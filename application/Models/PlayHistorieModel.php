<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Class PlayHistorieModel
 * @package Pinet\EPG\Models
 * @Clips\Model({ "title" })
 */
class PlayHistorieModel extends DBModel {

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
		return $this->select('count(title_id) as count')->from('play_histories')->from('play_histories')->where('title_id', $titleID)->result()[0]->count;
	}

}