<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class E_library_Model extends CI_Model{
	public function getAllLibrary(){		
		//$this->db->select('I.id,I.subject,I.prop_details,I.added_at,U.first_name,U.email')
		//		 ->from('e_library as I')
		//		 ->join('users as U', 'U.id = I.user_id','inner');
		//return $result = $this->db->get()->result();	
		$query=$this->db->select('*')
						->get('e_library');
		return $query->result();  
		
	}
//Getting particular user deatials on the basis of id	
 public function get_detail_model($uid){
	// $this->db->select('I.id,I.subject,I.prop_details,I.added_at,U.first_name,U.email')
	//			 ->from('innovative as I')
	//			 ->join('users as U', 'U.id = I.user_id','inner')
	//			 ->where('I.id',$uid);
		$query=$this->db->select('*')
						->from('e_library')
						->where('id',$uid);
		///return $query->result();  
		return $result = $this->db->get()->row_array();
 	
 }

 // Function for use deletion
 public function deleteInnovative_model($uid){
$sql_query=$this->db->where('id', $uid)
                ->delete('innovative');
            }

}