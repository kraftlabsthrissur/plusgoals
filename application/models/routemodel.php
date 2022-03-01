<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class RouteModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_routes($where) {
        $date = DATE('Y-m-d');
        $this->db->select('r.route_id,headquarters_id,route_name,starting_location,created_by,created_date,
        am.amAreaName as headquartersName,rd.id,rd.customer_id,place,latitude,longitude,order');
        $this->db->from('routes r');
        $this->db->join('areamaster am', 'r.headquarters_id=am.amId');
        $this->db->join('route_details rd', 'r.route_id=rd.route_id',"LEFT");
        $this->db->where($where);
        $this->db->group_by('r.route_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function showcustomerDet($data) {
        $this->db->select('smId,smStoreName');
        $this->db->from('storemaster');
        $this->db->where('smIsActive', 1);
        $this->db->where('smCity', $data);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_customer_address($condition) {

        $sql = "select concat(ifnull(`smAddress1`,''),' ',`smCity`,',',`smState`,' ',ifnull(`smCountry`,'') ) AS address from storemaster where" . $condition;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    public function get_routes_by_id($where) {
//        $this->db->select("r.*,rd.*,um.umUserName,am.amAreaName,concat(ifnull(sm.smAddress1,''),'',ifnull(sm.smCity,''),'',ifnull(sm.smState,''),ifnull(sm.smCountry,''))",'',false);
//        $this->db->from('routes r','',false);
//        $this->db->join('route_details rd','r.route_id=rd.route_id','left','',false);
//        $this->db->join('usermaster um','r.created_by=um.umId','left','',false);
//        $this->db->join('areamaster am','r.headquarters_id=am.amId','left','',false);
//        $this->db->join('storemaster sm','rd.place=sm.smStoreName','left','',false);
//        $this->db->where($where,'',false);
//        $query = $this->db->get();
        $sql = "SELECT  `r` . * ,  `rd` . * ,  `um`.`umUserName` ,  `am`.`amAreaName` , smCity as location, smAddress2 as area,place as name,CONCAT( IFNULL( sm.smAddress1,  '' ),' ', IFNULL( sm.smCity, '' ) ,  ',', IFNULL( sm.smState,  '' ) ,',', IFNULL( sm.smCountry,  '' ) ) as address 
FROM (
`routes` r
)
LEFT JOIN  `route_details` rd ON  `r`.`route_id` =  `rd`.`route_id` 
LEFT JOIN  `usermaster` um ON  `r`.`created_by` =  `um`.`umId` 
LEFT JOIN  `areamaster` am ON  `r`.`headquarters_id` =  `am`.`amId` 
LEFT JOIN  `storemaster` sm ON  `rd`.`place` =  `sm`.`smStoreName` where
" . $where;
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_assigned_user($where) {
        $date = DATE('Y-m-d');
        $sql = "select um.umUserName,ar.user_id,ar.route_id,ar.date from assigned_routes ar join routes r on ar.route_id=r.route_id"
                . " join usermaster um on ar.user_id=um.umId where $where and ar.date='" . $date . "'";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_assigned_routes($subordinate_users) {
        if($subordinate_users==null){
            $where="ar.is_active=1";
        }
        else{
           $where="ar.user_id in (".$subordinate_users.") and ar.is_active=1"; 
        }
        $sql = "select r.*,um.umUserName,ar.user_id,ar.route_id,ar.date,ar.id ar_id from assigned_routes ar join usermaster um on ar.user_id=um.umId join routes r on ar.route_id=r.route_id where ".$where;
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_assigned_routes_by_date($where) {
        $sql = "select r.*,um.umUserName,usm.umUserName as created_by, am.amAreaName,ar.user_id,ar.route_id,ar.date from assigned_routes ar "
                . "join usermaster um on ar.user_id=um.umId "
                . "join routes r on ar.route_id=r.route_id "
                . "join areamaster am on r. headquarters_id=am.amId "
                . "join usermaster usm on r.created_by=usm.umId "
                . "where " . $where . " and ar.is_active=1";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }
    public function get_assigned_route_names($where){
        $sql="select ar.route_id as id,r.route_name as name from routes r join assigned_routes ar on ar.route_id=r.route_id where ".$where;
         $query = $this->db->query($sql);
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    

}
