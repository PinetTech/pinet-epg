<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

\Clips\require_widget_smarty_plugin('html', 'img');
\Clips\require_widget_smarty_plugin('image', 'resimg');

function smarty_block_swiper__slide($params, $content = '', $template, &$repeat) {
	if($repeat) {
		\Clips\clips_context('indent_level', 1, true);
		return;
	}	
	$default = array(
		'class' => 'swiper-slide'
	);
	$dataImage = \Clips\get_default($params, 'data-image', null);
	$paginationImage = \Clips\get_default($params, 'data-pagination-image', null);
	$responsive = \Clips\get_default($params, 'responsive', false);
	$image = '';
	if($dataImage) {
		if ($responsive == "true") {
			$image = smarty_function_resimg(array('data-image'=>$dataImage, 'data-pagination-src'=>$paginationImage), $template);
		}
		else {
			$image = smarty_function_img(array('src'=>$dataImage, 'data-pagination-src'=>$dataImage), $template);
		}		
		unset($params['data-image']);
		unset($params['data-pagination-image']);
		unset($params['responsive']);		
	}

	\Clips\context_pop('indent_level');
	return \Clips\create_tag('div', $params, $default, $image.$content);
}