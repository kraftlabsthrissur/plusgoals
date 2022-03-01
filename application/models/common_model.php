<?php

class Common_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function checkPasswd($passwd, $id) {
        $query = $this->db->query('SELECT COUNT(*) AS cnt FROM usermaster WHERE umPassword ="' . $passwd . '" AND umId = "' . $id . '"');
        return $query;
    }

    function updatePassword($pass, $Id) {
        $this->db->query('UPDATE usermaster SET umPassword ="' . $pass . '",umResetPassword="1" WHERE umId = "' . $Id . '"');
        return true;
    }

    function getBranchIdByStoreId($storeId) {
        $query = $this->db->query('SELECT bmBranchID,bmBranchCode,bmBranchName,zmId,zmZoneName,zmCode,smId,smStoreCode,smStoreName FROM branchmaster INNER JOIN 
				zonemaster ON zmBranchId=bmBranchId INNER JOIN areamatrix ON amxZoneId=zmId INNER JOIN storetosubareaforrep ON 
				stsSubAreaForRepId=amxSubAreaForRepId INNER JOIN storemaster ON smid=stsstoreid WHERE smid =' . $storeId);
        return $query;
    }

    function getSalesOrderNo($mode, $branchId, $addNo) {
        if ($mode == 'select') {
            $query = $this->db->query('SELECT  CONCAT(ongOrderNoPrefix , ongLastOrderNo + ' . $addNo . ' ) AS OrderNo FROM ordernogenerator WHERE ongBranchID =' . $branchId);
            return $query;
        } else {
            $query = $this->db->query('INSERT INTO ordernogenerator (ongBranchId,ongOrderTypeName, ongDivisionId,ongOrderNoPrefix, ongLastOrderNo,ongGuid,ongCreationDate,ongTS) 
					VALUES(' . $branchId . ',"SalesOrder",1,"SO",1,"", CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)');
            return TRUE;
        }
    }

    function getOrderNoCount($OrderNo, $branchId) {
        $query = $this->db->query('SELECT COUNT(*) AS OrderNo FROM  sosummary WHERE sosSONo="' . $OrderNo . '" AND sosBranchId = ' . $branchId . '');
        return $query;
    }

    function saveSOSummary($storeId, $amount, $branchId, $orderNo, $dateNow, $divCode, $divName, $areaId, $HoId, $StoreUserId, $SalesRepId, $ManagerId, $Despatch, $DespatchMode, $sosTo, $sosCarrier, $sosDestination, $isConfirm, $isPartial, $orderedBy) {
        //die('Despatch= '.$Despatch.'mode = '.$DespatchMode.'sosto= '.$sosTo.'sosCar= '.$sosCarrier.'sosDest= '.$sosDestination);
        $query = $this->db->query('INSERT INTO sosummary(sosStoreID,sosSalesRepID,sosManagerID,sosStoreUserID,sosNetAmount,sosBranchID,sosSONo,sosCreationDate,sosTS,sosDivisionCode,sosDivisionName,sosBillDate,sosBillNo,sosIsConfirmed,sosAreaId,sosHoUserId,
					sosIsPending,sosIsInProcess,sosIsSuspended,sosIsCancelled,sosIsCompleted,sosIsPartial,sosDespatch,sosDespatchMode,sosTo,sosCarrier,sosDestination,OrderedBy)
					VALUES(' . $storeId . ',' . $SalesRepId . ',' . $ManagerId . ',' . $StoreUserId . ',' . $amount . ',' . $branchId . ',"' . $orderNo . '","' . date('Y-m-d H:i:s') . '","' . date('Y-m-d H:i:s') . '","' . $divCode . '","' . $divName . '","' . date('Y-m-d H:i:s') . '","",' . $isConfirm . ',' . $areaId . ',' . $HoId . ',
					0,0,0,0,0,' . $isPartial . ',"' . $Despatch . '",' . $DespatchMode . ',"' . $sosTo . '","' . $sosCarrier . '","' . $sosDestination . '",' . $orderedBy . ')');
        //$SummaryId = $this->db->query('SELECT MAX(sosID) AS SummaryID FROM SOSummary');
        //echo $this->db->last_query();
        $this->db->select_max('sosID');
        $SummaryId = $this->db->get('sosummary');

        return $SummaryId;
    }

    function updateOrderNo($branchId) {
        $query = $this->db->query('Update ordernogenerator Set ongLastOrderNo=ongLastOrderNo+1 WHERE ongBranchID =' . $branchId);
        return true;
    }

    function getproductDet($ProductId, $sales_type = '') {
        $query = $this->db->query("SELECT pmProductCode,pmProductName,pmCategory,if('mrp_price' = null, pmMRP, mrp_price) pmMRP  
        	FROM productlist pm
        	LEFT JOIN sales_price sp ON pm.pmProductCode = sp.item_no " . (($sales_type !== '') ? " 
        		and sp.sales_code = '$sales_type' " : '') . "
        	WHERE pmProductId =' $ProductId ' AND STR_TO_DATE( starting_date,  '%d-%m-%Y' ) = ( 
SELECT MAX( STR_TO_DATE( starting_date,  '%d-%m-%Y' ) ) 
FROM sales_price
WHERE  `item_no` LIKE  pmProductCode
AND  `sales_code` LIKE  sp.sales_code )  group by  pmProductCode ");
        return $query;
    }

    function savetoSODetails($sId, $prId, $productCode, $productName, $productCategoty, $quant, $ofr, $productMRP, $amounts) {
        if ($quant == '')
            $quant = 1;
        if ($ofr == '')
            $ofr = 0;
        $query = $this->db->query('Insert into sodetail(sodSummaryID,sodProductID,sodProductCode,sodProductName,sodCategory,sodQty,sodOfferQty,sodMRP,sodAmount,sodTS)
			Values(' . $sId . ',' . $prId . ',"' . $productCode . '","' . $productName . '","' . $productCategoty . '",' . $quant . ',' . $ofr . ',' . $productMRP . ',' . $amounts . ',CURRENT_TIMESTAMP)');
        //echo $this->db->last_query();
        //die($query);
        RETURN TRUE;
    }

    function getDataforViewSODetails($OrderFromDate, $OrderToDate, $areaId, $divId, $storeId, $status, $Unionstr = '') {
        $query = $this->db->query("SELECT DISTINCT sosID,sosSONo,sosDivisionName,smStoreName,DATE_FORMAT(sosBillDate, '%d %b %Y %h:%i %p')  AS sosBillDate,
                    sosNetAmount,sosGuid,OrderedBy,
                    (CASE WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsPending=1 THEN 'Pending' 
                    WHEN sosIsInProcess=1 THEN 'InProcess' WHEN sosIsSuspended=1 THEN 'Suspended' 
                    WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsCompleted=1 THEN 'Completed' 
                    WHEN sosIsConfirmed=1 THEN 'Confirmed' WHEN sosIsConfirmed=0 THEN 'Partial' END) AS OrderStatus,sosBillDate SortDate,(CASE WHEN sosIsDownload>=1 THEN 'Downloaded' END) AS IsDownloaded 
                    FROM sosummary INNER JOIN storemaster ON smId=sosStoreID 
                    WHERE sosAreaId=" . $areaId . " AND sosDivisionCode=" . $divId . " AND sosStoreID=" . $storeId . " 
                    AND sosBillDate BETWEEN '" . $OrderFromDate . "' AND '" . $OrderToDate . "' " . $status . "" . $Unionstr . "");
        return $query;
    }

    function getAllDataforViewSODetails($OrderFromDate, $OrderToDate, $status, $Unionstr = '', $userId) {
        $query = $this->db->query("SELECT DISTINCT sosID,sosSONo,sosDivisionName,smStoreName,DATE_FORMAT(sosBillDate, '%d %b %Y %h:%i %p')  AS sosBillDate,
                    sosNetAmount,sosGuid,OrderedBy,
                    (CASE WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsPending=1 THEN 'Pending' 
                    WHEN sosIsInProcess=1 THEN 'InProcess' WHEN sosIsSuspended=1 THEN 'Suspended' 
                    WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsCompleted=1 THEN 'Completed' 
                    WHEN sosIsConfirmed=1 THEN 'Confirmed' WHEN sosIsConfirmed=0 THEN 'Partial' END) AS OrderStatus,sosBillDate SortDate,(CASE WHEN sosIsDownload>=1 THEN 'Downloaded' END) AS IsDownloaded 
                    FROM sosummary INNER JOIN storemaster ON smId=sosStoreID 
                    WHERE smStoreCode IN ( SELECT `Code` FROM userauthorizedmodeitems  WHERE `Mode` = 'Store') AND sosDivisionCode IN (SELECT `Code` FROM userauthorizedmodeitems WHERE `Mode`='Division') 
                    AND sosStoreID IN (SELECT Id FROM userauthorizedmodeitems WHERE `Mode`='Store' AND UserId = $userId) 
                    AND sosBillDate BETWEEN '" . $OrderFromDate . "' AND '" . $OrderToDate . "' " . $status . "" . $Unionstr . "");
        return $query;
    }

    function getNoStoreAllDataforViewSODetails($OrderFromDate, $OrderToDate, $status, $Unionstr = '', $areaId, $divId) {
        $query = $this->db->query("SELECT Distinct sosID,sosSONo,sosDivisionName,smStoreName,DATE_FORMAT(sosBillDate, '%d %b %Y %h:%i %p') AS sosBillDate, 
                    sosNetAmount,sosGuid,OrderedBy,
                    (CASE WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsPending=1 THEN 'Pending'
                    WHEN sosIsInProcess=1 THEN 'InProcess' WHEN sosIsSuspended=1 THEN 'Suspended'
                    WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsCompleted=1 THEN 'Completed'
                    WHEN sosIsConfirmed=1 THEN 'Confirmed' WHEN sosIsConfirmed=0 THEN 'Partial' END)AS OrderStatus,sosBillDate SortDate,(CASE WHEN sosIsDownload>=1 THEN 'Downloaded' END) AS IsDownloaded
                    FROM sosummary INNER JOIN storemaster ON smId=sosStoreID 
                    INNER JOIN storetosubareaforrep ON stsstoreid=smId 
                    WHERE sosAreaId= " . $areaId . " AND sosDivisionCode= " . $divId . " AND sosStoreID IN (SELECT Id FROM userauthorizedmodeitems  WHERE `Mode` ='Store')
                       AND sosBillDate BETWEEN '" . $OrderFromDate . "' AND '" . $OrderToDate . "' " . $status . "
                    " . $Unionstr . "");
        return $query;
    }

    function getAllAreaDataforViewSODetails($OrderFromDate, $OrderToDate, $status, $Unionstr = '', $areaId) {
        $query = $this->db->query("SELECT Distinct sosID,sosSONo,sosDivisionName,smStoreName,DATE_FORMAT(sosBillDate, '%d %b %Y %h:%i %p') AS sosBillDate, 
                    sosNetAmount,sosGuid, OrderedBy,
                    (CASE WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsPending=1 THEN 'Pending'
                     WHEN sosIsInProcess=1 THEN 'InProcess' WHEN sosIsSuspended=1 THEN 'Suspended'
                     WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsCompleted=1 THEN 'Completed'
                     WHEN sosIsConfirmed=1 THEN 'Confirmed' WHEN sosIsConfirmed=0 THEN 'Partial' END)AS OrderStatus,sosBillDate SortDate,(CASE WHEN sosIsDownload>=1 THEN 'Downloaded' END) AS IsDownloaded 
                    FROM sosummary INNER JOIN storemaster ON smId=sosStoreID 
                    WHERE sosAreaId=" . $areaId . " AND sosDivisionCode IN (SELECT `code` FROM userauthorizedmodeitems WHERE `mode` = 'Division') 
                    AND sosStoreID IN (SELECT Id FROM userauthorizedmodeitems WHERE `mode`='Store')AND sosBillDate BETWEEN '" . $OrderFromDate . "' AND '" . $OrderToDate . "' " . $status . "" . $Unionstr . "");

        return $query;
    }

    function getDivAllDataforViewSODetails($OrderFromDate, $OrderToDate, $status, $Unionstr = '', $divId, $userId) {
        $query = $this->db->query("SELECT Distinct sosID,sosSONo,sosDivisionName,smStoreName,DATE_FORMAT(sosBillDate, '%d %b %Y %h:%i %p') AS sosBillDate, 
                    sosNetAmount,sosGuid, OrderedBy,
                    (CASE WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsPending=1 THEN 'Pending'
                     WHEN sosIsInProcess=1 THEN 'InProcess' WHEN sosIsSuspended=1 THEN 'Suspended'
                     WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsCompleted=1 THEN 'Completed'
                     WHEN sosIsConfirmed=1 THEN 'Confirmed' WHEN sosIsConfirmed=0 THEN 'Partial' END)AS OrderStatus,sosBillDate SortDate,(CASE WHEN sosIsDownload>=1 THEN 'Downloaded' END) AS IsDownloaded 
                    FROM sosummary INNER JOIN storemaster  ON smId=sosStoreID 
                    WHERE sosAreaId IN (SELECT Id FROM userauthorizedmodeitems WHERE `Mode` ='Area' AND UserId = $userId) AND 
                     sosDivisionCode=" . $divId . " AND sosStoreID IN (SELECT Id FROM userauthorizedmodeitems WHERE `Mode`='Store')
                     " . $status . " AND sosBillDate BETWEEN '" . $OrderFromDate . "' AND '" . $OrderToDate . "'
                    " . $Unionstr . "");

        return $query;
    }

    function getNoDivDataforViewSODetails($OrderFromDate, $OrderToDate, $status, $Unionstr = '', $storeId) {
        $query = $this->db->query("SELECT Distinct sosID,sosSONo,sosDivisionName,smStoreName,DATE_FORMAT(sosBillDate, '%d %b %Y %h:%i %p') AS sosBillDate, 
					sosNetAmount,sosGuid, OrderedBy,
					(CASE WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsPending=1 THEN 'Pending'
					 WHEN sosIsInProcess=1 THEN 'InProcess' WHEN sosIsSuspended=1 THEN 'Suspended'
					 WHEN sosIsCancelled=1 THEN 'Cancelled' WHEN sosIsCompleted=1 THEN 'Completed'
					 WHEN sosIsConfirmed=1 THEN 'Confirmed' WHEN sosIsConfirmed=0 THEN 'Partial' END)AS OrderStatus,sosBillDate SortDate,(CASE WHEN sosIsDownload>=1 THEN 'Downloaded' END) AS IsDownloaded 
					FROM sosummary INNER JOIN storemaster  ON smId=sosStoreID 
					WHERE sosAreaId IN (SELECT Id FROM userauthorizedmodeitems WHERE `Mode` ='Area') AND 
					 sosDivisionCode IN (SELECT `Code` FROM userauthorizedmodeitems WHERE `Mode`='Division') AND sosStoreID = " . $storeId . "
					 " . $status . " AND sosBillDate BETWEEN '" . $OrderFromDate . "' AND '" . $OrderToDate . "'
					" . $Unionstr . "");


        return $query;
    }

    function saveToStoreAmountCollectionSummary($store, $SRId, $managerId, $BranchId, $amount, $divId) {
        $query = $this->db->query("INSERT INTO storeamountcollectionsummary(scsStoreID,scsSalesRepID,scsManagerID,scsBranchId,scsCollectionDate,
			scsNetAmount,scsSOGuid,scsGuid,scsCreationDate,scsTS,scsDivisionId)VALUES(" . $store . "," . $SRId . "," . $managerId . "," . $BranchId . ",'" . date('Y-m-d H:i:s') . "'," . $amount . ",'ABCDEFG','EFGHIJ','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "'," . $divId . ")");
        $this->db->select_max('scsID');
        $SummaryId = $this->db->get('storeamountcollectionsummary');
        return $SummaryId;
    }

    function saveToStoreAmountCollectionDetails($scsSummaryId, $cMode, $amount, $ChequeNo, $date, $bank, $remarks) {
        if ($bank == 'NA') {
            $bank = '';
        }
        $query = $this->db->query("INSERT INTO storeamountcollectiondetail(scdSummaryID,scdCollectionMode,scdAmount,scdDDChequeNo,scdChequeDate,scdChequeBank,scdRemarks,scdGuid,scdCreationDate,scdTS)
				VALUES(" . $scsSummaryId . ",'" . $cMode . "'," . $amount . ",'" . $ChequeNo . "','" . $date . "','" . $bank . "','" . $remarks . "','ABCDEFG','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "')");
    }

    function getViewSOSummary($id) {
        $query = $this->db->query("SELECT sosStoreID,sosSalesRepID,sosManagerID,sosStoreUserID,sosNetAmount,sosBranchID,sosSONo,sosTS,sos.OrderedBy,um.umUserName,sosDivisionCode,sosDivisionName,sosBillDate,sosIsConfirmed,sosAreaId,sosHoUserId,
					sosDespatch,sosDespatchMode,sosTo,sosCarrier,sosDestination,sosIsCancelled,sosIsConfirmed,sosIsPartial,sosIsDownload,sm.smStoreName,sm.smStoreCode,am.amAreaName,dm.dmDivisionName,dm.dmCode FROM sosummary sos
					INNER JOIN storemaster sm ON sm.smId = sos.sosStoreID
					INNER JOIN areamaster am ON am.amId = sos.sosAreaId
					LEFT OUTER JOIN usermaster um ON um.umId = sos.OrderedBy
					INNER JOIN divisionmaster dm ON dm.dmCode = sos.sosDivisionCode WHERE sosID = " . $id . "");
        return $query;
    }

    function getViewSODetails($id) {
        $query = $this->db->query("Select sodProductID,sodProductCode,sodProductName,sodCategory,sodQty,sodOfferQty,sodMRP,sodAmount FROM sodetail WHERE sodSummaryID = " . $id . "");
        return $query;
    }

    function getSOCommunication($id) {
        $query = $this->db->query("Select socsoSummaryid,socLogUserid,umUserName,socLogDescription, DATE_FORMAT(socreationDate, '%d/%m/%Y') AS socreationDate from socommunication Inner join usermaster on umId=socLogUserid Where socsoSummaryid=" . $id . "");
        return $query;
    }

    function saveSOCommunication($summaryId, $userId, $desc) {
        $query = $this->db->query("Insert into socommunication(socsoSummaryid,socLogUserid,socLogDescription,socreationDate) Values(" . $summaryId . "," . $userId . ",'" . $desc . "','" . date('Y-m-d H:i:s') . "')");
        return TRUE;
    }

    function updateSOSummary($field, $field1, $field2, $field3, $val, $summaryId) {
        $this->db->query('UPDATE sosummary Set sosIsConfirmed = 0, sosIsPartial = 0,' . $field . ' = ' . $val . ',' . $field1 . ' = 0,' . $field2 . ' = 0,' . $field3 . ' = 0, sosTS = "' . date('Y-m-d H:i:s') . '" WHERE sosId = ' . $summaryId . '');
    }

    function getSummaryStatus($summaryId) {
        $query = $this->db->query("SELECT 
				(CASE WHEN sosIsPending=1 THEN 'sosIsPending' WHEN sosIsInProcess=1 THEN 'sosIsInProcess'
				WHEN sosIsSuspended=1 THEN 'sosIsSuspended' WHEN sosIsCompleted=1 THEN 'sosIsCompleted' END) AS status
				FROM sosummary WHERE sosId = " . $summaryId . "");
        return $query;
    }

    function getSOCollectionById($StoreID, $DivisionId) {
        // $query = $this->db->query("SELECT scdCreationDate,scdChequeDate,scdCollectionMode,scdDDChequeNo,scdChequeBank,scdAmount,scdRemarks FROM storeamountcollectiondetail WHERE scdSummaryID = ".$summaryId."");
        // return $query;
        $query = $this->db->query("Select scdSummaryID,DATE_FORMAT(scsCollectionDate, '%d/%m/%Y') AS scsCollectionDate,scdCollectionMode,
									scdDDChequeNo, DATE_FORMAT(scdChequeDate, '%d/%m/%Y') AS scdChequeDate,scdChequeBank,scdAmount,scdRemarks 
									From storeamountcollectiondetail Inner join storeamountcollectionsummary 
									on scsid=scdSummaryID where scsStoreID=" . $StoreID . " And (scsDivisionId=" . $DivisionId . " OR scsDivisionId Is Null)
									order by scsCollectionDate desc LIMIT 0,10");
        return $query;
    }

    function cancelSalesOrder($summaryId) {
        $query = $this->db->query('UPDATE sosummary SET sosIsCancelled = 1,sosIsConfirmed = 0,sosIsPending = 0,sosIsInProcess = 0,sosIsSuspended = 0,sosIsCompleted = 0,sosIsPartial = 0 WHERE sosId = ' . $summaryId . '');
        return true;
    }

    function isUpdatable($summaryId) {
        $query = $this->db->query("SELECT COUNT(*) AS counts FROM sosummary WHERE sosId = " . $summaryId . " AND (sosIsPartial = 1 OR sosIsInProcess = 1)");
        return $query;
    }

    function updateSalesOrder($summaryId, $amount, $DespatchMode, $Despatch, $sosTo, $sosCarrier, $sosDestination, $isConfirmed) {
        $isPartial = 0;
        if ($isConfirmed == 0) {
            $isPartial = 1;
        }
        $query = $this->db->query('Update sosummary SET sosNetAmount = ' . $amount . ',sosTS = CURRENT_TIMESTAMP,sosIsConfirmed = ' . $isConfirmed . ',
					sosIsPartial = ' . $isPartial . ',sosDespatch="' . $Despatch . '",sosDespatchMode = ' . $DespatchMode . ',sosTo="' . $sosTo . '",sosCarrier="' . $sosCarrier . '",sosDestination="' . $sosDestination . '",sosIsConfirmed = ' . $isConfirmed . ' WHERE sosID = ' . $summaryId . '');
        return true;
    }

    function deleteSODetails($summaryId) {
        $query = $this->db->query('Delete FROM sodetail Where sodSummaryID = ' . $summaryId . '');
        return true;
    }

    function isReceiptNoExists($receiptNo) {
        $query = $this->db->query('SELECT COUNT(*) AS cnt FROM storeamountcollectiondetail WHERE scdDDChequeNo = "' . $receiptNo . '"');
        return $query;
    }

    function updateDownloadStatus($summaryId) {
        $this->db->query("UPDATE sosummary SET sosIsDownload = 1 WHERE sosID = " . $summaryId . "");
    }

    function getSOResults($summaryId) {
        $query = $this->db->query("SELECT sodProductID,sodProductCode,sodQty,sodOfferQty,sodMRP,sodAmount,packingCode,pmProductName "
                . "FROM sodetail "
                . "JOIN productlist ON sodProductID = pmProductId "
                . "WHERE sodSummaryID = '" . $summaryId . "'");
        return $query;
    }

    function getSOSummaryBySummaryId($id) {
        $query = $this->db->query("call spGetSOSummaryById(" . $id . ");");
        // $query = $this->db->query("SELECT sosStoreID,sosSalesRepID,sosManagerID,sosStoreUserID,sosNetAmount,sosBranchID,sosSONo,sosTS,sosDivisionCode,sosDivisionName,sosBillDate,sosIsConfirmed,sosAreaId,sosHoUserId,
        // sosDespatch,sosDespatchMode,sosTo,sosCarrier,sosDestination,sosIsCancelled,sosIsConfirmed,sosIsPartial,sosIsDownload,sm.smStoreName,sm.smStoreCode,am.amAreaName,dm.dmDivisionName FROM SOSUMMARY sos
        // INNER JOIN storemaster sm ON sm.smId = sos.sosStoreID
        // INNER JOIN areamaster am ON am.amId = sos.sosAreaId
        // INNER JOIN divisionmaster dm ON dm.dmId = sos.sosDivisionCode 
        // INNER JOIN usermaster ON umUserId = 
        // WHERE sosID = ".$id."");
        // @mysqli_next_result($this->conn_id);
        return $query;
    }

    function orderSuccessMail($branchId, $userId, $storeId) {

        $br = $this->db->query('SELECT umEmail from branchmaster join usermaster on umUserCode = bmBranchCode where bmBranchID = "' . $branchId . '"')->result_array();
        // echo 'SELECT umEmail from branchmaster join usermaster on umUserCode = bmBranchCode where bmBranchID = "' . $branchId . '"';
        $email = $br[0]['umEmail'];
        $user = $this->db->query('SELECT umFirstName from  usermaster WHERE  umId = "' . $userId . '"')->result_array();
        $name = $user[0]['umFirstName'];
        $dealer = $this->db->query('SELECT smStoreName from  storemaster WHERE smId = "' . $storeId . '"')->result_array();
        $dealer_name = $dealer[0]['smStoreName'];
        $date = date('d/m/Y H:i:s');
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.ayurwarecrm.com';
        $config['smtp_port'] = '25';
        $config['smtp_timeout'] = '7';
        $config['smtp_user'] = 'admin@ayurwarecrm.com';
        $config['smtp_pass'] = 'ayurwareadmin';
        $config['charset'] = 'utf-8';
       // $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validate'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('<admin@ayurwarecrm.com>', 'VOSSMART');
        $this->email->reply_to('<admin@ayurwarecrm.com>', 'VOSSMART');
        $this->email->to($email);
        $this->email->cc('vositdept@gmail.com');
        $this->email->bcc('ajith@kraftlabs.com');
        $this->email->subject('New Order From ' . $dealer_name);
        $this->email->message('You have recieved a new order from ' . $dealer_name . ' on ' . $date . ' by ' . $name);
        $this->email->send();
    }

    function getCategories() {
        return $this->db->query('SELECT SUM( IF(  `pmProductCode` <>  "", 1, 0 ) ) AS number_of_products, pmCategory as category from productlist group by pmCategory', FALSE)->result_array();
    }

    function addCategory($data, $old_category = '') {
        if ($old_category == '') {
            $this->db->insert('productlist', array('pmCategory' => $data['category']));
            $this->db->insert('product_info', array('category' => $data['category']));
        } else {
            $this->db->where(array('pmCategory' => $old_category));
            $this->db->update('productlist', array('pmCategory' => $data['category']));

            $this->db->where(array('category' => $old_category));
            $this->db->update('product_info', array('category' => $data['category']));
        }
        return TRUE;
    }

}

?>