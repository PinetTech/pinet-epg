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

	public function getTitlesByColumn($column_id,$offset=0){
		$result = $this->assetcolumnref->getByColumnID($column_id);
		$titles = $this->get(array('id'=>$result->title_asset_id),$offset);
		return $titles;
	}

}