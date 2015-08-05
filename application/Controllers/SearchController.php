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
	 * @Clips\Widget({"epg", "navigation", "image", "handlebars"})
	 * @Clips\Scss({"search/movie"})
	 * @Clips\Js({"application/static/js/search/movie.js"})
	 */
	public function movie() {
		$this->request->session('sift',null);
		$search = $this->request->post('search') ? trim($this->request->post('search')) : trim($this->request->get('search'));
		$columnID = $this->request->post('column_id');
		$filterID = $this->request->get('column_id');
		if($filterID){//if contains value, then is is used for filtering value in mobile device
			$titles = $this->title->getTitlesByHotKey($search, $filterID);
		}else{
			$titles = $this->title->getTitlesByHotKey($search, $columnID);
		}
		$this->request->session('column_id', $columnID);
		$this->request->session('search', $search);
		 \Clips\context('highlight-text', $search);
		if(!count($titles)){
			return $this->forward('empty_result');
		}
		foreach ($titles as $k=>$v) {
			$titles[$k]->url = \Clips\static_url('movie/play/'.$v->id);
		}

		$sift = $this->movie->sift($columnID);
		$movieTab = $this->title->getColumnMovieCount($search, $columnID);
		$tabs = array();
		$total = 0;
		for($i=0; $i < count($movieTab); $i++){
			$total += $movieTab[$i]->count;
			if(count($movieTab) > 1){
				$tabs[] = array('id'=> $movieTab[$i]->column_id, 'column_name'=> $movieTab[$i]->column_name.'('.$movieTab[$i]->count.')'
				, 'active'=> $filterID == $movieTab[$i]->column_id ? 'active' : '', 'search'=> $search);
			}
		}
		$tabs[0] = array('id'=>'', 'column_name'=> '全部('.$total.')', 'active'=> $filterID ? '' : 'active', 'search'=> $search);
		foreach($movieTab as $movie){
			$total += $movie->count;
		}
		return $this->render("search/movie", array(
			'nav' => true,
			"sifts"=>$sift,
			'movies'=>$titles,
			'more'=>count($titles)<20 ? false : true,
			"tab"=>$tabs
		));
	}

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"search/empty_result"})
	 * @Clips\Js({"application/static/js/search/empty_result.js"})
	 */
	public function empty_result(){
		return $this->render('search/empty_result', array(
			'nav' => true,
			'search' => $this->request->session('search'),
			'sames' => $this->title->getSameColumnMovies($this->request->session('column_id'))
		));
	}

	public function getMore($page){
		$offset = $page * 20;
		$columnID = $this->request->session('column_id');
		$search = $this->request->session('search');
		$titles = $this->title->getTitlesByHotKey($search, $columnID,$offset,20);
		foreach ($titles as $k=>$v) {
			$titles[$k]->url = \Clips\static_url('movie/play/'.$v->id);
		}

		return $this->json(array(
				'page'=>$page + 1,
				'movies'=>$titles
		));
	}

}
