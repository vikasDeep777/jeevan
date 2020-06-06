<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
Class ManageUsers_Model extends CI_Model{
	public function getusersdetails(){
		//$query=$this->db->select('id,first_name,email,mobile,added_at,updated_at')
		//              ->get('users');
		//       return $query->result(); 

$this->db->select('U.id,U.first_name,U.email,U.mobile,U.added_at,U.updated_at,UR.counter,UR.rating')
				 ->from('users as U')
				 ->join('user_ratings as UR', 'UR.user_id = U.id','left');
		return $result = $this->db->get()->result();				
	}
//Getting particular user deatials on the basis of id	
 public function getuserdetail($uid){
 	$ret=$this->db->select('id,first_name,email,mobile,password,added_at,updated_at')
 	              ->where('id',$uid)
 	              ->get('users');
 	                return $ret->row_array();
 }

 // Function for use deletion
 public function deleteuser($uid){
$sql_query=$this->db->where('id', $uid)
                ->delete('users');
            }

}