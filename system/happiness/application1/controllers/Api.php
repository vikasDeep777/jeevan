<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	
	public function Login(){

		if(isset($_REQUEST['SubmitBtn']) && ($_REQUEST['SubmitBtn']=='UserLogin') ){

			$email       = $this->security->xss_clean($this->input->get_post('email'));
		    $password    = $this->security->xss_clean($this->input->get_post('password'));
		    
			if($email==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter Email.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			if($password==''){
			    $json_status[] = array("Status"=> false,"Msg"=>"Please Enter Password.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			

			$result = $this->app_model->getResultById('users', array('email'=>$email),$limit="",$offset="",true);	
		    if(!empty($result)){
		    	if($result['password']==md5($password)){
		    		
		    		$this->app_model->update('users',array('device_token'=>$_POST['device_token']), array('id'=>$result['id']));
		    		$LoginResult[] = array("Status"=>true,
		    								"msg"=> "logged in successfully",
			                               "data" =>array(  
			                               					"id"=>$result['id'],
			                               					"first_name"=>$result['first_name'],
			                               					"email"=>$result['email'],
			                               					"mobile"=>$result['mobile'],
			                               					"device_token"=>$_POST['device_token'],
			                               					),
			                           	);
				}
				else{
				$LoginResult[] = array("Status"=> false,"Msg"=>"Incorrect Login Details. Please try again.",'data'=>"");
			}
		}
			else{
				$LoginResult[] = array("Status"=> false,"Msg"=>"Incorrect Login Details. Please try again.",'data'=>"");
			}
			$json_status['Result'] 	= $LoginResult;
		    echo json_encode($json_status); 
		    exit;

		}else{
			$json_status[] = array("Status"=> false,"Msg"=>"invalid login.",'data'=>"");
		    echo json_encode(array('Result' => $json_status));
		    exit;
		}
	}


public function signup(){

		if(isset($_REQUEST['SubmitBtn']) && ($_REQUEST['SubmitBtn']=='UserSignup') ){

		    $data['first_name']    = $this->security->xss_clean($this->input->get_post('name'));
		    $data['email']       = $this->security->xss_clean($this->input->get_post('email'));
		    $data['password']    = $this->security->xss_clean(md5($this->input->get_post('password')));
		    $data['mobile']   = 	$this->security->xss_clean($this->input->get_post('mobile'));
		    $data['added_at'] = date('Y-m-d h:i:s');
		    
			
		    if($data['first_name']==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter Name.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			
			if($data['email']==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter Email.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			if($data['password']==''){
			    $json_status[] = array("Status"=> false,"Msg"=>"Please Enter Password.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			if($data['mobile']==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter mobile number.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			$check_mail = $this->app_model->getResultById('users', array('email'=>$data['email']),$limit="",$offset="",true);
			
			if(!empty($check_mail)){
				$json_status[] = array("Status"=> false,"Msg"=>"Sorry, but email already exists.");
				    echo json_encode(array('Result' => $json_status));
				    exit;
			}
			else{

			$result = $this->app_model->insert('users',$data);	
		    if($result){
		    	$SignupResult[] = array("Status"=>true,
			                               "msg" => "user details submitted successfully"
			                               );
				}else{
		    		$SignupResult[] = array("Status"=> false,"Msg"=>"Sorry , There is some technical issue");
		    	}
			
			$json_status['Result'] 	= $SignupResult;
		    echo json_encode($json_status); 
		    exit;
		}

	}else{
			$json_status[] = array("Status"=> false,"Msg"=>"Please input some details.");
		    echo json_encode(array('Result' => $json_status));
		    exit;
		}

	}


	public function get_reward(){


		if(isset($_REQUEST['SubmitBtn']) && ($_REQUEST['SubmitBtn']=='GetReward') ){

			$user_id       = $this->security->xss_clean($this->input->get_post('user_id'));
		    
		    
			if($user_id==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter User id.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			

			$result = $this->app_model->getResultById('user_ratings', array('user_id'=>$user_id),$limit="",$offset="",true);	
		    if(!empty($result)){
		    		
		    		$LoginResult[] = array("Status"=>true,
		    								"msg"=> "rewards of user",
			                               "data" =>array(  
			                               					"counter"=>$result['counter'],
			                               					"rating"=>$result['rating']
			                               					),
			                           	);
			
		}
			else{
				$LoginResult[] = array("Status"=> false,"Msg"=>"Incorrect Login Details. Please try again.",'data'=>"");
			}
			$json_status['Result'] 	= $LoginResult;
		    echo json_encode($json_status); 
		    exit;

		}else{
			$json_status[] = array("Status"=> false,"Msg"=>"invalid login.",'data'=>"");
		    echo json_encode(array('Result' => $json_status));
		    exit;
		}

	}

	public function innovative_form(){

		if(isset($_REQUEST['SubmitBtn']) && ($_REQUEST['SubmitBtn']=='InnovativeForm') ){

		    $data['subject']    = $this->security->xss_clean($this->input->get_post('subject'));
		    $data['prop_details']       = $this->security->xss_clean($this->input->get_post('details'));
		    $data['user_id']       = $this->security->xss_clean($this->input->get_post('user_id'));

		    $data['added_at'] = date('Y-m-d h:i:s');
		    
			
		    if($data['subject']==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter Subject.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			
			if($data['prop_details']==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter Details.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}

			if($data['user_id']==''){
				$json_status[] = array("Status"=> false,"Msg"=>"Please Enter User Id.");
			    echo json_encode(array('Result' => $json_status));
			    exit;
			}
			
			

			$result = $this->app_model->insert('innovative',$data);


		    if($result){

		    	$innovative = $this->app_model->getResultById('user_ratings', array('user_id'=>$data['user_id']),$limit="",$offset="",true);	
			    $rating = "";
			    if(!empty($innovative)){

			    	$this->app_model->update('user_ratings',array('rating'=>($innovative['rating']+5),'counter'=>($innovative['counter']+1) ), array('id'=>$innovative['id']));
			    	$rating = $innovative['rating']+5;


			    }else{

			    	$this->app_model->insert('user_ratings',array('rating'=>5,'user_id'=>$data['user_id'],'counter'=>1), array('id'=>$innovative['id']));
			    	$rating = 5;
			    }

		    	$SignupResult[] = array("Status"=>true,
			                               "msg" => "Form submitted successfully",
			                               "rating"=> $rating
			                               );
				}else{
		    		$SignupResult[] = array("Status"=> false,"Msg"=>"Sorry , There is some technical issue","rating"=>"");
		    	}
			
			$json_status['Result'] 	= $SignupResult;
		    echo json_encode($json_status); 
		    exit;
		}
		else{
			$json_status[] = array("Status"=> false,"Msg"=>"Please input some details.","rating"=>"");
		    echo json_encode(array('Result' => $json_status));
		    exit;
		}

	}
}
