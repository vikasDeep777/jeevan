<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class Feedback_Model extends CI_Model{
	public function getFeedbacks(){		
		$this->db->select('UF.id,UF.rated,UF.feedback,UF.added_at,U.first_name,U.email')
				 ->from('user_feedback as UF')
			     ->join('users as U', 'U.id = UF.user_id','inner');
		return $result = $this->db->get()->result();				
	}
//Getting particular user deatials on the basis of id	
 public function get_feedback_detail_model($uid){
	 $this->db->select('UF.id,UF.feedback,UF.rated,UF.added_at,U.first_name,U.email')
				 ->from('user_feedback as UF')
				 ->join('users as U', 'U.id = UF.user_id','inner')
				 ->where('UF.id',$uid);
		return $result = $this->db->get()->row_array();
 	
 }

 // Function for use deletion
 public function deleteFeedback_model($uid){
$sql_query=$this->db->where('id', $uid)
                ->delete('user_feedback');
            }

}