<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Product');
        $this->load->model('User');
        $this->load->model('Order');
		$this->load->helper('security');
        $this->load->library('upload');
    }
	
	public function get_csrf_token() {
		$token = $this->security->get_csrf_hash();
		echo json_encode(array('csrf_token' => $token));
	}

	public function index() {
        if ($this->input->get('page')) {
            $page = $this->input->get('page');
        } else {
            $page = 1;
        }
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $user_data = $this->prepare_user_data();
        $product_data = $this->Product->get_paginated_products($offset, $limit);
        $total_products = $this->Product->count_all_products();
        $total_pages = ceil(intval($total_products) / intval($limit));
        $pagination_links = array();
        for ($i = 1; $i <= $total_pages; $i++) {
            $pagination_links[] = array(
                'page_number' => $i,
                'url' => site_url('products/index?page=' . $i)
            );
        }
        $category_data = $this->Product->get_categories_with_product_count();
        $view_data = $this->prepare_view_data($product_data);
        $product_count = count($product_data);        
        $view_data = array(
            'user_data' => $user_data,
            'product_data' => $product_data,
            'category_data' => $category_data,
            'product_count' => $product_count,
            'total_products' => $total_products,
            'pagination_links' => $pagination_links,
            'page' => $page
        );
        $this->load->view('catalogue', $view_data);
    }

    public function index_html() {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $product_data = $this->Product->get_paginated_products($offset, $limit);
        $total_products = $this->Product->count_all_products();
        $total_pages = ceil(intval($total_products) / intval($limit));
        $pagination_links = array();
        for ($i = 1; $i <= $total_pages; $i++) {
            $pagination_links[] = array(
                'page_number' => $i,
                'url' => site_url('products/index_html?page=' . $i)
            );
        }
        $view_data = $this->prepare_view_data($product_data);
        $view_data['pagination_links'] = $pagination_links;
        $view_data['page'] = $page;
        $this->load->view('catalogue_results', $view_data);
    } 

    public function view_item($product_id) {
        $product_data = $this->Product->get_product_by_id($product_id);
        $product_image = $this->Product->get_productimage_by_id($product_id);
        $category = $this->Product->get_category_by_product_id($product_id);
        $similar_products = $this->Product->get_related_products($category, $product_id);
        $user_data = $this->prepare_user_data();
        $data = array(
            'product_data' => $product_data,
            'product_image' => $product_image,
            'similar_products' => $similar_products,
            'user_data' => $user_data
        );
        $this->load->view('product_view', $data);
    }

    public function search_by_name() {
        $keyword = $this->input->get('search');
        $product_data = $this->Product->search_by_product_name($keyword);
        $view_data = $this->prepare_view_data($product_data);
        $this->load->view('catalogue_results', $view_data);
    }

    public function filter_products() {
        $category_filter = $this->input->post('category_name');
        $product_data = $this->Product->get_products_by_category($category_filter);
        $view_data = $this->prepare_view_data($product_data);
        $this->load->view('catalogue_results', $view_data);
    }

    private function prepare_view_data($product_data) {
        $product_count = count($product_data);
        return array(
            'product_data' => $product_data,
            'product_count' => $product_count
        );
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