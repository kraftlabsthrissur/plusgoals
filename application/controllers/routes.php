<?php

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2015, Ajith Vp <ajith@kraftlabs.com>
 * @date 06-Feb-2015
 */

/**
 * @property privilegemodel $privilegemodel Description
 * @property routemodel $routemodel Description
 * 
 */
class Routes extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('routemodel');
        $this->load->model('list_model');
        $this->load->model('privilegemodel');
        $this->load->model('connection');
    }

    public function add_routes() {

        $edit_mode = FALSE;
        $form_data = $this->input->post();

        $area = $this->list_model->simple_get('areamaster', array('amId as id,amAreaName as name '));
        $user_data = $this->session->userdata('userdata');
        // $customers = $this->routemodel->simple_get('storemaster', array('smId as id,smStoreName as name '));
        $customer = $this->connection->getAllStoreByUserId($user_data['umId']);
        $i = 0;
        foreach ($customer->result() as $rows) {

            $customers[$i]['id'] = $rows->id;
            $customers[$i]['name'] = $rows->name;
            $customers[$i]['rep_name'] = $rows->rep_name;
            $customers[$i]['area'] = $rows->smAddress2;
            $customers[$i]['location'] = $rows->smCity;
            $i++;
        }


        if ($form_data !== FALSE) {

            $data = $this->save_route($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['headquarters'] = generate_options($area, 0, 0, $form_data['amId']);
                // $data['customers'] = generate_options($customers);
                $data['customers'] = $customers;
                $this->load->view('routes/form_route', $data);
            }
        } else {
            $data['headquarters'] = generate_options($area);

            //$data['customers'] = generate_options($customers);
            $data['customers'] = $customers;
            $data['edit_mode'] = $edit_mode;

            $this->load->view('routes/form_route', $data);
        }
    }

    public function edit_routes($id) {

        $edit_mode = TRUE;
        $form_data = $this->input->post();

        $where = "`r`.`route_id`=" . $id . " order by `rd`.`order` ASC";
        $routes = $this->routemodel->get_routes_by_id($where);
        $user_data = $this->session->userdata('userdata');
        //$customers = $this->routemodel->simple_get('storemaster', array('smId as id,smStoreName as name '));
        $area = $this->list_model->simple_get('areamaster', array('amId as id,amAreaName as name '));
        $customer = $this->connection->getAllStoreByUserId($user_data['umId']);
        $i = 0;
        $customers[$i]['id'] = '';
        $customers[$i]['name'] = "Select Customer";
        $i = 1;
        foreach ($customer->result() as $rows) {
            $customers[$i]['id'] = $rows->id;
            $customers[$i]['name'] = $rows->name;


            $i++;
        }
        if ($form_data !== FALSE) {

            $data = $this->save_route($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['headquarters'] = generate_options($area, 0, 0, $form_data['amId']);
                $data['customers'] = generate_options($customers);
                $data['routes'] = $routes;
                $this->load->view('routes/form_route', $data);
            }
        } else {

            $data['headquarters'] = generate_options($area, 0, 0, $routes[0]['headquarters_id']);
            $data['customers'] = generate_options($customers);
            $data['edit_mode'] = $edit_mode;
            $data['routes'] = $routes;

            $this->load->view('routes/form_route', $data);
        }
    }

    public function delete_route($id) {
        $this->routemodel->delete('routes', array('route_id' => $id));
        $this->routemodel->delete('route_details', array('route_id' => $id));
        $data['table_data'] = $this->routemodel->get_routes();
        //echo $this->db->last_query();
        $this->load->view('routes/list_routes', $data);
    }

    public function view_routes() {
        
    }

    public function select_customers() {
        $id = $_POST['id'];
        $where = "`smId`=" . $id;
        $customers = $this->routemodel->get_customer_address($where);
        echo $customers['address'];
    }

    public function list_routes() {
        $user_data = $this->session->userdata('userdata');
        $Where = "r.is_active = 1";
        if ($user_data['umIsHOUser'] != 1) {

            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $Where = "r.created_by in (" . $subordinate_users . ") and r.is_active =1 ";
        }
        $data['table_data'] = $this->routemodel->get_routes($Where);
        //echo $this->db->last_query();
        $data['assigned_user'] = $this->routemodel->get_assigned_user($Where);
        $this->load->view('routes/list_routes', $data);
    }

    public function save_route($form_data) {

        $routes['headquarters_id'] = $form_data['amId'];
        $routes['route_name'] = $form_data['route_name'];
        $routes['starting_location'] = $form_data['starting_location'];
        $userdata = $this->session->userdata('userdata');

        $routes['created_by'] = $userdata['umId'];
        $routes['created_date'] = date('Y-m-d');

        foreach ($form_data['place'] as $key => $value) {
            $route_details['place'] = $value;
        }
        $edit_mode = FALSE;
        if (isset($form_data['route_id']) && $form_data['route_id'] !== '') { // edit
            $edit_mode = TRUE;
            $this->form_validation->set_rules('route_name', 'Route Name', 'required|max_length[100]|exist_among[routes.route_name.route_id.' . $form_data['route_id'] . ']');
        } else {
            $this->form_validation->set_rules('route_name', 'Route Name', 'required|max_length[100]|exists[routes.route_name]');
            $this->form_validation->set_rules('amId', 'amId', 'max_length[500]');
        }


        if ($this->form_validation->run() == FALSE) {

            $data['edit_mode'] = $edit_mode;
            $data['error'] = $this->form_validation->error_array();

            $data['form_data'] = $routes;
            $data['status'] = 'failure';
        } else {

            if ($edit_mode) {

                $id = $form_data['route_id'];
                unset($form_data['route_id']);
                $result = $this->routemodel->edit('routes', $routes, array('route_id' => $id));
                $this->routemodel->delete('route_details', array('route_id' => $id));

                foreach ($form_data['place'] as $key => $value) {
                    $route_details['route_id'] = $id;
                    $route_details['place'] = $value;
                    $route_details['customer_id'] = $form_data['customer_id'][$key];
                    $route_details['latitude'] = $form_data['place_lat'][$key];
                    $route_details['longitude'] = $form_data['place_lng'][$key];
                    $route_details['order'] = $key + 1;


                    $res = $this->routemodel->insert('route_details', $route_details, array('route_id' => $id));
                }
                if ($result) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'routes/list_routes';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $routes;
                }
            } else {

                $routes['is_active'] = 1;

                $result = $this->routemodel->insert('routes', $routes);
                $route_details['route_id'] = $this->db->insert_id();
                foreach ($form_data['place'] as $key => $value) {
                    $route_details['place'] = $value;
                    $route_details['customer_id'] = $form_data['customer_id'][$key];
                    $route_details['latitude'] = $form_data['place_lat'][$key];
                    $route_details['longitude'] = $form_data['place_lng'][$key];
                    $route_details['order'] = $key + 1;

                    $res = $this->routemodel->insert('route_details', $route_details);
                }
                if ($result && $res) {
                    $data['status'] = 'success';
                    $data['message'] = 'Saved successfully';
                    $data['hash'] = 'routes/list_routes';
                } else {
                    $data['status'] = 'failure';
                    $data['edit_mode'] = $edit_mode;
                    $data['error'] = array('form_error' => 'Data not Saved');
                    $data['form_data'] = $routes;
                }
            }
        }

        return $data;
    }

    public function check_coordinates() {
        $where = "place like '%" . $_POST['place'] . "%' LIMIT 1";
        $result = $this->routemodel->simple_get('route_details', array('place', 'latitude', 'longitude'), $where);

        echo json_encode($result[0]);
    }

    public function select_user() {
        $data['route_id'] = $_POST['id'];
        $userWhere = "1=1"; //and umStoreId is null
        $user_data = $this->session->userdata('userdata');
        if ($user_data['umIsHOUser'] != 1) {

            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $userWhere = "umid in (" . $subordinate_users . ") ";
        }
        $users = $this->routemodel->simple_get('usermaster', array('umId as id ,umUserName as name'), $userWhere);
        $data['users'] = generate_options($users);
        $this->load->view('routes/assign_routes', $data);
    }

    public function assign_route() {
        //print_r($_POST);
        $assigned_routes['route_id'] = $_POST['route_id'];
        $assigned_routes['user_id'] = $_POST['user_id'];
        $assigned_routes['date'] = $_POST['date'];
        $assigned_routes['is_active'] = 1;
        if ($this->routemodel->insert('assigned_routes', $assigned_routes)) {
            $data['assigned_route_id'] = $this->db->insert_id();
            $data['message'] = "Route Assigned successfully";
            $data['status'] = "success";
        } else {
            $data['status'] = "failure";
        }
        echo json_encode($data);
    }

    public function calendar_view() {
        $c = 0;
        $data['p'] = -1;
        $data['n'] = 1;
        if (isset($_GET['c'])) {
            $c = $_GET['c'];
            $data['p'] = $c - 1;
            $data['n'] = $data['p'] + 2;
            $data['date'] = date('Y-m-d', strtotime("first day of $c month"));
            $data['month'] = date('F Y', strtotime("first day of  $c month"));
        } else {
            $data['month'] = date('F Y', strtotime("first day of  $c month"));
        }

        $user_data = $this->session->userdata('userdata');
        $subordinate_users = '';
        if ($user_data['umIsHOUser'] != 1) {
            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];
            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $userWhere = " umId in (" . $subordinate_users . ") and umStoreId is null";
            $routeWhere = "created_by in (" . $subordinate_users . ") and is_active=1";
        } else {
            $userWhere = "umStoreId is null";
            $routeWhere = "is_active=1";
        }
        $users = $this->routemodel->simple_get('usermaster', array('umId as id ,umUserName as name'), $userWhere);
        $data['users'] = generate_options($users);
        $routes = $this->routemodel->simple_get('routes', array('route_id as id ,route_name as name'), $routeWhere);
        $data['routes'] = generate_options($routes);

        $data['assigned_route'] = $this->routemodel->get_assigned_routes($subordinate_users);
        $this->load->view('routes/calendar_view', $data);
    }

    public function view_assign_route() {

        $where = "ar.date='" . $_POST['date'] . "'";
        $user_data = $this->session->userdata('userdata');

        if ($user_data['umIsHOUser'] != 1) {

            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            $where = "ar.date='" . $_POST['date'] . "' and ar.user_id in (" . $subordinate_users . ")";
        }
        $data['assigned_route'] = $this->routemodel->get_assigned_routes_by_date($where);
        //echo $this->db->last_query();

        $data['routes'] = $this->routemodel->simple_get('route_details', array('route_id', 'place'));
        // print_r($data);die();
        $this->load->view('routes/view_assign_routes', $data);
    }

    function remove_assigned_route() {
        $assigned_route_id = $this->input->post('assigned_route_id');
        $this->routemodel->delete("assigned_routes", array('id' => $assigned_route_id));
        $array = array(
            'table_name' => 'routes',
            'primary_key' => 'id',
            'value' => $assigned_route_id,
            'data_change' => 'deleted',
            'date' => date('Y-m-d H:i:s')
        );
        $this->routemodel->insert('data_changes', $array);
    }

}
