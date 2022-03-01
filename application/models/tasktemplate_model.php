<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author ajith
 * @date 9 Mar, 2015
 */
class Tasktemplate_Model extends MY_Model {

    protected $table = "";

    public function __construct() {
        parent::__construct();
    }

    function get_tasktemplate_list($start, $length, $order_column, $order_dir, $task_id, $condition = '') {

        $this->db->select('t.task_id,tt.template_name,t.difficulty_level,tm.name',false);
        $this->db->from('tasks t');
        $this->db->join('task_templates tt', 't.task_id = tt.task_id', 'inner');
        $this->db->join('user_tasks ut', 't.task_id = ut.task_id', 'left');
        $this->db->join('typemaster tm', 't.task_level = tm.type_id','inner');
        $this->db->join('usermaster u', 'ut.user_id = u.umId', 'left');
        $this->db->join('usermaster ua', 'ut.assigned_user_id = ua.umId', 'left');

        if ($condition != '') {
            $this->db->where($condition, '', FALSE);
        }
        $this->db->group_by('t.task_id');
        $data['num_rows'] = $this->db->count_results();
        $this->db->order_by($order_column, $order_dir);
        $this->db->limit($length, $start);
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
        } else {
            $data['result'] = false;
        }
        return $data;
   }
}
