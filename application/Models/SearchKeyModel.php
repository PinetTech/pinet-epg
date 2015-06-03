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
		if($key){
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
	}


}