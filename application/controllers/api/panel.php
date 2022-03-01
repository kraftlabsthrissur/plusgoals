<?php
defined('BASEPATH') or exit("No direct script access allowed");

class panel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $headers = $this->input->request_headers();

        $access_token = ($headers['Access-Token'] != "") ? $headers['Access-Token'] : "NA";

        $this->users = $this->db->get_where('usermaster', array('access_token' => $access_token));

        if ($this->users->num_rows() == 0) {
            $response['status'] = "error";
            $response['message'] = "Authenticaton not found";
            $response['http_code'] = 401;

            echo json_encode($response);

            die();
        } else {

            $this->user = $this->users->row();
        }
    }

    public function signout()
    {
        $data = array('access_token' => NULL);

        $this->db->set($data);
        $this->db->where('umId', $this->user->umId);
        $this->db->update('usermaster', $data);

	$this->db->where('user_id',$this->user->umId);
        $this->db->delete('firebase_tokens');

        $response['status'] = "success";
        $response['message'] = "Signout successful";
        $response['data'] = NULL;
        $response['http_code'] = 200;

        echo json_encode($response);
    }

    public function sendPushnotification($body, $title, $users, $data)
    {
        include_once APPPATH . 'classes/FCM.php';

        $device_tokens = array();
    
        foreach ($users as $user) {

            $tokens = $this->db->get_where('firebase_tokens', array('user_id' => $user->assigned_user_id));
            

            if ($tokens->num_rows() > 0) {
                array_push($device_tokens, $tokens->row()->token);
            }
        }

        

        foreach ($device_tokens as $token) {

            $assigned_user_id=$this->db->get_where('firebase_tokens',array('token'=>$token))->row()->user_id;
            $group_ref=$this->db->get_where('user_tasks',array('assigned_user_id'=>$assigned_user_id,'task_id'=>$data['task_id']))->row()->group_ref;
            $notification = array();
            $arrNotification = array();
            $arrData = array();
            $arrNotification["body"] = $body;
            $arrNotification["title"] = $title;
            $arrNotification["sound"] = "default";
            $arrNotification["type"] = 1;
            $arrNotification["task_id"] = $data['task_id'];
            $arrNotification["task_name"] = $data['task_name'];
            $arrNotification["group_ref"] = $group_ref;
            $arrNotification["perc_of_completion"] = $data['perc_of_completion'];


            $fcm = new FCM();
            $result = $fcm->send_notification($token, $arrNotification, "Android");
        }
    }

    public function save_firebase_token()
    {
        $this->form_validation->set_rules('token', 'Firebase Token', 'required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() === FALSE) {
            $response['status'] = "error";
            $response['message'] = validation_errors();

            echo json_encode($response);
        } else {

            try {

                $tokens = $this->db->get_where('firebase_tokens', array('user_id' => $this->user->umId));

                if ($tokens->num_rows() > 0) {
                    $token = $tokens->row();

                    $data = array('token' => $this->input->post('token'), 'updated_at' => date('Y-m-d H:i:s'));
                    $token_id = $token->id;
                    $this->db->set($data);
                    $this->db->where('id', $token_id);
                    $this->db->update('firebase_tokens', $data);
                } else {

                    $data = array(
                        'user_id' => $this->user->umId,
                        'token' => $this->input->post('token'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );

                    $this->db->insert('firebase_tokens', $data);

                    $token_id = $this->db->insert_id();
                }

                if ($token_id > 0) {
                    $response['status'] = "success";
                    $response['message'] = "Firebase token added";

                    echo json_encode($response);
                }
            } catch (\Exception $e) {
                $response['status'] = "error";
                $response['message'] = $e->getMessage();

                echo json_encode($response);
            }
        }
    }
}
