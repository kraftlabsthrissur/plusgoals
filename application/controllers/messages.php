<?php

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
/**
 * @property privilegemodel $privilegemodel Description
 * 
 */
// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK

class Messages extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('routemodel');
        $this->load->model('list_model');
        $this->load->model('privilegemodel');
        $this->load->model('expensemodel');
        $this->load->model('callmodel');
        $this->load->model('messagemodel');
    }

    public function list_user() {

        $user_data = $this->session->userdata('userdata');
        // $where ="1 = 1 and (um.umIsSalesRep=1 or um.umIsManager=1)";
        if (isset($_POST['user_name'])) {   //$_POST['user_name']  is an id of manager
            //$w = "1=1 and umid='" . $_POST['user_name'] . "'"; //$w=>subordinate users 
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($_POST['user_name']);
            //echo $this->db->last_query(); die();
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $_POST['user_name'];
            } else {
                $subordinate_users = $_POST['user_name'] . ',' . $subordinate_users;
            }
            //$w = "umid in (" . $subordinate_users . ")"; //$w=>subordinate users  
            $w = "1=1"; //$w=>subordinate users
            $where = "1 = 1 and (um.umIsSalesRep=1 or um.umIsManager=1) and umid in (" . $subordinate_users . ")"; //table data
        } else {
            $w = "1=1"; //$w=>subordinate users  
            $where = "1 = 1 and (um.umIsSalesRep=1 or um.umIsManager=1)"; //table data
        }


        if ($user_data['umId'] != 1) {

            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }

            if (isset($_POST['user_name'])) {

                $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($_POST['user_name']);
                $subordinate_users = $data['subordinate_users']['user_id'];

                if ($subordinate_users == null) {
                    $subordinate_users = $_POST['user_name'];
                } else {
                    $subordinate_users = $_POST['user_name'] . ',' . $subordinate_users;
                }
                $w = "umid in (" . $subordinate_users . ")"; //$w=>subordinate users  
                $where = "um.umid in (" . $subordinate_users . ") and (um.umIsSalesRep=1 or um.umIsManager=1)"; //table data
            } else {

                $w = "umid in (" . $subordinate_users . ")"; //$w=>subordinate users  
                $where = "um.umid in (" . $subordinate_users . ") and (um.umIsSalesRep=1 or um.umIsManager=1)"; //table data
            }

            // $w = "umid in (" . $subordinate_users . ")"; //$w=>subordinate users  
            // $where="um.umid in (".$subordinate_users.") and (um.umIsSalesRep=1 or um.umIsManager=1)";   
        }

        $Mwhere = $w . " and umIsManager=1"; //for Manager
        $manager = $this->messagemodel->simple_get('usermaster', array('umid as id', 'umUserName as name'), $Mwhere);
        //print_r($Mwhere);
        //print_r($where);
        //  die();
        $data['manager'] = generate_options($manager);
        $data['table_data'] = $this->messagemodel->get_users($where);
        $this->load->view('messages/list_users', $data);
    }

    public function save_message() {
        $user_data = $this->session->userdata('userdata');
        $message['send_by'] = $user_data['umId'];
        $message['message_head'] = $_POST['message_head'];
        $message['message_content'] = $_POST['message_content'];
        $message['send_time'] = date('Y-m-d H:m:s');
        $message['status'] = "message_send";
        $result = $this->messagemodel->insert('messages', $message);

        $user_ids = explode(',', $_POST['user_id']);

        foreach ($user_ids as $key => $value) {
            $message_details[$key]['user_id'] = $value;
            $message_details[$key]['message_id'] = $result;
        }
        if ($this->messagemodel->insert_batch('message_details', $message_details)) {
            // echo $this->db->last_query();
            $result = $this->send_mail($_POST['user_id'], $message);
        }
        // echo $this->db->last_query();
    }

    public function send_mail($user_ids, $message) {
        $user_data = $this->session->userdata('userdata');
        //print_r($user_data);die();
        $where = "umid in (" . $user_ids . ")";
        $result = $this->messagemodel->simple_get('usermaster', array('umUserName', 'umEmail'), $where);
        //echo $this->db->last_query();
        $this->load->library('email');

        foreach ($result as $k => $value) {
            $user_name = $value['umUserName'];
            $user_email = $value['umEmail'];
            // print_r($value);
            //$this->email->from('srutheesh0@gmail.com', 'srutheesh m');
            //$this->email->to('srutheesh0@gmail.com');
            //print_r($user_email);die();
            if (isset($user_email) && $user_email != '') {

                $this->email->from($user_data['umEmail']);
                $this->email->to($user_email);

                $this->email->subject($message['message_head']);
                $this->email->message($message['message_content']);
                $this->email->send();
                //echo $this->email->print_debugger();
            } else {
                $data['message'] = "$user_name's mail id not available";
                echo '<script>alert('.$data['message'].');</script>';
                //$this->list_user();
            }
        }
    }

}
