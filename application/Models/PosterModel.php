<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\Object;

/**
 * Class PosterModel
 * @package Pinet\EPG\Models
 * @Clips\Model(table="poster")
 */
class PosterModel extends DBModel {
	const POSTER_SIZE = '306x429';

}