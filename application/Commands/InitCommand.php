<?php namespace Pinet\EPG\Commands; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Command;

/**
 * @Clips\Library("sling")
 */
class InitCommand extends Command {
	public function execute($args) {
		$this->initColumns();
	}

	/**
	 * Initialize the columns of videos
	 */
	public function initColumns() {
		$columns = \Clips\config('columns');
		$columns = $columns[0];
		$i = 0;
		foreach($columns as $key => $col) {
			$this->sling->update('/epg/columns/'.$key, array(
				'column_id'=>$i,
				'column_name' => $col,
				'name' => $key,
				'type' => 'column',
				'time' => \Clips\timestamp(),
				'column_type' => $i++,
				'rank' => $i,
				'status' => 1,
				'desc' => $col
			));
		}
	}
} 
