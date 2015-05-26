<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

\Clips\require_widget_smarty_plugin('html', 'img');

function smarty_block_swiper__slide($params, $content = '', $template, &$repeat) {
	if($repeat) {
		\Clips\clips_context('indent_level', 1, true);
		return;
	}	
	$default = array(
		'class' => 'swiper-slide'
	);
	$dataImage = \Clips\get_default($params, 'data-image', null);
	if($dataImage) {
		unset($params['data-image']);
		$image = smarty_function_img(array('src'=>$dataImage), $template);
	}

	\Clips\context_pop('indent_level');
	return \Clips\create_tag('div', $params, $default, $image.$content);
}