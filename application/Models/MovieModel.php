<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class MovieModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="movie")
 */
class MovieModel extends DBModel {

	public function getMovieByName($name){
		return $this->one('asset_name',$name);
	}

	public function getMoviesByColumn(){

	}

	public function getPlayUrlByTitleID($titleID, $serverUrl){
		$movie = $this->one('title_id', $titleID);
		if(isset($movie->id)){
			return str_replace('localhost', $serverUrl, $movie->play_url);
		}
		return '';
	}

}