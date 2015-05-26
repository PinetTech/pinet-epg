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
	public function index() {
		$this->title('Pinet Home Page',true);
		$columns = $this->column->get();
		$titleApps = $this->titleapplication->get();

		return $this->render('movie/index');
	}

    /**
     * @Clips\Scss({"movie/index"})
     * @Clips\Widget("videoJs")
	 * @Clips\Model({"playHistorie", "title", "movie"})
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
	    );

		$title->playUrl = $this->movie->getPlayUrlByTitleID($titleID, $this->request->server('REMOTE_ADDR'));

	    $this->playhistorie->saveHistory(array(
			'mac' => $this->request->server('REMOTE_ADDR'),
			'title_id' => $titleID
		));

		$sames = $this->title->getSameTypeMovies($titleID);
		$this->logger->info('movie controller REMOTE_ADDR is ', array($this->request->server('SERVER_ADDR'), $sames));
        $this->title($title->asset_name,true);
        return $this->render('movie/play', array('movie' => $title));
    }


}
