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
 * @Clips\Library("sling")
 */
class TitleModel extends DBModel {

/*	public function getTitleByName($name){
		return $this->one('asset_name',$name);
	}*/

	public function getTitlesByColumn($column_id, $limit=0){
/*		$titles = $this->select('min(title.id) as id,title.asset_name,poster.sourceurl,title.package_id')
			->from('title')
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where(array('asset_column_ref.column_id'=>$column_id,
				'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE),
				new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null))))
			->groupBy('title.package_id')
			->limit(0, $limit)
			->result();*/

		$data = $this->sling->data('/epg/columns.2');
		foreach($data as $k => $v) {
			if(is_object($v) && $v->type == 'column' && $v->column_id == $column_id) {
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
		$titles = array_slice($titles,0,$limit);

		foreach ($titles as $k=>$v) {
			$titles[$k]->record = $this->playhistorie->getPlayTimesByPackageID($v->package_id);
		}
		return $titles;
	}

	/**
	 * @Clips\Model({ "searchKey" })
	 */
	public function getTitlesByHotKey($key, $columnID, $offset=0, $limit=10){
		$key = trim($key);
		$this->searchkey->recordHotKey($key);
		$where = array(
			new \Clips\Libraries\OrOperator(
				array(new \Clips\Libraries\LikeOperator('title.asset_name', '%'.$key.'%'),
					new \Clips\Libraries\LikeOperator('title_application.director', '%'.$key.'%'),
					new \Pinet\EPG\Core\FindInSet('title_application.actors', $key))
			),
			'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE)
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
/*		$titles = $this->select('title.id,title.asset_name,title_application.actors,title_application.summary_short,title_application.director,title.show_type,title.package_id')
			->from('title')
			->join('title_application',array('title.application_id'=>'title_application.id'))
			->where(array('title.id' => $titleID))
			->result();
		if(count($titles))
			return $titles[0];
		return null;*/

		$title = $this->sling->data('/media/video/'.$titleID);
		return $title;

	}

	public function getTitles($limit=10, $notIn=array()){
/*		$select = $this->select('title.id,title.asset_name,poster.sourceurl')
				->from('title')
				->join('poster',array('poster.title_id'=>'title.id'));
		$where = array(
			new \Clips\Libraries\NotOperator(array('title.asset_id' => null)),
				'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE)
		);
		if($notIn){
			$where[] = new \Pinet\EPG\Core\NotIn('title.id', $notIn);
		}
		$select->where($where);
		$titles = $select->limit(0,$limit)
			->result();
		if($titles)
			return $titles;
		return array();*/

		$titles = array();
		$data = $this->sling->data('/epg/columns.2');
		foreach($data as $k => $v) {
			if(is_object($v) && $v->type == 'column') {
				foreach ($v as $k2=>$v2) {
					if(is_object($v2) && $v2->type == 'epg/link') {
						$title = $this->sling->data($v2->reference);
						$titles[] = $title;
					}
				}
			}
		}
		$titles = array_slice($titles,0,$limit);
		return $titles;
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

/*	public function siftTitles($session){
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
		var_dump($typeAll);die;
		return $typeAll;

	}*/

	public function siftRecords($session,$columnID){
		$where = array();
		if(isset($session['search']) && $session['search']) {
			$search = $session['search'];
			$where[] = new \Clips\Libraries\OrOperator(
					array(new \Clips\Libraries\LikeOperator('title.asset_name', '%'.$search.'%'),
							new \Clips\Libraries\LikeOperator('title_application.director', '%'.$search.'%'),
							new \Pinet\EPG\Core\FindInSet('title_application.actors', $search))
			);
		}
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
		$where['asset_column_ref.column_id'] = $columnID;
		$where['poster.image_aspect_ratio'] = '300x428';
		$where[] = new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null));
		$titles = $this->select("count(play_histories.id) as count ,min(title.id) as id, package.program_type_name,
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
						->orderBy('title.create_at desc')
						->result();
//		var_dump($titles);die;
		return $titles;


/*		$siftRecords = array();
		foreach($records as $record){
			$title = $this->one('id',$record->id);
			$titleApp = $this->titleapplication->one('id',$title->application_id);
			$record->type = $this->package->one('id',$title->package_id)->program_type_name;
			$record->area = $titleApp->area;
			$record->director = $titleApp->director;
			$record->actors = $titleApp->actors;
			$record->year = $title->create_at;
			if(isset($session['search']) && $session['search']) {
				$search = $session['search'];
				if(!(strpos($record->asset_name, $search) !== false || strpos($record->director, $search) !== false
					|| strpos($record->actors, $search) !== false)){
					continue;
				}
			}
			if(isset($session['type']) && $session['type'] && $session['type'] != 'all') {
				if(!in_array($session['type'], array_map(function($type){ return trim($type);}, explode(',',$record->type)))){
					continue;
				}
			}
			if(isset($session['area']) && $session['area'] && $session['area'] != 'all') {
				if(strpos($record->area, $session['area'])===false){
					continue;
				}
			}
			if(isset($session['year']) && $session['year'] && $session['year'] != 'all') {
				$prefix = 0;
				if(substr($session['year'],0,1) == '-'){
					$prefix = 1;
				}
				$year = substr($record->year,$prefix,4);
				if($year > $session['year']) {
					continue;
				}
			}
			$siftRecords[] = $record;
		}
		return $siftRecords;*/
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
//			var_dump($nav);die;
			$action = new ColumnAction(array('content' => 'movie/index/'.$nav->column_id, 'label' => $nav->column_name, 'type' => 'server'));
			$records = $this->playhistorie->getRecordsByColumnID($nav->column_id);
			$count = count($records);
			if($count != $limit){
				$packageIDs = array_map(function($record){ return $record->id;}, $records);
				$records = array_merge($records, $this->getNewTitlesByColumnID($nav->column_id, $packageIDs, $limit-$count));
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
						'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE)
				))
				->groupBy('play_histories.package_id')
				->orderBy("count desc")
				->limit($offset, $limit)
				->result();
	}

	public function getNewsByColumnID($columnID,$offset=0,$limit=10){
		$news = $this->select('min(title.id) as id,title.asset_name,poster.sourceurl,title.package_id')
			->from('title')
			->join('asset_column_ref',array('asset_column_ref.title_asset_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where(array('asset_column_ref.column_id'=>$columnID,
				new \Clips\Libraries\NotOperator(array('asset_column_ref.status' => null)),
				'poster.image_aspect_ratio'=>(PosterModel::SMALL_SIZE)
			))
			->groupBy('title.package_id')
			->orderBy('title.create_at desc')
			->limit($offset, $limit)
			->result();
		foreach ($news as $k=>$v) {
			$news[$k]->count = $this->playhistorie->getPlayTimesByPackageID($v->package_id);
		}
		return $news;
	}

	public function getSeries($packageID){
		$series = $this->get(array('package_id'=>$packageID));

		foreach ($series as $k=>$v) {
			$app = $this->titleapplication->getEpisodeNameByID($v->application_id);
			$series[$k]->episode_name = $app->episode_name;
		}

		return $series;
	}
}