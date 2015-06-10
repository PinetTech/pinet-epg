<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

/**
 * @Clips\Model({"movie"})
 */
class MovieModelTest extends Clips\TestCase {

	/**
	 * @test
	 * @Clips\FakeModel
	 */
	public function getRecommendTitles(){
		$this->fake_handler->expect('query',
			'select title.id,title.asset_name,title.create_at,poster.sourceurl from title as title  join poster as poster on (poster.title_id = title.id)
			join recommend_titles as recommend_titles on (recommend_titles.title_id = title.id) where (poster.image_aspect_ratio = ?) limit 0, 9', 1)->result(array(
				array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				),array(
					'id' => 1,
					'asset_name' => '',
					'create_at' => '',
					'sourceurl' => ''
				)
			));
		$this->assertTrue(count($this->movie->getRecommendTitles()) == 9);
	}

}