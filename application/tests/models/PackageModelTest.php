<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * @Clips\Model({"package"})
 */
class PackageModelTest extends Clips\TestCase {

	public function testGetPackagesByType(){
		$packages = $this->package->getPackagesByType('惊悚');
		foreach ($packages as $item) {
			if($item->id == 12) {
				$title = $item;
			}
		}

		$this->assertEquals('霸王别姬', $title->asset_name);
	}

}