<?php namespace Pinet\EPG\Core; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Controller;
use Clips\Interfaces\Initializable;

/**
 * The Base controller for all controllers
 *
 * @author Jake
 * @since 2015-04-21
 */
class BaseController extends Controller implements Initializable {

	public function init() {
		// Add the UA Compatible
		\Clips\context('html_meta', array('http-equiv' => 'X-UA-Compatible',
			'content' => 'IE=edge'), true);
		// Add the view port for phones
		\Clips\context('html_meta', array('name' => 'viewport',
			'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'), true);
		// Add the iPhone support
		\Clips\context('html_meta', array('name' => 'renderer',
			'content' => 'webkit'), true);
		// Add the cache control
		\Clips\context('html_meta', array('http-equiv' => 'Cache-Control',
			'content' => 'no-siteapp'), true);
		// Add the cache control
		\Clips\context('html_meta', array('name' => 'mobile-web-app-capable',
			'content' => 'yes'), true);
		// Add the cache control
		\Clips\context('html_meta', array('name' => 'apple-mobile-web-app-capable',
			'content' => 'yes'), true);
		// Add the cache control
		\Clips\context('html_meta', array('name' => 'apple-mobile-web-app-status-bar-style',
			'content' => 'black'), true);
		// Add the cache control
		\Clips\context('html_meta', array('name' => 'apple-mobile-web-app-title',
			'content' => 'Pinet EPG'), true);
	}

	public function getMovieQuery() {
		$data = $this->request->session('movie_query');
		if($data) {
			return json_decode($data);
		}

		$data = array(
			'column' => 'movie',
            'type'=>'movie',
			'category' => array('all'),
			'area' => array('all'),
			'time' => array('all'),
			'keywords' => array(),
			'order' => 'year desc'
		);
		$this->request->session('movie_query', json_encode($data));
		return $data;
	}

    public function getSearchMovieQuery($search) {
        $search = $search ? $search : array();
        $data = array(
            'column' => 'movie',
            'type'=>'movie',
            'category' => array('all'),
            'area' => array('all'),
            'time' => array('all'),
            'keywords' => $search,
            'order' => 'year desc'
        );
        $this->request->session('movie_query', json_encode($data));
        return $data;
    }

    public function getAllMovies() {
        $data = array(
            'column' => 'movie',
            'type'=>'movie',
            'category' => array('all'),
            'area' => array('all'),
            'time' => array('all'),
            'keywords' => array(),
            'order' => 'year desc'
        );
        $this->request->session('movie_query', json_encode($data));
        return $data;
    }

    public function getSerials($serial) {
        $data = array(
            'column' => 'movie',
            'type'=>$serial,
            'category' => array('all'),
            'area' => array('all'),
            'time' => array('all'),
            'keywords' => array(),
            'order' => 'year desc'
        );
//        $this->request->session('movie_query', json_encode($data));
        return $data;
    }

	protected function updateQuery($type = 'column', $data = 'movie') {
		$query = $this->getMovieQuery();

		if($type == 'column') {
			$query->column = $data;
		}
		else if($type == 'order') {
			$query->order = $data;
		}
		else {
			if($data == 'all') {
				$query->$type = array('all');
			}
			else {
				if($query->{$type}[0] == 'all') {
					$query->$type = array($data);
				}
				else
					array_push($query->$type, $data);
			}
		}
		$this->request->session('movie_query', json_encode($query));
		return $query;
	}
}
