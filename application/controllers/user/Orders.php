<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Orders extends MY_Controller {

		public function __construct(){

			parent::__construct();
			auth_check_user(); // check login auth
			//$this->rbac->check_module_access();

			$this->load->model('user/orders_model', 'orders_model');
			$this->load->model('user/Activity_model', 'activity_model');
			$this->load->helper('pdf_helper'); // loaded pdf helper
		}

		//---------------------------------------------------
		// Get All Invoices
		public function index(){

			$data['orders_detail'] = $this->orders_model->get_all_orders();
			$this->load->view('user/includes/_header');
			$this->load->view('user/orders/order_list', $data);
			$this->load->view('user/includes/_footer');
		}

		//---------------------------------------------------
		// Add New Invoices
		public function add()
		{
			//$this->rbac->check_operation_access(); // check opration permission

			if($this->input->post('submit')){

					$uploaded_files = [];
					if(sizeof($_FILES['attachments']['name']) > 0){
						// $fileName = $this->do_multi_upload('attachments');

						for($i=0;$i<sizeof($_FILES['attachments']['name']);$i++){
							$fileName = $_FILES['attachments']['name'][$i];
							//Getting the Temporary file name of the uploaded file
							$fileTempName = $_FILES['attachments']['tmp_name'][$i];
							//Getting the file size of the uploaded file
							$fileSize = $_FILES['attachments']['size'][$i];
							//getting the no. of error in uploading the file
							$fileError = $_FILES['attachments']['error'][$i];
							//Getting the file type of the uploaded file
							$fileType = $_FILES['attachments']['type'][$i];
	
							//Getting the file ext
							$fileExt = explode('.',$fileName);
							$fileActualExt = strtolower(end($fileExt));

							$fileNemeNew = uniqid('',true).".".$fileActualExt;
							//File destination
							$fileDestination = './uploads/'.$fileNemeNew;
							//function to move temp location to permanent location
							move_uploaded_file($fileTempName, $fileDestination);
							$uploaded_files[] = $fileNemeNew;
						}

						
					}
					
					$services_detail =  array(
							'service' => $this->input->post('service'),
							'price' => $this->input->post('price')
						);
					$services_detail = serialize($services_detail);
					$uploaded_files = serialize($uploaded_files);

					$order = array(

						'user_id' => $this->session->userdata('id'),
						'cnic' => $this->input->post('cnic'),
						'services' => $services_detail,
						'name' => $this->input->post('name'),
						'father_name' => $this->input->post('father_name'),
						'total_price' => $this->input->post('grand_total'),
						'attachments' => $uploaded_files
					);

					$order = $this->security->xss_clean($order);

					$result = $this->orders_model->add_order($order);
					if($result){
						// Activity Log 
						// $this->activity_model->add_log(7);

						$this->session->set_flashdata('success', 'Order has been Added Successfully!');
						redirect(base_url('user/orders'));
					}
				// }	
				//print_r($data['invoice_data']);
			}
			else{
				$data['title'] = 'Orders';
				$data['customer_list'] = $this->orders_model->get_customer_list();
				$data['services_list'] = $this->orders_model->get_services_list();

				$this->load->view('user/includes/_header');
				$this->load->view('user/orders/order_add', $data);
				$this->load->view('user/includes/_footer');
			}
			
		}

		//---------------------------------------------------
		// Get Customer Detail for Invoice
		public function customer_detail($id=0){

			$data['customer'] = $this->orders_model->customer_detail($id);
			echo json_encode($data['customer']);
		}

		//---------------------------------------------------
		// Get View Invoice
		public function view($id=0){

			$this->rbac->check_operation_access(); // check opration permission

			$data['invoice_detail'] = $this->orders_model->get_invoice_by_id($id);

			$this->load->view('user/includes/_header');
        	$this->load->view('user/invoices/invoice_view', $data);
        	$this->load->view('user/includes/_footer');
		}

		//---------------------------------------------------
		// Edit Invoice
		public function edit($id=0){

			$this->rbac->check_operation_access(); // check opration permission

			if($this->input->post('submit')){
				$data['company_data'] = array(
					'name' => $this->input->post('company_name'),
					'address1' => $this->input->post('company_address_1'),
					'address2' => $this->input->post('company_address_2'),
					'email' => $this->input->post('company_email'),
					'mobile_no' => $this->input->post('company_mobile_no'),
					'created_date' => date('Y-m-d h:m:s')
				);
				$data = $this->security->xss_clean($data['company_data']);
				$company_id = $this->orders_model->update_company($data, $this->input->post('company_id'));
				if($company_id){
					$items_detail =  array(
							'product_description' => $this->input->post('product_description'),
							'quantity' => $this->input->post('quantity'),
							'price' => $this->input->post('price'),
							'tax' => $this->input->post('tax'),
							'total' => $this->input->post('total'),
						);
					$items_detail = serialize($items_detail);

					$data['invoice_data'] = array(

						'admin_id' => $this->session->userdata('id'),
						'user_id' => $this->input->post('user_id'),
						'company_id' => $company_id,
						'invoice_no' => $this->input->post('invoice_no'),
						'txn_id' => '',
						'items_detail' => $items_detail,
						'sub_total' => $this->input->post('sub_total'),
						'total_tax' => $this->input->post('total_tax'),
						'discount' => $this->input->post('discount'),
						'grand_total' => $this->input->post('grand_total'),
						'currency ' => 'USD',
						'payment_method' => '',
						'payment_status ' => $this->input->post('payment_status'),
						'client_note ' => $this->input->post('client_note'),
						'termsncondition ' => $this->input->post('termsncondition'),
						'due_date' => date('Y-m-d', strtotime($this->input->post('due_date'))),
						'updated_date' => date('Y-m-d'),
					);

					$invoice_data = $this->security->xss_clean($data['invoice_data']);
						
					$result = $this->orders_model->update_invoice($invoice_data, $id);
					if($result){
						// Activity Log 
						$this->activity_model->add_log(8);
						$this->session->set_flashdata('success', 'Invoice has been updated Successfully!');
						redirect(base_url('user/invoices/edit/'.$id));
					}
				}	
			}
			else{
				$data['invoice_detail'] = $this->orders_model->get_invoice_by_id($id);
				$data['customer_list'] = $this->orders_model->get_customer_list();

				$data['title'] = 'Edit Invoice';

				$this->load->view('user/includes/_header');
				$this->load->view('user/orders/order_edit', $data);
				$this->load->view('user/includes/_footer');
			}
		}

		//---------------------------------------------------
		// Download PDF Invoices
		public function invoice_pdf_download($id=0){

			$data['invoice_detail'] = $this->orders_model->get_invoice_by_id($id);
			$this->load->view('user/invoices/invoice_pdf_download', $data);
		}

		//---------------------------------------------------------------
		// Create PDF invoice at run time for Email
		public function create_pdf($id=0){
			
			$data['invoice_detail'] = $this->orders_model->get_invoice_by_id($id);
			$html = $this->load->view('user/invoices/invoice_pdf', $data, TRUE);
			
			$filename = $data['invoice_detail']['invoice_no'];
		
			$pdf_file_path = FCPATH."/uploads/invoices/".$filename.".pdf";

			$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
			// LOAD a stylesheet
			$stylesheet = file_get_contents(base_url('public/dist/css/mpdfstyletables.css'));
			$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html,2);
			$mpdf->Output($pdf_file_path,'F');
			
			echo base_url()."uploads/invoices/".$filename.".pdf";
			exit;
		
		}

		//---------------------------------------------------------------
		// Sending email with invoice attachemnt
		function send_email_with_invoice(){
		
			$this->load->helper('email_helper');
			
			$to = $this->input->post('email');
			$subject = $this->input->post('subject');
			$message = $this->input->post('message');
			$cc = $this->input->post('cc');
			$file = $this->input->post('file');
			
			$check = send_email($to, $subject, $message, $file, $cc);
						  
			  if( $check ){
				  echo 'success';
			  }
			
		}

		//---------------------------------------------------
		// Delete Invoices
		public function delete($id){

			$this->rbac->check_operation_access(); // check opration permission

			$result = $this->db->delete('ci_payments', array('id' => $id));
			if($result){
				// Activity Log 
				$this->activity_model->add_log(9);
				$this->session->set_flashdata('success', 'Record has been deleted Successfully!');
				redirect(base_url('user/invoices'));
			}
		}

	}

?>