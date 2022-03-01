<?php

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */

/**
 * @property privilegemodel $privilegemodel Description
 * 
 */
class Privilege extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('privilegemodel');
    }

    public function insert_actions() {
        $dir = APPPATH . '/controllers/';
        $files = scandir($dir);
        $controller_files = array_filter($files, function($filename) {
            return (substr(strrchr($filename, '.'), 1) == 'php') ? true : false;
        });
        $avoid = array('call.php', 'campaign.php', 'contact.php', 'deal.php', 'email.php',
            'error.php', 'lead.php', 'meeting.php', 'stockManager.php');
        foreach ($avoid as $key => $value) {
            if (($k = array_search($value, $controller_files)) !== false) {
                unset($controller_files[$k]);
            }
        }
        $actions = array();
        foreach ($controller_files as $filename) {
            require_once('./application/controllers/' . $filename);
            $classname = ucfirst(substr($filename, 0, strrpos($filename, '.')));
            $controller = new $classname();
            $methods = get_class_methods($controller);
            foreach ($methods as $method) {
                $refl = new ReflectionMethod($classname, $method);
                if (!$refl->isConstructor() && !$refl->isPrivate() && !$refl->isProtected() && $refl->isPublic() && !$refl->isStatic()) {
                    $this->privilegemodel->insert_if_not_exists('actions', array(
                        'file_name' => $filename,
                        'class_name' => $classname,
                        'method_name' => $method,
                        'is_active' => 1));
                }
            }
        }
    }

    public function list_actions() {
        $data['table_data'] = $this->privilegemodel->simple_get('actions', array('action_id', 'file_name', 'class_name', 'method_name', 'action_name', 'description'), array('is_active' => 1));
        $this->load->view('privilege/list_actions', $data);
    }

    public function add_action() {
        $edit_mode = FALSE;
        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data = $this->save_action($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->load->view('privilege/form_action', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('privilege/form_action', $data);
        }
    }

    public function edit_action($id) {
        $edit_mode = TRUE;
        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data = $this->save_action($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $this->load->view('privilege/form_action', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $action_details = $this->privilegemodel->simple_get('actions', array('action_id', 'file_name', 'class_name', 'method_name', 'action_name', 'description'), array('action_id' => $id));
            $data['form_data'] = $action_details[0];
            $this->load->view('privilege/form_action', $data);
        }
    }

    public function delete_action($id) {
        $form_data['is_active'] = 0;
        $result = $this->privilegemodel->edit('actions', $form_data, array('action_id' => $id));
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = 'Deleted successfully';
            $data['hash'] = 'privilege/list_actions';
        } else {
            $data['status'] = 'failure';
            $data['form_data'] = $form_data;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function list_roles() {
        $data['table_data'] = $this->privilegemodel->get_roles(array('r.is_active' => 1));
        $this->load->view('privilege/list_roles', $data);
    }

    public function add_role() {

        $edit_mode = FALSE;
        $form_data = $this->input->post();

        $access_levels = $this->privilegemodel->simple_get('access_levels', array('access_level_id as id', 'access_level_name as name'));

        if ($form_data !== FALSE) {
            $data = $this->save_role($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['access_levels'] = generate_options($access_levels, 0, 0, $form_data['access_level_id']);
                $this->load->view('privilege/form_role', $data);
            }
        } else {
            $data['access_levels'] = generate_options($access_levels);
            $data['edit_mode'] = $edit_mode;
            $this->load->view('privilege/form_role', $data);
        }
    }

    public function edit_role($id) {
        $edit_mode = TRUE;
        $form_data = $this->input->post();
        $access_levels = $this->privilegemodel->simple_get('access_levels', array('access_level_id as id', 'access_level_name as name'));
        if ($form_data !== FALSE) {
            $data = $this->save_role($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['access_levels'] = generate_options($access_levels, 0, 0, $form_data['access_level_id']);
                $this->load->view('privilege/form_role', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $role_details = $this->privilegemodel->get_roles(array('role_id' => $id));
            $data['form_data'] = $role_details[0];
            $data['access_levels'] = generate_options($access_levels, 0, 0, $role_details[0]['access_level_id']);
            $this->load->view('privilege/form_role', $data);
        }
    }

    public function delete_role($id) {
        $form_data['is_active'] = 0;
        if ($id == 1 || $id == 2) {
            $data['status'] = 'success';
            $data['message'] = 'Can\'t delete default roles';
            $data['hash'] = 'privilege/list_roles';
        } else {
            $result = $this->privilegemodel->edit('roles', $form_data, array('role_id' => $id));
            if ($result) {
                $data['status'] = 'success';
                $data['message'] = 'Deleted successfully';
                $data['hash'] = 'privilege/list_roles';
            } else {
                $data['status'] = 'failure';
                $data['form_data'] = $form_data;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function edit_default_role_privilege($role_id) {
        $roles_data = $this->privilegemodel->simple_get('roles', '*', array('role_id' => $role_id));
        $privileges_added = $this->privilegemodel->get_role_privileges($role_id);
        $actions_added = $this->privilegemodel->get_actions($privileges_added);
        $actions_not_added = $this->privilegemodel->get_actions(FALSE, $privileges_added);

        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data['form_data'] = $form_data;
            $this->privilegemodel->delete('default_role_privileges', array('role_id' => $form_data['role_id']));
            $i = 0;
            $table_data = array();
            $added_actions_array = array();
            if ($form_data['added_actions'] !== "") {
                $substr = substr($form_data['added_actions'], 0, -1);
                $added_actions_array = explode(',', $substr);
            }
            foreach ($added_actions_array as $value) {
                $table_data[$i]['role_id'] = $form_data['role_id'];
                $table_data[$i]['action_id'] = $value;
                $i++;
            }
            $this->privilegemodel->insert_batch('default_role_privileges', $table_data);
            $privileges_added = $this->privilegemodel->get_role_privileges($role_id);
            $actions_added = $this->privilegemodel->get_actions($privileges_added);
            $actions_not_added = $this->privilegemodel->get_actions(FALSE, $privileges_added);
        } else {
            $added_actions = '';
            if ($actions_added) {
                foreach ($actions_added as $key => $value) {
                    $added_actions .= $value['id'] . ',';
                }
                $added_actions = substr($added_actions, 0, -1);
            }
            $data['form_data'] = $roles_data[0];
            $data['form_data']['added_actions'] = $added_actions;
        }

        $data['actions_added'] = generate_options($actions_added);
        $data['actions_not_added'] = generate_options($actions_not_added);

        $this->load->view('privilege/edit_role_privilege', $data);
    }

    public function list_users() {
        $user_data = $this->session->userdata('userdata');
        $data['table_data'] = $this->privilegemodel->get_users(array('umIsActive' => 1,'parent_user_id' =>$user_data['umId']));
        $this->load->view('privilege/list_users', $data);
    }

    public function edit_user_privileges($user_id) {
        $user_data = $this->privilegemodel->simple_get('usermaster', '*', array('umId' => $user_id));
        $roles_data = $this->privilegemodel->simple_get('roles', '*', array('role_id' => $user_data[0]['role_id']));
        $privileges_added = $this->privilegemodel->get_user_privileges($user_id);
        $actions_added = $this->privilegemodel->get_actions($privileges_added);
        $actions_not_added = $this->privilegemodel->get_actions(FALSE, $privileges_added);

        $form_data = $this->input->post();
        if ($form_data !== FALSE) {
            $data['form_data'] = $form_data;
            $this->privilegemodel->delete('user_privileges', array('user_id' => $user_id));
            $i = 0;
            $table_data = array();
            $added_actions_array = array();
            if ($form_data['added_actions'] !== "") {
                $substr = substr($form_data['added_actions'], 0, -1);
                $added_actions_array = explode(',', $substr);
            }
            foreach ($added_actions_array as $value) {
                $table_data[$i]['user_id'] = $user_id;
                $table_data[$i]['access_level_id'] = $roles_data[0]['access_level_id'];
                $table_data[$i]['action_id'] = $value;
                $i++;
            }
            $this->privilegemodel->insert_batch('user_privileges', $table_data);
            $privileges_added = $this->privilegemodel->get_user_privileges($user_id);
            $actions_added = $this->privilegemodel->get_actions($privileges_added);
            $actions_not_added = $this->privilegemodel->get_actions(FALSE, $privileges_added);
        } else {
            $added_actions = '';
            if ($actions_added) {
                foreach ($actions_added as $key => $value) {
                    $added_actions .= $value['id'] . ',';
                }
                $added_actions = substr($added_actions, 0, -1);
            }
            $data['form_data'] = $user_data[0];
            $data['form_data']['added_actions'] = $added_actions;
        }

        $data['actions_added'] = generate_options($actions_added);
        $data['actions_not_added'] = generate_options($actions_not_added);

        $this->load->view('privilege/edit_user_privilege', $data);
    }

    public function edit_user_role($user_id) {
        $edit_mode = TRUE;
        $form_data = $this->input->post();
        $roles = $this->privilegemodel->simple_get('roles', array('role_id as id', 'role_name as name'));
        if ($form_data !== FALSE) {
            $data = $this->save_user($form_data);
            if ($data['status'] === 'success') {
                $this->privilegemodel->insert_default_role_privileges_to_user($user_id, $form_data['role_id']);
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['roles'] = generate_options($roles, 0, 0, $form_data['role_id']);
                $this->load->view('privilege/form_user', $data);
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $user_details = $this->privilegemodel->get_users(array('umId' => $user_id));
            $data['form_data'] = $user_details[0];
            $data['role'] = generate_options($roles, 0, 0, $user_details[0]['role_id']);
            $this->load->view('privilege/form_user', $data);
        }
    }

    public function test() {
        $this->privilegemodel->set_default_role_privileges_to_users();
    }

    public function get_staffs() {
        $parent_hierarchy_id = $this->input->post('parent_hierarchy_id');
        $hierarchy_id = $this->input->post('hierarchy_id');
        $mode = $this->input->post('mode');
        $user_data = array();
        $parent_hierarchy = $this->privilegemodel->get_parent_hierarchy($hierarchy_id);
        $users_to_avoid = FALSE;
        if ($parent_hierarchy) {
            $users_to_avoid = $this->privilegemodel->get_from_list('hierarchy', 'user_id', 'hierarchy_id', $parent_hierarchy);
        }
        $user_ids = '';
        if ($users_to_avoid) {
            foreach ($users_to_avoid as $key => $value) {
                $user_ids .= "'" . $value['user_id'] . "',";
            }
        }
        $child_hierarchy = $this->privilegemodel->get_child_hierarchy($hierarchy_id);
        if ($child_hierarchy) {
            $users_to_avoid = $this->privilegemodel->get_from_list('hierarchy', 'user_id', 'hierarchy_id', $child_hierarchy);
        }
        if ($users_to_avoid) {
            foreach ($users_to_avoid as $key => $value) {
                $user_ids .= "'" . $value['user_id'] . "',";
            }
        }
        $self = $this->privilegemodel->simple_get('hierarchy', 'user_id', array('hierarchy_id' => $hierarchy_id));
        $user_ids .= "'" . $self[0]['user_id'] . "'";

        if ($mode == 'add-staff') {
            $data['type'] = "checkbox";
        } else {
            $data['type'] = "radio";
        }
        $staffs = $this->privilegemodel->get_users_for_hierarchy("umId not in  ($user_ids) AND umIsActive= 1");
        $data['table_data'] = $staffs;
        $data['parent_hierarchy_id'] = $parent_hierarchy_id;
        $data['hierarchy_id'] = $hierarchy_id;
        $data['mode'] = $mode;
        $this->load->view('privilege/form_select_staff', $data);
    }

    public function add_staff() {
        $hierarchy_id = $this->input->post('hierarchy_id');
        $parent_hierarchy_id = $this->input->post('parent_hierarchy_id');
        $selected_users = $this->input->post('selected_users');
        $selected_users = substr($selected_users, 0, -1);
        $split = explode(',', $selected_users);
        $table_data = array();
        foreach ($split as $key => $value) {
            $table_data[$key]['user_id'] = $value;
            $table_data[$key]['parent_hierarchy_id'] = $hierarchy_id;
        }
        $this->privilegemodel->insert_batch('hierarchy', $table_data);
        $this->db->query('CALL setHierarchyMapping()');
        $data = array();
        $this->load->view('privilege/hierarchy', $data);
    }

    public function change_staff() {
        $hierarchy_id = $this->input->post('hierarchy_id');
        $parent_hierarchy_id = $this->input->post('parent_hierarchy_id');
        $selected_users = $this->input->post('selected_users');
        $selected_users = substr($selected_users, 0, -1);
        $this->privilegemodel->edit('hierarchy', array('user_id' => $selected_users), array('hierarchy_id' => $hierarchy_id));
        $data = array();
        $this->load->view('privilege/hierarchy', $data);
    }

    public function view_hierarchy() {
        $data = array();
        $this->load->view('privilege/hierarchy', $data);
    }

    public function remove_staff() {
        $form_data = $this->input->post();
        $parent_hierarchy_id = $form_data['parent_hierarchy_id'];
        unset($form_data['parent_hierarchy_id']);
        $this->privilegemodel->delete('hierarchy', $form_data);
        $this->db->query('CALL setHierarchyMapping()');
        $data = array();
        $this->load->view('privilege/hierarchy', $data);
    }

    private function save_user($form_data) {
        $edit_mode = FALSE;
        if (isset($form_data['umId']) && $form_data['umId'] !== '') { // edit
            $edit_mode = TRUE;
        }
        $this->form_validation->set_rules('role_id', 'Role Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['edit_mode'] = $edit_mode;
            $data['error'] = $this->form_validation->error_array();
            $data['form_data'] = $form_data;
            $data['status'] = 'failure';
        } else {
            if ($edit_mode) {
                $id = $form_data['umId'];
                unset($form_data['umId']);
                $result = $this->privilegemodel->edit('usermaster', $form_data, array('umId' => $id));
                if ($result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'privilege/list_users';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $form_data;
                }
            } else {
                $result = $this->privilegemodel->insert('usermaster', $form_data);
                if ($result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'privilege/list_users';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $form_data;
                }
            }
        }
        return $data;
    }

    private function save_role($form_data) {
        $edit_mode = FALSE;
        if (isset($form_data['role_id']) && $form_data['role_id'] !== '') { // edit
            $edit_mode = TRUE;
            $this->form_validation->set_rules('role_name', 'Role Name', 'required|max_length[100]|exist_among[roles.role_name.role_id.' . $form_data['role_id'] . ']');
        } else {
            $this->form_validation->set_rules('role_name', 'Role Name', 'required|max_length[100]|exists[roles.role_name]');
        }
        $this->form_validation->set_rules('role_description', 'Description', 'max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            $data['edit_mode'] = $edit_mode;
            $data['error'] = $this->form_validation->error_array();
            $data['form_data'] = $form_data;
            $data['status'] = 'failure';
        } else {
            if ($edit_mode) {
                $id = $form_data['role_id'];
                unset($form_data['role_id']);
                $result = $this->privilegemodel->edit('roles', $form_data, array('role_id' => $id));
                if ($result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'privilege/list_roles';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $form_data;
                }
            } else {
                $form_data['is_active'] = 1;
                $result = $this->privilegemodel->insert('roles', $form_data);
                if ($result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'privilege/list_roles';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $form_data;
                }
            }
        }
        return $data;
    }

    private function save_action($form_data) {
        $edit_mode = FALSE;
        if (isset($form_data['action_id']) && $form_data['action_id'] !== '') { // edit
            $edit_mode = TRUE;
            $this->form_validation->set_rules('action_name', 'Action Name', 'required|max_length[100]|exist_among[actions.action_name.action_id.' . $form_data['action_id'] . ']');
        } else {
            $this->form_validation->set_rules('action_name', 'Action Name', 'required|max_length[100]|exists[actions.action_name]');
            $this->form_validation->set_rules('method_name', 'Method Name', 'required|max_length[100]');
            $this->form_validation->set_rules('file_name', 'File Name', 'required|max_length[100]');
            $this->form_validation->set_rules('class_name', 'Class Name', 'required|max_length[100]');
        }
        $this->form_validation->set_rules('description', 'Description', 'max_length[500]');

        if ($this->form_validation->run() == FALSE) {
            $data['edit_mode'] = $edit_mode;
            $data['error'] = $this->form_validation->error_array();
            $data['form_data'] = $form_data;
            $data['status'] = 'failure';
        } else {
            if ($edit_mode) {
                $id = $form_data['action_id'];
                unset($form_data['action_id']);
                $result = $this->privilegemodel->edit('actions', $form_data, array('action_id' => $id));
                if ($result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'privilege/list_actions';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $form_data;
                }
            } else {
                $form_data['is_active'] = 1;
                $result = $this->privilegemodel->insert('actions', $form_data);
                if ($result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'privilege/list_actions';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $form_data;
                }
            }
        }
        return $data;
    }

}
