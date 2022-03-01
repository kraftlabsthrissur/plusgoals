<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Mar-2015
 */

/**
 * @property task_model $task_model Description
 * @property privilegemodel $privilegemodel Description
 * 
 */
class Task extends Secure_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('task_model');
        $this->load->model('submaster_model');
        $this->load->model('privilegemodel');
        $this->load->model('taskattachment_model');
        $this->load->model('tasktemplate_model');
        $this->load->model('file_model');
        $this->load->model('list_model');
    }

    public function add()
    {
        $edit_mode = FALSE;
        $priorities_array = array(
            array("id" => "urgent", "name" => "Urgent"),
            array("id" => "high", "name" => "High"),
            array("id" => "medium", "name" => "Medium"),
            array("id" => "low", "name" => "Low"),
        );
        $tasklevel_array = $this->submaster_model->simple_get('typemaster', array('type_id as id', 'name'), 'type="level"');
        $projects_array = $this->list_model->simple_get('projectmaster', array('project_id as id', 'project_name as name'));
        $weeks_array = array(
            array("id" => "monday", "name" => "Monday"),
            array("id" => "tuesday", "name" => "Tuesday"),
            array("id" => "wednesday", "name" => "Wednesday"),
            array("id" => "thursday", "name" => "Thursday"),
            array("id" => "friday", "name" => "Friday"),
            array("id" => "saturday", "name" => "Saturday"),
            array("id" => "sunday", "name" => "Sunday"),
        );
        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data = $this->save();
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data['priority']);
                $data['levels'] = generate_options($tasklevel_array, 0, 0, $form_data['task_level']);
                $data['projects'] = generate_options($projects_array, 0, 0, $form_data['project']);
                $data['difficulty_levels'] = generate_options(array(), 1, 10, $form_data['difficulty_level']);
                $data['weeks'] = generate_options($weeks_array, 0, 0, $form_data['week_day']);
                $data['days'] = generate_options(array(), 1, 31, $form_data['day']);

                $data['form_data'] = $form_data;
                $this->load->view('tasks/form_task', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $data['priorities'] = generate_options($priorities_array, 0, 0, "");
            $data['levels'] = generate_options($tasklevel_array, 0, 0, "");
            $data['projects'] = generate_options($projects_array, 0, 0, "");
            $data['difficulty_levels'] = generate_options(array(), 1, 10, "");
            $data['weeks'] = generate_options($weeks_array, 0, 0, "");
            $data['days'] = generate_options(array(), 1, 31, "");
            $this->load->view('tasks/form_task', $data);
        }
    }

    public function edit($id)
    {
        $edit_mode = TRUE;
        $priorities_array = array(
            array("id" => "urgent", "name" => "Urgent"),
            array("id" => "high", "name" => "High"),
            array("id" => "medium", "name" => "Medium"),
            array("id" => "low", "name" => "Low"),
        );
        $tasklevel_array = $this->submaster_model->simple_get('typemaster', array('type_id as id', 'name'), 'type="level"');
        $projects_array = $this->list_model->simple_get('projectmaster', array('project_id as id', 'project_name as name'));
        $weeks_array = array(
            array("id" => "monday", "name" => "Monday"),
            array("id" => "tuesday", "name" => "Tuesday"),
            array("id" => "wednesday", "name" => "Wednesday"),
            array("id" => "thursday", "name" => "Thursday"),
            array("id" => "friday", "name" => "Friday"),
            array("id" => "saturday", "name" => "Saturday"),
            array("id" => "sunday", "name" => "Sunday"),
        );
        $form_data = $this->input->post();
       // print_r($form_data);
        if ($form_data !== FALSE) {
            $data = $this->save();
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data['priority']);
                $data['levels'] = generate_options($tasklevel_array, 0, 0, $form_data['task_level']);
                $data['projects'] = generate_options($projects_array, 0, 0, $form_data['project']);
                $data['difficulty_levels'] = generate_options(array(), 1, 10, $form_data['difficulty_level']);
                $data['weeks'] = generate_options($weeks_array, 0, 0, $form_data['week_day']);
                $data['days'] = generate_options(array(), 1, 31, $form_data['day']);
                $this->load->view('tasks/form_task', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            //  $group_ref = $this->input->post('group_ref');
            $form_data = $this->task_model->simple_get('tasks', array('*'), array('task_id' => $id));
            $template_name = $this->tasktemplate_model->simple_get('task_templates', 'template_name', array('task_id' => $id));
            //$project_name = $this->list_model->simple_get('projectmaster', 'project_name', array('project_id' =>$project_id));
            $data['form_data'] = $form_data[0];
            $data['project_id'] = $data['form_data']['project_id'];
            $project_name = $this->list_model->simple_get('projectmaster', 'project_name', array('project_id' => $data['project_id']));
           // print_r($data['projects']);
            foreach ($form_data  as $rows) {
               $project_details = $data['form_data']['project_id'];
            }
            $project_details = array(
                'project_id' => $project_details
            );
            $data['template_names'] = $template_name[0];
            $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data[0]['priority']);
            $data['levels'] = generate_options($tasklevel_array, 0, 0, "");
            //$data['projects'] = generate_options($projects_array, 0, 0,"");
            $data['projects'] = generate_options($projects_array, 0, 0, $project_details);
           // print_r($data['projects']);
            $data['difficulty_levels'] = generate_options(array(), 1, 10, "");
            $data['weeks'] = generate_options($weeks_array, 0, 0, $form_data[0]['week_day']);
            $data['days'] = generate_options(array(), 1, 31, $form_data[0]['day']);
            $data['files'] = $this->taskattachment_model->get_attached_files(array('task_id' => $id));
            $data['assigned_persons'] = $this->task_model->get_assign_users_list(array('task_id' => $id));
            $this->load->view('tasks/form_task', $data);
        }
    }

    public function set_filter()
    {
        $form_data = $this->input->post();
      //  print_r($form_data);
        // print_r($form_data);
        $this->session->set_userdata('task', $form_data);
      //  $data = $this->session->userdata('task', $form_data);
        $data['status'] = 'success';
        $data['message'] = 'filter set successfully';
       // print_r($data);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function list_view()
    {
        $user_data = $this->session->userdata('userdata');
        $data = $this->session->userdata('task');
        $form_data = $this->input->post();
        $priorities_array = array(
            array("id" => "%%", "name" => "All"),
            array("id" => "urgent", "name" => "Urgent"),
            array("id" => "high", "name" => "High"),
            array("id" => "medium", "name" => "Medium"),
            array("id" => "low", "name" => "Low"),
        );
        $projects_array = $this->task_model->simple_get('projectmaster', array('project_id as id', 'project_name as name'));
        if($user_data['umUserName'] !="admin")
        {
        $users_array = $this->users_for_filter();
        }else{
        $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
        }
        $status_array = array(
            array("id" => "all", "name" => "All"),
            array("id" => "completed", "name" => "Completed"),
            array("id" => "partial", "name" => "Partial"),
            array("id" => "not done", "name" => "Not Done"),
            array("id" => "over due", "name" => "Over Due"),
        );
       // print_r($data);
        // if($data['from_date'] == ""){
            $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d', strtotime('-30 days'));
            $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d', strtotime('last day of this month')); 
            $form_data['priority'] = isset($form_data['priority']) ? $form_data['priority'] : "%%";
            $form_data['project'] = isset($form_data['project']) ? $form_data['project'] : "";
            $form_data['status'] = isset($form_data['status']) ? $form_data['status'] : "all";
            $form_data['user'] = isset($form_data['user']) ? $form_data['user'] : "";
    //        }else{
    //        $form_data['from_date'] = $data['from_date'];
    //        $form_data['to_date'] = $data['to_date'];
    //        $form_data['priority'] = $data['priority'];
    //        $form_data['project'] = $data['project'];
    //        $form_data['status'] = $data['status'];
    //        $form_data['user'] = $data['user'];
    //    }
      $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d', strtotime('first day of this month'));
       $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d', strtotime('last day of this month'));
       $form_data['priority'] = isset($form_data['priority']) ? $form_data['priority'] : "%%";
       $form_data['project'] = isset($form_data['project']) ? $form_data['project'] : "%%";
       $form_data['status'] = isset($form_data['status']) ? $form_data['status'] : "all";
      // $form_data['user'] = isset($form_data['user']);
       $form_data['user'] = isset($form_data['user']) ? $form_data['user'] : "";

        $this->session->set_userdata('task', $form_data);
        $data['users'] = generate_options($users_array, 0, 0,$form_data['user'] );
       // $data['users'] = generate_options($users_array, 0, 0, "");
        $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data['priority']);
        $data['projects'] = generate_options($projects_array, 0, 0, $form_data['project']);
        $data['statuses'] = generate_options($status_array, 0, 0, $form_data['status']);
        $data['from_date'] = $form_data['from_date'];
        $data['to_date'] = $form_data['to_date'];
        $this->load->view('tasks/list_task', $data);
    }

    public function assigned_by()
    {
        $user_data = $this->session->userdata('userdata');
        $data = $this->session->userdata('task');
        $form_data = $this->input->post();
       // print_r($data);
        $priorities_array = array(
            array("id" => "%%", "name" => "All"),
            array("id" => "urgent", "name" => "Urgent"),
            array("id" => "high", "name" => "High"),
            array("id" => "medium", "name" => "Medium"),
            array("id" => "low", "name" => "Low"),
        );
        $projects_array = $this->task_model->simple_get('projectmaster', array('project_id as id', 'project_name as name'));
        // print_r($projects_array);
       //  $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
      // $users_array = $this->privilegemodel->get_users_for_filter(array('umIsActive' => 1,'parent_user_id' =>$user_data['umId'])); 
      if($user_data['umUserName'] !="admin")
      {
      $users_array = $this->users_for_filter();
      }else{
      $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
      }
      $status_array = array(
            array("id" => "all", "name" => "All"),
            array("id" => "completed", "name" => "Completed"),
            array("id" => "partial", "name" => "Partial"),
            array("id" => "not done", "name" => "Not Done"),
            array("id" => "over due", "name" => "Over Due"),
        );
       // print_r($data);
        // if($data['from_date'] == ""){
             $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d', strtotime('-30 days'));
             $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d', strtotime('last day of this month')); 
             $form_data['priority'] = isset($form_data['priority']) ? $form_data['priority'] : "%%";
             $form_data['project'] = isset($form_data['project']) ? $form_data['project'] : "";
             $form_data['status'] = isset($form_data['status']) ? $form_data['status'] : "all";
             $form_data['user'] = isset($form_data['user']) ? $form_data['user'] : "";
        //     }else{
        //     $form_data['from_date'] = $data['from_date'];
        //     $form_data['to_date'] = $data['to_date'];
        //     $form_data['priority'] = $data['priority'];
        //     $form_data['project'] = $data['project'];
        //     $form_data['status'] = $data['status'];
        //     $form_data['user'] = $data['user'];
        // }
        $form_data['priority'] = isset($form_data['priority']) ? $form_data['priority'] : "%%";
        $form_data['project'] = isset($form_data['project']) ? $form_data['project'] : "%%";
        $form_data['status'] = isset($form_data['status']) ? $form_data['status'] : "all";
        $form_data['user'] = isset($form_data['user']) ? $form_data['user'] : "";

        $this->session->set_userdata('task', $form_data);
        $data['users'] = generate_options($users_array, 0, 0, "");
        $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data['priority']);
        $data['projects'] = generate_options($projects_array, 0, 0, $form_data['project']);
        $data['statuses'] = generate_options($status_array, 0, 0, $form_data['status']);
        $data['from_date'] = $form_data['from_date'];
        $data['to_date'] = $form_data['to_date'];
        $this->load->view('tasks/assigned_by_list', $data);
    }

    public function assigned_to_you()
    {
        $user_data = $this->session->userdata('userdata');
        $data = $this->session->userdata('task');
        $form_data = $this->input->post();
       // $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
      // $users_array = $this->privilegemodel->get_users_for_filter(array('umIsActive' => 1,'parent_user_id' =>$user_data['umId']));
        $priorities_array = array(
            array("id" => "%%", "name" => "All"),
            array("id" => "urgent", "name" => "Urgent"),
            array("id" => "high", "name" => "High"),
            array("id" => "medium", "name" => "Medium"),
            array("id" => "low", "name" => "Low"),
        );
        $projects_array = $this->task_model->simple_get('projectmaster', array('project_id as id', 'project_name as name'));
        // print_r($projects_array);
       //  $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
      // $users_array = $this->privilegemodel->get_users_for_filter(array('umIsActive' => 1,'parent_user_id' =>$user_data['umId'])); 
        if($user_data['umUserName'] !="admin")
         {
        $users_array = $this->users_for_filter();
        }else{
        $users_array = $this->task_model->simple_get('usermaster', array('umId as id', 'umUserName as name'));
        }
        $status_array = array(
            array("id" => "all", "name" => "All"),
            array("id" => "completed", "name" => "Completed"),
            array("id" => "partial", "name" => "Partial"),
            array("id" => "not done", "name" => "Not Done"),
            array("id" => "over due", "name" => "Over Due"),
        );
       // if($data['from_date'] == ""){
            $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d', strtotime('-30 days'));
            $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d', strtotime('last day of this month')); 
            $form_data['priority'] = isset($form_data['priority']) ? $form_data['priority'] : "%%";
            $form_data['project'] = isset($form_data['project']) ? $form_data['project'] : "";
            $form_data['status'] = isset($form_data['status']) ? $form_data['status'] : "all";
            $form_data['user'] = isset($form_data['user']) ? $form_data['user'] : "";
         //  }else{
        //    $form_data['from_date'] = $data['from_date'];
        //    $form_data['to_date'] = $data['to_date'];
        //    $form_data['priority'] = $data['priority'];
        //    $form_data['project'] = $data['project'];
        //    $form_data['status'] = $data['status'];
        //    $form_data['user'] = $data['user'];
     //  }
       $form_data['from_date'] = isset($form_data['from_date']) ? $form_data['from_date'] : date('Y-m-d', strtotime('-30 days'));
       $form_data['to_date'] = isset($form_data['to_date']) ? $form_data['to_date'] : date('Y-m-d', strtotime(date('Y-m-d')));
       $form_data['priority'] = isset($form_data['priority']) ? $form_data['priority'] : "%%";
       $form_data['status'] = isset($form_data['status']) ? $form_data['status'] : "all";
       $form_data['user'] = isset($form_data['user']) ? $form_data['user'] : "";

        $this->session->set_userdata('task', $form_data);
        $data['users'] = generate_options($users_array, 0, 0, "");
        $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data['priority']);
        $data['projects'] = generate_options($projects_array, 0, 0, $form_data['project']);
        $data['statuses'] = generate_options($status_array, 0, 0, $form_data['status']);
        $data['from_date'] = $form_data['from_date'];
        $data['to_date'] = $form_data['to_date'];
        $this->load->view('tasks/assigned_to_list', $data);
    }

    public function template_list()
    {
        $user_data = $this->session->userdata('userdata');
        $form_data = $this->input->post();
        $data['difficulty_levels'] = generate_options(array(), 1, 10, $form_data['difficulty_level']);
        $tasklevel_array = $this->submaster_model->simple_get('typemaster', array('type_id as id', 'name'), 'type="level"');
        $data['levels'] = generate_options($tasklevel_array, 0, 0, $form_data['task_level']);

        $this->session->set_userdata('task', $form_data);
        $this->load->view('tasks/template_list', $data);
    }
    public function delete($id)
    {
        $form_data['is_active'] = 0;
        $result = $this->task_model->edit('tasks', $form_data, array('task_id' => $id));
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = 'Deleted successfully';
            $data['hash'] = 'task/list_view';
        } else {
            $data['status'] = 'failure';
            $data['form_data'] = $form_data;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function is_valid_form($mode, $form_data)
    {
        $this->form_validation->set_rules('task_name', 'Task', 'required|max_length[1000]');
        $this->form_validation->set_rules('task_desc', 'Description', 'max_length[10000]');
        $this->form_validation->set_rules('time_limit', 'Time Limit', 'numeric');
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');
        $this->form_validation->set_rules('task_level', 'Task Level', 'required');
        $this->form_validation->set_rules('difficulty_level', 'Difficulty Level', 'required');
        $this->form_validation->set_rules('task_date', 'Task Date', 'required');
        if (!isset($form_data['is_repeating']) || $form_data['is_repeating'] != 1) {
            $this->form_validation->set_rules('due_date', 'Due Date', 'required');
        } else {
            $this->form_validation->set_rules('frequency', 'Frequency', 'required');
            $this->form_validation->set_rules('repeat_upto', 'Repeat UpTo Date', 'required');
        }
        if(sizeof($form_data['users']) < 1){
        $this->form_validation->set_rules('number-of-assigned-persons', 'number-of-assigned-persons', 'numeric|required|greater_than[0]');
        $this->form_validation->set_message('greater_than', 'Please assign atleast one person');
        }
        return $this->form_validation->run();
    }

    private function save()
    {
        $edit_mode = FALSE;
        $form_data = $this->input->post();
        //  print_r($form_data);
        $project_id = isset($form_data['project']) ? $form_data['project'] : FALSE;
        if($form_data['project'] =="select"){
            $form_data['project_id'] = 0;
        }
        else{
            $form_data['project_id'] = $form_data['project'];
        }
        unset($form_data['project']);
        $users = isset($form_data['users']) ? $form_data['users'] : FALSE;
        $user_name = isset($form_data['user_name']) ? $form_data['user_name'] : FALSE;
        // print_r($user_name);
        //$user_names = isset($form_data['user_name']) ? $form_data['user_name'] : FALSE;
        unset($form_data['number-of-assigned-persons']);
        // unset($form_data['users']);
        // unset($form_data['user_name']);
       // $names = implode(",",$user_names);
        //$form_data['assigned_to'] = $names;
        $attachments = isset($form_data['attachment_id']) ? $form_data['attachment_id'] : FALSE;
        unset($form_data['attachment_id']);
        $template_name = isset($form_data['template_name']) ? $form_data['template_name'] : FALSE;
        unset($form_data['template_name']);
        if (isset($form_data['task_id']) && $form_data['task_id'] !== '') { // edit
            if($form_data['clone_task_id'] !==''){
                $edit_mode = FALSE;
                }
                else{
                $edit_mode = TRUE;
                }
        }
        if (!$this->is_valid_form($edit_mode, $form_data)) {
            $data['edit_mode'] = $edit_mode;
            $data['error'] = $this->form_validation->error_array();
            $data['form_data'] = $form_data;
            $data['status'] = 'failure';
        } else {
            if ($edit_mode) {
                $id = $form_data['task_id'];
                unset($form_data['task_id']);

                // $assigned_id=array();
                // $assigned_id=$form_data['users'];
                // $assigned_name=array();
                // $assigned_name=$form_data['user_name'];
                // // print_r($assigned_name);
                // $form_data['assigned_user_id'] = implode(',',$assigned_id);
                // $form_data['assigned_user_name'] = implode(',',$assigned_name);
                unset($form_data['clone_task_id']);
                unset($form_data['user_name']);
                unset($form_data['users']);
                $this->task_model->log_activity('tasks', array('task_id' => $id), $form_data);
                $result = $this->task_model->edit('tasks', $form_data, array('task_id' => $id));
                $this->tasktemplate_model->delete('task_templates', array('task_id' => $id));
                $this->taskattachment_model->delete('task_attachments', array('task_id' => $id));
                $this->task_model->delete('user_tasks', array('task_id' => $id));
            } else {
                $id = $form_data['task_id'];
                $userdata = $this->session->userdata('userdata');
                $form_data['created_by'] = $userdata['umId'];
                $form_data['is_active'] = 1;
                $form_data['created_date'] = date('Y-m-d H:m:s');
                // $form_data['created_user'] = $userdata['umFirstName'];
                
                // $assigned_id=array();
                // $assigned_id=$form_data['users'];
                // $assigned_name=array();
                // $assigned_name=$form_data['user_name'];
                // // print_r($assigned_name);
                // $form_data['assigned_user_id'] = implode(',',$assigned_id);
                // $form_data['assigned_user_name'] = implode(',',$assigned_name);
            //    $form_data['assigned_to'] = $names;

                unset($form_data['users']);
                unset($form_data['user_name']);
                if($form_data['clone_task_id'] !==''){
                    unset($form_data['clone_task_id']);
                    $form_data['task_id'] = 0;
                    }
                    unset($form_data['clone_task_id']);
                    $result = $this->task_model->insert('tasks', $form_data);
                    $id = $this->db->insert_id();
            }
            if ($result) {
                $form_data['task_id'] = $id;
                $this->assign_users_to_task($users,$user_name, $form_data);
                // $this->task_attachments($attachments, $id);
                $this->task_templates($template_name, $id);
                if ($attachments > 0) {
                    $this->task_attachments($attachments, $id);
                }
                $data['status'] = 'success';
                $data['message'] = 'Saved successfully';
                $data['hash'] = 'task/assigned_by';
                $data['form_data'] = $form_data;
            } else {
                $data['status'] = 'failure';
                $data['edit_mode'] = $edit_mode;
                $data['error'] = array('form_error' => 'Data not Saved');
                $data['form_data'] = $form_data;
            }
        }
        return $data;
    }

    public function select_user()
    {
        $data['task_id'] = $_POST['id'];
        $userWhere = "1=1"; //and umStoreId is null
        $user_data = $this->session->userdata('userdata');
        if ($user_data['umIsHOUser'] != 1) {

            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $userWhere = "umid in (" . $subordinate_users . ") ";
        }
        $users = $this->task_model->simple_get('usermaster', array('umId as id ,umUserName as name'), $userWhere);
        $data['users'] = generate_options($users);
        $this->load->view('tasks/assign_tasks', $data);
    }

    public function assign_users()
    {
        $task_id = $this->input->post('task_id');
        $group_ref = $this->input->post('group_ref');
        $users = $this->input->post('users');
        if ($users && sizeof($users)) {
            $tasks = $this->task_model->simple_get('tasks', array('*'), array('task_id' => $task_id));
            $task_data = $tasks[0];
            $task_data['is_group_task'] = 1;
            $task_data['is_repeating'] = 0;
            $this->assign_users_to_task($users, $task_data);
            $data['assigned_persons'] = $this->task_model->get_assigned_users($task_id, $group_ref);
            $this->load->view('tasks/assigned_persons', $data);
        }
    }

    private function assign_users_to_task($users,$user_name, $task_data)
    {
        $user_data = $this->session->userdata('userdata');
        if (!$users || !sizeof($users)) {
            return;
        }
        $user_tasks = array();
        $today = date('Y-m-d');
        $j = 0;
        if (isset($task_data['is_repeating']) && $task_data['is_repeating']) {
            if ($task_data['repeat_upto'] == "") {
                $task_data['repeat_upto'] = date('Y-m-d', strtotime('last day of this year'));
            }
            for ($i = 0; $task_data['task_date'] < $task_data['repeat_upto']; $i++) {

                foreach ($users as $key => $value) {
                        $user_tasks = array(); 
                        if (isset($task_data['is_group_task']) && $task_data['is_group_task'] == 1) {
                            $user_tasks['group_ref'] = $i;
                            } else {
                            $user_tasks['group_ref'] = $j;
                        }
                        $user_tasks['task_id'] = $task_data['task_id'];
                        $user_tasks['user_id'] = $user_data['umId'];
                        $user_tasks['created_user_name'] = $user_data['umUserName'];
                      //  $user_tasks['assigned_by'] = $user_data['umFirstName'];
                        $user_tasks['assigned_user_id'] = $value;

                        $qry= $this->task_model->get_username($value);
                        $user_tasks['assigned_user_name'] = $qry[0]['umUserName'];
                      //  $user_tasks['assigned_to'] = $task_data['assigned_to'];
                        $user_tasks['assigned_date'] = $today;
                        $user_tasks['task_date'] = $task_data['task_date'];
                        $user_tasks['due_date'] = date('Y-m-d', strtotime('+' . $task_data['time_limit'] . ' day', strtotime($task_data['task_date'])));
                        $exist_array = array('task_id' => $user_tasks['task_id'], 'assigned_user_id' => $value, 'task_date' => $user_tasks['task_date']);
                        if (!$this->task_model->is_exists('user_tasks', $exist_array)) {
                            // print_r($exist_array);
                            $this->task_model->insert('user_tasks', $user_tasks);
                        }
                        $j++;
                }
                switch ($task_data['frequency']) {
                    case "daily":
                        $task_data['task_date'] = date('Y-m-d', strtotime('+1 day', strtotime($task_data['task_date'])));
                        break;
                    case "weekly":
                        $task_data['task_date'] = date('Y-m-d', strtotime('+1 week ' . $task_data['week_day'], strtotime($task_data['task_date'])));
                        break;
                    case "monthly":
                        $task_data['task_date'] = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($task_data['task_date'])) + 1, $task_data['day'], date('Y', strtotime($task_data['task_date']))));
                        break;
                    default:
                        break;
                }
            }
        } else {
                foreach ($users as $key => $value) {
                    $user_tasks = array();
                        if (isset($task_data['is_group_task']) && $task_data['is_group_task'] == 1) {
                            $user_tasks['group_ref'] = 0;
                        } else {
                             $user_tasks['group_ref'] = $j;
                        }
                        $user_tasks['task_id'] = $task_data['task_id'];
                        $user_tasks['user_id'] = $user_data['umId'];
                        $user_tasks['assigned_user_id'] = $value;
                        //$user_tasks['assigned_by'] = $user_data['umFirstName'];
                        //$user_tasks['assigned_to'] = $task_data['assigned_to'];
                        $qry= $this->task_model->get_username($value);
                        // print_r($qry);
                        
                    //     if($qry[0]['umFirstName'] != ''){
                    //         foreach ($qry as $ky => $res) {
                    //             $user_tasks['assigned_user_name'] = $res;
                    //     }
                    // }
                        $user_tasks['assigned_user_name'] = $qry[0]['umUserName'];
                        $user_tasks['assigned_date'] = $today;
                        $user_tasks['task_date'] = $task_data['task_date'];
                        $user_tasks['due_date'] = $task_data['due_date'];
                        $user_tasks['created_user_name'] = $user_data['umUserName'];
                        $exist_array = array('task_id' => $user_tasks['task_id'], 'assigned_user_id' => $value,'task_date' => $user_tasks['task_date']);
                        if (!$this->task_model->is_exists('user_tasks', $exist_array)) {
                            $this->task_model->insert('user_tasks', $user_tasks);
                        }
                        $j++;       
                }
                // foreach ($users as $ky => $value) {
                    // print_r($value);
        // }
        }
    }

    private function task_attachments($attachments, $task_id)
    {
        foreach ($attachments as $key => $value) {
            $this->db->insert('task_attachments', array('attachment_id' => $value, 'task_id' => $task_id));
        }
    }

    private function task_templates($template_name, $task_id)
    {
        $data['template_name'] = $template_name;
        $data['task_id'] = $task_id;
        $this->db->insert('task_templates', $data);
    }

    public function assign_task()
    {
        $data['task_id'] = $_POST['task_id'];
        $userdata = $this->session->userdata('userdata');
        $_POST['user_id'] = $userdata['umId'];
        $result = $this->task_model->insert('user_tasks', $_POST);
        $this->list_view();
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

    public function json_users()
    {
        $user_data = $this->session->userdata('userdata');
        $params = $_REQUEST;
        // print_r($params);
        $search_columns = array(
            'umUserCode',
            'umFirstName',
            'umLastName',
            'umUserName',
            'umEmail',
            'umCity'
        );
       // $search = '';

       if ($params['search']['value'] != '') {
        $search .= '(';
        foreach ($search_columns as $key => $value) {
            $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            // print_r($search);
        }
        $search = substr($search, 0, -3);
        $search .= ')';
    }

        // $search .= "umUserCode LIKE '" . $user_data['umUserCode'] . "' OR umFirstName LIKE '" . $user_data['umFirstName'] . "' OR ";
            // $search .= "umLastName LIKE '" . $user_data['umLastName'] . "' OR umUserName LIKE '" . $user_data['umUserName'] . "' OR";
            // $search .= "umEmail LIKE '" . $user_data['umEmail'] . "' OR umCity LIKE '" . $user_data['umCity'] . "'";


        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $search = "umId in (" . $subordinate_users . ")";

        }

        if ($user_data['umIsHOUser'] != 1) {
            if ($params['search']['value'] != '') {
                $search .= ' AND (';
                foreach ($search_columns as $key => $value) {
                    $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
                    // print_r($search);
                }
                $search = substr($search, 0, -3);
                $search .= ')';
            }
        }
       // print_r($search);
        $data = $this->task_model->get_users($params['start'], $params['length'], $search_columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
        // echo $this->db->last_query();
        if ($data['result']) {
            $i_tag = '<input type="checkbox" class="user" value="%d"/>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['select'] = sprintf($i_tag, $row['umId']);
            }
        }

        $results = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => $data['num_rows'],
            "recordsFiltered" => $data['num_rows'],
            "data" => $data['result']
        );
        echo json_encode($results);
    }

    public function json_tasks()
    {
        $user_data = $this->session->userdata('userdata');
        $params = $_REQUEST;
        $search_columns = array(
            'task_name',
            //'task_desc',
            'priority',
            'status',
            // 'ua.umUserName',
            // 'u.umUserName'
            'ut.assigned_user_name',
            'ut.created_user_name'
        );
        $sort_columns = array(
            'ut.task_date',
            'ut.due_date',
            'created_date',
            'task_name',
            'priority',
            // 'ua.umUserName',
            // 'u.umUserName',
            'ut.assigned_user_name',
            'ut.created_user_name',
            'status',
            'perc_of_completion'
        );
        $search = '  t.is_active = 1 ';

        $assigned_by = isset($params['assigned_by']) ? $params['assigned_by'] : "";

        $type = isset($params['type']) ? $params['type'] : "";
        $today = date('Y-m-d');
        // switch ($type) {
        //     case 'due-today-list':
        //         $search .= " AND  ut.due_date = '$today' AND (tc.status NOT LIKE 'completed' OR tc.status IS NULL)";
        //         break;
        //     case 'over-due-list':
        //         $search .= " AND  ut.due_date < '$today' AND (tc.status NOT LIKE 'completed' OR tc.status IS NULL) ";
        //         break;
        //     case 'not-due-list':
        //         $search .= " AND  ut.due_date > '$today' AND (tc.status NOT LIKE 'completed' OR tc.status IS NULL)";
        //         break;
        //     case 'completed-list':
        //         $search .= " AND  tc.status = 'completed' ";
        //         break;  

        //     default:
        //         # code...
        //         break;
        // }

        // switch ($type) {
        //     case 'due-today-list':
        //         $search .= " AND  ut.due_date = '$today' AND (tc.status NOT LIKE 'completed' OR tc.status IS NULL )";
        //         break;
        //     case 'over-due-list':
        //         $search .= " AND  ut.due_date < '$today' AND (tc.status NOT LIKE 'completed' OR tc.status IS NULL )";
        //         break;
        //     case 'not-due-list':
        //         $search .= " AND  ut.due_date > '$today' AND (tc.status NOT LIKE 'completed' OR tc.status IS NULL )";
        //         break;
        //     case 'completed-list':
        //         $search .= " AND  tc.status = 'completed' AND tc.approved_status NOT LIKE 'approved'";
        //         break;  
        //     case 'approved-list':
        //         $search .= " AND  tc.approved_status = 'approved' ";
        //         break;     

        //     default:
        //         # code...
        //         break;
        // }

        switch ($type) {
            case 'due-today-list':
                $search .=  "  AND  ut.due_date = '$today' AND (ut.status NOT LIKE 'completed' OR ut.status IS NULL )";
                break;
            case 'over-due-list':
                $search .= "  AND  ut.due_date < '$today' AND (ut.status NOT LIKE 'completed' OR ut.status IS NULL )";
                break;
            case 'not-due-list':
                $search .= "  AND  ut.due_date > '$today' AND (ut.status NOT LIKE 'completed' OR ut.status IS NULL )";
                break;
            case 'completed-list':
                $search .= " AND  ut.status = 'completed' AND ut.approved_status NOT LIKE 'approved'";
                break;  
            case 'approved-list':
                $search .= " AND  ut.approved_status = 'approved' ";
                break;     

            default:
                # code...
                break;
        }

        if ($params['search']['value'] != '') {
            $search .= ' AND (';
            foreach ($search_columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        $form_data = $this->session->userdata('task');

        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
           // print_r($form_data);
        //    if ($assigned_by == "me") {
            if($form_data['user'] == 'Select' || $form_data['user'] == ""){
            // $search .= " AND (u.umId in ( $subordinate_users ) OR  ua.umId in ( $subordinate_users ) )";
            $search .= " AND (ut.user_id in ( $subordinate_users ) OR  ut.assigned_user_id in ( $subordinate_users ) )";
            }
            //  print_r($search);
        }
//        $form_data = $this->session->userdata('task');

       // $search .= " AND  ut.due_date BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";

        $search .= " AND  ut.task_date BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";

        $search .= " AND priority LIKE '" . $form_data['priority'] . "' ";
  // print_r($form_data);
        if($form_data['user'] != "" && $form_data['user'] != "Select" ){
            if ($assigned_by == "me") {
                $search .= " AND ut.user_id = '" . $user_data['umId'] . "' AND ut.assigned_user_id = '" . $form_data['user'] . "' ";
            } else if ($assigned_by == "other") {
            //  $search .= " AND ut.user_id <> '" . $form_data['user'] . "' ";
            $search .= " AND ut.assigned_user_id = '" . $user_data['umId'] . "' AND ut.user_id = '" . $form_data['user'] . "' ";
            }
        }

        // if ($form_data['status'] == "all") {
        //     $search .= " AND (tc.status LIKE '%%' OR tc.status IS NULL) ";
        // } elseif ($form_data['status'] == "not done") {
        //     $search .= " AND ( tc.status IS NULL) ";
        // } else {
        //     $search .= " AND tc.status LIKE '" . $form_data['status'] . "' ";
        // }

        if ($form_data['status'] == "all") {
            $search .= " AND (ut.status LIKE '%%' OR ut.status IS NULL) ";
        } elseif ($form_data['status'] == "not done") {
            $search .= " AND ( ut.status IS NULL) ";
        } else {
            $search .= " AND ut.status LIKE '" . $form_data['status'] . "' ";
        }
       // print_r($form_data);
        if ($form_data['project'] != '') {
              $search .= " AND t.project_id = '" . $form_data['project'] . "' ";
         }
    //    }

        $data = $this->task_model->get_tasks_list($params['start'], $params['length'], $sort_columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
       // echo $this->db->last_query();
        if ($data['result']) { 
            if (has_privilege('task', 'edit')) { 
            $action_tag = '<a class="assign-users">Assign</a> &nbsp;&nbsp;&nbsp; '
                . '<a href="#task/edit/%s">Edit</a> &nbsp;&nbsp;&nbsp; '
                . '<a onClick="return confirm(\'All the reccurring task will be removed. Are you want to delete this task?\');" href="#task/delete/%s">Delete</a> &nbsp;&nbsp;&nbsp;'
                . '<a href="#task/clone_data/%s">Clone</a>'
                . '<input type="hidden" class="task_id" value="%s">'
                . '<input type="hidden" class="group_ref" value="%s">';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['action'] = sprintf($action_tag, $row['task_id'], $row['task_id'], $row['task_id'],$row['task_id'], $row['group_ref']);
                $data['result'][$key]['assigned_to'] = $row['c'] > 3 ? $row['c'] . ' Persons' : $row['assigned_to'];
            }
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

    public function json_task_list()
    {
        $user_data = $this->session->userdata('userdata');
        $params = $_REQUEST;
        $search_columns = array(
            'task_name',
            //'task_desc',
            'priority',
            'status',
            // 'ua.umUserName',
            // 'u.umUserName'
            'ut.assigned_user_name',
            'ut.created_user_name'
        );
        $sort_columns = array(
            'ut.task_date',
            'ut.due_date',
            'created_date',
            'task_name',
            'priority',
            // 'ua.umUserName',
            'ut.assigned_user_name',
            // 'ut.created_user_name'
            'status',
            'perc_of_completion'
        );
        $search = '  t.is_active = 1 ';

        $type = isset($params['type']) ? $params['type'] : "";
        $today = date('Y-m-d');
        

        if ($params['search']['value'] != '') {
            $search .= ' AND (';
            foreach ($search_columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        $form_data = $this->session->userdata('task');

        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            // $search .= " AND (u.umId in ( $subordinate_users ) OR  ua.umId in ( $subordinate_users ) )";
            $search .= " AND (ut.user_id in ( $subordinate_users ) OR  ut.assigned_user_id in ( $subordinate_users ) )";
            //  print_r($search);
        }
       // print_r($form_data);
        // $search .= " AND  t.task_date BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
       // $search .= " AND  t.task_date BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";

       // $search .= " AND  ut.assigned_date BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
       if($form_data['user'] !=""){
            $search .= " AND  ut.due_date BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
            // $search .= " AND  ut.task_date BETWEEN '" . $form_data['from_date'] . "' AND '" . $form_data['to_date'] . "'";
        }
        $search .= " AND priority LIKE '" . $form_data['priority'] . "' ";

        if($form_data['user'] !="" & $form_data['user'] !="Select")
        {
           // $search .= "AND ut.user_id = '" . $form_data['user'] . "' OR ut.assigned_user_id = '" . $form_data['user'] . "' ";; 
           $search .= "AND (ut.user_id = '" . $form_data['user'] . "' OR ut.assigned_user_id = '" . $form_data['user'] . "') ";
        }


        // if ($form_data['status'] == "all") {
        //     $search .= " AND (tc.status LIKE '%%' OR tc.status IS NULL) ";
        // } elseif ($form_data['status'] == "not done") {
        //     $search .= " AND ( tc.status IS NULL) ";
        // } else {
        //     $search .= " AND tc.status = '" . $form_data['status'] . "' ";
        // }

        if ($form_data['status'] == "all") {
            $search .= " AND (ut.status LIKE '%%' OR ut.status IS NULL) ";
        } elseif ($form_data['status'] == "not done") {
            $search .= " AND ( ut.status IS NULL) ";
        } else {
            $search .= " AND ut.status LIKE '" . $form_data['status'] . "' ";
        }


        if ($form_data['project'] != '') {
            $search .= " AND t.project_id = '" . $form_data['project'] . "' ";
       }

        $data = $this->task_model->get_tasks_list($params['start'], $params['length'], $sort_columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
       // echo $this->db->last_query();
        if ($data['result']) {
            $action_tag = '<a class="assign-users">Assign</a> &nbsp;&nbsp;&nbsp; '
                . '<a href="#task/edit/%s">Edit</a> &nbsp;&nbsp;&nbsp; '
                . '<a onClick="return confirm(\'All the reccurring task will be removed. Are you want to delete this task?\');" href="#task/delete/%s">Delete</a> &nbsp;&nbsp;&nbsp; '
                . '<a href="#task/clone_data/%s">Clone</a>'
                . '<input type="hidden" class="task_id" value="%s">'
                . '<input type="hidden" class="group_ref" value="%s">';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['action'] = sprintf($action_tag, $row['task_id'], $row['task_id'],$row['task_id'], $row['task_id'], $row['group_ref']);
                $data['result'][$key]['assigned_to'] = $row['c'] > 3 ? $row['c'] . ' Persons' : $row['assigned_to'];
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

    public function json_task_templates()
    {
        $user_data = $this->session->userdata('userdata');
        $params = $_REQUEST;
        $search_columns = array(
            'task_name',
            'task_level',
            'difficulty_level',
        );
        $sort_columns = array(
            'task_name',
            'task_level',
            'difficulty_level',
        );
        $search = '  t.is_active = 1 ';
        if ($params['search']['value'] != '') {
            $search .= ' AND (';
            foreach ($search_columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }

        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $search .= " AND (u.umId in ( $subordinate_users ) OR  ua.umId in ( $subordinate_users ) )";
            // echo $search;
        }
        $form_data = $this->session->userdata('task');
        $data = $this->tasktemplate_model->get_tasktemplate_list($params['start'], $params['length'], $sort_columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
        // echo $this->db->last_query();
        if ($data['result']) {
            $action_tag = //'<a class="assign-users">Assign</a> &nbsp;&nbsp;&nbsp; '
                '<a href="#task/edit/%s">Edit</a> &nbsp;&nbsp;&nbsp; '
                . '<a onClick="return confirm(\'All the reccurring task will be removed. Are you want to delete this task?\');" href="#task/delete/%s">Delete</a>'
                . '<input type="hidden" class="task_id" value="%s">'
                . '<input type="hidden" class="group_ref" value="%s">';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['action'] = sprintf($action_tag, $row['task_id'], $row['task_id'], $row['task_id'], $row['task_id']);
                //  $data['result'][$key]['assigned_to'] = $row['c'] > 3 ? $row['c'] . ' Persons' : $row['assigned_to'];
            }
        }

        $results = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => $data['num_rows'],
            "recordsFiltered" => $data['num_rows'],
            "data" => $data['result']
        );
        echo json_encode($results);
    }

    public function clone_data($id){
        $edit_mode = TRUE;
        $priorities_array = array(
            array("id" => "urgent", "name" => "Urgent"),
            array("id" => "high", "name" => "High"),
            array("id" => "medium", "name" => "Medium"),
            array("id" => "low", "name" => "Low"),
        );
        $tasklevel_array = $this->submaster_model->simple_get('typemaster', array('type_id as id', 'name'), 'type="level"');
        $projects_array = $this->list_model->simple_get('projectmaster', array('project_id as id', 'project_name as name'));
        $weeks_array = array(
            array("id" => "monday", "name" => "Monday"),
            array("id" => "tuesday", "name" => "Tuesday"),
            array("id" => "wednesday", "name" => "Wednesday"),
            array("id" => "thursday", "name" => "Thursday"),
            array("id" => "friday", "name" => "Friday"),
            array("id" => "saturday", "name" => "Saturday"),
            array("id" => "sunday", "name" => "Sunday"),
        );

        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data = $this->save_clonedata();
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data['priority']);
                $data['levels'] = generate_options($tasklevel_array, 0, 0, $form_data['task_level']);
                $data['projects'] = generate_options($projects_array, 0, 0, $form_data['project']);
                $data['difficulty_levels'] = generate_options(array(), 1, 10, $form_data['difficulty_level']);
                $data['weeks'] = generate_options($weeks_array, 0, 0, $form_data['week_day']);
                $data['days'] = generate_options(array(), 1, 31, $form_data['day']);
                $this->load->view('tasks/form_task', $data);
            }
        } else {
            $data['edit_mode'] = 1;
            //  $group_ref = $this->input->post('group_ref');
            $form_data = $this->task_model->simple_get('tasks', array('*'), array('task_id' => $id));
            $clone_id = isset($form_data['clone_task_id']) ? $form_data['clone_task_id'] : FALSE;
            $form_data['clone_task_id'] = 1;
            // print_r($form_data['clone_task_id']);
            $template_name = $this->tasktemplate_model->simple_get('task_templates', 'template_name', array('task_id' => $id));
            //$project_name = $this->list_model->simple_get('projectmaster', 'project_name', array('project_id' =>$project_id));
            $data['form_data'] = $form_data[0];
            $data['project_id'] = $data['form_data']['project_id'];
            $project_name = $this->list_model->simple_get('projectmaster', 'project_name', array('project_id' => $data['project_id']));
           // print_r($data['projects']);
        //   print_r($form_data);
            foreach ($form_data  as $rows) {
               $project_details = $data['form_data']['project_id'];
            }
            $project_details = array(
                'project_id' => $project_details
            );
            $data['clone_task_id'] = 1;
            $data['template_names'] = $template_name[0];
            $data['priorities'] = generate_options($priorities_array, 0, 0, $form_data[0]['priority']);
            $data['levels'] = generate_options($tasklevel_array, 0, 0, "");
            //$data['projects'] = generate_options($projects_array, 0, 0,"");
            $data['projects'] = generate_options($projects_array, 0, 0, $project_details);
           // print_r($data['projects']);
            $data['difficulty_levels'] = generate_options(array(), 1, 10, "");
            $data['weeks'] = generate_options($weeks_array, 0, 0, $form_data[0]['week_day']);
            $data['days'] = generate_options(array(), 1, 31, $form_data[0]['day']);
            $data['files'] = $this->taskattachment_model->get_attached_files(array('task_id' => $id));
            
            // $data['assigned_persons'] = $this->task_model->get_assign_users_list(array('task_id' => $id));
           
            // print_r($data['assigned_persons']);
        //   print_r($data);
            $this->load->view('tasks/form_task', $data);
        }
    }

    public function get_task_details($task_id, $group_ref)
    {
        $user_data = $this->session->userdata('userdata');
        $data['user_id'] = $user_data['umId'];
        $tasks = $this->task_model->get_task_details(array('task_id' => $task_id));
        $data['task'] = $tasks[0];
        $data['assigned_persons'] = $this->task_model->get_assigned_users($task_id, $group_ref);
        $data['comments'] = $this->task_model->get_comments($task_id, $group_ref);
       // print_r($data['comments']);
        $data['task_id'] = $task_id;
        $data['group_ref'] = $group_ref;
        $data['ratings'] = generate_options(array(), 1, 10, $data['comments'][0]['rating']);
        $data['approved'] =  $data['comments'][0]['approved'];
        $data['rejected'] =  $data['comments'][0]['rejected'];
        //print_r($data['rejected']);      
        $data['files'] = $this->taskattachment_model->get_attached_files(array('task_id' => $task_id));
        $data['attached_files'] = $this->taskattachment_model->get_attached_files_for_comments(array('task_id' => $task_id));
        $this->load->view('tasks/task_details', $data);
    }

    public function add_comment()
    {
        $form_data = $this->input->post();
        //print_r($form_data);
        $file = isset($form_data['attachment_id']) ? $form_data['attachment_id'] : FALSE;
        $user_data = $this->session->userdata('userdata');
        $attachment_Id = isset($form_data['attachment_id']) ? $form_data['attachment_id'] : FALSE;
        unset($form_data['attachment_id']);
        $form_data['user_id'] = $user_data['umId'];
        $form_data['is_active'] = 1;
        $task_id = $form_data['task_id'];
        $form_data['date'] = date('Y-m-d H:i:s');
        $condition = array('task_id' => $form_data['task_id'], 'group_ref' => $form_data['group_ref']);
        if ($form_data['perc_of_completion'] == 100) {
            $form_data['status'] = "Completed";
            $array['is_done'] = 1;
            $this->task_model->update('user_tasks', array('is_done' => 1, 'done_date' => $form_data['date']), $condition);
        } else {
            $form_data['status'] = "Partial";
            $array['is_done'] = 0;
            $this->task_model->update('user_tasks', array('is_done' => 0, 'done_date' => 0), $condition);
        }
        $this->task_model->update('task_comments', array('is_active' => 0), $condition);
        $result = $this->task_model->insert('task_comments', $form_data);
        $id = $this->db->insert_id();
        $this->task_model->update('user_tasks', array('status' => $form_data['status'], 'perc_of_completion' => $form_data['perc_of_completion']), $condition);
        $this->task_model->update('user_tasks', array('task_comment_id' => $id, 'task_comment_date' => $form_data['date'],'active_comment' => 1), $condition);
        $this->task_model->update('user_tasks', array('task_comment' => $form_data['comment']),$condition);
        // print_r($form_data);
        if ($attachment_Id > 0) {
            foreach ($attachment_Id as $key => $value) {
                $data['task_id'] = $task_id;
                $data['attachment_id'] = $value;
                $data['task_comment_id'] = $id;
                $data['is_result'] = 1;
                $this->db->insert('task_attachments', $data);
            }
        }
        $data['user_id'] = $user_data['umId'];
        $user=$this->db->get_where('usermaster',array('umId'=>$user_data['umId']))->row();
        $data['comments'] = $this->task_model->get_comments($task_id, $form_data['group_ref']);
        $data['attached_files'] = $this->taskattachment_model->get_attached_files_for_comments(array('task_id' => $task_id));
        $array['html'] = $this->load->view('tasks/task_comment', $data, true);
        $array['perc_of_completion'] = $form_data['perc_of_completion'];
        $array['is_done'] = $form_data['perc_of_completion'] == 100 ? 1 : 0;
        if($result !=""){
        //    alert('updates successfully');
        //}
        //echo json_encode($array);
    //}
        $task=$this->db->get_where('tasks',array('task_id'=>$task_id))->row();
        $this->db->distinct();
        $this->db->select('assigned_user_id');
        $other_candidates = $this->db->get_where('user_tasks', array('task_id' => $task_id, 'assigned_user_id !=' => $user_data['umId']))->result();                    

        $task_details = array('task_id' => $task_id, 'group_ref' => $form_data['group_ref'],'task_name'=>$task->task_name,'perc_of_completion'=>$form_data['perc_of_completion']);
        $task=$this->db->get_where('tasks',array('task_id'=>$task_id))->row();
        if($file)
            {
                $comment="File added";
            }
        else if($this->input->post('comment')!="")
            {
                $comment=$user->umFirstName . " added " . $task->task_name;
            }
        else{
                $comment=$user->umFirstName." added an empty text comment"; 
            }
        $task=$this->db->get_where('tasks',array('task_id'=>$task_id))->row();
        $this->sendPushnotification($comment, "New comment added to " . $task->task_name, $other_candidates, $task_details);
        alert('updates successfully');
        }
        echo json_encode($array);
    }

    public function sendPushnotification($body, $title, $users, $data)
    {
        include_once APPPATH . 'classes/FCM.php';

        $device_tokens = array();
        foreach ($users as $user) {

           $tokens = $this->db->get_where('firebase_tokens', array('user_id' => $user->assigned_user_id));
          // $tokens = $this->db->get_where('firebase_tokens', array('user_id' => $user['user_id']));

            if ($tokens->num_rows() > 0) {
                array_push($device_tokens, $tokens->row()->token);
            }
        }

        foreach ($device_tokens as $token) {
            $assigned_user_id=$this->db->get_where('firebase_tokens',array('token'=>$token))->row()->user_id;
            $group_ref=$this->db->get_where('user_tasks',array('task_id'=>$data['task_id'],'assigned_user_id'=>$assigned_user_id))->row()->group_ref;
            //$group_ref='';

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
            array_merge($arrNotification, $data);

            $fcm = new FCM();
            $result = $fcm->send_notification($token, $arrNotification, "Android");
        }
    }

    public function approve_task_completion()
    {
        $form_data = $this->input->post();
      // print_r($form_data);
        $user_data = $this->session->userdata('userdata');
       // print_r($user_data); 
        //$form_data['is_active'] = 1;
        $task_id = $form_data['task_id'];
        $group_ref = $form_data['group_ref'];
        $rating = $form_data['rating'];
        $form_data['approved_date'] = date('Y-m-d H:i:s');
       // $condition = array('task_id' => $form_data['task_id'], 'group_ref' => $form_data['group_ref']);
       $condition = array('task_id' => $task_id, 'group_ref' => $group_ref);
      //  $form_data['approved'] =1;
       $data['approved'] = 1;
       $data['rejected'] = 0;
       $data['rating'] = $rating;
       $data['approved_date'] = $form_data['approved_date'];
       $data['rejected_date'] = "";
       $data['approved_status'] = 'approved';
       $data['approved_by'] = $user_data['umId'];
       $data['rejected_by'] = 0;
       // $this->task_model->update('task_comments', array('approved' => 1 ,'rejected' => 0, 'approved_date' => $form_data['date'],'rating' => $rating,'approved_status' =>'approved'), $condition);
       $this->task_model->update('task_comments',$data,$condition); 
       $this->task_model->update('user_tasks',array('approved_status' => $data['approved_status']),$condition);  
       $this->task_model->update('user_tasks',array('approved_by' => $data['approved_by'],'rejected_by' => $data['rejected_by']),$condition);   
    }

    public function reject_task_completion()
    {
        $form_data = $this->input->post();
       // print_r($form_data);
        $user_data = $this->session->userdata('userdata');
       // print_r($user_data);
        //$form_data['is_active'] = 1;
        $task_id = $form_data['task_id'];
        $group_ref = $form_data['group_ref'];
        $rating = $form_data['rating'];
        $form_data['rejected_date'] = date('Y-m-d H:i:s');
       $condition = array('task_id' => $task_id, 'group_ref' => $group_ref);
       $data['approved'] = 0;
       $data['rejected'] = 1;
       $data['rating'] = $rating;
       $data['rejected_date'] = $form_data['rejected_date'];
       $data['approved_date'] = "";
       $data['approved_status'] = 'rejected'; 
       $data['rejected_by'] = $user_data['umId'];
       $data['approved_by'] = 0;
      // $this->task_model->update('task_comments', array('approved' => 0,'rejected' => 1 ,'rating' => $rating,'rejected_date' => $form_data['rejected_date'],'approved_status' =>'rejected'), $condition);
      $this->task_model->update('task_comments',$data,$condition); 
      $this->task_model->update('user_tasks',array('approved_status' => $data['approved_status']),$condition); 
      $this->task_model->update('user_tasks',array('rejected_by' => $data['rejected_by'],'approved_by' => $data['approved_by']),$condition);  
    }

    public function remove_user()
    {
        $form_data = $this->input->post();
        if (isset($form_data['task_id']) && isset($form_data['group_ref']) && isset($form_data['assigned_user_id'])) {
            $this->task_model->delete('user_tasks', $form_data);
        }
    }

    public function complete_task()
    {
        $form_data = $this->input->post();
        $user_data = $this->session->userdata('userdata');
        $form_data['user_id'] = $user_data['umId'];
        $form_data['is_active'] = 1;
        $form_data['date'] = date('Y-m-d H:i:s');
        $condition = array('task_id' => $form_data['task_id'], 'group_ref' => $form_data['group_ref']);

        $this->task_model->update('user_tasks', array('is_done' => $form_data['is_done'], 'done_date' => $form_data['date']), $condition);
        if ($form_data['is_done'] == 1) {
            $form_data['comment'] = $user_data['umFirstName'] . " marked the task as complete";
            $form_data['perc_of_completion'] = 100;
            $form_data['status'] = "Completed";
        } else {
            $form_data['comment'] = $user_data['umFirstName'] . " reopened the task";
            $form_data['perc_of_completion'] = 50;
            $form_data['status'] = "Partial";
        }
        unset($form_data['is_done']);

        $this->task_model->update('task_comments', array('is_active' => 0), $condition);
        $this->task_model->insert('task_comments', $form_data);
        $data['user_id'] = $user_data['umId'];
        $data['comments'] = $this->task_model->get_comments($form_data['task_id'], $form_data['group_ref']);
        $array['html'] = $this->load->view('tasks/task_comment', $data, true);
        $array['perc_of_completion'] = $form_data['perc_of_completion'];
        $array['is_done'] = $form_data['perc_of_completion'] == 100 ? 1 : 0;

        echo json_encode($array);
    }
}
