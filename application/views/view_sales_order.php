<script type="text/javascript">
    $('#right-content').on('click', '.modal .close, .modal .close-btn', function () {
        $('.modal').slideUp(800);
    });
    function setAreaDivStore()
    {
        $("#areaList tbody tr").click(function () {
            $("#areaList tr").removeClass("selected");
            $(this).addClass("selected");
        });
        $("#areaList tbody tr").dblclick(function () {
            $("#areaList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#areaResult .selected").length > 0)
            {
                $("#hid_txtArea").val($("#areaResult .selected input").val());
                $("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
            }
            $("#areaMaster").slideUp(500);
        });
        $("#divList tbody tr").click(function () {
            $("#divList tr").removeClass("selected");
            $(this).addClass("selected");
        });
        $("#divList tbody tr").dblclick(function () {
            $("#divList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#divResult .selected").length > 0)
            {
                $("#hid_txtDivision").val($("#divResult .selected input").val());
                $("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
                $("#hid_txtDivisionCode").val($("#divResult .selected td.last").text().ltrim().rtrim());
            }
            $("#divMaster").slideUp(500);
        });
        $("#storeList tbody  tr").click(function () {
            $("#storeList tr").removeClass("selected");
            $(this).addClass("selected");
        });
        $("#storeList tbody  tr").dblclick(function () {
            $("#storeList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#storeResult .selected").length > 0)
            {
                $("#hid_txtCustomer").val($("#storeResult .selected input").val());
                $("#txtCustomer").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            $("#storeMaster").slideUp(500);
            //closePopup("storeMaster");
        });
    }
    function selectRow(divId, el)
    {
        $("#" + divId + " tr").removeClass("selected");
        el.addClass("selected");
    }

    function setareaList(searchString) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/getArea/" + searchString + "/yes",
            success: function (message) {
                $("#areaResult").html(message);
                setAreaDivStore();
            }
        });
    }
    function setDivisionList(searchString) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/getDivisionMaster/" + searchString + "/yes",
            success: function (message) {
                $("#divResult").html("");
                $("#divResult").html(message);
                setAreaDivStore();
            }
        });
    }
    function setStoreList(type, searchString) {
        if (searchString == '')
        {
            searchString = "searchstringMissing";
        }
        var areaId = $("#hid_txtArea").val();
        var divId = $("#hid_txtDivision").val();
        //var divCode=$("#hid_txtDivisionCode").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/getStoreMaster/" + type + "/" + searchString + "/" + areaId + "/" + divId + "/yes",
            success: function (message) {

                $("#storeList").html(message);
                setAreaDivStore();
            }
        });
    }
    $(function () {

		$('.select-all').click(function(){
			if($(this).is(':checked')){
				$('.select').each(function(){
					$(this).selected(true);
				});
			}else{
				$('.select').each(function(){
					$(this).selected(false);
				});
			}
		});
		$('body').on('click','.download-orders',function(){
			var order_ids = '';
            var flag = false;
            $('.select').each(function(){
	         if($(this).is(':checked')){
                     flag = true;
                     order_ids += $(this).val() + '_';
                }
	     });
            if(flag){
                order_ids = order_ids.slice(0,-1);  
                window.location = "<?php echo base_url(); ?>index.php/common/downloadSalesOrders/"+order_ids;
            }else{
                alert('Select at least an order to download');
            }
       });
        
        $.datepicker.setDefaults({
            //    dateFormat: 'dd.mm.yy'
        });
        $('#divAjaxLoader').hide();
        createAutoComplete("#txtArea", "index.php/common/getAreaAutocomplete/", "all", '', '');
        createAutoComplete("#txtDivision", "index.php/common/getDivisionAutocomplete/", "all", '', '');
        createAutoComplete("#txtCustomer", "index.php/common/getCustomerAutocomplete/", 'hid_txtArea', 'hid_txtDivision', '');
        //alert( "<?php echo $details['status']; ?>");
        var checktype = '';
        checktype = "<?php echo $details['status']; ?>";
        if (checktype == 'sosIsPartial')
        {
            $("#chkPartial").prop("checked", true);
        }
        else if (checktype == 'sosIsCompleted')
        {
            $("#chkComplete").prop("checked", true);
        }
        else if (checktype == 'sosIsCancelled')
        {
            $("#chkcancel").prop("checked", true);
        }
        else if (checktype == 'sosIsSuspended')
        {
            $("#chkSuspend").prop("checked", true);
        }
        else if (checktype == 'sosIsInProcess')
        {
            $("#chkInProcess").prop("checked", true);
        }
        else if (checktype == 'sosIsPending')
        {
            $("#chkPending").prop("checked", true);
        }
        if ("<?php echo $details['OrderFromDate']; ?>" != '')
        {
            $("#txtOrderFrom").val(dateConvertToOrg("<?php echo $details['OrderFromDate']; ?>"));
            $("#txtOrderTo").val(dateConvertToOrg("<?php echo $details['OrderToDate']; ?>"));
            submitClick();
        }


        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd.mm.yy'
        });

        String.prototype.ltrim = function () {
            return this.replace(/^\s+/, "");
        }
        String.prototype.rtrim = function () {
            return this.replace(/\s+$/, "");
        }
        setAreaDivStore();
        $("#closediv ,#divClose").click(function () {
            $("#divMaster").slideUp(500);
            return false;
        });
        $("#closeStore ,#storeClose").click(function () {
            closePopup("storeMaster");
            return false;
        });
        function closePopup(divId) {
            $("#" + divId).slideUp(500);
        }
        $("#btnDivision").click(function () {
            $("#divValue").val("");
            $("#divMaster").slideDown(500);
            return false;
        });
        $("#btnCustomer").click(function () {
            if ($("#hid_txtArea").val() != "" && $("#hid_txtDivision").val() != "") {

                setStoreList('all', '');
                $("#storeMaster").slideDown(500);
                return false;
            }
            else {
                if ($("#hid_txtArea").val() != "")
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
        $("#btnArea").click(function () {
            $("#areaValue").val("");
            $('#txtCustomer').val('');
            $('#hid_txtCustomer').val('');
            $("#areaMaster").slideDown(500);
            return false;
        });

        $("#divSearch").click(function () {
            var searchString = "";
            if ($("#divValue").val().trim() != "") {
                searchString = $("#divValue").val();
            }
            else {
                alert("Please enter a value.");
                return false;
            }
            setDivisionList(searchString);
        });

        $("#storeSearch").click(function () {
            var type = "store";
            var searchString = "";
            if ($("#storeValue").val().trim() != "") {
                searchString = $("#storeValue").val();
            }
            else if ($("#storeCodeValue").val().trim() != "") {
                type = "code";
                searchString = $("#storeCodeValue").val();
            }
            else {
                type = 'all';
                searchString = 'searchstringMissing';
                //alert("Please enter a value.");
                //return false;
            }
            setStoreList(type, searchString);
        });
        $("#closearea ,#areaClose").click(function () {
            $("#areaMaster").slideUp(500);
            return false;
        });
        $("#areaSelect").click(function () {
            if ($("#areaResult .selected").length > 0)
            {
                $("#hid_txtArea").val($("#areaResult .selected input").val());
                $("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
            }
            $("#areaMaster").slideUp(500);
        });
        $("#divSelect").click(function () {
            if ($("#divResult .selected").length > 0)
            {
                $("#hid_txtDivision").val($("#divResult .selected input").val());
                $("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
                $("#hid_txtDivisionCode").val($("#divResult .selected td.last").text().ltrim().rtrim());
            }
            $("#divMaster").slideUp(500);
        });
        $("#storeSelect").click(function () {
            if ($("#storeResult .selected").length > 0)
            {
                $("#hid_txtCustomer").val($("#storeResult .selected input").val());
                $("#txtCustomer").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            closePopup("storeMaster");
        });
    });

    function submitClick()
    {
        var status = '';
        var divName = '';
        var divId = '';
        var areaName = '';
        var areaId = '';
        var storeName = '';
        var storeId = '';
        if ($('#txtDivision').val() != "")
        {
            divName = $('#txtDivision').val();
            //divId = $('#hid_txtDivision').val();
            divId = $('#hid_txtDivisionCode').val();
        }
        // else
        // {
        // alert('Please select division');
        // return false;
        // }
        if ($('#txtArea').val() != "")
        {
            areaName = $('#txtArea').val();
            areaId = $("#hid_txtArea").val();
        }

        if ($('#txtCustomer').val() != "")
        {
            storeName = $('#txtCustomer').val();
            storeId = $("#hid_txtCustomer").val();
            //alert(storeName);
        }
        if ($("#txtOrderFrom").val() != "")
        {
            var OrderFromDate = dateConvertion($("#txtOrderFrom").val());
        }
        else
        {
            alert('Please select OrderFromDate');
            return false;
        }
        if ($("#txtOrderTo").val() != "")
        {
            var OrderToDate = dateConvertion($("#txtOrderTo").val());
        }
        else
        {
            alert('Please select OrderToDate');
            return false;
        }
        if ($("input:checked").length !== 0)
        {

            status += '&confirmST=0';
            if ($("#chkNew").is(":checked"))
                status += '&newST=1';
            else
                status += '&newST=0';
            if ($("#chkPartial").is(":checked"))
                status += '&partialST=1';
            else
                status += '&partialST=0';
            if ($("#chkComplete").is(":checked"))
                status += '&completeST=1';
            else
                status += '&completeST=0';
            if ($("#chkcancel").is(":checked"))
                status += '&cancelST=1';
            else
                status += '&cancelST=0';
            if ($("#chkSuspend").is(":checked"))
                status += '&suspendST=1';
            else
                status += '&suspendST=0';
            if ($("#chkInProcess").is(":checked"))
                status += '&processST=1';
            else
                status += '&processST=0';
            if ($("#chkPending").is(":checked"))
                status += '&pendingST=1';
            else
                status += '&pendingST=0';
        }
        else
        {
            status += '&confirmST=1';
        }
        var data = "from=" + OrderFromDate + "&to=" + OrderToDate + "&div=" + divName + "&store=" + storeName + status + "&area=" + areaName + "&areaId=" + areaId + "&divId=" + divId + "&storeId=" + storeId;
        $('#divAjaxLoader').show();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>salesorder/getSalesOrderView/",
            data: "data=&" + data,
            //dataType: html,
            success: function (message) {
                $('#divAjaxLoader').hide();
                $('#results').html(message);
                $(".colDownloaded").each(function () {
                    if ($(this).text() == 'Downloaded') {
                        $(this).parent().css("background-color", "#EEE");
                    }
                });
            }
        });
    }

    function dateConvertion(dateOrg)
    {
        var dateSplit = dateOrg.split('.');
        var date = dateSplit[2] + '-' + dateSplit[1] + '-' + dateSplit[0];
        //alert(date);
        return date;
    }
    function dateConvertToOrg(dateToConvert)
    {
        //alert(dateToConvert);
        var dateArray = dateToConvert.split('-');
        var date = dateArray[2] + '.' + dateArray[1] + '.' + dateArray[0];
        return date;
    }
    function showSalesOrder(id)
    {
        //alert('This is the clicked rows Id :'+ id);
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/salesorder/" + id,
            success: function (message) {
                //alert(message);
            }
        });
        return false;
    }
    function createAutoComplete(elem, url, addParams, keys, select) {
        //alert(elem+'-'+url+'-'+ addParams+'-'+keys);
        $(elem).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>" + url,
                    dataType: "json",
                    data: {
                        term: request.term,
                        values: addParams == "all" ? 'all' : $("#" + addParams).val(),
                        divId: keys == "" ? '' : $("#" + keys).val(),
                        AllType: select
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            if (elem == '#txtArea') {
                                return {
                                    value: item.amAreaName,
                                    areaID: item.amId,
                                    label: item.amAreaName
                                };
                            }
                            else if (elem == "#txtDivision")
                            {
                                return {
                                    value: item.dmDivisionName,
                                    divID: item.dmId,
                                    divCode: item.dmCode,
                                    label: item.dmDivisionName
                                };
                            }
                            else
                            {
                                return {
                                    value: item.smStoreName,
                                    smID: item.smId,
                                    smcode: item.smStorecode,
                                    label: item.smStoreName
                                };
                            }
                        }));
                    }
                });
            },
            minLength: 1,
            selectFirst: true,
            select: function (event, ui) {
                //alert(ui.item.areaID);
                if (elem == '#txtArea') {
                    $("#hid_txtArea").val(ui.item.areaID);
                    $('#txtCustomer').val('');
                    $('#hid_txtCustomer').val('');
                }
                else if (elem == "#txtDivision") {
                    $("#hid_txtDivision").val(ui.item.divID);
                    $("#hid_txtDivisionCode").val(ui.item.divCode);
                    //fillDdlCategory();
                }
                else
                {
                    $("#hid_txtCustomer").val(ui.item.smID);
                    //$("#hid_txtDivisionCode").val(ui.item.divCode);
                }
                //$("#hid_PrdctMRP").val(ui.item.productMRP);
            }
        });
    }
    function btnResetClick()
    {
        $('#hid_txtArea').val('');
        $('#txtArea').val('');
        $('#txtDivision').val('');
        $('#hid_txtDivision').val('');
        $('#hid_txtDivisionCode').val('');
        $('#txtCustomer').val('');
        $('#hid_txtCustomer').val('');
        $(':checkbox').attr('checked', false);
        $('#txtOrderFrom').val('');
        $('#txtOrderTo').val('');
        $('#resultRows').html('');
    }

