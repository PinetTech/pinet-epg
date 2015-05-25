<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * @Clips\Model({"title"})
 */
class TitleModelTest extends Clips\TestCase {

	public function testGetTitlesByColumn(){
		$titles = $this->title->getTitlesByColumn(11,6);
		foreach ($titles as $item) {
			if($item->id == 14) {
				$title = $item;
			}
		}

		$this->assertEquals('纵横四海', $title->asset_name);
	}

}