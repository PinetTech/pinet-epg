<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * @Clips\Model({"config","configChange"})
 */
class MovieModelTest extends Clips\TestCase {

	public function testGetMovieByName(){
		$this->assertEquals('ab', 'ab');
	}

}