<?php

function wprbd_page_handler(){
	include WPRBD_PLGUIN_DIR.'/admin/templates/page-dashboards-list.php';	
	
}



function wprbd_create_dashboard_page(){
	$args = array(
		'title'   => 'Create Dashboard',
		'content' => theme( 'create_dashboard' )
	);

	print theme( 'admin_wrapper', $args );
}
?>