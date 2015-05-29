<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "bootstrap"})
 * @Clips\MessageBundle(name="movie")
 */
class MovieController extends BaseController
{
	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"welcome/list"})
	 * @Clips\Js({"application/static/js/welcome/list.js"})
	 * @Clips\Model({"column","titleApplication","movie","title","playhistorie"})
	 */
	public function index($columnID) {
		$this->title('Pinet Home Page',true);
		$types = $this->movie->getProgramTypes();
		$areas = $this->movie->getAreas();
		$years = $this->movie->getYears();

		$type = $this->action('/nav', '按类型');
		$typeChildren = array();
		foreach ($types as $v) {
			$typeChildren[] = $this->action('/nav/'.$v, $v);
		}
		$type->children = $typeChildren;

		$area = $this->action('/nav', '按地区');
		$areaChildren = array();
		foreach ($areas as $v) {
			$areaChildren[] = $this->action('/nav/'.$v, $v);
		}
		$area->children = $areaChildren;

		$year = $this->action('/nav', '按年份');
		$yearChildren = array();
		foreach ($years as $v) {
			$yearChildren[] = $this->action('/nav/'.$v, $v);
		}
		$year->children = $yearChildren;

		$actions = array($type,$area,$year);

//		(object)array('title'=>'nature1', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/1'),
		$movies = array();
		$records = $this->playhistorie->getHotRecord(8);
		foreach ($records as $v) {
			$movies[] = (object)array('title'=>$v->asset_name, 'sourceurl'=>$v->sourceurl,'record'=>$v->count);
		}

		$items = $this->movie->getPushRecords();
//		var_dump($items);
		$itemRecords = array();
		foreach ($items as $v) {
			$itemRecords[] = (object)array('title'=>$v->asset_name, 'res'=>$v->sourceurl,'titleID'=>$v->id);
		}

		return $this->render('movie/list',array(
				"actions"=>$actions,
				'movies'=>$movies,
				'items'=>$itemRecords,
				"tab"=>array(
						"navs"=>array(
								'最新',
								'最热'
						),
						"contents"=>array(
								(object)array('title'=>'movie1','info'=>'sdsdsdsdsds'),
								(object)array('episodes'=>'1,2,3,4,5'),
								(object)array('number'=>array('sdsds','sdsds','sdsdsds'))
						)
				),
		));
	}

    /**
     * @Clips\Form({"search"})
     * @Clips\Scss({"movie/play"})
     * @Clips\Js({"application/static/js/movie/play.js"})
     * @Clips\Widget({"epg", "navigation", "image", "videoJs"})
	 * @Clips\Model({"playHistorie", "title", "movie","column","TitleApplication"})
     */
    public function play($titleID) {
		$title = $this->title->getMovieInfoByID($titleID);
		if(!isset($title->id)){
			echo 'Not Found This Movie!';//todo need redirect 404 page
			die;
		}
	    \Clips\context('jquery_init', <<<VIDEOJS_SWF

	videojs.options.flash.swf = Clips.staticUrl('application/Widgets/VideoJs/js/video-js.swf');
	// initialize the player
	var player = videojs('video');
VIDEOJS_SWF
	    ,true);

		$title->playUrl = $this->movie->getPlayUrlByTitleID($titleID, $this->request->server('REMOTE_ADDR'));
		$title->assetClass = $this->movie->getMovieByTitleID($titleID)->asset_class;
		$mac = \Clips\ip2mac($this->request->getIP());
		if($mac) {
			$this->playhistorie->saveHistory(array(
				'mac' => $mac,
				'title_id' => $titleID
			));
		}

		$sames = $this->title->getSameTypeMovies($titleID);
        $this->title($title->asset_name,true);

	    $navs = $this->column->getAllColumns();
	    $actions = $this->title->getHomeNavigations($navs);

	    if($title->assetClass == 'series') {
			$series = $this->titleApplication->getSeriesByTitle($title->asset_name);

	    }

	    return $this->render("movie/play", array(
			    'actions'=>$actions,
		        'movie'=>$title,
		        'sames'=>$sames
	    ));
    }


}
