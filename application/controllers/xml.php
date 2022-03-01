<?php

class Xml extends Secure_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('xml');
		$this->load->model('xml_model');
	}

	var $xml;

	private function import(){
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->xml = '';
		if(! $this->upload->do_upload('xml')){
			$data = array(
				'message' => $this->upload->display_errors(),
				'status' => 'error'
			);
			return $data;
		}else{
			$data = array();
			$upload_data = $this->upload->data();
			$path = $upload_data['full_path'];
			$ext = $upload_data['file_ext'];
			$data['ext'] = $ext;
			if(strtolower($ext) !== '.xml'){
				$data['status'] = 'error';
				$data['message'] = 'Not an XML file';
				return $data;
			}
			try{
				$xml_string = $this->load->file($path, true);
				$this->xml = new SimpleXMLElement($xml_string);
				$data['status'] = 'success';
				return $data;
			}catch(Exception $e){
				$data['status'] = 'error';
				$data['message'] = 'Can\'t load XML';
				return $data;
			}
		}
	}

	public function import_customer(){
		$data = $this->import();
		if($data['status'] === 'success'){
			$size = sizeof($this->xml->Customer);
			if($size == 0){
				$data['status'] = 'error';
				$data['message'] = 'Empty customer data';
				echo json_encode($data);
				exit();
			}
			$i = 0;
			foreach($this->xml->Customer as $key => $value){
				
				$table_data['smStoreCode'] = (string)$value['CustomerCode'][0];
				$table_data['smStoreName'] = (string)$value['Name'];
				$table_data['smAddress1'] = (string)$value['Address'];
				$table_data['smAddress2'] = (string)$value['Address2'];
				$table_data['smCity'] = (string)$value['City'];
				$table_data['smPin'] = (string)$value['PostCode'];
				$table_data['smCountry'] = (string)$value['CountryRegionCode'];
				$table_data['smState'] = (string)$value['StateCode'];
				$table_data['smStructure'] = (string)$value['Structure'];
				$table_data['smSalesPersonCode'] = (string)$value['SalesPersonCode'];
				$table_data['PaymentTerms'] = (string)$value['PaymentTerms'];
				$table_data['CustomerPriceGroup'] = (string)$value['CustomerPriceGroup'];
				$table_data['CustomerDiscGroup'] = (string)$value['CustomerDiscGroup'];
				$table_data['smIsActive'] = 1;
				$result = $this->xml_model->simple_get('storemaster', 'count(smId) cnt', $table_data);
				$count = $result[0]['cnt'];
				if(! $count){
					$table_data['smCreationDate'] = date('Y-m-d H:i:s');
					$table_data['smTS'] = date('Y-m-d H:i:s');
					$this->xml_model->insert('storemaster', $table_data);
					$i += 1;
				}
			}
			$data['message'] = 'Inserted ' . $i . ' Records';
		}
		echo json_encode($data);
	}

	public function import_items(){
		$data = $this->import();
		if($data['status'] === 'success'){
			$size = sizeof($this->xml->Item);
			if($size == 0){
				$data['status'] = 'error';
				$data['message'] = 'Empty Item data';
				echo json_encode($data);
				exit();
			}
			$i = 0;
			foreach($this->xml->Item as $key => $value){
				$table_data['pmProductCode'] = (string)$value['ItemCode'][0];
				$table_data['pmProductName'] = (string)$value['Description'];
				$table_data['pmDivisionCode'] = 1;
				$table_data['pmDescription'] = (string)$value['Description'];
				$table_data['pmBasicUnitOfMeasurement'] = (string)$value['BasicUnitofMeasure'];
				$table_data['pmCategory'] = (string)$value['ProductDivision'];
				$table_data['GenProdPostingGroup'] = (string)$value['GenProdPostingGroup'];
				$table_data['TaxGroupCode'] = (string)$value['TaxGroupCode'];
				$table_data['SalesUnitofMeasure'] = (string)$value['SalesUnitofMeasure'];
				$table_data['ExciseProdPostingGroup'] = (string)$value['ExciseProdPostingGroup'];
				$table_data['ProductDivisionGrp'] = (string)$value['ProductDivisionGrp'];
				$result = $this->xml_model->simple_get('productlist', 'count(pmProductId) cnt', $table_data);
				$count = $result[0]['cnt'];
				if(! $count){
					$table_data['pmCreationDate'] = date('Y-m-d H:i:s');
					$table_data['pmTS'] = date('Y-m-d H:i:s');
					$this->xml_model->insert('productlist', $table_data);
					$i += 1;
				}
			}
			$data['message'] = 'Inserted ' . $i . ' Records';
		}
		echo json_encode($data);
	}

	public function import_customer_discount_group(){
		$data = $this->import();
		if($data['status'] === 'success'){
			$size = sizeof($this->xml->CustomerDiscountGroup);
			if($size == 0){
				$data['status'] = 'error';
				$data['message'] = 'Empty Customer Discount Group data';
				echo json_encode($data);
				exit();
			}
			$i = 0;
			foreach($this->xml->CustomerDiscountGroup as $key => $value){
				$table_data['code'] = (string)$value['Code'][0];
				$table_data['description'] = (string)$value['Description'];
				$result = $this->xml_model->simple_get('customer_discount_group', 'count(customer_discount_group_id) cnt', $table_data);
				$count = $result[0]['cnt'];
				if(! $count){
										$this->xml_model->insert('customer_discount_group', $table_data);
					$i += 1;
				}
			}
			$data['message'] = 'Inserted ' . $i . ' Records';
		}
		echo json_encode($data);
	}
	
	
	public function import_sales_price(){
		$data = $this->import();
		if($data['status'] === 'success'){
			$size = sizeof($this->xml->SalesPrice);
			if($size == 0){
				$data['status'] = 'error';
				$data['message'] = 'Empty Sales Price data';
				echo json_encode($data);
				exit();
			}
			$i = 0;
			foreach($this->xml->SalesPrice as $key => $value){
				$table_data['item_no'] = (string)$value['ItemNo'][0];
				$table_data['sales_type'] = (string)$value['SalesType'];
				$table_data['sales_code'] = (string)$value['SalesCode'];
				$table_data['starting_date'] = (string)$value['StartingDate'];
				$table_data['currency_code'] = (string)$value['CurrencyCode'];
				$table_data['variant_code'] = (string)$value['VariantCode'];
				$table_data['uom'] = (string)$value['UOM'];
				$table_data['minimum_quantity'] = (string)$value['MinimumQuantity'];
				$table_data['unit_price'] = (string)$value['UnitPrice'];
				$table_data['mrp_price'] = (string)$value['MRPPrice'];
				$table_data['Abatement'] = (string)$value['Abatement'];
				$table_data['MRP'] = (string)$value['MRP'];
				$result = $this->xml_model->simple_get('sales_price', 'count(sales_price_id) cnt', $table_data);
				$count = $result[0]['cnt'];
				if(! $count){
					$this->xml_model->insert('sales_price', $table_data);
					$i += 1;
				}
			}
			$data['message'] = 'Inserted ' . $i . ' Records';
		}
		echo json_encode($data);
	}
	
	public function import_user(){
		$data = $this->import();
		if($data['status'] === 'success'){
			$size = sizeof($this->xml->SalesPersonPurchaser);
			if($size == 0){
				$data['status'] = 'error';
				$data['message'] = 'Empty Sales Person data';
				echo json_encode($data);
				exit();
			}
			$i = 0;
			foreach($this->xml->SalesPersonPurchaser as $key => $value){
				$table_data['umUserCode'] = (string)$value['Code'];
				$table_data['umUserName'] = (string)$value['Name'];
				$table_data['umFirstName'] = (string)$value['Name'];
				
				
				$result = $this->xml_model->simple_get('usermaster', 'count(umId) cnt', $table_data);
				$count = $result[0]['cnt'];
				if(! $count){
					$table_data['umCreationDate'] = date('Y-m-d H:i:s');
					$table_data['umTS'] = date('Y-m-d H:i:s');
					$table_data['umGuid'] = '2A33D960-E4E5-4F5D-AED3-48A6E54B5325';
					$table_data['umIsActive'] = '1';
					$table_data['umPassword'] = 'password';
					$this->xml_model->insert('usermaster', $table_data);
					$i += 1;
				}
			}
			$data['message'] = 'Inserted ' . $i . ' Records';
		}
		echo json_encode($data);
	}
	
	public function import_area(){
		$data = $this->import();
		if($data['status'] === 'success'){
			$size = sizeof($this->xml->Location);
			if($size == 0){
				$data['status'] = 'error';
				$data['message'] = 'Empty Location data';
				echo json_encode($data);
				exit();
			}
			$i = 0;
			foreach($this->xml->Location as $key => $value){
				$table_data['amCode'] = (string)$value['Code'];
				$table_data['amAreaName'] = (string)$value['Name'];	
				$result = $this->xml_model->simple_get('areamaster', 'count(amId) cnt', $table_data);
				$count = $result[0]['cnt'];
				if(! $count){
					$table_data['amCreationDate'] = date('Y-m-d H:i:s');
					$table_data['amTS'] = date('Y-m-d H:i:s');
					$table_data['amGuid'] = '2A33D960-E4E5-4F5D-AED3-48A6E54B5325';
					$this->xml_model->insert('areamaster', $table_data);
					$i += 1;
				}
			}
			$data['message'] = 'Inserted ' . $i . ' Records';
		}
		echo json_encode($data);
	}
	
	public function import_customer_price_group(){
		$data = $this->import();
		if($data['status'] === 'success'){
			$size = sizeof($this->xml->CustomerPriceGroup);
			if($size == 0){
				$data['status'] = 'error';
				$data['message'] = 'Empty Customer Price Group data';
				echo json_encode($data);
				exit();
			}
			$i = 0;
			foreach($this->xml->CustomerPriceGroup as $key => $value){
				$table_data['code'] = (string)$value['Code'][0];
				$table_data['price_includes_VAT'] = (string)$value['PriceIncludesVAT'];
				$table_data['allow_invoice_disc'] = (string)$value['AllowInvoiceDisc'];
				$table_data['VAT_bus_posting_grp'] = (string)$value['VATBusPostingGrp'];
				$table_data['description'] = (string)$value['Description'];
				$table_data['allow_line_disc'] = (string)$value['AllowLineDisc'];
				$result = $this->xml_model->simple_get('customer_price_group', 'count(customer_price_group_id) cnt', $table_data);
				$count = $result[0]['cnt'];
				if(! $count){
					$this->xml_model->insert('customer_price_group', $table_data);
					$i += 1;
				}
			}
			$data['message'] = 'Inserted ' . $i . ' Records';
		}
		echo json_encode($data);
	}

}
