<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid"})
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

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"search/movie"})
	 * @Clips\Js({"application/static/js/search/movie.js"})
	 * @Clips\Model({"title","column","movie"})
	 */
	public function movie() {
		$search = $this->request->post('search') ? $this->request->post('search') : $this->request->get('search');
		$columnID = $this->request->post('column_id');
		$this->request->session('column_id', $columnID);
		$titles = $this->title->getTitlesByHotKey($search, $columnID);
		foreach ($titles as $k=>$v) {
			$titles[$k]->url = \Clips\static_url('movie/play/'.$v->id);
		}

		$sift = $this->movie->sift($columnID);
		$this->formData('search', (object)(array('search'=>$search)));

		return $this->render("search/movie", array(
			'nav' => true,
			"sifts"=>$sift,
			'search'=>$search,
			'movies'=>$titles,
			"tab"=>array(
				"navs"=>array(
					'全部',
					'电影',
					'电视剧'
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
