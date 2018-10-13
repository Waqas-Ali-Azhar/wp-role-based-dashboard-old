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
		
		//$this->_column_headers = $this->get_column_info();
		
		$columns = $this->get_columns();
		$hidden = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array(
		$columns,
		$hidden,
		$sortable
		);
		// /** Process bulk action */
		$this->process_bulk_action();
		$per_page = $this->get_items_per_page('records_per_page', 10);
		$current_page = $this->get_pagenum();
		$total_items = self::record_count();
		$data = self::get_records($per_page, $current_page);
		$this->set_pagination_args(
		['total_items' => $total_items, //WE have to calculate the total number of items
		'per_page' => $per_page // WE have to determine how many items to show on a page
		]);
		$this->items = $data;
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


			return $result;
		
	}

	/**
	 *
	 * Override parent columns to get your own column here 
	 * @return array
	 */
	
	public function get_columns(){

		$columns = array('cb' => '<input type="checkbox" />' ,
		'id' => __('ID','ux'),
		'name' => __('Name','ux'),
		'role' => __('User Role','ux'),
		'page' => __('Page URL','ux'),
		'created' => __('Date','ux')
		);

		return $columns;
	}

	/**
	 *
	 * Set if you need any hidden columns
	 *
	 */
	
	public function get_hidden_columns(){

		return array();

	}

	/**
	 *
	 * Columns to make sortable
	 * @return  array
	 */
	

	public function get_sortable_columns(){

		$sortable_columns = array(
			'id' => array('id',true),
			'name' => array('name',true),
			// 'role' => array('role',false),
			// 'page' => array('page',false),
		);

		return $sortable_columns;

	}



	 function column_cb($items){
	 	return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />',$items['id']);
	 }

	 function column_name($items){
	 	return sprintf('<a href="%s" class="btn btn-primary" />%s</a>',$items['name'],$items['name']);
	 }

	 function column_id($items){
	 	return sprintf('<a href="%s" class="btn btn-primary" />%s</a>',$items['id'],$items['id']);
	 }

	 public function get_bulk_actions(){
	 	$actions = ['bulk-delete' => 'Delete'];
	 	return $actions;
	 }

	 public function process_bulk_action(){
	 	if('delete' === $this->current_action()){
	 		$nonce = esc_attr($_REQUEST['_wpnonce']);
	 		if(!wp_verify_nonce($nonce,'bx_delete_records'))
	 			die('Hey Come on');
	 		else{
	 			self::delete_records(absint($_GET['record']));
	 			$redirect = admin_url('admin.php?page=dashboard');
	 			wp_redirect($redirect);
	 			exit;
	 		}
	 	}

	 	if(isset($_POST['action'])){
	 		if($_POST['action'] == 'bulk-delete' || $_POST['action2'] =='bulk-delete'){
	 			$delete_ids = esc_sql($_POST['bulk-delete']);
	 			foreach ($delete_ids as $ids) {
	 				# code...
	 				self::delete_records($id);
	 			}
	 			$redirect = admin_url('admin.php?page=dashboard');
	 			wp_redirect($redirect);
	 			exit;
	 		}
	 	}
	 }

	 public static function delete_records($id){
	 	global $wpdb;
	 	$wpdb->delete($wpdb->prefix.DASHBOARD_TABLE,['id'=>$id],['%d']);
	 } 

	 public function no_items(){
	 	_e('No Records are found in database.','ux');
	 }

	 public function record_count(){
	 	global $wpdb;
	 	$sql = "Select COUNT(*) from ".$wpdb->prefix.DASHBOARD_TABLE;
	 	return $wpdb->get_var($sql);
	 }
}



	function wprbd_list_form(){
		$dashboards_list = new Dashboards_list();
		$dashboards_list->prepare_items();
		if( !isset( $_REQUEST['noheader'] ) ){
			?>
			<div class="wrap">
				<div id="icon-tools" class="icon32"><br/></div>
				<h2>Custom Dashboards <a class="add-new-h2"
			                      href="admin.php?page=dashboard-create">Add New</a>
			</h2>
			<form id="search-dashboard-filter" method="get">
				<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
				<?php $dashboards_list->search_box( 'Search', 'post' ); ?>
			</form> 	

			<form id="dashboard-filter">
				<input type="hidden" name="page"
				       value="<?php echo $_REQUEST['page'] ?>"/>
				<input type="hidden" name="noheader" value="true"/>
				<!-- Now we can render the completed list table -->
				<?php $dashboards_list->display() ?>
			</form>
		</div>
			<?php
		}



		
	}

?>