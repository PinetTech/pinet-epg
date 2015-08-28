<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class PackageModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="package")
 * @Clips\Model({ "column","assetColumnRef" })
 * @Clips\Library("sling")
 */
class PackageModel extends DBModel {

/*	public function getPackagesByType($type_name){
		$all = $this->get();
		$result = array();
		foreach ($all as $item) {
			$arr = explode(',',$item->program_type_name);
			if(in_array($type_name,$arr)) {
				$result[] = $item;
			}
		}

		return $result;
	}*/

}