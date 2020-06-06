<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * ***************Auth.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Auth
 * @description     : This class used to handle user authentication functionality 
 *                    of the application.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Auth extends CI_Controller {

    public $academic_year_id = '';
    public $data = array();

    public function __construct() {

        parent::__construct();
        $this->load->model('Auth_Model', 'auth', true);
        
        $academic_year = $this->db->get_where('academic_years', array('is_running'=>1))->row();
        if($academic_year){
            $this->academic_year_id = $academic_year->id;
        }
    }

    /****************Function login**********************************
     * @type            : Function
     * @function name   : login
     * @description     : Authenticatte when uset try lo login. 
     *                    if autheticated redirected to logged in user dashboard.
     *                    Also set some session date for logged in user.   
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function login() {
        if ($_POST) {

            $data['email'] = $this->input->post('email');
            $data['user_id'] = $this->input->post('email');
            $data['password'] = md5($this->input->post('password'));
			$id = (!empty($data['email']))? $data['email'] : $data['user_id'];
            $login = $this->auth->getsingle($id, $data['password']);
	        $email = $this->input->post('email');
            $password = ($this->input->post('password'));
			$remember= $this->input->post('remember');
            if (!empty($login)) {

                // check user active status
                if (!$login->status) {
                    $this->session->set_flashdata('error', $this->lang->line('user_active_status'));
                    redirect();
                }

                // check is setting role permission by admin

                $privileges = $this->auth->get_list('privileges', array('role_id' => $login->role_id));

                if (empty($privileges)) {
                     $this->session->set_flashdata('error', $this->lang->line('privilege_not_setting'));
                    redirect();
                }

                $this->session->set_userdata('id', $login->id);

                $this->session->set_userdata('role_id', $login->role_id);
                $this->session->set_userdata('is_default', $login->is_default);

                $this->session->set_userdata('email', $login->email);
                $this->session->set_userdata('school_id', $login->school_id);
                

                if ($login->role_id == STUDENT) {
                    $profile = $this->auth->get_single('students', array('user_id' => $login->id));
                   // $profile = $this->auth->get_single_student($login->id);
                  // $this->session->set_userdata('class_id', $profile->class_id);
                    
                } elseif ($login->role_id == GUARDIAN) {
                    $profile = $this->auth->get_single('guardians', array('user_id' => $login->id));
                } elseif ($login->role_id == TEACHER) {
                    $profile = $this->auth->get_single('teachers', array('user_id' => $login->id));
                } else {
                    $profile = $this->auth->get_single('employees', array('user_id' => $login->id));
                }  
	
                if($login->is_default){
                    $this->session->set_userdata('user_name', 'Super Admin');
                }
                
                 if (isset($profile->name)) {
                   $this->session->set_userdata('name', $profile->name);
                }
                if (isset($profile->phone)) {
                    $this->session->set_userdata('phone', $profile->phone);
                }
                if (isset($profile->photo)) {
                    $this->session->set_userdata('photo', $profile->photo);
                }
                if (isset($profile->user_id)) {                
                    $this->session->set_userdata('user_id', $profile->user_id);
                }
                if (isset($profile->id)) {
                    $this->session->set_userdata('profile_id', $profile->id);
                }
                
                // set appliction theme
                $theme = $this->auth->get_single('themes', array('is_active' => 1));
                $this->session->set_userdata('theme', $theme->slug);

                // set appliction setting
                if($login->role_id != SUPER_ADMIN){                    
                    $setting = $this->auth->get_single('schools', array('status' => 1, 'id'=>$login->school_id));
                    if (isset($setting->school_name)) {
                        $this->session->set_userdata('school_name', $setting->school_name);
                    }                    
                }

				
                $this->auth->update('users', array('last_logged_in' => date('Y-m-d H:i:s')), array('id' => logged_in_user_id()));
                success($this->lang->line('login_success'));
                if($remember != NULL){
				setcookie('email',$email,time()+(86400 * 30),"/");
				setcookie('password',$password,time()+(86400 * 30),"/");	
				//print_r('set');
				//exit();				
				}
				
				
			   redirect('dashboard');

                /*if($login->role_id == 1){
                redirect('dashboard/index');
                }else{
                    redirect('my-account');
                }*/
                
            } else {
                // $this->lang->line('invalid_login')
                $this->session->set_flashdata('error', 'Invalid User Id/password Or Account is not active.');
                redirect('login');
            }
        }
        redirect('login');
    }

    /*     * ***************Function logout**********************************
     * @type            : Function
     * @function name   : logout
     * @description     : Log Out the logged in user and redirected to Login page  
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function logout() {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('email');

        $this->session->unset_userdata('name');
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('photo');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('profile_id');
        $this->session->unset_userdata('theme');

        // set appliction setting
        $this->session->unset_userdata('school_name');
        $this->session->unset_userdata('currency');
        $this->session->unset_userdata('currency_symbol');
        $this->session->unset_userdata('language');
        $this->session->unset_userdata('running_year');
        $this->session->unset_userdata('school_email');
        $this->session->unset_userdata('school_phone');

        $this->session->sess_destroy();
		setcookie('email',"",time() -3600);
		setcookie('password',"",time()-3600);
			
        redirect();
        exit;
    }

    /*     * ***************Function forgot**********************************
     * @type            : Function
     * @function name   : forgot
     * @description     : Load recover forgot password view file  
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function forgot() {

        $this->load->helper('form');
        $data = array();
        $this->load->view('forgot', $data);
    }

    /*     * ***************Function forgotpass**********************************
     * @type            : Function
     * @function name   : forgotpass
     * @description     : this function is used to send recover forgot password  email 
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function forgotpass() {

        if ($_POST) {

            $data['email'] = $this->input->post('email');
            $data['status'] = 1;
            $login = $this->auth->get_single('users', $data);
            if (!empty($login)) {

                $this->_send_email($login);
                $this->session->set_flashdata('success', $this->lang->line('reset_email_success'));
            } else {
                $this->session->set_flashdata('error', $this->lang->line('wrong_email'));
            }
        }

        redirect('auth/forgot');
        exit;
    }

    /*     * ***************Function _send_email**********************************
     * @type            : Function
     * @function name   : _send_email
     * @description     : this function used to send recover forgot password email 
     * @param           : $data array(); 
     * @return          : null 
     * ********************************************************** */

    private function _send_email($data) {

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		$config['smtp_user'] = "admin@edusams.com"; 
		$config['smtp_pass'] = '$P$BWg6VpCVDat';
        $this->email->initialize($config);

       // $setting = $this->auth->get_single('schools', array('status' => 1));
        $this->email->from('admin@edusams.com','Edusams.com');
        //$this->email->from($setting->email, $setting->school_name);
        $this->email->to($data->email);
        $this->email->subject('Edusams : Password reset Email');
        $key = uniqid();
        $this->auth->update('users', array('reset_key' => $key), array('id' => $data->id));

        // $message = 'You have requested to reset your  Edusams web Application login password.<br/>';
        // //$message = 'You have requested to reset your ' . $setting->school_name . ' web Application login password.<br/>';
        // $message .= 'To reset you password plese click following url<br/><br/>';
        // $message .= site_url('auth/reset/' . $key);
        // $message .= '<br/><br/>';
        // $message .= 'If you did not  request to reset your password, Plesae ignore this email.<br/><br/>';
        // $message .= 'Thank you<br/>';
        // $message .= 'Edusams Team';

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
            <td colspan="2" style="background-color:#121c5b; border-radius: 8px 8px 0 0;
               padding: 7px 0;">
               <img  margin:0 auto; display:block" src="https://www.edusams.com//assets/images/mailer-slogo.png">
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h2 style="text-align:center;">You have requested to reset your web Application login password.</h2>
            </td>
         </tr>
         <tr>
            <td colspan="2">
            <br/>
               <a href="'.site_url('auth/reset/' . $key).'"><img style="max-width:100%;" src="https://www.edusams.com//assets/images/reset_pwd.png"></a>
            <br/>      
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <p style="margin-bottom:20px">If you did not request to reset your password, Plesae ignore this email.</p>
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

        $this->email->message($message);
        $this->email->send();
    }

    /*     * ***************Function reset**********************************
     * @type            : Function
     * @function name   : reset
     * @description     : this function used to load password reset view file 
     * @param           : $key string parameter; 
     * @return          : null 
     * ********************************************************** */

    public function reset($key=null) {

        $data = array();
        $this->load->helper('form');
        $user = $this->auth->get_single('users', array('reset_key' => $key));

        if (!empty($user)) {
            $data['user'] = $user;
            $data['key'] = $key;
            $this->load->view('reset', $data);
        } else {
            $this->session->set_flashdata('error', $this->lang->line('unexpected_error'));
            redirect();
        }
    }

    /*     * ***************Function resetpass**********************************
     * @type            : Function
     * @function name   : resetpass
     * @description     : this function used to reset user passwrd 
     *                    after sucessfull reset password it's redirected
     *                    user to log in page            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */

    public function resetpass() {

        if ($_POST) {

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('conf_password', $this->lang->line('conf_password'), 'trim|required|matches[password]');

            if ($this->form_validation->run() === TRUE) {
                $data['password'] = md5($this->input->post('password'));
                $data['temp_password'] = base64_encode($this->input->post('password'));
                $data['reset_key'] = NULL;
                $data['modified_at'] = date('Y-m-d H:i:s');
                $data['modified_by'] = logged_in_user_id();
                $this->auth->update('users', $data, array('id' => $this->input->post('id')));
                $this->session->set_flashdata('success', $this->lang->line('update_success'));
                redirect('login');
            } else {
                $this->session->set_flashdata('error', $this->lang->line('password_reset_error'));
                redirect('auth/reset/' . $this->input->post('key'));
            }
        }

        redirect();
        exit;
    }
    public function resend_con(){

        if ($_POST) {
          
           $email=$this->input->post('resend');
           $this->db->select('email');                                           
          // $this->db->where('type', 'notice');
           $this->db->where('email', $email);
           $query = $this->db->get('users');
           $result = $query->result();
           $num = $query->num_rows();
         
           if($num>0 )
           {

         //  print_r($email);
         //  die();
           $key = md5($email . date('mY')); 
           $data['activation_key'] = $key;
          
           $info ='<!doctype html>
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
               <img  margin:0 auto; display:block" src="https://www.edusams.com//assets/images/mailer-slogo.png">
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
           $updated = $this->auth->update('users', $data, array('email' =>$email));
           mail1($email,$info);
           success($this->lang->line('success'));
           redirect('login'); 
           }else{     
             error($this->lang->line('unsuccess'));
            redirect('login'); 
           }
        }
    }

}
