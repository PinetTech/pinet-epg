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

	protected function render($template, $args = array(), $columnID, $slider = true, $column = false, $engine = null, $headers = array()) {
		$navs = $this->column->getAllColumns();
		$actions = $this->title->getHomeNavigations($navs);
		$args['actions'] = $actions;
		if($slider){
			$items = $this->movie->getPushRecords($columnID);
			$args['items'] = $items;
		}
		if($column){
			$columns = $this->column->getColumns($navs);
			$args['columns'] = $columns;
		}
		return parent::render($template, $args, $engine, $headers);
	}
}
