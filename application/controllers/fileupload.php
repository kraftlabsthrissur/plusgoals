<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Mar-2015
 */

/**
 * @property call_model $call_model Description 
 * 
 */
class Fileupload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('file_model');
    }

     function do_upload(){
        $path = $this->get_path();
        $config['upload_path'] = $path;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload("file")) {
            $data= array('error' => $this->upload->display_errors());        
            $data['status'] = "failure";
        }
        else {
            $upload_data = $this->upload->data();

            $data['file_name'] = $upload_data['orig_name'];
            $data['file_extension'] = $upload_data['file_ext'];
            $data['file_size'] = $upload_data['file_size'];
            $data['file_type'] = $upload_data['file_type'];
            $data['file_path'] = $config['upload_path'];
            $data['upload_time'] = date('Y-m-d H:i:s');
            $data['id'] = $this->file_model->insert_new($data);
            $data['status'] = "success";
        }
    
        echo json_encode($data); 
    }

    private function get_path()
    {
        $path = './uploads/'.date('Y').'/'.date('m').'/'.date('d');
        if (!file_exists($path) ){
            mkdir($path, 0777, true);
        }

        return $path;
    }
    public function add() {
        $edit_mode = FALSE;
        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data = $this->save();
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->load->view('crm/form_call', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('crm/form_call', $data);
        }
    }

    public function edit($id) {
        $edit_mode = TRUE;
        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data = $this->save();
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->load->view('crm/form_call', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $form_data = $this->call_model->simple_get('calls', array('*'), array('call_id' => $id));
            $data['form_data'] = $form_data[0];
            $this->load->view('crm/form_call', $data);
        }
    }

    public function list_view() {
        $data = array();
      //  $data['table_data'] = $this->call_model->get_calls(array('t.is_active' => 1));
        $this->load->view('crm/list_call', $data);
    }

    public function delete() {
        $form_data['is_active'] = 0;
        $result = $this->call_model->edit('calls', $form_data, array('call_id' => $id));
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = 'Deleted successfully';
            $data['hash'] = 'call/list_view';
        } else {
            $data['status'] = 'failure';
            $data['form_data'] = $form_data;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function is_valid_form($mode) {
        if (!$mode) { // edit
            $this->form_validation->set_rules('action_name', 'Action Name', 'required|max_length[100]|exist_among[actions.action_name.action_id.' . $form_data['action_id'] . ']');
        } else {
            $this->form_validation->set_rules('action_name', 'Action Name', 'required|max_length[100]|exists[actions.action_name]');
        }
        $this->form_validation->set_rules('method_name', 'Method Name', 'required|max_length[100]');
        $this->form_validation->set_rules('file_name', 'File Name', 'required|max_length[100]');
        $this->form_validation->set_rules('class_name', 'Class Name', 'required|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');

        return $this->form_validation->run();
    }

    private function save() {
        $edit_mode = FALSE;
        $form_data = $this->input->post();

        if (isset($form_data['call_id']) && $form_data['call_id'] !== '') { // edit
            $edit_mode = TRUE;
        }
        if (!$this->is_valid_form($edit_mode)) {
            $data['edit_mode'] = $edit_mode;
            $data['error'] = $this->form_validation->error_array();
            $data['form_data'] = $form_data;
            $data['status'] = 'failure';
        } else {
            if ($edit_mode) {
                $id = $form_data['call_id'];
                unset($form_data['call_id']);
                $result = $this->call_model->edit('calls', $form_data, array('call_id' => $id));
            } else {
                $form_data['is_active'] = 1;
                $result = $this->call_model->insert('calls', $form_data);
            }
            if ($result) {
                $data['status'] = 'success';
                $data['message'] = 'Saved successfully';
                $data['hash'] = 'crm/list_call';
            } else {
                $data['status'] = 'failure';
                $data['edit_mode'] = $edit_mode;
                $data['error'] = array('form_error' => 'Data not Saved');
                $data['form_data'] = $form_data;
            }
        }

        return $data;
    }

}
