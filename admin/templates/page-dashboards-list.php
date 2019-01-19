<?php


if(!class_exists('WP_List_Table')){
	require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');
}


class Wprbd_list_table extends WP_List_Table{

	global $status,$page;

	parent::_constructor(array(
		'singular' => 'dashboard',
		'plural' => 'dashboards'
		'ajax'=> FALSE
	));



}


function column_default( $item , $column_name){

	switch($columns_name){

		case 'id':
			return '<a href="?page=wprbd-dashboard&edit'.$item['id'].'">
          '.$item['id'].'</a>';
		break;
		case 'name':

			return '<a href="?page=wprbd-dashboard&edit'.$item['id'].'">
          '.ucfirst($item['name']).'</a>';

		case 'user_role':
			return ucfirst($item['user_role']);

		case 'edit':
		break;

		case 'delete':
		break;

		default:
		return print_r($item,TRUE);

	}

}


 function column_name(){

 	$actions = array(
 		'edit' => sprintf('<a href="?page=%s&edit%s"></a>',
 			$_REQUES['page'],
 			$item['id']
 		),

 		'delete' => sprintf('<a href="?page=%s&delete=%s"',
 			$_REQUEST['page'],
 			$item['id']
 		)
 	);

 	return $this->row_actions($actions);
 }

 function column_cb($item){
 	return sprintf('<input type="checkbox" name="%1$s[]" value="%2$s[]" />',
 		$this->_args['singluar'],
 		$item['id']

 	);
 }



 function get_columns(){
 	$columns = array(
 		'cb' => '<input type="checkbox" />',
 		'name' => 'Name',
 		'user roles' => 'User Roles',
 		'edit' => 'Edit Link'
 	);

 	return $columns;
 }

 function get_sortable_columns(){
 	$sortable_columns = array(
 		'name' => array('name', TRUE),
 		'user_roles' => array('user_role', FALSE)
 	);

 	return $sortable_columns;
 }

 function get_bulk_actions(){

 	$actions = array(
 		'delete' => 'Delete'
 	);

 	return $actions;

 }


 function process_bulk_actions(){

 }


 function prepare_items(){

 	$per_page = 12;

 	$columns = this->get_columns();
 	$hidden = array();
 	$sortable = this->get_sortable_columns();

 	$this->_colums_headers = array($columns, $hidden, $sortable);

 	$this->process_bulk_actions();

 	global $wpdb;

 	$sql = "SELECT `id` , `name` , `user_role` FROM {$wpdb->prefix}_wprbd_dashboards"; 
 	$args = array();

 	if(!empty($_REQUEST['s'])){

 		$sql.='WHERE `name` LIKE %s';
 		$args[] = '%'.$wpdb->esc_like(trim($_REQUEST['s'])).'%';

 	}

 	$orderby ='name';
 	if(!empty($_REQUEST['orderby'])) &&
 		in_array($_REQUEST['orderby'],array('name','user_role')){
 			$ordery = $_REQUEST['orderby'];
 	}

 	$order = 'ASC';
 	if( !empty($_REQUEST['order']) && strtolower($_REQUEST['order']=='desc')){
 		$order = 'DESC';
 	}

 	$sql.="orderby {$order}";

 	$args[] = $orderby;

 	$sql = $wpdb->prepare($sql,$args);

 	$data = $wpdb->get_results($sql, ARRAY_A);

 	$current_page = $this->get_pagenum();

 	$total_items = count( $data );

 	$data = array_slice($data,($current_page - 1) * $per_page),$per_page);

 }

?>