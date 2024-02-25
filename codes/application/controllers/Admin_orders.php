<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_orders extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Order');
        $this->count_status_items();
    }
	
    public function orders() {
        $data['order_data'] = $this->Order->fetch_orders();
        $data['statuses'] = array('Pending', 'On-Process', 'Shipped', 'Delivered');
        $data['order_count'] = count($data['order_data']);
        $data['status_counts'] = $this->status_counts;
        $this->load->view('admin_orders', $data);
    }
    

    public function index_html() {
        $data['order_data'] = $this->Order->fetch_orders();
        $data['statuses'] = array('Pending', 'On-Process', 'Shipped', 'Delivered');
        $this->load->view('order_results', $data);
    }

    public function search_orders() {
        $keyword = $this->input->get('search');
        $data['order_data'] = $this->Order->search_order($keyword);
        $data['statuses'] = array('Pending', 'On-Process', 'Shipped', 'Delivered');
        $this->load->view('order_results', $data);
    }

    public function filter_orders() {
        $status = $this->input->post('status_name');
        $data['order_data'] = $this->Order->filter_orders_by_status($status);
        $data['statuses'] = array('Pending', 'On-Process', 'Shipped', 'Delivered');
        $this->load->view('order_results', $data);
    }

    public function update_order_status($order_id) {
        $status = $this->input->post('status');
        $this->Order->update_order_status($status, $order_id);
        $data['order_data'] = $this->Order->fetch_orders();
        $data['statuses'] = array('Pending', 'On-Process', 'Shipped', 'Delivered');
        $this->load->view('order_results', $data);
    }

    private function count_status_items() {
        $this->status_counts = $this->Order->count_items_by_status();
    }
}

// public function search_by_name() {
//     $keyword = $this->input->get('search');
//     $product_data = $this->Product->search_by_product_name($keyword);
//     $view_data = $this->prepare_view_data($product_data);
//     $this->load->view('product_results', $view_data);
// }