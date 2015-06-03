<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\SimpleAction;

/**
 * Class TitleModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="title")
 * @Clips\Model({ "column","assetColumnRef", "playHistorie", "searchKey","poster","package","titleApplication" })
 */
class TitleModel extends DBModel {

	public function getTitleByName($name){
		return $this->one('asset_name',$name);
	}

	public function getTitlesByColumn($column_id, $limit=0){
		$titles = $this->select('min(title.id) as id,title.asset_name,poster.sourceurl')
			->from('title')
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where(array('asset_column_ref.column_id'=>$column_id,
				'poster.image_aspect_ratio'=>'306x429',
				new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null))))
			->groupBy('title.package_id')
			->limit(0, $limit)
			->result();
		foreach ($titles as $k=>$v) {
			$titles[$k]->record = $this->playhistorie->getPlayTimesByTitleID($v->id);
		}
		return $titles;
	}

	/**
	 * @Clips\Model({ "searchKey" })
	 */
	public function getTitlesByHotKey($key, $columnID=1, $offset=0, $limit=10){
		$key = trim($key);
		$this->searchkey->recordHotKey($key);
		$where = array(
			new \Clips\Libraries\OrOperator(
				array(new \Clips\Libraries\LikeOperator('title.asset_name', '%'.$key.'%'),
					new \Clips\Libraries\LikeOperator('title_application.director', '%'.$key.'%'),
					new \Pinet\EPG\Core\FindInSet('title_application.actors', $key))
			),
			'poster.image_aspect_ratio'=>'306x429'
		);
		if($columnID){
			$where['asset_column_ref.column_id'] = $columnID;
		}
		return $this->select('min(title.id) as id,asset_column_ref.column_id,title.asset_name,title_application.area,title_application.summary_short,
								title_application.actors,title_application.director,package.program_type_name,poster.sourceurl')
			->from('title')
			->join('title_application',array('title.application_id'=>'title_application.id'))
			->join('package',array('title.package_id'=>'package.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->where($where)
			->groupBy('title.package_id')
			->limit($offset, $limit)
				->result();
	}

	public function getMovieInfoByID($titleID){
		$titles = $this->select('title.id,title.asset_name,title_application.actors,title_application.summary_short,title_application.director')
			->from('title')
			->join('title_application',array('title.application_id'=>'title_application.id'))
			->where(array('title.id' => $titleID))
			->result();
		if(count($titles))
			return $titles[0];
		return null;
	}

	public function getTitles($limit=10, $notIn=array()){
		$select = $this->select('title.id,title.asset_name,poster.sourceurl')
				->from('title')
				->join('poster',array('poster.title_id'=>'title.id'));
		$where = array(
			new \Clips\Libraries\NotOperator(array('title.asset_id' => null)),
				'poster.image_aspect_ratio'=>'306x429'
		);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.id', $notIn);
		}
		$select->where($where);
		$titles = $select->limit(0,$limit)
			->result();
		if($titles)
			return $titles;
		return array();
	}

	public function getNewTitles($limit, $notIn=array()){
		$where = array('poster.original'=>'1');
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.package_id', $notIn);
		}
		$titles = $this->select('title.id,title.asset_name,title.create_at,poster.sourceurl')
				->from('title')
				->join('poster',array('poster.title_id'=>'title.id'))
				->where($where)
				->orderBy('title.create_at desc')
				->limit(0,$limit)
				->result();
		return $titles;
	}

	public function getSameTypeMovies($titleID, $limit=10) {
		$ref = $this->assetcolumnref->getColumnByID($titleID);
		$titles = array();
		if(isset($ref->id)){
			$titles = $this->getTitlesByColumn($ref->column_id, $limit);
			$titleIDs = array_map(function($title){return $title->id;}, $titles);
			$count = count($titles);
			if($count != $limit){
				$titles = array_merge($titles, $this->getTitles($limit - $count, $titleIDs));
			}
		}else{
			$titles = $this->getTitles();
		}
		$titleIDs = array_map(function($title){return $title->id;}, $titles);
		$plays = $this->playhistorie->getMovieHistories($titleIDs);
		foreach($titles as $key=>$title){
			$titles[$key]->count = 0;
			if(isset($plays[$title->id]))
				$titles[$key]->count = $plays[$title->id];
		}
		return $titles;
	}

	function array_unique_fb($array2D) {     //二维数组去重
		foreach ($array2D as $k=>$v)
		{
			$v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
			$temp[$k] = $v;
		}
		$temp = array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
		foreach ($temp as $k => $v)
		{
			$array=explode(",",$v); //再将拆开的数组重新组装
			$temp2[$k]["id"] =$array[0];
			$temp2[$k]["asset_name"] =$array[1];
		}
		return $temp2;
	}

	public function siftTitles($session){
		$type = $session['type'];
		$area = $session['area'];
		$year = $session['year'];

		if(isset($type)) {
			foreach ($type as $v) {
				$typeTitles[] = $this->select('title.id,title.asset_name')
						->from('title')
						->join('package',array('title.package_id'=>'package.id'))
						->where(array( new \Pinet\EPG\Core\FindInSet('package.program_type_name', $v)))
						->result();
			}
			foreach ($typeTitles as $vs) {
				foreach ($vs as $v) {
					$typeAll[] = (Array)$v;
				}
			}
		}

		if(isset($area)) {
			foreach ($area as $v) {
				$areaTitles[] = $this->select('title.id,title.asset_name')
						->from('title')
						->join('title_application',array('title.application_id'=>'title_application.id'))
						->where(array(new \Clips\Libraries\LikeOperator('title_application.area', '%'.$v.'%')))
						->result();
			}
			foreach ($areaTitles as $vs) {
				foreach ($vs as $v) {
					$typeAll[] = (Array)$v;
				}
			}
		}

		if(isset($year)) {
			foreach ($year as $v) {
				$yearTitles[] = $this->select('title.id,title.asset_name')
						->from('title')
						->where(array(new \Clips\Libraries\LikeOperator('title.create_at', $v.'%')))
						->result();
			}
			foreach ($yearTitles as $vs) {
				foreach ($vs as $v) {
					$typeAll[] = (Array)$v;
				}
			}
		}

		$typeAll = $this->array_unique_fb($typeAll);

		foreach ($typeAll as $k=>$v) {
			$typeAll[$k]['count'] = $this->playhistorie->getPlayTimesByTitleID($v['id']);
			$poster = $this->poster->one(array(
				'title_id' => $v['id'],
				'image_aspect_ratio' => '306x429'
			));
			$typeAll[$k]['sourceurl'] = $poster->sourceurl;
		}
		var_dump($typeAll);die;
		return $typeAll;

	}

	public function siftRecords($records,$session){
		foreach ($records as $k=>$v) {
			$title = $this->one('id',$v->id);
			$records[$k]->type = $this->package->one('id',$title->package_id)->program_type_name;
			$records[$k]->area = $this->titleapplication->one('id',$title->application_id)->area;
			$records[$k]->year = $title->create_at;
		}
		if(isset($session['type'])) {
			foreach ($records as $k=>$v) {
				$types = explode(',',$v->type);
				foreach ($types as $k=>$v) {
					$types[$k] = trim($v);
				}

				if($session['type'] == 'all') {

				}elseif(!in_array($session['type'],$types)) {
					unset($records[$k]);
				}
			}
		}
		if(isset($session['area'])) {
			foreach ($records as $k=>$v) {
				if($session['area'] == 'all') {

				}elseif(strpos($v->area, $session['area'])===false) {
					unset($records[$k]);
				}
			}
		}
		if(isset($session['year'])) {
			foreach ($records as $k=>$v) {
				$year = substr($v->year,0,4);
				if($session['year'] == 'all') {

				}elseif(substr($session['year'],0,1) == '-'){
					$year_sift = substr($session['year'],1,4);
					if($year>$year_sift) {
						unset($records[$k]);
					}
				}elseif(strpos($v->year, $session['year'])===false) {
					unset($records[$k]);
				}
			}
		}
		return $records;
	}

	public function getNewTitlesByColumnID($columnID, $notIn=array() ,$limit=10){
		$where = array('asset_column_ref.column_id'=>$columnID);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.package_id', $notIn);
		}
		$titles = $this->select('title.id,title.asset_name,title.create_at')
				->from('title')
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->where($where)
				->orderBy('title.create_at desc')
				->limit(0,$limit)
				->result();
		return $titles;
	}

	public function getHomeNavigations($navs, $limit=10){
		$actions = array();
		foreach ($navs as $k=>$nav) {
			$action = new SimpleAction(array('content' => 'movie/index/'.$nav->id, 'label' => $nav->column_name, 'type' => 'server'));
			$records = $this->playhistorie->getRecordsByColumnID($nav->id);
			$count = count($records);
			if($count != $limit){
				$packageIDs = array_map(function($record){ return $record->id;}, $records);
				$records = array_merge($records, $this->getNewTitlesByColumnID($nav->id, $packageIDs, $limit-$count));
			}
			$children = array();
			foreach ($records as $record) {
				$children[] = new SimpleAction(array('content' => 'movie/play/' . $record->id, 'label' => $record->asset_name, 'type' => 'server'));
			}

			$action->children = $children;
			$actions[] = $action;
		}
		return $actions;
	}

	public function getTypeByColumnID($columnID){
		$titleID = $this->assetcolumnref->one('column_id',$columnID)->title_asset_id;
		if(!$titleID) {
			return 'Movie';
		}else{
			$show_type = $this->one('id',$titleID)->show_type;
			return $show_type;
		}
	}

	public function getHotsByColumnID($columnID,$offset=0,$limit=10){
		return $this->select('min(title.id) as id,title.asset_name,poster.sourceurl,count(1) as count')
				->from('title')
				->join('play_histories',array('play_histories.title_id'=>'title.id'))
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->join('poster',array('poster.title_id'=>'title.id'))
				->where(array('asset_column_ref.column_id'=>$columnID,
						new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)),
						'poster.image_aspect_ratio'=>'306x429'
				))
				->groupBy('play_histories.package_id')
				->orderBy("count desc")
				->limit($offset, $limit)
				->result();
	}

	public function getNewsByColumnID($columnID,$offset=0,$limit=10){
		$news = $this->select('min(title.id) as id,title.asset_name,poster.sourceurl')
			->from('title')
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where(array('asset_column_ref.column_id'=>$columnID,
				new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)),
				'poster.image_aspect_ratio'=>'306x429'
			))
			->groupBy('title.package_id')
			->orderBy('title.create_at desc')
			->limit($offset, $limit)
			->result();
		foreach ($news as $k=>$v) {
			$news[$k]->count = $this->playhistorie->getPlayTimesByTitleID($v->id);
		}
		return $news;
	}
}