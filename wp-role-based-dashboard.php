<?php

/**
 * 
Plugin Name:       WordPress Role Based Dashboard
Plugin URI:        http://waqasali.pro
Description:       Provides facility to declared dashboards based on user roles 
and show content in blocks
Author:            Waqas Ali Azhar
Author URI:        http://waqasali.pro
Version:           1.0

 */

define('WPRBD_VERSION',1.0);
define('WPRBD_PLUGIN_DIR',dirname(__FILE__));
define('WPRBD_PLGUIN_URL',plugins_url('',__FILE__));

function wprbd_admin_init(){
	include_once WPRBD_PLUGIN_DIR . '/admin/wprbd-admin-pages.php';
}



function wprbd_init_frontend(){
	if ( ! function_exists( 'wprbd_theme' ) ) {
		include_once WPRBD_PLUGIN_DIR . '/template-wprbd.php';
	}
}


function wprbd_menu(){
	global $menu;


	
	
	$menu_placement = 1000;
	for ($i= 0; $i<$menu_placement; ++$i) {
		if(!isset($menu[$i])){
			
			//$menu_placement = $i;
			break;
		}
	}


	
	$list_page = add_menu_page(
		'WPRBD Dashboard',
		'WPRBD Dashboard',
		'manage-options',
		'wprbd-dashboard',
		'wprbd_page_handler','',$menu_placement
	);


	$create_page = add_submenu_page('wprbd-dashboard',
		'Create New Dashboard',
		'Add New',
		'manage_options',
		'wprbd-create',
		'wprbd_create_dashboard_page'
		);



}
add_action( 'init', 'wprbd_init_frontend' );
add_action('admin_menu','wprbd_menu',9999);
add_action( 'admin_init', 'wprbd_admin_init' );

?>