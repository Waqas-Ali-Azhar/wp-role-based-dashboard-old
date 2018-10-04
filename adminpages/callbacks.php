<?php
/* All admin page menu callback are listed here */

/* All Dashboard */

function wprbd_dashboards(){
	require_once(WPRBD_PATH.'adminpages/dashboards.php');
	wprbd_list_form();
	


}

function wprbd_views(){
		require_once(WPRBD_PATH.'adminpages/pagesettings.php');

	}

?>