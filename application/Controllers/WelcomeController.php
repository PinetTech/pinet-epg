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
		$this->title('Pinet Home Page',true);
		return $this->render('welcome/index', array(), true, true);
	}

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation"})
	 * @Clips\Scss({"welcome/list"})
	 * @Clips\Js({"application/static/js/welcome/list.js"})
	 */
	public function movielist() {
		$nav1 = $this->action('/nav', 'label');
		$nav1->children = array(
				$this->action('/nav/1', 'nav1-1'),
				$this->action('/nav/2', 'nav1-2'),
				$this->action('/nav/3', 'nav1-3')
		);
		$nav2 = $this->action('/nav', 'label');
		$nav2->children = array(
				$this->action('/nav/1', 'nav2-1'),
				$this->action('/nav/2', 'nav2-2'),
				$this->action('/nav/3', 'nav2-3')
		);
		$nav3 = $this->action('/nav', 'label');
		$nav3->children = array(
				$this->action('/nav/1', 'nav3-1'),
				$this->action('/nav/2', 'nav3-2'),
				$this->action('/nav/3', 'nav3-3')
		);
		return $this->render('welcome/list', array(
				"actions"=>array(
						$nav1,
						$nav2,
						$nav3
				),
				"tab"=>array(
						"navs"=>array(
								'nav1',
								'nav2'
						),
						"contents"=>array(
								(object)array('title'=>'movie1','info'=>'sdsdsdsdsds'),
								(object)array('episodes'=>'1,2,3,4,5'),
								(object)array('number'=>array('sdsds','sdsds','sdsdsds'))
						)
				)
		));
	}
}
