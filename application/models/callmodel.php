<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class CallModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_calls($where) {
        $this->db->select('c.id,c.route_id,c.customer_id,c.status,c.date,u.umUserName,r.route_name,s.smStoreName,s.customer_group');
        $this->db->from('calls c');
        $this->db->join('usermaster u', 'c.user_id=u.umid', 'inner');
        $this->db->join('routes r', 'c.route_id=r.route_id', 'inner');
        $this->db->join('storemaster s', 'c.customer_id=s.smid', 'inner');
        $this->db->where($where, '', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    function get_calls_json($start, $length, $order_column, $order_dir, $condition = '') {

        $this->db->select('c.id,c.route_id,c.customer_id,c.status,c.date,u.umUserName,r.route_name,s.smStoreName,s.customer_group');
        $this->db->from('calls c');
        $this->db->join('usermaster u', 'c.user_id=u.umid', 'inner');
        $this->db->join('routes r', 'c.route_id=r.route_id', 'inner');
        $this->db->join('storemaster s', 'c.customer_id=s.smid', 'inner');

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

    function get_new_calls_json($start, $length, $order_column, $order_dir, $condition = '') {

        $this->db->select('c.*, u.umUserName');
        $this->db->from('new_customer_call c');
        $this->db->join('usermaster u', 'c.user_id=u.umid', 'LEFT');

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

    public function get_users() {
        $this->db->select('u.umUserName name, umId id');
        $this->db->from('usermaster u');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_new_customer_calls($where) {
        $this->db->select('c.*, u.umUserName');
        $this->db->from('new_customer_call c');
        $this->db->join('usermaster u', 'c.user_id=u.umid', 'inner');
        $this->db->where($where, '', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_calls_by_id($where) {
        $this->db->select('c.*,u.umUserName,r.route_name,s.smStoreName,s.customer_group');
        $this->db->from('calls c');
        $this->db->join('usermaster u', 'c.user_id=u.umid', 'inner');
        $this->db->join('routes r', 'c.route_id=r.route_id', 'inner');
        $this->db->join('storemaster s', 'c.customer_id=s.smid', 'inner');
        $this->db->where($where, '', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function select_customers($id) {
        $this->db->select('sm.smid as id,sm.smStoreName as name');
        $this->db->from('route_details rd');
        $this->db->join('storemaster sm', 'rd.customer_id=sm.smid and route_id = ' . $id);
        // $this->db->where('route_id',$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

}
