<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class ColumnModel
 * @package Pinet\EPG\Models
 * @Clips\Model({"title"})
 */
class ColumnModel extends DBModel {

	public function getAllColumns(){
		return $this->orderBy("rank")->get();
	}

	public function getColumnByName($name){
		return $this->one('column_name',$name);
	}

	public function getColumns($navs){
		$columns = array();
		foreach ($navs as $k=>$nav) {
			$videos = array();
			$movies = $this->title->getTitlesByColumn($nav->id,6);
			foreach ($movies as $movie) {
				$videos[]=(object)array('id'=>$movie->id, 'title'=>$movie->asset_name, 'count'=>$movie->record, 'imageSrc'=>$movie->sourceurl);
			}
			$columns[$k]['videos'] = $videos;
			$columns[$k]['column_id'] = $nav->id;
			$columns[$k]['column_name'] = $nav->column_name;
			$columns[$k]['url'] = 'movie/index/'.$nav->id;
		}
		return $columns;
	}

}