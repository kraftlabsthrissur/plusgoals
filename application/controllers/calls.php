<?php

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */

/**
 * @property privilegemodel $privilegemodel Description
 * @property callmodel $callmodel Description
 * 
 */
class Calls extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('routemodel');
        $this->load->model('list_model');
        $this->load->model('privilegemodel');
        $this->load->model('expensemodel');
        $this->load->model('callmodel');
    }

    public function list_calls() {
        $data = array();
        $form_data = $this->input->post();
        $users = $this->callmodel->get_users();
        $form_data['c_from_date'] = isset($form_data['c_from_date']) ? $form_data['c_from_date'] : date('Y-m-d', strtotime('first day of this month'));
        $form_data['c_to_date'] = isset($form_data['c_to_date']) ? $form_data['c_to_date'] : date('Y-m-d', strtotime('last day of this month'));
        $form_data['n_from_date'] = isset($form_data['n_from_date']) ? $form_data['n_from_date'] : date('Y-m-d', strtotime('first day of this month'));
        $form_data['n_to_date'] = isset($form_data['n_to_date']) ? $form_data['n_to_date'] : date('Y-m-d', strtotime('last day of this month'));
        $form_data['c_user_id'] = isset($form_data['c_user_id']) ? $form_data['c_user_id'] : "";
        $form_data['n_user_id'] = isset($form_data['n_user_id']) ? $form_data['n_user_id'] : "";
        $this->session->set_userdata('calls', $form_data);
        $data['c_from_date'] = $form_data['c_from_date'];
        $data['c_to_date'] = $form_data['c_to_date'];
        $data['n_from_date'] = $form_data['n_from_date'];
        $data['n_to_date'] = $form_data['n_to_date'];
        $data['c_users'] = generate_options($users, 0, 0, $form_data['c_user_id']);
        $data['n_users'] = generate_options($users, 0, 0, $form_data['n_user_id']);
        $this->load->view('calls/list_calls', $data);
    }

    public function json_calls() {
        $user_data = $this->session->userdata('userdata');
        $params = $_REQUEST;
        $search_columns = array(
            'route_name',
            'umUserName',
            'smStoreName',
            'status',
            'u.umUserName'
        );
        $sort_columns = array(
            'route_name',
            'umUserName',
            'date',
            'smStoreName',
            'status'
        );
        $search = ' 1 = 1 ';
        if ($params['search']['value'] != '') {
            $search .= ' AND (';
            foreach ($search_columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }

        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $search .= " AND user_id in ( $subordinate_users )";
        }
        $form_data = $this->session->userdata('calls');
        $search .= " AND  c.date BETWEEN '" . $form_data['c_from_date'] . "' AND '" . $form_data['c_to_date'] . "'";
        if ($form_data['c_user_id'] != "") {
            $search .= " AND  user_id = '" . $form_data['c_user_id'] . "' ";
        }
        $data = $this->callmodel->get_calls_json($params['start'], $params['length'], $sort_columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
//echo $this->db->last_query();
        if ($data['result']) {
            $action_tag = '<a href="#calls/add_calls/%s">Edit</a> &nbsp;&nbsp; '
                    . '<a  data-call-id="%s" class="view_call" >View</a> &nbsp;&nbsp; '
                    . '<a href="#calls/delete_call/%s" onClick="return confirm(\'Are you want to delete this call?\');">Delete</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['action'] = sprintf($action_tag, $row['id'], $row['id'], $row['id']);
                $data['result'][$key]['date'] = date('Y-m-d', strtotime($row['date']));
            }
        }

        $results = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => $data['num_rows'],
            "recordsFiltered" => $data['num_rows'],
            "data" => $data['result']
        );
        echo json_encode($results);
    }

    public function json_new_calls() {
        $user_data = $this->session->userdata('userdata');
        $params = $_REQUEST;
        $search_columns = array(
            'umUserName',
            'creation_date',
            'customer_name',
            'phone',
            'address',
            'customer_details',
            'customer_info',
        );
        $sort_columns = array(
            'umUserName',
            'creation_date',
            'customer_name',
            'phone',
            'address',
            'customer_details',
            'customer_info',
        );
        $search = ' 1 = 1 ';
        if ($params['search']['value'] != '') {
            $search .= ' AND (';
            foreach ($search_columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }

        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $search .= " AND user_id in ( $subordinate_users )";
        }
        $form_data = $this->session->userdata('calls');
        $search .= " AND  creation_date BETWEEN '" . $form_data['n_from_date'] . "' AND '" . $form_data['n_to_date'] . "'";
        if ($form_data['n_user_id'] != "") {
            $search .= " AND  user_id = '" . $form_data['n_user_id'] . "' ";
        }

        $data = $this->callmodel->get_new_calls_json($params['start'], $params['length'], $sort_columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
//echo $this->db->last_query();
        if ($data['result']) {
            $action_tag = '<a href="#calls/add_new_customer_calls/%s">Edit</a> &nbsp;&nbsp; '
                    . '<a href="#calls/delete_new_customer_calls/%s" onClick="return confirm(\'Are you want to delete this call?\');">Delete</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['action'] = sprintf($action_tag, $row['id'], $row['id'], $row['id']);
                $data['result'][$key]['creation_date'] = date('Y-m-d', strtotime($row['creation_date']));
            }
        }

        $results = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => $data['num_rows'],
            "recordsFiltered" => $data['num_rows'],
            "data" => $data['result']
        );
        echo json_encode($results);
    }

    public function add_calls($id = null) {
        if ($id == null) {
            $edit_mode = FALSE;
        } else {
            $edit_mode = TRUE;
            $call_id['id'] = $id;
            $sample_id['call_id'] = $id;
            $call = $this->callmodel->simple_get('calls', array('*'), $call_id);
            $sample = $this->callmodel->simple_get('call_details_sample', array('*'), $sample_id);
            $prescribs = $this->callmodel->simple_get('call_details_prescribs', array('*'), $sample_id);
            $data['call'] = $call;

            $data['sample'] = $sample;
            $data['prescribs'] = $prescribs;
        }

        $form_data = $this->input->post();

        $user_data = $this->session->userdata('userdata');
        $customers = $this->callmodel->simple_get('storemaster', array('smid as id', 'smStoreName as name'));

        if ($user_data['umIsHOUser'] == 1) {
            $where = "1=1";
            $routes = $this->routemodel->simple_get('routes', array('route_id as id', 'route_name as name'), $where);
        } else {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $where = "created_by in (" . $subordinate_users . ")";
            $routes = $this->routemodel->simple_get('routes', array('route_id as id', 'route_name as name'), $where);
        }
        if ($form_data !== FALSE) {
            $form_data['user_id'] = $user_data['umId'];
            $form_data['edit_mode'] = $edit_mode;
            // print_r($form_data);
            $data = $this->save_call($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['routes'] = generate_options($routes, 0, 0, $form_data['route_id']);
                $data['customers'] = generate_options($customers, 0, 0, $form_data['route_id']);
                $this->load->view('calls/form_calls', $data);
            }
        } else {
            if ($edit_mode == TRUE) {
                $data['routes'] = generate_options($routes, 0, 0, $data['call'][0]['route_id']);
                $data['customers'] = generate_options($this->callmodel->select_customers($data['call'][0]['route_id']), 0, 0, $data['call'][0]['customer_id']);
            } else {
                $data['routes'] = generate_options($routes);
                $data['customers'] = generate_options($customers);
            }

            $data['user_data'] = $user_data;
            $data['edit_mode'] = $edit_mode;

            $this->load->view('calls/form_calls', $data);
        }
    }

    public function view_calls() {

        $calls_id['call_id'] = $_POST['id'];
        $call_id['id'] = $_POST['id'];
        $user_data = $this->session->userdata('userdata');
        $id['user_id'] = $user_data['umId'];
        $data['role'] = $this->callmodel->simple_get('roles', array('role_id', 'role_name'), 'role_id= ' . $user_data['role_id'] . '');
        $data['calls'] = $this->callmodel->get_calls_by_id($call_id);
        $data['prescribs'] = $this->callmodel->simple_get('call_details_prescribs', array('*'), $calls_id);
        $data['sample'] = $this->callmodel->simple_get('call_details_sample', array('*'), $calls_id);
        // print_r($data);die();
        $this->load->view('calls/view_calls', $data);
    }

    public function delete_call($id) {
        $this->callmodel->delete('calls', array('id' => $id));
        $this->callmodel->delete('call_details_sample', array('call_id' => $id));
        $this->callmodel->delete('call_details_prescribs', array('call_id' => $id));
        $user_data = $this->session->userdata('userdata');
        $this->list_calls();
    }

    public function customer_type() {
        $customer_id['smid'] = $_POST['id'];
        $result = $this->callmodel->simple_get('storemaster', array('customer_group'), $customer_id);
        print_r($result[0]['customer_group']);
    }

    public function save_call($form_data) {
        $user_data = $this->session->userdata('userdata');
        if ($form_data['edit_mode'] == 1) {


            $calls['route_id'] = $form_data['route_id'];
            $calls['user_id'] = $user_data['umId'];
            $calls['customer_id'] = $form_data['customer_id'];
            // $calls['date']=$form_data['date'];

            $calls['order_booked'] = $form_data['order_booked'];

            $calls['information_conveyed'] = $form_data['information_conveyed'];

            $calls['collection'] = $form_data['collection'];
            $calls['created_date'] = date('Y-m-d H:m:s');
            $calls_id['id'] = $form_data['id'];


            if (isset($form_data['status'])) {
                $calls['status'] = "visited";
                $calls['date'] = $form_data['date'];
            } else {
                $calls['status'] = "Not_visited";
                $calls['date'] = 00 - 00 - 00;
            }

            $result = $this->callmodel->update('calls', $calls, $calls_id);

            $call_id['call_id'] = $form_data['id'];
        } else {
            $calls['route_id'] = $form_data['route_id'];
            $calls['user_id'] = $user_data['umId'];
            $calls['customer_id'] = $form_data['customer_id'];
            //$calls['date']=$form_data['date'];

            $calls['order_booked'] = $form_data['order_booked'];

            $calls['information_conveyed'] = $form_data['information_conveyed'];

            $calls['collection'] = $form_data['collection'];
            $calls['created_date'] = date('Y-m-d H:m:s');

            if (isset($form_data['status'])) {
                $calls['status'] = "visited";
                $calls['date'] = $form_data['date'];
            } else {
                $calls['status'] = "Not_visited";
                $calls['date'] = 00 - 00 - 00;
            }
            $result = $this->callmodel->insert('calls', $calls);

            $call_id['call_id'] = $this->db->insert_id();
        }



        $data['status'] = 'success';
        $data['message'] = 'Saved successfully';
        $data['hash'] = 'calls/list_calls';


        return $data;
    }

    public function select_customer() {
        $id = $this->callmodel->select_customers($_POST['id']);
        $customers = generate_options($id);
        echo $customers;
    }

    public function add_new_customer_calls($id = null) {
        if ($id == null) {
            $edit_mode = FALSE;
        } else {
            $edit_mode = TRUE;
            $new_call_id['id'] = $id;
            $data['new_customer'] = $this->callmodel->simple_get('new_customer_call', array('*'), $new_call_id);
        }
        $form_data = $this->input->post();

        $user_data = $this->session->userdata('userdata');
        if ($form_data != FALSE) {
            $form_data['user_id'] = $user_data['umId'];
            $form_data['edit_mode'] = $edit_mode;
            $data = $this->save_new_customer_calls($form_data);

            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {

                $this->load->view('calls/add_new_customer_form', $data);
            }
        } else {

            $data['user_id'] = $user_data['umId'];
            $data['edit_mode'] = $edit_mode;
            //print_r($data);die();
            $this->load->view('calls/add_new_customer_form', $data);
        }
    }

    public function save_new_customer_calls($data) {

        if ($data['edit_mode'] == 1) {
            $call_id['id'] = $data['id'];
            $data['modified_date'] = date('Y-m-d H:i:s');
            unset($data['edit_mode']);
            $result = $this->callmodel->update('new_customer_call', $data, $call_id);
        } else {
            unset($data['edit_mode']);
            unset($data['id']);
            $data['creation_date'] = date('Y-m-d');
            $result = $this->callmodel->insert('new_customer_call', $data);
        }
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = 'Saved successfully';
            $data['hash'] = 'calls/list_calls';
        } else {
            $data['status'] = 'failure';
            $data['edit_mode'] = True;
            $data['error'] = array('form_error' => 'Data not Saved');
            $data['form_data'] = $form_data;
        }
        //print_r($data);die();
        return $data;
    }

    public function delete_new_customer_calls($id) {
        $this->callmodel->delete('new_customer_call', array('id' => $id));
        $this->list_calls();
    }

}
