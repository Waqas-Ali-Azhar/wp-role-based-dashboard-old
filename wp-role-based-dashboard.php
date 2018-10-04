<?php
/*
Plugin Name:  WP Role Based Dashboard
Plugin URI:   https://waqasali.pro/projects/wp-role-based-dashboard
Description:  Create Multiple Dashboards Based On User Roles
Version:      1.0
Author:       Waqas Ali
Author URI:   https://waqasali.pro
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wp-role-based-access
Domain Path:  /languages
*/

/**
* No Script Kiddies
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* WPRBD PATH */
define('WPRBD_PATH',dirname(__FILE__).'/');

/* WPRBD version */
define('WPRBD_VERSION','1.0');

/* WPRBD Uri Constant */
define('WPRBD_DIR',plugin_dir_url(__FILE__));

/* WPRBD Options Slug */
define('WPRBD_OPTIONS_SLUG','wprbd_options');


/* Data Constants */

require_once(WPRBD_PATH . 'includes/constants.php');


/* Initialize Admin */

require_once(WPRBD_PATH . 'includes/adminpages.php');

/* All Admin Functions */
require_once(WPRBD_PATH . 'adminpages/callbacks.php');





/* Plugin Activation Hooks */
function wprbd_register_activaton(){
	global $wpdb;
	$tableName = $wpdb->prefix.DASHBOARD_TABLE;
	$sql = "CREATE TABLE ".$tableName."(
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	user_role text NOT NULL,
	data text Not Null,
	UNIQUE KEY id (id)
	)";

	require_once(ABSPATH."wp-admin/includes/upgrade.php");
	dbDelta( $sql );

}

register_activation_hook(__FILE__,'wprbd_register_activaton');



/**
 *
 * Adding menu pages for plugin settings
 *
 */

function wprbd_menu_pages(){

	add_menu_page('WPRBD Settings','WPRBD','manage_options','wprbd','wprbd_settings_page',WPRBD_PATH.'images/icon_wrapper.png',20);

}
/**
 *
 * Menu Page Output
 *
 */


function wprbd_settings_page(){

}

//add_action('admin_menu','wprbd_menu_pages')




?>