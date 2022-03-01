<?php
header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=" . date('YmdHis') . ".xml");
header("Pragma: no-cache");
header("Expires: 0");

$abc = '<?xml version="1.0" encoding="UTF-16" standalone="no" ?>
<Root>';
foreach($summary as $key => $value){
	$abc .= '
	<SalesHeader Customer="' . $value['StoreCode'] . '" SalesPerson="' . $value['UserCode'] . '" LocationCode="' . $value['Area'] . '" Division="' . $value['DivName'] . '" >';
	$i = 0;
	foreach($details[$key] as $k => $detail){
		$i += 10000;
		$abc .= '
		<SalesLine LineNo="' . $i . '" ItemNo.="' . $detail['productCode'] . '" Quantity="' . intval($detail['sodQty']) . '" />';
	}
	$abc .= '
	</SalesHeader>';
}

$abc .= '
</Root>';
echo $abc;