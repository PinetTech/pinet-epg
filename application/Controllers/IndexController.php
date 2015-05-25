<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "bootstrap"})
 * @Clips\MessageBundle(name="index")
 */
class IndexController extends BaseController
{
    /**
     * @Clips\Scss({"index/index"})
     * @Clips\Model({"title"})
     */
    public function index() {
        $this->title('Pinet Home Page',true);
		$movies = $this->title->getTitlesByColumn(11,6);
	    var_dump($movies);die;
        return $this->render('index/index');
    }
}
