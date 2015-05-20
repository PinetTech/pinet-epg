<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class TitleModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="Title")
 *@Clips\Model({ "column","assetcolumnref" })
 */
class TitleModel extends DBModel {

	public function getTitleByName($name){
		return $this->one('asset_name',$name);
	}

	public function getTitlesByColumn($column_name){
		$column = $this->column->getColumnByName($column_name);
		$result = $this->assetcolumnref->getByColumnID($column->id);
		$titles = $this->get('asset_id',$result->title_asset_id);
		return $titles;
	}

}