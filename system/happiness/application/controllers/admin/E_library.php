<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class E_library extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('adid'))
redirect('admin/login');
}

public function index(){
	$this->load->model('E_library_Model');
	$user=$this->E_library_Model->getAllLibrary();
	$this->load->view('admin/e_library_view',['userdetails'=>$user]);
}

// For particular Record
public function get_detail_model($uid)
{
	$this->load->model('E_library_Model');
	$udetail=$this->E_library_Model->get_detail_model($uid);
	
	
	$this->load->view('admin/details_elibrary_view',['ud'=>$udetail]);
}

public function delete_E_library($uid)
{
	$this->load->model('E_library_Model');
	$this->E_library_Model->delete_E_library($uid);
	$this->session->set_flashdata('success', 'User data deleted');
	redirect('admin/E_library');
}

 public function edit($id = null) {       
        $this->load->model('E_library_Model'); 

        if ($id) {
           
        $udetail=$this->E_library_Model->get_detail_model($id);
    
	   
        $this->load->view('admin/updateE_library',['profile'=>$udetail]);

        }
        if (!$id) {
        redirect('admin/E_library');
        }
       
    }
	public function updateUserProfile(){
	

    if ($_POST) {
      $id = !empty($this->input->post('id')) ? $this->input->post('id') : '';
        $data['name'] = !empty($this->input->post('name')) ? $this->input->post('name') :'';		
		$data['file'] =!empty($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
		$data['images'] = !empty($_FILES['images']['name']) ? $_FILES['images']['name'] : '';
	//	$data['updated_at'] =date('Y-m-d h:i:s');				
				if ($_POST) {

				//Check whether user upload picture
				if(!empty($_FILES['file']['name'])){
					

					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
					$config['file_name'] = $_FILES['file']['name'];

					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('file')){
							   
						$uploadData = $this->upload->data();
						$file = $uploadData['file_name'];
					}else{
							   
						$file = '';
					}
				}else{
					$file = '';
				}
				if(!empty($_FILES['images']['name'])){
					


					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
					$config['file_name'] = $_FILES['images']['name'];

					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('images')){
						
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
					}else{
								
						$picture = '';
					}
				}else{
					$picture = '';
				}			
				$data['file']=$file;			
				$data['images']=$picture;

		//***validation**************
       
		$this->form_validation->set_rules('name','first_name','required|alpha');
        //$this->form_validation->set_rules('email','email','required');
        //$this->form_validation->set_rules('mobile','Mobile Number','required|numeric|exact_length[10]');
		//***************************
	
        if ($this->form_validation->run() === TRUE) {                
           //$this->db->update('e_library', $data ,$id);
				$this->db->where('id', $id);
			 $inserted =	$this->db->update('e_library', $data);
            if ($inserted) {
                     
                 
                 $this->session->set_flashdata('success','E library updated successfull.');
                 redirect('admin/E_library');       
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
                redirect('admin/E_library');    
				}
            } else {

				$this->load->view('admin/edit',['profile'=>$data]);
			}

		}
		else{
		$this->load->view('admin/edit',['profile'=>$data]);
		}
}
	
	}
	public function addUserProfile(){
	
	    $data['id'] = !empty($this->input->post('id')) ? $this->input->post('id') : '';
        $data['name'] = !empty($this->input->post('name')) ? $this->input->post('name') :'';		
		$data['file'] =!empty($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
		$data['images'] = !empty($_FILES['images']['name']) ? $_FILES['images']['name'] : '';
		$data['added_at'] =date('Y-m-d h:i:s');				
				if ($_POST) {

				//Check whether user upload picture
				if(!empty($_FILES['file']['name'])){
					echo 'Hello';

					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
					$config['file_name'] = $_FILES['file']['name'];

					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('file')){
							   
						$uploadData = $this->upload->data();
						$file = $uploadData['file_name'];
					}else{
							   
						$file = '';
					}
				}else{
					$file = '';
				}
				if(!empty($_FILES['images']['name'])){
					echo 'Hello';


					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
					$config['file_name'] = $_FILES['images']['name'];

					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('images')){
						
						$uploadData = $this->upload->data();
						$picture = $uploadData['file_name'];
					}else{
								
						$picture = '';
					}
				}else{
					$picture = '';
				}			
				$data['file']=$file;			
				$data['images']=$picture;

		//***validation**************
       
		$this->form_validation->set_rules('name','first_name','required|alpha');
        //$this->form_validation->set_rules('email','email','required');
        //$this->form_validation->set_rules('mobile','Mobile Number','required|numeric|exact_length[10]');
		//***************************
        if ($this->form_validation->run() === TRUE) {                
            $inserted = $this->db->insert('e_library', $data);
            if ($inserted) {
                     
                     
                 $this->session->set_flashdata('success','User added successfull.');
                 redirect('admin/E_library');       
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
                redirect('admin/E_library');    
				}
            } else {

				$this->load->view('admin/addE_library',['profile'=>$data]);
			}

		}
		else{
		$this->load->view('admin/addE_library',['profile'=>$data]);
		}
	}
	 

public function userDetail(){
	
  $this->load->view('admin/user_detail');
	
}


}