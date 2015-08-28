<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Class ColumnModel
 * @package Pinet\EPG\Models
 * @Clips\Model({"title"})
 * @Clips\Library("sling")
 */
class PlayHistorieModel extends DBModel {

	public function saveHistory($history){
		if($this->checkFlushData($history['mac'], $history['video_id'])){
			$title = $this->title->one('id',$history['video_id']);
			if($title){
				$history['title_asset_id'] = $title->asset_id;
				$history['package_id'] = $title->package_id;
				return $this->insert($history);
			}
		}
		return true;
	}

	public function checkFlushData($mac, $titleID){
		$history = $this->orderBy('create_date desc')->one(array(
			'mac' => $mac,
			'title_id' => $titleID
		));
		if(isset($history->id)){
			$now = new \DateTime();
			$lastTime = new \DateTime($history->create_date);
			if($now->diff($lastTime)->i < 5)
				return false;
		}
		return true;
	}

	public function getMovieHistories($titleIDs){
		$result = array();
		$plays = $this->select('title_id, count(title_id) as count')->from('play_histories')
			->where(new \Pinet\EPG\Core\In('title_id', $titleIDs))
			->groupBy('title_id')
			->result();
		foreach($plays as $play){
			$result[$play->title_id] = $play->count;
		}
	}

	public function getHotRecord($columnID , $limit=9){
		$where = array('poster.image_aspect_ratio'=>(PosterModel::BIG_SIZE),
			new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)));
		if($columnID){
			$where['asset_column_ref.column_id'] = $columnID;
		}
		return $this->select('min(title.id) as id,play_histories.package_id,title.asset_name,poster.sourceurl,count(1) as count')
				->from('title')
				->join('play_histories',array('play_histories.title_id'=>'title.id'))
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->join('poster',array('poster.title_id'=>'title.id'))
				->where($where)
				->groupBy('play_histories.package_id')
				->orderBy('count desc')
				->limit(0, $limit)
				->result();
	}

	public function getPlayTimesByPackageID($packageID){
		return $this->select('count(1) as count')->from('play_histories')->where(array('package_id'=>$packageID))->result()[0]->count;
	}

	public function getRecordsByColumnID($columnID, $limit=10){
		return $this->select('min(title.id) as id,play_histories.package_id,title.asset_name,count(1)')
				->from('title')
				->join('play_histories',array('play_histories.title_id'=>'title.id'))
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->where(array('asset_column_ref.column_id'=>$columnID,new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null))))
				->groupBy('play_histories.package_id')
				->limit(0, $limit)
				->result();
	}
}