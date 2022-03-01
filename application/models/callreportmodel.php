<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class CallReportModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_call($condition){
        $this->db->select('c.*,um.umUserName,sm.smStoreName,sm.customer_group,'
                . 'group_concat(DISTINCT cb.prescribing_product) as prescribing_product,group_concat(DISTINCT cs.sample) as sample,ro.role_name');
        $this->db->from('calls c');
        $this->db->join('call_details_prescribs cb','c.id=cb.call_id');
        $this->db->join('call_details_sample cs','c.id=cs.call_id');
        $this->db->join('storemaster sm','c.customer_id=sm.smid');
        $this->db->join('usermaster um','c.user_id=um.umid');
        $this->db->join('roles ro','um.umid=ro.role_id');
        $this->db->where($condition);
        $this->db->group_by('cb.call_id');
        $query = $this->db->get();
       
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
    public function get_prescribing_product($condition){
        $this->db->select('cb.prescribing_product');
        $this->db->from('call_details_prescribs cb');
        $this->db->where('cb.call_id',$condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
    public function get_sample($condition){
        $this->db->select('cs.sample');
        $this->db->from('call_details_sample cs');
        $this->db->where('cs.call_id',$condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
}