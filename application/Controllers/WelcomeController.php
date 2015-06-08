<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct 
script access allowed");

use Pinet\EPG\Core\BaseController;

/**	
 * @Clips\Widget({"html", "lang", "grid"})
 * @Clips\MessageBundle(name="welcome")
 */
class WelcomeController extends BaseController
{
	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"welcome/index"})
	 * @Clips\Js({"application/static/js/welcome/index.js"})
	 * @Clips\Model({"title","column","movie"})
	 */
	public function index() {
		$this->title('流媒体系统',true);
		$this->request->session('column_id', null);
		$this->request->session('search', null);
		return $this->render('welcome/index', array(
			'nav' => true,
			'slider' => true,
			'column' => true
		));
	}

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"welcome/qr"})
	 * @Clips\Model({"title","column","movie"})
	 */
	public function qr() {
		$this->title('流媒体系统',true);
		return $this->render('welcome/qr');
	}
}
