<?php
$this->load->view('includes/header');
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/salesorderSR.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/storemaster.css"/>
<script type="text/javascript">
		
		function setProduct()
		{
			$("#areaList tr").dblclick(function() {
				$("#areaList tr").removeClass("selected");
				$(this).addClass("selected");
				if($("#areaResult .selected").length > 0)
				{
					$("#hid_txtArea").val($("#areaResult .selected input").val());
					$("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
				}
				$("#areaMaster").slideUp(500, function() {
					$("#overlayA").fadeOut(500);
				});
			});
			$("#areaList tr").click(function() {
				$("#areaList tr").removeClass("selected"); 
				$(this).addClass("selected");
			});
			$("#divList tr").dblclick(function() {
				$("#divList tr").removeClass("selected"); 
				$(this).addClass("selected");
				if($("#divResult .selected").length > 0)
				{
					$("#hid_txtDivision").val($("#divResult .selected input").val());
					$("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
					$("#hid_div_id").val($("#divResult .selected td.last").text().ltrim().rtrim());
				}
				$("#divMaster").slideUp(500, function() {
					$("#overlayD").fadeOut(500);
				});
			});
			$("#divList tr").click(function() {
				$("#divList tr").removeClass("selected"); 
				$(this).addClass("selected");
			});
			$("#storeList tr").dblclick(function() {
				$("#storeList tr").removeClass("selected"); 
				$(this).addClass("selected");
				if($("#storeResult .selected").length > 0)
				{
					$("#hid_txtCustomer").val($("#storeResult .selected input").val());
					$("#txtCustomer").val($("#storeResult .selected td.first").text().ltrim().rtrim());
					$("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
				}
				$("#storeMaster").slideUp(500, function() {
					$("#overlay").fadeOut(500);
				});
			//closePopup("storeMaster");
			});
			$("#storeList tr").click(function() {
				$("#storeList tr").removeClass("selected"); 
				$(this).addClass("selected");
			});
		}
		function openPopUp(divId)
		{
			var dWidth = $(document).width();
			var pLeft = (($(window).width())) - 502;
			var dHeight = $(document).height();
			var pHeight = (($(window).height())) - 386 + $(window).scrollTop();
			$("#overlay").css("width", dWidth + "px");
			$("#overlay").css("height", dHeight + "px");
			$("#overlay").fadeIn(500, function() {
				$("#"+divId).css("left", pLeft / 2 + "px");
				$("#"+divId).css("top", pHeight / 2 + "px");
				$("#"+divId).slideDown(500);
			});
			return false;
		}
		function setareaList(searchString) {
			$.ajax({
			  url: "<?php echo base_url(); ?>index.php/common/getArea/"+searchString,
			  success: function(message){
				$("#areaResult").html("");
				$("#areaResult").html(message);
				setProduct();
			  }
			});
		}
		function setDivisionList(searchString) {
			$.ajax({
			  url: "<?php echo base_url(); ?>index.php/common/getDivisionMaster/"+searchString,
			  success: function(message){
				$("#divResult").html("");
				$("#divResult").html(message);
				setProduct();
			  }
			});
		}
		function setStoreList(type, searchString) {
			if(searchString == '')
			{
				searchString = "searchstringMissing";
			}
			var areaId = $("#hid_txtArea").val();
			var divId = $("#hid_txtDivision").val();
			$.ajax({
			  url: "<?php echo base_url(); ?>index.php/common/getStoreMaster/"+type+"/"+searchString+"/"+areaId+"/"+divId,
			  success: function(message){
				$("#storeResult").html("");
				$("#storeResult").html(message);
				setProduct();
			  }
			});
		}
	$(function() {
		$.datepicker.setDefaults({
			dateFormat: 'dd.mm.yy'
		});
		$( ".datepicker " ).datepicker({ changeYear: true });
		$( ".datepicker " ).datepicker({ changeMonth: true });
		$( ".datepicker " ).datepicker( "option", "changeYear", true );
		$( ".datepicker " ).datepicker( "option", "changeMonth", true );
		$( ".datepicker " ).datepicker({ monthNames: ["Januar","Februar","Marts","April","Maj","Juni","Juli","August","September","Oktober","November","December"] });
		//getter
var monthNames = $( ".datepicker " ).datepicker( "option", "monthNames" );
//setter
$( ".datepicker " ).datepicker( "option", "monthNames", ["Januar","Februar","Marts","April","Maj","Juni","Juli","August","September","Oktober","November","December"] );
		var $radios = $('input:radio[name=cashType]');
		if($radios.is(':checked') === false) {
			$radios.filter('[value=Cash]').attr('checked', true);
			$("#det_chq input").attr('disabled', 'disabled');
			$('#divChk').hide();
		}
		$(".datepicker").datepicker();
		$("#btnNext").attr("disabled","disabled");
		$("#txtCustomer").attr("readonly","readonly");
		$(".datepicker").attr("readonly","true");
		$("#txtArea").attr("readonly","readonly");
		$("#txtTotal").attr("readonly","readonly");
		$("#txtDivision").attr("readonly","readonly");
		
		$("#txtCashAmount, #txtChequeAmount").keydown(function(event) {
        // Allow: backspace, delete, tab and escape
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else {
				// Ensure that it is a number and stop the keypress
				if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
					event.preventDefault(); 
				}   
			}
		});
		
		String.prototype.ltrim = function() {
			return this.replace(/^\s+/,"");
		}
		String.prototype.rtrim = function() {
			return this.replace(/\s+$/,"");
		}
		setProduct();
		
		$("#closediv ,#divClose").click(function(){
			$("#divMaster").slideUp(500, function() {
				$("#overlayA").fadeOut(500);
			});
			return false;
		});
		$("#closeStore ,#storeClose").click(function(){
			closePopup("storeMaster");
			return false;
		});
		function closePopup(divId) {
			$("#" + divId).slideUp(500, function() {
				$("#overlay").fadeOut(500);
			});
		}
		$("#btnDivision").click(function(){
					$("#divValue").val("");
					setDivisionList('all');
					
			var dWidth = $(document).width();
			var pLeft = (($(window).width())) - 502;
			var dHeight = $(document).height();
			var pHeight = (($(window).height())) - 386 + $(window).scrollTop();
			$("#overlayA").css("width", dWidth + "px");
			$("#overlayA").css("height", dHeight + "px");
			$("#overlayA").fadeIn(500, function() {
				$("#divMaster").css("left", pLeft / 2 + "px");
				$("#divMaster").css("top", pHeight / 2 + "px");
				$("#divMaster").slideDown(500);
			});
			return false;
		});
		$("#btnCustomer").click(function(){
			if($("#hid_txtArea").val() != "" && $("#hid_txtDivision").val() != ""){
				$("#storeValue").val("");
				$("#codeValue").val("");
				setStoreList('all','');
				openPopUp("storeMaster");
				return false;
			}
			else{
				if($("#hid_txtArea").val() != "")
				{
					alert('Please choose Division');
				}
				else
				{
					alert('Please choose Area');
				}
				return false;
			}
		});
		$("#btnArea").click(function(){
					$("#areaValue").val("");
					setareaList('all');
					
			var dWidth = $(document).width();
			var pLeft = (($(window).width())) - 502;
			var dHeight = $(document).height();
			var pHeight = (($(window).height())) - 386 + $(window).scrollTop();
			$("#overlayA").css("width", dWidth + "px");
			$("#overlayA").css("height", dHeight + "px");
			$("#overlayA").fadeIn(500, function() {
				$("#areaMaster").css("left", pLeft / 2 + "px");
				$("#areaMaster").css("top", pHeight / 2 + "px");
				$("#areaMaster").slideDown(500);
			});
			return false;
		});
		$("#areaSearch").click(function() {
			var searchString = "";
			if($("#areaValue").val().trim() != "") {
				searchString = $("#areaValue").val();
			}
			else {
				alert("Please enter a value.");
				return false;
			}
			setareaList(searchString);
		});
		$("#divSearch").click(function() {
			var searchString = "";
			if($("#divValue").val().trim() != "") {
				searchString = $("#divValue").val();
			}
			else {
				alert("Please enter a value.");
				return false;
			}
			setDivisionList(searchString);
		});
		
		$("#storeSearch").click(function() {
			var type = "store";
			var searchString = "";
			if($("#storeValue").val().trim() != "") {
				searchString = $("#storeValue").val();
			}
			else if($("#storeCodeValue").val().trim() != "") {
				type = "code";
				searchString = $("#storeCodeValue").val();
			}
			else {
				type='all';
				searchString = 'searchstringMissing';
				//alert("Please enter a value.");
				//return false;
			}
			setStoreList(type,searchString);
		});
		$("#closearea ,#areaClose").click(function(){
			$("#areaMaster").slideUp(500, function() {
				$("#overlayA").fadeOut(500);
			});
			return false;
		});
		$("#areaSelect").click(function() {
			if($("#areaResult .selected").length > 0)
			{
				$("#hid_txtArea").val($("#areaResult .selected input").val());
				$("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
			}
				$("#areaMaster").slideUp(500, function() {
					$("#overlayA").fadeOut(500);
				});
		});	
		$("#divSelect").click(function() {
			if($("#divResult .selected").length > 0)
			{
				$("#hid_txtDivision").val($("#divResult .selected input").val());
				$("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
				$("#hid_div_id").val($("#divResult .selected td.last").text().ltrim().rtrim());
			}
				$("#divMaster").slideUp(500, function() {
					$("#overlayD").fadeOut(500);
				});
		});
		$("#storeSelect").click(function() {
			if($("#storeResult .selected").length > 0)
			{
				$("#hid_txtCustomer").val($("#storeResult .selected input").val());
				$("#txtCustomer").val($("#storeResult .selected td.first").text().ltrim().rtrim());
				$("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
			}
			closePopup("storeMaster");
		});
		
		$("input:radio").click(function() 
		{
			var id=$(this).attr("id");
			$("#det_" + id + " input").removeAttr('disabled', 'disabled');
			if(id == "chq") {
				$("#det_cash input").attr('disabled', 'disabled');
				$("#det_cash input").val('');
				$('#divCash').hide();
				$('#divChk').show();
			} 
			else {
				$("#det_chq input").attr('disabled', 'disabled');
				$("#det_chq input").val('');
				$('#divCash').show();
				$('#divChk').hide();
			}
		});
	});
	
	function btnSubmit_Click()
	{
		var mode = '';
		var date = '';
		var amount = '';
		var chequeNo = '';
		var bank = '';
		var remark = $("#txtRemarks").val();
		var id = $("input[name=cashType]:checked").attr('id'); 
		if(id == 'cash')
		{
			mode = 'Cash';
			date = $("#txtCollectionDate").val();
			amount = $('#txtCashAmount').val();
			chequeNo = $('#txtReceiptNo').val();
			bank = 'NA';
		}
		else
		{
			mode = 'ChequeDD';
			date = $("#txtCollectionChequeDate").val();
			amount = $('#txtChequeAmount').val();
			chequeNo = $('#txtChequeNo').val();
			bank = $('#txtBank').val();
		}
		if(date != '' && amount !='' && chequeNo!= '' && bank != '')
		{
		$.ajax({
			url: "<?php echo base_url();?>index.php/common/setSOListByMRep/"+mode+"/"+dateConvertion(date)+"/"+amount+"/"+chequeNo+"/"+bank+"/"+remark,
			success: function(message){
				 //alert(message);
				// return false;
				if(message)
				{
					var row = '<div class="divRowHead" id="divRow_' + chequeNo + '">';
					row += '<div class="colMode">'+mode+'</div>';
					row += '<div class="colDate">' + date + '</div>';
					row += '<div class="colAmount amt">' + amount + '</div>';
					row += '<div class="colCheckNo">' + chequeNo + '</div>';
					row += '<div class="colBank">' + bank + '</div>';
					row += '<div class="colcloseval">';
					row += '<input class="btn btn-small btn-danger" type="button" onclick="javascript:btnRemoveSO_Click(\'divRow_' + chequeNo + '\');" value="Remove" />';
					row += '</div></div>';
					$("#hid_isAdded").val(1);
					$("#addedRows").append(row);
					var total=0;
					$(".amt").each(function(){
						//total = total + parseInt($(this).text());
						total = (parseFloat(total) + (parseFloat($(this).text()*100)/100)).toFixed(2);
					});
					$("#txtTotal").val(total);
					//$("#hid_isAdded").val(1);
				}
				else
				{
					alert('This chequeNo/ReceiptNo is already exists!');
					return false;
				}
				$("#det_cash input").val('');
				$("#det_chq input").val('');
				$("#txtRemarks").val('');
			}
		});
		}
		else
		{
			alert('Please give corresponding datas');
			return false;
		}
	}
	
	function dateConvertion(dateOrg)
	{
		//alert(dateOrg);
		var dateSplit = dateOrg.split('.');
		var date = dateSplit[2]+'-'+dateSplit[1]+'-'+dateSplit[0];
		//alert(date);
		return date;
	}
	function btnRemoveSO_Click(chequeNo)
	{
		var chNo = chequeNo.split('_')[1];
		//alert(chNo);
		$.ajax({
			url: "<?php echo base_url();?>index.php/common/removeSOMSRList/"+chNo,
			success: function(message){
				//alert(message);
				if(message)
				{
					$("#"+chequeNo).val("");
					$("#"+chequeNo).html("");
					$("#"+chequeNo).hide();
					var total=0;
					$(".amt").each(function(){
						//total = total + parseInt($(this).text());
						total = (parseFloat(total) + (parseFloat($(this).text()*100)/100)).toFixed(2);
					});
					$("#txtTotal").val(total);
				}
				else
				{
					alert('Error in removing');
				}
			}
		});
	}
	function btnSaveClick()
	{
		var amount = $("#txtTotal").val();
		var divId =$("#hid_div_id").val();
		var divName =$("#txtDivision").val();
		var areaId =$("#hid_txtArea").val();
		var DespatchMode=$("#ddlMode").val();
		if(areaId == "")
		{
			alert("Select Area!!!");
			return false;
		}
		if(divId == "")
		{
			alert("Select Division!!!");
			return false;
		}
		if($("#txtCustomer").val()== "")
		{
			alert("Please Choose Store!!!");
			return false;
		}
		
		if($("#hid_isAdded").val()!= 1)
		{
			alert("Please select Cash/Cheque as pay Mode");
			return false;
		}
		$.ajax({
			url:"<?php echo base_url();?>index.php/common/saveSalesOrderMSR/"+divId+"/"+$("#hid_txtCustomer").val()+"/"+amount,
			success: function(message){
				//alert('success');
				$("#addedRows").html("");
				$("#isSaved").val(1);
			}
		});
		
	}
	function btnNextClick()
	{
		if($("#hid_txtArea").val() == '')
		{
			alert("Please select Area...");
			return false;
		}
		if($("#hid_txtDivision").val() == '')
		{
			alert("Please select Division...");
			return false;
		}
		if($("#hid_txtCustomer").val() == '')
		{
			alert("Please select Customer...");
			return false;
		}
		if($("#isSaved").val() == 1)
		{
			$("#btnNext").attr("href","<?php echo base_url(); ?>index.php/common/salesorder/"+$("#hid_txtArea").val()+"/"+$("#txtArea").val()+"/"+$("#hid_txtDivision").val()+"/"+$("#hid_div_id").val()+"/"+$("#txtDivision").val()+"/"+$("#hid_txtCustomer").val()+"/"+encodeURI($("#txtCustomer").val().trim()));
		}
	}
	
</script>
<?php
$this->load->view('includes/menu');
?>
	<div class="span10">
		<div id="overlay"></div>
			<div id="content" class="well">
				<div id="main_content">
					<h2>Sales Order</h2>
				</div>
				<div id ="subcontent">
					<div id="tablecontent">
						<form name="SRsalesORData" method="post" action="<?php echo base_url(); ?>index.php/common/salesorderSR">
							<div class="well" style="background:#FFF;">
								<div class="table1">
									<div class="align">
										<table>
											<tr>
												<td>
													Area :
												</td>
												<td>
													<input type="text" name="txtArea" id="txtArea"/>
													<input type="hidden" name="hid_txtArea" id="hid_txtArea"/>
												</td>
												<td>
													<input type="button" name="btnArea" id="btnArea" Value="..." class="btn btn-mini btn-warning" />
												</td>
											</tr>
										</table>
									</div>
									<div class="align">
										<table>
											<tr>
												<td>
													Division :
												</td>
												<td>
													<input type="text" name="txtDivision" id="txtDivision"/>
													<input type="hidden" id="hid_txtDivision" name="hid_txtDivision"/>
													<input type="hidden" id="hid_div_id" name="hid_div_id" />
												</td>
												<td>
													<input type="button" name="btnDivision" class="btn btn-mini btn-warning" Value="..." id="btnDivision" />
												</td>
											</tr>
										</table>
									</div>
									<div>
										<table>
											<tr>
												<td>
													Customer :
												</td>
												<td>
													<input type="text" name="txtCustomer" id="txtCustomer"/>
													<input type="hidden" name="hidTxtCustomer" id="hid_txtCustomer"/>
												</td>
												<td>
													<input type="button" name="btnCustomer" class="btn btn-mini btn-warning" Value="..." id="btnCustomer" />
												</td>
											</tr>
										</table>
									</div>
								</div>
								<div class="border well">
									<div class="input">
										<div>
											<input type="radio" name="cashType" value="Cash" id="cash"/> Cash
										</div>
										<div>
											<input type="radio" name="cashType" value="check" id="chq"/> Cheque/DD
										</div>
										
									</div>
									<div id="divChkCash">
										<div id="divCash">
											<table id="det_cash">
												<tr>
													<td>
														Collection Date
														<input type="text" id="txtCollectionDate" name="txtCollectionDate" class="datepicker" /> 
													</td>
													<td>
														Amount
														<input type="text" name="txtCashAmount" id="txtCashAmount"/>
													</td>
													<td>
														Receipt No:
														<input type="text" name="txtReceiptNo" id="txtReceiptNo"/>
													</td>
												</tr>
											</table>
										</div>
										<div id="divChk">
											<table id="det_chq">
												<tr>
													<td>
														Cheque Date
														<input type="text" id="txtCollectionChequeDate" name="txtCollectionChequeDate" class="datepicker"/>
													</td>
													<td>
														Amount
														<input type="text" name="txtChequeAmount" id="txtChequeAmount"/>
													</td>
													<td>
														Cheque No:
														<input type="text" name="txtChequeNo" id="txtChequeNo"/>
													</td>
													<td>
														Bank
														<input type="text" name="txtBank" id="txtBank" />
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div><!--border-->
								<!--div class="table2">
									<div>
										<input type="radio" name="cashType" value="Cash" id="cash"/> Cash<br />
									</div>
									<table id="det_cash">
										<tr>
											<td>
												Collection Date
												<input type="text" id="txtCollectionDate" name="txtCollectionDate" class="datepicker" /> 
											</td>
											<td>
												Amount
												<input type="text" name="txtCashAmount" id="txtCashAmount"/>
											</td>
											<td>
												Receipt No:
												<input type="text" name="txtReceiptNo" id="txtReceiptNo"/>
											</td>
										</tr>
									</table>
								</div>
								<div class="table3">
									<div>
										<input type="radio" name="cashType" value="check" id="chq"/> Cheque/DD<br />
									</div>
									<table id="det_chq">
										<tr>
											<td>
												Cheque Date
												<input type="text" id="txtCollectionChequeDate" name="txtCollectionChequeDate" class="datepicker"/>
											</td>
											<td>
												Amount
												<input type="text" name="txtChequeAmount" id="txtChequeAmount"/>
											</td>
											<td>
												Cheque No:
												<input type="text" name="txtChequeNo" id="txtChequeNo"/>
											</td>
											<td>
												Bank
												<input type="text" name="txtBank" id="txtBank" />
											</td>
										</tr>
									</table>
								</div-->
								<div class="table4">
									<div class="remarks">
										Remarks
										<input type="text" name="txtRemarks" id="txtRemarks" /> 
									</div>
									<div class="submit">
										<input type="button" id="btnSubmit" name="btnSubmit"  class="linkButton btn btn-primary" value="Submit" onclick="btnSubmit_Click();"/>
										<input type="hidden" id="hid_isAdded" name="hid_isAdded"  class="linkButton" Value="0"/>
									</div>
								</div>
							</div>
							<div id="SOview" class="SalesOrder">
								<div style="background:#BD4247; width:100%;">
									<div class="divTitleRow">
										<div class="colMode">Mode</div>
										<div class="colDate">Date</div>
										<div class="colAmount">Amount</div>
										<div class="colCheckNo">CheckNo</div>
										<div class="colBank">Bank</div>
										<div class="colclose">Remove</div>
									</div>
								</div>
								<div class="item" id="addedRows"></div>
							</div>
							<div class="total">
								<div>
									Total
									<input type="text" id="txtTotal" name="txtTotal" value="0"/>
								</div>
							</div>
							<div class="savepart">
								<div class="save">
									<input type="hidden" id="isSaved"  class="linkButton" value="0";/>
									<input type="button" id="btnSave" name="btnSave" value="Save"  class="linkButton btn btn-primary" onclick = "return btnSaveClick();"/>
								</div>
								<div class="next">
									<a id="btnNext" onclick="btnNextClick();"  class="linkButton btn btn-primary" >Next</a>
									<!--input type="button" id="btnNext" name="btnNext" value="Next" onclick="btnNextClick();"/-->
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="store" id="productMaster">
					<div>
						<div class="title">
							<div class="titleText">
								<b>Product Master</b>
							</div>
							<div class="titleClose">
								<a id="productClose" href="#">X</a>
							</div>
						</div>
						<div class="search">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td rowspan="2">
										<img src="<?php echo base_url(); ?>/CSS/images/view_calendar_list.png" width="60" height="60" />
									</td>
									<td>
										<b>Product</b>
									</td>
									<td>
										<input type="text" name="store" id="productValue" />
									</td>
									<td rowspan="2">
										<input type="submit" value="Search" id="productSearch" />
									</td>
								</tr>
								<tr>
									<td>
										<b>Code</b>
									</td>
									<td>
										<input type="text" name="code" id="codeValue" />
									</td>
								</tr>
							</table>
						</div>
						<div class="list">
							<div class="title">
								<div class="col1">Product Name</div>
								<div class="col2">Product Code</div>
								<div class="col3"></div>
							</div>
							<div class="items" id="productsList">
								<table cellpadding="0" cellspacing="0" id="productResult">
									
								</table>
							</div>
						</div>
						<div class="footer">
							<div>
								<input type="submit" class="linkButton btn btn-primary" value="Ok" id="productSelect" />
								<a href="#" id="closeProduct" class="linkButton btn btn-primary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
				<div id="overlayA"></div>
				<div class="store" id="areaMaster">
					<div>
						<div class="title">
							<div class="titleText">
								<b>Area Master</b>
							</div>
							<div class="titleClose">
								<a id="areaClose" href="#">X</a>
							</div>
						</div>
						<div class="search">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td rowspan="2">
										<img src="<?php echo base_url(); ?>/CSS/images/view_calendar_list.png" width="60" height="60" />
									</td>
									<td>
										<b>Areas</b>
									</td>
									<td>
										<input type="text" name="areaVal" id="areaValue" />
									</td>
									<td rowspan="2">
										<input type="submit" value="Search" id="areaSearch" class="linkButton btn btn-primary" />
									</td>
								</tr>
							</table>
						</div>
						<div class="list">
							<div class="title">
								<div class="col1">Area</div>
								<div class="col3"></div>
							</div>
							<div class="items" id="areaList">
								<table cellpadding="0" cellspacing="0" id="areaResult">
									<?php 
									if ($areaArray->num_rows() > 0)
									{
									//$count=0;
										$isEven = false;
										foreach($areaArray->result() as $row)
										{
											if($isEven) {
												echo "<tr class=\"even\">";
												$isEven = false;
											}
											else {
												echo "<tr>";
												$isEven = true;
											}
											?>
												<td class="first">
													<?php echo $row->amAreaName; ?>
												</td>
												<td class="second">
												</td>
												<td class="last">
													<input type="hidden" value="<?php echo $row->amId; ?>" />
												</td>
											</tr>
											<?php
										}
									}
									?>
								</table>
							</div>
						</div>
						<div class="footer">
							<div>
								<input type="submit" class="linkButton  btn btn-primary" value="Ok" id="areaSelect" />
								<a href="#" id="closearea" class="linkButton btn btn-primary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="store" id="divMaster">
					<div>
						<div class="title">
							<div class="titleText">
								<b>Division Master</b>
							</div>
							<div class="titleClose">
								<a id="divClose" href="#">X</a>
							</div>
						</div>
						<div class="search">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td rowspan="2">
										<img src="<?php echo base_url(); ?>/CSS/images/view_calendar_list.png" width="60" height="60" />
									</td>
									<td>
										<b>Division</b>
									</td>
									<td>
										<input type="text" name="divVal" id="divValue" />
									</td>
									<td rowspan="2">
										<input type="submit" value="Search" id="divSearch" class="linkButton btn btn-primary" />
									</td>
								</tr>
							</table>
						</div>
						<div class="list">
							<div class="title">
								<div class="col1">Division</div>
								<div class="col3"></div>
							</div>
							<div class="items" id="divList">
								<table cellpadding="0" cellspacing="0" id="divResult">
									<?php 
									if ($divisionArray->num_rows() > 0)
									{
									//$count=0;
										$isEven = false;
										foreach($divisionArray->result() as $row)
										{
											if($isEven) {
												echo "<tr class=\"even\">";
												$isEven = false;
											}
											else {
												echo "<tr>";
												$isEven = true;
											}
											?>
												<td class="first">
													<?php echo $row->dmDivisionName; ?>
												</td>
												<td class="second">
												</td>
												<td class="last">
													<input type="hidden" value="<?php echo $row->dmId; ?>" />
												</td>
											</tr>
											<?php
										}
									}
									?>
								</table>
							</div>
						</div>
						<div class="footer">
							<div>
								<input type="submit" class="linkButton btn btn-primary" value="Ok" id="divSelect" class="linkButton" />
								<a href="#" id="closediv" class="linkButton btn btn-primary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="store" id="storeMaster">
					<div>
						<div class="title">
							<div class="titleText">
								<b>Store Master</b>
							</div>
							<div class="titleClose">
								<a id="storeClose" href="#">X</a>
							</div>
						</div>
						<div class="search">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td rowspan="2">
										<img src="<?php echo base_url(); ?>/CSS/images/view_calendar_list.png" width="60" height="60" />
									</td>
									<td>
										<b>Store</b>
									</td>
									<td>
										<input type="text" name="store" id="storeValue" />
									</td>
									<td rowspan="2">
										<input type="submit" value="Search" id="storeSearch" class="linkButton btn btn-primary" />
									</td>
								</tr>
								<tr>
									<td>
										<b>Code</b>
									</td>
									<td>
										<input type="text" name="code" id="storeCodeValue" />
									</td>
								</tr>
							</table>
						</div>
						<div class="list">
							<div class="title">
								<div class="col1">Store Name</div>
								<div class="col2">Store Code</div>
								<div class="col3"></div>
							</div>
							<div class="items" id="storeList">
								<table cellpadding="0" cellspacing="0" id="storeResult">
									
								</table>
							</div>
						</div>
						<div class="footer">
							<div>
								<input type="submit" class="linkButton btn btn-primary" value="Ok" id="storeSelect"class="linkButton"/>
								<a href="#" id="closeStore" class="linkButton btn btn-primary">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
$this->load->view('includes/footer');
 ?>