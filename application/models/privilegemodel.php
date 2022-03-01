<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */
class PrivilegeModel extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_roles($condition) {
        $this->db->select('*');
        $this->db->from('roles r');
        $this->db->join('access_levels a', 'a.access_level_id = r.access_level_id');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    // public function get_users($condition, $in = FALSE) {
    //     $this->db->select('r.*,u.*');
    //     $this->db->from('usermaster u');
    //     $this->db->join('roles r', 'r.role_id = u.role_id','left');
    //     $this->db->where($condition, NULL, FALSE);
    //     $query = $this->db->get();
    //      echo $this->db->last_query();
    //     if ($query->num_rows() > 0) {
    //         $result = $query->result_array();
    //         return $result;
    //     }
    //     return FALSE;
    // }

    public function get_users_for_hierarchy($condition, $in = FALSE) {
        $this->db->select('r.*,u.*');
        $this->db->Distinct('u.*');
        $this->db->from('usermaster u');
        $this->db->join('roles r', 'r.role_id = u.role_id','left');
        $this->db->where($condition, NULL, FALSE);
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_users($condition, $in = FALSE) {
           // $this->db->select('r.*,u.*,hm.user_id');
            $this->db->select('u.*,r.*,hm.user_id');
            $this->db->Distinct('r.*');
            $this->db->from('usermaster u');
            $this->db->join('roles r', 'r.role_id = u.role_id','left');
            $this->db->join('hierarchy_mapping hm', 'hm.user_id = u.umId','inner');
            $this->db->where($condition, NULL, FALSE);
            $query = $this->db->get();
            //echo $this->db->last_query();
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            }
            return FALSE;
        }

        public function get_users_for_filter($condition, $in = FALSE) {
            // $this->db->select('r.*,u.*,hm.user_id');
             $this->db->select('u.umUserName as name ,u.umId as id');
             $this->db->Distinct('r.*');
             $this->db->from('usermaster u');
             $this->db->join('roles r', 'r.role_id = u.role_id','left');
             $this->db->join('hierarchy h', 'u.umId = h.user_id ', 'left');
             $this->db->join('hierarchy_mapping hm', 'hm.user_id = u.umId','inner');
             $this->db->where($condition, NULL, FALSE);
           // $this->db->where('umId in (" . $condition . "));
             $query = $this->db->get();
            // echo $this->db->last_query();
             if ($query->num_rows() > 0) {
                 $result = $query->result_array();
                 return $result;
             }
             return FALSE;
         }

    public function get_role_privileges($role_id) {
        $result = $this->simple_get('default_role_privileges', array('action_id'), array('role_id' => $role_id));
        if ($result) {
            $avoid_actions = array();
            foreach ($result as $key => $value) {
                array_push($avoid_actions, $value['action_id']);
            }
        } else {
            $avoid_actions = array(0);
        }
        return $avoid_actions;
    }

    public function get_user_privileges($user_id) {
        $result = $this->simple_get('user_privileges', array('action_id'), array('user_id' => $user_id));
        if ($result) {
            $avoid_actions = array();
            foreach ($result as $key => $value) {
                array_push($avoid_actions, $value['action_id']);
            }
        } else {
            $avoid_actions = array(0);
        }
        return $avoid_actions;
    }

