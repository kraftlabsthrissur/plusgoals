<?php

class Report_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function toFillStockDeterminer($id) {
        //die($id);
        if ($id == 'btnBranch') {
            $query = $this->db->query('Select bmBranchID,bmBranchName,bmBranchCode FROM branchmaster');
        } else if ($id == 'btnItems') {
            $query = $this->db->query('Select pmProductId,pmProductCode,pmProductName FROM productlist WHERE pmProductId < 30');
        } else {
            $query = $this->db->query('Select pmProductId,pmProductCode,pmCategory FROM productlist WHERE pmProductId < 30');
        }
        return $query;
    }

    function searchStockpopupData($type, $value, $id) {
        if ($type == 'name') {
            if ($id == 'btnBranch') {
                $query = $this->db->query('Select bmBranchID,bmBranchName,bmBranchCode FROM branchmaster WHERE bmBranchName LIKE "' . $value . '%"');
            } else if ($id == 'btnItems') {
                $query = $this->db->query('Select pmProductId,pmProductCode,pmProductName FROM productlist WHERE pmProductId < 30 AND pmProductName LIKE "' . $value . '%"');
            } else {
                $query = $this->db->query('Select pmProductId,pmProductCode,pmCategory FROM productlist WHERE pmProductId < 100 AND pmCategory LIKE "' . $value . '%"');
            }
        } else {
            if ($id == 'btnBranch') {
                $query = $this->db->query('Select bmBranchID,bmBranchName,bmBranchCode FROM branchmaster WHERE bmBranchCode LIKE "' . $value . '%"');
            } else if ($id == 'btnItems') {
                $query = $this->db->query('Select pmProductId,pmProductCode,pmProductName FROM productlist WHERE pmProductId < 30 AND pmProductCode LIKE "' . $value . '%"');
            } else {
                $query = $this->db->query('Select pmProductId,pmProductCode,pmCategory FROM productlist WHERE pmProductId < 30 AND pmProductCode LIKE "' . $value . '%"');
            }
        }
        return $query;
    }

    // function getBranchIdByStoreId($storeId)
    // {
    // $query = $this->db->query('SELECT bmBranchID,bmBranchCode,bmBranchName,zmId,zmZoneName,zmCode,smId,smStoreCode,smStoreName FROM BranchMaster INNER JOIN 
    // zoneMaster ON zmBranchId=bmBranchId INNER JOIN AreaMatrix ON amxZoneId=zmId INNER JOIN StoreToSubAreaForRep ON 
    // stsSubAreaForRepId=amxSubAreaForRepId INNER JOIN storeMaster ON smid=stsstoreid WHERE smid ='. $storeId);
    // return $query;
    // }
    // function getSalesOrderNo($mode,$branchId,$addNo)
    // {
    // if($mode == 'select')
    // {
    // $query = $this->db->query('SELECT  CONCAT(ongOrderNoPrefix , ongLastOrderNo + '.$addNo.' ) AS OrderNo FROM OrderNoGenerator WHERE ongBranchID ='.$branchId);
    // return $query;
    // }
    // else
    // {
    // $query = $this->db->query('INSERT INTO OrderNoGenerator (ongBranchId,ongOrderTypeName, ongDivisionId,ongOrderNoPrefix, ongLastOrderNo,ongGuid,ongCreationDate,ongTS) 
    // VALUES('.$branchId.',"SalesOrder",1,"SO",1,"", CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)');
    // return TRUE;
    // }
    // }
    function insertdemo($a) {
        $ab = $a['data'];
        $query = $this->db->query('Insert into syncdemo select ' . $ab);
    }

}

?>
