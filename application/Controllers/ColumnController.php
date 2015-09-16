<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;
use Clips\Controller;

/**
 * The controller for column manipulations
 *
 * @author Jack
 * @version 1.0
 * @date Sat Aug 29 16:03:48 2015
 *
 * @Clips\Model({"column", "movie"})
 * @Clips\Widget({"html", "lang", "grid", "image"})
 */
class ColumnController extends BaseController {

	/**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss("construction")
	 */
	public function test() {
		return $this->render('construction', array(
        	'actions' => $this->column->getNav()
		));
	}

    /**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image", "handlebars"})
	 * @Clips\Scss({"welcome/list"})
	 * @Clips\Js({"application/static/js/welcome/list.js"})
     */
    public function show($name = '', $filter = 'new', $filter_value = 'all') {
        if($name) {
            $all_movies = $this->movie->queryFront($name);
//          $this->request->session('all_movies',$all_movies);
//          $this->request->session('sift_name',$name);
            $this->title('Pinet Home Page',true);
            $col = $this->column->getColumnByName($name);
			$this->updateQuery('column', $name);
			$this->updateQuery('type', $name);
            if($filter=='new' || $filter=='hot'){
               $this->request->session('new_type',$filter);
            }
			switch($filter) {
			case 'new':
				$query = $this->updateQuery('order', 'year desc');
				break;
			case 'hot':
				$query = $this->updateQuery('order', 'year asc');
				break;
			default:
				$query = $this->updateQuery($filter, $filter_value);
			}
			$query->type = $name;
            $serial = $this->movie->queryMovies($this->getSerials('serials'));
            $this->request->session('serial_movies',$serial);
            if($col) {
                $movies = $this->movie->queryMovies($query);
                return $this->render('movie/list', array(
                    'sifts' => $this->column->getTypeNav($col->name),
                    'movies' => $movies,
					'column_name' => $col->label,
                    'items' => $all_movies,
					'tab' => array(
						'navs' => array(
							array('url'=>\Clips\site_url("/column/show/$name/new"), 'name' => '最新', 'active' => $this->request->session('new_type') == 'new' ? 'active' : ''),
							array('url'=>\Clips\site_url("/column/show/$name/hot"), 'name' => '最热', 'active' => $this->request->session('new_type') == 'hot' ? 'active' : '')
						)
					),
                    'actions' => $this->column->getNav()
                ));
            }
        }

        return $this->redirect(\Clips\site_url(''));
    }

    public function more($page){
		return $this->json($this->movie->queryMovies($this->getMovieQuery(), $page * 9, 9));
    }
}
