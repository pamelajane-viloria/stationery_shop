<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Order');
		$this->load->model('User');
    }
	
	public function index() {
		$user_data = $this->prepare_user_data();
		$user_id = $this->session->userdata('user_id');
		$cart_data = $this->Order->get_cart_items_by_user_id($user_id);
		$data = array(
            'user_data' => $user_data,
			'cart_data'=> $cart_data
        );
		$this->load->view('cart', $data);
	}

	public function index_html() {
		$user_data = $this->prepare_user_data();
		$user_id = $this->session->userdata('user_id');
		$cart_data = $this->Order->get_cart_items_by_user_id($user_id);
		$data = array(
            'user_data' => $user_data,
			'cart_data'=> $cart_data
        );        
		$this->load->view('cart_results', $data);
    }

	public function add_to_cart($product_id) {
		$post_data = $this->input->post();
		$user_id = $this->session->userdata('user_id');
		$this->Order->add_to_cart($post_data, $product_id, $user_id);
		redirect('/Products/view_item/' . $product_id);
	}

	public function archive_order($cart_id) {
		$this->Order->archive_order_by_id($cart_id);
		redirect('/Orders/index_html');
	}

	public function update_product_quantity($cart_id) {
		$item_data = $this->input->post();
		$this->Order->edit_product_quantity($item_data, $cart_id);
		$user_data = $this->prepare_user_data();
		$user_id = $this->session->userdata('user_id');
		$cart_data = $this->Order->get_cart_items_by_user_id($user_id);
		$data = array(
            'user_data' => $user_data,
			'cart_data'=> $cart_data
        );        
		$this->load->view('cart_results', $data);
	}

	public function search_by_name() {
		$user_data = $this->prepare_user_data();
		$keyword = $this->input->get('search');
		$user_id = $this->session->userdata('user_id');
		$cart_data = $this->Order->search_by_product_name($keyword, $user_id);
		$data = array(
            'user_data' => $user_data,
			'cart_data'=> $cart_data
        );        
		$this->load->view('cart_results', $data);
	}
	
	public function checkout($user_id) {
		$order_data = $this->input->post();
		$this->Order->insert_order($order_data, $user_id);
	}

	public function pay_order($user_id) {
		$stripeToken = $this->input->post('stripeToken');		
		$payment_data = $this->input->post('card_name');
		$order_data = array(
			'payment_data' => $payment_data,
			'stripe_token' => $stripeToken,
		);
		$this->Order->insert_payment($order_data);
		redirect('/Products');
	}

    private function prepare_user_data() {
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $user_data = $this->User->get_user_data_by_id($user_id);
            $user_item_count = $this->Order->count_items_by_user($user_id);
            if (!empty($user_item_count)) {
				$user_item_count = $user_item_count[0]['item_count'];
			} else {
				$user_item_count = 0;
			}
            $data = array(
                'user_data' => $user_data,
                'user_item_count' => $user_item_count
            );
        } else {
            redirect('/Users/login');
        }
        return $data;
    }
}