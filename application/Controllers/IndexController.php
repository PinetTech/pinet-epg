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
     * @Clips\Model({"title","playHistorie"})
     */
    public function index() {
        $this->title('Pinet Home Page',true);
		$titles = $this->title->getTitlesByColumn(1,6);
//	    foreach ($titles as $k=>$v) {
//			$titles[$k]->record = $this->playhistorie->getPlayTimesByTitleID($v->id);
//	    }
//	    $hotRecords = $this->playhistorie->getHotRecord();
//	    var_dump($titles);die;
//
//        return $this->render('index/index');
    }


}
