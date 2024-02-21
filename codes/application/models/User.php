<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function get_user_by_email($email) { 
        $query = "SELECT * FROM Users WHERE email = ?";
        $user_email = $this->security->xss_clean($email);
        $result_array = $this->db->query($query, array($user_email))->result_array();
        if (!empty($result_array)) {
            return $result_array[0];
        } else {
            return null;
        }
    }

    public function validate_registration($email) {
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');        
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if(!$this->form_validation->run()) {
            return validation_errors();
        } else if($this->get_user_by_email($email)) {
            return "Email already taken.";
        }
        return null;
    }

    public function create_user($form_data) {
        $query = "INSERT INTO Users (first_name, last_name, email, password, created_at, updated_at) VALUES (?,?,?,?,NOW(),NOW())";
        $values = array(
            $this->security->xss_clean($form_data['first_name']), 
            $this->security->xss_clean($form_data['last_name']), 
            $this->security->xss_clean($form_data['email']), 
            md5($this->security->xss_clean($form_data["password"])),
        ); 
        return $this->db->query($query, $values);
    }

    public function validate_login($email, $password) {
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            return validation_errors();
        } else {
            if ($this->get_user_by_email($email) == null) {
                return "User not found.";
            } else {
                return true;
            }
        }
    }
    
    function login($user, $password) {
        $entered_password_hash = md5($this->security->xss_clean($password));
        if ($user['password'] === $entered_password_hash) {
            return true;
        } else {
            return "Incorrect email/password.";
        }
    }
    
}