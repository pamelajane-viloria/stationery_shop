<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Product');
		$this->load->helper('security');
    }
	
	public function get_csrf_token() {
		$token = $this->security->get_csrf_hash();
		echo json_encode(array('csrf_token' => $token));
	}

	public function index() {
        $product_data = $this->Product->get_all_products();
        $category_data = $this->Product->get_categories_with_product_count();
        $view_data = $this->prepare_view_data($product_data);
        $view_data['category_data'] = $category_data;
        $this->load->view('catalogue', $view_data);
    }

    public function index_html() {
        $product_data = $this->Product->get_all_products();
        $view_data = $this->prepare_view_data($product_data);
        $this->load->view('catalogue_results', $view_data);
    }

    public function view_item($product_id) {
        $product_data = $this->Product->get_product_by_id($product_id);
        $product_image = $this->Product->get_productimage_by_id($product_id);
        $category = $this->Product->get_category_by_product_id($product_id);
        $similar_products = $this->Product->get_related_products($category, $product_id);
        $this->load->view('product_view', array('product_data' => $product_data, 'product_image' => $product_image, 'similar_products' => $similar_products));
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
}