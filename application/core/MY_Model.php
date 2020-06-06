<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    // insert new data

    function insert($table_name, $data_array) {

        $this->db->insert($table_name, $data_array);

        return $this->db->insert_id();
    }

    // insert new data

    function insert_batch($table_name, $data_array) {

        $this->db->insert_batch($table_name, $data_array);

        return $this->db->insert_id();
    }

    // update data by index

    function update($table_name, $data_array, $index_array) {

        $this->db->update($table_name, $data_array, $index_array);

      return  $this->db->affected_rows();
        // $this->db->last_query(); die();


    }
	
	function update1($table_name, $data_array) {

    $this->db->update($table_name, $data_array);

    return $this->db->affected_rows();
 }

    // delete data by index

    function delete($table_name, $index_array) {
        $this->db->delete($table_name, $index_array);

        return $this->db->affected_rows();
    }

    public function get_list($table_name, $index_array, $columns = null, $limit = null, $offset = 0, $order_field = null, $order_type = null) {

        if ($columns)
            $this->db->select($columns);

        if ($limit)
            $this->db->limit($limit, $offset);

        if ($order_type) {
            $this->db->order_by($order_field, $order_type);
        } else {
            $this->db->order_by('id', 'DESC');
        }

        return $this->db->get_where($table_name, $index_array)->result();
		
    }

    // get data list by index order

    function get_list_order($table_name, $index_array, $order_array, $limit = null) {

        if ($limit) {

            $this->db->limit($limit);
        }

        if ($order_array) {

            $this->db->order_by($order_array['by'], $order_array['type']);
        } else {

            $this->db->order_by('created', 'desc');
        }

        return $this->db->get_where($table_name, $index_array)->result();
    }

    // get single data by index

    function get_single($table_name, $index_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('id', 'desc');
        $this->db->limit(1);

        $row = $this->db->get_where($table_name, $index_array)->row();

        return $row;
    }
    function getsingle($id, $password){
        
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
           // $this->db->where('email', $id);
           // $this->db->or_where('user_id', $id);
			$this->db->where("(email='$id' OR user_id='$id')");
            $this->db->where('password', $password);
            $row = $this->db->get('users')->row();

        return $row;

    }
    function getsingle_api($id, $password){
        
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $this->db->where('email', $id);
            $this->db->or_where('user_id', $id);
            $this->db->where('password', $password);
            $row = $this->db->get('users')->result();

        return $row;

    }
    function get_single_random($table_name, $index_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('rand()');
        $this->db->limit(1);
        $row = $this->db->get_where($table_name, $index_array)->row();
        return $row;
    }

    // get number of rows in database

    function count_all($table_name, $index_array = null) {

        if ($index_array) {
            $this->db->where($index_array);
        }
        return $this->db->count_all_results($table_name);
    }

    // get data with paging

    function get_paged_list($table_name, $index_array, $url, $segment, $offset = 0, $order_by = null) {

        $result = array('rows' => array(), 'total_rows' => 0);



        $this->load->library('pagination');



        $limit = $this->config->item('admin_per_page');



        $this->db->where($index_array);



        $this->db->order_by('id', 'desc');


        /* if($order_by){
          $this->db->order_by('sort_order', 'ASC');
          }else{
          $this->db->order_by('modified', 'desc');
          } */


        $result['rows'] = $this->db->get($table_name, $limit, $offset)->result();


        $this->db->where($index_array);

        $result['total_rows'] = $total_rows = $this->db->count_all_results($table_name);


        $config['uri_segment'] = $segment;

        $config['base_url'] = site_url() . $url;

        $config['total_rows'] = $total_rows;

        $config['per_page'] = $this->config->item('admin_per_page');



        $this->pagination->initialize($config);

        $result['pagination'] = $this->pagination->create_links();



        return $result;
    }

