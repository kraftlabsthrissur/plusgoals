<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Form_validation
 *
 * @author kraftlabs
 */
class MY_Form_validation extends CI_Form_validation {

    var $CI;

    public function __construct($rules = array()) {
        $this->CI = & get_instance();
        parent::__construct($rules);
    }

    public function error_array() {
        return $this->_error_array;
    }

    public function error_class() {
        $error_class = array();
        foreach ($this->_error_array as $key => $value) {
            $error_class[$key] = "error";
        }
        return $error_class;
    }

    public function max_value($value, $max) {
        if ($max > $value) {
            $this->CI->form_validation->set_message('max_value', 'The %s can not be greater than ' . $max);
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function exist_among($state, $field) {
        list($table, $column, $condition_column, $value) = explode('.', $field, 4);
        $this->CI->db->select("$column");
        $this->CI->db->where("$column", "$state");
        $this->CI->db->where("$condition_column <>", "$value");
        $this->CI->db->from("$table");
        $query = $this->CI->db->get();
        if ($query->num_rows() === 0) {
            return TRUE;
        } else {
            $this->CI->form_validation->set_message('exist_among', sprintf(' %s  already exists', $column));
            return FALSE;
        }
    }

    public function exists($state, $field) {
        list($table, $column) = explode('.', $field, 2);
        $this->CI->db->select("$column");
        $this->CI->db->where("$column", "$state");
        $this->CI->db->from("$table");
        $query = $this->CI->db->get();
        if ($query->num_rows() === 0) {
            return TRUE;
        } else {
            $this->CI->form_validation->set_message('exists', sprintf('%s already exists ', $column));
            return FALSE;
        }
    }

    function error_exists($field) {
        if (!empty($this->_field_data[$field]['error'])) {
            return TRUE;
        }
        return FALSE;
    }

}
