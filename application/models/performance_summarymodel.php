<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class Performance_SummaryModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    // public function get_tasks($where){
     
    //   $this->db->select("t.*,ut.*,um.umUserName,umc.umUserName AS Createdby,ro.role_name",false);  
    //   $this->db->from('user_tasks ut'); 
    //   $this->db->join('tasks t','t.task_id=ut.task_id','inner');
    //   $this->db->join('usermaster um','ut.assigned_user_id=um.umid','inner');
    //   $this->db->join('usermaster umc','ut.user_id=umc.umid','inner');
    //   $this->db->join('roles ro','um.umid=ro.role_id','inner');
     
    //   $this->db->where($where);  
    //   $query = $this->db->get();
      
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         return $result;
    //     }
    //     return FALSE;
    // }

    function get_tasks_list($where) {
        $this->db->select('ua.umUsername,
        Count(distinct ut.task_id)as total_tasks,
        count(distinct Case When tc.approved = 1 THEN tc.task_id END) AS completed_tasks, 
        Case When tc.status != "Completed" AND ut.assigned_user_id = ua.umId THEN Count(distinct tc.task_id) else 0 END As pending_tasks, 
        SUM(tc.rating) as total_rating', false);
        $this->db->from('tasks t');
        $this->db->join('user_tasks ut', 't.task_id = ut.task_id', 'left');
        $this->db->join('task_comments tc', 't.task_id = tc.task_id AND tc.group_ref = ut.group_ref', 'left');
        $this->db->join('usermaster ua', 'ut.assigned_user_id = ua.umId', 'left');

       // if ($condition != '') {
        $this->db->where($where, '', FALSE); 
        $this->db->group_by('ua.umUsername');
        $data['num_rows'] = $this->db->count_results();
        // $this->db->order_by('tc.task_comment_id','desc');
        //}
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            // print_r($result);
            return $result;
        }
        return FALSE;
    }
}

