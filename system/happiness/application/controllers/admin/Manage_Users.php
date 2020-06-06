<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Manage_Users extends CI_Controller {
function __construct(){
parent::__construct();
if(! $this->session->userdata('adid'))
redirect('admin/login');
}

public function index(){
$this->load->model('ManageUsers_Model');
$user=$this->ManageUsers_Model->getusersdetails();
$this->load->view('admin/manage_users',['userdetails'=>$user]);
}

// For particular Record
public function getuserdetail($uid)
{
$this->load->model('ManageUsers_Model');
$udetail=$this->ManageUsers_Model->getuserdetail($uid);
$this->load->view('admin/getuserdetails',['ud'=>$udetail]);
}

public function deleteuser($uid)
{
$this->load->model('ManageUsers_Model');
$this->ManageUsers_Model->deleteuser($uid);
$this->session->set_flashdata('success', 'User data deleted');
redirect('admin/Manage_Users');
}

 public function edit($id = null) {       
        $this->load->model('ManageUsers_Model'); 

        if ($id) {
           
        $udetail=$this->ManageUsers_Model->getuserdetail($id);
       
        $this->load->view('admin/updateUser',['profile'=>$udetail]);

        }
        if (!$id) {
        redirect('admin/Manage_Users');
        }
       
    }
	public function updateProfile(){

    if ($_POST) {
      

        $data['id'] = $this->input->post('id');
        $data['first_name'] = $this->input->post('first_name');
        $data['email'] = $this->input->post('email');
        $data['mobile'] = $this->input->post('mobile');
		//$data['password'] = $this->input->post('mobile');
		//$data['password'] = $this->security->xss_clean(md5($this->input->get_post('password')));
        $data['updated_at'] =date('Y-m-d h:i:s');
      
     //***validation**************
        $this->form_validation->set_rules('first_name','first_name','required|alpha');
        $this->form_validation->set_rules('email','email','required');
        $this->form_validation->set_rules('mobile','Mobile Number','required|numeric|exact_length[10]');
     //***************************
        if ($this->form_validation->run() === TRUE) {                
            $updated = $this->db->update('users', $data, array('id' => $data['id']));
            if ($updated) {
                     
                     
                 $this->session->set_flashdata('success','Profile updated successfull.');
                 redirect('admin/Manage_Users');       
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
                redirect('admin/Manage_Users');    
            }
            } else {

                $this->load->view('admin/updateUser',['profile'=>$data]);
              
            }
        }
}
	

public function addUserProfile(){
	
	    $data['id'] = !empty($this->input->post('id')) ? $this->input->post('id') : '';
        $data['first_name'] = !empty($this->input->post('first_name')) ? $this->input->post('first_name') :'';
        $data['email'] = !empty($this->input->post('email')) ? $this->input->post('email') : '';
		$data['password'] = $this->security->xss_clean(md5($this->input->get_post('password')));
        $data['mobile'] = !empty($this->input->post('mobile')) ? $this->input->post('mobile') : '' ;
		$data['password'] = !empty($this->input->post('password')) ? $this->input->post('password') : '' ;
        $data['added_at'] =date('Y-m-d h:i:s');

    if ($_POST) {
	
      

      
      
     //***validation**************
        $this->form_validation->set_rules('first_name','first_name','required|alpha');
        $this->form_validation->set_rules('email','email','required');
        $this->form_validation->set_rules('mobile','Mobile Number','required|numeric|exact_length[10]');
     //***************************
        if ($this->form_validation->run() === TRUE) {                
            $inserted = $this->db->insert('users', $data);
            if ($inserted) {
                     
                     
                 $this->session->set_flashdata('success','User added successfull.');
                 redirect('admin/Manage_Users');       
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
                redirect('admin/Manage_Users');    
            }
            } else {

                $this->load->view('admin/addUser',['profile'=>$data]);
              
            }
        }
		 $this->load->view('admin/addUser',['profile'=>$data]);
		
}

public function userDetail(){
	
  $this->load->view('admin/user_detail');
	
}


}