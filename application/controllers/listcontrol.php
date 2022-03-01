<?php

class Listcontrol extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array(
            'form',
            'url',
            'date'
        ));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->load->library('pagination');
        $this->load->model('list_model');
        $this->load->model('connection');
        $this->load->model('task_model');
    }

    function show_customer_discount_group() {
        $data['rows'] = $this->list_model->simple_get('customer_discount_group', '*');
        $this->load->view('list_customer_discount_group', $data);
    }

    function show_customer_price_group() {
        $data['rows'] = $this->list_model->simple_get('customer_price_group', '*');
        $this->load->view('list_customer_price_group', $data);
    }

    function show_sales_price() {
        $data['rows'] = $this->list_model->simple_get('sales_price', '*', array(
            'starting_date' => '01-04-15',
            'sales_code' => 'CST AGENCY'
        ));
        $this->load->view('list_sales_price', $data);
    }

    function show_users() {
        $data = array();
        $this->load->view('list_users', $data);
    }

    function json_users() {
        $params = $_REQUEST;
        $columns = array(
            'umUserCode',
            'umFirstName',
            'umLastName',
            'umUserName',
            'umEmail',
            'umCity',
        );
        $search = '';
        if ($params['search']['value'] != '') {
            $search .= '(';
            foreach ($columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        $data = $this->list_model->showUserDet($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
//echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">%s</a>';
            $b_tag = '<a onclick="confirm(' . "'Are you sure you want to delete?'" . ')" href="%s">%s</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['edit'] = sprintf($a_tag, base_url() . "#listcontrol/edit_user/" . $row['umId'], "Edit");
                $data['result'][$key]['delete'] = sprintf($b_tag, base_url() . "#admin/delete_user/" . $row['umId'], "Delete");
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

    function edit_user($id) {
        $jsarray = $this->connection->getStoreData(0);
        $data['storeArray'] = $jsarray;

        $user_details = $this->userDetArray($id);
        $store_row = $this->list_model->customerDetById($user_details['umStoreId']);
        $user_roles = $this->list_model->simple_get('roles',array('role_id as id','role_name as name'));
        $store = $store_row->result();
        if (sizeof($store)) {
            $user_details['store_name'] = $store[0]->smStoreName;
            $user_details['store_name'] = $store[0]->smStoreName;
            $user_details['hid_Code'] = $store[0]->smStoreCode;
        }
        $data['edit_mode'] = TRUE;
        $data['user_details'] = $user_details;
        $data['user_roles'] = generate_options($user_roles, 0, 0, $user_details['role_id']);
        $this->load->view('create_user', $data);
    }

    function userDetArray($id) {
        if ($id != null) {
            $data = $this->list_model->UserDetById($id);

            foreach ($data->result() as $rows) {
                $umId = $rows->umId;
                $umUserName = $rows->umUserName;
                $umPassword = $rows->umPassword;
                $umUserCode = $rows->umUserCode;
                $umPrefix = $rows->umPrefix;
                $umFirstName = $rows->umFirstName;
                $umLastName = $rows->umLastName;
                $umAddress1 = $rows->umAddress1;
                $umAddress2 = $rows->umAddress2;
                $umCity = $rows->umCity;
                $umState = $rows->umState;
                $umCountry = $rows->umCountry;
                $umPin = $rows->umPin;
                $umPhone1 = $rows->umPhone1;
                $umPhone2 = $rows->umPhone2;
                $umPhone3 = $rows->umPhone3;
                $umEmail = $rows->umEmail;
                $umStoreId = $rows->umStoreId;
                $umIsHOUser = $rows->umIsHOUser;
                $umIsSalesRep = $rows->umIsSalesRep;
                $umIsManager = $rows->umIsManager;
                $umGuid = $rows->umGuid;
                $umIsActive = $rows->umIsActive;
                $role_id = $rows->role_id;
            }
            $userDet = array(
                'umId' => $umId,
                'umUserName' => $umUserName,
                'umPassword' => $umPassword,
                'umUserCode' => $umUserCode,
                'umPrefix' => $umPrefix,
                'umFirstName' => $umFirstName,
                'umLastName' => $umLastName,
                'umAddress1' => $umAddress1,
                'umAddress2' => $umAddress2,
                'umCity' => $umCity,
                'umState' => $umState,
                'umCountry' => $umCountry,
                'umPin' => $umPin,
                'umPhone1' => $umPhone1,
                'umPhone2' => $umPhone2,
                'umPhone3' => $umPhone3,
                'umEmail' => $umEmail,
                'umStoreId' => $umStoreId,
                'umIsHOUser' => $umIsHOUser,
                'umIsSalesRep' => $umIsSalesRep,
                'umIsManager' => $umIsManager,
                'umIsActive' => $umIsActive,
                'role_id' => $role_id
            );
            return $userDet;
        }
    }

    function show_product_info() {
        $data = array();
        $this->load->view('list_product_info', $data);
    }

    function json_product_info() {
        $params = $_REQUEST;
        $columns = array(
            'productCode',
            'productName',
            'category',
            'ingredients',
            'dosage',
            'anupana',
            'indication',
            'reference'
        );
        $search = '';
        if ($params['search']['value'] != '') {
            $search .= '(';
            foreach ($columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        $data = $this->list_model->getProductInfo($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
//echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">%s</a>';
            $b_tag = '<a onclick="confirm(' . "'Are you sure you want to delete?'" . ')" href="%s">%s</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['edit'] = sprintf($a_tag, base_url() . "#listcontrol/edit_product_info/" . $row['productId'], "Edit");
                $data['result'][$key]['delete'] = sprintf($b_tag, base_url() . "#listcontrol/delete_product_info/" . $row['productId'], "Delete");
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

    function edit_product_info($productId) {
        if ($productId != null) {
            $row_data = $this->list_model->showProductInfo($productId);

            foreach ($row_data->result() as $rows) {
                $productId = $rows->productId;
                $productCode = $rows->productCode;
                $productName = $rows->productName;
                $ingredients = $rows->ingredients;
                $indication = $rows->indication;
                $dosage = $rows->dosage;
                $anupana = $rows->anupana;
                $reference = $rows->reference;
                $category_selected = $rows->category;
            }
            $product_info = array(
                'productId' => $productId,
                'productCode' => $productCode,
                'productName' => $productName,
                'ingredients' => $ingredients,
                'indication' => $indication,
                'dosage' => $dosage,
                'anupana' => $anupana,
                'reference' => $reference
                    )
            ;
            $data['product_info'] = $product_info;
            $data['edit_mode'] = TRUE;

            $this->load->model('common_model');
            $categories = $this->common_model->getCategories();
            foreach ($categories as $key => $category) {
                $categories[$key]['id'] = $category['category'];
                $categories[$key]['name'] = $category['category'];
            }

            $data['categories'] = generate_options($categories, 0, 0, $category_selected);
            $this->load->view('add_product_info', $data);
        }
    }

    function add_product_info() {
        $edit_mode = FALSE;
        $product_info = $this->input->post();
        $this->load->model('common_model');
        $categories = $this->common_model->getCategories();
        foreach ($categories as $key => $category) {
            $categories[$key]['id'] = $category['category'];
            $categories[$key]['name'] = $category['category'];
        }
        if ($product_info !== FALSE) {

            if (isset($product_info['productId']) && $product_info['productId'] !== '') { // edit
                $edit_mode = TRUE;
            }
            $this->form_validation->set_rules('ingredients', 'Ingredients', 'max_length[10000]');
            $this->form_validation->set_rules('dosage', 'Dosage', 'max_length[100]');
            $this->form_validation->set_rules('anupana', 'Anupana', 'max_length[1000]');
            $this->form_validation->set_rules('reference', 'Reference', 'max_length[100]');
            $this->form_validation->set_rules('indication', 'Indication', 'max_length[1000]');
            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['product_info'] = $product_info;
                $this->load->view('add_product_info', $data);
            } else {
                if ($edit_mode) {
                    $productId = $product_info['productId'];
                    unset($product_info['productId']);
                    if ($this->list_model->editProductInfo($product_info, $productId)) {

                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_product_info';
                        $data['message'] = 'Updated successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Error while editing Product Info';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    }
                } else {
                    if ($this->list_model->addProductInfo($product_info)) {
                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_product_info';
                        $data['message'] = 'Inserted successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Error while adding Product Info';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    }
                }
            }
        } else {
            $data['categories'] = generate_options($categories, 0, 0, '');
            $data['edit_mode'] = $edit_mode;
            $this->load->view('add_product_info', $data);
        }
    }

    function delete_product_info($productId) {
        if ($this->list_model->deleteProductInfo($productId)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_product_info';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function show_customers() {
        $data = array();
        $this->load->view('list_customers', $data);
    }

    function show_projects() {
       $data = array();
        $this->load->view('list_projects',$data);
    }

    function show_departments() {
        $data = array();
         $this->load->view('list_departments',$data);
     }

    function json_customers() {
        $user_data = $this->session->userdata('userdata');
        //print_r($user_data);
        $params = $_REQUEST;
        $columns = array(
            'smStoreCode',
            'smStoreName',
            'customer_group',
            'smAddress1',
            'smCity',
        );
        $search = '';
        if ($params['search']['value'] != '') {
            $search .= '(';
            foreach ($columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        if($user_data['umIsHOUser'] !=1){
            $search .= "created_by = '".$user_data['umId']."'";
        }
        $data = $this->list_model->showcustomerDet($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
//echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">%s</a>';
            $b_tag = '<a onclick="confirm(' . "'Are you sure you want to delete?'" . ')" href="%s">%s</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['edit'] = sprintf($a_tag, base_url() . "#listcontrol/edit_customer/" . $row['smId'], "Edit");
                $data['result'][$key]['delete'] = sprintf($b_tag, base_url() . "#admin/delete_customer/" . $row['smId'], "Delete");
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

    function json_projects() {
        $user_data = $this->session->userdata('userdata');
        //print_r($user_data);
        $params = $_REQUEST;
        $columns = array(
            'project_code',
            'project_name',
            'budget',
        );
        $search = '';
        if ($params['search']['value'] != '') {
            $search .= '(';
            foreach ($columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        if($user_data['umIsHOUser'] !=1){
            $search .= "created_by = '".$user_data['umId']."'";
        }
        $data = $this->list_model->showprojectDet($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir'],$search);
     //echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">%s</a>';
            $b_tag = '<a onclick="confirm(' . "'Are you sure you want to delete?'" . ')" href="%s">%s</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['edit'] = sprintf($a_tag, base_url() . "#admin/edit_project/" . $row['project_id'], "Edit");
                $data['result'][$key]['delete'] = sprintf($b_tag, base_url() . "#admin/delete_project/" . $row['project_id'], "Delete");
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

    function json_departments() {
        $params = $_REQUEST;
        $columns = array(
            'department_code',
            'department_name',
        );
        $search = '';
        if ($params['search']['value'] != '') {
            $search .= '(';
            foreach ($columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        $data = $this->list_model->showdepartmentDet($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir']);
     //echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">%s</a>';
            $b_tag = '<a onclick="confirm(' . "'Are you sure you want to delete?'" . ')" href="%s">%s</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['edit'] = sprintf($a_tag, base_url() . "#admin/edit_department/" . $row['department_id'], "Edit");
                $data['result'][$key]['delete'] = sprintf($b_tag, base_url() . "#admin/delete_department/" . $row['department_id'], "Delete");
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

    function edit_customer($id) {
        if ($id != null) {
            $store_data = $this->list_model->customerDetById($id);

            foreach ($store_data->result() as $rows) {
                $smId = $rows->smId;
                $smStoreCode = $rows->smStoreCode;
                $smStoreName = $rows->smStoreName;
                $smAddress1 = $rows->smAddress1;
                $smAddress2 = $rows->smAddress2;
                $smCity = $rows->smCity;
                $smState = $rows->smState;
                $smCountry = $rows->smCountry;
                $smPin = $rows->smPin;
                $smPhone1 = $rows->smPhone1;
                $smPhone2 = $rows->smPhone2;
                $smPhone3 = $rows->smPhone3;
                $smEmail = $rows->smEmail;
                $smIsActive = $rows->smIsActive;
                $type = $rows->customer_group;
            }
            $store_details = array(
                'smId' => $smId,
                'smStoreCode' => $smStoreCode,
                'smStoreName' => $smStoreName,
                'smAddress1' => $smAddress1,
                'smAddress2' => $smAddress2,
                'smCity' => $smCity,
                'smState' => $smState,
                'smCountry' => $smCountry,
                'smPin' => $smPin,
                'smPhone1' => $smPhone1,
                'smPhone2' => $smPhone2,
                'smPhone3' => $smPhone3,
                'smEmail' => $smEmail,
                'smIsActive' => $smIsActive
            );
            $data['store_details'] = $store_details;
            $data['edit_mode'] = TRUE;
            $customer_types = $this->list_model->get_customer_types();
            $data['types'] = generate_options($customer_types, 0, 0, $type);
            $this->load->view('add_customer', $data);
        }
    }

    function show_divisions() {
        $data['divisionArray'] = $this->list_model->showDivisionDet();
        $this->load->view('list_division', $data);
    }

    function edit_division($id) {
        if ($id != null) {
            $division = $this->list_model->divisionDetById($id);

            foreach ($division->result() as $rows) {
                $dmId = $rows->dmId;
                $dmCode = $rows->dmCode;
                $dmDivisionName = $rows->dmDivisionName;
                $dmDescription = $rows->dmDescription;
                $dmIsActive = $rows->dmIsActive;
            }
            $divisionDet = array(
                'dmId' => $dmId,
                'dmCode' => $dmCode,
                'dmDivisionName' => $dmDivisionName,
                'dmDescription' => $dmDescription,
                'dmIsActive' => $dmIsActive
            );
            $data['edit_mode'] = TRUE;
            $data['division_details'] = $divisionDet;
            $this->load->view('add_division', $data);
        }
    }

    function show_areas() {
        $data['areaArray'] = $this->list_model->showareaDet();
        $this->load->view('list_area', $data);
    }

    function edit_area($id) {
        if ($id != null) {
            $area_data = $this->list_model->areaDetById($id);

            foreach ($area_data->result() as $rows) {
                $amId = $rows->amId;
                $amCode = $rows->amCode;
                $amAreaName = $rows->amAreaName;
            }
            $areaDet = array(
                'amId' => $amId,
                'amCode' => $amCode,
                'amAreaName' => $amAreaName
            );
            $data['area_details'] = $areaDet;
            $data['edit_mode'] = TRUE;
            $this->load->view('add_area', $data);
        }
    }

    function show_zones() {
        $data['zoneArray'] = $this->list_model->showzoneDet();
        $this->load->view('list_zone', $data);
    }

    function edit_zone($id) {
        if ($id != null) {
            $zone_data = $this->list_model->zoneDetById($id);
            if ($zone_data->num_rows() > 0) {
                foreach ($zone_data->result() as $rows) {
                    $zmId = $rows->zmId;
                    $zmCode = $rows->zmCode;
                    $zmZoneName = $rows->zmZoneName;
                    $zmBranchId = $rows->zmBranchId;
                    $bmBranchCode = $rows->bmBranchCode;
                    $bmBranchName = $rows->bmBranchName;
                }
                $zoneDet = array(
                    'zmId' => $zmId,
                    'zmCode' => $zmCode,
                    'zmZoneName' => $zmZoneName,
                    'bmBranchName' => $bmBranchName,
                    'zmBranchId' => $zmBranchId,
                    'hid_Code' => $bmBranchCode
                );
                $data['zone_details'] = $zoneDet;
                $data['edit_mode'] = TRUE;
                $data['branches'] = $this->connection->getBranchName();
                $this->load->view('add_zone', $data);
            }
        }
    }

    function edit_product($id) {
        if ($id != null) {
            $dbarray = $this->connection->get_dropdown_array_category('pmProductId', 'pmCategory', 'productlist', 'all');
            $product_data = $this->list_model->productDetById($id);
            foreach ($product_data->result() as $rows) {
                $pmProductId = $rows->pmProductId;
                $pmProductCode = $rows->pmProductCode;
                $pmProductName = $rows->pmProductName;
                $pmCategory = $rows->pmCategory;
                $pmMRP = $rows->pmMRP;
                $packingCode = $rows->packingCode;
                $insideKeralaPrice = $rows->insideKeralaPrice;
                $outsideKeralaPrice = $rows->outsideKeralaPrice;
                $pmDivisionCode = $rows->pmDivisionCode;
                $pmDescription = $rows->pmDescription;
            }
            $product_details = array(
                'pmProductId' => $pmProductId,
                'pmProductCode' => $pmProductCode,
                'pmProductName' => $pmProductName,
                'pmCategory' => $pmCategory,
                'pmMRP' => $pmMRP,
                'packingCode' => $packingCode,
                'insideKeralaPrice' => $insideKeralaPrice,
                'outsideKeralaPrice' => $outsideKeralaPrice,
                'pmDivisionCode' => $pmDivisionCode,
                'pmDescription' => $pmDescription
            );
            $data['product_details'] = $product_details;
            $data['dbArray'] = $dbarray;
            $divisionArray = $this->connection->get_dropdown_array_subArea('dmCode', 'dmDivisionName', 'divisionmaster');
            $data['divisionArray'] = $divisionArray;
            $data['edit_mode'] = TRUE;
            $this->load->view('add_product', $data);
        }
    }

    function show_branches() {
        $data['branchArray'] = $this->list_model->showbranchDet();
        $this->load->view('list_branch', $data);
    }

    function edit_branch($id) {
        if ($id != null) {
            $branch_data = $this->list_model->branchDetById($id);

            foreach ($branch_data->result() as $rows) {
                $bmBranchID = $rows->bmBranchID;
                $bmBranchCode = $rows->bmBranchCode;
                $bmBranchName = $rows->bmBranchName;
            }
            $branchDet = array(
                'bmBranchID' => $bmBranchID,
                'bmBranchCode' => $bmBranchCode,
                'bmBranchName' => $bmBranchName
            );
            $data['branch_details'] = $branchDet;
            $data['edit_mode'] = TRUE;
            $this->load->view('add_branch', $data);
        }
    }

    function edit_sub_area($id) {
        if ($id != null) {
            $subarea_data = $this->list_model->subAreaDetById($id);

            foreach ($subarea_data->result() as $rows) {
                $saId = $rows->saId;
                $saSubAreaName = $rows->saSubAreaName;
                $saIsActive = $rows->saIsActive;
            }
            $subAreaDet = array(
                'saId' => $saId,
                'saSubAreaName' => $saSubAreaName,
                'saIsActive' => $saIsActive
            );
            $data['sub_area_details'] = $subAreaDet;
            $data['edit_mode'] = TRUE;
            $this->load->view('sub_area_for_rep', $data);
        }
    }

    function show_products() {
        $data = array();
        $this->load->view('list_product', $data);
    }

    function json_products() {
        $params = $_REQUEST;
        $columns = array(
            'pmProductCode',
            'pmProductName',
            'packingCode',
            'insideKeralaPrice',
            'outsideKeralaPrice',
            'pmCategory',
        );
        $search = '';
        if ($params['search']['value'] != '') {
            $search .= '(';
            foreach ($columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        $data = $this->list_model->showProductDet($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
//echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">%s</a>';
            $b_tag = '<a onclick="confirm(' . "'Are you sure you want to delete?'" . ')" href="%s">%s</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['packingCode'] = str_pad($row['packingCode'], 4, '0', STR_PAD_LEFT);
                $data['result'][$key]['edit'] = sprintf($a_tag, base_url() . "#listcontrol/edit_product/" . $row['pmProductId'], "Edit");
                $data['result'][$key]['delete'] = sprintf($b_tag, base_url() . "#admin/delete_product/" . $row['pmProductId'], "Delete");
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

    function show_sub_area() {
        $data['subAreaArray'] = $this->list_model->showSubAreaDet();
        $this->load->view('list_subarea', $data);
    }

     function show_doctors() {
        $data = array();
        $this->load->view('list_doctors', $data);
    }

    function json_doctors() {
        $params = $_REQUEST;
        $columns = array(
            'dmDoctorCode',
            'dmDoctorName',
            
        );
        $search = '';
        if ($params['search']['value'] != '') {
            $search .= '(';
            foreach ($columns as $key => $value) {
                $search .= $value . " LIKE '%" . $params['search']['value'] . "%' OR ";
            }
            $search = substr($search, 0, -3);
            $search .= ')';
        }
        $data = $this->list_model->showDoctorDet($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir'], $search);
//echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">%s</a>';
            $b_tag = '<a onclick="confirm(' . "'Are you sure you want to delete?'" . ')" href="%s">%s</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['edit'] = sprintf($a_tag, base_url() . "#listcontrol/edit_doctors/" . $row['dmid'], "Edit");
                $data['result'][$key]['delete'] = sprintf($b_tag, base_url() . "#admin/delete_doctor/" . $row['dmid'], "Delete");
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
    function edit_doctors($id){
       if ($id != null) {
            $doctor_data = $this->list_model->doctorDetById($id);

            foreach ($doctor_data->result() as $rows) {
                $dmid = $rows->dmid;
                $dmDoctorCode = $rows->dmDoctorCode;
                $dmDoctorName = $rows->dmDoctorName;
                $dmAddress = $rows->dmAddress	;
                $dmStreet = $rows->dmStreet;
                $dmPlace = $rows->dmPlace;
                $dmCity = $rows->dmCity;
                $dmDistrict = $rows->dmDistrict;
                $dmState = $rows->dmState;
                $dmMobile = $rows->dmMobile;
                $dmPhone = $rows->dmPhone;
                $dmQualification = $rows->dmQualification;
                $dmRepName = $rows->dmRepName;
                $dmIsActive = $rows->dmIsActive;
                
            }
            $doctorDet = array(
                'dmid' => $dmid,
                'dmDoctorCode' => $dmDoctorCode,
                'dmDoctorName' => $dmDoctorName,
                'dmAddress' => $dmAddress,
                'dmPlace' => $dmPlace,
                'dmStreet' => $dmStreet,
                'dmCity' => $dmCity,
                'dmDistrict' => $dmDistrict,
                'dmState' => $dmState,
                'dmMobile' => $dmMobile,
                'dmPhone' => $dmPhone,
                'dmQualification' => $dmQualification,
                'dmRepName' => $dmRepName,
                'dmIsActive' => $dmIsActive,
            );
            $data['doctor_details'] = $doctorDet;
            $data['edit_mode'] = TRUE;
            $this->load->view('add_doctor', $data);
        }
    }

}
