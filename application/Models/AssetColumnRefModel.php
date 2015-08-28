<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Libraries\NotOperator;
use Clips\Object;

/**
 * Class AssetcolumnrefModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="asset_column_ref")
 * @Clips\Library("sling")
 */
class AssetColumnRefModel extends DBModel {

	public function getByColumnID($id){
//		return $this->get('column_id',$id);

		$data = $this->sling->data('/epg/columns.2');
		foreach($data as $k => $v) {
			if(is_object($v) && $v->type == 'column' && $v->column_id == $id) {
				$column = $v;
			}
		}
//		var_dump($column_id);die;
		$titles = array();
		foreach ($column as $k=>$v) {
			if(is_object($v) && $v->type == 'epg/link') {
				$title = $this->sling->data($v->reference);
				$titles[] = $title;
			}
		}
		return $titles;
	}

	public function getColumnByID($videoID){
//		return $this->one('title_asset_id', $videoID);

		$title = $this->sling->data('/media/video/'.$videoID);
		return $title;
	}

}