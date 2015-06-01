<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\SimpleAction;

/**
 * Class MovieModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="movie", value={"title", "playHistorie"})
 */
class MovieModel extends DBModel {

	public function getMovieByName($name){
		return $this->one('asset_name',$name);
	}

	public function getMoviesByColumn(){

	}

	public function getPlayUrlByTitleID($titleID, $serverUrl){
		$movie = $this->one('title_id', $titleID);
		if(isset($movie->id)){
			return str_replace('localhost', $serverUrl, $movie->play_url);
		}
		return '';
	}

	public function getMovieByTitleID($titleID){
		return $this->one('title_id', $titleID);
	}


	public function getProgramTypes(){
		return array(
			'全部','剧情', '动作', '犯罪', '喜剧', '科幻', '西部', '传记', '爱情', '歌舞'
		, '惊悚', '冒险', '悬疑', '奇幻', '历史', '恐怖', '战争', '运动', '音乐', '家庭'
		);
	}

	public function getAreas(){
		return array(
				'全部','中国大陆', '香港', '英国', '美国', '德国', '法国', '澳大利亚', '台湾', '丹麦', '日本'
		, '新西兰', '意大利', '加拿大', '巴西', '秘鲁', '韩国', '西班牙', '瑞士', '尼泊尔'
		);
	}

	public function getYears(){
		$now = new \DateTime();
		$year = $now->format('Y');
		$years = array($year);
		for($i=1 ; $i < 5; $i++){
			$years[] = $year - $i;
		}
		$years[0] = '全部';
		$years[] = '更早';
		return $years;
	}

	public function getPushRecords($columnID, $limit=9){
		$records = $this->playhistorie->getHotRecord($columnID , $limit);
		$count = count($records);
		if($count != $limit){
			$packageIDs = array_map(function($record){ return $record->package_id;}, $records);
			$record = array_merge($records, $this->title->getNewTitles($limit-$count, $packageIDs));
		}
		return $record;
	}

	public function sift(){
		$types = $this->getProgramTypes();
		$areas = $this->getAreas();
		$years = $this->getYears();
		$type = new SimpleAction(array('content' => '/nav', 'label' => '按类型', 'type' => 'server'));
		$typeChildren = array();
		foreach ($types as $v) {
			$typeChildren[] = new SimpleAction(array('content' => '/nav/'.$v, 'label' => $v, 'type' => 'server'));
		}
		$type->children = $typeChildren;

		$area = new SimpleAction(array('content' => '/nav', 'label' => '按地区', 'type' => 'server'));
		$areaChildren = array();
		foreach ($areas as $v) {
			$areaChildren[] = new SimpleAction(array('content' => '/nav/'.$v, 'label' => $v, 'type' => 'server'));
		}
		$area->children = $areaChildren;

		$year = new SimpleAction(array('content' => '/nav', 'label' => '按年份', 'type' => 'server'));
		$yearChildren = array();
		foreach ($years as $v) {
			$yearChildren[] = new SimpleAction(array('content' => '/nav/'.$v, 'label' => $v, 'type' => 'server'));
		}
		$year->children = $yearChildren;
		return array($type,$area,$year);
	}
}