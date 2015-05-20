<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class TitleApplicationModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="title_application")
 *@Clips\Model({ "column","assetcolumnref" })
 */
class TitleApplicationModel extends DBModel {

	public function getTitleappsByArea($area){
		$all = $this->get('area',$area);

		return $all;
	}

	public function getTitleappsByYear($year){
		$all = $this->get();
		$result = array();
		foreach ($all as $item) {
			$arr = explode('-',$item->year);
			if($year == $arr[0]) {
				$result[] = $item;
			}
		}

		return $result;
	}

}