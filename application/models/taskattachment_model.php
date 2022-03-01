<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author ajith
 * @date 9 Mar, 2015
 */
class Taskattachment_Model extends MY_Model {

    protected $table = "";

    public function __construct() {
        parent::__construct();   
    }
    function get_attached_files($condition){
        $this->db->select('af.file_id,af.file_name,af.file_path','ta.task_comment_id');
        $this->db->from('attached_files af');
        $this->db->join('task_attachments ta','ta.attachment_id=af.file_id','inner');
        $this->db->where($condition, '', false);
        $this->db->where('is_result', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;

    }
    
    function get_attached_files_for_comments($condition){
        $this->db->select('af.file_id,af.file_name,af.file_path, ta.task_comment_id');
        $this->db->from('attached_files af');
        $this->db->join('task_attachments ta','ta.attachment_id=af.file_id','inner');
        $this->db->where($condition, '', false);
        $this->db->where('is_result', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;

    }

}
