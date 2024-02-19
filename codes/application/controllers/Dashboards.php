<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboards extends CI_Controller {

	public function __construct() {
        parent::__construct();
        // $this->load->model('');
    }
	
	public function orders() {
		$this->load->view('admin_orders');
	}

	public function products() {
		$this->load->view('admin_products');
	}

}