<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Mar-2015
 */

/**
 * @property campaign_model $campaign_model Description
 * 
 */
class Campaign extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('campaign_model');
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
                $this->load->view('crm/form_campaign', $data);
            }
        } else {
            $data['form_data'] = $data['error'] = array();
            $data['edit_mode'] = $edit_mode;
            $this->load->view('crm/form_campaign', $data);
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
                $this->load->view('crm/form_campaign', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $form_data = $this->campaign_model->simple_get('campaigns', array('*'), array('campaign_id' => $id));
            $data['form_data'] = $form_data[0];
            $this->load->view('crm/form_campaign', $data);
        }
    }

    public function list_view() {
        $data = array();
        // $data['table_data'] = $this->campaign_model->get_campaigns(array('t.is_active' => 1));
        $this->load->view('crm/list_campaign', $data);
    }

    public function delete() {
        $form_data['is_active'] = 0;
        $result = $this->campaign_model->edit('campaigns', $form_data, array('campaign_id' => $id));
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = 'Deleted successfully';
            $data['hash'] = 'campaign/list_view';
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

        if (isset($form_data['campaign_id']) && $form_data['campaign_id'] !== '') { // edit
            $edit_mode = TRUE;
        }
        if (!$this->is_valid_form($edit_mode)) {
            $data['edit_mode'] = $edit_mode;
            $data['error'] = $this->form_validation->error_array();
            $data['form_data'] = $form_data;
            $data['status'] = 'failure';
        } else {
            if ($edit_mode) {
                $id = $form_data['campaign_id'];
                unset($form_data['campaign_id']);
                $result = $this->campaign_model->edit('campaigns', $form_data, array('campaign_id' => $id));
            } else {
                $form_data['is_active'] = 1;
                $result = $this->campaign_model->insert('campaigns', $form_data);
            }
            if ($result) {
                $data['status'] = 'success';
                $data['message'] = 'Saved successfully';
                $data['hash'] = 'crm/list_campaign';
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
