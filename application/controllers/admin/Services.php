<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Services extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();

		$this->load->model('admin/services_model', 'services_model');
		$this->load->model('admin/Activity_model', 'activity_model');
	}

	//-----------------------------------------------------------
	public function index(){

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/services/services_list');
		$this->load->view('admin/includes/_footer');
	}
	
	public function datatable_json(){				   					   
		$records['data'] = $this->services_model->get_all_services();
		$data = array();

		$i=0;
		foreach ($records['data']   as $row) 
		{  
			$status = ($row['is_active'] == 1)? 'checked': '';
			$data[]= array(
				++$i,
				$row['title'],
				$row['description'],
				'<input class="tgl_checkbox tgl-ios" 
				data-id="'.$row['id'].'" 
				id="cb_'.$row['id'].'"
				type="checkbox"  
				'.$status.'><label for="cb_'.$row['id'].'"></label>',
				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('admin/services/edit/'.$row['id']).'"> <i class="fa fa-pencil-square-o"></i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------------
	function change_status()
	{   
		$this->services_model->change_status();
	}

	public function add(){
		
		$this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('description', 'Description', 'trim|required');
			$this->form_validation->set_rules('rate', 'Rate', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect(base_url('admin/services/add'),'refresh');
			}
			else{
				$data = array(
					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'rate' => $this->input->post('rate')
				);
				$data = $this->security->xss_clean($data);
				$result = $this->services_model->add_service($data);
				if($result){

					$this->session->set_flashdata('success', 'Service has been added successfully!');
					redirect(base_url('admin/services'));
				}
			}
		}
		else{
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/services/services_add');
			$this->load->view('admin/includes/_footer');
		}
		
	}

	public function edit($id = 0){

		// $this->rbac->check_operation_access(); // check opration permission

		if($this->input->post('submit')){
			$this->form_validation->set_rules('user_id', 'Name', 'trim|required');
			$this->form_validation->set_rules('rate', 'Rate', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('admin/services/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'user_id' => $this->input->post('user_id'),
					'rate' => $this->input->post('rate'),
					'service_id' => $id,
				);
				$data = $this->security->xss_clean($data);
				$result = $this->services_model->add_service_rate($data, $id);
				if($result){
					// Activity Log 
					// $this->activity_model->add_log(2);

					$this->session->set_flashdata('success', 'User Rate has been added successfully!');
					redirect(base_url('admin/services/edit/'.$id),'refresh');
				}
			}
		}
		else{
			$data['service_users'] = $this->services_model->get_service_users($id);
			
			$data['remaining_users'] = $this->services_model->get_remaining_users($id);
			// print_r($data['remaining_users']);die;
			$data['service_id'] = $id;
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/services/service_edit', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	public function delete($id = 0)
	{
		$this->rbac->check_operation_access(); // check opration permission
		
		$this->db->delete('ci_users', array('id' => $id));

		// Activity Log 
		$this->activity_model->add_log(3);

		$this->session->set_flashdata('success', 'Use has been deleted successfully!');
		redirect(base_url('admin/users'));
	}

}


?>