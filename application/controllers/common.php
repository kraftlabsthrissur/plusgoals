<?php

/**
 *
 * @property common_model $common_model Description
 *          
 */
class Common extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('connection');
    }

    public function index() {
        $data = array();
        $this->load->model('privilegemodel');
        $user = $this->session->userdata('userdata');
        $role = $this->privilegemodel->simple_get('roles', 'role_name', array(
            'role_id' => $user['role_id']
        ));
        $user['role'] = $role[0]['role_name'];
        $data['user'] = $user;
        $this->load->view('includes/global', $data);
    }

    public function dashboard() {
        $data = array();
       // $data['new_orders'] = $this->connection->count_new_orders();
       // $data['new_customers'] = $this->connection->count_new_customers();
       // $data['new_products'] = $this->connection->count_new_products();
        $data['new_task'] = $this->connection->count_new_orders();
        $data['percentage_completed'] = $this->connection->count_new_customers();
        $data['users'] = $this->connection->count_new_users();
        $data['new_communication'] = $this->connection->count_new_communication();
        $data['partial_orders'] = $this->connection->count_orders('sosIsPartial');
        $data['pending_orders'] = $this->connection->count_orders('sosIsPending');
        $data['processing_orders'] = $this->connection->count_orders('sosIsInProcess');
        $data['suspended_orders'] = $this->connection->count_orders('sosIsSuspended');
        $data['cancelled_orders'] = $this->connection->count_orders('sosIsCancelled');
        $data['completed_orders'] = $this->connection->count_orders('sosIsCompleted');

        $divisionwise_sales = $this->connection->divisionwise_sales();
        $i = 0;
        $flag = true;
        $fields = $report = $xkeys = $ykeys = $labels = $line_colors = array();
        if ($divisionwise_sales) {
            foreach ($divisionwise_sales as $key => $value) {
                foreach ($value as $keys => $items) {
                    $fields[] = $keys;
                }
                break;
            }
            foreach ($fields as $key => $value) {
                if ($key === 0) {
                    continue;
                }
                foreach ($divisionwise_sales as $keys => $items) {
                    $report[$key - 1]['y'] = $key;
                    $report[$key - 1][$divisionwise_sales[$keys]['y']] = $divisionwise_sales[$keys][$value];
                    if ($key === 1) {
                        $ykeys[] = $divisionwise_sales[$keys]['y'];
                        $labels[] = $divisionwise_sales[$keys]['y'];
                        $line_colors[] = '#' . $this->random_color();
                    }
                }
            }
        }
        $data['divisionwise_sales'] = $report;
        $data['ykeys'] = $ykeys;
        $data['labels'] = $labels;
        $data['line_colors'] = $line_colors;
        $this->load->view('dashboard', $data);
        // echo $_SERVER['HTTP_X_REQUESTED_WITH'];
    }

    function random_color_part() {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    function getProductAutocomplete() {
        $category = $_GET['category'];
        $term = $_GET['term'];
        $sales_type = isset($_GET['sales_type']) ? $_GET['sales_type'] : '';
        // if($category != -1) {
        $categoryName = urldecode($category);
        $this->load->model('connection');
        $jsarray = $this->connection->getProductsAutocomplete($categoryName, $term, $sales_type);
        echo json_encode($jsarray);
        // }
    }

    function getAreaAutocomplete() {
        $isHo = 'false';
        $AllType = $_GET['AllType'];
        $userdata = $this->session->userdata('userdata');
        if ($userdata['umIsHOUser'] && $AllType != 'no') {
            $isHo = 'true';
        }
        $value = $_GET['values'];
        $term = $_GET['term'];
        // if($category != -1) {
        $value = urldecode($value);
        $this->load->model('connection');
        $jsarray = $this->connection->getAreasAutocomplete($userdata['umId'], $value, $term, $isHo);
        echo json_encode($jsarray);
        // }
    }

    function getDivisionAutocomplete() {
        $isHo = 'false';
        $AllType = $_GET['AllType'];
        $userdata = $this->session->userdata('userdata');
        if ($userdata['umIsHOUser'] && $AllType != 'no') {
            $isHo = 'true';
        }
        $value = $_GET['values'];
        $term = $_GET['term'];
        // if($category != -1) {
        $value = urldecode($value);
        $this->load->model('connection');
        $jsarray = $this->connection->getDivisionAutocomplete($userdata['umId'], $value, $term, $isHo);
        // die($jsarray);
        echo json_encode($jsarray);
        // }
    }

    function getCustomerAutocomplete() {
        $areaId = $_GET['values'];
        $divId = $_GET['divId'];
        $term = $_GET['term'];
        $this->load->model('connection');
        // if($areaId != '' && $divId != ''){
        $jsarray = $this->connection->getCustomerAutocomplete($userdata['umId'], $areaId, $divId, $term);
        echo json_encode($jsarray);
        // }
        // }
    }

    function getArea($value, $alltype = '') {
        $this->session->unset_userdata('SOList');
        $userdata = $this->session->userdata('userdata');
        $LoggedIn = $this->session->userdata('LoggedIn');
        $this->load->model('connection');
        if ($value == 'all') {
            $data = $this->connection->getAreaName($userdata['umId']);
        } else {
            $data = $this->connection->searchareaData($value);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;

            if ($LoggedIn !== FALSE) {
                if ($alltype != '') {
                    $response .= "<tr class=\"even\"><td class=\"first\"><input type=\"hidden\" value=\"-2\" />ALL</td><td class=\"last\"></td></tr>";
                }
            }
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

    function getDivisionMaster($value, $alltype = '') {
        $this->session->unset_userdata('SOList');
        $userdata = $this->session->userdata('userdata');
        $LoggedIn = $this->session->userdata('LoggedIn');
        $this->load->model('connection');
        if ($value == 'all') {
            $data = $this->connection->getDivisionName($userdata['umId']);
        } else {
            $data = $this->connection->searchdivisionData($value);
        }
        $response = "";
        if ($data->num_rows() > 0) {
            $isEven = false;
            if ($LoggedIn !== FALSE) {
                if ($alltype != '') {
                    $response .= "<tr class=\"even\"><td class=\"first\"><input type=\"hidden\" value=\"-2\" />ALL</td><td class=\"last\">-2</td></tr>";
                }
            }
            foreach ($data->result() as $row) {
                if ($isEven) {
                    $response .= "<tr class=\"even\">";
                    $isEven = false;
                } else {
                    $response .= "<tr>";
                    $isEven = true;
                }
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->dmId . "\" />" . $row->dmDivisionName . "</td>";
                $response .= "<td class=\"last\">" . $row->dmCode . "</td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function getStoreMaster($type, $value = '', $areaId, $divId, $alltype = '') {
        $this->load->model('connection');
        $userdata = $this->session->userdata('userdata');
        $LoggedIn = $this->session->userdata('LoggedIn');
        $response = "";
        // die($areaId.'--'.$divId);
        if ($areaId == - 2 && $divId == - 2) {
            $result = '';
            if ($LoggedIn !== FALSE) {
                if ($alltype != '') {

                    $response .= "<tr class=\"even\"><td class=\"first\"><input type=\"hidden\" value=\"-2\" />ALL</td><td class=\"last\">-2</td></tr>";
                }
            }
        } else {
            if ($areaId != - 2 && $divId == - 2) {
                if ($type == 'all' && $value == 'searchstringMissing') {
                    $result = $this->connection->getStoreDataByArea($userdata['umId'], $areaId);
                    // getStoreDataByArea($userId,$areaId,$divCode)
                } else {
                    $result = $this->connection->searchStoreDataByArea($type, $value, $areaId);
                }
            } else {
                if ($type == 'all' && $value == 'searchstringMissing') {
                    $result = $this->connection->getStoreDataByArea($userdata['umId'], $areaId, $divId);
                    // getStoreDataByArea($userId,$areaId,$divCode)
                } else {
                    $result = $this->connection->searchStoreDataByArea($type, $value, $areaId);
                }
            }
        }
        $data['result'] = $result;
        $this->load->view('list_stores', $data);
    }

    function getProductsList($categoryName, $type = '', $searchstring = '') {
        $categoryName = urldecode($categoryName);
        $this->load->model('connection');
        if ($type == '' && $searchstring == '') {
            $data = $this->connection->getProductslist($categoryName);
        } else {
            $data = $this->connection->searchProductData($categoryName, $type, $searchstring);
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
                $response .= "<td class=\"first\"><input type=\"hidden\" value=\"" . $row->pmProductId . "\" /><input type=\"hidden\" id=\"hidMRP_" . $row->pmProductId . "\" value=\"" . $row->pmMRP . "\" />" . $row->pmProductName . "</td>";
                $response .= "<td class=\"second\">" . $row->pmProductCode . "</td>";
                $response .= "<td class=\"last\"></td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function change_password() {
        $userdata = $this->session->userdata('userdata');
        $this->load->view('change_password');
    }

    function changePasswd() {
        $userdata = $this->session->userdata('userdata');
        $password_details = $this->input->post();
        $this->form_validation->set_rules('txtCurrentPasswd', 'Old Password', 'required|callback_txtCurrentPasswd_check');
        $this->form_validation->set_rules('txtNewPasswd', 'New Password', 'required|matches[txtConfirmPasswd]|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('txtConfirmPasswd', 'Confirm Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = $this->form_validation->error_array();
            $this->load->view('change_password', $data);
        } else {
            $newPasswd = $this->input->post('txtNewPasswd');
            $id = $userdata['umId'];
            $this->load->model('common_model');
            if ($this->common_model->updatePassword($newPasswd, $id)) {
                $data['status'] = 'success';
                $data['hash'] = 'common/dashboard';
                $data['message'] = 'Password Cahnged Successfully';
                header('Content-Type: application/json');
                echo json_encode($data);
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Error while changing password';
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }
    }

    public function txtCurrentPasswd_check($str) {
        $passwd = $this->input->post('txtCurrentPasswd');
        $userdata = $this->session->userdata('userdata');
        $id = $userdata['umId'];
        $this->load->model('common_model');
        $data = $this->common_model->checkPasswd($passwd, $id);
        foreach ($data->result() as $row) {
            if ($row->cnt > 0) {
                return TRUE;
            } else {
                $this->form_validation->set_message('txtCurrentPasswd_check', 'The Old password is incorrect.');
                return FALSE;
            }
        }
    }

    private function isProductExists($val, array $arr, $sessionVal) {
        if (sizeof($arr) > 0) {
            foreach ($arr as $a) {
                // if (stripos($str,$a) !== false) return true;
                if ($a[$sessionVal] == $val)
                    return true;
            }
        }
        return false;
    }

    public function setSOList($productId, $qty, $offer) {
        $soList = $this->session->userdata('SOList');
        if ($soList == null) {
            $soList = array();
        }
        if (!$this->isProductExists($productId, $soList, 'productId')) {
            $item = array(
                'productId' => $productId,
                'qty' => $qty,
                'offer' => $offer
            );
            array_push($soList, $item);
            $this->session->set_userdata('SOList', $soList);
            echo TRUE;
        } else {
            $arraySO = $soList;
            // $val = $soList;
            for ($i = 0; $i < sizeof($soList); $i ++) {
                if ($arraySO[$i]["productId"] == $productId) {
                    $idx = $i;
                    $val = $arraySO[$i];
                }
            }
            $val['productId'] = $productId;
            $val['qty'] = $qty;
            $val['offer'] = $offer;
            $arraySO[$idx] = $val;
            // $soList = '';
            $soList = array();
            $soList = $arraySO;
            $this->session->set_userdata('SOList', $soList);
            echo true;
        }
    }

    public function seteditSOListSess($productId, $qty, $offer) {
        $editSOList = $this->session->userdata('editSo');
        if ($editSOList == FALSE) {
            $editSOList = array();
        }
        if (!$this->isProductExists($productId, $editSOList, 'productId')) {
            $item = array(
                'productId' => $productId,
                'productCode' => '',
                'productName' => '',
                'Category' => '',
                'qty' => $qty,
                'offer' => $offer,
                'Mrp' => '',
                'Amount' => ''
            );
            array_push($editSOList, $item);
            $this->session->set_userdata('editSo', $editSOList);
        } else {
            $arraySo = $editSOList;
            for ($i = 0; $i < sizeof($editSOList); $i ++) {
                if ($arraySo[$i]["productId"] == $productId) {
                    $idx = $i;
                    $val = $arraySo[$i];
                }
            }
            $val['productId'] = $productId;
            $val['qty'] = $qty;
            $val['offer'] = $offer;
            $arraySo[$idx] = $val;

            $editSOList = array();
            $editSOList = $arraySo;
            $this->session->set_userdata('editSo', $editSOList);
        }
    }

    public function removeSOList($productId) {
        $soList = $this->session->userdata('SOList');
        $new = $soList;
        $isRemove = false;
        if (sizeof($soList) > 0) {
            foreach ($soList as $so => $value) {
                if ($value['productId'] == $productId) {
                    unset($new[$so]);
                    $isRemove = true;
                }
            }
        }
        // var_dump($new);
        $this->session->set_userdata('SOList', $new);
        echo $isRemove;
    }

    function setSOListByMRep($mode, $date, $amount, $chequeNo, $bank, $remark = '') {
        if ($mode == 'Cash') {
            $this->load->model('common_model');
            $receiptNo = $this->common_model->isReceiptNoExists($chequeNo);
            if ($receiptNo->num_rows() > 0) {
                foreach ($receiptNo->result() as $row) {
                    $recpNoCnt = $row->cnt;
                }
                if ($recpNoCnt > 0) {
                    echo false;
                }
            }
        }
        $soListMSR = $this->session->userdata('SOListMSR');
        if ($soListMSR == null) {
            $soListMSR = array();
        }
        if (!$this->isProductExists($chequeNo, $soListMSR, 'chequeNo')) {
            $item = array(
                'chequeNo' => $chequeNo,
                'mode' => $mode,
                'date' => $date,
                'amount' => $amount,
                'bank' => $bank,
                'remark' => $remark
            );
            array_push($soListMSR, $item);
            $this->session->set_userdata('SOListMSR', $soListMSR);
            echo TRUE;
        } else {
            echo false;
        }
    }

    function removeSOMSRList($chqNoId) {
        $soListMSR = $this->session->userdata('SOListMSR');
        $newMSR = $soListMSR;
        $isRemove = false;
        if (sizeof($soListMSR) > 0) {
            foreach ($soListMSR as $soSR => $value) {
                if ($value['chequeNo'] == $chqNoId) {
                    unset($newMSR[$soSR]);
                    $isRemove = true;
                }
            }
        }
        $this->session->set_userdata('SOListMSR', $newMSR);
        echo $isRemove;
    }

    function removeEditSOList($productId) {
        $editSoList = $this->session->userdata('editSo');
        $new = $editSoList;
        $isRemove = false;
        if (sizeof($editSoList) > 0) {
            foreach ($editSoList as $so => $value) {
                if ($value['productId'] == $productId) {
                    unset($new[$so]);
                    $isRemove = true;
                }
            }
        }
        $this->session->set_userdata('editSo', $new);
        echo $isRemove;
    }

    function saveSalesOrderMSR($divId, $store, $amount) {
        $userdata = $this->session->userdata('userdata');
        $SRId = 0;
        $managerId = 0;
        if ($userdata !== FALSE && $userdata['umIsSalesRep'] == 1) {
            $SRId = $userdata['umId'];
        } else if ($userdata['umIsManager']) {
            $managerId = $userdata['umId'];
        }
        $this->load->model('common_model');
        $branchIds = $this->common_model->getBranchIdByStoreId($store);
        if ($branchIds->num_rows() > 0) {
            foreach ($branchIds->result() as $row) {
                $branchId = $row->bmBranchID;
            }
        }
        $summaryId = $this->common_model->saveToStoreAmountCollectionSummary($store, $SRId, $managerId, $branchId, $amount, $divId);
        if ($summaryId->num_rows() > 0) {
            foreach ($summaryId->result() as $sum) {
                $sumId = $sum->scsID;
            }
            $soListMSR = $this->session->userdata('SOListMSR');
            if (sizeof($soListMSR) > 0) {
                foreach ($soListMSR as $a) {
                    $chqNo = $a['chequeNo'];
                    $mode = $a['mode'];
                    $date = $a['date'];
                    $amount = $a['amount'];
                    $bank = $a['bank'];
                    $remark = $a['remark'];
                    $this->common_model->saveToStoreAmountCollectionDetails($sumId, $mode, $amount, $chqNo, $date . ' 00:00:00', $bank, $remark);
                }
            }
            $this->session->unset_userdata('SOListMSR');
        }
    }

    function getSOProductDetails() {
        $editSoList = $this->session->userdata('editSOList');
        $response = '';
        if ($editSoList != null) {
            if (sizeof($editSoList) > 0) {

                foreach ($editSoList as $a) {
                    $response .= '<tr>';
                    $response .= '<td class="colName">' . $a['productName'] . '</td>';
                    $response .= '<td class="colCateg">' . $a['Category'] . '</td>';
                    $response .= '<td class="colQty">' . $a['qty'] . '</td>';
                    $response .= '<td class="colOffer">' . $a['offer'] . '</td>';
                    $response .= '<td class="colMRP">' . $a['Mrp'] . '</td>';
                    $response .= '<td class="colAmount amt">' . $a['Amount'] . '</td>';
                    $response .= '<td class="colcloseval">';
                    $response .= '<input type="button" class="btn btn-small btn-danger" onclick="remove_SO_item(' . $a['productId'] . ');" value="REMOVE" />';
                    $response .= '<input type="hidden" id="' . $a['ProductID'] . '" /></td>';
                    $response .= '</tr>';
                }
            }
        }
        echo $response;
    }

    function getProducts($id) {
        $response = '';
        $this->load->model('common_model');
        $dataSoDet = $this->common_model->getViewSODetails($id);
//echo $this->db->last_query();

        if ($dataSoDet->num_rows() > 0) {
            foreach ($dataSoDet->result() as $results) {
                $response .= '';
                //$this->seteditSOListSess($results->sodProductID, $results->sodQty, $results->sodOfferQty);
                $qt = $results->sodQty;
                $q = explode(".", $results->sodQty);
                $of = explode(".", $results->sodOfferQty);
                $response .= '<tr>';
                $response .= '<td class="colName">' . $results->sodProductName . '</td>';
                $response .= '<td class="colCateg" >' . $results->sodCategory . '</td>';
                $response .= '<td class="colQty">' . $q[0] . '</td>';
                $response .= '<td class="colOffer">' . $of[0] . '</td>';
                $response .= '<td class="colMRP">' . $results->sodMRP . '</td>';
                $response .= '<td class="colAmount amt">' . $results->sodAmount . '</td>';
                $response .= '<td class="colcloseval">';
                $response .= '<input type="button" class="btn btn-xs btn-danger" onclick="javascript:remove_SO_item(' . $results->sodProductID . ');" value="Remove" />';
                $response .= '<input type="hidden" id="' . $results->sodProductID . '" /></td>';
                $response .= '</tr>';
            }
        }
        echo $response;
    }

    function getSOComm($summaryId) {
        $this->load->model('common_model');
        $data = $this->common_model->getSOCommunication($summaryId);
        $response = "";
        if ($data->num_rows() > 0) {

            $cnt = 0;
            foreach ($data->result() as $row) {
                $cnt ++;
                $response .= "<tr>";
                $date_string = $row->socreationDate;
                $response .= "<td class=\"first\" id=\"comdate\">" . $date_string . "</td>";
                $response .= "<td class=\"second\"id=\"comname\">" . $row->umUserName . "</td>";
                $response .= "<td class=\"last\"id=\"comdsptn_" . $cnt . "\">" . $row->socLogDescription;
            }
            $status = $this->common_model->getSummaryStatus($summaryId);
            if ($status->num_rows() > 0) {
                foreach ($status->result() as $res) {
                    if ($res->status != null) {
                        $response .= "<input type=\"hidden\" id=\"hid_status\" value=" . $res->status . " />";
                    } else {
                        $response .= "<input type=\"hidden\" id=\"hid_status\" />";
                    }
                }
            }
            $response .= "</td></tr>";
        } else {
            $response = "<tr><td colspan=\"3\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function saveSOComm($summaryId, $txtComment, $field = '') {
        $userdata = $this->session->userdata('userdata');
        $field1 = 'sosIsInProcess';
        $field2 = 'sosIsSuspended';
        $field3 = 'sosIsCompleted';
        $value = 1;
        if ($txtComment == 'NA') {
            $txtComment = '';
        }
        $txtComment = trim(str_replace("%20", ' ', $txtComment));
        $userId = $userdata['umId'];
        $this->load->model('common_model');
        if ($this->common_model->saveSOCommunication($summaryId, $userId, $txtComment) && $field != null) {
            if ($field == 'sosIsInProcess') {
                $field1 = 'sosIsPending';
            } else if ($field == 'sosIsSuspended') {
                $field2 = 'sosIsPending';
            } else if ($field == 'sosIsCompleted') {
                $field3 = 'sosIsPending';
            } else if ($field == 'uncheckall') {
                $field = 'sosIsConfirmed';
                $value = 1;
            } else {
                
            }
            $this->common_model->updateSOSummary($field, $field1, $field2, $field3, $value, $summaryId);
        }
    }

    function getSOCollection($StoreID, $DivisionId) {
        $this->load->model('common_model');
        $data = $this->common_model->getSOCollectionById($StoreID, $DivisionId);
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
                $date_string = $row->scsCollectionDate;

                $cheque_date = $row->scdChequeDate;
                $response .= "<td class=\"colVal1\" id=\"dat\">" . $date_string . "</td>";
                $response .= "<td class=\"colVal1\"id=\"check\">" . $cheque_date . "</td>";
                $response .= "<td class=\"colVal1\"id=\"cmode\">" . $row->scdCollectionMode . "</td>";
                $response .= "<td class=\"colVal1\"id=\"bank\">" . $row->scdDDChequeNo;
                if ($row->scdChequeBank != '' || $row->scdChequeBank != null) {
                    $response .= "/" . $row->scdChequeBank . "";
                }
                $response .= "</td>";
                $response .= "<td class=\"colVal1\" id=\"amount\">" . $row->scdAmount . "</td>";
                $response .= "<td class=\"colValLast\" id=\"remarks\">" . urldecode($row->scdRemarks) . "</td></tr>";
            }
        } else {
            $response = "<tr><td colspan=\"6\">Sorry no result.</td></tr>";
        }
        echo $response;
    }

    function cancelSalesOrder($summaryId) {
        $this->load->model('common_model');
        // die($summaryId);
        if ($this->common_model->cancelSalesOrder($summaryId)) {
            echo true;
        }
    }

    function getCategories($divId) {
        if ($divId != null) {
            $this->load->model('connection');
            $result = $this->connection->get_dropdown_array_category('pmProductId', 'pmCategory', 'productlist', $divId);
//echo $this->db->last_query();
            $data['dbarray'] = $result;
            // var_dump($data['dbarray']);
            $this->load->view('ddl', $data);
        }
    }

    
    function downloadSalesOrders($order_ids) {
        $this->load->model('common_model');
        $data = array();
        $order_id_array = explode('_', $order_ids);
        $sumDet = array();
        $data1 = array();
        foreach ($order_id_array as $key => $order_id) {
            $summaryData = $this->common_model->getSOSummaryBySummaryId($order_id);
            if ($summaryData->num_rows() > 0) {
                foreach ($summaryData->result() as $rows) {
                    $sumDet[$key] = array(
                        'StoreName' => $rows->smStoreName,
                        'StoreCode' => $rows->smStoreCode,
                        'Location' => $rows->smCity,
                        'Area' => $rows->amCode,
                        'SONo' => $rows->sosSONo,
                        'OrderBy' => $rows->OrderBy,
                        'UserCode' => $rows->umUserCode,
                        'Name' => $rows->NAME,
                        'Date' => $rows->sosBillDate,
                        'DivCode' => $rows->sosDivisionCode,
                        'DivName' => $rows->sosDivisionName,
                        'Despatch' => $rows->sosDespatch,
                        'NetAmt' => $rows->sosNetAmount
                    );
                }
            }
            $data['summary'] = $sumDet;
            $details = $this->common_model->getSOResults($order_id);
            if ($details->num_rows() > 0) {
                foreach ($details->result() as $row) {
                    $data1[$key][] = array(
                        'productId' => $row->sodProductID,
                        'productCode' => $row->sodProductCode,
                        'sodQty' => $row->sodQty,
                        'sodOfferQty' => $row->sodOfferQty,
                        'sodMRP' => $row->sodMRP,
                        'sodAmount' => $row->sodAmount
                    );
                }
            }
            $data['details'] = $data1;
        }

        $this->load->view('xml_view_multiple', $data);
    }

    function downloadSalesOrder($summaryId) {
        $this->load->model('common_model');
        // below line must uncomment later
        $this->common_model->updateDownloadStatus($summaryId);
        $summaryData = $this->common_model->getSOSummaryBySummaryId($summaryId);
        $sumDet = array();
        if ($summaryData->num_rows() > 0) {
            foreach ($summaryData->result() as $rows) {
                $sumDet = array(
                    'StoreName' => $rows->smStoreName,
                    'StoreCode' => $rows->smStoreCode,
                    //                 'Location' => $rows->smCity,
                    'SONo' => $rows->sosSONo,
                    'OrderBy' => $rows->OrderBy,
                    //                   'UserCode' => $rows->umUserCode,
                    'Name' => $rows->NAME,
                    'Date' => $rows->sosBillDate,
                    'DivCode' => $rows->sosDivisionCode,
                    'DivName' => $rows->sosDivisionName,
                    'Despatch' => $rows->sosDespatch,
                    'NetAmt' => $rows->sosNetAmount
                );
            }
        }
        $query['sumDet'] = $sumDet;
        $data = $this->common_model->getSOResults($summaryId);
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel ();

        $objPHPExcel->getProperties()->setCreator($this->config->item('app_name'));
        $objPHPExcel->getProperties()->setLastModifiedBy($this->config->item('app_name'));
        $objPHPExcel->getProperties()->setTitle("Order Details");
        $objPHPExcel->getProperties()->setSubject("Order Details");
        $objPHPExcel->getProperties()->setDescription("Order Details, generated using PHP classes.");
        $data1 = array();
        if ($data->num_rows() > 0) {

            foreach ($data->result() as $key => $row) {
                $data1[] = array(
                    'productId' => $row->sodProductID,
                    'productCode' => $row->sodProductCode,
                    'sodQty' => $row->sodQty,
                    'sodOfferQty' => $row->sodOfferQty,
                    'sodMRP' => $row->sodMRP,
                    'sodAmount' => $row->sodAmount,
                    'packingCode' => $row->packingCode
                );

                $objPHPExcel->getActiveSheet()->setCellValueExplicit('A' . ($key + 2), str_pad($row->packingCode, 4, '0', STR_PAD_LEFT), PHPExcel_Cell_DataType::TYPE_STRING);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . ($key + 2), $row->pmProductName);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . ($key + 2), $row->sodQty);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . ($key + 2), $sumDet['StoreCode']);
                $objPHPExcel->getActiveSheet()->getStyle("A" . ($key + 2) . ":D" . ($key + 2))->getFont()->setSize(10);
            }
        }

        $query['data1'] = $data1;

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Packing code');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Packing Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Quantity');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Party code');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFont()->setSize(10);



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="order-' . $summaryId . '.xls"');
        $objWriter->save('php://output');
    }

    function downloadSalesOrderCSV($summaryId) {
        $this->load->model('common_model');
        // below line must uncomment later
        $this->common_model->updateDownloadStatus($summaryId);
        $summaryData = $this->common_model->getSOSummaryBySummaryId($summaryId);
        $sumDet = array();
        if ($summaryData->num_rows() > 0) {
            foreach ($summaryData->result() as $rows) {
                $sumDet = array(
                    'StoreName' => $rows->smStoreName,
                    'StoreCode' => $rows->smStoreCode,
                    //                 'Location' => $rows->smCity,
                    'SONo' => $rows->sosSONo,
                    'OrderBy' => $rows->OrderBy,
                    //                   'UserCode' => $rows->umUserCode,
                    'Name' => $rows->NAME,
                    'Date' => $rows->sosBillDate,
                    'DivCode' => $rows->sosDivisionCode,
                    'DivName' => $rows->sosDivisionName,
                    'Despatch' => $rows->sosDespatch,
                    'NetAmt' => $rows->sosNetAmount
                );
            }
        }
        $query['sumDet'] = $sumDet;
        $data = $this->common_model->getSOResults($summaryId);
        $data1 = array();

        $fp = fopen('php://output', 'w');
        if ($data->num_rows() > 0) {

            foreach ($data->result() as $key => $row) {

                $fields = array(str_pad($row->packingCode, 4, '0', STR_PAD_LEFT), round($row->sodQty));
                fwrite($fp, implode(',', str_replace('"', '""', $fields)) . "\r\n");
            }
        }

        $query['data1'] = $data1;


        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="order-' . $summaryId . '.csv"');
    }

    function test() {
        echo str_pad("1234", 8, '0', STR_PAD_LEFT);
    }

    function categoryChange($categoryName) {
        $categoryName = urldecode($categoryName);
        $this->load->model('connection');
        $jsarray = $this->connection->getProductslist($categoryName);
        // pmProductId,pmProductCode,pmProductName,pmMRP
        // $jsarray = $this->connection->getStoreData();
        $javascript_array = "var availableTags = [";
        foreach ($jsarray->result() as $row) {
            $javascript_array .= "\"" . $row->pmProductName . "#" . $row->pmProductId . "\",";
        }
        $javascript_array = substr($javascript_array, 0, strlen($javascript_array) - 1);
        $javascript_array .= "];";
        echo $javascript_array;
    }

}
