<?php namespace Pinet\EPG\Core; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use \Clips\SimpleTreeNode;
use \Clips\Interfaces\Action;

/**
 * The default implementation of the Action interface
 *
 * @author Jake
 * @date Thu Jun  2 19:54:32 2015
 */
class SiftAction extends SimpleTreeNode implements Action {
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
		return "\\Clips\\SiftAction";
	}

	public function active() {
		if(isset($this->_active))
			return $this->_active;
		$controller = \Clips\context('controller');
		$sift = $controller->request->session('sift');

		$query = array();
		$url = parse_url($this->content());
		$url = explode("&", $url['query']);
		foreach($url as $k=>$v){
			$param = explode('=', $v);
			$query[$param[0]] = $param[1];
		}
		if(array_intersect_assoc($query, $sift)){
			$this->_active = true;
			return true;
		}
		$this->_active = false;
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
