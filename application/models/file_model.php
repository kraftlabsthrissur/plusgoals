<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author ajith
 * @date 9 Mar, 2015
 */
class File_Model extends MY_Model {

    protected $table = "";

    public function __construct() {
        parent::__construct();
        $this->table = "attached_files";
    }

    function get_attached_files($condition){
        $this->db->select('af.file_name');
        $this->db->from('attached_files af');
        $this->db->join('task_attachments ta','ta.attachment_id=af.file_id','inner');
        $this->db->where($condition, '', false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;

        }
        return FALSE;

    }



    

}
