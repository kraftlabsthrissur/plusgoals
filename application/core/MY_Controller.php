<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller Extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

}

/**
 * @property privilegemodel $privilegemodel Description
 * 
 */
class Secure_Controller Extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('privilegemodel');
        $base_url = base_url();
        if(strpos($base_url, "sfm")){
            $this->config->set_item("app_title",  $this->config->item("app2"));
        }
        if (!$this->privilegemodel->is_privileged()) {
            $user = $this->session->userdata('userdata');
            if ($user) {
                $this->redirect('common/dashboard');
            }else {
                $this->redirect('login/index');
            }
        }
    }
    private function redirect($segment, $message = '') {
        if ($this->input->is_ajax_request()) {   // 
            $data['message'] = $message;
            $data['status'] = 'error';
            $data['hash'] = $segment;
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
         }else {
            redirect($segment, 'refresh');
        }
    }

}
