<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author ajith
 * @date 9 Mar, 2015
 */
class Task_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

//    public function get_tasks($condition) {
//        $this->db->select('*');
//        $this->db->from('tasks t');
//        $this->db->join('usermaster u1', 'u1.umId = t.created_by');
//        $this->db->join('usermaster u2', 'u2.umId = t.assigned_to','left');
//        $this->db->where($condition);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $result = $query->result_array();
//            return $result;
//        }
//        return FALSE;
//    }
    public function get_tasks($condition) {
        $this->db->select('*');
        $this->db->from('tasks t');


        $this->db->where($condition, '', false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_users($start, $length, $order_column, $order_dir, $condition = '') {

        // $this->db->select("umId,concat(umFirstName,' ',umLastName) userFullName,umEmail,umCity,(select count(*) from user_tasks where task_id = '$task')as assigned", false);
        $this->db->select("umId,concat(umFirstName,' ',umLastName) userFullName,umEmail,umCity", false);
        $this->db->from('usermaster');
        $this->db->where('umId !=', 1);
        if ($condition != '') {
            $this->db->where($condition, '', FALSE);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column, $order_dir);
        $this->db->limit($length, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
        } else {
            $data['result'] = false;
        }
        return $data;
    }

    function get_users_edit($id) {

        $this->db->select('count(*)', false);
        $this->db->from('user_tasks');
        $this->db->where('task_id ', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
        } else {
            $data['result'] = false;
        }
        return $data;
    }

    function get_username($id) {

        $this->db->select('umUserName', false);
        $this->db->from('usermaster');
        $this->db->where('umId ', $id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_tasks_list($start, $length, $order_column, $order_dir, $condition = '') {

        // $this->db->select('t.task_id,t.task_name,DATE_FORMAT(t.created_date,"%d-%m-%Y") created_date, t.task_desc,DATE_FORMAT(COALESCE(ut.task_date,t.task_date),"%d-%m-%Y") task_date,'
        //         . 'DATE_FORMAT(COALESCE(ut.due_date,t.due_date),"%d-%m-%Y") due_date,ut.created_user_name assigned_by, t.priority,'
        //         . 'ut.assigned_user_name assigned_to,tc.approved_status,'
        //         . 'ut.group_ref,count(t.task_id) c,COALESCE(tc.status,"Not Done") status,coalesce(tc.perc_of_completion,0) perc_of_completion', false);
        // $this->db->from('tasks t');
        // $this->db->join('user_tasks ut', 't.task_id = ut.task_id', 'left');
        // $this->db->join('task_comments tc', 't.task_id = tc.task_id AND ut.group_ref = tc.group_ref AND tc.is_active = 1', 'left');
        // if ($condition != '') {
        //     $this->db->where($condition, '', FALSE);
        // }

        $this->db->select('t.task_id,t.task_name,DATE_FORMAT(t.created_date,"%d-%m-%Y") created_date, t.task_desc,DATE_FORMAT(COALESCE(ut.task_date,t.task_date),"%d-%m-%Y") task_date,'
                . 'DATE_FORMAT(COALESCE(ut.due_date,t.due_date),"%d-%m-%Y") due_date,ut.created_user_name assigned_by, t.priority,'
                . 'ut.assigned_user_name assigned_to,IF(ut.status = "", "Not Done",ut.status)as status,ut.perc_of_completion,'
                . 'ut.group_ref,count(t.task_id) c', false);
        $this->db->from('tasks t');
        $this->db->join('user_tasks ut', 't.task_id = ut.task_id AND t.is_active = 1', 'left');
        // $this->db->join('task_comments tc', 't.task_id = tc.task_id AND ut.group_ref = tc.group_ref AND tc.is_active = 1', 'left');
        if ($condition != '') {
            $this->db->where($condition, '', FALSE);
        }
        
        $this->db->group_by('t.task_id,ut.group_ref');
        // $this->db->group_by('t.task_id');
        $data['num_rows'] = $this->db->count_results();
        $this->db->order_by($order_column, $order_dir);
        $this->db->limit($length, $start);
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

    function get_task_details($condition) {
        $this->db->select('t.*,u.umFirstName,u.umLastName');
        $this->db->from('tasks t');
        $this->db->join('usermaster  u', 't.created_by = u.umId', 'left');

        $this->db->where($condition, '', false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
    function get_assigned_users($task_id,$group_ref) {
        $this->db->select('ut.*,u.umFirstName,u.umLastName');
        $this->db->Distinct('ut.*');
        $this->db->from('user_tasks ut');
        $this->db->join('usermaster  u', 'ut.assigned_user_id = u.umId', 'left');

        $this->db->where('ut.task_id', $task_id, false);
        $this->db->where('ut.group_ref', $group_ref, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_assigned_users_to_projects($condition) {
        $this->db->select('up.*,u.umFirstName,u.umLastName');
        $this->db->from('user_projects up');
        $this->db->join('usermaster  u', 'up.assigned_user_id = u.umId', 'inner');

        $this->db->where($condition,'',false);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
    
    function get_assign_users($condition) {
        $this->db->select('ut.*,u.umFirstName,u.umLastName');
        $this->db->from('user_tasks ut');
        $this->db->join('usermaster  u', 'ut.assigned_user_id = u.umId', 'left');

        $this->db->where($condition,'',false);
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_assign_users_list($condition) {
        $this->db->select('ut.assigned_user_id,u.umId,u.umFirstName,u.umLastName');
        $this->db->Distinct('ut.*');
        $this->db->from('user_tasks ut');
        $this->db->join('usermaster  u', 'ut.assigned_user_id = u.umId', 'left');

        $this->db->where($condition,'',false);
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_assign_users_edit($condition) {
        $this->db->select('ut.assigned_user_id');
        $this->db->Distinct('ut.assigned_user_id');
        $this->db->from('user_tasks ut');

        $this->db->where($condition,'',false);
        $query = $this->db->get();
    //    echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_comments($task_id,$group_ref) {
        // $this->db->select('uc.*,u.umFirstName,u.umLastName');
        $this->db->select('uc.*,u.umFirstName,u.umLastName');
        $this->db->from('task_comments uc');
        $this->db->join('usermaster  u', 'uc.user_id = u.umId', 'left');

        $this->db->where('uc.task_id', $task_id, false);
        $this->db->where('uc.group_ref', $group_ref, false);
        $this->db->order_by('uc.task_comment_id','asc');
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_comment_id($task_id) {
        $this->db->select('task_comment_id');
        $this->db->from('task_comments');

        $this->db->where('task_id', $task_id, false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
}
