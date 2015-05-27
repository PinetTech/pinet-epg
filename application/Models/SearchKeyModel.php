<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Class SearchKeyModel
 * @package Pinet\EPG\Models
 */
class SearchKeyModel extends DBModel {

	public function getKeys($offset){
		return $this->orderBy('times desc')->get(0, $offset);
	}

	public function recordHotKey($key){
		$hotKey = $this->one('keyword',$key);
		if(isset($hotKey->id)) {
			$hotKey->times += 1;
			$this->update($hotKey);
		}else{
			$this->insert(array(
					'keyword' => $key,
					'times' => 1
			));
		}

	}

//	public function getRecordByColumnID($columnID){
//		return $this->select('title.id,title.asset_name')
//				->from('title')
//				->join('play_histories',array('play_histories.title_id'=>'title.id'))
//				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
//				->where(array())
//				->limit(0, $limit)
//				->result();
//	}

}