<?php
	class Dashboard_model extends CI_Model{

		public function get_all_users(){
			return $this->db->count_all('ci_users');
		}
		public function get_verified_users(){
			$this->db->where('is_verify', 1);
			return $this->db->count_all_results('ci_users');
		}
		public function get_active_users(){
			$this->db->where('is_active', 1);
			return $this->db->count_all_results('ci_users');
		}
		public function get_admin_approval_users(){
			$this->db->where('admin_approval', 0);
			return $this->db->count_all_results('ci_users');
		}
		public function get_orders_count(){
			return 
			$this->db->select('count(*) orders, date(date_created) y')
			->from('orders')->group_by(' date(date_created)')
			->order_by('date(date_created)', 'desc')->limit(7)->get()->result_array();
		}
	}

?>