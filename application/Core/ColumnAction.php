<?php namespace Pinet\EPG\Core; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use \Clips\SimpleTreeNode;
use \Clips\Interfaces\Action;

/**
 * The default implementation of the Action interface
 *
 * @author Jake
 * @date Thu Jun  2 19:54:32 2015
 */
class ColumnAction extends SimpleTreeNode implements Action {
	public $type;
	public $content;
	public $params = array();

	public function __construct($data = array()) {
		if(is_object($data)) {
			$data = (array) $data;
		}

		if(!isset($data['type']))
			$this->type = Action::SERVER;

		parent::__construct($data);
	}

	protected function nodeClass() {
		return "\\Pinet\\EPG\\Core\\ColumnAction";
	}

	public function active() {
		$controller = \Clips\context('controller');
		if($controller) {
			$query = $controller->getMovieQuery();
			if(isset($this->name))
				return $query->column == $this->name;
		}
		return false;
	}

	public function type() {
		return \Clips\get_default($this, 'type');
	}

	public function content() {
		return \Clips\get_default($this, 'content');
	}

	public function params() {
		return \Clips\get_default($this, 'params', array());
	}

}
