<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class App_model extends CI_Model {

    function __construct() {
        parent :: __construct();
    }

	function insert($table, $data) {

        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }
    
    function insert_batch($table,$data = array()){
        $insert = $this->db->insert_batch($table,$data);
        return $insert?true:false;
    }

  function getResultById($table, $where,$limit="",$offset="",$row="", $order_by="") {
        if($order_by){
            $this->db->order_by($order_by,'DESC');
        }
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get_where($table, $where);
       if($row){
        return $query->row_array();
        }
        else{
            return $query->result_array();
        }
    }

    function get_specific_selected_details($select,$table,$where,$result='',$order_by=''){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        if($order_by){
            $this->db->order_by($order_by,'DESC');
        }
        if($result){
            $query =  $this->db->get()->result_array();
        }
        else{
            $query =  $this->db->get()->row_array();
        }
        return $query;
    }
    
    function countrows($table) {
        $query = $this->db->select('*')
                        ->get($table)->num_rows();
        return $query;
    }

    function count_specific_rows($table,$where) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query =  $this->db->get()->num_rows();
        return $query;
    }



    function update($table, $data, $where) {

        if ($this->db->update($table, $data, $where)) {
            
            return true;
        } else {
            return false;
        }
    }

    function get_data($table,$limit="",$offset="") {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }


    function delete_row($table, $where) {
        $this->db->delete($table, $where);
        return true;
    }

    public function getLimitData($table, $limit, $where = false) {
        if($where)
        {
            $this->db->where($where);
        }
        $data = $this->db->get($table, $limit,0);
        return $data->result();
    }


    public function sendmail($data){
        $url = 'https://sendgrid.com/';
        $user = 'lcdhakar87';
        $pass = 'Iws123#*today';

        $boday = $data['message'];
        $params = array(
        'api_user' => $user,
        'api_key' => $pass,
        'to' => $data['to'],
        'subject' => $data['subject'],
        'html' => $boday,
        'text' => 'testing body',
        'from' => 'yogesh@i-webservices.com',
        );


        $request = $url.'api/mail.send.json';

        // Generate curl request
        $session = curl_init($request);
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        curl_close($session);

        return $response;
      }


}

?>