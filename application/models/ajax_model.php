<?php

class Ajax_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function change_password($userId, $password, $oldPassword) {
        $this->db->where(array('umId' => $userId, 'umPassword' => $oldPassword));
        $this->db->update('usermaster', array('umPassword' => $password));
        $this->db->select('umId');
        $this->db->from('usermaster');
        $this->db->where(array('umId' => $userId, 'umPassword' => $password));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function getAllStoreByUserId($userId, $last_id = 0) {
        $query = $this->db->query('SELECT Id AS StoreId,NAME AS StoreName,CODE AS StoreCode,AreaId AS AreaId,DivisionId AS DivisionId,
                                    dmCode AS DivisionCode, dmDivisionName AS DivisionName, amAreaName AS AreaName, smCity as city, smState as state, smPhone1,smAddress1,customer_group
                                        FROM userauthorizedmodeitems u 
                                        INNER JOIN storemaster s ON s.smId = Id
                                        INNER JOIN divisionmaster d ON d.dmId = DivisionId 
                                        INNER JOIN areamaster a ON a.amId = AreaId 
                                        WHERE MODE="Store" AND u.UserId = '.$userId.' AND smId > ' . $last_id . ' GROUP BY StoreId ORDER BY NAME ');
        return $query;
    }

    function getAllProductsByUserId($userId, $last_id = 0) {
        $query = $this->db->query('SELECT pmProductId, pmProductCode, pmProductName,pmCategory,pmDivisionCode,insideKeralaPrice,outsideKeralaPrice 
                                    FROM productlist p
                                    INNER JOIN divisionmaster d ON d.dmCode = p.pmDivisionCode 
                                    INNER JOIN userauthorizedmodeitems u ON u.Id = d.dmId AND u.MODE = "division"  AND u.UserId = '.$userId.' WHERE pmProductId > ' . $last_id);
        return $query;
    }

    function saveSalesOrder($storeId, $areaId, $divCode, $SalesRepId, $ManagerId, $StoreUserId, $amount, $HoId, $userName) {
        $orderno = '';
        $this->load->model('common_model');
        $branchIds = $this->common_model->getBranchIdByStoreId($storeId);

        if ($branchIds->num_rows() > 0) {
            foreach ($branchIds->result() as $row) {
                $branchId = $row->bmBranchID;
            }
        }
        
        $query = $this->db->query("SELECT CONCAT(ongOrderNoPrefix ,'',(ongLastOrderNo+1)) AS orderno FROM ordernogenerator WHERE ongBranchID = $branchId");
        foreach ($query->result() AS $row) {
            $orderNo = $row->orderno;
        }
        $q = $this->db->query('Update ordernogenerator Set ongLastOrderNo=ongLastOrderNo+1 WHERE ongBranchID =' . $branchId);
     //   $this->common_model->orderSuccessMail($branchId, $userName, $storeId);
        $query = '';
        $query = $this->db->query('INSERT INTO sosummary(sosStoreID,sosSalesRepID,sosManagerID,sosStoreUserID,sosNetAmount,sosBranchID,sosSONo,sosCreationDate,sosTS,sosDivisionCode,sosDivisionName,sosBillDate,sosBillNo,sosIsConfirmed,sosAreaId,sosHoUserId,
					sosIsPending,sosIsInProcess,sosIsSuspended,sosIsCancelled,sosIsCompleted,sosIsPartial,sosDespatch,sosDespatchMode,sosTo,sosCarrier,sosDestination,OrderedBy)
					VALUES(' . $storeId . ',' . $SalesRepId . ',' . $ManagerId . ',' . $StoreUserId . ',' . $amount . ',' . $branchId . ',"' . $orderNo . '","' . date('Y-m-d H:i:s') . '","' . date('Y-m-d H:i:s') . '", "' . $divCode . '","NA","' . date('Y-m-d H:i:s') . '","",1,' . $areaId . ',' . $HoId . ',
					0,0,0,0,0,0,"ph",1,"ph","ph","ph",' . $userName . ')');

        $insert_id = $this->db->insert_id();
        $this->db->select('sosID order_id,sosBillDate date,sosSONo invoice_number');
        $this->db->from('sosummary');
        $this->db->where(array('sosID' => $insert_id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }

    function saveSODetails($sId, $prId, $productCode, $productName, $productCategoty, $quant, $ofr, $productMRP, $amounts) {
        if ($quant == '')
            $quant = 0;
        if ($ofr == '')
            $ofr = 0;
        $query = $this->db->query('Insert into sodetail(sodSummaryID,sodProductID,sodProductCode,sodProductName,sodCategory,sodQty,sodOfferQty,sodMRP,sodAmount,sodTS)
			Values(' . $sId . ',' . $prId . ',"' . $productCode . '","' . $productName . '","' . $productCategoty . '",' . $quant . ',' . $ofr . ',' . $productMRP . ',' . $amounts . ',CURRENT_TIMESTAMP)');
        //die($query);
        RETURN TRUE;
    }

    function get_tasks($user_id, $last_id, $in = '') {
        $this->db->select('t.task_id, task_name title, task_desc description, created_by, created_date,is_read,is_done,read_date,done_date ');
        $this->db->from('tasks t');
        $this->db->join('user_tasks ut', 'ut.task_id = t.task_id');
        $this->db->where('ut.assigned_user_id', $user_id);
        if (is_array($in)) {
            if (!sizeof($in)) {
                $in = array(0);
            }
            $this->db->where_in('t.task_id', $in);
        } else {
            $this->db->where('t.task_id > ' . $last_id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function get_routes($user_id, $last_id, $in = '') {
        $this->db->select('id as route_assign_id,r.route_id,route_name,starting_location,created_by,date');
        $this->db->from('routes r');
        $this->db->join('assigned_routes a', 'a.route_id = r.route_id and a.user_id = ' . $user_id);
        $this->db->where('a.user_id', $user_id);
        if (is_array($in)) {
            if (!sizeof($in)) {
                $in = array(0);
            }
            $this->db->where_in('a.id', $in);
        } else {
            $this->db->where('a.id > ' . $last_id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }
    
     function get_expenses($user_id, $last_id, $in = '') {
        $this->db->select('*');
        $this->db->from('expenses e');
        $this->db->where('e.user_id', $user_id);
        if (is_array($in)) {
            if (!sizeof($in)) {
                $in = array(0);
            }
            $this->db->where_in('e.id', $in);
        } else {
            $this->db->where('e.id > ' . $last_id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function get_messages($user_id, $last_id, $in = '') {
        $this->db->select('d.id message_assign_id, m.message_id message_id, message_head message_title, message_content message, send_by created_by, send_time date');
        $this->db->from('messages m');
        $this->db->join('message_details d', 'm.message_id = d.message_id AND d.user_id =' . $user_id);
        $this->db->where('d.user_id', $user_id);
        if (is_array($in)) {
            if (!sizeof($in)) {
                $in = array(0);
            }
            $this->db->where_in('d.id', $in);
        } else {
            $this->db->where('d.id > ' . $last_id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function get_users($user_id, $last_id, $in = '') {
        $sql = "SELECT user_id, concat(umFirstName,' ', umLastName) user_name, role_name, u.role_id,role_name role,'' photo
		FROM usermaster u
		JOIN (SELECT * FROM  `hierarchy_mapping` WHERE parent_user_id = $user_id
			UNION ALL SELECT parent_user_id user_id, user_id parent_user_id FROM hierarchy_mapping WHERE user_id =$user_id
			UNION ALL SELECT $user_id user_id, 0 parent_user_id)h ON umId = user_id
		JOIN roles r ON r.role_id = u.role_id ";
        if (is_array($in)) {
            if (!sizeof($in)) {
                $in = array(0);
            }
            $sql .= " WHERE umId IN (" . implode(',', $in) . ")";
        } else {
            $sql .= " WHERE umId > " . $last_id;
        }
        $query = $this->db->query($sql);
        //echo $this->db->last_query().'<br/>';
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function get_route_customers($user_id, $last_id, $in = '') {

        $this->db->select("r.id route_customer_id, rd.route_id, customer_id, place, latitude, longitude, `order` sort_order,date", false);
        $this->db->from('route_details rd');
        $this->db->join('assigned_routes r', 'r.route_id = rd.route_id AND r.user_id =' . $user_id);
        $this->db->where('r.user_id', $user_id);
        if (is_array($in)) {
            if (!sizeof($in)) {
                $in = array(0);
            }
            $this->db->where_in('r.id', $in);
        } else {
            $this->db->where('r.id > ' . $last_id);
        }
        $query = $this->db->get();
        // echo $this->db->last_query().'<br/>';
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function get_calls($user_id, $last_id, $in = '') {

        $this->db->select("user_id,id server_call_id,route_id,customer_id,status,date,complaints,collection,promotional_product,order_booked,information_conveyed,
			stock_availability,created_date,route_customer_id,samples_given,products_prescribed ", false);
        $this->db->from('calls c');
        $this->db->where('c.user_id', $user_id);
        if (is_array($in)) {
            if (!sizeof($in)) {
                $in = array(0);
            }
            $this->db->where_in('c.id', $in);
        } else {
            $this->db->where('c.id > ' . $last_id);
        }
        $query = $this->db->get();
        // echo $this->db->last_query().'<br/>';
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function save_lead($form_data) {
        $condition = array('id' => $form_data['id']);
        $this->db->select('id');
        $this->db->from('new_customer_call');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $lead_id = $result['id'];
            $this->db->where($condition);
	    $form_data['modified_date'] = date("Y-m-d H:i:s");
            $this->db->update('new_customer_call', $form_data);
        } else {
	    $form_data['creation_date'] = date("Y-m-d H:i:s");
            $this->db->insert('new_customer_call', $form_data);
            $lead_id = $this->db->insert_id();
        }
        return $lead_id;
    }

    function save_call($form_data) {
        $condition = array('user_id' => $form_data['user_id'], 'route_customer_id' => $form_data['route_customer_id'], 'customer_id' => $form_data['customer_id']);
        $this->db->select('id');
        $this->db->from('calls');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $call_id = $result['id'];
            $this->db->where($condition);
            $this->db->update('calls', $form_data);
        } else {
            $this->db->insert('calls', $form_data);
            $call_id = $this->db->insert_id();
        }
        return $call_id;
    }

    function save_expense($form_data) {
        $condition = array('user_id' => $form_data['user_id'], 'route_id' => $form_data['route_id'], 'date' => $form_data['date']);
        $this->db->select('id');
        $this->db->from('expenses');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $expense_id = $result['id'];
            $this->db->where($condition);
            $this->db->update('expenses', $form_data);
        } else {
            $this->db->insert('expenses', $form_data);
            $expense_id = $this->db->insert_id();
        }
        return $expense_id;
    }

    function get_modified_data($last_id, $table_name) {
        $this->db->select('value,data_change');
        $this->db->from('data_changes');
        $this->db->where('value <= ' . $last_id);
        $this->db->where(array('table_name' => $table_name));
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = array('modified' => array(), 'deleted' => array());
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $key => $value) {
                $data[$value['data_change']][] = $value['value'];
            }
        }
        return $data;
    }

    function get_user_details($user_id) {
        $this->db->select("*");
        $this->db->from('usermaster');
        $this->db->where('umId', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return FALSE;
    }

function get_user($user_name,$password) {
        $this->db->select("u.*,r.role_name");
        $this->db->from('usermaster u');
	$this->db->join('roles r','u.role_id = r.role_id','left');
        $this->db->where('umUserName', $user_name);
        $this->db->where('umPassword', $password);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return FALSE;
    }

}

?>
