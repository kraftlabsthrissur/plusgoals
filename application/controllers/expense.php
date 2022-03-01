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
class Expense extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('routemodel');
        $this->load->model('list_model');
        $this->load->model('privilegemodel');
        $this->load->model('expensemodel');
    }

    public function list_expense() {
        $user_data = $this->session->userdata('userdata');
        
        $where = "1 = 1";
        if ($user_data['umId'] != 1) {

            $data['subordinate_users'] = $this->privilegemodel->get_subordinate_users($user_data['umId']);
            $subordinate_users = $data['subordinate_users']['user_id'];

            if ($subordinate_users == null) {
                $subordinate_users = $user_data['umId'];
            } else {
                $subordinate_users = $user_data['umId'] . ',' . $subordinate_users;
            }
            if ($user_data['role_id'] == 10) {
                $where = "ex.user_id in (" . $subordinate_users . ") and ex.status=Accepted By ASM";
            } elseif ($user_data['role_id'] == 11) {
                $where = "ex.user_id in (" . $subordinate_users . ") and ex.status=Accepted By Marketing dept.";
            } else {
                $where = "ex.user_id in (" . $subordinate_users . ")";
            }
        }
        $data['table_data'] = $this->expensemodel->get_expenses($where);
        // print_r($data);
        // echo $this->db->last_query();
        $this->load->view('expense/list_expense', $data);
    }

    public function add_expense($id = null) {
        if ($id == null) {
            $edit_mode = FALSE;
        } else {
            $edit_mode = TRUE;
            $expense_id['id'] = $id;
            $expense = $this->expensemodel->simple_get('expenses', array('*'), $expense_id);
            $data['expense'] = $expense;
        }

        $form_data = $this->input->post();
        $user_data = $this->session->userdata('userdata');

        if ($user_data['umId'] != 1) {
            $where = "ar.user_id=" . $user_data['umId'] . " group by r.route_id";
        } else {

            $where = "1=1 group by r.route_id";
        }
        $routes = $this->routemodel->get_assigned_route_names($where);
        if ($form_data !== FALSE) {
            $form_data['user_id'] = $user_data['umId'];
            $form_data['edit_mode'] = $edit_mode;
            // print_r($form_data);
            $data = $this->save_expense($form_data);
            if ($data['status'] === 'success') {
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['routes'] = generate_options($routes, 0, 0, $form_data['route_id']);
                $this->load->view('expense/form_expense', $data);
            }
        } else {

            $data['routes'] = generate_options($routes);
            $data['user_data'] = $user_data;
            $data['edit_mode'] = $edit_mode;
            $this->load->view('expense/form_expense', $data);
        }
    }

    public function view_expense() {
        $id['id'] = $_POST['id'];
        $user_data = $this->session->userdata('userdata');
        $id['user_id'] = $user_data['umId'];
        $data['role'] = $this->expensemodel->simple_get('roles', array('role_id', 'role_name'), 'role_id= ' . $user_data['role_id'] . '');
        $data['expense'] = $this->expensemodel->get_expenses_by_id($id);
        // echo $this->db->last_query();
        $this->load->view('expense/view_expenses', $data);
    }

    public function delete_expense($id) {
        $this->expensemodel->delete('expense', array('id' => $id));
        $user_data = $this->session->userdata('userdata');
        $data['table_data'] = $this->expensemodel->get_expenses($user_data['umId']);
        //echo $this->db->last_query();
        $this->load->view('expense/list_expense', $data);
    }

    public function save_expense($form_data) {
        //print_r($form_data);die();
        if ($form_data['edit_mode'] == 1) {
            unset($form_data['edit_mode']);
            //print_r($form_data);die('45');
            $id['id'] = $form_data['id'];
            $form_data['modified_date'] = date('Y-m-d H:m:s');
            $form_data['status'] = "Not_verified";
            $result = $this->expensemodel->update('expenses', $form_data, $id);
        } else {
            unset($form_data['edit_mode']);
            $form_data['created_date'] = date('Y-m-d H:m:s');
            $form_data['status'] = "Not_verified";
            $result = $this->expensemodel->insert('expenses', $form_data);
        }
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = 'Saved successfully';
            $data['hash'] = 'expense/list_expense';
        } else {
            $data['status'] = 'failure';
            $data['edit_mode'] = True;
            $data['error'] = array('form_error' => 'Data not Saved');
            $data['form_data'] = $form_data;
        }

        return $data;
    }

    public function accept_expenses() {

        $id['id'] = $_POST['id'];
        if ($_POST['role'] == 9) {
            $status['status'] = "Accepted By ASM";
        } elseif ($_POST['role'] == 10) {
            $status['status'] = "Accepted By Marketing dept.";
        } else {
            $status['status'] = "Accepted By Accounts dept.";
        }
        $this->expensemodel->update('expenses', $status, $id);
        $this->list_expense();
    }

    public function reject_expenses() {

        $id['id'] = $_POST['id'];

        if ($_POST['role'] == 9) {
            $status['status'] = "Rejected By ASM";
        } elseif ($_POST['role'] == 10) {
            $status['status'] = "Rejected By Marketing dept.";
        } else {
            $status['status'] = "Rejected By Accounts dept.";
        }
        $this->expensemodel->update('expenses', $status, $id);
        $this->list_expense();
    }

}

?>
