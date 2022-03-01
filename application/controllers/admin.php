<?php

/**
 * @property common_model $common_model Description
 * @property connection $connection Description
 * 
 */
class admin extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'date'));
        $this->load->library('form_validation');
        $this->load->model('connection');
        $this->load->model('list_model');
        $this->load->model('task_model');
    }

    function index() {
        $this->load->view('admin_view');
    }

    function sub_area_for_rep() {
        $this->load->view('sub_area_for_rep');
    }

    function sub_area_allocation() {
        $dbarray = $this->connection->get_dropdown_array_subArea('said', 'saSubAreaName', 'subareaforrepmaster');
        $data['dbArray'] = $dbarray;
        $jsarray = $this->connection->getStoreData(0);
        $mangerarray = $this->connection->getManagerData(0);
        $SR = $this->connection->getSRData(0);
        $data['storeArray'] = $jsarray;
        $data['managerArray'] = $mangerarray;
        $data['SRArray'] = $SR;
        $this->load->view('sub_area_allocation', $data);
    }

    function getmanagerList($type, $value = '', $subAreaId) {
        if ($type == 'all' && $value == 'searchstringMissing') {
            $data = $this->connection->getManagerData($subAreaId);
        } else {
            $data = $this->connection->searchManagerData($type, $value, $subAreaId);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->umId . "\" />" . $row->umUserName . "</td>";
                $response .= "<td class=\"second\">" . $row->umUserCode . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function getSRList($type, $value = '', $subAreaId) {
        if ($type == 'all' && $value == 'searchstringMissing') {
            $data = $this->connection->getSRData($subAreaId);
        } else {
            $data = $this->connection->searchSRData($type, $value, $subAreaId);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->umId . "\" />" . $row->umUserName . "</td>";
                $response .= "<td class=\"second\">" . $row->umUserCode . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function area_matrix() {
        $userdata = $this->session->userdata('userdata');
        $sAreaArray = $this->connection->getsubAreaName();
        $zoneArray = $this->connection->getZoneName();
        $areaArray = $this->connection->getAreaName($userdata['umId']);
        $divisionArray = $this->connection->getDivisionName($userdata['umId']);
        $datas['subAreaArray'] = $sAreaArray;
        $datas['zoneArray'] = $zoneArray;
        $datas['areaArray'] = $areaArray;
        $datas['divisionArray'] = $divisionArray;
        $this->load->view('area_matrix', $datas);
    }

    function create_user() {
        $jsarray = $this->connection->getStoreData(0);
        $data['storeArray'] = $jsarray;
        $data['edit_mode'] = FALSE;
        $userss = $this->connection->getUserss();
        $data['userss'] = $userss;
        //$data['userDetails']='';
        $user_details = $this->input->post();
        $user_roles = $this->list_model->simple_get('roles',array('role_id as id','role_name as name'));
        if ($user_details !== FALSE) {
            if (isset($user_details['umId']) && $user_details['umId'] !== '') { // edit
                $edit_mode = TRUE;
                $data['user_roles'] = generate_options($user_roles, 0, 0);
                $this->form_validation->set_rules('umUserName', 'Username', 'required|exist_among[usermaster.umUserName.umId.' . $user_details['umId'] . ']');
                $this->form_validation->set_rules('umUserCode', 'UserCode', 'required|exist_among[usermaster.umUserCode.umId.' . $user_details['umId'] . ']');
                if (isset($user_details['umPassword'])) {
                    $this->form_validation->set_rules('umPassword', 'Password', 'required|min_length[5]|max_length[12]');
                } else {
                    $this->form_validation->set_rules('umPassword', 'Password', 'min_length[5]|max_length[12]');
                }
            } else {
                $edit_mode = FALSE;
                $this->form_validation->set_rules('umUserName', 'Username', 'required|callback_txtUname_check');
                $this->form_validation->set_rules('umUserCode', 'UserCode', 'required|callback_txtUserCode_check');
                $this->form_validation->set_rules('umPassword', 'Password', 'required|min_length[5]|max_length[12]');
            }

            $this->form_validation->set_rules('umFirstName', 'First Name', 'required');
            $this->form_validation->set_rules('umLastName', 'Last Name', 'required');
            $this->form_validation->set_rules('umAddress1', 'Address 1', 'required');
            $this->form_validation->set_rules('umAddress2', 'Address 2', '');
            $this->form_validation->set_rules('umCity', 'City', '');
            $this->form_validation->set_rules('umState', 'State', '');
            $this->form_validation->set_rules('umCountry', 'Country', '');
            $this->form_validation->set_rules('umEmail', 'email', 'valid_email');
          //  $this->form_validation->set_rules('user_type', 'User type', 'required');
            $this->form_validation->set_rules('umPin', 'Pin', 'numeric|min_length[6]');
            $this->form_validation->set_rules('umPhone1', 'Residence Phone', 'numeric|min_length[10]');
            $this->form_validation->set_rules('umPhone2', 'Office Phone', 'numeric|min_length[10]');
            $this->form_validation->set_rules('umPhone3', 'Mobile number', 'numeric|min_length[10]');

            $data['user_roles'] = generate_options($user_roles, 0, 0, $user_details['role_id']);
    
        if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['user_details'] = $user_details;
                $this->load->view('create_user', $data);
            } else {

                if ($this->input->post('hid_Code') != "") {
                    $UserCode = $this->input->post('hid_Code');
                }

                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $user_details['umIsHOUser'] = 0;//$user_details['user_type'] === 'h.o.user' ? 1 : 0;
                $user_details['umIsSalesRep'] = 1;
                $user_details['umIsManager'] = 0;// $user_details['user_type'] === 'area_manager' ? 1 : 0;
                $user_details['umGuid'] = '32277FBC-5EEF-4C92-BBE9-49DDBA2CEB8C';
                $user_details['umTS'] = mdate($format, $time);
                $user_details['umResetPassword'] = '0';

                unset($user_details['user_type']);
                unset($user_details['store_name']);
                unset($user_details['hid_Code']);
                if ($edit_mode) {
                    $this->editUser($user_details);
                } else {
                    $this->addUser($user_details);                   
                }
               // $this->privilegemodel->insert_default_role_privileges_to_user($user_details['umId'], $user_details['role_id']);
            }
        } else {
            $data['user_roles'] = generate_options($user_roles);
            $data['user_details'] = array(
                'umState' => 'Kerala',
                'umCountry' => 'India',
            );
            $this->load->view('create_user', $data);
        }
    }

    function add_zone() {

        $data['branches'] = $this->connection->getBranchName();

        $edit_mode = FALSE;
        $zone_details = $this->input->post();
        if ($zone_details !== FALSE) {

            if (isset($zone_details['zmId']) && $zone_details['zmId'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('zmCode', 'Zone Code', 'required|exist_among[zonemaster.zmCode.zmId.' . $zone_details['zmId'] . ']');
                $this->form_validation->set_rules('zmZoneName', 'Zone Name', 'required|exist_among[zonemaster.zmZoneName.zmId.' . $zone_details['zmId'] . ']');
            } else {
                $this->form_validation->set_rules('zmCode', 'Zone Code', 'required|exists[zonemaster.zmCode]');
                $this->form_validation->set_rules('zmZoneName', 'Zone Name', 'required|exists[zonemaster.zmZoneName]');
            }
            $this->form_validation->set_rules('zmBranchId', 'Branch', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['zone_details'] = $zone_details;
                $this->load->view('add_zone', $data);
            } else {
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $zone_details['zmTS'] = mdate($format, $time);
                $zone_details['zmGuid'] = '851C5B71-4756-4404-8081-8EF51DD37DBD';
                unset($zone_details['bmBranchName']);
                unset($zone_details['hid_Code']);
                if ($edit_mode) {
                    $id = $zone_details['zmId'];
                    unset($zone_details['zmId']);
                    $this->editZone($zone_details, $id);
                } else {
                    $this->addZone($zone_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('add_zone', $data);
        }
    }

    function add_branch() {
        $edit_mode = FALSE;
        $branch_details = $this->input->post();
        if ($branch_details !== FALSE) {

            if (isset($branch_details['bmBranchID']) && $branch_details['bmBranchID'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('bmBranchCode', 'Branch Code', 'required|exist_among[branchmaster.bmBranchCode.bmBranchID.' . $branch_details['bmBranchID'] . ']');
                $this->form_validation->set_rules('bmBranchName', 'Branch Name', 'required|exist_among[branchmaster.bmBranchName.bmBranchID.' . $branch_details['bmBranchID'] . ']');
            } else {
                $this->form_validation->set_rules('bmBranchCode', 'Branch Code', 'required|exists[branchmaster.bmBranchCode]');
                $this->form_validation->set_rules('bmBranchName', 'Branch Name', 'required|exists[branchmaster.bmBranchName]');
            }

            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['branch_details'] = $branch_details;
                $this->load->view('add_branch', $data);
            } else {
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $branch_details['bmTS'] = mdate($format, $time);
                $branch_details['bmGuid'] = '851C5B71-4756-4404-8081-8EF51DD37DBD';
                if ($edit_mode) {
                    $id = $branch_details['bmBranchID'];
                    unset($branch_details['bmBranchID']);
                    $this->editBranch($branch_details, $id);
                } else {
                    $this->addBranch($branch_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('add_branch', $data);
        }
    }

    function add_category() {
        $edit_mode = FALSE;
        $cat_details = $this->input->post();
        if ($cat_details !== FALSE) {

            if (isset($cat_details['old_category']) && $cat_details['old_category'] !== '') { // edit
                $edit_mode = TRUE;
            }
            $this->form_validation->set_rules('category', 'Category Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['form_data'] = $cat_details;
                $this->load->view('add_category', $data);
            } else {

                if ($edit_mode) {
                    $old_category = $cat_details['old_category'];
                    unset($cat_details['old_category']);
                    $this->editCategory($cat_details, $old_category);
                } else {
                    $this->addCategory($cat_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('add_category', $data);
        }
    }

    function edit_category($category) {
        $edit_mode = TRUE;
        $cat_details = $this->input->post();
        if ($cat_details !== FALSE) {

            if (isset($cat_details['old_category']) && $cat_details['old_category'] !== '') { // edit
                $edit_mode = TRUE;
            }
            $this->form_validation->set_rules('category', 'Category Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['form_data'] = $cat_details;
                $this->load->view('add_category', $data);
            } else {

                if ($edit_mode) {
                    $old_category = $cat_details['old_category'];
                    unset($cat_details['old_category']);
                    $this->editCategory($cat_details, $old_category);
                } else {
                    $this->addCategory($cat_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $data['form_data'] = array('category' => $category, 'old_category' => $category);
            $this->load->view('add_category', $data);
        }
    }

    function add_area() {
        $edit_mode = FALSE;
        $area_details = $this->input->post();
        if ($area_details !== FALSE) {

            if (isset($area_details['amId']) && $area_details['amId'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('amCode', 'Area Code', 'required|exist_among[areamaster.amCode.amId.' . $area_details['amId'] . ']');
                $this->form_validation->set_rules('amAreaName', 'Area Name', 'required|exist_among[areamaster.amAreaName.amId.' . $area_details['amId'] . ']');
            } else {
                $this->form_validation->set_rules('amCode', 'Area Code', 'required|exists[areamaster.amCode]');
                $this->form_validation->set_rules('amAreaName', 'Area Name', 'required|exists[areamaster.amAreaName]');
            }

            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['area_details'] = $area_details;
                $this->load->view('add_area', $data);
            } else {
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $area_details['amTS'] = mdate($format, $time);
                $area_details['amGuid'] = '851C5B71-4756-4404-8081-8EF51DD37DBD';
                if ($edit_mode) {
                    $id = $area_details['amId'];
                    unset($area_details['amId']);
                    $this->editArea($area_details, $id);
                } else {
                    $this->addArea($area_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('add_area', $data);
        }
    }

    function add_sub_area() {
        $edit_mode = FALSE;
        $sub_area_details = $this->input->post();
        if ($sub_area_details !== FALSE) {
            if (isset($sub_area_details['saId']) && $sub_area_details['saId'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('saSubAreaName', 'Sub Area Name', 'required|exist_among[subareaforrepmaster.saSubAreaName.saId.' . $sub_area_details['saId'] . ']');
            } else {
                $this->form_validation->set_rules('saSubAreaName', 'Sub Area Name', 'required|exists[subareaforrepmaster.saSubAreaName]');
            }
            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['sub_area_details'] = $sub_area_details;
                $this->load->view('sub_area_for_rep', $data);
            } else {
                $this->load->helper('date');
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $sub_area_details['saGuid'] = '851C5B71-4756-4404-8081-8EF51DD37DBD';
                $sub_area_details['saTS'] = mdate($format, $time);
                if ($edit_mode) {
                    $id = $sub_area_details['saId'];
                    unset($sub_area_details['saId']);
                    if ($this->list_model->updatesubAreaDet($sub_area_details, $id)) {
                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_sub_area';
                        $data['message'] = 'Subarea updated successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $this->load->view('sub_area_for_rep');
                    }
                } else {
                    if ($this->connection->addSubAreaForRep($sub_area_details)) {
                        //$data['methodeType'] = "add";
                        //$data['module'] = "Sub Area";
                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_sub_area';
                        $data['message'] = 'Subarea inserted successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $this->load->view('sub_area_for_rep');
                    }
                }
            }
        }
    }

    function add_division() {
        $edit_mode = FALSE;
        $division_details = $this->input->post();
        if ($division_details !== FALSE) {

            if (isset($division_details['dmId']) && $division_details['dmId'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('dmCode', 'Division Code', 'required|exist_among[divisionmaster.dmCode.dmId.' . $division_details['dmId'] . ']');
                $this->form_validation->set_rules('dmDivisionName', 'Division Name', 'required|exist_among[divisionmaster.dmDivisionName.dmId.' . $division_details['dmId'] . ']');
            } else {
                $this->form_validation->set_rules('dmCode', 'Division Code', 'required|exists[divisionmaster.dmCode]');
                $this->form_validation->set_rules('dmDivisionName', 'Division Name', 'required|exists[divisionmaster.dmDivisionName]');
            }

            $this->form_validation->set_rules('dmDescription', 'Description', 'max_length[300]');

            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['division_details'] = $division_details;
                $this->load->view('add_division', $data);
            } else {
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $division_details['dmTS'] = mdate($format, $time);
                $division_details['dmGuid'] = '851C5B71-4756-4404-8081-8EF51DD37DBD';
                if ($edit_mode) {
                    $id = $division_details['dmId'];
                    unset($division_details['dmId']);
                    $this->editDivision($division_details, $id);
                } else {
                    $this->addDivision($division_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('add_division', $data);
        }
    }

    function add_product() {
        $edit_mode = FALSE;

        $dbarray = $this->connection->get_dropdown_array_category('pmProductId', 'pmCategory', 'productlist', 'all');
        $divisionArray = $this->connection->get_dropdown_array_subArea('dmCode', 'dmDivisionName', 'divisionmaster');
        $data['divisionArray'] = $divisionArray;
        $data['dbArray'] = $dbarray;
        $product_details = $this->input->post();
        if ($product_details !== FALSE) {

            if (isset($product_details['pmProductId']) && $product_details['pmProductId'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('pmProductCode', 'Product Code', 'required|exist_among[productlist.pmProductCode.pmProductId.' . $product_details['pmProductId'] . ']');
                $this->form_validation->set_rules('pmProductName', 'Product Name', 'required|exist_among[productlist.pmProductName.pmProductId.' . $product_details['pmProductId'] . ']');
            } else {
                $this->form_validation->set_rules('pmProductCode', 'Product Code', 'required|exists[productlist.pmProductCode]');
                $this->form_validation->set_rules('pmProductName', 'Product Name', 'required|exists[productlist.pmProductName]');
            }

            //  $this->form_validation->set_rules('pmMRP', 'MRP', 'required');
            $this->form_validation->set_rules('pmCategory', 'Category', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['product_details'] = $product_details;
                $this->load->view('add_product', $data);
            } else {
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $product_details['pmTS'] = mdate($format, $time);
                if ($edit_mode) {
                    $id = $product_details['pmProductId'];
                    unset($product_details['pmProductId']);
                    $this->editProduct($product_details, $id);
                } else {
                    $this->addProduct($product_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('add_product', $data);
        }
    }

    function add_customer() {
        $edit_mode = FALSE;
        $store_details = $this->input->post();
        if ($store_details !== FALSE) {
            if (isset($store_details['smId']) && $store_details['smId'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('smStoreName', 'Customername', 'required|exist_among[storemaster.smStoreName.smId.' . $store_details['smId'] . ']');
                $this->form_validation->set_rules('smStoreCode', 'CustomerCode', 'required|exist_among[storemaster.smStoreCode.smId.' . $store_details['smId'] . ']');
            } else {
                $this->form_validation->set_rules('smStoreName', 'CustomerName', 'required|exists[storemaster.smStoreName]');
                $this->form_validation->set_rules('smStoreCode', 'CustomerCode', 'required|exists[storemaster.smStoreCode]');
            }

            $this->form_validation->set_rules('smAddress1', 'Address', 'required');
            $this->form_validation->set_rules('smPin', 'Pincode', 'numeric|min_length[6]');
            $this->form_validation->set_rules('smPhone1', 'Phone Number', 'numeric|min_length[10]');
            $this->form_validation->set_rules('smPhone2', 'Phone Number', 'numeric|min_length[10]');
            $this->form_validation->set_rules('smPhone3', 'Phone Number', 'numeric|min_length[10]');
            $this->form_validation->set_rules('smEmail', 'email', 'valid_email');
            if ($this->form_validation->run() === FALSE) {
                $data['store_details'] = $store_details;
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $this->load->view('add_customer', $data);
            } else {
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $store_details['smGuid'] = '851C5B71-4756-4404-8081-8EF51DD37DBD';
                $store_details['smTS'] = mdate($format, $time);
                if ($edit_mode) {
                    $id = $store_details['smId'];
                    unset($store_details['smId']);
                    if ($this->list_model->updateCustomer($store_details, $id)) {
                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_customers';
                        $data['message'] = 'updated successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Error while editing store details';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    }
                } else {
                    if ($this->connection->addCustomer($store_details)) {
                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_customers';
                        $data['message'] = 'Inserted successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Error while editing user details';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    }
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $customer_types = $this->list_model->get_customer_types();
            $data['types'] = generate_options($customer_types, 0, 0, '');
            $this->load->view('add_customer', $data);
        }
    }

    public function assign_users_for_projects($id) {
       // $group_ref = $this->input->post('group_ref');
         $users = $this->input->post('users');
         if ($users && sizeof($users)) {
             $projects = $this->list_model->simple_get('projectmaster', array('*'), array('project_id' => $id));
             $projects_data = $projects[0];
            // $task_data['is_group_task'] = 1;
            // $task_data['is_repeating'] = 0;
             $this->assign_users_to_projects($users, $projects_data);
             $data['assigned_persons'] = $this->task_model->get_assigned_users_to_projects(array('project_id' => $id));
             $this->load->view('tasks/assigned_persons', $data);
         }
     }

     private function assign_users_to_projects($users, $projects_data) {
        $user_data = $this->session->userdata('userdata');
        if (!$users || !sizeof($users)) {
            return;
        }
        $user_tasks = array();
        $today = date('Y-m-d');
        $j = 0;
            foreach ($users as $key => $value) {
                $user_tasks = array();

                $user_tasks['project_id'] = $projects_data['project_id'];
                $user_tasks['user_id'] = $user_data['umId'];
                $user_tasks['assigned_user_id'] = $value;
                $user_tasks['assigned_date'] = $today;     
              
                $exist_array = array('project_id' => $user_tasks['project_id'], 'assigned_user_id' => $value);
                if (!$this->list_model->is_exists('user_projects', $exist_array)) {
                    $this->list_model->insert('user_projects', $user_tasks);
                }
                $j++;
            }
    }

    function add_project() {
        $edit_mode = FALSE;
        $project_details = $this->input->post();
        // print_r($project_details);
        //$id = $project_details['project_id'];
        // unset($project_details['project_id']);
        unset($project_details['number-of-assigned-persons']);
        $users = isset($project_details['users']) ? $project_details['users'] : FALSE;
        unset($project_details['users']);
        unset($project_details['user_name']);
        $customer_details = $this->list_model->simple_get('storemaster',array('smId as id','smStoreName as name'));
        $department_details = $this->list_model->simple_get('departmentmaster',array('department_Id as id','department_name as name'));
        if ($project_details !== FALSE) {
            if (isset($project_details['project_id']) && $project_details['project_id'] !== '') {
                $edit_mode = TRUE;
                $data['customer_details'] = generate_options($customer_details, 0, 0);
                $data['department_details'] = generate_options($department_details, 0, 0);
                $this->form_validation->set_rules('project_name', 'ProjectName', 'required');
                $this->form_validation->set_rules('project_code', 'ProjectCode', 'required');
            } else {
                $this->form_validation->set_rules('project_name', 'ProjectName', 'required');
                $this->form_validation->set_rules('project_code', 'ProjectCode', 'required');
            }
            $data['customer_details'] = generate_options($customer_details, 0, 0, $project_details['customer_id']);
            $data['department_details'] = generate_options($department_details, 0, 0, $project_details['department_id']);

            if ($this->form_validation->run() === FALSE) { 
                $data['customer_details'] = $project_details;
                $data['department_details'] = $project_details;
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $this->load->view('add_projects', $data);
            } else {
                if ($edit_mode) {
                    $id = $project_details['project_id'];
                    unset($project_details['project_id']);
                    unset($project_details['users']);
                    unset($project_details['user_name']);
                    unset($project_details['number-of-assigned-persons']);
                    $result = $this->list_model->edit('projectmaster', $project_details, array('project_id' => $id));
                    $this->list_model->delete('user_projects', array('project_id' => $id)); 
                   // if ($this->list_model->updateproject($project_details, $id)) {
                    if ($result) {
                        if($project_details['customer_id'] !="select" || $project_details['department_id'] !="select"){
                            $project_details['project_id'] = $id;
                            $this->assign_users_for_projects($id);
                            $data['status'] = 'success';
                            $data['hash'] = 'listcontrol/show_projects';
                            $data['message'] = 'updated successfully';
                            header('Content-Type: application/json');
                            echo json_encode($data);
                            exit();
                        }else{
                            $data['status'] = 'error';
                            $data['message'] = 'Please select any one department or customer';
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        }
                    }else {
                        $data['status'] = 'error';
                        $data['message'] = 'Error while editing store details';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    }
                } else {
                    $userdata = $this->session->userdata('userdata');
                    $project_details['created_by'] = $userdata['umId'];
                    $project_details['created_date'] = date('Y-m-d H:m:s');
                    // print_r($project_details);
                        if($project_details['customer_id'] !="select" || $project_details['department_id'] !="select"){
                            if ($this->connection->addProject($project_details)) {
                            // print_r($project_details);
                            $id = $this->db->insert_id(); 
                            $this->assign_users_for_projects($id);
                            $data['status'] = 'success';
                            $data['hash'] = 'listcontrol/show_projects';
                            $data['message'] = 'Inserted successfully';
                            header('Content-Type: application/json');
                            echo json_encode($data);
                            exit();
                            } else {
                            $data['status'] = 'error';
                            $data['message'] = 'Error while editing user details';
                            header('Content-Type: application/json');
                            echo json_encode($data);
                            exit();
                            }
                        }
                        else{
                            $data['status'] = 'error';
                            $data['message'] = 'Please select any one department or customer';
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        }
                    }
                 }
        } else {
            $data['edit_mode'] = $edit_mode;
            $customer_types = $this->list_model->get_customer_types();
            $data['customer_details'] = generate_options($customer_details);
            $data['department_details'] = generate_options($department_details);
            $data['types'] = generate_options($customer_types, 0, 0, '');
            $this->load->view('add_projects', $data);
        }
    }
    public function edit_project($id) {
        $edit_mode = TRUE;
        if ($id != null) {
            $project_data = $this->list_model->projectDetById($id);
            foreach ($project_data->result() as $rows) {
                $project_id = $rows->project_id;
                $project_code = $rows->project_code;
                $project_name = $rows->project_name;
                $customer_details = $rows->customer_id;
                // print_r($customer_details);
                $budget = $rows->budget;
                $department_details = $rows->department_id;
                
            }
            if($customer_details > 0 ){
                $customer_name = $this->list_model->get_customer_name($customer_details);
                // print_r($customer_name);
            }
            $project_details = array(
                'project_id' => $project_id,
                'project_code' => $project_code,
                'project_name' => $project_name,
                'budget' => $budget
            );
            $data['project_details'] = $project_details;
            $data['edit_mode'] = TRUE;
            $customer_names = $this->list_model->get_customers();
            $department_names = $this->list_model->get_departments();
            $data['customer_details'] = generate_options($customer_names, 0, 0, $customer_details);
            $data['department_details'] = generate_options($department_names, 0, 0, $department_details);
            // $assigned_users = $this->task_model->get_assigned_users_to_projects($id);
            // $data['assigned_users'] = generate_options($assigned_users, 0, 0, $assigned_users);
            $data['assigned_persons'] = $this->task_model->get_assigned_users_to_projects(array('project_id' => $id)); 
            $this->load->view('add_projects', $data);
        }
    }

    public function edit_department($id) {
        $edit_mode = TRUE;
        if ($id != null) {
            $department_data = $this->list_model->departmentDetById($id);
            foreach ($department_data->result() as $rows) {
                $department_id = $rows->department_id;
                $department_code = $rows->department_code;
                $department_name = $rows->department_name;
                
            }
            $department_details = array(
                'department_id' => $department_id,
                'department_code' => $department_code,
                'department_name' => $department_name
            );
            $data['department_details'] = $department_details;
            $data['edit_mode'] = TRUE;
            $this->load->view('department/add_department', $data);
        }
    }

    function add_department() {
        $edit_mode = FALSE;
        $department_details = $this->input->post();
        //$id = $project_details['project_id'];
        // unset($project_details['project_id']);
        if ($department_details !== FALSE) {
            if (isset($department_details['department_id']) && $department_details['department_id'] !== '') {
                $edit_mode = TRUE;
                $this->form_validation->set_rules('department_name', 'DepartmentName', 'required');
                $this->form_validation->set_rules('department_code', 'DepartmentCode', 'required');
            } else {
                $this->form_validation->set_rules('department_name', 'DepartmentName', 'required');
                $this->form_validation->set_rules('department_code', 'DepartmentCode', 'required');
            }

            if ($this->form_validation->run() === FALSE) { 
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $this->load->view('department/add_department', $data);
            } else {
                if ($edit_mode) {
                    $id = $department_details['department_id'];
                    unset($department_details['department_id']);
                    $result = $this->list_model->edit('departmentmaster', $department_details, array('department_id' => $id));
                   // if ($this->list_model->updateproject($project_details, $id)) {
                    if ($result) {
                        $department_details['department_id'] = $id;
                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_departments';
                        $data['message'] = 'updated successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Error while editing store details';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    }
                } else {
                    $userdata = $this->session->userdata('userdata');
                    $department_details['created_by'] = $userdata['umId'];
                    $department_details['created_date'] = date('Y-m-d H:m:s');
                    if ($this->connection->addDepartment($department_details)) {
                        $id = $this->db->insert_id(); 
                        $data['status'] = 'success';
                        $data['hash'] = 'listcontrol/show_departments';
                        $data['message'] = 'Inserted successfully';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    } else {
                        $data['status'] = 'error';
                        $data['message'] = 'Error while editing user details';
                        header('Content-Type: application/json');
                        echo json_encode($data);
                        exit();
                    }
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            $this->load->view('department/add_department', $data);
        }
    }

    function delete_sales_price($id) {

        if ($this->list_model->delete('sales_price', array("sales_price_id" => $id))) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_sales_price';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_customer_discount_group($id) {

        if ($this->list_model->delete('customer_discount_group', array("customer_discount_group_id" => $id))) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_customer_discount_group';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_customer_price_group($id) {

        if ($this->list_model->delete('customer_price_group', array("customer_price_group_id" => $id))) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_customer_price_group';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_customer($id) {

        if ($this->list_model->customerDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_customers';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_project($id) {

        if ($this->list_model->projectDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_projects';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_sub_area($id) {
        if ($this->list_model->subAreaDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_sub_area';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_area($id) {

        if ($this->list_model->areaDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_areas';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_branch($id) {

        if ($this->list_model->branchDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_branches';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_user($id) {

        if ($this->connection->deleteUser($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_users';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_product($id) {

        if ($this->list_model->productDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_products';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_division($id) {
        if ($this->list_model->divisionDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_divisions';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function delete_zone($id) {
        $this->load->model('list_model');
        if ($this->list_model->zoneDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_zones';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function getStoreMaster($type, $value = '', $subAreaId) {
        if ($type == 'all' && $value == 'searchstringMissing') {
            $result = $this->connection->getStoreData($subAreaId);
        } else {
            $result = $this->connection->searchStoreData($type, $value, $subAreaId);
        }
        $response = "";
        if ($result->num_rows() > 0) {
            $isEven = false;
            foreach ($result->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->smId . "\" />" . $row->smStoreName . "</td>";
                $response .= "<td class=\"second\">" . $row->smStorecode . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        $data['result'] = $result;
        $this->load->view('list_stores', $data);
    }

    function editUser($user_details) {
        $id = $user_details['umId'];
        unset($user_details['umId']);
        $this->load->model('list_model');
        if ($this->list_model->updateUserDetails($user_details, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_users';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing user details';
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        }
    }

    function getBranchMaster($type, $value = '') {

        if ($type == 'all') {
            $data = $this->connection->getBranchName();
        } else {
            $data = $this->connection->searchBranchData($type, $value);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->bmBranchID . "\" />" . $row->bmBranchName . "</td>";
                $response .= "<td class=\"second\">" . $row->bmBranchCode . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function security_user_access($privilegeValue) {
        if ($privilegeValue == 'direct') {
            
        }
        $data['isPrivilege'] = $privilegeValue;
        $this->load->view('security_user_access', $data);
    }

    function addZone($zone_data) {
        if ($this->connection->addZone($zone_data)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_zones';
            $data['message'] = 'Inserted Zone successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while inserting zone details';
            echo json_encode($data);
            exit();
        }
    }

    function addUser($user_data) {
        if ($this->connection->addUser($user_data)) {
            $id = $this->db->insert_id();  
            $this->privilegemodel->insert_default_role_privileges_to_user($id, $user_data['role_id']);
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_users';
            $data['message'] = 'Inserted User successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while inserting user details';
            echo json_encode($data);
            exit();
        }
    }

    function uploadProductList() {
        $error = array('error' => ' ');
        $this->load->view('uploadProduct_view', $error);
    }

    function getsubArea($value) {

        if ($value == 'all') {
            $data = $this->connection->getsubAreaName();
        } else {
            $data = $this->connection->searchsubAreaData($value);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->saId . "\" />" . $row->saSubAreaName . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function getZone($value) {


        if ($value == 'all') {
            $data = $this->connection->getZoneName();
        } else {
            $data = $this->connection->searchzoneData($value);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->zmId . "\" />" . $row->zmZoneName . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function getArea($value) {

        $userdata = $this->session->userdata('userdata');
        if ($value == 'all') {
            $data = $this->connection->getAreaName($userdata['umId']);
        } else {
            $data = $this->connection->searchareaData($value);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->amId . "\" />" . $row->amAreaName . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function getDivisionMaster($value) {
        $userdata = $this->session->userdata('userdata');

        if ($value == 'all') {
            $data = $this->connection->getDivisionName($userdata['umId']);
        } else {
            $data = $this->connection->searchdivisionData($value);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->dmId . "\" />" . $row->dmDivisionName . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function AllocateSubArea() {
        $bool = false;
        if ($this->input->post('txtSp') != "") {
            $data = array(
                'srsSalesRepId' => $this->input->post('hid_sp_id'),
                'srsSubAreaForRepId' => $this->input->post('subAreaList'),
                'srsGuid' => '851C5B71-4756-4404-8081-8EF51DD37DBD',
                'srsTS' => time()
            );
            if ($this->connection->addSalesRepToSubArea($data)) {
                $bool = true;
            }
        }
        if ($this->input->post('txtManager') != "") {
            $data = array(
                'mtsManagerId' => $this->input->post('hid_Manger_id'),
                'mtsSubAreaForRepId' => $this->input->post('subAreaList'),
                'mtsGuid' => '851C5B71-4756-4404-8081-8EF51DD37DBD',
                'mtsTS' => time()
            );
            if ($this->connection->addManagerToSubArea($data)) {
                $bool = true;
            }
        }
        if ($this->input->post('txtStore_name') != "") {
            $data = array(
                'stsStoreId' => $this->input->post('txtStore'),
                'stsSubAreaForRepId' => $this->input->post('subAreaList'),
                'stsGuid' => '851C5B71-4756-4404-8081-8EF51DD37DBD',
                'stsTS' => time()
            );
            if ($this->connection->addStoreToSubArea($data)) {
                $bool = true;
            }
        }
        $data = array();
        if ($bool == true) {
            $data['status'] = 'success';
            $data['hash'] = 'admin/sub_area_allocation';
            $data['message'] = 'The data saved successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Failed to save the data. Please Try again';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function showSubAreaAllocation($id) {
        $response = "";

        $data = $this->connection->getSubAreaAlloctionSalesRep($id);
//echo $this->db->last_query();
        if ($data->num_rows() > 0) {
            $response .= "<tr >"
                    . "<td >"
                    . "<a href=\"javascript:hideshowSalesRep();\">"
                    . "<span class=\"ui-icon ui-icon-circle-arrow-e\"></span>"
                    . "</a>"
                    . "</td>"
                    . "<td >SalesRep.(" . $data->num_rows() . " Items)"
                    . "</td>"
                    . "<td>"
                    . "</td>"
                    . "<td>"
                    . "</td>"
                    . "</tr>";
            $cnt = 0;
            foreach ($data->result() as $row) {
                $cnt = $cnt + 1;
                $response .= "<tr class='divSalesReps' >";
                $response .= "<td ></td>";
                $response .= "<td ><input type=\"hidden\" id=\"hidSalesrepId_" . $cnt . "\" value=\"" . $row->srsId . "\" />" . $row->umFirstName . ' ' . $row->umLastName . "</td>";
                $response .= "<td >" . $row->umUserCode . "</td>";
                $response .= "<td ><a href=\"javascript:deleteAllocation('hidSalesrepId_" . $cnt . "','salesRep')\">Delete</a></td>"
                        . "</tr>";
            }
        }

        $dataM = $this->connection->getSubAreaAlloctionManager($id);
        if ($dataM->num_rows() > 0) {

            $response .= "<tr>"
                    . "<td><a href='javascript:hideshowManager();'> "
                    . "<span class='ui-icon ui-icon-circle-arrow-e'></span> "
                    . "</a>"
                    . "</td>"
                    . "<td >Manager(" . $dataM->num_rows() . " Items)</td>"
                    . "<td>"
                    . "</td>"
                    . "<td>"
                    . "</td>"
                    . "</tr>";
            $cntM = 0;
            foreach ($dataM->result() as $row) {
                $cntM = $cntM + 1;
                $response .= "<tr class='divManagers'>";
                $response .= "<td></td>";
                $response .= "<td><input type='hidden' id='hidSAManagerId_" . $cntM . "'  value='" . $row->Id . "' />" . $row->FirstName . ' ' . $row->LastName . "</td>";
                $response .= "<td >" . $row->Code . "</td>";
                $response .= "<td><a href=\"javascript:deleteAllocation('hidSAManagerId_" . $cntM . "','manager')\">Delete</a></td>"
                        . "</tr>";
            }
        }
        $dataC = $this->connection->getSubAreaAlloctionCustomer($id);
        if ($dataC->num_rows() > 0) {
            $cntC = 0;
            $response .= "<tr>"
                    . "<td><a href='javascript:hideshowCustomer();'>"
                    . "<span class='ui-icon ui-icon-circle-arrow-e'></span>"
                    . "</a>"
                    . "</td>"
                    . "<td>Customer(" . $dataC->num_rows() . " Items)</td>"
                    . "<td>"
                    . "</td>"
                    . "<td>"
                    . "</td>"
                    . "</tr>";

            foreach ($dataC->result() as $row) {
                $cntC = $cntC + 1;
                $response .= "<tr class='divCustomers'>";
                $response .= "<td></td>";
                $response .= "<td><input type='hidden' id=\"hidSACustomerId_" . $cntC . "\" value='" . $row->Id . "' />" . $row->FirstName . "</td>";
                $response .= "<td>" . $row->Code . "</td>";
                $response .= "<td><a href=\"javascript:deleteAllocation('hidSACustomerId_" . $cntC . "','Customer')\">Delete</a></td>"
                        . "</tr>";
            }
        }
        echo $response;
    }

    function deleteSubAreaAllocation($Id, $type) {

        if ($this->connection->deleteSubAreaAllocation_model($Id, $type)) {
            echo true;
        }
    }

    function add_area_matrix_details($subAreaId, $zName, $zId, $aName, $aId, $dName, $dId) {
        $format = '%Y-%m-%d %H:%i:%s';
        $time = time();
        $data = array(
            'amxZoneId' => $zId,
            'amxAreaId' => $aId,
            'amxDivisionId' => $dId,
            'amxCode' => 'AreaM111',
            'amxSubAreaForRepId' => $subAreaId,
            'amxGuid' => 'noGuide',
            'amxTS' => mdate($format, $time)
        );

        if ($this->connection->addAreaMatrix($data)) {
            $this->showAreaMatrix($subAreaId);
        }
    }

    function showAreaMatrix($subAreaId) {
        $result = "";

        $data = $this->connection->getAreaMatrix($subAreaId);
        if ($data->num_rows() > 0) {
            $cnt = 0;
            foreach ($data->result() as $row) {
                $cnt = $cnt + 1;
                $result .= "<tr id='divAreamatrixHead_" . $cnt . "'>";
                $result .="<td>" . $row->zmZoneName . "</td>";
                $result .="<td>" . $row->amAreaName . "</td>";
                $result .="<td>" . $row->dmDivisionName . "</td>";
                $result .="<td><input type='button' class='btn btn-xs btn-danger' id=" . $row->amxId . " value='Remove' onclick='javascript:removeAreaMatrix(" . $row->amxId . "," . $subAreaId . ");'/></td>";
                $result .="</tr>";
            }
        }
        echo $result;
    }

    function removeAreaMatrixById($amxId, $subAreaId) {

        if ($data = $this->connection->removeAreaMatrixById_model($amxId)) {
            $this->showAreaMatrix($subAreaId);
        }
    }

    //function getProductsList($type, $value = '',$subAreaId) {
    function deleteAllProducts() {

        $this->connection->deleteallProducts();
    }

    function getLevelList() {

        $levels = $this->connection->getLevelMasterlist();
        $data['result'] = $levels;
        $this->load->view('level_list', $data);
    }

    function getUsersDetails($userType, $type, $searchString) {

        if ($type == 'all') {
            $user_details = $this->connection->getUserDetails($userType);
        } else {
            $user_details = $this->connection->searchUserDetails($userType, $type, $searchString);
        }
        $data['result'] = $user_details;
        $this->load->view('user_details', $data);
    }

    function insertUserAccess() {
        $userType = $this->input->post('ddlUserType');
        $userId = $this->input->post('hid_userId');
        $level = $this->input->post('ddlLevels');
        $allPages = FALSE;

        $formName = $this->input->post('hid_url');
        if ($formName == 'AllPages') {
            $allPages = TRUE;
        }
        if ($formName == 'SalesOrders' || $allPages == TRUE) {
            $formName = '/salesorder/view_sales_order';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/salesorder/create_sales_order';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
        }
        if ($formName == 'Allocations' || $allPages == TRUE) {
            $formName = '/listcontrol/show_sub_area';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/admin/sub_area_allocation';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/admin/area_matrix';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
        }
        if ($formName == 'Masters' || $allPages == TRUE) {
            $formName = '/listcontrol/show_users';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/listcontrol/show_customers';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/listcontrol/show_products';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/listcontrol/show_divisions';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/listcontrol/show_areas';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/listcontrol/show_zones';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
            $formName = '/listcontrol/show_branches';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
        }
        if ($formName == 'SecurityAccess' || $allPages == TRUE) {
            $formName = '/admin/security_user_access';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
        }
        if ($formName == 'Settings' || $allPages == TRUE) {
            $formName = '/common/change_password';
            $this->insertoDBSecurityAccess($userId, $formName, $level);
        }
        $this->insertoDBSecurityAccess($userId, $formName, $level);
        $this->SecurityUserAccess('previleged0DR4RE6SE');
    }

    function insertoDBSecurityAccess($userId, $formName, $level) {

        if ($this->connection->insertUserAccessDet($userId, $formName, $level)) {
            //$this->SecurityUserAccess('true');
        }
    }

    function SecurityUserAccess($privilegeValue) {
        if ($privilegeValue == 'direct') {
            
        }

        $isPrivileges = $privilegeValue;
        $data['isPrivilege'] = $isPrivileges;
        $data['status'] = 'success';
        $data['hash'] = 'admin/security_user_access/direct';
        $data['message'] = 'Updated successfully';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function editZone($zone_data, $id) {
        if ($this->list_model->updatezoneDet($zone_data, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_zones';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing area details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function editBranch($branch_data, $id) {
        if ($this->list_model->updatebranchDet($branch_data, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_branches';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing branch details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function editCategory($cat_data, $id) {
        $this->load->model('common_model');
        if ($this->common_model->addCategory($cat_data, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'admin/show_categories';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing category';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function editArea($area_data, $id) {

        if ($this->list_model->updateareaDet($area_data, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_areas';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing area details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function addArea($form_data) {
        if ($this->connection->addArea($form_data)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_areas';
            $data['message'] = 'Inserted successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing area details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function addBranch($branch_data) {
        if ($this->connection->addBranch($branch_data)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_branches';
            $data['message'] = 'Inserted successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing division details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function addCategory($cat_data) {
        $this->load->model('common_model');
        if ($this->common_model->addCategory($cat_data)) {
            $data['status'] = 'success';
            $data['hash'] = 'admin/show_categories';
            $data['message'] = 'Inserted successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while inserting category';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function addDivision($division_data) {
        if ($this->connection->addDivision($division_data)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_divisions';
            $data['message'] = 'Inserted successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing division details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function editDivision($division_data, $id) {
        if ($this->list_model->updateDivisionDet($division_data, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_divisions';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing division details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function addProduct($product_data) {
        if ($this->connection->addproductDet($product_data)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_products';
            $data['message'] = 'Inserted successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing product details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function editProduct($data, $id) {
        if ($this->list_model->updateproductDet($data, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_products';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing product details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function allocate() {
        $this->list_model->allocate();
        $data['status'] = 'success';
        $data['hash'] = 'admin/allocation';
        $data['message'] = 'Updated successfully';
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function allocation() {
        $data = array();
        $this->load->view('allocation', $data);
    }

    function json_allocation() {
        $params = $_REQUEST;
        $columns = array(
            'smStoreCode',
            'smStoreName',
            'rep_name',
            'smCity',
            'customer_group',
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
        $data = $this->list_model->get_allocation_table($params['start'], $params['length'], $columns[$params['order'][0]['column']], $params['order'][0]['dir'],$search);
//echo $this->db->last_query();
        if ($data['result']) {
            $a_tag = '<a href="%s">Change</a>';
            foreach ($data['result'] as $key => $row) {
                $data['result'][$key]['c'] = sprintf($a_tag, base_url() . "#admin/change_allocation/" . $row['smId']);
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

    function change_allocation($storeId) {

        $this->load->model('PrivilegeModel');

        $store_details = $this->input->post();
        $form_data = $this->list_model->get_allocation(array('smId' => $storeId));
        $data['rep'] = $this->PrivilegeModel->simple_get('usermaster', 'umFirstName,umLastName,umUserCode', array('umIsActive' => 1, 'umStoreId' => NULL));
        $data['branches'] = $this->PrivilegeModel->simple_get('branchmaster', 'bmBranchName,bmBranchCode');

        $data['form_data'] = $form_data[0];
        if ($store_details !== FALSE) {
            $ret = $this->PrivilegeModel->update('storemaster', $store_details, array('smId' => $store_details['smId']));
            $data['status'] = 'success';
            $data['hash'] = 'admin/allocation';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['edit_mode'] = TRUE;

            $this->load->view('change_allocation', $data);
        }
    }

    function t() {
        $this->load->model('common_model');
        $this->common_model->orderSuccessMail(3, 6, 8);
    }

    function show_categories() {
        $this->load->model('common_model');
        $data['categories'] = $this->common_model->getCategories();
        $this->load->view('list_category', $data);
    }

    function create_doctor() {
     $edit_mode = FALSE;
        $doctor_details = $this->input->post();
        
        if ($doctor_details !== FALSE) {

            if (isset($doctor_details['dmid']) && $doctor_details['dmid'] !== '') { // edit
                $edit_mode = TRUE;
                $this->form_validation->set_rules('dmDoctorCode', 'Doctor Code', 'required|exist_among[doctormaster.dmDoctorCode.dmid.' . $doctor_details['dmid'] . ']');
                $this->form_validation->set_rules('dmDoctorName', 'Doctor Name', 'required|exist_among[doctormaster.dmDoctorName.dmid.' . $doctor_details['dmid'] . ']');
            } else {
                $this->form_validation->set_rules('dmDoctorCode', 'Doctor Code', 'required|exists[doctormaster.dmDoctorCode]');
                $this->form_validation->set_rules('dmDoctorName', 'Doctor Name', 'required|exists[doctormaster.dmDoctorName]');
            }

            if ($this->form_validation->run() == FALSE) {
                $data['edit_mode'] = $edit_mode;
                $data['error'] = $this->form_validation->error_array();
                $data['doctor_details'] = $doctor_details;
                $this->load->view('add_doctor', $data);
            } else {
                $format = '%Y-%m-%d %H:%i:%s';
                $time = time();
                $doctor_details['dmCreationDate'] = mdate($format, $time);
                if(isset($doctor_details['dmIsActive'])){
                    $doctor_details['dmIsActive']=1;
                }else{
                    $doctor_details['dmIsActive']=0;
                }
               
                if ($edit_mode) {
                    $id = $doctor_details['dmid'];
                    unset($doctor_details['dmid']);
                    $this->editDoctor($doctor_details, $id);
                } else {
                    $this->addDoctor($doctor_details);
                }
            }
        } else {
            $data['edit_mode'] = $edit_mode;
            
            $this->load->view('add_doctor', $data);
        } 
    }
    function addDoctor($doctor_details) {
        
        if ($this->connection->addDoctor($doctor_details)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_doctors';
            $data['message'] = 'Inserted successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing doctor details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
    function editDoctor($branch_data, $id) {
        if ($this->list_model->updatedoctorDet($branch_data, $id)) {
            $data['status'] = 'success';
            $data['hash'] = 'listcontrol/show_doctors';
            $data['message'] = 'Updated successfully';
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Error while editing doctor details';
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
    function delete_doctor($id) {

        if ($this->list_model->doctorDelete($id)) {
            $data['status'] = 'success';
        } else {
            $data['status'] = 'error';
        }
        $data['hash'] = 'listcontrol/show_doctors';
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    

}
