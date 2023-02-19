<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agreement extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check_user(); // check login auth
	}

	//----------------------------------------------------------------
	public function index(){

		$data['title'] = 'User Agreement';

		$this->load->view('user/includes/_header');
		$this->load->view('user/agreement/index');
		$this->load->view('user/includes/_footer');
	}

	//---------------------------------------------------------------
	public function profile(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/profile', $data);
		$this->load->view('admin/includes/_footer');
	}

	//---------------------------------------------------------------
	public function login(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;

		$this->load->view('admin/includes/_header' , $data);
		$this->load->view('admin/pages/login', $data);
		$this->load->view('admin/includes/_footer' , $data);
	}

	//---------------------------------------------------------------
	public function register(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;

		$this->load->view('admin/includes/_header' , $data);
		$this->load->view('admin/pages/register', $data);
		$this->load->view('admin/includes/_footer' , $data);
	}

	//---------------------------------------------------------------
	public function lockscreen(){

		$data['title'] = '';
		$data['navbar'] = false;
		$data['sidebar'] = false;
		$data['footer'] = false;
		
		$this->load->view('admin/includes/_header' , $data);
		$this->load->view('admin/pages/lockscreen', $data);
		$this->load->view('admin/includes/_footer' , $data);

	}

	

	//---------------------------------------------------------------
	public function pace(){

		$data['title'] = '';

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/pages/pace', $data);
		$this->load->view('admin/includes/_footer');
	}

}

?>