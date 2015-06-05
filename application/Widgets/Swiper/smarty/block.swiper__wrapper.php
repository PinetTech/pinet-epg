<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

\Clips\require_widget_smarty_plugin('swiper', 'swiper__slide');

function smarty_block_swiper__wrapper($params, $content = '', $template, &$repeat) {
	if($repeat) {
		\Clips\clips_context('indent_level', 1, true);
		return;
	}
	$default = array(
		'class' => 'swiper-wrapper'
	);

	$content = "\t".Clips\process_list_items($params, $content, $template);

	if(isset($params['items']))
		unset($params['items']);

	\Clips\context_pop('indent_level');
	return \Clips\create_tag('div', $params, $default, $content);
}