<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * @Clips\Model({"playHistorie"})
 */
class PlayHistorieModelTest extends Clips\TestCase {

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function getHotRecord(){
		$this->playhistorie->getHotRecord(1);
	}

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function getRecordsByColumnID(){
		$this->playhistorie->getRecordsByColumnID(1);
	}

}