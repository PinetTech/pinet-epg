<?php namespace Pinet\EPG\Core;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\WhereOperator;

class FindInSet extends WhereOperator {
	public function __construct($left, $right) {
		parent::__construct(array());
		$this->left = $left;
		$this->right = $right;
	}

	public function getArgs() {
		return $this->right;
	}

	public function toString() {
		return 'find_in_set(?, '.$this->left.')';
	}
}