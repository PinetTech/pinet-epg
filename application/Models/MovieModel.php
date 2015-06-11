<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Pinet\EPG\Core\SiftAction;

/**
 * Class MovieModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="movie", value={"title", "playHistorie"})
 */
class MovieModel extends DBModel {

	public function getMovieByName($name){
		return $this->one('asset_name',$name);
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
			'all'=>'全部','剧情'=>'剧情', '动作'=>'动作', '犯罪'=>'犯罪', '喜剧'=>'喜剧', '科幻'=>'科幻', '西部'=>'西部', '传记'=>'传记', '爱情'=>'爱情', '歌舞'=>'歌舞'
		, '惊悚'=>'惊悚', '冒险'=>'冒险', '悬疑'=>'悬疑', '奇幻'=>'奇幻', '历史'=>'历史', '恐怖'=>'恐怖', '战争'=>'战争', '运动'=>'运动', '音乐'=>'音乐', '家庭'=>'家庭'
		);
	}

	public function getAreas(){
		return array(
			'all'=>'全部','中国大陆'=>'中国大陆', '香港'=>'香港', '英国'=>'英国', '美国'=>'美国', '德国'=>'德国', '法国'=>'法国', '澳大利亚'=>'澳大利亚', '台湾'=>'台湾', '丹麦'=>'丹麦', '日本'=>'日本'
		, '新西兰'=>'新西兰', '意大利'=>'意大利', '加拿大'=>'加拿大', '巴西'=>'巴西', '秘鲁'=>'秘鲁', '韩国'=>'韩国', '西班牙'=>'西班牙', '瑞士'=>'瑞士', '尼泊尔'=>'尼泊尔'
		);
	}

	public function getYears(){
		$now = new \DateTime();
		$year = $now->format('Y');
		$years = array(
			'all'=>'全部',
			$year=>$year,
		);
		for($i=1 ; $i < 5; $i++){
			$years[$year - $i] = $year - $i;
		}
		$years['-'.end($years)+1] = '更早';
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

	//now instead of getPushRecords for banner
	public function getRecommendTitles(){
		$where = array('poster.image_aspect_ratio'=>(PosterModel::BIG_SIZE),
			new \Clips\Libraries\OrOperator(
				array(array('title_application.episode_id' => ''),
					array('title_application.episode_id' => 1)
				)
			));
		return $this->select('title.id,title.asset_name,title.create_at,poster.sourceurl')
			->from('title')
			->join('title_application',array('title_application.id'=>'title.application_id'))
			->join('recommend_titles',array('recommend_titles.title_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where($where)
			->limit(0, 9)
			->result();
	}

	public function sift($columnID=1){
		$types = $this->getProgramTypes();
		$areas = $this->getAreas();
		$years = $this->getYears();
		$type = new SiftAction(array('content' => '', 'label' => '按类型', 'type' => 'client'));
		$typeChildren = array();
		foreach ($types as $k=>$v) {
			$typeChildren[] = new SiftAction(array('content' => '/movie/sift/'.$columnID.'?type='.urlencode($k), 'label' => $v, 'type' => 'server'));
		}
		$type->children = $typeChildren;

		$area = new SiftAction(array('content' => '', 'label' => '按地区', 'type' => 'client'));
		$areaChildren = array();
		foreach ($areas as $k=>$v) {
			$areaChildren[] = new SiftAction(array('content' => '/movie/sift/'.$columnID.'?area='.urlencode($k), 'label' => $v, 'type' => 'server'));
		}
		$area->children = $areaChildren;

		$year = new SiftAction(array('content' => '', 'label' => '按年份', 'type' => 'client'));
		$yearChildren = array();
		foreach ($years as $k=>$v) {
			$yearChildren[] = new SiftAction(array('content' => '/movie/sift/'.$columnID.'?year='.urlencode($k), 'label' => $v, 'type' => 'server'));
		}
		$year->children = $yearChildren;
		return array($type,$area,$year);
	}
}