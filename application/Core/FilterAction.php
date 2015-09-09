<?php namespace Pinet\EPG\Core; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\SimpleAction;

/**
 *
 */
class FilterAction extends SimpleAction {
	public function __construct($data = array()) {
		parent::__construct($data);
	}

	public function active() {
		$controller = \Clips\context('controller');
		if($controller) {
			$query = $controller->getMovieQuery();

			$values = $query->{$this->mode};

			\Clips\log('The values is ', array($values, $this->mode_value));
			return array_search(urlencode($this->mode_value), $values) !== false;
		}
		return false;
	}

	protected function nodeClass() {
		return "\\Clips\\FilterAction";
	}
}
