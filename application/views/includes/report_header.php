<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>	<head>		<title>Amritha</title>		<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/report.css">		<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/superfish.css">		<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/jquery-ui-1.8.17.custom.css">		<script type="text/javascript" src="<?php echo base_url(); ?>JS/JQuery.js"></script>		<script type="text/javascript" src="<?php echo base_url(); ?>JS/jquery-ui-1.8.17.custom.min.js"></script>		<script type="text/javascript" src="<?php echo base_url(); ?>JS/stockReport.js"></script>	</head>	<body>		<div id="wraper">			<div id="header">				<div id="report_logo">					<img src="<?php echo base_url(); ?>images/amritalogo.jpg" alt="AMRITHA" />				</div>				<div id="companyInfo">					<b style="font-size:15pt";>						  Amritha					</b><br />						Vallikkavu, 						Kollam<br/>						Kerala<br/>						INDIA ,						PIN - 689562									</div>				<div id="report_heading">					<div id="divPrint">						<input type="button" id="btnPrint" value=" PRINT "/>					</div>					<div id="r_head">						<b><label id="lblrptHeading"><?php echo $dates['head'];?></label></b>					</div>					<div id="reporthead_right">						From:<label id="lblFrom"></label><?php echo $dates['FromDate'];?>   - To: <label id="lblTo"><?php echo $dates['ToDate'];?></label>					</div>				</div>			</div>