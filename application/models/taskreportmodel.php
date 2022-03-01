<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class TaskReportModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_tasks($where){
     
      $this->db->select("t.*,ut.*,um.umUserName,umc.umUserName AS Createdby,ro.role_name",false);  
      $this->db->from('user_tasks ut'); 
      $this->db->join('tasks t','t.task_id=ut.task_id','inner');
      $this->db->join('usermaster um','ut.assigned_user_id=um.umid','inner');
      $this->db->join('usermaster umc','ut.user_id=umc.umid','inner');
      $this->db->join('roles ro','um.umid=ro.role_id','inner');
     
      $this->db->where($where);  
      $query = $this->db->get();
      
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_tasks_list($start, $length, $order_column, $order_dir, $where) {

    // $this->db->select('t.task_id,ut.group_ref,DATE_FORMAT(tc.date,"%d-%m-%Y %h:%i %p")as date,u.umUserName assigned_by,ua.umUserName assigned_to,
    //     t.task_name, date(t.created_date) created_date, COALESCE(tc.status,"Not Done") status,coalesce(tc.perc_of_completion,0) perc_of_completion,
    //     t.due_date, MAX(tc.comment)as comment,tc.approved_status,um.umUserName as approved_by,uam.umUserName as rejected_by,COALESCE(ut.task_date, t.task_date) task_date, COALESCE(ut.due_date, t.due_date) due_date', false);
    //     $this->db->from('tasks t');
    //     $this->db->join('user_tasks ut', 't.task_id = ut.task_id', 'left');
    //     $this->db->join('task_comments tc', 't.task_id = tc.task_id AND tc.group_ref = ut.group_ref', 'left');
    //     $this->db->join('usermaster u', 'ut.user_id = u.umId', 'left');
    //     $this->db->join('usermaster ua', 'ut.assigned_user_id = ua.umId', 'left');
    //     $this->db->join('usermaster um', 'tc.approved_by = um.umId', 'left');
    //     $this->db->join('usermaster uam', 'tc.rejected_by = uam.umId', 'left');

    $this->db->select('t.task_id, ut.group_ref, ut.created_user_name assigned_by, DATE_FORMAT(ut.task_comment_date, "%d-%m-%Y %h:%i %p")as date, ut.assigned_user_name assigned_to, t.task_name,
        date(t.created_date) created_date, IF(ut.status = " ", "Not Done", ut.status)as status, ut.perc_of_completion
        , t.due_date, ut.approved_status, u.umusername as approved_by, um.umusername as rejected_by,ut.task_comment as comment,
        COALESCE(ut.task_date, t.task_date) task_date,COALESCE(ut.due_date, t.due_date) due_date', false);

        $this->db->from('tasks t');
        $this->db->join('user_tasks ut', 't.task_id = ut.task_id AND t.is_active=1', 'left');
        $this->db->join('usermaster u', 'ut.approved_by = u.umId', 'left');
        $this->db->join('usermaster um', 'ut.rejected_by = um.umId', 'left');
           // if ($condition != '') {
            $this->db->where($where, '', FALSE); 
            $this->db->group_by(',t.task_id,ut.group_ref'); 
            $data['num_rows'] = $this->db->count_results();
            //$this->db->order_by('tc.task_comment_id','desc');
            $this->db->order_by('ut.task_comment_id','desc');
            $this->db->limit($length, $start);
            //}
            $query = $this->db->get();
         //echo $this->db->last_query();
            $data['q'] = $this->db->last_query();
            if ($query->num_rows() > 0) {
                $data['result'] = $query->result_array();
            } else {
                $data['result'] = false;
            }
            return $data;
    }
}

