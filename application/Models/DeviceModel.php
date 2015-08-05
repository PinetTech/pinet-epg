<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;

/**
 * Class DeviceModel
 * @package Pinet\EPG\Models
 */
class DeviceModel extends DBModel {
	public function saveDevices($history){
		return $this->insert($history);
	}

}