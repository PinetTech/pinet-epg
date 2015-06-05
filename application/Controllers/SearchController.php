<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid"})
 * @Clips\MessageBundle(name="index")
 * @Clips\Model({"title","column","movie"})
 */
class SearchController extends BaseController
{
    /**
     * @Clips\Scss({"index/index"})
     */
    public function index() {
        $this->title('EPG Home Page',true);
		$keys = $this->search->getKeys(6);
        return $this->render('index/index');
    }

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"search/movie"})
	 * @Clips\Js({"application/static/js/search/movie.js"})
	 */
	public function movie() {
		$this->request->session('sift',null);
		$search = $this->request->post('search') ? $this->request->post('search') : $this->request->get('search');
		$columnID = $this->request->post('column_id');
		$this->request->session('column_id', $columnID);
		$this->request->session('search', $search);
		$titles = $this->title->getTitlesByHotKey($search, $columnID);
		foreach ($titles as $k=>$v) {
			$titles[$k]->url = \Clips\static_url('movie/play/'.$v->id);
		}

		$sift = $this->movie->sift($columnID);
		$this->formData('search', (object)(array('search'=>$search)));

		return $this->render("search/movie", array(
			'nav' => true,
			"sifts"=>$sift,
			'movies'=>$titles,
			'flag'=>1,
			'more'=>count($titles)<20 ? false : true,
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

	public function getMore($flag){
		$offset = $flag * 20;
		$this->request->session('offset',$offset);
		$columnID = $this->request->session('column_id');
		$search = $this->request->session('search');
		$titles = $this->title->getTitlesByHotKey($search, $columnID,$offset,20);
		foreach ($titles as $k=>$v) {
			$titles[$k]->url = \Clips\static_url('movie/play/'.$v->id);
		}


		$titles = $this->title->getTitlesByHotKey($search, $columnID);

		return $this->json(array(
				'flag'=>$flag + 1,
				'movies'=>$titles
		));
	}

}
