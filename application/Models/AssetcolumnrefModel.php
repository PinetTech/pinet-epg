<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class AssetcolumnrefModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="asset_column_ref")
 */
class AssetcolumnrefModel extends DBModel {

	public function getByColumnID($id){
		return $this->get('column_id',$id);
	}

}