<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class MovieModel
 * @package Pinet\EPG\Models
 * @Clips\Model({table="movie", "title", "playHistorie"})
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
			'剧情', '动作', '犯罪', '喜剧', '科幻', '西部', '传记', '爱情', '歌舞'
		, '惊悚', '冒险', '悬疑', '奇幻', '历史', '恐怖', '战争', '运动', '音乐', '家庭'
		);
	}

	public function getAreas(){
		return array(
			'中国大陆', '香港', '英国', '美国', '德国', '法国', '澳大利亚', '台湾', '丹麦', '日本'
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
		return $years;
	}

	public function getPushRecords($limit=9){
		$records = $this->playhistorie->getHotRecord($limit);
		$count = count($records);
		if($count != $limit){
			$titleIDs = array_map(function($record){ return $record->id;}, $records);
			$record = array_merge($records, $this->title->getNewTitles($limit-$count, $titleIDs));
		}
		return $record;
	}
}