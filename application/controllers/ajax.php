<?php

/**
 * @author: Ajith VP
 * @email: ajith@ttransforme.com
 * @mobile : 09747874509
 */
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');

/**
 * @property ajax_model $ajax_model Description
 */
class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ajax_model');
    }

    public function get_app_data() {
        /*
          $user_id = 1;
          $last_product_id =  0;
          $last_customer_id = 0;
          $last_task_id = 0;
          $last_route_id =0;
          $last_message_id = 0;
          $last_user_id = 0;
          $last_route_customer_id = 0;
          $last_call_id = 0;
          $last_expense_id = 0;
         */

        //  print_r($this->input->post());
        // die();
        $user_id = $this->input->post("user_id");
        $last_product_id = $this->input->post("last_product_id");
        $last_customer_id = $this->input->post("last_customer_id");
        $last_task_id = $this->input->post("last_task_id");
        $last_route_id = $this->input->post("last_route_id");
        $last_message_id = $this->input->post("last_message_id");
        $last_user_id = $this->input->post("last_user_id");
        $last_route_customer_id = $this->input->post("last_route_customer_id");
        $last_call_id = $this->input->post("last_call_id");
        $last_expense_id = $this->input->post("last_expense_id");

        $result = $this->ajax_model->getAllProductsByUserId($user_id, $last_product_id);

        $data = array();
        $data['status'] = "success";
        $product['modified'] = array();
        $product['deleted'] = array();
        $product['new'] = array();
        foreach ($result->result() as $key => $value) {
            $product['new'][$key]['i'] = $value->pmProductId;
            $product['new'][$key]['pc'] = $value->pmProductCode;
            $product['new'][$key]['n'] = $value->pmProductName;
            $product['new'][$key]['c'] = $value->pmCategory;
            $product['new'][$key]['d'] = $value->pmDivisionCode;
            $product['new'][$key]['ip'] = $value->insideKeralaPrice;
            $product['new'][$key]['op'] = $value->outsideKeralaPrice;
        }

        $result = $this->ajax_model->getAllStoreByUserId($user_id, $last_customer_id);

        $customer['modified'] = array();
        $customer['deleted'] = array();
        $customer['new'] = array();
        foreach ($result->result() as $key => $value) {
            $customer['new'][$key]['i'] = $value->StoreId;
            $customer['new'][$key]['n'] = strtoupper(trim(preg_replace('/\s\s+/', ' ', $value->StoreName)));
            $customer['new'][$key]['sc'] = $value->StoreCode;
            $customer['new'][$key]['c'] = $value->city;
            $customer['new'][$key]['s'] = $value->state;
            $customer['new'][$key]['a'] = $value->smAddress1;
            $customer['new'][$key]['p'] = $value->smPhone1;
            $customer['new'][$key]['cg'] = $value->customer_group;
            $customer['new'][$key]['ai'] = $value->AreaId;
            $customer['new'][$key]['dc'] = $value->DivisionCode;
        }

        $task['new'] = $this->ajax_model->get_tasks($user_id, $last_task_id);
        $modified_data = $this->ajax_model->get_modified_data($last_task_id, 'tasks');
        $task['modified'] = $this->ajax_model->get_tasks($user_id, $last_task_id, $modified_data['modified']);
        $task['deleted'] = $modified_data['deleted'];

        $route['new'] = $this->ajax_model->get_routes($user_id, $last_route_id);
        $modified_data = $this->ajax_model->get_modified_data($last_route_id, 'routes');
        $route['modified'] = $this->ajax_model->get_routes($user_id, $last_route_id, $modified_data['modified']);
        $route['deleted'] = $modified_data['deleted'];

        $message['new'] = $this->ajax_model->get_messages($user_id, $last_message_id);
        $modified_data = $this->ajax_model->get_modified_data($last_message_id, 'messages');
        $message['modified'] = $this->ajax_model->get_messages($user_id, $last_message_id, $modified_data['modified']);
        $message['deleted'] = $modified_data['deleted'];

        $user['new'] = $this->ajax_model->get_users($user_id, $last_user_id);
        $modified_data = $this->ajax_model->get_modified_data($last_user_id, 'users');
        $user['modified'] = $this->ajax_model->get_users($user_id, $last_user_id, $modified_data['modified']);
        $user['deleted'] = $modified_data['deleted'];

        $route_customer['new'] = $this->ajax_model->get_route_customers($user_id, $last_route_customer_id);
        $modified_data = $this->ajax_model->get_modified_data($last_route_customer_id, 'route_details');
        $route_customer['modified'] = $this->ajax_model->get_route_customers($user_id, $last_route_customer_id, $modified_data['modified']);
        $route_customer['deleted'] = $modified_data['deleted'];

        $call['new'] = $this->ajax_model->get_calls($user_id, $last_call_id);
        $modified_data = $this->ajax_model->get_modified_data($last_call_id, 'calls');
        $call['modified'] = $this->ajax_model->get_calls($user_id, $last_call_id, $modified_data['modified']);
        $call['deleted'] = $modified_data['deleted'];

        $expense['new'] = $this->ajax_model->get_expenses($user_id, $last_expense_id);
        $modified_data = $this->ajax_model->get_modified_data($last_expense_id, 'expenses');
        $expense['modified'] = $this->ajax_model->get_expenses($user_id, $last_expense_id, $modified_data['modified']);
        $expense['deleted'] = $modified_data['deleted'];

        $data['tasks'] = $task;
        $data['expenses'] = $expense;
        $data['calls'] = $call;
        $data['routes'] = $route;
        $data['route_customers'] = $route_customer;
        $data['messages'] = $message;
        $data['users'] = $user;
        $data['customers'] = $customer;
        $data['products'] = $product;
        echo json_encode($data);
    }

    public function save_lead() {
        $form_data = $this->input->post();
        unset($form_data['lead_id']);
        $data = array();
        $data['lead_id'] = $this->ajax_model->save_lead($form_data);
        $data['status'] = "success";
        //  $data['q'] = $this->db->last_query();
        echo json_encode($data);
    }

    public function save_call() {
        $form_data = $this->input->post();
        unset($form_data['call_id']);
        $data = array();
        $data['call_id'] = $this->ajax_model->save_call($form_data);
        $data['status'] = "success";
        $data['q'] = $this->db->last_query();
        echo json_encode($data);
    }

    public function save_expense() {
        $form_data = $this->input->post();
        $data = array();
        $data['expense_id'] = $this->ajax_model->save_expense($form_data);
        $data['status'] = "success";
        // $data['q'] = $this->db->last_query();
        echo json_encode($data);
    }

    public function change_password() {
        $data['Status'] = "failure";
        if ($this->ajax_model->change_password($this->input->post('user_id'), $this->input->post('password'), $this->input->post('old_password'))) {
            $data['Status'] = "success";
        }

        echo json_encode($data);
    }

    public function do_login_new() {
        $data = $this->ajax_model->get_user($this->input->post('username'), $this->input->post('password'));
        if ($data) {
            $result['Name'] = $data['umUserName'];
            $result['Userid'] = $data['umId'];
            $result['isHOUser'] = $data['umIsHOUser'];
            $result['isSalesRep'] = $data['umIsSalesRep'];
            $result['storeId'] = is_null($data['umStoreId']) ? '0' : $data['umStoreId'];
            $result['isManager'] = $data['umIsManager'];
            $result['isHOUser'] = $data['umIsHOUser'];
            $result['role'] = $data['role_name'];
            $result['photo'] = base_url() . 'assets/img/avatar3.png'; //$rows->umIsHOUser;
            $result['Status'] = 1;
            $this->db->query('SELECT GetUserAuthorizedModeItems(' . $result['Userid'] . ')');
 //$result['q'] = 'SELECT GetUserAuthorizedModeItems(' . $result['Userid'] . ')';
        } else {
            $result['Status'] = 0;
        }
        echo json_encode($result);
    }

    public function do_login() {

        $this->load->model('connection');
        $data = $this->connection->getuser($this->input->post('username'), $this->input->post('password'));
        foreach ($data->result() as $rows) {
            if ($rows->cnt > 0) {
                $datafield = $this->connection->getuserdet($this->input->post('username'), $this->input->post('password'));
                foreach ($datafield->result() as $rows) {
                    $result['Name'] = $rows->umUserName;
                    $result['Userid'] = $rows->umId;
                    $result['isHOUser'] = $rows->umIsHOUser;
                    $result['isSalesRep'] = $rows->umIsSalesRep;
                    $result['storeId'] = is_null($rows->umStoreId) ? '0' : $rows->umStoreId;
                    $result['isManager'] = $rows->umIsManager;
                    $result['isHOUser'] = $rows->umIsHOUser;
                    $result['role'] = 'Administrator'; //$rows->umIsHOUser;
                    $result['photo'] = base_url() . 'assets/img/avatar3.png'; //$rows->umIsHOUser;
                }
                $result['Status'] = 1;
            } else {
                $result['Status'] = 0;
            }
            echo json_encode($result);
        }
    }

    public function customers() {

        $this->load->model('ajax_model');
        $userId = $this->input->get("userid");
        $data = $this->ajax_model->getAllStoreByUserId($userId);
        echo json_encode($data->result());
    }

    public function products() {

        $this->load->model('ajax_model');
        $userId = $this->input->get("userid");
        $data = $this->ajax_model->getAllProductsByUserId($userId);
        echo json_encode($data->result());
    }

    public function order_new() {
        $this->load->model('ajax_model');
        $userId = $this->input->post('user_id');
        $user_details = $this->ajax_model->get_user_details($userId);
        $storeId = $this->input->post('storeId');
        $areaId = $this->input->post('areaId');
        $divCode = $this->input->post('divisionCode');
        $SalesRepId = $user_details['umIsSalesRep'];
        $ManagerId = $user_details['umIsManager'];
        $StoreUserId = is_null($user_details['umStoreId']) ? '0' : $user_details['umStoreId'];
        $HoId = $user_details['umIsHOUser'];

        $items = $this->input->post('items');
        $amount = 0;
        $items = json_decode($items, TRUE);

        foreach ($items as $item) {
            $amount += $item['unitprice'] * $item['quantity'];
        }
        $summary = $this->ajax_model->saveSalesOrder($storeId, $areaId, $divCode, $SalesRepId, $ManagerId, $StoreUserId, $amount, $HoId, $userId);
        $summaryId = $summary['order_id'];
        $summary['status'] = 1;
        foreach ($items as $item) {
            $this->ajax_model->saveSODetails($summaryId, $item['productId'], $item['productCode'], $item['productName'], $item['category'], $item['quantity'], $item['offerquantity'], $item['unitprice'], $item['unitprice'] * $item['quantity']);
        }
        echo json_encode($summary);
    }

    public function order() {

        $this->load->model('ajax_model');
        $storeId = $this->input->post('storeId');
        $areaId = $this->input->post('areaId');
        $divCode = $this->input->post('divisionCode');
        $SalesRepId = $this->input->post('isSalesRep');
        $ManagerId = $this->input->post('isManager');
        $StoreUserId = $this->input->post('userStoreId');
        $HoId = $this->input->post('isHOUser');
        $userName = $this->input->post('userId');
        $items = $this->input->post('items');
        $amount = 0;
        $items = json_decode($items, TRUE);

        foreach ($items as $item) {
            $amount += $item['unitprice'] * $item['quantity'];
        }
        $summary = $this->ajax_model->saveSalesOrder($storeId, $areaId, $divCode, $SalesRepId, $ManagerId, $StoreUserId, $amount, $HoId, $userName);
        $summaryId = $summary['order_id'];
        $summary['status'] = 1;
        foreach ($items as $item) {
            $this->ajax_model->saveSODetails($summaryId, $item['productId'], $item['productCode'], $item['productName'], $item['category'], $item['quantity'], $item['offerquantity'], $item['unitprice'], $item['unitprice'] * $item['quantity']);
        }
        echo json_encode($summary);
    }

    function get_product_info() {
        $this->load->model('list_model');
        $product_info = $this->list_model->showProductInfo();
        $product_info_array = $product_info->result_array();
        foreach ($product_info_array as $key => $row) {
            $product_info_array[$key]['category'] = ucwords(strtolower($product_info_array[$key]['category']));
        }
        echo json_encode($product_info_array);
    }

    function set_task_status() {

        $cond['task_id'] = $this->input->post('task_id');
        $cond['user_id'] = $this->input->post('user_id');
        $form_data['is_read'] = $this->input->post('is_read');
        $form_data['read_date'] = $this->input->post('read_date');
        $form_data['is_done'] = $this->input->post('is_done');
        if ($this->input->post('done_date') != '') {
            $form_data['done_date'] = $this->input->post('done_date');
        }
        $response = array();
        $response['status'] = "success";
        $this->load->model('task_model');
        $this->task_model->edit('user_tasks', $form_data, $cond);
        $response['q'] = $this->db->last_query();

        echo json_encode($response);
    }

}

/* End of file ajax.php */
/* Location: /application/controllers/ajax.php */
?>
