<?php


add_action('wprbd_templates','wprbd_admin_templates');

function wprbd_admin_templates($templates){

	$templates['create_dashboard'] = array(
		'files' => 'admin/templates/form-create-dashboard.php',
		'default_path' => WPRBD_PLUGIN_DIR,
		'arguments' => array('options' => NULL)
	);

		// generic admin page wrapper
	$templates['admin_wrapper'] = array(
		'files'        => array(
			'admin/templates/page-admin-wrapper.php',
		),
		'default_path' => QW_PLUGIN_DIR,
		'arguments'    => array(
			'title'   => 'Admin Page',
			'content' => 'content goes here.',
		),
	);

	return $templates;

}


function wprbd_insert_new_dashboard(){
	global $wpdb;
	$table_name = $wpdb->prefix . "wprbd_dashboards";

	$values = array(
		'name' => $post['dash-name'],
		'user_role' => $post['user-role'],
		'path' => $post['path']
	);

	$wpdb->insert($table_name,$values);
	return $wpdb->insert_id;
}

/**
 * 
 */

function wprbd_admin_redirect($dashboard_id = NULL,$page='wprbd-dashboard'){
	$url = admin_url("admin.php?page=$page");

	if($dashboard_id){
		$url .='&edit='.(int) $dashboard_id;
	}

	wp_redirect($url);
	exit();
}


?>