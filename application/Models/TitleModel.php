<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Class TitleModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="Title")
 * @Clips\Model({ "column","assetColumnRef", "playHistorie" })
 */
class TitleModel extends DBModel {

	public function getTitleByName($name){
		return $this->one('asset_name',$name);
	}

	public function getTitlesByColumn($column_id,$limit=0){
		$titles = $this->select('title.id,title.asset_name')
				->from('title')
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->where(array('asset_column_ref.column_id'=>$column_id))
				->limit(0,$limit)
				->result();
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
		return $this->select('title.asset_name,title_application.actors,title_application.summary_long,title_application.director')
			->from('title')
			->join('title_application',array('title.application_id'=>'title_application.id'))
			->where('title.id', $titleID)
			->result();
	}

	public function getTitles($limit=10, $notIn=array()){
		$select = $this->select('title.id,title.asset_name')
			->from('title');
		if($notIn){
			$select->where(new \Pinet\EPG\Core\NotIn('title.id', implode(',', $notIn)));
		}
		return $select->limit(0,$limit)
			->result();
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
		foreach($titles as $key=>$title){
			$titles['count'] = 0;
			if(isset($plays[$title->id]))
				$titles['count'] = $plays[$title->id];
		}
		return $titles;
	}

}