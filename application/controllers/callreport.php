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
class CallReport extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('routemodel');
        $this->load->model('list_model');
        $this->load->model('privilegemodel');
        $this->load->model('expensemodel');
        $this->load->model('expensereportmodel');
        $this->load->model('callreportmodel');
    }
    public function call_report_form() {
        $user_data = $this->session->userdata('userdata');
        $data['user_data'] = $user_data;
        if ($user_data['umId'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            // print_r($subordinate_users);
            $userWhere = " umId in (" . $subordinate_users . ") and umStoreId is null";
            $routeWhere = "created_by in (" . $subordinate_users . ") and is_active=1";
        } else {
            $userWhere = "umStoreId is null";
            $routeWhere = "is_active=1";
        }
        $users = $this->routemodel->simple_get('usermaster', array('umId as id ,umUserName as name'), $userWhere);
        $data['users'] = generate_options($users);
        $routes = $this->routemodel->simple_get('routes', array('route_id as id ,route_name as name'), $routeWhere);
        $data['routes'] = generate_options($routes);
        $this->load->view('reports/call_report_form', $data);
    }
    public function call_report_table() {
        $form_data = $this->input->post();
        //print_r($form_data);die();
        $condition = "c.user_id = '" . $form_data['user_id'] . "' and c.date between '" . $form_data['from_date'] . "' and '" . $form_data['to_date'] . "' and c.status like '" . $form_data['status'] . "'";
        $result = $this->callreportmodel->get_call($condition);
        $data['table_data'] = $result;
        $data['form_data'] = $form_data;
        $this->load->view('reports/call_report_table', $data);
    }
     public function generate_call_report() {
        $form_data = $this->input->post();
        $condition = "c.user_id = '" . $form_data['user_id'] . "' and c.date between '" . $form_data['from_date'] . "' and '" . $form_data['to_date'] . "' and c.status like '" . $form_data['status'] . "'";
        $result = $this->callreportmodel->get_call($condition);
       
       
//        foreach ($result as $key => $value) {
//            $result[$key]['prescribing'] = $this->callreportmodel->get_prescribing_product($value['id']);
//            $result[$key]['sample'] = $this->callreportmodel->get_sample($value['id']);
//      
//        }
      
        $data['form_heading'] = 'ExpenseStatment';
        $data['report_head1']='Ashtavadyan Thaikkattu mooss';
        $data['company_name'] = 'VAIDYARATNAM OUSHADHASALA PVT. LTD.';
       
        $data['order_name'] = 'FSO Daily Report';
        $data['result'] = $result;
    
        $this->load->library('pdf');
       // $this->load->view('reports/callpdf', $data);
        $this->pdf->load_view('reports/callpdf', $data);
        $this->pdf->render();
        $this->pdf->stream("callpdf.pdf");
    }
}