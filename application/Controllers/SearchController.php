<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "bootstrap"})
 * @Clips\MessageBundle(name="index")
 * @Clips\Model({"searchKey","title"})
 */
class SearchController extends BaseController
{
    /**
     * @Clips\Scss({"index/index"})
     */
    public function index() {
        $this->title('Pinet Home Page',true);
		$keys = $this->search->getKeys(6);
        return $this->render('index/index');
    }

	public function search() {
		$post = $this->post();
		$titles = $this->title->getTitlesByKey($post['key']);
	}

	public function sift(){
		$post = $this->post();
		$titles = $this->title->getTitlesByItem("剧情","aaa",2015);
		var_dump($titles);
	}

}
