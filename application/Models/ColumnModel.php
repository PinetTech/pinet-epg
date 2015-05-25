<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class ColumnModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="Columns")
 */
class ColumnModel extends DBModel {

	public function getColumnByName($name){
		return $this->one('column_name',$name);
	}

}