<?php in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

function smarty_block_highlight($params, $content = '', $template, &$repeat) {
	if($repeat) {
		\Clips\clips_context('indent_level', 1, true);
		return;
	}	
	$highlightText = \Clips\context('highlight-text');
	if(!isset($highlightText)) {
		$highlightText = \Clips\get_default($params, 'text', '');
	}
	$tpl = \Clips\create_tag('span', array(
		'class' => 'highlight__content'
	), array(), $highlightText);
	$content = str_replace($highlightText, $tpl, $content);
	$default = array(
		'class' => 'highlight'
	);
	\Clips\context_pop('indent_level');
	return \Clips\create_tag('div', $params, $default, $content);
}