<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct() {
        parent::__construct();
        // $this->load->model('');
    }
	
	public function login() {
		$this->load->view('login');
	}

	public function register() {
		$this->load->view('signup');
	}

}