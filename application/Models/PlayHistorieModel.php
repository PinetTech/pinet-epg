<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Class ColumnModel
 * @package Pinet\EPG\Models
 * @Clips\Model({"title"})
 */
class PlayHistorieModel extends DBModel {

	public function saveHistory($history){
		if($this->checkFlushData($history['title_id'])){
			return $this->insert($history);
		}
		return true;
	}

	public function checkFlushData($titleID){
		$history = $this->orderBy('create_date desc')->one('title_id', $titleID);
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
			->where(new \Pinet\EPG\Core\In('title_id', implode(',', $titleIDs)))
			->groupBy('title_id')
			->result();
		foreach($plays as $play){
			$result[$play->title_id] = $play->count;
		}
	}

	public function getHotRecord($limit=10){
		$records = $this->select('title_id , count(title_id) as count')->from('play_histories')
			->groupBy('title_id')->orderBy('count(title_id) desc')
			->limit(0, $limit)->result();
		foreach ($records as $k=>$v) {
			$title = $this->title->one('id',$v->title_id);
			$records[$k]->asset_name = $title->asset_name;
		}
		return $records;
	}

	public function getPlayTimesByTitleID($titleID){
		return $this->select('count(1) as count')->from('play_histories')->where(array('title_id'=>$titleID))->result()[0]->count;
	}
}