    public function get_actions($add_actions = false, $avoid_actions = false) {

        $this->db->select('*, action_id as id, if(action_name ="", concat(class_name,"/",method_name),action_name ) as name, class_name as group_name ', FALSE);
        $this->db->from('actions a');
        if ($avoid_actions !== FALSE) {
            $this->db->where_not_in('a.action_id', $avoid_actions);
        }
        if ($add_actions !== FALSE) {
            $this->db->where_in('a.action_id', $add_actions);
        }
        $this->db->where('is_active', 1);
        $this->db->order_by('class_name');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function insert_default_role_privileges_to_user($user_id, $role_id) {
        $this->delete('user_privileges', array('user_id' => $user_id));
        $access_level_id = $this->simple_get('roles', array('access_level_id'), array('role_id' => $role_id));
        $role_privileges = $this->simple_get('default_role_privileges', array('action_id'), array('role_id' => $role_id));
        if ($role_privileges) {
            foreach ($role_privileges as $key => $value) {
                $table_data[$key]['user_id'] = $user_id;
                $table_data[$key]['action_id'] = $value['action_id'];
                $table_data[$key]['access_level_id'] = $access_level_id[0]['access_level_id'];
            }
            $this->insert_batch('user_privileges', $table_data);
        }
    }

    public function is_privileged() {
        $condition['method_name'] = $this->router->method;
        $condition['class_name'] = $this->router->class;
        $user_data = $this->session->userdata('userdata');
        if ($user_data === FALSE) {
            $condition['role_id'] = 1;
            $this->db->select('*');
            $this->db->from('default_role_privileges drp');
            $this->db->join('actions a', 'a.action_id = drp.action_id');
            $this->db->where($condition);
        } else {
            $condition['user_id'] = $user_data['umId'];
            $this->db->select('*');
            $this->db->from('user_privileges up');
            $this->db->join('actions a', 'a.action_id = up.action_id');
            $this->db->where($condition);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function set_default_role_privileges_to_users() {
        $query = "TRUNCATE user_privileges";
        $this->db->query($query);
        $query = "INSERT INTO user_privileges
                    SELECT NULL , umId, d.action_id, r.access_level_id
                    FROM usermaster u
                    JOIN roles r ON r.role_id = u.role_id
                    JOIN default_role_privileges d ON r.role_id = d.role_id";
        $this->db->query($query);
    }

    public function get_parent_hierarchy($hierarchy_id, &$found = array()) {
        $this->db->select('hierarchy_id, parent_hierarchy_id');
        $this->db->from('hierarchy h');
        $this->db->where('h.hierarchy_id', $hierarchy_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            array_push($found, $result['parent_hierarchy_id']);
            $this->get_parent_hierarchy($result['parent_hierarchy_id'], $found);
        }
        return $found;
    }

    public function get_child_hierarchy($hierarchy_id, &$found = array()) {
        $this->db->select('hierarchy_id, parent_hierarchy_id');
        $this->db->from('hierarchy h');
        $this->db->where('h.parent_hierarchy_id', $hierarchy_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $key => $value) {
                array_push($found, $value['hierarchy_id']);
                $this->get_parent_hierarchy($value['hierarchy_id'], $found);
            }
        }
        return $found;
    }

    public function get_hierarchy_staffs($in = FALSE, $not_in = FALSE) {
        // SELECT * FROM  `hierarchy` RIGHT JOIN usermaster ON user_id = umId

        $this->db->select('umId, concat(u.umFirstName," ",u.umLastName) as user_name,r.role_name ', FALSE);
        $this->db->from('hierarchy h');
        $this->db->join('usermaster u', 'u.umId = h.user_id ', 'right');
        $this->db->join('roles r', 'u.role_id = r.role_id ');

        if ($in !== FALSE) {
            $comma_seperated = implode("','", $in);
            $this->db->where("hierarchy_id = null or hierarchy_id in ('$comma_seperated')");
        }
        if ($not_in !== FALSE) {
            $this->db->where_not_in('hierarchy_id', $not_in);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_subordinate_users($id) {
        $this->db->select('group_concat(distinct hm.user_id) as user_id');
        $this->db->from('hierarchy_mapping hm');
        $this->db->where('hm.parent_user_id', $id);
        $query = $this->db->get();

    //    echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    public function get_subordinateusers($id) {
        $this->db->select('group_concat(distinct(hm.user_id)) as user_id');
        $this->db->from('hierarchy_mapping hm');
        $this->db->where('hm.parent_user_id', $id);
        $query = $this->db->get();

       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    public function user_has_privilege($class, $method) {
        $user_data = $this->session->userdata('userdata');
        $user_id = $user_data['umId'];
        $condition = array('a.class_name' => $class, 'a.method_name' => $method, 'u.user_id' => $user_id);
        $this->db->select('count(*) c', FALSE);
        $this->db->from('user_privileges u');
        $this->db->join('actions a', 'a.action_id = u.action_id');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['c'];
        }
        return FALSE;
    }

}