// get data with paging

    function get_paged_list_order($table_name, $index_array, $order_array, $limit = 10, $offset = 0) {

        $result = array('rows' => array(), 'total_rows' => 0);



        if ($order_array) {

            $this->db->order_by($order_array['by'], $order_array['type']);
        } else {

            $this->db->order_by('created', 'desc');
        }



        $this->db->where($index_array);

        $result['rows'] = $this->db->get($table_name, $limit, $offset)->result();



        $this->db->where($index_array);

        $result['total_rows'] = $this->db->count_all_results($table_name);



        return $result;
    }

    public function send_email($mail_info) {



        $this->load->library('email');



        $config['mailtype'] = 'html';

        $config['charset'] = 'iso-8859-1';

        $config['wordwrap'] = TRUE;



        $this->email->initialize($config);



        $from = $mail_info['from'] ? $mail_info['from'] : '';

        $from_name = $mail_info['from_name'] ? $mail_info['from_name'] : '';

        $to = $mail_info['to'] ? $mail_info['to'] : 'yousuf361@gmail.com';

        $cc = $mail_info['cc'] ? $mail_info['cc'] : '';

        $bcc = $mail_info['bcc'] ? $mail_info['bcc'] : '';

        $subject = $mail_info['subject'] ? $mail_info['subject'] : '';

        $message = $mail_info['message'] ? $mail_info['message'] : '';



        $this->email->from($from, $from_name);

        $this->email->to($to);

        $this->email->cc($cc);

        $this->email->bcc($bcc);

        $this->email->subject($subject);

        $this->email->message($message);



        return ($this->email->send()) ? TRUE : FALSE;



        //echo $this->email->print
    }

    // get single data by index

    function get_single_order($table_name, $index_array, $order_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->limit(1);

        if ($order_array) {

            $this->db->order_by($order_array['by'], $order_array['type']);
        } else {

            $this->db->order_by('created', 'desc');
        }

        $row = $this->db->get_where($table_name, $index_array)->row();

        return $row;
    }


    public function get_table_fields($table) {

        return $this->db->list_fields($table);
    }
    public function update_user_email($user_id,$email, $password = null){
        $data = array('email'=>$email);
        if(!empty($password)){
            $data['password'] = md5($password);
        }
        $this->db->update('users', $data, array('id'=> $user_id));
    }
    public function create_user($schoolid = NULL, $user_id=null, $role_id = null, $password=null, $email=null){
        
        $data = array();
        if(!empty($schoolid)){
            $data['school_id']    = $schoolid;
        }
        if(!empty($this->input->post('school_id'))){
            $data['school_id']    = $this->input->post('school_id');   
        }
        
        if(!empty($user_id)){ $data['user_id'] = $user_id; }
        //user_id
        $post_user_id = $this->input->post('userid');
        if(!empty($post_user_id)){ $data['user_id'] = $post_user_id; }
        
        $data['role_id']    = (!empty($role_id)) ? $role_id : $this->input->post('role_id');
		
        $data['password']   = (!empty($password)) ? md5($password) : md5($this->input->post('password'));
        $data['temp_password'] = (!empty($password)) ? base64_encode($password) : base64_encode($this->input->post('password'));
        $data['email']      = (!empty($email)) ? $email : $this->input->post('email');
       // $data['email']      =  $this->input->post('email');
		$data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $data['status']     = 1; // by default would be able to login
#################################################################################################

        if(!empty($data['user_id'])){
            $this->db->where('user_id', $data['user_id']);
            $row = $this->db->get('users')->row();
        }
        if(!empty($row)){
            $role_id = $row->role_id;
            $u_id = $row->id;
            $userid = $row->user_id;

            if(($role_id == 1) || ($role_id == 2)){
				 //$this->db->insert('users', $data);
                //return $this->db->insert_id();
			
               
				 return $u_id;
            }else{
                /*$this->db->insert('users', $data);
                return $this->db->insert_id();*/
				 $data['user_id'] = $userid;
				
                $this->db->update('users', $data, array('user_id'=> $userid));
                return $u_id;
            }
        }else{
            $this->db->insert('users', $data);
            return $this->db->insert_id();
        }
###################################################################################################

        //$this->db->insert('users', $data);
        //return $this->db->insert_id();
    }
    
   public function get_custom_id($table, $prefix)
   {
      $max_id = '';
      $this->db->select_max('id');
      $max_id = $this->db->get($table)->row()->id;
      
      if(isset($max_id) && $max_id > 0)
      {
        $max_id = $max_id+1;
      }else{
          $max_id = 1;
      }
      
      if(!$max_id){
        $max_id = '0000'.$max_id;
      }elseif($max_id > 0 && $max_id < 10){
          $max_id = '0000'.$max_id;      
      }elseif($max_id >= 10 && $max_id < 100){
          $max_id = '000'.$max_id;
      }elseif($max_id >= 100 && $max_id < 1000){
          $max_id = '00'.$max_id;
      }elseif($max_id >= 1000 && $max_id < 10000){
          $max_id = '0'.$max_id;
      }else{
          $max_id = $max_id;
      }      
      return $prefix.$max_id;
   }  
   
    public function get_user_premission($module_slug, $operation_slug, $role_id)
    {
       $sql = "SELECT P.*
               FROM isl_modules AS M
               LEFT JOIN isl_operations AS O ON O.module_id = M.id
               LEFT JOIN isl_privileges AS P ON P.operation_id = O.id
               WHERE P.role_id = $role_id 
               AND O.operation_slug = '$operation_slug' 
               AND M.module_slug = '$module_slug'
              ";
       return $this->db->query($sql)->row();
    }
	public function find_data($id)
	{
		$q =$this->db->select(['school_name'])
						->where('id',$id)
						->get('schools');
			return $q->row();
	}
    public function find_data_class($id)
	{
		$q =$this->db->select(['name'])
						->where('id',$id)
						->get('classes');
			return $q->row();
	}
	public function find_data_section($id)
	{
		$q =$this->db->select(['name'])
						->where('id',$id)
						->get('sections');
			return $q->row();
	}
	public function find_data_guardians($id)
	{
		$q =$this->db->select(['name'])
						->where('id',$id)
						->get('guardians');
			return $q->row();
	}
    public function get_userid($table, $user_id){
        $q =$this->db->select(['user_id'])
                        ->where('user_id',$user_id)
                        ->get($table);
            return $q->row();
    }
	public function classdata($id)
										{
										$q =$this->db->select(['class_id'])
										->where('student_id',$id)
										->get('enrollments');
										return $q->row();
										}
}

?>