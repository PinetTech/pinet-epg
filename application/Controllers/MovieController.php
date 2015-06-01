<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;
use Clips\Controller;

/**
 * @Clips\Widget({"html", "lang", "grid"})
 * @Clips\MessageBundle(name="movie")
 */
class MovieController extends BaseController
{
	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"welcome/list"})
	 * @Clips\Js({"application/static/js/welcome/list.js"})
	 * @Clips\Model({"column", "movie", "title"})
	 */
	public function index($columnID=1, $type='new') {
		$this->title('Pinet Home Page',true);
		$sift = $this->movie->sift();

		$movies = array();
		if($type == 'hot') {
			$records = $this->title->getHotsByColumnID($columnID);
		}elseif($type == 'new'){
			$records = $this->title->getNewsByColumnID($columnID);
		}
		foreach ($records as $v) {
			$movies[] = (object)array('id'=>$v->id,'title'=>$v->asset_name, 'sourceurl'=>$v->sourceurl,'record'=>$v->count);
		}

		return $this->render('movie/list',array(
			'nav' => true,
			'slider' => true,
			'column_id' => $columnID,
			"sifts"=>$sift,
			'movies'=>$movies,
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
			),
		));
	}

    /**
     * @Clips\Form({"search"})
     * @Clips\Js({"application/static/js/movie/play.js"})
     * @Clips\Widget({"epg", "navigation", "image", "videoJs"})
	 * @Clips\Scss({"movie/play"})
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
		$this->playhistorie->saveHistory(array(
			'mac' => (string)\Clips\ip2mac($this->request->getIP()),
			'title_id' => $titleID
		));

		$sames = $this->title->getSameTypeMovies($titleID);
        $this->title($title->asset_name,true);

	    $navs = $this->column->getAllColumns();
	    $actions = $this->title->getHomeNavigations($navs);

	    if($title->assetClass == 'Series') {
			$series = $this->title->getSeriesByTitle($title->asset_name);

	    }

	    return $this->render("movie/play", array(
			'nav' => true,
		    'actions'=>$actions,
	        'movie'=>$title,
	        'sames'=>$sames,
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


}
