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
class TaskReport extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('routemodel');
        $this->load->model('list_model');
        $this->load->model('privilegemodel');
        $this->load->model('expensemodel');
        $this->load->model('expensereportmodel');
        $this->load->model('taskreportmodel');
    }

    public function task_report_form() {
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
        $this->load->view('reports/task_report_form', $data);
    }
    public function task_report_table() {
        $form_data = $this->input->post();
        //print_r($form_data);die();
        $condition = "ut.assigned_user_id = '" . $form_data['user_id'] . "' and ut.assigned_date between '" . $form_data['from_date'] . "' and '" . $form_data['to_date'] . "'";
        $result = $this->taskreportmodel->get_tasks($condition);
        $data['table_data'] = $result;
        $data['form_data'] = $form_data;
        $this->load->view('reports/task_report_table', $data);
    }
    public function generate_task_report() {
        $form_data = $this->input->post();
       
        $condition = "ut.assigned_user_id = '" . $form_data['user_id'] . "' and ut.assigned_date between '" . $form_data['from_date'] . "' and '" . $form_data['to_date'] . "'";
        $result = $this->taskreportmodel->get_tasks($condition);
       
        $data['form_heading'] = 'Task Report';
        $data['report_heading1'] = 'ASHTAVAIDYAN THAIKKATTU MOOSS';
        $data['company_name'] = 'VAIDYARATNAM OUSHADHASALA PVT. LTD.';
        $data['company_address'] = 'OLLUR.THAIKKATTUSSERY P. O., THRISSUR. KER.ALA - 680 306';
        $data['order_name'] = 'FSO MONTHLY TOUR PROGRAMME';
        $data['result'] = $result;
        
      
        $this->load->library('pdf');
        //$this->load->view('reports/taskpdf', $data);

        $this->pdf->load_view('reports/taskpdf', $data);
        $this->pdf->render();
        $this->pdf->stream("taskpdf.pdf");
    }

}
