<?php

function wprbd_theme($template_name='',$arguments = array()){


	if(is_null($arguments)){
		$arguments = array();
	}


	
	$wprbd_templates = wprbd_templates();

	if(isset($wprbd_templates[$template_name]) and is_array($wprbd_templates[$template_name])){

		$wprbd_template = $wprbd_templates[$template_name];
		$wprbd_template['name'] = $template_name;


		if(!isset($wprbd_template['arguments']) || !is_array($wprbd_template['arguments'])){
			$wprbd_template['arguments'] = array();
		}

		$wprbd_template['arguments'] = array_merge($wprbd_template['arguments'],$arguments);
		
		//allow other plugins to alter the template before rendering
		$wprbd_template = apply_filters('wprbd_pre_process_template',$wprbd_template);

		if($theme = wprbd_process_template($wprbd_template)){
			return $theme;

		}
	}

	wprbd_find_template( $wprbd_template );


		// for other means of processing or information
		if ( isset( $wprbd_template['arguments']['wprbd_action'] ) && $wprbd_template['arguments']['wprbd_action'] == 'find_only' ) {
			return $wprbd_template;
		}
	

		// echo '<pre>';
		// print_r($wprbd_template['arguments']);
		// echo '</pre>';
		// exit();



	if(isset($wprbd_template['found_path']) && $wprbd_template['found_path']!='' )
	{
		//apply_filters('wprbd_pre_render_template',$tw_template);

		ob_start();

		extract($wprbd_template['arguments']);

		include $wprbd_template['found_path'];

		$theme = ob_get_clean();

		return $theme;
	}

}

/**
 *
 * 	Look for non-wordpress preprocess functions
 * 
 */

function wprbd_process_template(&$template){
	$theme_folder = explode("/",STYLESHEETPATH);
	$theme_folder = array_pop($theme_folder);

	if(!isset($template['default_path'])){
		$bt = debug_backtrace();
		$caller = array_shift($bt);

		$template['default_path'] = dirname($caller['file']);
	}

	if(isset($template['includes']) && is_array($template['includes'])){
		foreach($template['includes'] as $include_file_location){
			@include_once $include_file_location;
		}
	}

	if(function_exists($theme_folder.'_'. $template_name.'_preprocess')){
		$preprocess = $theme_folder.'_'.$template['name'].'_preprocess';
		$template = call_user_func($preprocess,$template);
	}
	else if(function_exists('theme'.'_'.$template['name'].'_preprocess')){
		$preprocess = 'theme_'.$template['name'].'_preprocess';
		$template = call_user_func($preprocess,$template);
	}

	if(!isset($template['files'])){
		//look for theme folder name namebased suggestions
		//
		if(function_exists($theme_folder.'_'.$template['name'])){
			return call_user_func($theme_folder.'_'.$template['name'],$template['arguments']);
		}
		else if(function_exists('theme_'.$temlate['name'])){
			return call_user_func('theme_'.$template_name['name'],$template['arguments']);
		}
	}

	else if(!is_array($template['files'])){
		$template['files'] = array($template['files']);
	}





}

function wprbd_find_template(&$template){

	// loop through and find suggested templates
	$found_path = '';

	foreach ( $template['files'] as $suggestion ) {
		$replace_count = 0;
		$tokens_count  = 0;



		// look for an argument in template suggestions
		if ( preg_match( '/\[.*\]/', $suggestion ) ) {

			$tokens_count = substr_count( $suggestion, '[' );
			
			// we have arguments, lets build the possibilities
			$search  = array();
			$replace = array();
			foreach ( $template['arguments'] as $key => $value ) {
				// only apply to strings and numerics
				if ( is_string( $template['arguments'][ $key ] ) || is_numeric( $template['arguments'][ $key ] ) ) {
					if ( trim( $template['arguments'][ $key ] ) ) {
						$search[]  = '[' . $key . ']';
						$replace[] = $value;
					}
				}
			}

			// do the replacement
			$suggestion = str_replace( $search,
				$replace,
				$suggestion,
				$replace_count );
		}



		// only accept a suggestion if all tokens were replaced
		if ( $tokens_count == 0 || ( $replace_count > 0 && $tokens_count == $replace_count ) ) {
			$template['suggestions'][] = $suggestion;

		}
	}



	// loop through suggestions and find existing template in theme path first
	foreach ( $template['suggestions'] as $suggestion ) {
		// easier to read this way
		
		$theme_path = locate_template( $suggestion, FALSE, FALSE );
		


		// look in the theme folder
		if ( file_exists( $theme_path ) ) {
			$template['found_path']       = $theme_path;
			$template['found_suggestion'] = $suggestion;
			break;
		}
	}

	if ( ! isset( $template['found_path'] ) ) {
		// loop through suggestions and find existing template in default path
		foreach ( $template['suggestions'] as $suggestion ) {
			$default_path = rtrim( $template['default_path'] ) . '/' . $suggestion;

			// look for file in default path
			if ( file_exists( $default_path ) ) {
				$template['found_path']       = $default_path;
				$template['found_suggestion'] = $suggestion;
				break;
			}
		}
	}
}


/**
 * Hook For adding templates to the Syste,
 *
 *  @return array All templates
 */

function wprbd_templates(){


	$templates = apply_filters('wprbd_templates',array());
	
	return $templates;

}
?>