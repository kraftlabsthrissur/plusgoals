<?php
header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=".$sumDet['SONo'].'_'.$sumDet['StoreCode'].'_'.$sumDet['Date'].".xml");
header("Pragma: no-cache");
header("Expires: 0");
?>
<SalesOrderData>
	<Title>Sales Order Report</Title>
	<Customer><?php echo $sumDet['StoreName'].' ['.$sumDet['StoreCode'].'] ';?></Customer>
	<OrderNo><?php echo $sumDet['SONo'];?></OrderNo>
	<UserType><?php echo $sumDet['OrderBy'];?></UserType>
	<UserName><?php echo $sumDet['Name'];?></UserName>
	<OrderDate><?php echo $sumDet['Date'];?></OrderDate>
	<DivCode><?php echo $sumDet['DivCode'];?></DivCode>
	<CustomerCode><?php echo $sumDet['StoreCode'];?></CustomerCode>
	<DivName><?php echo $sumDet['DivName'];?></DivName>
	<DespatchMode><?php echo $sumDet['Despatch'];?></DespatchMode>
	<NetAmount><?php echo $sumDet['NetAmt'];?></NetAmount>
	<items>
<?
	foreach($data1 as $item) {
?>
		<ItemDet>
			<ItemId><?php echo $item['productId'];?></ItemId>
			<ItemCode><?php echo $item['productCode'];?></ItemCode>
			<Quantity><?php echo $item['sodQty'];?></Quantity>
			<OfferQty><?php echo $item['sodOfferQty'];?></OfferQty>
			<TotalQty><?php echo $item['sodQty']+$item['sodOfferQty'];?></TotalQty>
		</ItemDet>
<? } ?>
	</items>
</SalesOrderData>