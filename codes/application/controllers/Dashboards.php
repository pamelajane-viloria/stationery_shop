<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboards extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Product');
        $this->load->library('upload');
    }

	public function products() {
        $product_data = $this->Product->get_all_products();
        $category_data = $this->Product->get_categories_with_product_count();
        $view_data = $this->prepare_view_data($product_data);
        $view_data['category_values'] = array(
            1 => 'Stickers',
            2 => 'Pens',
            3 => 'Notebooks',
            4 => 'Tapes',
            5 => 'Organizers'
        );
        $view_data['category_data'] = $category_data;
        $this->load->view('admin_products', $view_data);
    }

    public function index_html() {
        $product_data = $this->Product->get_all_products();
        $view_data = $this->prepare_view_data($product_data);
        $this->load->view('product_results', $view_data);
    }

	public function search_by_name() {
        $keyword = $this->input->get('search');
        $product_data = $this->Product->search_by_product_name($keyword);
        $view_data = $this->prepare_view_data($product_data);
        $this->load->view('product_results', $view_data);
    }

	public function filter_products() {
        $category_filter = $this->input->post('category_name');
        $product_data = $this->Product->get_products_by_category($category_filter);
        $view_data = $this->prepare_view_data($product_data);
        $this->load->view('product_results', $view_data);
    }

	public function archive_product($product_id) {
		$this->Product->archive_product($product_id);
		$product_data = $this->Product->get_all_products();
        $view_data = $this->prepare_view_data($product_data);
        $this->load->view('product_results', $view_data);
	}

	public function get_product_data($product_id) {
		$product_data = $this->Product->get_product_by_id($product_id);
		$image_data = $this->Product->get_productimage_by_id($product_id);
        $data = array(
            'product_data' => $product_data,
            'image_data' => $image_data
        );
        echo json_encode($data);
	}

    // public function get_product_images($product_id) {
	// 	$product_images = $this->Product->get_productimage_by_id($product_id);
	// 	echo json_encode($product_images);
	// }
	
    public function edit_product($product_id) {
        $product_data = $this->input->post();
        $result = $this->Product->validate_product_data($product_data);
        if ($result !== null) {
            $this->session->set_flashdata('validation_errors', $result);
            redirect('/Dashboards/index_html');
        } else {
            $uploaded_images = $this->process_file_uploads(); 
            $result = $this->Product->update_product($product_id, $product_data, $uploaded_images);
            redirect('/Dashboards/products');
        }
    }
    

    public function add_product() {
        $post_data = $this->input->post();
        var_dump($post_data);
        // $result = $this->Product->validate_product_data($post_data);
        // if ($result !== null) {
		// 	$this->session->set_flashdata('validation_errors', $result);
		// 	redirect('/Dashboards/products');
		// } else {
        //     $uploaded_images = $this->process_file_uploads();
        //     $result = $this->Product->add_product($post_data, $uploaded_images);
		// 	redirect('/Dashboards/products');
		// }
    }
    
    private function process_file_uploads() {
        $uploaded_images = [];
        $config['upload_path'] = FCPATH . 'assets/images/products/';
        $config['allowed_types'] = 'gif|jpg|png|webp';
        $config['max_size'] = 10000; 
        $this->load->library('upload');
        $this->upload->initialize($config);
        $files = $_FILES['userfile'];
      
        if (!empty($files['name'][0])) {
          $file_count = count($files['name']);
      
          for ($i = 0; $i < $file_count; $i++) {
            $_FILES['userfile']['name'] = $files['name'][$i];
            $_FILES['userfile']['type'] = $files['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['error'][$i];
            $_FILES['userfile']['size'] = $files['size'][$i];
      
            if ($this->upload->do_upload('userfile')) {
              $upload_data = $this->upload->data();
              $filename = $upload_data['file_name'];
              $is_main = 0;
              $uploaded_images[] = array(
                'filename' => $filename,
                'is_main' => $is_main
              );
            } else {
              $error = array('error' => $this->upload->display_errors());
              print_r($error);
            }
          }
        } else {
          return false;
        }
        
        foreach ($uploaded_images as $i => $image) {
            $filename = $image['filename'];
            $is_main = 0; // Default value
            if (isset($_POST['main_image']) && in_array($filename, $_POST['main_image'])) {
                $is_main = 1;
            }
            $uploaded_images[$i]['is_main'] = $is_main;
        }
        return $uploaded_images;
      }
        
    private function prepare_view_data($product_data) {
        $product_count = count($product_data);
        return array(
            'product_data' => $product_data,
            'product_count' => $product_count
        );
    }
}