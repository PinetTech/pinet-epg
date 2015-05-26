<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

function smarty_block_swiper__pagination($params, $content = '', $template, &$repeat) {
	if($repeat) {
		\Clips\clips_context('indent_level', 1, true);
		return;
	}	
	$default = array(
		'class' => 'swiper-pagination'
	);
	\Clips\context_pop('indent_level');
	return \Clips\create_tag('div', $params, $default, $content);
}