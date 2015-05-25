<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * @Clips\Model({"config","configChange"})
 */
class ColumnModelTest extends Clips\TestCase {

	public function testGetColumnByName(){
		$this->assertEquals('ab', 'ab');
	}
}