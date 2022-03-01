<?php
header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=" . $sumDet['SONo'] . '_' . $sumDet['DivName'] . '_' . $sumDet['StoreName'] . '_' . $sumDet['StoreCode'] . '_' . $sumDet['Date'] . ".xml");
header("Pragma: no-cache");
header("Expires: 0");

$abc = "<?xml version='1.0' encoding='UTF-16' standalone='no'?>
<Root>
	<SalesHeader>
		<Customer>" . $sumDet['StoreCode'] . "</Customer>
		<SalesPerson>" . $sumDet['UserCode'] . "</SalesPerson>
		<LocationCode>" . $sumDet['Location'] . "</LocationCode>
		<Division>" . $sumDet['DivName'] . "</Division>";
$items = "";
$i = 0;

foreach($data1 as $item){
	$i += 10000;
	$items .= "
		<SalesLine LineNo='" . $i . "' ItemNo.='" . $item['productCode'] . "' Quantity='" . $item['sodQty'] . "' />";
}
$abc_bottom = "
	</SalesHeader>
</Root>";
// die ($abc.$items.$abc_bottom);
// echo base64_encode($abc.$items.$abc_bottom);
echo $abc . $items . $abc_bottom;

?>