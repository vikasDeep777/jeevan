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



    // public function edit($id = null) {       
    //   $this->load->model('ManageUsers_Model'); 
        
    //     //'id,first_name,email,mobile'
        
        
    //     if ($_POST) {
          
    //         $id1 =$this->input->post('id');
    //             $data['first_name'] = $this->input->post('first_name');
    //             $data['email'] = $this->input->post('email');
    //             $data['mobile'] = $this->input->post('mobile');
                
    //       // Array ( [id] => 7 [firstname] => Yogesh [email] => testinsssg@testing.com [mobile] => 9865522122 [Update] => Update )
    //         $this->form_validation->set_rules('first_name','Full Name','required|alpha');
    //         $this->form_validation->set_rules('email','Email','required|alpha');
    //         $this->form_validation->set_rules('mobile','Mobile Number','required|numeric|exact_length[10]');
    //         if ($this->form_validation->run() === TRUE) {
    //           print_r($data);
    //           print_r($id1);
    //         $updated = $this->db->update('users', $data, array('id' => $id1));
                
    //             if ($updated) {
    //               $this->session->set_flashdata('success','Profile updated successfull.');
    //                         redirect('admin/Manage_Users');       
    //             } else {
    //              	$this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
    //                  redirect('admin/Manage_Users');    
    //             }
    //         } else {
    //               $this->load->view('admin/updateUser',['ud'=>$data]);
    //         }
    //     }
        
    //     if ($id) {
            
    //         $udetail=$this->ManageUsers_Model->getuserdetail($id);
    //         $this->load->view('admin/updateUser',['ud'=>$udetail]);
           
    //     }
    //      if (!$id) {
    //              redirect('admin/Manage_Users');
    //         }
       
       
    // }



///first_name,email,mobile
public function updateUserProfile(){
$this->form_validation->set_rules('first_name','Full Name','required|alpha');
$this->form_validation->set_rules('email','Email','required|alpha');
$this->form_validation->set_rules('mobile','Mobile Number','required|numeric|exact_length[10]');
if($this->form_validation->run()){
$fname=$this->input->post('firstname');
$lname=$this->input->post('lastname');
$mnumber=$this->input->post('mobilenumber');
$userid = $this->session->userdata('uid');
$this->User_Profile_Model->update_profile($fname,$lname,$mnumber,$userid);
$this->session->set_flashdata('success','Profile updated successfull.');
return redirect('user/user_profile');

} else {
	$this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
redirect('user/user_profile');
}

}


}