<?php

class Login extends Secure_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $message['status'] = '';
        if ($this->input->post('username') != null && $this->input->post('password') != null) {
            $this->load->model('connection');
            $login = $this->connection->getuser($this->input->post('username'), $this->input->post('password'));
            if ($login !== FALSE) {
                $this->session->set_userdata('userdata', $login);
                $this->session->set_userdata('LoggedIn', true);
                $this->db->query('SELECT GetUserAuthorizedModeItems(' . $login['umId'] . ')');
                 $message['status'] = 'Login Successfully!';
                    redirect('', 'refresh');
            } else {
                $message['status'] = 'Invalid username or password..!';
                $this->load->view('login_view', $message);
            }
        } else {
            $login = array(
                "LoggedIn" => ''
            );
            $data['username'] = 'sample';
            $this->session->sess_destroy();
            $this->load->view('login_view', $data);
        }
    }

    function logout() {
        $data['username'] = 'sample';
        $this->session->sess_destroy();
        $this->load->view('login_view', $data);
    }

}
