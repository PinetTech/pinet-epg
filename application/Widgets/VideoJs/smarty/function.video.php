<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

function smarty_function_video($params, $template) {
	$src = Clips\get_default($params, 'src', null);
	if(!$src) {
		Clips\error("No src found for this video tag.");
		return '';
	}
	$src = Clips\create_tag('source', array('src' => $src, 'type'=>"application/x-mpegURL"));
	return Clips\create_tag_with_content('video', $src, $params, array('class' => array('video-js', 'vjs-default-skin'), 'id'=>'video', 'controls'));
}