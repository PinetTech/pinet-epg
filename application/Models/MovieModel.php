<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\SiftAction;
use Clips\Model;

/**
 * Class MovieModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="movie", value={"video", "playHistorie"})
 * @Clips\Library("sling")
 */
class MovieModel extends Model {

	/**
	 * Query the movies based on:
	 *
	 * 1. Column (Required)
	 * 2. Categories *
	 * 3. Area *
	 * 4. Time *
	 * 5. Keyword *
	 */
	public function queryMovies($query, $offset = 0, $limit = 10) {
		$query = (array) $query;
		$query['offset'] = $offset;
		$query['limit'] = $limit;

		$mss = \Clips\config('mss_url');
		$mss = $mss[0];
		return array_map(function($item){
			$item->poster_normal = $item->id.'/'.$item->poster_normal;
			$item->poster_small = $item->id.'/'.$item->poster_small;
			$item->poster = $item->id.'/'.$item->poster;
			return $item;
		}, $this->sling->data("/mms.json", array(
			'type' => 'movie',
			'query' => json_encode($query)
		)));
	}

    public function getMovie($id) {
        return $this->sling->data('/media/video/'.$id);
    }

/*	public function getMovieByName($name){
		return $this->one('asset_name',$name);
	}*/

	public function getPlayUrl($movie){
        $mss = \Clips\config('mss_url');
        if($mss) {
            $mss = $mss[0];
            return $mss.'/api/retrieve/'.$movie->id.'/'.$movie->playlist_name;
        }
        return null;
	}

    public function getSameMovies($movie) {
        return array(); // Return empty list
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
			$record = array_merge($records, $this->video->getNewTitles($limit-$count, $packageIDs));
		}
		return $record;
	}

	//now instead of getPushRecords for banner
	public function getRecommendTitles(){
/*		$where = array('poster.image_aspect_ratio'=>(PosterModel::BIG_SIZE));
		return $this->select('title.id,title.asset_name,title.create_at,poster.sourceurl')
			->from('title')
			->join('recommend_titles',array('recommend_titles.title_id'=>'title.id'))
			->join('poster',array('poster.title_id'=>'title.id'))
			->where($where)
			->limit(0, 9)
			->result();*/

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
		$titles = array_slice($titles,0,9);
		return $titles;
	}

	public function sift($columnID=1){
		$types = $this->getProgramTypes();
		$areas = $this->getAreas();
		$years = $this->getYears();
		$type = new SiftAction(array('content' => '/nav', 'label' => '按类型', 'type' => 'server'));
		$typeChildren = array();
		foreach ($types as $k=>$v) {
			$typeChildren[] = new SiftAction(array('content' => '/movie/sift/'.$columnID.'?type='.$k, 'label' => $v, 'type' => 'server'));
		}
		$type->children = $typeChildren;

		$area = new SiftAction(array('content' => '/nav', 'label' => '按地区', 'type' => 'server'));
		$areaChildren = array();
		foreach ($areas as $k=>$v) {
			$areaChildren[] = new SiftAction(array('content' => '/movie/sift/'.$columnID.'?area='.$k, 'label' => $v, 'type' => 'server'));
		}
		$area->children = $areaChildren;

		$year = new SiftAction(array('content' => '/nav', 'label' => '按年份', 'type' => 'server'));
		$yearChildren = array();
		foreach ($years as $k=>$v) {
			$yearChildren[] = new SiftAction(array('content' => '/movie/sift/'.$columnID.'?year='.$k, 'label' => $v, 'type' => 'server'));
		}
		$year->children = $yearChildren;
		return array($type,$area,$year);
	}
}
