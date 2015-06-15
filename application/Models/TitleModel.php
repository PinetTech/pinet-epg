<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\SimpleAction;
use Pinet\EPG\Core\ColumnAction;

/**
 * Class TitleModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="title")
 * @Clips\Model({ "column","assetColumnRef", "playHistorie", "searchKey","poster","package","titleApplication" })
 */
class TitleModel extends DBModel {

	public function getTitlesByColumn($column_id, $limit){
		$titles = $this->select('title.id,title.asset_name,poster.sourceurl,title.package_id')
			->from('title')
			->join('title_application',array('title_application.id'=>'title.application_id'))
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where(array('asset_column_ref.column_id'=>$column_id,
				'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE),
				new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)),
					new \Clips\Libraries\OrOperator(
						array(array('title_application.episode_id' => ''),
							array('title_application.episode_id' => 1)
						)
					)
				)
			)
			->groupBy('title.package_id')
			->limit(0, $limit)
			->result();
		foreach ($titles as $k=>$v) {
			$titles[$k]->record = $this->playhistorie->getPlayTimesByPackageID($v->package_id);
		}
		return $titles;
	}

	/**
	 * @Clips\Model({ "searchKey" })
	 */
	public function getTitlesByHotKey($key, $columnID, $offset=0, $limit=20){
		$key = trim($key);
		$this->searchkey->recordHotKey($key);
		$where['poster.image_aspect_ratio'] = PosterModel::SMALL_SIZE;
		if($key){
			$where[] = new \Clips\Libraries\OrOperator(
					array(new \Clips\Libraries\LikeOperator('title.asset_name', '%'.$key.'%'),
						new \Clips\Libraries\LikeOperator('title_application.director', '%'.$key.'%'),
						new \Pinet\EPG\Core\FindInSet('title_application.actors', $key))
				);
		}
		$where[] = new \Clips\Libraries\OrOperator(
						array(array('title_application.episode_id' => ''),
							array('title_application.episode_id' => 1)
						)
					);
		if($columnID){
			$where['asset_column_ref.column_id'] = $columnID;
		}
		return $this->select('title.id,asset_column_ref.column_id,title.asset_name,title_application.area,title_application.summary_short,
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

	public function getColumnMovieCount($key, $columnID){
		$key = trim($key);
		$where = array();
		if($key){
			$where[] = new \Clips\Libraries\OrOperator(
				array(new \Clips\Libraries\LikeOperator('title.asset_name', '%'.$key.'%'),
					new \Clips\Libraries\LikeOperator('title_application.director', '%'.$key.'%'),
					new \Pinet\EPG\Core\FindInSet('title_application.actors', $key))
			);
		}
		if($columnID){
			$where['asset_column_ref.column_id'] = $columnID;
		}
		return $this->select('count(title.id) as count,columns.column_name,asset_column_ref.column_id')
			->from('title')
			->join('title_application',array('title.application_id'=>'title_application.id'))
			->join('columns',array('asset_column_ref.column_id'=>'columns.id'))
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->where($where)
			->groupBy('asset_column_ref.column_id')
			->result();
	}

	public function getMovieInfoByID($titleID){
		$titles = $this->select('title.id,title.asset_name,title_application.actors,title_application.summary_short,title_application.director,title.show_type,title.package_id')
			->from('title')
			->join('title_application',array('title.application_id'=>'title_application.id'))
			->where(array('title.id' => $titleID))
			->result();
		if(count($titles))
			return $titles[0];
		return null;
	}

	public function getTitles($limit=10, $notIn=array()){
		$select = $this->select('title.id,title.package_id,title.asset_name,poster.sourceurl')
				->from('title')
				->join('poster',array('poster.title_id'=>'title.id'));
		$where = array(
			new \Clips\Libraries\NotOperator(array('title.asset_id' => null)),
				'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE)
		);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.package_id', $notIn);
		}
		$select->where($where);
		$titles = $select->limit(0,$limit)
			->result();
		if($titles)
			return $titles;
		return array();
	}

	public function getNewTitles($limit, $notIn=array()){
		$where = array('poster.image_aspect_ratio'=>(PosterModel::BIG_SIZE));
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

	public function getSameTypeMovies($titleID, $limit=7) {
		$ref = $this->assetcolumnref->getColumnByID($titleID);
		$titles = array();
		if(isset($ref->id)){
			$titles = $this->getTitlesByColumn($ref->column_id, $limit);
			$packageIDs = array();
			foreach($titles as $key=>$title){
				$packageIDs[] = $title->package_id;
				if($title->id == $titleID){
					unset($titles[$key]);
				}
			}
			$count = count($titles);
			if($count != $limit){
				$titles = array_merge($titles, $this->getTitles($limit - $count, $packageIDs));
			}
		}else{
			$titles = $this->getTitles();
		}
		$packageIDs = array_map(function($title){return $title->package_id;}, $titles);
		$plays = $this->playhistorie->getMovieHistories($packageIDs);
		foreach($titles as $key=>$title){
			$titles[$key]->record = 0;
			if(isset($plays[$title->package_id]))
				$titles[$key]->record = $plays[$title->package_id];
		}
		return $titles;
	}

	public function getSameColumnMovies($columnID, $limit=7) {
		$titles = array();
		if($columnID){
			$titles = $this->getTitlesByColumn($columnID, $limit);
			$packageIDs = array_map(function($title){return $title->package_id;}, $titles);
			$count = count($titles);
			if($count != $limit){
				$titles = array_merge($titles, $this->getTitles($limit - $count, $packageIDs));
			}
		}else{
			$titles = $this->getTitles();
		}
		$packageIDs = array_map(function($title){return $title->package_id;}, $titles);
		$plays = $this->playhistorie->getMovieHistories($packageIDs);
		foreach($titles as $key=>$title){
			$titles[$key]->record = 0;
			if(isset($plays[$title->package_id]))
				$titles[$key]->record = $plays[$title->package_id];
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
			$typeAll[$k]['count'] = $this->playhistorie->getPlayTimesByPackageID($v['package_id']);
			$poster = $this->poster->one(array(
				'title_id' => $v['id'],
				'image_aspect_ratio' => (PosterModel::SMALL_SIZE)
			));
			$typeAll[$k]['sourceurl'] = $poster->sourceurl;
		}
		return $typeAll;

	}

	public function siftRecords($session,$columnID,$offset=0,$limit=20){
		$where = array();
		if(isset($session['search']) && $session['search']) {
			$search = $session['search'];
			$where[] = new \Clips\Libraries\OrOperator(
					array(new \Clips\Libraries\LikeOperator('title.asset_name', '%'.$search.'%'),
							new \Clips\Libraries\LikeOperator('title_application.director', '%'.$search.'%'),
							new \Pinet\EPG\Core\FindInSet('title_application.actors', $search))
			);
		}
		$where[] = new \Clips\Libraries\OrOperator(
						array(array('title_application.episode_id' => ''),
							array('title_application.episode_id' => 1)
						)
					);
		if(isset($session['type']) && $session['type'] && $session['type'] != 'all') {
			$type = $session['type'];
			$where[] = new \Clips\Libraries\LikeOperator('package.program_type_name', '%'.$type.'%');
		}
		if(isset($session['area']) && $session['area'] && $session['area'] != 'all') {
			$area = $session['area'];
			$where[] = new \Clips\Libraries\LikeOperator('title_application.area', '%'.$area.'%');
		}
		if(isset($session['year']) && $session['year'] && $session['year'] != 'all') {
			$siftYear = $session['year'];
			if(substr($siftYear,0,1) == '-'){
				$where["date_format(title.create_at, '%Y')"] = new \Clips\Libraries\CommonOperator('year', $siftYear, '<');
			}else{
				$where["date_format(title.create_at, '%Y')"] = $siftYear;
			}
		}
		if($columnID)
			$where['asset_column_ref.column_id'] = $columnID;
		$type = isset($session['order_by']) ? $session['order_by'] : 'new';
		$orderBy = 'title.create_at';
		if($type == 'hot'){
			$orderBy = 'count';
		}
		$where['poster.image_aspect_ratio'] = '300x428';
		$where[] = new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null));
		$titles = $this->select("count(distinct play_histories.id) as count , title.id, package.program_type_name,
								title_application.director,title_application.actors,title_application.area,
								title.asset_name,poster.sourceurl,title.package_id,date_format(title.create_at, '%Y') as year")
						->from('title')
						->join('poster',array('poster.title_id'=>'title.id'))
						->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
						->join('package',array('package.id'=>'title.package_id'))
						->join('title_application',array('title_application.id'=>'title.application_id'))
						->join('play_histories',array('play_histories.package_id'=>'title.package_id'),'left')
						->where($where)
						->groupBy('title.package_id')
						->orderBy($orderBy . ' desc')
						->limit($offset,$limit)
						->result();
		return $titles;

	}

	public function getNewTitlesByColumnID($columnID, $notIn=array() ,$limit=10){
		$where = array('asset_column_ref.column_id'=>$columnID);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.package_id', $notIn);
		}
		$where[] = new \Clips\Libraries\OrOperator(
						array(array('title_application.episode_id' => ''),
							array('title_application.episode_id' => 1)
						)
					);
		$titles = $this->select('title.id,title.asset_name,title.create_at')
			->from('title')
			->join('title_application',array('title_application.id'=>'title.application_id'))
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->where($where)
			->groupBy('title.package_id')
			->orderBy('title.create_at desc')
			->limit(0,$limit)
			->result();
		return $titles;
	}

	public function getHomeNavigations($navs, $limit=10){
		$actions = array();
		foreach ($navs as $k=>$nav) {
			$action = new ColumnAction(array('content' => 'movie/index/'.$nav->id, 'label' => $nav->column_name, 'type' => 'server'));
			$records = $this->playhistorie->getRecordsByColumnID($nav->id);
			$count = count($records);
			if($count != $limit){
				$packageIDs = array_map(function($record){ return $record->package_id;}, $records);
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

	public function getHotsByColumnID($columnID,$offset=0,$limit=20){
		return $this->select('title.id,title.asset_name,poster.sourceurl,count(1) as count')
				->from('title')
				->join('title_application',array('title_application.id'=>'title.application_id'))
				->join('play_histories',array('play_histories.title_id'=>'title.id'))
				->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
				->join('poster',array('poster.title_id'=>'title.id'))
				->where(array('asset_column_ref.column_id'=>$columnID,
						new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)),
						'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE),
						new \Clips\Libraries\OrOperator(
							array(array('title_application.episode_id' => ''),
								array('title_application.episode_id' => 1)
							)
						)
				))
				->groupBy('play_histories.package_id')
				->orderBy("count desc")
				->limit($offset, $limit)
				->result();
	}

	public function getSeries($packageID){
		return $this->select('title.id, title_application.episode_id')
			->from('title')
			->join('title_application',array('title_application.id'=>'title.application_id'))
			->where(array('title.package_id'=>$packageID,
				new \Clips\Libraries\NotOperator(array('title.application_id' => null)),
				new \Clips\Libraries\NotOperator(array('title_application.episode_id' => ''))
			))
			->orderBy('cast(title_application.episode_id as unsigned)')
			->result();
	}
}