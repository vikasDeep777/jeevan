<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Feedback extends CI_Controller {
function __construct(){
	parent::__construct();
	if(! $this->session->userdata('adid'))
	redirect('admin/login');

}

public function index(){
	$this->load->model('Feedback_Model');	
	$feedback=$this->Feedback_Model->getFeedbacks();	
	$this->load->view('admin/feedback_view',['feedback'=>$feedback]);
}

// For particular Record
public function get_feedback_detail($uid)
{
	$this->load->model('Feedback_Model');
	$udetail=$this->Feedback_Model->get_feedback_detail_model($uid);
	$this->load->view('admin/viewfeedback_view',['ud'=>$udetail]);
}

public function deleteFeedback($uid)
{
	$this->load->model('Feedback_Model');
	$this->Feedback_Model->deleteFeedback_model($uid);
	$this->session->set_flashdata('success', 'User data deleted');
	redirect('admin/Feedback');
}

 public function edit($id = null) {       
        $this->load->model('Feedback_Model'); 

        if ($id) {
           
        $udetail=$this->Feedback_Model->get_innovative_detail_model($id);
       
        $this->load->view('admin/updateInnovative_view',['profile'=>$udetail]);

        }
        if (!$id) {
        redirect('admin/innovative');
        }
       
    }
	public function updateInnovative(){

    if ($_POST) {
 	 
        $data['id'] = $this->input->post('id');
        $first_name= $this->input->post('first_name');
        $email = $this->input->post('email');
        $data['subject'] = $this->input->post('subject');
		//$data['password'] = $this->input->post('mobile');
		//$data['password'] = $this->security->xss_clean(md5($this->input->get_post('password')));
        $data['prop_details'] =$this->input->post('prop_details');
      
     //***validation**************
        $this->form_validation->set_rules('subject','first_name','required|alpha');
        $this->form_validation->set_rules('prop_details','prop_details','required');
       // $this->form_validation->set_rules('mobile','Mobile Number','required|numeric|exact_length[10]');
     //***************************
        if ($this->form_validation->run() === TRUE) {  
 	
            $updated = $this->db->update('innovative', $data, array('id' => $data['id']));
            if ($updated) {                                          
                 $this->session->set_flashdata('success','Innovative updated successfull.');
                 redirect('admin/innovative');       
				} else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
                redirect('admin/innovative');    
				}
            } else {
				$data['first_name']=$first_name;
				$data['email']=$email;

                $this->load->view('admin/updateInnovative_view',['profile'=>$data]);
              
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