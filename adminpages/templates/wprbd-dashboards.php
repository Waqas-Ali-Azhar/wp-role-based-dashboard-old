<?php
/* List Down All Dashboards in a table */

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * 
 */
class Wprdb_List extends WP_List_Table
{
	
	public function __construct(argument)
	{
		parent::__construct([
			'singular' => __('Dashboard'),
			'plural' => __('Dashboards'),
			'ajax' => false
		]);
	}
}
?>
