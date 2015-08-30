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
	 * @Clips\Model({"title","column","movie","video"})
	 */
	public function index() {
		$this->title('Pinet Home Page',true);
		$this->request->session('column_id', null);
		$this->request->session('search', null);
		return $this->render('welcome/index', array(
            'columns' => $this->column->getFrontPageColumns(),
			'nav' => true,
            'actions' => $this->column->getNav(),
			'slider' => true,
			'column' => true,
            'items' =>  $this->column->getMovies('movie')
		));
	}
}
