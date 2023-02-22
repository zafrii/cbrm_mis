<?php
	class Services_model extends CI_Model{

		public function add_service($data){
			$this->db->insert('services', $data);
			return true;
		}

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_services(){
			$this->db->select('*');
			return $this->db->get('services')->result_array();
		}


		//---------------------------------------------------
		// Get user detial by ID
		public function get_user_by_id($id){
			$query = $this->db->get_where('ci_users', array('id' => $id));
			return $result = $query->row_array();
		}

		public function get_service_users($service_id){
			// $query = $this->db->get_where('services_rate', array('service_id' => $service_id));
			// return $query->row_array();
			return 
			$this->db->select('u.id, u.firstname, u.lastname, sr.rate, sr.date_created')->from('ci_users u')
			->join('services_rate sr', 'sr.user_id = u.id', 'left')
			->where("u.id in (select user_id from services_rate where service_id = $service_id)")
			->where("sr.service_id", $service_id)
			->get()->result_array();
		}

		public function get_remaining_users($service_id){
			return 
			$this->db->select('u.id, u.firstname, u.lastname, sr.rate')->from('ci_users u')
			->join('services_rate sr', 'sr.user_id = u.id', 'left')
			->where("u.id not in (select user_id from services_rate where service_id = $service_id)")
			->get()->result_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_user($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_users', $data);
			return true;
		}
		
		public function add_service_rate($data){
			$this->db->insert('services_rate', $data);
			return true;
		}

		//---------------------------------------------------
		// Change user status
		//-----------------------------------------------------
		function change_status()
		{		
			$this->db->set('is_active', $this->input->post('status'));
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('services');
		} 

	}

?>