<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_model{
	public function register($new_user){
		$query = "INSERT INTO users (first_name, last_name, email, password, dob, created_at, updated_at) VALUES (?, ? ,? , ? , ?, NOW(), NOW());";
		$this->load->library("form_validation");
		$config = array(
			   	array(
                     'field'   => 'email', 
                     'label'   => 'Email Address', 
                     'rules'   => 'required|valid_email|is_unique[users.email]|xss_clean'
                  	),
               	array(
                     'field'   => 'first_name', 
                     'label'   => 'First Name', 
                     'rules'   => 'required|xss_clean'
                  	),
               	array(
                     'field'   => 'last_name', 
                     'label'   => 'Last Name', 
                     'rules'   => 'required|xss_clean'
                  	),
               	array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'required|xss_clean|min_length[8]'
                 	),
              	 array(
                     'field'   => 'password_conf', 
                     'label'   => 'Password Confirmation', 
                     'rules'   => 'required|matches[password]|xss_clean'
                  	),
              	 array(
                     'field'   => 'dob', 
                     'label'   => 'Date of Birth', 
                     'rules'   => 'required|xss_clean'
                  	)
            	);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
				redirect('');
			} else {
				$date = strtotime($new_user['dob']);
				$new_date = date( 'Y-m-d H:i:s', $date );
				$new_user['dob'] = $new_date;
				$new_user['password'] = md5($new_user['password']);
				$user = array($new_user['first_name'], $new_user['last_name'], $new_user['email'], $new_user['password'], $new_user['dob']);
				$this->db->query($query, $user);
				$this->session->set_flashdata('success', "<p>You've been registered successfully, and may login</p>");
			}
	}
	public function login($user){
		$user['password'] = md5($user['password']);
		$query = $this->db->query("SELECT * FROM users WHERE email = '{$user['email']}'")->row_array();
		$this->load->library("form_validation");
		$config = array(
			   	array(
                     'field'   => 'email', 
                     'label'   => 'Email Address', 
                     'rules'   => 'required|valid_email|xss_clean'
                  	),
			   	array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'required|xss_clean|min_length[8]'
                 	)
				);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
				redirect('');
			} else if ($query == NULL || $user['password'] !== $query['password']){
				$this->session->set_flashdata('errors', '<p>Email/Password Combination is incorrect</p>');
				redirect('');
			} else {
				$this->session->set_userdata('logged', $query);
				redirect('/users/home');
			}

	}
	public function friends($id){
		$query = "SELECT * FROM users JOIN friends on users.id = user_id JOIN users as users_friends ON users_friends.id = friend_id WHERE users.id = {$id}";
		return $this->db->query($query)->result_array();
	}
	public function get_all($user_id){
		return $this->db->query("SELECT users.id, first_name, last_name FROM users WHERE users.id != {$user_id} AND users.id NOT IN (SELECT friend_id FROM friends WHERE user_id = {$user_id})")->result_array();
	}
	public function profile($id){
		return $this->db->query("SELECT first_name, last_name, email FROM users where id = {$id}")->row_array();
	}
	public function add($friend_id, $user_id){
		$this->db->query("INSERT INTO friends (user_id, friend_id) VALUES ({$user_id}, {$friend_id})");
		$this->db->query("INSERT INTO friends (user_id, friend_id) VALUES ({$friend_id} , {$user_id})");
	}
	public function remove($friend_id, $user_id){
		$this->db->query("DELETE FROM friends where friend_id = {$friend_id} AND user_id = {$user_id}");
		$this->db->query("DELETE FROM friends where friend_id = {$user_id} AND user_id = {$friend_id}");
	}
}