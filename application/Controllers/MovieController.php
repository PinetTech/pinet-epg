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
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"welcome/list"})
	 * @Clips\Js({"application/static/js/welcome/list.js"})
	 */
	public function index($columnID=1, $type='new') {
		$this->request->session('column_id', $columnID);
		$this->request->session('sift',null);
		$this->title('EPG Home Page',true);
		$sift = $this->movie->sift($columnID);

		$movies = array();
		if($type == 'hot') {
			$movies = $this->title->getHotsByColumnID($columnID,0,20);
		}elseif($type == 'new'){
			$movies = $this->title->getNewsByColumnID($columnID,0,20);
		}

		return $this->render('movie/list',array(
			'nav' => true,
			'slider' => true,
			'column_id' => $columnID,
			"sifts"=>$sift,
			'flag'=>1,
			'movies'=>$movies,
			"tab"=>array(
				"navs"=>array(
					array('name'=>'Latest','url'=>\Clips\static_url('movie/index/'.$columnID.'/new')),
					array('name'=>'Hottest','url'=>\Clips\static_url('movie/index/'.$columnID.'/hot'))
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

	    $navs = $this->column->getAllColumns();
	    $actions = $this->title->getHomeNavigations($navs);
	    $seriesList = array();
	    if($title->show_type == 'Serise') {
			$series = $this->title->getSeries($title->package_id);
		    foreach ($series as $k=>$v) {
			    $seriesList[$k]['titleID'] = $v->id;
			    $seriesList[$k]['episode'] = $v->episode_name;
			    $seriesList[$k]['active'] = ($v->id == $titleID ? 'active' : '');
		    }
	    }

	    return $this->render("movie/play", array(
			'nav' => true,
		    'actions'=>$actions,
	        'movie'=>$title,
	        'sames'=>$sames,
		    'seriesList'=>$seriesList,
			"tab"=>array(
					"navs"=>array(
							'nav1',
							'nav2',
							'nav3'
					),
					"contents"=>array(
					)
			)
	    ));
    }

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"welcome/list"})
	 * @Clips\Js({"application/static/js/welcome/list.js"})
	 */
	public function sift($columnID){
		$this->request->session('column_id', $columnID);
		$sift = $this->request->session('sift') ? $this->request->session('sift') : array();
		if($this->request->session('search')){
			$sift['search'] = $this->request->session('search');
		}
		$this->request->session('sift', array_merge($sift ,$this->get()));
		$siftTypes = $this->movie->sift($columnID);

		$movies = $this->title->siftRecords($this->request->session('sift'),$columnID,0,20);

		return $this->render('movie/list',array(
			'nav' => true,
			'slider' => true,
			'column_id' => $columnID,
			'movies'=>$movies,
			"sifts"=>$siftTypes,
			'more'=>count($movies)<20 ? false : true,
			"tab"=>array(
					"navs"=>array(
							array('name'=>'最新','url'=>\Clips\static_url('movie/index/'.$columnID.'/new')),
							array('name'=>'最热','url'=>\Clips\static_url('movie/index/'.$columnID.'/hot'))
					),
					"contents"=>array(
							(object)array('title'=>'movie1','info'=>'sdsdsdsdsds'),
							(object)array('episodes'=>'1,2,3,4,5'),
							(object)array('number'=>array('sdsds','sdsds','sdsdsds'))
					)
			)
		));
	}

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Model({"searchKey"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"movie/hot"})
	 * @Clips\Js({"application/static/js/welcome/search.js"})
	 */
	public function hot(){
		return $this->render("movie/hot", array(
				'hots' => $this->searchkey->getKeys(20)
		));
	}

	public function getMore($flag,$type='new'){
		$columnID = $this->request->session('column_id');
		$offset = $flag * 20;

		if($type == 'new') {
			$titles = $this->title->getNewsByColumnID($columnID,$offset,20);
		}elseif($type == 'hot'){
			$titles = $this->title->getHotsByColumnID($columnID,$offset,20);
		}else{
			$titles = $this->title->siftRecords($this->request->session('sift'),$offset,20);
		}
		return $this->json(array(
			'flag'=>$flag + 1,
			'movies'=>$titles
		));

	}
}
