<?php
/**
 *
 * Wordpress Role Based Dashboard
 *
 */
	

	function wprbd_capabilities(){
		$wprbd_caps = array(
			'wprbd_pagesettings',
			'manage_options',

		);
		return $wprbd_caps;
	}

	function add_pages(){

		global $wpdb;

		$wprbd_caps = wprbd_capabilities();

		foreach ($wprbd_caps as $cap) {
			# code...
			if(current_user_can($cap)){
				$top_menu_cap = $cap;
				break;
			}
		}

		if(empty($top_menu_cap))
			return ;


		add_menu_page('WPRBD','WP Role Based Dashoard',$top_menu_cap,'wprbd_pagesettings','wprbd_dashboards','dashicons-group',20);

		add_submenu_page('wprbd_pagesettings','WordPress Role Based Dashboard Settings','Settings',$top_menu_cap,'wprbd_views','wprbd_settings');
	}


	

	add_action('admin_menu','add_pages');

 ?>