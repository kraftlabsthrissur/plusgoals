<?php

class List_model extends MY_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function showUserDet($start,$length,$order_column,$order_dir,$condition = '') {
              
        $this->db->select('umId,umUserCode,concat(umFirstName," ",umLastName) userFullName,umUserName,umEmail,umCity',false);
        $this->db->from('usermaster');
        $this->db->where('umId !=', 1);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }

    function UserDetById($id) {
        $this->db->where('umId', $id);
        $query = $this->db->get('usermaster');
        return $query;
    }

    function updateUserDetails($data, $id) {
        // var_dump($data);die();
        $this->db->where('umId', $id);
        $this->db->update('usermaster', $data);
        return true;
    }

    
    
    function showcustomerDet($start,$length,$order_column,$order_dir,$condition = '') {
              
        $this->db->select('smId,smStoreCode,smStoreName,smAddress1,smCity,customer_group',false);
        $this->db->from('storemaster');
        $this->db->where('smIsActive', 1);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }

    function showprojectDet($start,$length,$order_column,$order_dir,$condition = '') {
              
        $this->db->select('project_id,project_code,project_name,budget',false);
        $this->db->from('projectmaster');
       // $this->db->where('smIsActive', 1);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }

    function showdepartmentDet($start,$length,$order_column,$order_dir,$condition = '') {
              
        $this->db->select('department_id,department_code,department_name',false);
        $this->db->from('departmentmaster');
       // $this->db->where('smIsActive', 1);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }

    function customerDetById($id) {
        $this->db->where('smId', $id);
        $query = $this->db->get('storemaster');
        return $query;
    }

    function projectDetById($id) {
        $this->db->where('project_id', $id);
        $query = $this->db->get('projectmaster');
        return $query;
    }

    function get_customer_name($id){
        $query = "select smStoreName from storemaster where smId = '$id'";
        return $query;
    }
    function departmentDetById($id) {
        $this->db->where('department_id', $id);
        $query = $this->db->get('departmentmaster');
        return $query;
    }

    function updateCustomer($data, $id) {
        $this->db->where('smId', $id);
        $this->db->update('storemaster', $data);
        return true;
    }

    function updateProject($data, $id) {
        $this->db->where('project_id', $id);
        $this->db->update('projectmaster', $data);
        return true;
    }

    function customerDelete($id) {
        $this->db->delete('storemaster', array(
            'smId' => $id
        ));
        return true;
    }

    function projectDelete($id) {
        $this->db->delete('projectmaster', array(
            'project_id' => $id
        ));
        return true;
    }

    function showDivisionDet() {
        $query = $this->db->get('divisionmaster');
        return $query;
    }

    function divisionDetById($id) {
        $this->db->where('dmId', $id);
        $query = $this->db->get('divisionmaster');
        return $query;
    }

    function updateDivisionDet($data, $id) {
        $this->db->where('dmId', $id);
        $this->db->update('divisionmaster', $data);
        return true;
    }

    function divisionDelete($id) {
        $this->db->delete('divisionmaster', array(
            'dmId' => $id
        ));
        return true;
    }

    function showareaDet() {
        $query = $this->db->get('areamaster');
        return $query;
    }

    function areaDetById($id) {
        $this->db->where('amId', $id);
        $query = $this->db->get('areamaster');
        return $query;
    }

    function updateareaDet($data, $id) {
        $this->db->where('amId', $id);
        $this->db->update('areamaster', $data);
        return true;
    }

    function areaDelete($id) {
        $this->db->delete('areamaster', array(
            'amId' => $id
        ));
        return true;
    }

    function showzoneDet() {
        $query = $this->db->query('Select *,bmBranchName FROM zonemaster LEFT OUTER JOIN branchmaster ON bmBranchId = zmBranchId');
        return $query;
    }

    function zoneDetById($id) {
        $query = $this->db->query('Select *,bmBranchName,bmBranchCode FROM zonemaster INNER JOIN branchmaster ON bmBranchId = zmBranchId WHERE zmId = "' . $id . '"');
        return $query;
    }

    function updatezoneDet($data, $id) {
        $this->db->where('zmId', $id);
        $this->db->update('zonemaster', $data);
        return true;
    }

    function zoneDelete($id) {
        $this->db->delete('zonemaster', array(
            'zmId' => $id
        ));
        return true;
    }

    function showbranchDet() {
        $query = $this->db->get('branchmaster');
        return $query;
    }

    function branchDetById($id) {
        $this->db->where('bmBranchId', $id);
        $query = $this->db->get('branchmaster');
        return $query;
    }

    function updatebranchDet($data, $id) {
        $this->db->where('bmBranchId', $id);
        $this->db->update('branchmaster', $data);
        return true;
    }

    function branchDelete($id) {
        $this->db->delete('branchmaster', array(
            'bmBranchId' => $id
        ));
        return true;
    }

    function showProductInfo($productId = NULL) {
        if ($productId <> NULL) {
            $this->db->where('productId', $productId);
        }
        $query = $this->db->get('product_info');
        return $query;
    }
    
    function getProductInfo($start,$length,$order_column,$order_dir,$condition = '') {
              
        $this->db->select('*',false);
        $this->db->from('product_info');
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }

    function addProductInfo($productInfo) {
        $this->db->insert('product_info', $productInfo);
        return $this->db->affected_rows();
    }

    function editProductInfo($productInfo, $productId) {
        $this->db->where('productId', $productId);
        $this->db->update('product_info', $productInfo);
        return $this->db->affected_rows();
    }

    function deleteProductInfo($productId) {
        $this->db->delete('product_info', array(
            'productId' => $productId
        ));
        return $this->db->affected_rows();
    }

    
    
    function showproductDet($start,$length,$order_column,$order_dir,$condition = '') {
              
        $this->db->select('pmProductId,pmProductCode, pmProductName, packingCode, insideKeralaPrice, outsideKeralaPrice, pmCategory',false);
        $this->db->from('productlist');
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }

    function productDetById($id) {
        $this->db->where('pmProductId', $id);
        $query = $this->db->get('productlist');
        return $query;
    }

    function updateproductDet($data, $id) {
        $this->db->where('pmProductId', $id);
        $this->db->update('productlist', $data);
        return true;
    }

    function productDelete($id) {
        $this->db->delete('productlist', array(
            'pmProductId' => $id
        ));
        return true;
    }

    function showsubAreaDet() {
        $query = $this->db->get('subareaforrepmaster');
        return $query;
    }

    function subAreaDetById($id) {
        $this->db->where('saId', $id);
        $query = $this->db->get('subareaforrepmaster');
        return $query;
    }

    function updatesubAreaDet($data, $id) {
        $this->db->where('saId', $id);
        $this->db->update('subareaforrepmaster', $data);
        return true;
    }

    function subAreaDelete($id) {
        $this->db->delete('subareaforrepmaster', array(
            'saId' => $id
        ));
        return true;
    }
    
    function get_allocation($condition = '') {
 
        $this->db->select('smId,smStoreCode,smStoreName ,rep_name,smCity,customer_group',false);
        $this->db->from('storemaster');
        $this->db->where('smIsActive', 1);
        if ($condition != '') {
            $this->db->where($condition);
        }
      
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return  $query->result_array();
        }
        return FALSE;
    }

    function get_allocation_table($start,$length,$order_column,$order_dir,$condition = '') {
 
        $this->db->select('smId,smStoreCode,smStoreName ,rep_name,smCity,customer_group',false);
        $this->db->from('storemaster');
        $this->db->where('smIsActive', 1);
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }

    function allocate() {

        $query = $this->db->query('TRUNCATE TABLE  `managertosubareaforrep`;');
        $query = $this->db->query('TRUNCATE TABLE  `salesreptosubareaforrep`;');
        $query = $this->db->query('TRUNCATE TABLE  `storetosubareaforrep`;');
        $query = $this->db->query('TRUNCATE TABLE  `areamatrix`;');
        $query = $this->db->query('TRUNCATE TABLE  `subareaforrepmaster`;');

        $query = "SELECT rep_name, umId, umIsSalesRep, umIsManager, smCity,smAddress2
			FROM  `storemaster` s
			LEFT JOIN usermaster ON rep_name = umUserName WHERE rep_name not like ''
			GROUP BY rep_name, smCity";
        $result = $this->db->query($query);
        $array = $result->result_array();

        foreach ($array as $value) {
            $value['smCity'] = trim($value['smCity']);
            $sub_area_name = $value['smCity'] . $value['umId'];
            $query = "INSERT INTO `subareaforrepmaster` (`saId`, `saSubAreaName`, `saGuid`, `saCreationDate`, `saTS`, `saIsActive`) 
				VALUES (NULL, '$sub_area_name', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW(), '1');";
            $this->db->query($query);
            $sub_area_for_rep_id = $this->db->insert_id();

               if ($value['umIsManager'] == 1) {
                $query = "INSERT INTO managertosubareaforrep (mtsManagerId,mtsSubAreaForRepId) VALUES (" . $value['umId'] . "," . $sub_area_for_rep_id . ");";
		$this->db->query($query);
		$query = "INSERT INTO salesreptosubareaforrep (srsSalesRepId,srsSubAreaForRepId) VALUES (" . $value['umId'] . "," . $sub_area_for_rep_id . ");";
            } else {
                $query = "INSERT INTO salesreptosubareaforrep (srsSalesRepId,srsSubAreaForRepId) VALUES (" . $value['umId'] . "," . $sub_area_for_rep_id . ");";
            }
            $this->db->query($query);
            $query = "SELECT smId FROM storemaster WHERE rep_name LIKE  '" . $value['rep_name'] . "' AND smCity = '" . $value['smCity'] . "';";

            $res = $this->db->query($query);
            $rs = $res->result_array();

            if ($rs) {

                foreach ($rs as $store) {
                    $query = "INSERT INTO storetosubareaforrep (stsStoreId,stsSubAreaForRepId) VALUES (" . $store['smId'] . "," . $sub_area_for_rep_id . ");";
                    $this->db->query($query);
                }
            }

           
            $zone_id = 1;

            $query = "SELECT amId FROM areamaster WHERE amAreaName LIKE  '" . $value['smCity'] . "';";
            $rs = $this->db->query($query)->result_array();
            $area_id = $rs[0]['amId'];

            $query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '1', '$area_id', '" . $zone_id . '1' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);

            $query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '2', '$area_id', '" . $zone_id . '2' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);

$query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '3', '$area_id', '" . $zone_id . '3' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);

            $query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '4', '$area_id', '" . $zone_id . '4' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);

$query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '5', '$area_id', '" . $zone_id . '5' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);

            $query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '6', '$area_id', '" . $zone_id . '6' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);

$query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '7', '$area_id', '" . $zone_id . '7' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);

            $query = "INSERT INTO `areamatrix` 
			(`amxId`, `amxZoneId`, `amxDivisionId`, `amxAreaId`, `amxCode`, `amxSubAreaForRepId`, `amxGuid`, `amxCreationDate`, `amxTS`) 
			VALUES (NULL, '1', '8', '$area_id', '" . $zone_id . '8' . $area_id . "', '$sub_area_for_rep_id', '851C5B71-4756-4404-8081-8EF51DD37DBD', CURRENT_TIMESTAMP, NOW());";
            $this->db->query($query);
        }
       
$query = "INSERT into managertosubareaforrep 
			SELECT null,h.parent_user_id,srsSubAreaForRepId,'','','' 
			FROM `salesreptosubareaforrep` s 
			JOIN hierarchy_mapping h on h.user_id = s.`srsSalesRepId` 
			GROUP BY srsSubAreaForRepId , parent_user_id";
            $this->db->query($query);

    }
    function get_customer_types(){
        $this->db->select('customer_group id, customer_group name');
        $this->db->from('storemaster');
        $this->db->group_by('customer_group');
        $query = $this->db->get();
        if($query->num_rows > 0){
            return $query->result_array();
        }
        return false;        
    }

    function get_customers(){
        $this->db->select('smId as id, smStoreName as name');
        $this->db->from('storemaster');
       // $this->db->group_by('customer_group');
        $query = $this->db->get();
        if($query->num_rows > 0){
            return $query->result_array();
        }
        return false;        
    }

    function get_departments(){
        $this->db->select('department_id as id, department_name as name');
        $this->db->from('departmentmaster');
       // $this->db->group_by('customer_group');
        $query = $this->db->get();
        if($query->num_rows > 0){
            return $query->result_array();
        }
        return false;        
    }

   function doctorDetById($id) {
        $this->db->where('dmId', $id);
        $query = $this->db->get('doctormaster');
        return $query;
    }
    function showDoctorDet($start,$length,$order_column,$order_dir,$condition = '') {
              
        $this->db->select('dmid,dmDoctorCode,dmDoctorName',false);
        $this->db->from('doctormaster');
       
        if ($condition != '') {
            $this->db->where($condition);
        }
        $data['num_rows'] = $this->db->count_all_results();
        $this->db->order_by($order_column,$order_dir);
        $this->db->limit($length,$start);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data['result'] =  $query->result_array();
        }else{
             $data['result'] = false;
        }
        return $data;
    }
    function doctorDelete($id) {
        $this->db->delete('doctormaster', array(
            'dmid' => $id
        ));
        return true;
       
       
    }
    function updatedoctorDet($data, $id) {
        $this->db->where('dmid', $id);
        $this->db->update('doctormaster', $data);
        return true;
    }


}

?>
