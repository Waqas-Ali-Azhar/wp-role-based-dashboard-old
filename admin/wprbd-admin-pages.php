<?php

function wprbd_page_handler(){
	include WPRBD_PLGUIN_DIR.'/admin/templates/page-dashboards-list.php';	

	$redirect = FALSE;

	if(isset($_GET['action'])){
		$redirect = TRUE;
		switch( $_GET['action'] ){
			case 'create':

				$new_dashboard_id = wprbd_insert_new_dashboard( $_POST );

				wprbd_admin_redirect( $new_dashboard_id );

			break;
		}
	}
	
}




function wprbd_create_dashboard_page(){
	global $wp_roles;
	$user_roles = $wp_roles->role_names;
	$args = array(
		'title'   => 'Create Dashboard',
		'content' => wprbd_theme( 'create_dashboard', array('user_roles'=>$user_roles) )
	);



	print wprbd_theme( 'admin_wrapper', $args );
}
?>