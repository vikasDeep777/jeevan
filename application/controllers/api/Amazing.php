<?php
//https://code.tutsplus.com/tutorials/working-with-restful-services-in-codeigniter--net-8814
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/Format.php';
//require_once 'Attendance.php';
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          vikas sahu
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Amazing extends REST_Controller{
    function __construct(){
        
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['student_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->requests = json_decode(file_get_contents('php://input'), true);
       // $this->req = $this->requests['RequestData'];
		$this->req = $this->requests;
       // $this->load->model('Auth_Model', 'auth', true);
       // $this->load->model('Student_Model', 'student', true);
		$this->load->model('User_Model', 'user_Model', true);
    }
    //Update Profile

	//*****************************************************************************************************************************
	//*******************************************************************************************************************************
	
	
	
	
	public function user_register_post(){
      		
        if(isset($_POST)){	
            $emailcheck = $this->user_Model->duplicate_check($this->input->post('email'));
            
            $mobilecheck = $this->user_Model->duplicate_check_mobile($this->input->post('mobileNo'));
            
            if ($emailcheck !=null){
                $this->set_response(['status' => false, 'message' => 'This Email ID is Already Exists', "Error"=> REST_Controller::HTTP_NOT_ACCEPTABLE ], REST_Controller::HTTP_OK);
            }elseif($mobilecheck != null){
                $this->set_response(['status' => false, 'message' => 'This Mobile no is Already Exists', "Error"=> REST_Controller::HTTP_NOT_ACCEPTABLE ], REST_Controller::HTTP_OK);        
            }else{
                //print_r($_POST);
                //die();
                $data['mobileNo']  		    = $this->input->post('mobileNo');
                $data['email']  		    = $this->input->post('email');
                $data['name']			    = $this->input->post('first_name');
                $data['last_name']          = $this->input->post('last_name');
                $data['password']  	        = md5($this->input->post('password'));				
				$data['temp_password']      = base64_encode($this->input->post('password'));
				$data['gender']             = $this->input->post('gender');
				$data['deviceID']	        = $this->input->post('deviceID');
				$data['deviceType']	        = $this->input->post('deviceType');
				
				$data['created_at']         = date('Y-m-d H:i:s');
				$data['created_by']         = '';	
				$data['device_token']       = $this->input->post('device_token');
                $key = $this->input->post('name') . $this->input->post('email') . date('mY');
                $data['activation_key']     = md5($key);	
                $data['quick_blox_id']      = $this->input->post('quick_blox_id');
                $data['latitude']           = $this->input->post('latitude');
                $data['longitude']          = $this->input->post('longitude');
               
                $data['profile_for']        = $this->input->post('profile_for');
                $data['dob']                = $this->input->post('dob');
                $data['permanent_address']  = $this->input->post('permanent_address');
                $data['city']               = $this->input->post('city');
                $data['state']             = $this->input->post('state');
                $data['country']           =$this->input->post('country');
                $data['education_category'] =$this->input->post('education_category');  
                $data['qualification']       =$this->input->post('qualification');
                $data['hobbies']            =$this->input->post('hobbies');
                $data['fav_actor']            =$this->input->post('fav_actor');	
                $data['fav_actress']            =$this->input->post('fav_actress');	
                $data['food_type']            =$this->input->post('food_type');	
                $data['partner_type']            =$this->input->post('partner_type');	
                $data['mother_tongue']            =$this->input->post('mother_tongue');	
                $data['marital_status']            =$this->input->post('marital_status');	
                $data['occupation_sector']            =$this->input->post('occupation_sector');	
                $data['occupation_type']            =$this->input->post('occupation_type');	
                $data['religion']            =$this->input->post('religion');	
                $data['height']            =$this->input->post('height');
                $data['height_m1']            =$this->input->post('height_m1');
                $data['height_m2']            =$this->input->post('height_m2');
            
                $data['caste']            =$this->input->post('caste');
                $destination = 'assets/uploads/profile_image/';
                
                if ($_FILES['image']['name']) {
                $data['image'] = $this->_upload_image($destination);
                }
                 
				$insert_id = $this->user_Model->insert('users_register', $data); 
                if($insert_id){
                    $info =
                    '<!doctype html>
                    <html>
                       <head>
                          <meta charset="utf-8">
                          <title>Wedding Day</title>
                          <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700" rel="stylesheet">
                          <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
                       </head>
                       <body>
                          <div style="margin:auto;background: #f7f7f7; float:left;  margin-top: 20px;padding:20px 0">
                          <table  align="center;" border="0" style="margin:auto; width:80%; text-align:center;font-size: 13px;color: #666;background: #fff;">
                             <tr>
                                <td colspan="2" style="background-color:#121c5b; border-radius: 8px 8px 0 0;
                                   padding: 7px 0;">
                                   <img  margin:0 auto; display:block" src="#">
                                </td>
                             </tr>
                             <tr>
                                <td colspan="2">
                                   <h2 style="text-align:center;">We"re glad you"re here!</h2>
                                </td>
                             </tr>
                             <tr>
                                <td colspan="2">
                                <br/>
                                   <a href="https://www.edusams.com/login?key='.$key.'"> 
                                    <img style="max-width:100%; min" src="https://www.edusams.com//assets/images/click-button.png">
                                </a>
                                <br/>      
                                </td>
                             </tr>
                             <tr>
                                <td colspan="2">
                                   <table width="90%" align="center;"  border="1" cellpadding="4" style="margin:auto; width:90%; text-align:center; margin:0 auto;border-collapse: collapse;margin-top: 20px;font-size: 13px;color: #666;">
                                      <tr>
                                         <td>Name</td>
                                         <td>'.$data['name'].' '. $data['last_name'].'</td>
                                      </tr>
                                      
                                      
									  
                                   </table>
                                </td>
                             </tr>
                             <tr>
                                <td colspan="2">
                                   <p style="margin-bottom:20px">We just want to confirm you"re you.</p>
                                   <p>If you didn"t create a Edusams account, just delete this email and everything will go back to the way it was.</p>
                                </td>
                              </tr>  
                              <tr>
                                                    <td>
                                                    <img style="width:650px" width="650" src="https://www.edusams.com//assets/images/mailer.jpg">     
                                                    </td>     
                                                    </tr>
                          </table>
                       </div>
                       </body>
                    </html>';
                   $this->user_Model->update('users_register', array('activation_key'=>$key), array('id' => $insert_id));
                    //mail1($data['email'] ,$info);  
//                     $this->load->library('email');
// $config['protocol']='smtp';
// //$config['smtp_host']='ssl://smtp.googlemail.com';
// //$config['smtp_port']='465';
// $config['smtp_timeout']='30';
// $config['smtp_user']='support@appzdigital.com';
// $config['smtp_pass']='anand@9807';
// $config['charset']='utf-8';
// $config['newline']="\r\n";
// $config['wordwrap'] = TRUE;
// $config['mailtype'] = 'html';
// $this->email->initialize($config);
// $this->email->from('support@appzdigital.com', 'Site name');
// $this->email->to('contactvikassahu@gmial.com');
// $this->email->subject('Notification Mail');
// $this->email->message('Your message');
// $this->email->send();
    
                    $config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'ssl://smtp.googlemail.com',
  'smtp_port' => 465,
  'smtp_user' => 'vikas@amazingmarry.com', // change it to yours
  'smtp_pass' => 'vikas@123', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);

        $message = '';
        $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('vikas@amazingmarry.com'); // change it to yours
      $this->email->to('contactvikassahu@gmail.com');// change it to yours
      $this->email->subject('Resume from JobsBuddy for your Job posting');
      $this->email->message($message);
      if($this->email->send())
     {
      echo 'Email sent.';
     }
     else
    {
     show_error($this->email->print_debugger());
    }
 
 
                     // Create Response
                                      
						$response = array(
						'id'               => (!empty($insert_id)) ? $insert_id : '',                      						                     
						'email'            => (!empty($data['email'])) ? $data['email'] :'', 
						'mobileNo'         => (!empty($data['mobileNo'])) ? $data['mobileNo'] :'',
						'name'             => (!empty($data['name'])) ? $data['name'] :'',  
						'gender'           =>(!empty($data['gender'])) ? $data['gender'] :'',
						'device_token'     => (!empty($data['device_token'])) ? $data['device_token'] :'',
						'quick_blox_id'    => (!empty($data['quick_blox_id'])) ? $data['quick_blox_id'] :'',
						'latitude'         => (!empty($data['latitude'])) ? $data['latitude'] :'',
						'longitude'        => (!empty($data['longitude'])) ? $data['longitude'] :'',
						'current_address'  => (!empty($data['current_address'])) ? $data['current_address'] :''
						);

                    $this->set_response([
                                            'status' => true, 
                                            'code' => REST_Controller::HTTP_OK,
					                        'message' => 'Your biography created successfully.',
                                            //'response' => $response
                                        ], REST_Controller::HTTP_OK);

                }else{
                         $this->set_response(['status' => false,
                                              'code' => REST_Controller::HTTP_NOT_ACCEPTABLE, 
                                              'message' => 'Some thing Went Wrong.'],
                                              REST_Controller::HTTP_OK);
                }
            }
            }else{
                $this->set_response(['status' => false,
                                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                                    'message' => 'Some thing Went Wrong' ],
                                    REST_Controller::HTTP_OK);
        }
    }
	
	
	


	///****************************************************************************************************************************************
	
	    public function login_user_post(){
        $status = 0;
        $msg="Invalid Email OR password";

        if((!empty($this->req['password'])) && (!empty($this->req['email_or_moblie'])) && (!empty($this->req['device_token'])) && (!empty($this->req['deviceID'])) && (!empty($this->req['deviceType']))){
            

            $data['password'] = md5($this->req['password']);
			$data['email_or_moblie'] = $this->req['email_or_moblie'];         
            $login = $this->user_Model->getsingleuser($data['email_or_moblie'], $data['password']);
            $email = $this->req['email_or_moblie'];
            $password = $this->req['password'];
            $remember= $this->req['remember'];

            if (!empty($login)) {
               
                $this->session->set_userdata('id', $login->id);                              
                $this->session->set_userdata('email', $login->email); 
				$this->session->set_userdata('mobileNo', $login->mobileNo);
				$this->session->set_userdata('gender', $login->gender);
				$this->session->set_userdata('firstname', $login->name);
				$this->session->set_userdata('lastname', $login->last_name);
                $this->session->set_userdata('device_token', $login->device_token);
                $this->session->set_userdata('email_active_status', $login->email_active_status);
                $this->session->set_userdata('notification_status', $login->notification_status);
                $this->session->set_userdata('quick_blox_id', $login->quick_blox_id);
                $this->session->set_userdata('latitude', $login->latitude);
                $this->session->set_userdata('longitude', $login->longitude);
                $this->session->set_userdata('created_at', $login->created_at);
                $this->session->set_userdata('profile_for', $login->profile_for);
                $this->session->set_userdata('dob', $login->dob);
                $this->session->set_userdata('permanent_address', $login->permanent_address);
                $this->session->set_userdata('city', $login->city);
                $this->session->set_userdata('state', $login->state);
                $this->session->set_userdata('country', $login->country);
                $this->session->set_userdata('education_category', $login->education_category);
                $this->session->set_userdata('qualification', $login->qualification);
                $this->session->set_userdata('hobbies', $login->hobbies);
                $this->session->set_userdata('fav_actor', $login->fav_actor);
                $this->session->set_userdata('fav_actress', $login->fav_actress);
                $this->session->set_userdata('food_type', $login->food_type);
                $this->session->set_userdata('partner_type', $login->partner_type);
                $this->session->set_userdata('mother_tongue', $login->mother_tongue);
                $this->session->set_userdata('occupation_sector', $login->occupation_sector);
                $this->session->set_userdata('occupation_type', $login->occupation_type);
                $this->session->set_userdata('religion', $login->religion);
                $this->session->set_userdata('height', $login->height);
                $this->session->set_userdata('height_m1', $login->height_m1);
                $this->session->set_userdata('height_m2', $login->height_m1);
                $this->session->set_userdata('caste', $login->caste);
				if($login->image != ''){
				   $login->image= 'https://www.amazingmarry.com/assets/uploads/profile_image/'.$login->image;
					$this->session->set_userdata('image', $login->image );
				}else{
					$this->session->set_userdata('image', '');
				}
               
                $this->user_Model->update('users_register', array('last_logged_in' => date('Y-m-d H:i:s')), array('id' => $login->id));
                $status = 1;
                $msg = 'Login Success';
                if((!empty($login->id))){
                    $this->db->update('users_register', array('device_token'=>$this->req['device_token'], 'deviceID'=>$this->req['deviceID'],'deviceType'=>$this->req['deviceType']), array('id'=>$login->id));   
                }
            }else{
                $status = 0;
                $msg = 'Invalid User Id/password Or Account is not active.';
            }
            if($status == 1){

                $this->set_response(['status' => true,
                                    'code' => REST_Controller::HTTP_OK,
                                    'message' => $msg,
                                    'response' => $this->session->userdata
                                   ], REST_Controller::HTTP_OK);   
            }else{
                $this->set_response(['status' => false,
                                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                                    'message' => $msg ],
                                    REST_Controller::HTTP_OK);  
            }
        }else{
                $this->set_response(['status' => false,'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,'message' => $msg], REST_Controller::HTTP_OK);  
        }
    }
    //***********************PASSWORD*******************************************
	// Reset Password
    public function passwordreset_post() {
        $status = 0;$msg="";
        if(!empty($this->req)){
            $data['email'] = $this->req['email'];
            $data['status'] = 1;
            $login = $this->user_Model->get_single_auth('users_register', $data);
            if (!empty($login)) {
                $this->_send_email($login);
                $status = 1;
                $msg = 'Password Reset Email Send';
            } else {
                $msg ='wrong_email';
            }

        }

        if($status == 1){	
			$this->set_response(['status' => true,'code' => REST_Controller::HTTP_OK,'message' => $msg], REST_Controller::HTTP_OK); 		
        }else{			
            $this->set_response(['status' => false,'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,'message' => $msg], REST_Controller::HTTP_OK);  
        }
    }

	private function _send_email($data) {
      
        $to = $data->email;
        $subject = 'Password reset Email';
        $key = uniqid();
        $this->user_Model->update('users_register', array('reset_key' => $key), array('id' => $data->id));
        // $message = 'You have requested to reset your ' . $setting->school_name . ' web Application login password.<br/>';
        // $message .= 'To reset you password plese click following url<br/><br/>';
        // $message .= site_url('auth/reset/' . $key);
        // $message .= '<br/><br/>';
        // $message .= 'If you did not  request to reset your password, Plesae ignore this email.<br/><br/>';
        // $message .= 'Thank you<br/>';
        // $message .= $setting->school_name;
        $message ='<!doctype html>
        <html>
           <head>
              <meta charset="utf-8">
              <title>Reset Password</title>
              <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700" rel="stylesheet">
              <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
           </head>
           <body>
              <div style="margin:auto;background: #f7f7f7; float:left;  margin-top: 20px;padding:20px 0">
              <table  align="center;" border="0" style="margin:auto; width:80%; text-align:center;font-size: 13px;color: #666;background: #fff;">
                 
                 <tr>
                    <td colspan="2">
                       <h2 style="text-align:center;">You have requested to reset your login password.</h2>
                    </td>
                 </tr>
                 <tr>
                    <td colspan="2">
                    <br/>
                       
					   <a href="'.site_url('auth/reset_key/' . $key).'" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Reset Your Password link</a>
                    <br/>      
                    </td>
                 </tr>
                 <tr>
                    <td colspan="2">
                       <p style="margin-bottom:20px">If you did not request to reset your password, Plesae ignore this email.</p>
                    </td>
                  </tr>  
                  <tr>
                                     
              </table>
           </div>
           </body>
        </html>';
      mail1($to,$message, $subject);
	 
		
    }
	///***********************************************************************************
	//************************************************************************************
	//                     API :-  Dashboard Slider    
	//
    //                 FUNTION FOR :-INSERT ALL DATA
	//*************************************************************************************
	//*************************************************************************************
	
	
	
	public function dashboard_slider_post(){
		
		$data['notes_name']  	= $this->input->post('notes_name');
		$data['notes_category']  = $this->input->post('notes_category'); 
		$data['notes_image_url']  = $this->input->post('notes_image_url');
        $data['notes_pdf_link']  = $this->input->post('notes_pdf_link'); 
        $data['rating']  = $this->input->post('rating'); 
        $data['total_user_rated']  = $this->input->post('total_user_rated'); 
        $data['notes_status']  = $this->input->post('notes_status');
        $data['notes_desc']  = $this->input->post('notes_desc');

		
		if ($_FILES['notes_image_url_main']['name']) {
		$data['notes_image_url_main'] = $this->_upload_notes_image_url_main();
		}
		$insert_id = $this->user_Model->insert('dashboardSlider', $data); 
								
		if($insert_id){
			
			$this->set_response([
			'status' => true, 
			'code' => REST_Controller::HTTP_OK,
			'message' => 'Data uploads successful'
			

			], REST_Controller::HTTP_OK);

		}else{
			$this->set_response(['status' => false,"Error"=>array('code' => REST_Controller::HTTP_NOT_ACCEPTABLE, 
			'message' => 'Some thing Went Wrong...')], REST_Controller::HTTP_OK);
		}	
		
	}
	private function _upload_notes_image_url_main() {

        $prev_photo = $this->input->post('prev_photo');
        $notes_image_url_main = $_FILES['notes_image_url_main']['name'];
        $photo_type = $_FILES['notes_image_url_main']['type'];
        $return_photo = '';
        if ($notes_image_url_main != "") {
            if ($photo_type == 'image/jpeg' || $photo_type == 'image/pjpeg' ||
                    $photo_type == 'image/jpg' || $photo_type == 'image/png' ||
                    $photo_type == 'image/x-png' || $photo_type == 'image/gif') {

                $destination = 'assets/uploads/notes_image_url_main/';

                $file_type = explode(".", $notes_image_url_main);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $photo_path = 'notes_image_url_main-' . time()  . $extension;

                move_uploaded_file($_FILES['notes_image_url_main']['tmp_name'], $destination . $photo_path);

                // need to unlink previous photo
                if ($prev_photo != "") {
                    if (file_exists($destination . $prev_photo)) {
                        @unlink($destination . $prev_photo);
                    }
                }

                $return_photo = $photo_path;
            }
        } else {
            $return_photo = $prev_photo;
        }

        return $return_photo;
    }
	///***********************************************************************************
	//************************************************************************************
	//                     API :-  Dashboard Slider    
	//
    //                 FUNCTION FOR :-LIST  ALL & SPECIFIC BY ID
	//*************************************************************************************
	//*************************************************************************************
    public function dashboard_slider_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'dashboardSlider';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);
            //  unset($obj->notes_category);
            //	unset($obj->notes_image_url);
            //	unset($obj->notes_pdf_link);
            //	unset($obj->notes_pdf_link);
            //	unset($obj->notes_image_url_main);
            //	if($obj->date != null){
            //		$date = date_create($obj->date); 
            //      $obj->date = date_format($date, "M d Y h:i a");
            //	}
            
				if($obj->notes_image_url_main != null){
                    	$obj->notes_image_url_main ='https://www.appzdigital.com/dev/assets/uploads/notes_image_url_main/'.$obj->notes_image_url_main;
                    
				}
				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is all slider images";
			$this->set_response(['status' => true,'code' => REST_Controller::HTTP_OK,'response' => $this->data,'message' => $msg], REST_Controller::HTTP_OK);
        }else{
            $msg = "No Record found.";
            $this->set_response(['status' => false,"Error"=>array('code' => REST_Controller::HTTP_NOT_ACCEPTABLE,'message' => $msg)], REST_Controller::HTTP_OK);
        }	 
	}
    
    //***********************************************************************************
    //COUNTRY
	//************************************************************************************
    //        FUNCTION FOR :-INSERT ALL DATA
	//------------------------------------------------------------------------------------
	public function country_post(){
	
		$data['name']  	= $this->req['name'];
	    $data['sortname']       = $this->req['sortname'];
     	$insert_id = $this->user_Model->insert('country_list', $data); 
		if($insert_id){
			$this->set_response([
			'status' => true, 
			'code' => REST_Controller::HTTP_OK,
			'message' => 'Data uploads successful'
			], REST_Controller::HTTP_OK);
		}else{
			  $this->set_response(['status' => false,
                                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                                    'message' =>'Some thing Went Wrong...' ],
                                    REST_Controller::HTTP_OK); 
		}	
	}
	//------------------------------------------------------------------------------------
    //	FUNCTION FOR :-LIST ALL COUNRTY NAME
    //------------------------------------------------------------------------------------
     public function country_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'country_list';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is Country Data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
   //***********************************************************************************
    //STATE 
	//**********************************************************************************
	//STATE LIST
	//-----------------------------------
	   public function state_list_post(){		
    
		$id =  $this->  req['country_id'];
		$tablename = 'state_list';	
		
    	$this->db->select('*');
        $this->db->from($tablename);
        if(!empty($id)){
             $this->db->where('country_id', $id);
        }
        $lists= $this->db->get()->result();
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is State Data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	//***********************************************************************************
    //CITY
	//**********************************************************************************
	//CITY LIST
	//-----------------------------------
	   public function city_list_post(){		
    
		$id =  $this->req['state_id'];
		
		$tablename = 'city_list';	
		
    	$this->db->select('*');
        $this->db->from($tablename);
        if(!empty($id)){
             $this->db->where('state_id', $id);
        }
        $lists= $this->db->get()->result();
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is City Data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	
	//***********************************************************************************
    //MOTHER TONGUE
	//************************************************************************************
    //        FUNCTION FOR :-INSERT ALL DATA
	//------------------------------------------------------------------------------------
	public function mother_tongue_post(){
	
		$data['name']  	= $this->req['name'];
	   
     	$insert_id = $this->user_Model->insert('mother_tongue', $data); 
		if($insert_id){
			$this->set_response([
			'status' => true, 
			'code' => REST_Controller::HTTP_OK,
			'message' => 'Data uploads successful'.$data['mother_tongue_name']
			], REST_Controller::HTTP_OK);
		}else{
			  $this->set_response(['status' => false,
                                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                                    'message' =>'Some thing Went Wrong...' ],
                                    REST_Controller::HTTP_OK); 
		}	
	}
	//---------------------------------------------------------------------------------
	//  FUNCTION FOR LIST 
	//---------------------------------------------------------------------------------
	 public function mother_tongue_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'mother_tongue';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is mother tongue Data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	//***********************************************************************************
    //HEIGHT
	//************************************************************************************
    //        FUNCTION FOR :-INSERT HEIGHT
	//------------------------------------------------------------------------------------
		public function heights_post(){
	
		$data['foot']  	= $this->req['foot'];
	    $data['inch']  	= $this->req['inch'];
	    $data['centimetre'] = $this->req['centimetre'];
	   	
	   	
     	$insert_id = $this->user_Model->insert('height', $data); 
		if($insert_id){
			$this->set_response([
			'status' => true, 
			'code' => REST_Controller::HTTP_OK,
			'message' => 'Data height successful'
			], REST_Controller::HTTP_OK);
		}else{
			  $this->set_response(['status' => false,
                                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                                    'message' =>'Some thing Went Wrong...' ],
                                    REST_Controller::HTTP_OK); 
		}	
	}
	//---------------------------------------------------------------------------
	// height list all
	//---------------------------------------------------------------------------
	
	public function height_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'height';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				$this->data[$i]['id']=$obj->id;
				$this->data[$i]['height']=$obj->foot."ft ".$obj->inch."in - ".$obj->centimetre."cm";
				$i++;
			}				
			
			$msg = "This is mother tongue Data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	//***********************************************************************************
    // Education_level
	//************************************************************************************
    //        FUNCTION FOR :-INSERT HEIGHT
	//------------------------------------------------------------------------------------
		public function education_level_post(){
	
	
	    $data['name'] = $this->req['name'];
	   	
	   	
     	$insert_id = $this->user_Model->insert('educationlevel', $data); 
		if($insert_id){
			$this->set_response([
			'status' => true, 
			'code' => REST_Controller::HTTP_OK,
			'message' => 'Data education level /category successful'
			], REST_Controller::HTTP_OK);
		}else{
			  $this->set_response(['status' => false,
                                    'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                                    'message' =>'Some thing Went Wrong...' ],
                                    REST_Controller::HTTP_OK); 
		}	
	}
	
	//-----------------------------------------------------------------------
	//education level list
	//------------------------------------------------------------------------
	public function education_level_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'educationlevel';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is education level Data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	//*************************************************************************
	//Qualification 
	//------------------------------------------------------------------------
	// Qualification list
	//------------------------------------------------------------------------
	public function qualification_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'qualification';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
            //	unset($obj->notes_name);
				$this->data[$i]=$obj;
				$i++;
			}				
			$msg = "This is education level Data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	//*************************************************************************
	//Religion
	//------------------------------------------------------------------------
	// Religion list
	//------------------------------------------------------------------------
		public function religion_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'religion';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is religion data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
		//*************************************************************************
	//OCCUPATION SECTER
	//------------------------------------------------------------------------
	// OCCUPATION list
	//------------------------------------------------------------------------
		public function occupation_sector_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'occupation_sector';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is occupation sector data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	
		//*************************************************************************
	//OCCUPATION TYPE
	//------------------------------------------------------------------------
	// OCCUPATION TYPE LIST
	//------------------------------------------------------------------------
		public function occupation_type_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'occupation_type';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is occupation sector data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	
    //*************************************************************************
	// user detail api
	//------------------------------------------------------------------------

		public function user_register_detail_get(){		
   
		$id =  $this->get('id');
		
		$tablename = 'users_register';	
    	$lists = $this->user_Model->get_list_all($tablename,$id);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is user_register_detail data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	
	
		//*************************************************************************
	//profile_for
	//------------------------------------------------------------------------
	// profile_for list
	//------------------------------------------------------------------------
		public function profile_for_list_get(){		
    
		$id =  $this->get('id');
		$tablename = 'profile_for';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is occupation sector data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	
	
	
    //*************************************************************************
	//MATERIAL LIST _for
	//------------------------------------------------------------------------
	// profile_for list
	//------------------------------------------------------------------------
		public function maiterial_status_list_get(){		
    
	
		$tablename = 'maiterial_status';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is maiterial Status list data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}

    //*************************************************************************
	//FOOD LIST _for
	//------------------------------------------------------------------------
	// FOOD LIST 
	//------------------------------------------------------------------------
		public function food_list_get(){		
    
	
		$tablename = 'food_list';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is food list data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}

//*************************************************************************
	//GenderLIST _for
	//------------------------------------------------------------------------
	// FOOD LIST 
	//------------------------------------------------------------------------
		public function gender_list_get(){		
    
	
		$tablename = 'gender';	
    	$lists = $this->user_Model->get_list_all($tablename,$id=null);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is gender list data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}

		//*************************************************************************
	//profile_for
	//------------------------------------------------------------------------
	// profile_for list
	//------------------------------------------------------------------------
		public function searchrecord1_post(){
		$payment_status =$this->req['payment_status'];      
		$gender =$this->req['gender'];  
        $page_number =$this->req['page_number'];
        $recard_perpage = $this->req['recard_perpage'];
        
		$limit = $recard_perpage;
	    $offset = ($page_number-1)*$recard_perpage;
    	$lists = $this->user_Model->getRows1($limit,$offset);
		if(!empty($lists)){
			$msg = "This is occupation sector data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	
	 //***************************************************************************
  // All list Record
  //-------------------------------------------------------------------------


		public function all_list_record_post(){
		  
		$payment_status =$this->req['payment_status'];      
		$gender =$this->req['gender'];  
        $page_number =$this->req['page_number'];
        $recard_perpage = $this->req['recard_perpage'];
        $searchbyname = !empty($this->req['searchbyname']) ? $this->req['searchbyname'] : "";
        $login_user_id = $this->req['login_user_id'];
		$limit = $recard_perpage;
	    $offset = ($page_number-1)*$recard_perpage;
	    
                        
    	$lists = $this->user_Model->getRows($limit,$offset,$gender,$searchbyname);
    
		if(!empty($lists)){
			
				$i=0;
			foreach($lists as $obj){
			    
                    //_________________________________________________________________
                    //  check condition 
                    //_________________________________________________________________
                    $this->db->where('login_user_id',$login_user_id);
                    $query = $this->db->get('user_connection');
                    $result = $query->result_array();
                    $connectedarray= array();
                    foreach($result as $k){
                         $connectedarray[]= $k['requested_user_id']; 
                    }
                 
                    
                    if(in_array($obj['id'], $connectedarray)){
                        
                       
                        
                            $this->db->where('requested_user_id',$obj['id']);
                            $this->db->where('login_user_id',$login_user_id);
                            $query = $this->db->get('user_connection');
                            $result = $query->result_array();
                            // print_r($result[0]['connected_status']);
                            // die();
                            $obj['connection_info']= $result[0]['connected_status'];
                            
                        
                    }else{
                         $obj['connection_info']= '0';
                    }
	                        
                    
                    if($payment_status == '0') {
                    $obj['mobileNo'] = substr($obj['mobileNo'],0,-7)."xxxxxxx";
                    }
                    if($payment_status == '0') {
                    $obj['email'] = "xxxxxxxxxxxxx@xxxxxxxxx";
                    } 
                    //	unset($obj->notes_name);
                    
                    
                    
                    $this->data[$i]=$obj;
                    $i++;
                    }	
		
			
			
			$msg = "This is occupation sector data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	

  //***************************************************************************
  // Search Record
  //-------------------------------------------------------------------------


		public function searchrecord_post(){
		  
		$payment_status =$this->req['payment_status'];      
		$gender =$this->req['gender'];  
        $page_number =$this->req['page_number'];
        $recard_perpage = $this->req['recard_perpage'];
        $searchbyname = !empty($this->req['searchbyname']) ? $this->req['searchbyname'] : "";
        $login_user_id =$this->req['login_user_id'];
        
		$limit = $recard_perpage;
	    $offset = ($page_number-1)*$recard_perpage;
	     
	    if(!empty($searchbyname)){
            	$lists = $this->user_Model->getRows($limit,$offset,$gender,$searchbyname);
                if(!empty($lists)){
                
                	$i=0;
                foreach($lists as $obj){
                    
                    
                    //_________________________________________________________________
                    //  check condition 
                    //_________________________________________________________________
                    $this->db->where('login_user_id',$login_user_id);
                    $query = $this->db->get('user_connection');
                    $result = $query->result_array();
                    $connectedarray= array();
                    foreach($result as $k){
                         $connectedarray[]= $k['requested_user_id']; 
                    }
                    
                    
                    if(in_array($obj['id'], $connectedarray)){
                        
                       
                        
                            $this->db->where('requested_user_id',$obj['id']);
                            $this->db->where('login_user_id',$login_user_id);
                            $query = $this->db->get('user_connection');
                            $result = $query->result_array();
                            // print_r($result[0]['connected_status']);
                            // die();
                            $obj['connection_info']= $result[0]['connected_status'];
                            
                        
                    }else{
                         $obj['connection_info']= '0';
                    }
	                         
                       
                       
                if($payment_status == '0') {
                   $obj['mobileNo'] = substr($obj['mobileNo'],0,-7)."xxxxxxx";
                }
                if($payment_status == '0') {
                   $obj['email'] = "xxxxxxxxxxxxx@xxxxxxxxx";
                } 
                //	unset($obj->notes_name);
                
                
                	
                	$this->data[$i]=$obj;
                	$i++;
                }	
                
                
                
                $msg = "This is occupation sector data";
                $this->set_response(['status' => true,
                    	'message' => $msg,
                    	'code' => REST_Controller::HTTP_OK,
                		'response' => $this->data], REST_Controller::HTTP_OK);
                }else{
                $this->set_response(['status' => false,
                      'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                    'message' =>'Some thing Went Wrong...' ],
                    REST_Controller::HTTP_OK); 
                }	 
	    }
	    else{
	        $this->set_response(['status' => false,
                                 'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                                 'message' =>'please fill data for search' ],
                                  REST_Controller::HTTP_OK); 
    	    }
	}
	
    //***************************************************************************
  // Search Record by lat long
  //-------------------------------------------------------------------------


		public function searchrecord_bylatlang_post(){
		  
		$payment_status =$this->req['payment_status'];      
		$gender =$this->req['gender'];  
        $page_number =$this->req['page_number'];
        $recard_perpage = $this->req['recard_perpage'];
        if(!empty($this->req['latitude']) && !empty($this->req['longitude'])){
        $latitude = $this->req['latitude'];
        $longitude = $this->req['longitude'];
        }
        
       // $longitude = $this->req['longitude'];
		$limit = $recard_perpage;
	    $offset = ($page_number-1)*$recard_perpage;
    	$lists = $this->user_Model->getRows1($limit,$offset,$gender,$latitude,$longitude);
    	
    	
		if(!empty($lists)){
			
				$i=0;
			foreach($lists as $obj){
			 
          if($payment_status == '0') {
               $obj['mobileNo'] = substr($obj['mobileNo'],0,-7)."xxxxxxx";
           }
           if($payment_status == '0') {
               $obj['email'] = "xxxxxxxxxxxxx@xxxxxxxxx";
           } 
          //	unset($obj->notes_name);
           

				
				$this->data[$i]=$obj;
				$i++;
			}	
		
			
			
			$msg = "This is occupation sector data";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	
	//***************************************************************
	//          Connection API
	//---------------------------------------------------------------
	// Add Connection request
	//---------------------------------------------------------------
	public function user_connection_post(){
	    $data['login_user_id'] = $this->req['login_user_id'];
	    $data['requested_user_id'] =$this->req['requested_user_id'];
	    $data['connected_status'] = $this->req['connected_status'];
         if(!empty($data['login_user_id']) && !empty($data['requested_user_id'])){
             
             $duplicate_connection = $this->user_Model->duplicate_check_connection($data['login_user_id'],$data['requested_user_id']);
            
             if ($duplicate_connection !=null){

                $this->set_response(['status' => false, 'message' => 'Already request send', "Error"=> REST_Controller::HTTP_NOT_ACCEPTABLE ], REST_Controller::HTTP_OK);
            }else{
             $insert_id = $this->user_Model->insert('user_connection', $data); 
            
                if($insert_id){
                     $this->set_response([
                         'status' => true, 
                         'code' => REST_Controller::HTTP_OK,
                         'message' => 'connection request send successful'], 
                          REST_Controller::HTTP_OK);
                }else{
                     $this->set_response(['status' => false,
                         'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                         'message' =>'Some thing Went Wrong...' ],
                          REST_Controller::HTTP_OK); 
                }
            }
            
	        
	     }
	}
	
	//---------------------------------------------------------------
	//          list of Connection API
	//---------------------------------------------------------------
    // connection list for connected status  -> 1  (Requested) 
    // connection list for connected status  -> 2  (Accept) 
    // connection list for connected status  -> 3  (Rejected) 
	//---------------------------------------------------------------
	public function connection_list_post(){		
        $data = [];
    	$data['login_user_id']= $this->req['login_user_id'];
    	$data['connected_status'] = $this->req['connected_status'];
    	$lists = $this->user_Model->connection_list($data);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is connection list data status : 1-> Request ,2->Accept,3 ->Reject";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	//---------------------------------------------------------------
	//          list of Connection API
	//---------------------------------------------------------------
    // connection list for connected status  -> 1  (Requested) 
    // connection list for connected status  -> 2  (Accept) 
    // connection list for connected status  -> 3  (Rejected) 
	//---------------------------------------------------------------
	public function connection_recieved_post(){		
        $data = [];
    	$data['requested_user_id']= $this->req['login_user_id'];
    	$data['connected_status'] = $this->req['connected_status'];
    	$lists = $this->user_Model->connection_list_rec($data);
		if(!empty($lists)){
				$i=0;
			foreach($lists as $obj){
			 
            //	unset($obj->notes_name);

				
				$this->data[$i]=$obj;
				$i++;
			}				
			
			$msg = "This is connection list data status : 1-> Request ,2->Accept,3 ->Reject";
			$this->set_response(['status' => true,
		        	'message' => $msg,
		        	'code' => REST_Controller::HTTP_OK,
	        		'response' => $this->data], REST_Controller::HTTP_OK);
        }else{
            $this->set_response(['status' => false,
                  'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                'message' =>'Some thing Went Wrong...' ],
                REST_Controller::HTTP_OK); 
        }	 
	}
	//-------------------------------------------------------------
    //  Connection Accept/Reject
	//---------------------------------------------------------------
		public function connection_accept_or_reject_post(){
	    $data['login_user_id'] = $this->req['login_user_id'];
	    $data['requested_user_id'] =$this->req['requested_user_id'];
	    $data['connected_status'] = $this->req['connected_status'];
	    $data['message'] = !empty($this->req['message']) ? $this->req['message'] : "" ;
         if(!empty($data['login_user_id']) && !empty($data['requested_user_id'])){
            
                     $this->db->set('connected_status',$data['connected_status'] );
                     $this->db->set('message',$data['message'] );
                     $this->db->where('login_user_id', $data['requested_user_id']);
                     $this->db->where('requested_user_id', $data['login_user_id']);
                $updated_id =$this->db->update('user_connection');
            
                if($updated_id){
                     $this->set_response([
                         'status' => true, 
                         'code' => REST_Controller::HTTP_OK,
                         'message' => 'connection successful 2-> Accept ,3 ->Reject'], 
                          REST_Controller::HTTP_OK);
                }else{
                     $this->set_response(['status' => false,
                         'code' => REST_Controller::HTTP_NOT_ACCEPTABLE,
                         'message' =>'Some thing Went Wrong...' ],
                          REST_Controller::HTTP_OK); 
                }
	     }
	}
	
    private function _upload_image($destination) {

        $prev_photo = $this->input->post('prev_photo');
        $photo = $_FILES['image']['name'];
        $photo_type = $_FILES['image']['type'];
        $return_photo = '';
        if ($photo != "") {
            if ($photo_type == 'image/jpeg' || $photo_type == 'image/pjpeg' ||
                    $photo_type == 'image/jpg' || $photo_type == 'image/png' ||
                    $photo_type == 'image/x-png' || $photo_type == 'image/gif') {

               // $destination = 'assets/uploads/student-photo/';

                $file_type = explode(".", $photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $photo_path = 'image-' . time()  . '.' . $extension;

                move_uploaded_file($_FILES['image']['tmp_name'], $destination . $photo_path);

                // need to unlink previous photo
                if ($prev_photo != "") {
                    if (file_exists($destination . $prev_photo)) {
                        @unlink($destination . $prev_photo);
                    }
                }

                $return_photo = $photo_path;
            }
        } else {
            $return_photo = $prev_photo;
        }

        return $return_photo;
    }
	
	private function _upload_photo1() {

        $prev_photo = $this->input->post('prev_photo');
        $photo = $_FILES['photo']['name'];
        $photo_type = $_FILES['photo']['type'];
        $return_photo = '';
        if ($photo != "") {
            if ($photo_type == 'image/jpeg' || $photo_type == 'image/pjpeg' ||
                    $photo_type == 'image/jpg' || $photo_type == 'image/png' ||
                    $photo_type == 'image/x-png' || $photo_type == 'image/gif') {

                $destination = 'assets/uploads/student-photo/';

                $file_type = explode(".", $photo);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $photo_path = 'photo-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['photo']['tmp_name'], $destination . $photo_path);

                // need to unlink previous photo
                if ($prev_photo != "") {
                    if (file_exists($destination . $prev_photo)) {
                        @unlink($destination . $prev_photo);
                    }
                }

                $return_photo = $photo_path;
            }
        } else {
            $return_photo = $prev_photo;
        }

        return $return_photo;
    }
	///***********************************************************************************
	//************************************************************************************
	//                       insert data in table : Notes upload     
	//*************************************************************************************
	//*************************************************************************************
	public function notes_upload_post(){
		
		$data['name']  	= $this->input->post('name');
		$data['category']  = $this->input->post('name');                           
		
		if ($_FILES['photo']['name']) {
		$data['photo'] = $this->_upload_photo1();
		}
		$insert_id = $this->user_Model->insert('notes_upload', $data); 
								
		if($insert_id){
			
			$this->set_response([
			'status' => true, 
			'code' => REST_Controller::HTTP_OK,
			'message' => 'Data uploads successful'
			

			], REST_Controller::HTTP_OK);

		}else{
			$this->set_response(['status' => false,"Error"=>array('code' => REST_Controller::HTTP_NOT_ACCEPTABLE, 
			'message' => 'Some thing Went Wrong...')], REST_Controller::HTTP_OK);
		}	
		
	}
	
	
	
	
	
	
}
