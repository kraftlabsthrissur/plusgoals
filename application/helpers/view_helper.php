<?php

/**
 * @author ajith
 * @date 17 Feb, 2015
 */
if (!function_exists('load_menu')) {

    function load_menu() {
        echo create_menu(0);
    }

}

if (!function_exists('create_menu')) {

    function create_menu($parent_id = 0) {

        $CI = & get_instance();
        $user_data = $CI->session->userdata('userdata');
        $CI->db->select('menu_item_id,item_name,m.action_id,parent_menu_item_id,icon_class,user_privilege_id,LOWER(class_name) class_name,method_name ');
        $CI->db->from('menu_items m');
        $CI->db->join('actions a', 'a.action_id = m.action_id', 'left');
        $CI->db->join('user_privileges u', 'u.action_id = m.action_id and u.user_id = ' . $user_data['umId'], 'left');
        $CI->db->where('parent_menu_item_id', $parent_id);
        $CI->db->order_by('sort_order');
        $query = $CI->db->get();
        
        $hash = '#';
        $menu = '';
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $ul = '<ul class="' . ($parent_id ? 'treeview-menu' : 'sidebar-menu') . '" >';
            $li = '';
            foreach ($result as $key => $value) {
                if ($value['user_privilege_id'] !== NULL || $parent_id == 0) {
                    $submenu = create_menu($value['menu_item_id']);
                    if (!($parent_id == 0 && $submenu == '' && $value['action_id'] == 0 )) {
                        $li .= '<li class="' . ($submenu !== '' ? 'treeview' : '') . '">';
                        $li .= '<a href="';
                        $li .= $value['class_name'] !== null ? base_url() . $hash . $value['class_name'] . '/' . $value['method_name'] : $hash;
                        $li .= '">';
                        $li .= '<i class="fa ' . $value['icon_class'] . '"></i>';
                        $li .= '<span>' . $value['item_name'] . '</span>';
                        $li .= ($submenu !== '') ? '<i class="fa fa-angle-left pull-right"></i>' : '';
                        $li .= '</a>';
                        $li .= $submenu;
                        $li .= '</li>';
                    }
                }
            }
            if ($li !== '') {
                $menu = $ul . $li . '</ul>';
            }
        }
        return $menu;
    }

}
if (!function_exists('show_hierarchy')) {

    function show_hierarchy() {
        $CI = & get_instance();
        $user_data = $CI->session->userdata('userdata');
        $end_node_count = 0;
        echo hierarchy(0,$end_node_count);
    }

}

if (!function_exists('hierarchy')) {

    function hierarchy($parent_id,&$end_node_count) {
       
        $CI = & get_instance();
        $user_data = $CI->session->userdata('userdata');
        $CI->db->select('hierarchy_id, user_id,parent_hierarchy_id, concat(u.umFirstName," ",u.umLastName) as user_name,r.role_name', FALSE);
        $CI->db->from('hierarchy h');
        $CI->db->join('usermaster u', 'u.umId = h.user_id', 'left');
        $CI->db->join('roles r', 'u.role_id = r.role_id', 'left');
        $CI->db->where('parent_hierarchy_id', $parent_id);
        $CI->db->order_by('sort_order');
        $query = $CI->db->get();
        // echo $CI->db->last_query();

        $hierarchy = '';
        $rows = $query->num_rows();
        if ($rows > 0) {
            $result = $query->result_array();
            $h1 = '';
            $width = ceil(100 / $query->num_rows()) - 1;
            $add_button = '<a class="add">Add</a>';
            $remove_button = '<a class="remove">Remove</a>';
            $change_button = '<a class="change">Change</a>';
            foreach ($result as $key => $value) {
                $sub = hierarchy($value['hierarchy_id'],$end_node_count);
                $h1 .= '<span class="hierarchy"  style="width:auto; " >';
                $h1 .= '<div class="line" id="line-' . $value['hierarchy_id'] . '"></div>';
                $h1 .= '<div class="line1" ></div>';
                $h1 .= '<div class="line2" ></div>';
               
                $h1 .= '<div class="hierarchy-box" id="box-' . $value['hierarchy_id'] . '">';
                
                $h1 .= '<div >';
                $h1 .= '<div >';
                $h1 .= '<img src="'.base_url().'/assets/img/avatar3.png" class="img-circle" alt="User Image">';
                $h1 .= '<p>' . $value['user_name'] . '</p>';
                $h1 .= '<p>' . $value['role_name'] . '</p>';
                $h1 .= '<div class="actions">' . $add_button;
                $h1 .= ($sub === '') ? $remove_button : $change_button;
                $h1 .= '<input type="hidden" class="hierarchy_id" value="' . $value['hierarchy_id'] . '">';
                $h1 .= '</div>';
                $h1 .= ($sub === '') ?'': '<span class="circle visible" > - </span>';
                $h1 .= '</div>';
                 
                $h1 .= '</div>';
                $h1 .= '</div>';
                $h1 .= $sub;
                $h1 .= '</span>';
            }
            $hierarchy .= $h1;
        }else{
            $end_node_count += 1;
        }
        return $hierarchy;
    }

}         

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}