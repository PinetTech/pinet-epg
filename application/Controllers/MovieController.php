<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "bootstrap"})
 * @Clips\MessageBundle(name="movie")
 */
class MovieController extends BaseController
{
	/**
	 * @Clips\Model({"column","titleApplication"})
	 */
	public function index($columnID) {
		exit('current movie type is'.$columnID);
		$this->title('Pinet Home Page',true);
		$columns = $this->column->get();
		$titleApps = $this->titleapplication->get();

		return $this->render('movie/index');
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
//		$mac = \Clips\ip2mac($this->request->getIP());
//		if($mac) {
//			$this->playhistorie->saveHistory(array(
//				'mac' => $mac,
//				'title_id' => $titleID
//			));
//		}

		$sames = $this->title->getSameTypeMovies($titleID);
	    $sames = array($sames[0]);
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
