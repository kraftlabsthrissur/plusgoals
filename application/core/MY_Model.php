<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author ajith
 * @date 9 Mar, 2015
 */
class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $data data
     * @return type
     */
    public function insert_new( $data) {
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $table table name
     * @param type $data data
     * @return type
     */
    public function insert($table, $data) {
        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    

    /**
     * 
     * @param type $table
     * @param type $data
     * @param type $condition
     */
    public function edit($table, $data, $condition) {
        $this->db->where($condition);
        $this->db->set($data);
        $result = $this->db->update($table,$data, $condition);
        return $result;
    }

    /**
     * 
     * @param string $table table name
     * @param array $fields 
     * @param array $condition
     * @return array
     */
    public function simple_get($table, $fields, $condition = '') {
        $this->db->select($fields);
        $this->db->from($table);
        if ($condition !== '') {
            $this->db->where($condition,"",false);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    /**
     * 
     * @param type $table table name
     * @param type $data data
     * @return type
     */
    public function insert_batch($table, $data) {
        if ($this->db->insert_batch($table, $data)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $table table name
     * @param type $data data
     * @return type
     */
    public function update($table, $data, $condition) {
        $this->db->where($condition);
        if ($this->db->update($table, $data)) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param type $table table name
     * @param type $condition
     * @return null
     */
    public function delete($table, $condition) {
        $this->db->where($condition);
        $this->db->delete($table);
    }

    /**
     *
     * @param type $table table name
     * @param type $data data
     * @return type $insert_id
     */    
    public function insert_if_not_exists($table, $data) {
        $this->db->select('count(1) c', FALSE);
        $this->db->from($table);
        $this->db->where($data);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if ($result['c'] == 0) {
                return $this->insert($table, $data);
            }
        }
    }

public function is_exists($table, $data) {
        $this->db->select('count(1) c', FALSE);
        $this->db->from($table);
        $this->db->where($data);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['c'];
        }
        return FALSE;
    }

    public function get_from_list($table, $fields, $condition_field, $in = FALSE, $not_in = FALSE) {
        $this->db->select($fields, FALSE);
        $this->db->from($table);
        if ($in !== FALSE) {
            $this->db->where_in($condition_field, $in);
        }
        if ($not_in !== FALSE) {
            $this->db->where_not_in($condition_field, $not_in);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function log_activity($table, $condition, $changes) {
        $old_records = $this->simple_get($table, '*', $condition);
        $log = array();
        if ($old_records) {
            $old_record = $old_records[0];
            $i = 0;
            foreach ($changes as $key => $value) {
                if (isset($old_record[$key]) && $old_record[$key] != $value) {
                    $log[$i]['field'] = $key;
                    $log[$i]['old_value'] = $old_record[$key];
                    $log[$i]['new_value'] = $value;
                    $i++;
                }
            }
        }
        
    }

}
