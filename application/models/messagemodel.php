<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class MessageModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_users($where){
        $this->db->select('um.umid,um.umUserName,r.role_name,m.status');
        $this->db->from('usermaster um');
        $this->db->join('roles r','um.role_id=r.role_id');
        $this->db->join('message_details md','md.user_id=um.umid','left');
        $this->db->join('messages m','md.message_id=m.message_id','left');
        $this->db->where($where,'',false);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
        
    }
}