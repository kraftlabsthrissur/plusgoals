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
class TaskDailyReport extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('task_model');
        $this->load->model('list_model');
        $this->load->model('privilegemodel');
        $this->load->model('expensemodel');
        $this->load->model('expensereportmodel');
        $this->load->model('taskreportmodel');
    }

    // public function task_report() {
    //    // $data = $this->session->userdata('TaskDailyReport');
    //     $form_data = $this->input->post();
    //     $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d');
    //     $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d');
    //     $form_data['user_id'] = isset($form_data['user_id']) ? $form_data['user_id'] : "";
    //     //print_r($form_data);die();
    //     // }
    //     $user_data = $this->session->userdata('userdata');
    //     $search = '';
    //    // $search = 't.is_active = 0 OR t.is_active = 1';
    //     if ($user_data['umIsHOUser'] <= 1) { 
    //         $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
    //         $subordinate_users = $data['subordinate_users']['user_id'];
    //         if ($subordinate_users == null) {
    //             $subordinate_users = $user_data['umId'];
    //         } else {
    //             $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
    //         }
    //         if($form_data['user_id'] == ""){
    //             // $search .= "u.umId in (" . $subordinate_users . ") AND ";
    //            $search .=" (u.umId in ( $subordinate_users ) OR  ua.umId in ( $subordinate_users ) )AND ";
    //         }
    //      }

    //     if($form_data['user_id'] !=""){
    //         $search .= " ut.assigned_user_id = '" . $form_data['user_id'] . "' AND ";
    //     }

    //     $search .= "DATE_FORMAT(tc.date,'%Y-%m-%d') BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
        
    //    // $data = $this->privilegemodel->get_users_for_filter($search);

    //     $result = $this->taskreportmodel->get_tasks_list($search);
    //     $data['table_data'] = $result;
    //    // print_r($data['table_data']);
    //    if($user_data['umUserName'] !="admin")
    //     {
    //         $users_array = $this->users_for_filter();
    //     }else{
    //         $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
    //     }
    //     $data['from_date'] = $form_data['from_date'];
    //     $data['to_date'] = $form_data['to_date'];
    //     $data['users'] = generate_options($users_array, 0, 0,$form_data['user_id'] );
    //    // print_r($data);
    //     $this->load->view('reports/task_daily_report', $data);
    // }

    public function json_taskreport()
    {
        $user_data = $this->session->userdata('userdata');
        $params = $_REQUEST;
        $search_columns = array(
            'task_name',
            //'task_desc',
            'priority',
            'status',
            'ua.umUserName',
            'u.umUserName'
        );
        $sort_columns = array(
             'task_name',
            'due_date',
            'date',
            'assigned_by',
            'assigned_to',
            'comment',
            'perc_of_completion',
            'status',
            'approved_status',
            'approved_by',
            'rejected_by',
        );

        $type = isset($params['type']) ? $params['type'] : "";
        $today = date('Y-m-d');
        
        $search = '';
        // if ($params['search']['value'] != '') {
        //     $search .= ' AND (';
        //     foreach ($search_columns as $key => $value) {
        //         $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
        //     }
        //     $search = substr($search, 0, -3);
        //     $search .= ')';
        // }
        $form_data = $this->input->post();
        //$search = '  tc.is_active = 1 ';
        $search = '  ut.active_comment = 1 ';
            // $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d');
            // $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d');
            // $form_data['user_id'] = isset($form_data['user_id']) ? $form_data['user_id'] : "";
           if ($user_data['umIsHOUser'] != 1) { 
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            if($form_data['user_id'] == ""){
                // $search .= "u.umId in (" . $subordinate_users . ") AND ";
               $search .="AND  (ut.user_id in ( $subordinate_users ) OR  ut.assigned_user_id in ( $subordinate_users ) ) ";
            }
         }
        $form_data = $this->session->userdata('task');
      // print_r($form_data);
        // if($form_data['user_id'] == ""){
        //     $search .=" (u.umId in ( $subordinate_users ) OR  ua.umId in ( $subordinate_users ) ) AND ";
        // }

        if($form_data['user_id'] !=""){
            $search .= " AND ut.assigned_user_id = '" . $form_data['user_id'] . "'";
        }

        // $search .= " AND DATE_FORMAT(tc.date,'%Y-%m-%d') >= '" . $form_data['from_date'] . "' AND DATE_FORMAT(tc.date,'%Y-%m-%d') <='" . $form_data['to_date'] . "'";
        $search .= " AND DATE_FORMAT(ut.task_comment_date,'%Y-%m-%d') >= '" . $form_data['from_date'] . "' AND DATE_FORMAT(ut.task_comment_date,'%Y-%m-%d') <='" . $form_data['to_date'] . "'";

    //     if ($form_data['project'] != '') {
    //         $search .= " AND t.project_id = '" . $form_data['project'] . "' ";
    //    }
        $data = $this->taskreportmodel->get_tasks_list($params['start'], $params['length'], $sort_columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
       // $data['table_data'] = $result;
      // print_r($result);
       // print_r($data['table_data']);
       if($user_data['umUserName'] !="admin")
        {
            $users_array = $this->users_for_filter();
        }else{
            $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
        }
        $data['from_date'] = $form_data['from_date'];
        $data['to_date'] = $form_data['to_date'];
        $data['users'] = generate_options($users_array, 0, 0,$form_data['user_id'] );
       // print_r($data);
        // $this->load->view('reports/task_daily_report', $data);
        if ($data['result']) {
            $action_tag = '<a class="assign-users">Assign</a> &nbsp;&nbsp;&nbsp; '
            . '<a href="#task/edit/%s">Edit</a> &nbsp;&nbsp;&nbsp; '
            . '<a onClick="return confirm(\'All the reccurring task will be removed. Are you want to delete this task?\');" href="#task/delete/%s">Delete</a>'
            . '<input type="hidden" class="task_id" value="%s">'
            . '<input type="hidden" class="group_ref" value="%s">';
        foreach ($data['result'] as $key => $row) {
            $data['result'][$key]['action'] = sprintf($action_tag, $row['task_id'], $row['task_id'], $row['task_id'], $row['group_ref']);
            // $data['result'][$key]['assigned_to'] = $row['c'] > 3 ? $row['c'] . ' Persons' : $row['assigned_to'];
        }
        }
        $results = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => $data['num_rows'],
            "recordsFiltered" => $data['num_rows'],
            "data" => $data['result'],
            "q" => $data['q']
        );
        echo json_encode($results);
    }
    public function task_report(){
        $form_data = $this->input->post();
        $user_data = $this->session->userdata('userdata');
        $data = $this->session->userdata('task');
        //print_r($form_data);
       // print_r($data);
       if($user_data['umUserName'] !="admin")
        {
            $users_array = $this->users_for_filter();
        }else{
            $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
        }
        $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d');
        $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d');
        $form_data['user_id'] = isset($form_data['user_id']) ? $form_data['user_id'] : "";
        $data['users'] = generate_options($users_array, 0, 0,$form_data['user_id'] );
        $this->session->set_userdata('task', $form_data);

        $data['from_date'] = $form_data['from_date'];
        $data['to_date'] = $form_data['to_date'];
        $data['user_id'] = $form_data['user_id'];

        $this->load->view('reports/task_daily_report', $data);
    }
    
    public function users_for_filter() 
    {
        $user_data = $this->session->userdata('userdata');
        $search = '';
        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $search = " umId in (" . $subordinate_users . ") ";
        }
        $data = $this->privilegemodel->get_users_for_filter($search);
        return $data;
    }
}