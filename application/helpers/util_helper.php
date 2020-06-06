<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


       function mail1($email,$info, $subject=null){
          
        $ci = & get_instance();
        $ci->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        //$config['smtp_host'] = "ssl://smtp.googlemail.com";
        //$config['smtp_port'] = "465";
        $config['smtp_user'] = "support@appzdigital.com"; 
        $config['smtp_pass'] = '$P$BWg6VpCVDat';
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
         $sup= trim("support@appzdigital.com");
         $mt = trim("pro");
        $ci->email->initialize($config);
        $ci->email->from($sup,$mt);
        $ci->email->to(trim($email));
        $ci->email->reply_to($sup,$mt);
        $subject = (!empty($subject))? $subject : 'Thanks you';
        $ci->email->subject(trim($subject));
        $ci->email->message(trim($info));
        $ci->email->send();
       
    }

    function send_notice($datas){
        $data = array();
        $statuss = '';
		$prev_status ='';
		$prev_pos ='';
		$priv_data ='';
		$prev_status1 = '';
        $school_id = (!empty($_SESSION['school_id']))? $_SESSION['school_id'] : '';

        if(!empty($datas->day)){
            $date = $datas->today .'-'. $datas->month .'-'. $datas->year;
            $data['to_user_id']   		= $datas->guardian_user_id;
            $data['guardian_user_id']   = $datas->guardian_user_id;
            $data['student_user_id']    = $datas->student_user_id;
            $data['n_id']               = $datas->student_user_id;
            $data['year']               = $datas->year;
            $data['month']              = $datas->month;
            $data['day']                = $datas->today;
            $data['student_name']       = $datas->student_name;
            //$data['status']           = $datas->day;
            $data['school_id']          = (!empty($datas->school_id))? $datas->school_id : $school_id;
            $data['role_id']            = 3;
            $data['type']               = 'student_attendance';
            $data['n_date']             = date('M j, Y', strtotime($date));
            $data['n_name']             = $datas->student_name;
            $data['n_title']            = 'Your Learner Attendance Status';
            
            $users_datas = getuserbyid($datas->guardian_user_id);
            //notification_status
            if(!empty($users_datas)){
                foreach($users_datas as $users_d){
                    if($users_d->device_token != '' && $users_d->notification_status ==1){
                        $array = array(
                            'title'             => 'Your Learner Attendance Status', 
                            'id'                => $datas->guardian_user_id, 
                            'student_user_id'   => $datas->student_user_id, 
                            'name'              => $datas->student_name, 
                            'date'              => date('M j, Y', strtotime($date)),
                            'day'               => $datas->today,
                            'month'             => $datas->month,
                            'year'              => $datas->year
                            );
                        $ci = & get_instance();
                        $ci->db->select('status');
                        $ci->db->from('notification');
                        $ci->db->where('guardian_user_id', $datas->guardian_user_id);
                        $ci->db->where('student_user_id', $datas->student_user_id);
                        $ci->db->where('year', $datas->year);
                        $ci->db->where('month', $datas->month);
                        $ci->db->where('day', $datas->today);
                        $prev_res = $ci->db->get()->result();
                        if(!empty($prev_res)){
                            foreach ($prev_res as $prev_re) {
                                $prev_status[] = $prev_re->status;
                            }
                        }
                        $fpos = strpos($datas->day, ',');
                        if($fpos){
                            $statuss = explode(',', $datas->day);
                            foreach($statuss as $status){
                                $data['status'] = $status;
                                if(!empty($prev_status)){                                   
                                    if(! in_array($status, $prev_status)){
                                        $ci->db->insert('notification', $data); 
                                    }
                                }else{
                                    if(!empty($prev_status)){
                                        if(! in_array($status, $prev_status)){
                                            $ci->db->insert('notification', $data);
                                        }
                                    }else{
                                        $ci->db->insert('notification', $data);
                                    }
                                    
                                }
                            }
                        }else{
                            $data['status'] = $datas->day;
                            if(!empty($prev_status)){
                                if (! in_array($datas->day, $prev_status)){ 
                                    $ci->db->insert('notification', $data);
                                }
                            }else{  
                                $ci->db->insert('notification', $data);            
                            }
                        }
                        //
                        // if(!empty($prev_status)){
                        //     if(strpos($datas->day, ',')){
                        //         $curr_status = explode(',', $datas->day);
                        //         $arr_check = array_diff($prev_status, $curr_status);
                        //         $up_status = array_unique($arr_check));
                        //         echo "hi";
                        //     }
                        // }
                        get_attendance_status_text($datas->day, $array, $users_d->device_token);
                    }
                }
            }else{
              return 0;  
            }       
        }else{
            return 2;
        }
    }
	


