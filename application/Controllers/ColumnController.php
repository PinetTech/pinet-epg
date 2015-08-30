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
 * @Clips\Model("column")
 * @Clips\Widget({"html", "lang", "grid"})
 */
class ColumnController extends BaseController {

    /**
	 * @Clips\Form({"search"})
	 * @Clips\Widget({"epg", "navigation", "image"})
	 * @Clips\Scss({"welcome/list"})
	 * @Clips\Js({"application/static/js/welcome/list.js"})
     */
    public function show($name = '') {
        if($name) {
            $this->title('Pinet Home Page',true);
            $col = $this->column->getColumnByName($name);

            if($col) {
                $movies = $this->column->getMovies($col->name);
                return $this->render('movie/list', array(
                    'sifts' => $this->column->getTypeNav(),
                    'movies' => $movies,
                    'items' => $movies,
                    'actions' => $this->column->getNav()
                ));
            }
        }

        return $this->redirect(\Clips\site_url(''));
    }
}
