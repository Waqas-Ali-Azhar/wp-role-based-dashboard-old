<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class Dashboards_list extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Dashboard', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Dashboards', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

	}
	

	public function prepare_items(){
		
		// $this->_column_headers = $this->get_column_info();
		$columns = $this->get_records(10,1);
		print_r($columns);
		exit();
		// $hidden = $this->get_hidden_columns();
		// $sortable = $this->get_sortable_columns();
		// $this->_column_headers = array(
		// $columns,
		// $hidden,
		// $sortable
		// );
		// /** Process bulk action */
		// $this->process_bulk_action();
		// $per_page = $this->get_items_per_page('records_per_page', 10);
		// $current_page = $this->get_pagenum();
		// $total_items = self::record_count();
		// $data = self::get_records($per_page, $current_page);
		// $this->set_pagination_args(
		// ['total_items' => $total_items, //WE have to calculate the total number of items
		// 'per_page' => $per_page // WE have to determine how many items to show on a page
		// ]);
		// $this->items = $data;
	}
	

	/**
	 * @param  int $per_page
	 * @param  int $page_number
	 * @return mixed
	 */
	public function get_records ($per_page =10, $page_number=1){

		global $wpdb;
		$sql = "select * from " .$wpdb->prefix.DASHBOARD_TABLE;

		if(isset($_REQUEST['s'])){
			$sql.="where name like '%".$_REQUEST['s']."%'";
		}
		if(!empty($_REQUEST['orderby'])){
			$sql.='ORDER BY '.esc_sql($_REQUEST['orderby']);
			$sql.= !empty($_REQUEST['order']) ? ' ' .esc_sql($_REQUEST['order']) : ' ASC';
		}	
			$sql.= " Limit $per_page ";
			$sql.= " OFFSET ".($page_number-1) * $per_page;
			$result = $wpdb->get_results($sql,'ARRAY_A');

			print_r($result);
			exit();

			return $result;
		
	}

	public function get_columns(){

	}

	public function get_hidden_columns(){

	}

	public function get_sortable_columns(){

	}

	// public function column_cb(){

	// }
}



	function wprbd_list_form(){
		$dashboards_list = new Dashboards_list();
		$dashboards_list->prepare_items();

		
	}

?>