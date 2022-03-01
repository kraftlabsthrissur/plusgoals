<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class ExpenseReportModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_expense($where){
     
      $this->db->select("ex.*,DATE_FORMAT(ex.date,'%Y-%d-%m') as date,u.umUserName,r.*,a.amAreaName,ro.role_name",false);  
      $this->db->from('expenses ex'); 
      $this->db->join('usermaster u','ex.user_id=u.umid','inner');
      $this->db->join('roles ro','u.role_id=ro.role_id','inner');
      $this->db->join('routes r','ex.route_id=r.route_id','inner');
      $this->db->join('areamaster a','r.headquarters_id=a.amid','inner');
      $this->db->where($where);  
      $query = $this->db->get();
      
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
}

