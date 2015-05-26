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
     */
    public function play() {
	    \Clips\context('jquery_init', <<<VIDEOJS_SWF

	videojs.options.flash.swf = Clips.staticUrl('application/Widgets/VideoJs/js/video-js.swf');
	// initialize the player
	var player = videojs('video');
VIDEOJS_SWF
	    );
	    
        $this->title('Pinet Home Page',true);
        return $this->render('movie/play');
    }


}
