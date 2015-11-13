<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
	}
	public function register(){
		$new_user = $this->input->post();
		$this->load->model('user');
		$this->user->register($new_user);
		redirect('');
	}
	public function login(){
		$user = $this->input->post();
		$this->load->model('user');
		$this->user->login($user);
	}
	public function home(){
		$user = $this->session->userdata('logged');
		$this->load->model('user');
		$friends = array('friends' => $this->user->friends($user['id']), 'others' => $this->user->get_all($user['id']));
		$this->load->view('home', $friends);
	}
	public function profile($id){
		$this->load->model('user');
		$profile = array('profile' => $this->user->profile($id));
		$this->load->view('profile', $profile);
	}
	public function add($friend_id){
		$user = $this->session->userdata('logged');
		$this->load->model('user');
		$this->user->add($friend_id, $user['id']);
		redirect('/users/home');
	}
	public function remove($friend_id){
		$user = $this->session->userdata('logged');
		$this->load->model('user');
		$this->user->remove($friend_id, $user['id']);
		redirect('/users/home');
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('');
	}
}
