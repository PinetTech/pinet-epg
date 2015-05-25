<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;
use Clips\Libraries\WhereOperator;


class FindInSet extends WhereOperator {
	public function __construct($left, $right) {
		parent::__construct(array());
		$this->left = $left;
		$this->right = $right;
	}

	public function getArgs() {
		return $this->right;
	}

	public function toString() {
		return 'find_in_set(?, '.$this->left.')';
	}
}

/**
 * Class TitleModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="Title")
 * @Clips\Model({ "column","assetcolumnref" })
 */
class TitleModel extends DBModel {

	public function getTitleByName($name){
		return $this->one('asset_name',$name);
	}

	public function getTitlesByColumn($column_id,$offset=0){
		$titles = $this->select('title.id,title.asset_name')
				->from('title')
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->where(array('asset_column_ref.column_id'=>$column_id))
				->limit(0,$offset)
				->result();
		return $titles;
	}

	/**
	 * @Clips\Model({ "searchKey" })
	 */
	public function getTitlesByKey($key){
		$key = trim($key);
		$this->searchkey->recordHotKey($key);
		return $this->select('distinct title.id,title_application.area,title_application.summary_short,
								title_application.actors,title_application,title_application.director,package.program_type_name')
				->from('title')
				->join('title_application',array('title.application_id'=>'title_application.id'))
				->join('package',array('title.package_id'=>'package.id'))
				->where(new \Clips\Libraries\OrOperator(array(array('title.asset_name' => $key), array('title_application.director' => $key)
				, new FindInSet('title_application.actors', $key))))
				->result();
	}


}