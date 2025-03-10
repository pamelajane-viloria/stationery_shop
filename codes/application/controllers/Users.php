<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('User');
    }
	
	public function login() {
		$this->load->view('login');
	}

	public function register() {
		$this->load->view('signup');
	}

	public function process_registration() {
		$email = $this->input->post('email');
		$result = $this->User->validate_registration($email);
		if($result != null) {
			$this->session->set_flashdata('input_errors', $result);
			redirect("/");
		} else {
			$form_data = $this->input->post();
			$this->User->create_user($form_data);
			redirect("login");
		}
	}

	public function login_user() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = $this->User->validate_login($email, $password);
		if ($result !== true) {
			$this->session->set_flashdata('validation_errors', $result);
			redirect('/Users/login');
			return;
		}
		$user = $this->User->get_user_by_email($email);
		$user_level = $this->User->login($user, $password);
	
		if ($user_level === "Incorrect email/password.") {
			$this->session->set_flashdata('validation_errors', $user_level);
			redirect('/Users/login');
			return;
		}
		if ($user_level === 'admin') {
			$this->session->set_userdata('user_id', $user['user_id']);
			redirect('/Admin_orders/orders');
		} else {
			$this->session->set_userdata('user_id', $user['user_id']);
			redirect('/Products');
		}
	}
	
	public function logout() {
		$this->session->unset_userdata('user_id');
		redirect('/Users/login');
	}
}