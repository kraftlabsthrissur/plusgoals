<?php
header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=exceldata.xls");
header("Content-Disposition: attachment; filename=".$sumDet['SONo'].'_'.$sumDet['DivName'].'_'.$sumDet['StoreName'].' ['.$sumDet['StoreCode'].'] '.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table>
	<tr colspan=5;><td></td><td></td><td><b>Sales Order Report</b></td><tr>
	<tr><td></td><td></td><td><?php echo $sumDet['StoreName'].' ['.$sumDet['StoreCode'].'] ';?></td><tr>
	<tr><td><b>SO No: </b><?php echo $sumDet['SONo'];?></td><tr>
	<tr><td></td><td><b>Order By: </b><?php echo $sumDet['OrderBy'];?></td><tr>
	<tr></tr>
	<tr><td></td><td><b>Name: </b><?php echo $sumDet['Name'];?></td><tr>
	<tr><td><b>SO Date: </b><?php echo $sumDet['Date'];?></td><tr>
	<tr><td><b>Div Code: <b/><?php echo $sumDet['DivCode'];?></td><tr>
	<tr><td></td><td><b>Party Code: </b><?php echo $sumDet['StoreCode'];?></td><tr>
	<tr><td><b>Division: </b><?php echo $sumDet['DivName'];?></td><tr>
	<tr><td><b>Despatch: </b><?php echo $sumDet['Despatch'];?></td><tr>
</table>
<table border='1' width="70%">
<tr>
	<td>ID</td>
	<td>CODE</td>
	<td>QUANTITY</td>
	<td>OFFER</td>
	<td>MRP</td>
	<td>AMOUNT</td>
</tr>
<?
	foreach($data1 as $item) {
?>
	<tr>
		<td><?php echo $item['productId'];?></td>
		<td><?php echo $item['productCode'];?></td>
		<td><?php echo $item['sodQty'];?></td>
		<td><?php echo $item['sodOfferQty'];?></td>
		<td><?php echo $item['sodMRP'];?></td>
		<td><?php echo $item['sodAmount'];?></td>
	</tr>
<? } ?>
</table>