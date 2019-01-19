<?php

function wprbd_theme($template_name='',$arguments = array()){

	if(is_null($arguments)){
		$arguments = array();


	}


	$wprbd_templates = wprbd_templates();
	


	wprbd_find_tempalte($tw_template);
	if(isset($tw_template['found_path']) && $tw_template['found_path']!='' )
	{
		apply_filters('wprbd_pre_render_template',$tw_template);

		ob_start();

		extract($tw_template['arguments']);

		include $tw_template['found_path'];

		$theme = ob_get_clean();

		return $theme;
	}

}
?>