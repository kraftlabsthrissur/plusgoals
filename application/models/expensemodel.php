<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class ExpenseModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_expenses($where){
        $this->db->select('ex.*,u.umUserName,r.route_name,am.amAreaName');
        $this->db->from('expenses ex');
        $this->db->join('usermaster u','ex.user_id=u.umid','inner');
        $this->db->join('routes r','ex.route_id=r.route_id','inner');
        $this->db->join('areamaster am','r.headquarters_id=am.amid','inner');
        $this->db->where($where ,'', FALSE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
    public function get_expenses_by_id($id){
        $this->db->select('ex.*,u.umUserName,r.route_name,am.amAreaName');
        $this->db->from('expenses ex');
        $this->db->join('usermaster u','ex.user_id=u.umid','inner');
        $this->db->join('routes r','ex.route_id=r.route_id','inner');
        $this->db->join('areamaster am','r.headquarters_id=am.amid','inner');
      //$this->db->where('ex.user_id',$id['user_id']);
        $this->db->where('ex.id',$id['id']);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
}
?>
