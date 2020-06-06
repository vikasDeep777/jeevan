<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    ///**************************************************************
	
	
	
	 function get_single_auth($table_name, $index_array, $columns = null) {

			if ($columns)
				$this->db->select($columns);

			$this->db->order_by('id', 'desc');
			$this->db->limit(1);

			$row = $this->db->get_where($table_name, $index_array)->row();

			return $row;
		}	
	function duplicate_check($email) {

        if(!empty($email)){
            $this->db->where('email', $email);
        }
        return $this->db->get('users_register')->num_rows();
    }
    function duplicate_check_mobile($mobileNo) {

        if(!empty($mobileNo)){
            $this->db->where('mobileNo', $mobileNo);
        }
        return $this->db->get('users_register')->num_rows();
    }
    
     function duplicate_check_connection($login_user_id,$requested_user_id) {

        if(!empty($login_user_id) && !empty($requested_user_id)){
            
            $this->db->where('login_user_id', $login_user_id);
            $this->db->where('requested_user_id', $requested_user_id);
        }
        return $this->db->get('user_connection')->num_rows();
    }
    
    
	function getsingleuser($id, $password){
        
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
           // $this->db->where('email', $id);
           // $this->db->or_where('user_id', $id);
			$this->db->where("(email='$id' OR mobileNo='$id')");
            $this->db->where('password', $password);
            $row = $this->db->get('users_register')->row();

        return $row;

    }
    
    //--------------------------------------------------------------
    
     function getRows1($limit,$offset,$gender,$lat,$lang)
        
        {
           
          if($gender=='MALE'){
              $gen='FEMALE';
            } 
            else{
             $gen='MALE';
            }
           // if(!empty($lat) && !empty($lang)){
                $query = $this->db->query("SELECT *, 
                    ( 6371 * acos ( cos ( radians($lat) ) 
                    * cos( radians( `latitude` ) ) 
                    * cos( radians( `longitude` ) - radians($lang) ) 
                    + sin ( radians($lat) ) 
                    * sin( radians( `latitude` ) ) ) ) AS distance 
                    FROM users_register 
                    HAVING distance < 450 AND gender = '$gen'
                    ORDER BY distance 
                    LIMIT $offset , $limit");
                   
          //  }
               
              
            $result=$query->result_array();
            
           
            return $result;
        }
        
        
        
        function getRows($limit,$offset,$gender,$searchbyname)
        {
           
           $login_user_id ="81";
           if($gender=='MALE'){
              $this->db->where('gender','FEMALE'); 
            } 
            else{
              $this->db->where('gender','MALE'); 
            } 
            if(!empty($searchbyname)){
              $this->db->like('name',$searchbyname,'both'); 
            } 
           //$this->db->distinct();
          //  $this->db->select('UR.*,UC.connected_status AS connectedstatus');
            $this->db->select('UR.*');
            $this->db->from("users_register AS UR");
            //$this->db->join('user_connection AS UC', 'UC.requested_user_id = UR.id', 'left');
           
           //$where = "(UC.login_user_id= '$login_user_id' or UC.login_user_id = '' or UC.login_user_id = '0'  )";
           //$this->db->where($where);
            
            $this->db->limit($limit,$offset);
            $query=$this->db->get();
            
            $result=$query->result_array();
            
           
            return $result;
        }
        
        
    
    
    //********************** dashboard_slider***********************************
    
    public function get_list_all($tablename,$id=null){
        
        $this->db->select('*');
        $this->db->from($tablename);
        if(!empty($id)){
             $this->db->where('id', $id);
        }
        return $this->db->get()->result();
        
    }
    
    
   public function connection_list($data)
   {
       	
    	$this->db->select("UC.connected_status AS connected_info ,UR.*");
    	$this->db->from('user_connection AS UC');
    	$this->db->join('users_register AS UR','UR.id = UC.requested_user_id');
    	$this->db->where('UC.login_user_id',$data['login_user_id']);
    	$this->db->where('UC.connected_status',$data['connected_status']);
        $query = $this->db->get();
    	return $query->result_array();
   }
    public function connection_list_rec($data)
   {
       	
    	$this->db->select("UC.connected_status AS connected_info ,UC.message,UR.*");
    	$this->db->from('user_connection AS UC');
    	$this->db->join('users_register AS UR','UR.id = UC.login_user_id');
    	$this->db->where('UC.requested_user_id',$data['requested_user_id']);
    	$this->db->where('UC.connected_status',$data['connected_status']);
        $query = $this->db->get();
    	return $query->result_array();
   }
   
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	///**********************************************************
    public function get_teacher_list($school_id = NULL){
        
        $this->db->select('T.*, S.school_name, U.email, U.role_id');
        $this->db->from('teachers AS T');
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->join('schools AS S', 'S.id = T.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id= (!empty($school_id))? $school_id : $this->session->userdata('school_id');
            $this->db->where('T.school_id', $school_id);
        }
        
        return $this->db->get()->result();
        
    }
    public function get_attendance_status($id, $day, $month, $year){
        $field = 'day_' . abs($day) .' AS today_status';
        $this->db->select($field);
        $this->db->from('teacher_attendances');
        $this->db->where('month', $month);
        $this->db->where('year', $year);
        $this->db->where('teacher_id', $id);
        $t_status = $this->db->get()->result_array();
        //echo $this->db->last_query();
        //die();
        if(!empty($t_status)){
            return $t_status[0]['today_status'];
        }else{
            return NULL;
        }
        
    }
    public function get_teacher_list_api($school_id = null, $day = null, $month=null, $year, $user_id=null){       

        $this->db->select('T.*, U.user_id AS teacherId, U.email, U.role_id');
        $this->db->from('teachers AS T');
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        
        $this->db->where('T.status', 1);
        $this->db->where('T.school_id', $school_id);
        if(!empty($user_id)){
            $this->db->where('T.user_id', $user_id);
        }
        $datas = $this->db->get()->result_array();
		
        $item = array();
        $i = 1;
        if($month <=9){ $month = '0'.$month; }
        foreach($datas as $data){
			
            $tstatus = $this->get_attendance_status($data['id'], $day, $month, $year);
            if($tstatus != null){
                $status = explode(",", $tstatus);  
                if(in_array('F', $status)){
                    $first_half = true;
                }else{
                    $first_half = false;
                }
                if(in_array('P', $status)){
                    $second_half = true;
                }else{
                    $second_half = false;
                }
                if(in_array('E', $status)){
                    $early_leave = true;
                }else{
                    $early_leave = false;
                }
                if(in_array('L', $status)){
                    $late = true;
                }else{
                    $late = false;
                }
                if(in_array('A', $status)){
                    $absent = true;
                }else{
                    $absent = false;
                }
            }else{
                $first_half = false;
                $second_half= false;
                $early_leave= false;
                $late= false;
                $absent= false;
            }  
			 if($data['joining_date']==0000-00-00){
				 $data['joining_date']= '';
				}else{
				$date = date_create($data['joining_date']);	 
				$data['joining_date'] = date_format($date, "M d Y ");
				}
			 if($data['resign_date']==0000-00-00){
				$data['resign_date']= '';
				}else{
				$date2 = date_create($data['resign_date']);	 
				$data['resign_date'] = date_format($date2, "M d Y ");
				}
			if($data['dob']==0000-00-00){
				$data['dob']= '';
				}else{
				$date3 = date_create($data['resign_date']);	 
				$data['dob'] = date_format($date3, "M d Y ");
				}					
			if(!empty($data['photo'])){
				$data['profile_image']	= 'https://www.edusams.com/assets/uploads/teacher-photo/'.$data['photo'];
				}
            $data['first_half']     = $first_half;
            $data['second_half']    = $second_half;
            $data['early_leave']    = $early_leave;
            $data['late']           = $late;
            $data['absent']         = $absent;
            $item[] = $data;
        }
        return $item;  
     

    }
    
    public function get_single_teacher($id){
        
        $this->db->select('T.*, U.email, U.role_id, R.name AS role, SG.grade_name');
        $this->db->from('teachers AS T');
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->join('salary_grades AS SG', 'SG.id = T.salary_grade_id', 'left');
        $this->db->where('T.id', $id);
        return $this->db->get()->row();
        
    }
    
        
    
	 function duplicate_userid($userid, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('user_id', $userid);
        return $this->db->get('users')->num_rows();            
    }
	
	public function get_attendances_detail($d, $school_id){
        $today_field = 'day_'. $d;
        $this->db->select('distinct(teacher_id) AS teacher_id,'.$today_field);
        $this->db->from('teacher_attendances');
        $this->db->where('school_id', $school_id); 
        $this->db->where('month',date('m'));
        return $this->db->get()->result();
    }
	
	 public function get_subject_list($school_id = NULL){
        
        $this->db->select('SU.*, S.school_name');
        $this->db->from('subjects AS SU');
      //  $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->join('schools AS S', 'S.id = SU.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id= (!empty($school_id))? $school_id : $this->session->userdata('school_id');
            $this->db->where('SU.school_id', $school_id);
        }
        
        return $this->db->get()->result();
        
    }
	 public function get_periods_list($school_id = NULL){
        
        $this->db->select('P.id ,P.name,P.school_id ,S.school_name');
        $this->db->from('periods AS P');
      //  $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id= (!empty($school_id))? $school_id : $this->session->userdata('school_id');
            $this->db->where('P.school_id', $school_id);
        }
        
        return $this->db->get()->result();
        
    }

}