</script>
<section class="content-header">
	<h1>
		View Sales Orders <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">View Sales Order</li>
	</ol>
</section>

<!-- Main content -->
<section id="content" class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header">
					<div class="col-xs-8">
						<h3 class="box-title">Filters</h3>
					</div>
					<div class="pull-right box-tools">
						<button class="btn btn-info btn-xs" data-widget="collapse"
							data-toggle="tooltip" title="" data-original-title="Collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-1">Area</div>
							<div class="col-xs-3">
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="txtArea"
										id="txtArea" value="<?php echo $details['areaName']; ?>" /> <input
										type="hidden" name="hid_txtArea" id="hid_txtArea"
										value="<?php echo $details['areaId']; ?>" /> <span
										class="input-group-btn"> <input type="button" name="btnArea"
										class="btn btn-info btn-flat" id="btnArea" Value="View" />
									</span>
								</div>
							</div>

							<div class="col-xs-1">Division</div>
							<div class="col-xs-3">
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="txtDivision"
										id="txtDivision" value="<?php echo $details['divName']; ?>" />
									<input id="hid_txtDivision" type="hidden"
										value="<?php echo $details['divId']; ?>" /> <input
										type="hidden" id="hid_txtDivisionCode"
										name="hid_txtDivisionCode"
										value="<?php echo $details['divId']; ?>" /> <span
										class="input-group-btn"> <input type="button"
										class="btn btn-info btn-flat" name="btnDivision"
										id="btnDivision" Value="View" />
									</span>
								</div>

							</div>
							<div class="col-xs-1">Customer</div>
							<div class="col-xs-3">
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="txtCustomer"
										id="txtCustomer" value="<?php echo $details['storeName']; ?>" />
									<input type="hidden" name="hidTxtCustomer" id="hid_txtCustomer"
										value="<?php echo $details['storeId']; ?>" /> <span
										class="input-group-btn"> <input type="button"
										class="btn btn-info btn-flat" name="btnCustomer"
										id="btnCustomer" Value="View" />
									</span>
								</div>
							</div>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-xs-12">
							<div class="col-xs-2">
								<input type="checkbox" name="chkNew" id="chkNew" /> New
								Communication
							</div>
							<div class="col-xs-10">
								<div class="col-xs-2">
									<input type="checkbox" name="chkPartial" id="chkPartial" />
									Partial
								</div>
								<div class="col-xs-2">
									<input type="checkbox" name="chkPending" id="chkPending" />
									Pending
								</div>
								<div class="col-xs-2">
									<input type="checkbox" name="chkInProcess" id="chkInProcess" />
									In Process
								</div>
								<div class="col-xs-2">
									<input type="checkbox" name="chkSuspend" id="chkSuspend" />
									Suspended
								</div>
								<div class="col-xs-2">
									<input type="checkbox" name="chkcancel" id="chkcancel" />
									Cancelled
								</div>
								<div class="col-xs-2">
									<input type="checkbox" name="chkComplete" id="chkComplete" />
									Completed
								</div>
							</div>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="row-inside">
							<div class="col-xs-4">
								<table>
									<tbody>
										<tr>
											<td>Order From Date</td>
											<td><input type="text" class="form-control datepicker"
												id="txtOrderFrom" /></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-xs-4">
								<table>
									<tbody>
										<tr>
											<td>Order To Date</td>
											<td><input type="text" class="form-control datepicker"
												id="txtOrderTo" /></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-xs-4">
								<table>
									<tbody>
										<tr>
											<td><input type="button" id="btnSubmit"
												class=" btn btn-primary" Value="Submit"
												onClick="submitClick();" /> <input type="reset"
												id="btnReset" class=" btn btn-warning" Value="Reset"
												onclick="javascript:btnResetClick();" /></td>
											<td>

												<div id="divAjaxLoader" class="span1"
													style="float: left; width: 40px;">
													<img src="<?php echo base_url(); ?>images/ajax-loader.gif" />
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="col-xs-8">
						<h3 class="box-title">Sales orders</h3>
					</div>
					<div class="box-tools pull-right">
						<!--a href="#admin/zone_master">
                            <button class="btn btn-primary" data-widget="collapse">
                                <i class="fa fa-pencil"> Add New Zone</i>
                            </button>
                        </a-->
					</div>
				</div>
				<!-- /.box-header -->
				<div id="main_content">
					<h4><?php echo ($this->session->flashdata('item')); ?></h4>
				</div>
				<div class="box-body table-responsive" id="results"></div>
			</div>
		</div>
	</div>


	<div class="modal fade in" id="areaMaster" tabindex="-1" role="dialog"
		aria-hidden="false" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">×</button>
					<h4 class="modal-title">
						<i class="fa fa-laptop"></i> Areas
					</h4>
				</div>
				<br />
				<div class="row">
					<div class="col-xs-12">
						<div class="list box box-info">

							<div class="items box-body table-responsive" id="areaList">
								<table id="areaResult"
									class="table  table-bordered table-striped table-hover">
									<thead>
										<tr>
											<td>Area Name</td>

											<td></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="first">ALL</td>
											<td class="last"><input type="hidden" value="-2" /></td>
										</tr>
                                        <?php
																																								if($areaArray->num_rows() > 0){
																																									foreach($areaArray->result() as $row){
																																										?>
                                                <tr>
											<td class="first">
                                                        <?php echo $row->amAreaName; ?>
                                                    </td>

											<td class="last"><input type="hidden"
												value="<?php echo $row->amId; ?>" /></td>
										</tr>
                                                <?php
																																									}
																																								}
																																								?>
                                    </tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer clearfix">
							<button type="button" class="btn btn-danger" data-dismiss="modal"
								id="closearea">
								<i class="fa fa-times"></i> Cancel
							</button>
							<button type="submit" class="btn btn-primary pull-left"
								id="areaSelect">
								<i class="fa fa-check"></i> Ok
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade in" id="divMaster" tabindex="-1" role="dialog"
		aria-hidden="false" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">×</button>
					<h4 class="modal-title">
						<i class="fa fa-laptop"></i> Divisions
					</h4>
				</div>
				<br />
				<div class="row">
					<div class="col-xs-12">
						<div class="list box box-info">

							<div class="items box-body table-responsive" id="divList">
								<table id="divResult"
									class="table  table-bordered table-striped table-hover">
									<thead>
										<tr>
											<td>Division Name</td>

											<td></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="first">ALL</td>
											<td class="last"><input type="hidden" value="-2" /> -2</td>
										</tr>
                                        <?php
																																								if($divisionArray->num_rows() > 0){
																																									
																																									foreach($divisionArray->result() as $row){
																																										?>
                                                <tr>
											<td class="first">
                                                        <?php echo $row->dmDivisionName; ?>
                                                    </td>

											<td class="last"><input type="hidden"
												value="<?php echo $row->dmId; ?>" />
                                                        <?php echo $row->dmCode; ?>
                                                    </td>
										</tr>
                                                <?php
																																									}
																																								}
																																								?>
                                    </tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer clearfix">
							<button type="button" class="btn btn-danger" data-dismiss="modal"
								id="closediv">
								<i class="fa fa-times"></i> Cancel
							</button>
							<button type="submit" class="btn btn-primary pull-left"
								id="divSelect">
								<i class="fa fa-check"></i> Ok
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade in" id="storeMaster" tabindex="-1" role="dialog"
		aria-hidden="false" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">×</button>
					<h4 class="modal-title">
						<i class="fa fa-laptop"></i> Stores
					</h4>
				</div>
				<br />
				<div class="row">
					<div class="col-xs-12">
						<div class="list box box-info">

							<div class="items box-body table-responsive" id="storeList"></div>
						</div>
						<div class="modal-footer clearfix">
							<button type="button" class="btn btn-danger" data-dismiss="modal"
								id="closeStore">
								<i class="fa fa-times"></i> Cancel
							</button>
							<button type="submit" class="btn btn-primary pull-left"
								id="storeSelect">
								<i class="fa fa-check"></i> Ok
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $(function () {
        $('#areaResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": false,
            "bAutoWidth": true,
            "iDisplayLength": 10,
        });
    });
    $(function () {
        $('#divResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": false,
            "bAutoWidth": true,
        });
    });
</script>
