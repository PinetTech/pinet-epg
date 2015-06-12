<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;
use Clips\Controller;

/**
 * @Clips\Widget({"html", "lang", "grid"})
 * @Clips\MessageBundle(name="movie")
 * @Clips\Model({"title", "movie","column"})
 */
class MovieController extends BaseController
{
	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image", "handlebars"})
	 * @Clips\Scss({"movie/list"})
	 * @Clips\Js({"application/static/js/movie/list.js"})
	 */
	public function index($columnID=1, $type='') {
		if(!$type){
			$type = $this->request->session('order_by') ? $this->request->session('order_by') : 'new';
			$this->request->session('column_id', $columnID);
			$this->request->session('sift', array('order_by'=>$type));
			$this->request->session('search',null);
		}
		$this->request->session('order_by', $type);
		$this->request->session('sift', array_merge($this->request->session('sift'), array('order_by'=>$type)));

		$movies = $this->title->siftRecords($this->request->session('sift'),$columnID,0,20);
		if(!count($movies)){
			return $this->forward('construction');
		}
		$this->title('流媒体系统',true);
		$sift = $this->movie->sift($columnID);

		return $this->render('movie/list',array(
			'nav' => true,
			'slider' => true,
			'column_id' => $columnID,
			"sifts"=>$sift,
			"column_name"=>$this->column->load($columnID)->column_name,
			'movies'=>$movies,
			'more'=>count($movies)<20 ? false : true,
			'tab'=>array(
				array('name'=>'最新', 'active' => $type == 'new' ? 'active' : '','url'=>\Clips\static_url('movie/index/'.$columnID.'/new')),
				array('name'=>'最热', 'active' => $type == 'hot' ? 'active' : '','url'=>\Clips\static_url('movie/index/'.$columnID.'/hot'))
			)
		));
	}

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"construction"})
	 */
	public function construction(){
		$columnID = $this->request->session('column_id');
		return $this->render('error/construction', array(
			'nav' => true,
			'slider' => true,
			'column_id' => $columnID,
			"column_name"=>$this->column->load($columnID)->column_name
		));
	}

    /**
     *
     * @Clips\Form({"search"})
     * @Clips\Js({"application/static/js/movie/play.js"})
     * @Clips\Widget({"epg", "navigation", "image", "videoJs"})
	 * @Clips\Scss({"movie/play"})
	 * @Clips\Model({"playHistorie","assetColumnRef","device"})
     */
    public function play($titleID) {
	    $this->request->session('column_id', null);
	    $columnRef = $this->assetcolumnref->getColumnByID($titleID);
	    if(isset($columnRef->column_id)){
	        $this->request->session('column_id', $columnRef->column_id);
	    }
		$title = $this->title->getMovieInfoByID($titleID);
		$columnID = $this->request->session('column_id');
		if(!isset($title->id)){
			return $this->forward('error404');
		}
	    \Clips\context('jquery_init', <<<VIDEOJS_SWF

	videojs.options.flash.swf = Clips.staticUrl('application/Widgets/VideoJs/js/video-js.swf');
	// initialize the player
	var player = videojs('video');
	setPoster(player, Clips.staticUrl('application/static/img/poster.png'), Clips.staticUrl('application/static/img/poster.png'));
	$(player.el()).find('.vjs-big-play-button span').text($('.video-button-text').text());
VIDEOJS_SWF
	    ,true);

		$title->playUrl = $this->movie->getPlayUrlByTitleID($titleID, $this->request->server('REMOTE_ADDR'));
		$this->playhistorie->saveHistory(array(
			'mac' => (string)\Clips\ip2mac($this->request->getIP()),
			'title_id' => $titleID
		));

	    $this->device->saveDevices(array(
			    'mac' => (string)\Clips\ip2mac($this->request->getIP()),
			    'create_date' => date("Y-m-d H:i:s",time()),
			    'uagent' => $_SERVER['HTTP_USER_AGENT'],
			    'play_uri' => \Clips\context('uri')
        ));

		$sames = $this->title->getSameTypeMovies($titleID);
        $this->title($title->asset_name,true);

	    $seriesList = array();
	    if($title->show_type == 'Series') {
			$series = $this->title->getSeries($title->package_id);
		    foreach ($series as $k=>$v) {
			    $seriesList[$k]['titleID'] = $v->id;
			    $seriesList[$k]['episode'] = $v->episode_id;
			    $seriesList[$k]['active'] = ($v->id == $titleID ? 'active' : '');
		    }
	    }
	    return $this->render("movie/play", array(
			'nav' => true,
	        'movie'=>$title,
	        'returnColumn'=>$this->column->getReturnColumn($columnID),
	        'sames'=>$sames,
	        'column_id'=>$columnID,
		    'seriesList'=>$seriesList,
			"tab"=>array(
				'简介',
				'剧集',
				'相关'
			)
	    ));
    }

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image", "handlebars"})
	 * @Clips\Scss({"movie/list"})
	 * @Clips\Js({"application/static/js/movie/list.js"})
	 */
	public function sift($columnID=''){
		$this->request->session('column_id', $columnID);
		$sift = $this->request->session('sift') ? $this->request->session('sift') : array();
		if($this->request->session('search')){
			$sift['search'] = $this->request->session('search');
		}
		if(!$this->request->session('order_by')){
			$this->request->session('order_by', 'new');
		}
		$gets = $this->get();
		foreach($gets as $key=>$value){
			if(in_array($key, array('type', 'area', 'year'))){
				$gets[$key] = urldecode($value);
			}
		}
		$this->request->session('sift', array_merge($sift , $gets ? $gets : array()));
		$siftTypes = $this->movie->sift($columnID);

		$movies = $this->title->siftRecords($this->request->session('sift'),$columnID,0,20);
		return $this->render('movie/list',array(
			'nav' => true,
			'slider' => true,
			'column_id' => $columnID,
			'movies'=>$movies,
			"sifts"=>$siftTypes,
			'more'=>count($movies)<20 ? false : true,
			'tab'=>array(
				array('name'=>'最新', 'active' => $this->request->session('order_by') == 'new' ? 'active' : '','url'=>\Clips\static_url('movie/index/'.$columnID.'/new')),
				array('name'=>'最热', 'active' => $this->request->session('order_by') == 'hot' ? 'active' : '','url'=>\Clips\static_url('movie/index/'.$columnID.'/hot'))
			)
		));
	}

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image", "handlebars"})
	 * @Clips\Scss({"movie/top"})
	 * @Clips\Js({"application/static/js/movie/list.js"})
	 */
	public function top($columnID){
		$this->request->session('column_id', $columnID);
		$sift = $this->request->session('sift') ? $this->request->session('sift') : array();
		if($this->request->session('search')){
			$sift['search'] = $this->request->session('search');
		}
		$gets = $this->get();
		$this->request->session('sift', array_merge($sift , $gets ? $gets : array('order_by'=>'new')));
		$siftTypes = $this->movie->sift($columnID);

		$movies = $this->title->siftRecords($this->request->session('sift'),$columnID,0,20);
		return $this->render('movie/top',array(
			'nav' => true,
			'slider' => true,
			'column_id' => $columnID,
			"column_name"=>$this->column->load($columnID)->column_name,
			'movies'=>$movies,
			"sifts"=>$siftTypes,
			'more'=>count($movies)<20 ? false : true,
			'tab'=>array(
				array('name'=>'最新', 'active' => $this->request->session('order_by') == 'new' ? 'active' : '','url'=>\Clips\static_url('movie/index/'.$columnID.'/new')),
				array('name'=>'最热', 'active' => $this->request->session('order_by') == 'hot' ? 'active' : '','url'=>\Clips\static_url('movie/index/'.$columnID.'/hot'))
			)
		));
	}	

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Model({"searchKey"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"movie/hot"})
	 * @Clips\Js({"application/static/js/movie/hot.js"})
	 */
	public function hot(){
		return $this->render("movie/hot", array(
				'hots' => $this->searchkey->getKeys(20)
		));
	}

	/**
	 * @Clips\Model({"title"})
	 */
	public function getMore($page){
		$offset = $page * 20;

		$titles = $this->title->siftRecords($this->request->session('sift'),$offset,20);
		return $this->json(array(
			'page'=>$page + 1,
			'movies'=>$titles
		));

	}
}
