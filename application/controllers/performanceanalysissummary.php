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
class PerformanceAnalysisSummary extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('task_model');
        $this->load->model('privilegemodel');
        $this->load->model('performance_summarymodel');
        $this->load->model('taskreportmodel');
    }

    public function performance_summary_report() {
         $form_data = $this->input->post();
         //print_r($form_data);

         //$form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d');
         //$form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d');
         $form_data['user_id'] = isset($form_data['user_id']) ? $form_data['user_id'] : "";
        // print_r($form_data);
         // }
         $user_data = $this->session->userdata('userdata');
         $search = '';
        // $search = 't.is_active = 0 OR t.is_active = 1';
        if ($user_data['umIsHOUser'] <= 1) { 
            $data['subordinate_users'] = $this->privilegemodel->get_subordinateusers($user_data['umId']);
            // print_r($data['subordinate_users']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                 $subordinate_users = $user_data['umId'];
            } else {
                 $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            if($form_data['user_id'] == ""){
                 // $search .= "u.umId in (" . $subordinate_users . ") AND ";
                $search .=" (ua.umId in ( $subordinate_users ) ) ";
               
            }
        }
 
        if($form_data['user_id'] !=""){
             $search .= " ut.assigned_user_id = '" . $form_data['user_id'] . "' ";
           //  $search .= " DATE_FORMAT(tc.date,'%Y-%m-%d') BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
        }
        // $search .= " DATE_FORMAT(tc.date,'%Y-%m-%d') BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
 
        $result = $this->performance_summarymodel->get_tasks_list($search);
        $data['table_data'] = $result;
        // print_r($data['table_data']);
        if($user_data['umUserName'] !="admin")
        {
             $users_array = $this->users_for_filter();
        }else{
             $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
        }
       // $data['from_date'] = $form_data['from_date'];
       // $data['to_date'] = $form_data['to_date'];
        $data['users'] = generate_options($users_array, 0, 0,$form_data['user_id'] );
        // print_r($data);
        $this->load->view('performanceanalysis/performance_analysis_summary', $data);
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

    public function generate_pdf_report() {
        $form_data = $this->input->post();
      // print_r($form_data);
       $form_data['user_id'] = isset($form_data['user_id']) ? $form_data['user_id'] : "";

        $user_data = $this->session->userdata('userdata');
        $search = '';
       if ($user_data['umIsHOUser'] <= 1) { 
           $data['subordinate_users'] = $this->privilegemodel->get_subordinateusers($user_data['umId']);
           $subordinate_users = $data['subordinate_users']['user_id'];
           if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
           } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
           }
           if($form_data['user_id'] == ""){
                // $search .= "u.umId in (" . $subordinate_users . ") AND ";
               $search .=" (ua.umId in ( $subordinate_users ) ) ";
              
           }
       }

       if($form_data['user_id'] !=""){
            $search .= " ut.assigned_user_id = '" . $form_data['user_id'] . "' ";
          //  $search .= " DATE_FORMAT(tc.date,'%Y-%m-%d') BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
       }

       $result = $this->performance_summarymodel->get_tasks_list($search);
       $data['table_data'] = $result;
       
       $data['form_heading'] = 'Task Report';

        
     // print_r($data);
        $this->load->library('pdf');
        //$this->load->view('reports/taskpdf', $data);

        $this->pdf->load_view('performanceanalysis/performance_analysis_summary', $data);
        $this->pdf->render();
        $this->pdf->stream("uploads/taskreportpdf.pdf");
    }
}