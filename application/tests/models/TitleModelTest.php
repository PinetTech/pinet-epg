<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * @Clips\Model({"title"})
 */
class TitleModelTest extends Clips\TestCase {

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function getTitlesByColumn(){
		$this->title->getTitlesByColumn(1);
	}

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function getTitlesByHotKey(){
		$this->title->getTitlesByHotKey('test', 1);
	}

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function getColumnMovieCount(){
		$this->title->getColumnMovieCount('test', 1);
	}

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function siftRecords(){
		$this->title->siftRecords(array(), 1);
	}

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function getHotsByColumnID(){
		$this->title->getHotsByColumnID(1);
	}

	/**
	 * @test
	 * @Clips\FakeModel("logFakeDataSourceHandler")
	 */
	public function getSeries(){
		$this->title->getSeries(1);
	}

}