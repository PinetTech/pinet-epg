<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\SimpleAction;
use Pinet\EPG\Core\ColumnAction;

/**
 * Class VideoModel
 * @Clips\Model({"title","playhistorie"})
 * @Clips\Library("sling")
 */
class VideoModel extends DBModel {

	public function getHomeNavigations($navs, $limit=10){
		$actions = array();
		foreach ($navs as $k=>$nav) {
//			var_dump($nav);die;
			$action = new ColumnAction(array('content' => 'movie/index/'.$nav->column_id, 'label' => $nav->column_name, 'type' => 'server'));
			$records = $this->playhistorie->getRecordsByColumnID($nav->column_id);
			$count = count($records);
			if($count != $limit){
				$packageIDs = array_map(function($record){ return $record->id;}, $records);
				$records = array_merge($records, $this->getNewTitlesByColumnID($nav->column_id, $packageIDs, $limit-$count));
			}
			$children = array();
			foreach ($records as $record) {
				$children[] = new SimpleAction(array('content' => 'movie/play/' . $record->id, 'label' => $record->asset_name, 'type' => 'server'));
			}

			$action->children = $children;
			$actions[] = $action;
		}
		return $actions;
	}

	public function getRecommendTitles(){

		$titles = array();
		$data = $this->sling->data('/epg/columns.2');
		foreach($data as $k => $v) {
			if(is_object($v) && $v->type == 'column') {
				foreach ($v as $k2=>$v2) {
					if(is_object($v2) && $v2->type == 'epg/link') {
						$title = $this->sling->data($v2->reference);
						$titles[] = $title;
					}
				}
			}
		}
		$titles = array_slice($titles,0,9);
		return $titles;
	}

	public function getHotsByColumnID($columnID,$offset=0,$limit=10){
		return $this->select('min(title.id) as id,title.asset_name,poster.sourceurl,count(1) as count')
			->from('title')
			->join('play_histories',array('play_histories.title_id'=>'title.id'))
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where(array('asset_column_ref.column_id'=>$columnID,
				new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)),
				'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE)
			))
			->groupBy('play_histories.package_id')
			->orderBy("count desc")
			->limit($offset, $limit)
			->result();
	}

	public function getNewsByColumnID($columnID,$offset=0,$limit=10){
		$news = $this->select('min(title.id) as id,title.asset_name,poster.sourceurl,title.package_id')
			->from('title')
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where(array('asset_column_ref.column_id'=>$columnID,
				new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)),
				'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE)
			))
			->groupBy('title.package_id')
			->orderBy('title.create_at desc')
			->limit($offset, $limit)
			->result();
		foreach ($news as $k=>$v) {
			$news[$k]->count = $this->playhistorie->getPlayTimesByPackageID($v->package_id);
		}
		return $news;
	}

	public function getSameTypeMovies($videoID, $limit=10) {
		$ref = $this->assetcolumnref->getColumnByID($videoID);
		$titles = array();
		if(isset($ref->id)){
			$titles = $this->getTitlesByColumn($ref->column_id, $limit);
			$videoIDs = array_map(function($title){return $title->id;}, $titles);
			$count = count($titles);
			if($count != $limit){
				$titles = array_merge($titles, $this->getTitles($limit - $count, $videoIDs));
			}
		}else{
			$titles = $this->getTitles();
		}
		$videoIDs = array_map(function($title){return $title->id;}, $titles);
		$plays = $this->playhistorie->getMovieHistories($videoIDs);
		foreach($titles as $key=>$title){
			$titles[$key]->count = 0;
			if(isset($plays[$title->id]))
				$titles[$key]->count = $plays[$title->id];
		}
		return $titles;
	}


	public function getSeries($packageID){
		$series = $this->get(array('package_id'=>$packageID));

		foreach ($series as $k=>$v) {
			$app = $this->titleapplication->getEpisodeNameByID($v->application_id);
			$series[$k]->episode_name = $app->episode_name;
		}

		return $series;
	}

	public function getMovieInfoByID($videoID){
		$title = $this->sling->data('/media/video/'.$videoID);
		return $title;

	}

	public function getNewTitlesByColumnID($columnID, $notIn=array() ,$limit=10){
		$where = array('asset_column_ref.column_id'=>$columnID);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.package_id', $notIn);
		}
		$titles = $this->select('title.id,title.asset_name,title.create_at')
			->from('title')
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->where($where)
			->orderBy('title.create_at desc')
			->limit(0,$limit)
			->result();
		return $titles;
	}

	public function getTitlesByColumn($column_id, $limit=0){

		$data = $this->sling->data('/epg/columns.2');
		foreach($data as $k => $v) {
			if(is_object($v) && $v->type == 'column' && $v->column_id == $column_id) {
				$column = $v;
			}
		}
		$titles = array();
		foreach ($column as $k=>$v) {
			if(is_object($v) && $v->type == 'epg/link') {
				$title = $this->sling->data($v->reference);
				$titles[] = $title;
			}
		}
		$titles = array_slice($titles,0,$limit);

		foreach ($titles as $k=>$v) {
			$titles[$k]->record = $this->playhistorie->getPlayTimesByPackageID($v->package_id);
		}
		return $titles;
	}

	public function getNewTitles($limit, $notIn=array()){
		$where = array('poster.image_aspect_ratio'=>(PosterModel::BIG_SIZE));
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.package_id', $notIn);
		}
		$titles = $this->select('title.id,title.asset_name,title.create_at,poster.sourceurl')
			->from('title')
			->join('poster',array('poster.title_id'=>'title.id'))
			->where($where)
			->orderBy('title.create_at desc')
			->limit(0,$limit)
			->result();
		return $titles;
	}
}
