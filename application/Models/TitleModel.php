<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\SimpleAction;

/**
 * Class TitleModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="title")
 * @Clips\Model({ "column","assetColumnRef", "playHistorie" })
 */
class TitleModel extends DBModel {

	public function getTitleByName($name){
		return $this->one('asset_name',$name);
	}

	public function getTitlesByColumn($column_id, $limit=0){
		$titles = $this->select('title.id,title.asset_name,poster.sourceurl')
				->from('title')
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->join('poster',array('poster.title_id'=>'title.id'))
				->where(array('asset_column_ref.column_id'=>$column_id,
						'poster.image_aspect_ratio'=>'306x429',
						new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null))))
				->limit(0, $limit)
				->result();
		foreach ($titles as $k=>$v) {
			$titles[$k]->record = $this->playhistorie->getPlayTimesByTitleID($v->id);
		}
		return $titles;
	}

	/**
	 * @Clips\Model({ "searchKey" })
	 */
	public function getTitlesByKey($key){
		$key = trim($key);
		$this->searchkey->recordHotKey($key);
		return $this->select('distinct title.id,title_application.area,title_application.summary_short,
								title_application.actors,title_application,title_application.director,package.program_type_name')
				->from('title')
				->join('title_application',array('title.application_id'=>'title_application.id'))
				->join('package',array('title.package_id'=>'package.id'))
				->where(new \Clips\Libraries\OrOperator(array(array('title.asset_name' => $key), array('title_application.director' => $key)
				, new \Pinet\EPG\Core\FindInSet('title_application.actors', $key))))
				->result();
	}

	public function getMovieInfoByID($titleID){
		$titles = $this->select('title.id,title.asset_name,title_application.actors,title_application.summary_short,title_application.director')
			->from('title')
			->join('title_application',array('title.application_id'=>'title_application.id'))
			->where(array('title.id' => $titleID))
			->result();
		if(count($titles))
			return $titles[0];
		return null;
	}

	public function getTitles($limit=10, $notIn=array()){
		$select = $this->select('title.id,title.asset_name')
			->from('title');
		$where = array(
			new \Clips\Libraries\NotOperator(array('title.asset_id' => null))
		);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.id', implode(',', $notIn));
		}
		$select->where($where);
		$titles = $select->limit(0,$limit)
			->result();
		if($titles)
			return $titles;
		return array();
	}

	public function getNewTitles($limit, $notIn=array()){
		$where = array('poster.image_aspect_ratio'=>'306x429');
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.id', implode(',', $notIn));
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

	public function getSameTypeMovies($titleID, $limit=10) {
		$ref = $this->assetcolumnref->getColumnByID($titleID);
		$titles = array();
		if(isset($ref->id)){
			$titles = $this->getTitlesByColumn($ref->column_id, $limit);
			$titleIDs = array_map(function($title){return $title->id;}, $titles);
			$count = count($titles);
			if($count != $limit){
				$titles = array_merge($titles, $this->getTitles($limit - $count, $titleIDs));
			}
		}else{
			$titles = $this->getTitles();
		}
		$titleIDs = array_map(function($title){return $title->id;}, $titles);
		$plays = $this->playhistorie->getMovieHistories($titleIDs);
		foreach($titles as $title){
			$titles['count'] = 0;
			if(isset($plays[$title->id]))
				$titles['count'] = $plays[$title->id];
		}
		return $titles;
	}

	public function getTitlesByItem($type,$area,$year){
		if(isset($type) && isset($area) && isset($year)) {
			$title = $this->select('distinct title.id,title.asset_name')
					->from('title')
					->join('title_application',array('title.application_id'=>'title_application.id'))
					->join('package',array('title.package_id'=>'package.id'))
					->where(array(new \Clips\Libraries\LikeOperator('title_application.area', '%'.$area.'%')
							,new \Clips\Libraries\LikeOperator('package.create_at', $year.'%')
							, new FindInSet('package.program_type_name', $type)))
					->result();
		}elseif(isset($type) && isset($area)){
			$title = $this->select('distinct title.id,title.asset_name')
					->from('title')
					->join('title_application',array('title.application_id'=>'title_application.id'))
					->join('package',array('title.package_id'=>'package.id'))
					->where(array(new \Clips\Libraries\LikeOperator('title_application.area', '%'.$area.'%')
					, new FindInSet('package.program_type_name', $type)))
					->result();
		}elseif(isset($type) && isset($year)){
			$title = $this->select('distinct title.id,title.asset_name')
					->from('title')
					->join('package',array('title.package_id'=>'package.id'))
					->where(array(new \Clips\Libraries\LikeOperator('package.create_at', $year.'%')
					, new FindInSet('package.program_type_name', $type)))
					->result();
		}elseif(isset($area) && isset($year)){
			$title = $this->select('distinct title.id,title.asset_name')
					->from('title')
					->join('title_application',array('title.application_id'=>'title_application.id'))
					->join('package',array('title.package_id'=>'package.id'))
					->where(array(new \Clips\Libraries\LikeOperator('package.create_at', $year.'%')
					, new \Clips\Libraries\LikeOperator('title_application.area', '%'.$area.'%')))
					->result();
		}elseif(isset($type)){
			$title = $this->select('distinct title.id,title.asset_name')
					->from('title')
					->join('package',array('title.package_id'=>'package.id'))
					->where(array(new FindInSet('package.program_type_name', $type)))
					->result();
		}elseif(isset($area)){
			$title = $this->select('distinct title.id,title.asset_name')
					->from('title')
					->join('title_application',array('title.application_id'=>'title_application.id'))
					->where(array(new \Clips\Libraries\LikeOperator('title_application.area', '%'.$area.'%')))
					->result();
		}elseif(isset($year)){
			$title = $this->select('distinct title.id,title.asset_name')
					->from('title')
					->join('package',array('title.package_id'=>'package.id'))
					->where(array(new \Clips\Libraries\LikeOperator('package.create_at', $year.'%')))
					->result();
		}

		

	}

	public function getNewTitlesByVolumnID($columnID, $notIn=array() ,$limit=10){
		$where = array('asset_column_ref.column_id'=>$columnID);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.id', implode(',', $notIn));
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

	public function getHomeNavigations($navs, $limit=10){
		$actions = array();
		foreach ($navs as $k=>$nav) {
			$action = new SimpleAction(array('content' => 'movie/index/'.$nav->id, 'label' => $nav->column_name, 'type' => 'server'));
			$records = $this->playhistorie->getRecordsByColumnID($nav->id);
			$count = count($records);
			if($count != $limit){
				$titleIDs = array_map(function($record){ return $record->id;}, $records);
				$records = array_merge($records, $this->getNewTitlesByVolumnID($nav->id, $titleIDs, $limit-$count));
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

}