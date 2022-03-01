<?php

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2014, Ajith Vp <ajith@kraftlabs.com>
 * @date 30-Dec-2014
 */

/**
 * @property common_model $common_model Description
 * 
 */
class SalesOrder extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('privilegemodel');
    } 

    public function getSalesOrderView() {
        $userdata = $this->session->userdata('userdata');
        $status = 'sosIsConfirmed';
        $OrderFromDate = $_POST['from'];
        $OrderToDate = $_POST['to'];
        $divName = $_POST['div'];
        $storeName = $_POST['store'];
        $areaName = $_POST['area'];
        $areaId = $_POST['areaId'];
        $divId = $_POST['divId'];
        $storeId = $_POST['storeId'];
        $status = $_POST['data'];
//die($areaId.'-'.$divId .'-'.$storeId);

        $str = "";
        $Unionstr = "";
//$data = '';
        if ($_POST['confirmST'] != 1) {
            $sosIsConfirmed = 0;
            $from = $OrderFromDate . ' ' . '00:00:00';
            $to = $OrderToDate . ' ' . '29:59:59';
            if ($_POST['newST'] != 0)
                $Unionstr = " and sosID in (select socSoSummaryId from socommunication where soCreationDate BETWEEN 
				'" . $OrderFromDate . "' AND '" . $OrderToDate . "') ORDER BY sosBillDate DESC,sosID DESC";
            else
                $Unionstr = " ORDER BY sosBillDate DESC ,sosID DESC";
            if ($_POST['partialST'] != 0)
                $str .= " AND sosIsPartial = 1";

            if ($_POST['completeST'] != 0)
                $str .= " AND sosIsCompleted = 1";

            if ($_POST['cancelST'] != 0)
                $str .= " AND sosIsCancelled = 1";

            if ($_POST['suspendST'] != 0)
                $str .= " AND sosIsSuspended = 1";

            if ($_POST['processST'] != 0)
                $str .= " AND sosIsInProcess = 1";

            if ($_POST['pendingST'] != 0)
                $str .= " AND sosIsPending = 1";
        }
        else {
            $str .= " AND sosIsConfirmed = 1 ";
            $Unionstr = " ORDER BY sosID DESC,sosBillDate DESC";
        }
        $viewSOData = array();
        $item = array(
            'OrderFromDate' => $OrderFromDate,
            'OrderToDate' => $OrderToDate,
            'divName' => $divName,
            'storeName' => $storeName,
            'status' => $status,
            'areaName' => $areaName,
            'areaId' => $areaId,
            'divId' => $divId,
            'storeId' => $storeId
        );
        array_push($viewSOData, $item);
        $this->session->set_userdata('viewSOList', $viewSOData);
        $response = '';

        $isAllowed = false;
        if (($areaId == '' || $areaId == -2) && ($divId == '' || $divId == -2) && ($storeId == '' || $storeId == -2)) {
            $result = $this->common_model->getAllDataforViewSODetails($OrderFromDate . ' ' . '00:00:00', $OrderToDate . ' ' . '23:59:59', $str, $Unionstr, $userdata['umId']);
            $isAllowed = true;
        }
        if ($areaId != '' && $divId != '' && $areaId != -2 && $divId != -2 && ($storeId == '' || $storeId == -2)) {
            $result = $this->common_model->getNoStoreAllDataforViewSODetails($OrderFromDate . ' ' . '00:00:00', $OrderToDate . ' ' . '23:59:59', $str, $Unionstr, $areaId, $divId);
            $isAllowed = true;
        }
        if (($areaId == '' || $areaId == -2) && $divId != '' && $divId != -2 && ($storeId == '' || $storeId == -2)) {
            $result = $this->common_model->getDivAllDataforViewSODetails($OrderFromDate . ' ' . '00:00:00', $OrderToDate . ' ' . '23:59:59', $str, $Unionstr, $divId, $userdata['umId']);
            $isAllowed = true;
        }
        if ($areaId != '' && $areaId != -2 && ($divId == '' || $divId == -2) && $storeId != '') {
            $result = $this->common_model->getNoDivDataforViewSODetails($OrderFromDate . ' ' . '00:00:00', $OrderToDate . ' ' . '23:59:59', $str, $Unionstr, $storeId);
            $isAllowed = true;
        }
        if ($areaId != '' && $areaId != -2 && ($divId == '' || $divId == -2) && ($storeId == '' || $storeId == -2)) {
            $result = $this->common_model->getAllAreaDataforViewSODetails($OrderFromDate . ' ' . '00:00:00', $OrderToDate . ' ' . '23:59:59', $str, $Unionstr, $areaId);
            $isAllowed = true;
        }

        if ($areaId != -2 && $divId != -2 && $storeId != -2 && $areaId != '' && $divId != '' && $storeId != '') {
            $result = $this->common_model->getDataforViewSODetails($OrderFromDate . ' ' . '00:00:00', $OrderToDate . ' ' . '23:59:59', $areaId, $divId, $storeId, $str, $Unionstr);
            $isAllowed = true;
        }
        if ($areaId == -2 && $divId == -2 && $storeId == -2 && $userdata['umIsHOUser'] == 1) {
            $result = $this->common_model->getAllDataforViewSODetails($OrderFromDate . ' ' . '00:00:00', $OrderToDate . ' ' . '23:59:59', $str, $Unionstr, $userdata['umId']);
            $isAllowed = true;
        }
        if ($isAllowed != true) {
            $result = '';
        }
      //  echo $this->db->last_query();
        $data['result'] = $result;
        $this->load->view('list_sales_orders', $data);
    }

    function view_sales_order() {
        $userdata = $this->session->userdata('userdata');
        $this->session->unset_userdata('editSOList');
        $this->session->unset_userdata('editSO');
        $this->session->unset_userdata('SOList');
        $this->session->unset_userdata('SOListMSR');
       
        $viewSOList = array();
        $viewSOList = $this->session->userdata('viewSOList');
//print_r($viewSOList);
        $details = array();
        $details['OrderFromDate'] = date('Y-m-d', mktime(0, 0, 0, date('m'), '1', date('Y')));
        $details['OrderToDate'] = date('Y-m-d', mktime(0, 0, 0, date('m'), date('t'), date('Y')));
        $details['divName'] = '';
        $details['storeName'] = '';
        $details['status'] = '';
        $details['areaName'] = '';
        $details['areaId'] = '';
        $details['divId'] = '';
        $details['storeId'] = '';
        if ($viewSOList != FALSE) {
            if (sizeof($viewSOList) > 0) {
                foreach ($viewSOList as $a) {
                    $details['OrderFromDate'] = $a['OrderFromDate'];
                    $details['OrderToDate'] = $a['OrderToDate'];
                    $details['divName'] = $a['divName'];
                    $details['storeName'] = $a['storeName'];
                    $details['status'] = $a['status'];
                    $details['areaName'] = $a['areaName'];
                    $details['areaId'] = $a['areaId'];
                    $details['divId'] = $a['divId'];
                    $details['storeId'] = $a['storeId'];
                }
            }
        }
//var_dump($details);
        $this->load->model('connection');
        $areaArray = $this->connection->getAreaName($userdata['umId']);
        $divisionArray = $this->connection->getDivisionName($userdata['umId']);
        $data['areaArray'] = $areaArray;
        $data['divisionArray'] = $divisionArray;
        $data['details'] = $details;
//$this->session->unset_userdata('viewSOList');
        $this->load->view('view_sales_order', $data);
//$this->session->unset_userdata('viewSOList');
    }

    function create_sales_order($areaId = null, $area = null, $divId = null, $divCode = null, $div = null, $storeId = null, $store = null) {
        $userdata = $this->session->userdata('userdata');
        $this->load->model('connection');
        $jsarray = $this->connection->getStoreData();
        $javascript_array = "var availableTags = [";
        foreach ($jsarray->result() as $row) {
            $javascript_array .= "\"" . $row->smStoreName . "#" . $row->smId . "\",";
        }
        $javascript_array = substr($javascript_array, 0, strlen($javascript_array) - 1);
        $javascript_array .= "];";
        $data['jsArray'] = $javascript_array;


        $data['sales_type'] = $this->connection->get_sales_types();

       
        $sodetails = array();

        $this->load->model('connection');
        $dbarray = '';
        $salesrepArray = '';
        if ($divCode != null) {
            $dbarray = $this->connection->get_dropdown_array_category('pmProductId', 'pmCategory', 'productlist', $divCode);
        }
        $salesrepArray = $this->connection->get_dropdown_array_salesrep();
        $areaArray = $this->connection->getAreaName($userdata['umId']);
        $divisionArray = $this->connection->getDivisionName($userdata['umId']);

        $data['areaArray'] = $areaArray;
        $data['divisionArray'] = $divisionArray;
        $data['dbArray'] = $dbarray;
        $data['salesrepArray'] = $salesrepArray;
        $data['productArray'] = '';
        $data['sodetails'] = null;
        if ($areaId != null) {
        	$store_data = $this->list_model->customerDetById($storeId);
            $sodetails = array(
                'areaId' => $areaId,
                'area' => $area,
                'divCode' => $divCode,
                'divId' => $divId,
                'div' => $div,
                'storeId' => $storeId,
                'store' => $store,
            	'CustomerPriceGroup' =>$store_data[0]['CustomerPriceGroup']
            );
            $data['sodetails'] = $sodetails;
        }
        if ($this->input->post('hid_txtArea') != null) {
            $soList = $this->session->userdata('SOList');
            if ($this->input->post('hid_isAdded') != 0 && sizeof($soList) > 0) {
                $this->savePartialSalesOrder();
            }
        } else {
            $this->session->unset_userdata('SOList');
            $this->load->view('create_sales_order', $data);
        }
    }

    public function savePartialSalesOrder() {
        $userdata = $this->session->userdata('userdata');
        $HoId = 0;
        $StoreUserId = 0;
        $SalesRepId = 0;
        $ManagerId = 0;
        if ($userdata['umIsHOUser'] == 1) {
            $HoId = $userdata['umId'];
        }
        if ($userdata['umStoreId'] > 0) {
            $StoreUserId = $userdata['umId'];
        }
        if ($userdata['umIsSalesRep'] == 1) {
            $SalesRepId = $userdata['umId'];
        }
        if ($userdata['umIsManager'] == 1) {
            $ManagerId = $userdata['umId'];
        }
        $storeId = $this->input->post('hidTxtCustomer');
        $amount = $this->input->post('txtTotal');
        $divCode = $this->input->post('hid_txtDivisionCode');
        $divName = $this->input->post('txtDivision');
        $areaId = $this->input->post('hid_txtArea');
        if ($userdata['umIsHOUser'] == 1){
            $orderedBy = $this->input->post('salesRepList');
            $SalesRepId = $this->input->post('salesRepList');
        }else
            $orderedBy = $userdata['umId'];

        $DespatchMode = $this->input->post('ddlMode');
        if ($DespatchMode == 0 || $DespatchMode == 1) {
            if ($DespatchMode == 0)
                $Despatch = 'By Parcel: ';
            else
                $Despatch = 'By Courier: ';
            $sosTo = $this->input->post('txtTo');
            $sosCarrier = $this->input->post('txtCarrier');
            $sosDestination = $this->input->post('txtDestination');
            $Despatch .= 'To:' . $sosTo . ', Carrier:' . $sosCarrier . ', Destination:' . $sosDestination . '';
        }
        else {
            $Despatch = $this->input->post('txtDespatch');
            $sosTo = '';
            $sosCarrier = '';
            $sosDestination = '';
        }

        $response = "";
        $this->load->model('common_model');
        $branchIds = $this->common_model->getBranchIdByStoreId($storeId);
        if ($branchIds->num_rows() > 0) {
            foreach ($branchIds->result() as $row) {
                $branchId = $row->bmBranchID;
            }
            $SOrderNo = $this->common_model->getSalesOrderNo('select', $branchId, 1);
            if ($SOrderNo->num_rows() > 0) {
                foreach ($SOrderNo->result() as $rows) {
                    $saleOrderNo = $rows->OrderNo;
                }
            } else {
                if ($this->common_model->getSalesOrderNo('add', $branchId, 1)) {
                    $saleOrderNo = 'SO1';
                }
            }
            $orderCount = $this->common_model->getOrderNoCount($saleOrderNo, $branchId);
            if ($orderCount->num_rows() > 0) {
                foreach ($orderCount->result() as $res) {
                    $SON = $res->OrderNo;
                }
                if ($SON > 0) {
                    $SOrderNo = $this->common_model->getSalesOrderNo('select', $branchId, 2);
                    if ($SOrderNo->num_rows() > 0) {
                        foreach ($SOrderNo->result() as $rows) {
                            $saleOrderNo = $rows->OrderNo;
                        }
                    }
                }
            }
            $orderCount = $this->common_model->getOrderNoCount($saleOrderNo, $branchId);
            if ($orderCount->num_rows() > 0) {
                foreach ($orderCount->result() as $res) {
                    $SON = $res->OrderNo;
                }
                if ($SON > 0) {
                    $SOrderNo = $this->common_model->getSalesOrderNo('select', $branchId, 3);
                    if ($SOrderNo->num_rows() > 0) {
                        foreach ($SOrderNo->result() as $rows) {
                            $saleOrderNo = $rows->OrderNo;
                        }
                    }
                }
            }
            $orderCount = $this->common_model->getOrderNoCount($saleOrderNo, $branchId);
            if ($orderCount->num_rows() > 0) {
                foreach ($orderCount->result() as $res) {
                    $SON = $res->OrderNo;
                }
                if ($SON > 0) {
                    $saleOrderNo = 'Failed! Duplicate Order Number. Please Try Again.';
                    echo $saleOrderNo;
                    die();
                }
            }
            if ($this->input->post('isConfirmBtn') == 1) {
                $isConfirmed = 1;
                $isPartial = 0;
            } else {
                $isConfirmed = 0;
                $isPartial = 1;
            }
//die('isconf:'.$isConfirmed.'   '.'isPartial:'.$isPartial);$HoId = 0;
            $clientDate = $this->input->post('hid_time');
            $dateNow = date('Y-m-d H:i:s', strtotime($clientDate));
// $now = time();
// $gmt = local_to_gmt($now);
            $summaryId = $this->common_model->saveSOSummary($storeId, $amount, $branchId, $saleOrderNo, $dateNow, $divCode, $divName, $areaId, $HoId, $StoreUserId, $SalesRepId, $ManagerId, $Despatch, $DespatchMode, $sosTo, $sosCarrier, $sosDestination, $isConfirmed, $isPartial, $orderedBy);
//die($summaryId);
             $this->common_model->orderSuccessMail($branchId, $userdata['umId'], $storeId);
            if ($summaryId->num_rows() > 0) {
                foreach ($summaryId->result() as $sums) {
                    $sId = $sums->sosID;
                }
                if ($sId != null) {
                    $this->common_model->updateOrderNo($branchId);
                }
                $soList = $this->session->userdata('SOList');

                if (sizeof($soList) > 0) {
                    foreach ($soList as $a) {
                        $prId = $a['productId'];
                        $quant = $a['qty'];
                        $ofr = $a['offer'];
                        $this->savetoSODetails($sId, $prId, $quant, $ofr);
                    }
                    echo '<script type="text/javascript">window.alert("SalesOrderSubmitted Successfully");window.location.href= "' . base_url() . '#salesorder/create_sales_order";</script>';
                }
            } else {
                echo 'ERROR OCCURED';
            }
        }
    }

    private function savetoSODetails($sId, $prId, $quant, $ofr) {
    	$sales_type = $_POST['sales_type'];
        $this->load->model('common_model');
        $productDet = $this->common_model->getproductDet($prId,$sales_type);
        if ($productDet->num_rows() > 0) {
            foreach ($productDet->result() as $row) {
                $productCode = $row->pmProductCode;
                $productName = $row->pmProductName;
                $productCategoty = $row->pmCategory;
                $productMRP = $row->pmMRP;
            }
        }
        $amounts = $quant * $productMRP;
        if ($this->common_model->savetoSODetails($sId, $prId, $productCode, $productName, $productCategoty, $quant, $ofr, $productMRP, $amounts)) {
            $this->session->unset_userdata('SOList');
        }
    }

    function edit_sales_order($id) {
        $this->load->model('connection');
        $this->load->model('list_model');
        $userdata = $this->session->userdata('userdata');
        $areaArray = $this->connection->getAreaName($userdata['umId']);
        $divisionArray = $this->connection->getDivisionName($userdata['umId']);

        $data['areaArray'] = $areaArray;
        $data['divisionArray'] = $divisionArray;

        $data['productArray'] = '';
        $this->session->unset_userdata('editSo');
        $data['sodetails'] = $this->setEditSOList($id);
        $store_data = $this->list_model->customerDetById($data['sodetails']['storeId']);
        $store_data = $store_data->result_array();
        
        $data['sodetails']['CustomerPriceGroup'] = $store_data[0]['CustomerPriceGroup'];
        $dbarray = $this->connection->get_dropdown_array_category('pmProductId', 'pmCategory', 'productlist', $data['sodetails']['divCode']); //

        $data['dbArray'] = $dbarray;
        $data['sales_type'] = $this->connection->get_sales_types();
        $this->load->view('edit_sales_order', $data);
    }

    function update_sales_order($summaryId, $amount, $DespatchMode, $Despatch, $sosTo, $sosCarrier, $sosDestination, $isConfirmed) {
        $this->load->model('common_model');
        if ($Despatch == 'NA') {
            $Despatch = '';
        }
        if ($sosTo == 'NA') {
            $sosTo = '';
            $sosCarrier = '';
            $sosDestination = '';
        }
        $data = $this->common_model->isUpdatable($summaryId);

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $res) {
                $cnt = $res->counts;
            }
            if ($cnt > 0) {
                if ($this->common_model->updateSalesOrder($summaryId, $amount, $DespatchMode, $Despatch, $sosTo, $sosCarrier, $sosDestination, $isConfirmed)) {
                    if ($this->common_model->deleteSODetails($summaryId)) {
                        $soList = $this->session->userdata('editSo');
                        if (sizeof($soList) > 0) {
                            foreach ($soList as $a) {
                                $prId = $a['productId'];
                                $quant = $a['qty'];
                                $ofr = $a['offer'];
                                $this->savetoSODetails($summaryId, $prId, $quant, $ofr);
                                $this->session->unset_userdata('editSo');
                            }
                            echo 'inserted successfully';
                        }
                    }
                }
            } else {
                return false;
            }
        }
    }

    function salesorderSR() {
//$this->session->unset_userdata('SOListMSR');
        $userdata = $this->session->userdata('userdata');
        $this->load->model('connection');
        $dbarray = $this->connection->get_dropdown_array_category('pmProductId', 'pmCategory', 'productlist', 1);
// var_dump($dbarray);
        $areaArray = $this->connection->getAreaName($userdata['umId']);
        $divisionArray = $this->connection->getDivisionName($userdata['umId']);
        $this->session->unset_userdata('viewSOList');

//$storeArray = '';
        $data['areaArray'] = $areaArray;
        $data['divisionArray'] = $divisionArray;
//$data['storeArray']=$storeArray;
        $data['dbArray'] = $dbarray;
        $data['productArray'] = '';
        $this->load->view('salesorderSalesRep_view', $data);
        $soListMSR = $this->session->userdata('SOListMSR');

        if ($this->input->post('hid_isAdded') != 0 && $soListMSR !== FALSE) {
            $this->saveSalesOrderMSR();
        }
    }

    function setEditSOList($id) {
        $details = array();
        $this->load->model('common_model');
        $data = $this->common_model->getViewSOSummary($id);
        if ($data->num_rows() > 0) {
            foreach ($data->result() AS $result) {
                $details['summaryId'] = $id;
                $details['areaId'] = $result->sosAreaId;
                $details['sosIsDownload'] = $result->sosIsDownload;
                $details['isConfirmed'] = $result->sosIsConfirmed;
                $details['isPartial'] = $result->sosIsPartial;
                $details['isCancelled'] = $result->sosIsCancelled;
                $details['divId'] = $result->sosDivisionCode;
                $details['divCode'] = $result->dmCode;
//die('divId = '.$result->sosDivisionCode.'  divCode = '.$result->dmCode);
                $details['storeId'] = $result->sosStoreID;
                if ($result->OrderedBy != 0)
                    $details['OrderedBy'] = $result->umUserName;
                else
                    $details['OrderedBy'] = '';
                $details['SalesRepID'] = $result->sosSalesRepID;
                $details['ManagerID'] = $result->sosManagerID;
                $details['StoreUserID'] = $result->sosStoreUserID;
                $details['Amount'] = $result->sosNetAmount;
                $details['BranchID'] = $result->sosBranchID;
                $details['SONo'] = $result->sosSONo;
                $details['HOUserId'] = $result->sosHoUserId;
                $details['Despatch'] = $result->sosDespatch;
                $details['DespatchMode'] = $result->sosDespatchMode;
                $details['To'] = $result->sosTo;
                $details['Carrier'] = $result->sosCarrier;
                $details['Destination'] = $result->sosDestination;
                $details['StoreName'] = $result->smStoreName;
                $details['AreaName'] = $result->amAreaName;
                $details['DivisionName'] = $result->dmDivisionName;
                $details['sodetails'] = array();
            }
            $dataSoDet = $this->common_model->getViewSODetails($id);
            if ($dataSoDet->num_rows() > 0) {
                $editsoList = $this->session->userdata('editSo');
                if ($editsoList === FALSE) {
                    $editsoList = array();
                }
                foreach ($dataSoDet->result() AS $results) {
                    $sodetails = array(
                        'productId' => $results->sodProductID,
                        'productCode' => $results->sodProductCode,
                        'productName' => $results->sodProductName,
                        'Category' => $results->sodCategory,
                        'qty' => $results->sodQty,
                        'offer' => $results->sodOfferQty,
                        'Mrp' => $results->sodMRP,
                        'Amount' => $results->sodAmount
                    );

                    array_push($editsoList, $sodetails);
                }
                $this->session->set_userdata('editSo', $editsoList);
            }
        }
        return $details;
    }

}
