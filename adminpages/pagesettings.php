<?php
/**
 *
 * Basic Settings Page for WPRBD
 *
 */


if(!function_exists('current_user_can') ||( (!current_user_can('manage_options') ) && !current_user_can('wprbd_pagesettings') ) )
	die(__('You do not have permission to perform this oepration','wprbd'));


global $msg, $wprbd, $msgt;

/* get/set/settings */
global $wprbd_pages;


if(!empty($_REQUEST['savesetings'])){


}


?>

<form action="<?php echo admin_url('admin.php?page=wprbd-pagesettings'); ?>" method="post" enctype="multipart/formdata" >
	<?php wp_nonce_field('savesettings', 'wprbd_pagesettings_nonce');?>
	<table>
		<tr><td>Waqas</td></tr>
	</table>

</form>





