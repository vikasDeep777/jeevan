<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class Innovative_Model extends CI_Model{
	public function getusersdetails(){		
		$this->db->select('I.id,I.subject,I.prop_details,I.added_at,U.first_name,U.email')
				 ->from('innovative as I')
				 ->join('users as U', 'U.id = I.user_id','inner');
		return $result = $this->db->get()->result();				
	}
//Getting particular user deatials on the basis of id	
 public function get_innovative_detail_model($uid){
	 $this->db->select('I.id,I.subject,I.prop_details,I.added_at,U.first_name,U.email')
				 ->from('innovative as I')
				 ->join('users as U', 'U.id = I.user_id','inner')
				 ->where('I.id',$uid);
		return $result = $this->db->get()->row_array();
 	
 }

 // Function for use deletion
 public function deleteInnovative_model($uid){
$sql_query=$this->db->where('id', $uid)
                ->delete('innovative');
            }

}