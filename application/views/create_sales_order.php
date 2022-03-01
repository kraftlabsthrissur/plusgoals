<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/salesorder.css"/>

<!--link rel="stylesheet" href="/resources/demos/style.css" /-->
<style>
    .ui-autocomplete {
        max-height: 100px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
    }
    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
    * html .ui-autocomplete {
        height: 100px;
    }
</style>
<script type="text/javascript">
    $('#right-content').on('click', '.modal .close, .modal .close-btn', function () {
        $('.modal').slideUp(800);
    });
    var IsEdit = false;
    function setProductlist(type, searchstring) {
        var categoryName = $("#ddlcategory").val();
        $.ajax({
            url: "<?php echo base_url(); ?>common/getProductsList/" + categoryName + "/" + type + "/" + searchstring,
            success: function (message) {
                $("#productResult").html("");
                $("#productResult").html(message);
                setProduct();
                openPopUp("productMaster");
            }
        });
    }

    function setProduct()
    {
        $("#productsList").off('dblclick').on('dblclick','tr',function () {
            selectRow("productsList", $(this));
            if ($("#productResult .selected").length > 0)
            {
                $("#hid_PrdctId").val($("#productResult .selected input").val());
                $("#txtProductName").val($("#productResult .selected td.first").text().ltrim().rtrim());
                $("#hid_PrdctMRP").val($("#hidMRP_" + $("#hid_PrdctId").val()).val());
            }
            $("#productMaster").slideUp(500);
        });
        $("#productsList").off('click').on('click','tr',function () {
            selectRow("productsList", $(this));
        });
        $("#areaList").off('dblclick').on('dblclick','tr',function () {
            $("#areaList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#areaResult .selected").length > 0)
            {
                $("#hid_txtArea").val($("#areaResult .selected input").val());
                $("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
            }
            $("#areaMaster").slideUp(500, function () {
                $("#overlayA").fadeOut(500);
            });
        });

        $("#divList").off('dblclick').on('dblclick','tr',function () {
            $("#divList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#divResult .selected").length > 0)
            {
                $("#hid_txtDivision").val($("#divResult .selected input").val());
                $("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
                $("#hid_txtDivisionCode").val($("#divResult .selected td.last").text().ltrim().rtrim());
                //alert($("#hid_txtDivisionCode").val());
            }
            $("#divMaster").slideUp(500, function () {
                $("#overlayD").fadeOut(500);
            });
            fillDdlCategory();
            $("#txtCustomer").val("");
            $("#hid_txtCustomer").val("");
        });

        $("#storeList").on('dblclick','tr',function () {
            //alert(this);
            $("#storeList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#storeResult .selected").length > 0)
            {
                $("#hid_txtCustomer").val($("#storeResult .selected .smId ").val());
                $("#hid_txtCustomerPriceGroup").val($("#storeResult .selected .CustomerPriceGroup ").val());
                $("#txtCustomer").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            $("#storeMaster").slideUp(500);

        });
        $(".modal .table").off('click').on('click','tr',function () {
            $(this).parent().find('tr').removeClass("selected");
            $(this).addClass("selected");
        });

    }
    function sendModeChange()
    {
        if ($("#ddlMode").val() == -1 || $("#ddlMode").val() == 2 || $("#ddlMode").val() == 3) {
            $("#divParcel").hide();
            $("#divDispatch").show();
            if ($("#ddlMode").val() != 3) {
                $("#txtDespatch").val('By Supply:');
            } else {
                $("#txtDespatch").val('By Hand:');
            }
        } else {
            $("#divParcel").show();
            $("#divDispatch").hide();
        }
    }
    function selectRow(divId, el) {
        $("#" + divId + " tr").removeClass("selected");
        el.addClass("selected");
    }
    function openPopUp(divId)
    {
        var dWidth = $(document).width();
        var pLeft = (($(window).width())) - 502;
        var dHeight = $(document).height();
        var pHeight = (($(window).height())) - 386 + $(window).scrollTop();
        $("#overlay").css("width", dWidth + "px");
        $("#overlay").css("height", dHeight + "px");
        $("#overlay").fadeIn(500, function () {
            $("#" + divId).css("left", pLeft / 2 + "px");
            $("#" + divId).css("top", pHeight / 2 + "px");
            $("#" + divId).slideDown(500);
        });
        return false;
    }

    function setDivisionList(searchString) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/getDivisionMaster/" + searchString,
            success: function (message) {
                $("#divResult").html("");
                $("#divResult").html(message);
                setProduct();
            }
        });
    }
    function fillDdlCategory()
    {
        if ($("#hid_txtDivisionCode").val() != '')
        {
            //alert($("#hid_txtDivisionCode").val());
            $.ajax({
                url: "<?php echo base_url(); ?>common/getCategories/" + $("#hid_txtDivisionCode").val(), //$("#hid_txtDivision").val(),
                success: function (message) {
                    $("#divddlCat").html(message);
                    setProduct();
                }
            });
        }
    }

    function setStoreList(type, searchString) {
        if (searchString == '')
        {
            searchString = "searchstringMissing";
        }
        var areaId = $("#hid_txtArea").val();
        var divId = $("#hid_txtDivision").val();
        $.ajax({
            url: "<?php echo base_url(); ?>common/getStoreMaster/" + type + "/" + searchString + "/" + areaId + "/" + divId,
            success: function (message) {
                $("#storeList").html(message);
                setProduct();
            }
        });
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
                }
                else if (elem == "#txtDivision") {
                    $("#hid_txtDivision").val(ui.item.divID);
                    $("#hid_txtDivisionCode").val(ui.item.divCode);
                    fillDdlCategory();
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
    function product_autocomplete() {
        $("#txtProductName").autocomplete({
            //source: "<?php echo base_url(); ?>index.php/common/getProductAutocomplete/" + $("#ddlCategory").val(),
            source: function (request, response) {
                if ($("#ddlcategory").length > 0) {
                    $("#hid_PrdctId").val("");
                    $("#hid_PrdctMRP").val("");
                    $.ajax({
                        url: "<?php echo base_url(); ?>common/getProductAutocomplete/",
                        dataType: "json",
                        data: {
                            term: request.term,
                            category: $("#ddlcategory").val(),
                            sales_type:$("#hid_txtCustomerPriceGroup").val()
                        },
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    value: item.pmProductName,
                                    productID: item.pmProductId,
                                    productMRP: item.pmMRP,
                                    label: item.pmProductName + " - " + item.pmProductCode
                                };
                            }));
                        }
                    });
                }
            },
            minLength: 1,
            selectFirst: true,
            select: function (event, ui) {
                $("#hid_PrdctId").val(ui.item.productID);
                $("#hid_PrdctMRP").val(ui.item.productMRP);
            }
        });
    }
    $(function () {
        var category = 1;
        row_Click();
        product_autocomplete();
        $("#txtTotal").attr("readonly", "readonly");
        $("#divParcel").hide();
        setProduct();
        if ($("#hid_txtDivision").val() != 1) {
            fillDdlCategory();
        }
        $("#productSearch").on('click',function () {
            var type = "product";
            var searchString = "";
            if ($("#productValue").val().trim() != "") {
                searchString = $("#productValue").val();
            } else if ($("#codeValue").val().trim() != "") {
                type = "code";
                searchString = $("#codeValue").val();
            } else {
                alert("Please enter a value.");
                return false;
            }
            setProductlist(type, searchString);
        });

        $("#txtQty, #txtOfferQty").keydown(function (event) {
            // Allow: backspace, delete, tab and escape
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
                    // Allow: Ctrl+A
                            (event.keyCode == 65 && event.ctrlKey === true) ||
                            // Allow: home, end, left, right
                                    (event.keyCode >= 35 && event.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    } else {
                        // Ensure that it is a number and stop the keypress
                        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                            event.preventDefault();
                        }
                    }
                });

        String.prototype.ltrim = function () {
            return this.replace(/^\s+/, "");
        }
        String.prototype.rtrim = function () {
            return this.replace(/\s+$/, "");
        }
        setProduct();
        $("#productSelect").on('click',function () {
            if ($("#productResult .selected").length > 0) {
                $("#hid_PrdctId").val($("#productResult .selected input").val());
                $("#txtProductName").val($("#productResult .selected td.first").text().ltrim().rtrim());
                $("#hid_PrdctMRP").val($("#hidMRP_" + $("#hid_PrdctId").val()).val());
            }
            closePopup("productMaster");
        });
        $("#closeProduct ,#productClose").click(function () {
            closePopup("productMaster");
            return false;
        });
        $("#closediv ,#divClose").click(function () {
            $("#divMaster").slideUp(500, function () {
                $("#overlayA").fadeOut(500);
            });
            return false;
        });
        $("#closeStore ,#storeClose").click(function () {
            closePopup("storeMaster");
            return false;
        });
        function closePopup(divId) {
            $("#" + divId).slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
        }
        $("#btnDivision").click(function () {
            $("#divValue").val("");
            $("#addedRows").html("");
            $("#hid_isAdded").val(0);
            $("#txtTotal").val(0);
            $("#divMaster").slideDown(500);
            return false;
        });
        $("#btnCustomer").click(function () {
            if ($("#hid_txtArea").val() != "" && $("#hid_txtDivision").val() != "") {
                $("#storeValue").val("");
                $("#codeValue").val("");
                //setStoreList('all', $("#subArealistId").val(),'');
                setStoreList('all', '');
                $("#storeMaster").slideDown(500);
                return false;
            } else {
                if ($("#hid_txtArea").val() != "") {
                    alert('Please choose Division');
                } else {
                    alert('Please choose Area');
                }
                return false;
            }
        });
        $("#btnArea").click(function () {
            $("#areaValue").val("");
            $("#hid_isAdded").val(0);
            $("#txtCustomer").val("");
            $("#hid_txtCustomer").val("");
            $("#addedRows").html("");
            $("#areaMaster").slideDown(500);
            return false;
        });

        $("#divSearch").click(function () {
            var searchString = "";
            if ($("#divValue").val().trim() != "") {
                searchString = $("#divValue").val();
            } else {
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
            } else if ($("#storeCodeValue").val().trim() != "") {
                type = "code";
                searchString = $("#storeCodeValue").val();
            } else {
                type = 'all';
                searchString = 'searchstringMissing';
            }
            setStoreList(type, searchString);
        });
        $("#closearea ,#areaClose").click(function () {
            $("#areaMaster").slideUp(500, function () {
                $("#overlayA").fadeOut(500);
            });
            return false;
        });
        $("#areaSelect").click(function () {
            if ($("#areaResult .selected").length > 0)
            {
                $("#hid_txtArea").val($("#areaResult .selected input").val());
                $("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
            }
            $("#areaMaster").slideUp(500, function () {
                $("#overlayA").fadeOut(500);
            });
        });
        $("#divSelect").click(function () {
            if ($("#divResult .selected").length > 0)
            {
                $("#hid_txtDivision").val($("#divResult .selected input").val());
                $("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
                $("#hid_txtDivisionCode").val($("#divResult .selected td.last").text().ltrim().rtrim());
            }
            $("#divMaster").slideUp(500, function () {
                $("#overlayD").fadeOut(500);
            });
            fillDdlCategory();
            $("#txtCustomer").val("");
            $("#hid_txtCustomer").val("");
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

    function btnAdd_Click() {
        if ($("#hid_PrdctId").val() === '') {
            alert("Choose product name");
        }
        else {
            var existingId = 0;
            $('#addedRows tr').each(function () {
                if ($("#hid_PrdctId").val() === $(this).find(".colcloseval input[type=hidden]").attr('id'))
                    existingId = $("#hid_PrdctId").val();
            });

            if (IsEdit || existingId === 0) {
                var qty = $("#txtQty").val() === '' ? 1 : parseFloat($("#txtQty").val());
                var offer_qty = $("#txtOfferQty").val() === '' ? 0 : parseFloat($("#txtOfferQty").val());
                $.ajax({
                    url: "<?php echo base_url(); ?>common/setSOList/" + $("#hid_PrdctId").val() + "/" + qty + "/" + offer_qty,
                    success: function (message) {
                        if (message) {
                            if ($("#hid_PrdctId").val() !== "") {
                                var existId = 0;
                                $('#addedRows tr').each(function () {
                                    if ($("#hid_PrdctId").val() === $(this).find(".colcloseval input[type=hidden]").attr('id')) {
                                        existId = $("#hid_PrdctId").val();
                                    }
                                });

                                var amount = (parseFloat($("#hid_PrdctMRP").val()) * qty).toFixed(2);
                                if (existId !== 0) {
                                    IsEdit = false;
                                    $('#' + existId).closest('tr').find('.colQty').html(qty);
                                    $('#' + existId).closest('tr').find('.colOffer').html(offer_qty);
                                    $('#' + existId).closest('tr').find('.amt').html(amount);
                                } else {
                                    var row = '<tr>';
                                    row += '<td class="colName">' + $("#txtProductName").val() + '</td>';
                                    row += '<td class="colCateg">' + $("#ddlcategory").val() + '</td>';
                                    row += '<td class="colQty" >' + qty + '</td>';
                                    row += '<td class="colOffer">' + offer_qty + '</td>';
                                    row += '<td class="colMRP">' + $("#hid_PrdctMRP").val() + '</td>';
                                    row += '<td class="colAmount amt">' + amount + '</td>';
                                    row += '<td class="colcloseval">';
                                    row += '<input type="button" class="btn btn-xs btn-danger" onclick="remove_SO_item(' + $("#hid_PrdctId").val() + ');" value="Remove" />';
                                    row += '<input type="hidden" id="' + $("#hid_PrdctId").val() + '" /></td></tr>';
                                }
                                $("#hid_isAdded").val(1);
                                $("#txtQty").val(1);
                                $("#txtOfferQty").val(0);
                                $("#txtProductName").val("");
                                $("#hid_PrdctMRP").val("");
                                $('#txtProductName').focus();
                                $('#txtQty').val('');
                                $('#txtOfferQty').val('');
                                //row_Click();
                            }
                        }
                        else
                        {
                            alert('This Product is already added!');
                        }

                        $("#addedRows").append(row);
                        var total = 0;
                        $(".amt").each(function () {
                            total = (parseFloat(total) + (parseFloat($(this).text() * 100) / 100)).toFixed(2);
                        });
                        $("#txtTotal").val(total);
                        $("#hid_PrdctId").val("");
                        $("#txtProductName").val("");
                    }
                });
            }
            else {
                alert('This Product is already added');
                $("#hid_PrdctId").val("");
                $("#txtProductName").val("");
                $('#txtProductName').focus();
                $("#txtQty").val(1);
                $("#txtOfferQty").val(0);
            }
        }
    }
    function row_Click() {
        $('#products tbody').on("click", 'tr', function (e) {
            if (e.target.localName === 'input') {
                return;
            }
            var customerId = $(this).find(".colName").html();
            $('#txtProductName').val(customerId);
            $('#txtQty').val($(this).find(".colQty").html());
            $('#txtOfferQty').val($(this).find(".colOffer").html());
            $('#hid_PrdctMRP').val($(this).find(".colMRP").html());
            var a = $(this).find(".colcloseval input[type=hidden]").attr('id');
            console.log(a, $(this).find(".colcloseval input[type=hidden]"));
            $('#hid_PrdctId').val(a);
            IsEdit = true;
        });

    }


    function remove_SO_item(productId) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/removeSOList/" + productId,
            success: function (message) {
                if (message) {
                    $("#addedRows").find("#" + productId).closest('tr').remove();
                    var total = 0;
                    $(".amt").each(function () {
                        total = (parseFloat(total) + (parseFloat($(this).text() * 100) / 100)).toFixed(2);
                    });
                    $("#txtTotal").val(total);
                } else {
                    alert('Not removed');
                }
            }
        });
    }
    function partialSave_Click(buttonName)
    {
        //alert("<?php echo date('Y-m-d H:i:s'); ?>");
        $('#hid_time').val(new Date());
        ///alert($('#hid_time').val());
        if (buttonName == 'partial')
        {
            $("#isConfirmBtn").val(0);
        }
        else
        {
            $("#isConfirmBtn").val(1);
        }
        var amount = $("#txtTotal").val();
        var divcode = $("#hid_txtDivision").val();
        var divName = $("#txtDivision").val();
        var areaId = $("#hid_txtArea").val();
        var DespatchMode = $("#ddlMode").val();

        
        if (areaId == "")
        {
            alert("Select Area!!!");
            return false;
        }
        if (divcode == "")
        {
            alert("Select Division!!!");
            return false;
        }
        if ($("#txtCustomer").val() == "")
        {
            alert("Please Choose Store!!!");
            return false;
        }
		if($('#ddlSalesRep').length && $('#ddlSalesRep').val() == ''){
			alert("Please Choose Sales Person!!!");
    		return false;
		}
        
        if ($("#hid_isAdded").val() != 1)
        {
            alert("Please Select and Add Product!!!");
            return false;
        }
        if (DespatchMode == -1)
        {
            alert('Please select Despatch mode');
            return false;
        }
        if ((DespatchMode == 2 || DespatchMode == 3) && $("#txtDespatch").val().trim() == '')
        {
            alert('Please add Despatch mode');
            return false;
        }
        if (DespatchMode == 0 || DespatchMode == 1)
        {
            if ($("#txtTo").val().trim() == '') {
                alert('Please add Despatch To:');
                return false;
            }
            if ($("#txtCarrier").val().trim() == '') {
                alert('Please add Despatch Carrier:');
                return false;
            }
            if ($("#txtDestination").val().trim() == '') {
                alert('Please add Despatch Destination:');
                return false;
            }
        }
    }
    function btnResetClick()
    {
        $('#txtArea').val('');
        $('#hid_txtArea').val('');
        $('#txtDivision').val('');
        $('#hid_txtDivision').val('');
        $('#hid_txtDivisionCode').val('');
        $('#txtCustomer').val('');
        $('#hid_txtCustomer').val('');
        $('#txtProductName').val('');
        $('#hid_PrdctMRP').val('');
        $('#hid_PrdctId').val('');
        $('#txtQty').val('');
        $('#txtOfferQty').val('');
        $('#addedRows').html('');
    }

</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Create Sales Order
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#salesorder/view_sales_order"><i class="fa fa-bar-chart-o"></i> Sales Orders</a></li>
        <li class="active">Create Sales Order</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="table1">
                <form name="salesOData" method="post" action="<?php echo base_url(); ?>salesorder/create_sales_order">
                    <div class="box ">
                        <div class="box-header">
                            <div class="col-xs-8">
                                <h3 class="box-title">Add Products</h3>
                            </div>

                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-1">
                                        Area
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="txtArea" id="txtArea" disabled="disabled" value="<?php if ($sodetails != null) echo $sodetails['area']; ?>"/>
                                            <input type="hidden" name="hid_txtArea" id="hid_txtArea" value="<?php if ($sodetails != null) echo $sodetails['areaId']; ?>"/>
                                            <span class="input-group-btn">
                                                <input type="button" name="btnArea" class="btn btn-info btn-flat" id="btnArea" Value="View" />
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-xs-1">
                                        Division
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="txtDivision" class="form-control" id="txtDivision" disabled="disabled" value="<?php if ($sodetails != null) echo $sodetails['div']; ?>"/>
                                            <input type="hidden" id="hid_txtDivision" name="hid_txtDivision" value="<?php if ($sodetails != null) echo $sodetails['divId']; ?>"/>
                                            <input type="hidden" id="hid_txtDivisionCode" name="hid_txtDivisionCode" value="<?php if ($sodetails != null) echo $sodetails['divCode']; ?>"/>
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-info btn-flat" name="btnDivision" id="btnDivision" Value="View" />
                                            </span>
                                        </div>

                                    </div>
                                    <div class="col-xs-1">
                                        Customer
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="txtCustomer" id="txtCustomer" class="form-control" disabled="disabled" value="<?php if ($sodetails != null) echo urldecode($sodetails['store']); ?>"/>
                                            <input type="hidden" name="hidTxtCustomer" id="hid_txtCustomer" value="<?php if ($sodetails != null) echo $sodetails['storeId']; ?>"/>
                                            <input type="hidden" name="sales_type" id="hid_txtCustomerPriceGroup" value="<?php if ($sodetails != null) echo $sodetails['CustomerPriceGroup']; ?>"/>
                                            <span class="input-group-btn">
                                                <input type="button" class="btn btn-info btn-flat" name="btnCustomer" id="btnCustomer" Value="View" />
                                            </span>
                                        </div>
                                    </div>
                                </div>                        
                            </div>

                            <br/>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-1">
                                        Category
                                    </div>
                                    <div class="col-xs-3" id="divddlCat">
                                        <select id="ddlCat" class="form-control">
                                            <option value="0">Select</option>
                                        </select>
                                    </div>
                                    <?php
                                    $userdata = $this->session->userdata('userdata');
                                    if ($userdata['umIsHOUser'] == 1) {
                                        ?>
                                        <div class="col-xs-1">
                                            Ordered By 
                                        </div>
                                        <div class="col-xs-3" id="divddlSalesRep">
                                            <?php echo form_dropdown('salesRepList', $salesrepArray, '', 'id="ddlSalesRep" class="form-control" '); ?>
                                        </div>
                                    <?php } ?>
                                    
                                </div>
                                
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-12 productname">
                                    <div class="col-xs-1">
                                        Product
                                    </div>
                                    <div class="col-xs-6" >
                                        <input type="text" name="txtPrdctName" id="txtProductName" class="form-control"  />
                                        <input type="hidden" name="hid_PrdctMRP" id="hid_PrdctMRP"/>
                                        <input type="hidden" name="hid_PrdctId" id="hid_PrdctId"/>
                                    </div>
                                    <div class="col-xs-5">
                                        <div class="col-xs-1">
                                            Qty 
                                        </div>
                                        <div class="col-xs-3" >
                                            <input type="text" name="txtQty" id="txtQty" class="form-control" value="" />
                                        </div>
                                        <div class="col-xs-3">
                                            Offer Qty 
                                        </div>
                                        <div class="col-xs-3" >
                                            <input type="text" name="txtOfferQty" id="txtOfferQty" class="form-control" value="" />
                                        </div>
                                        <div class="col-xs-2" >
                                            <input type="button" name="btnAdd" Value="Add" class="btn btn-primary" id="btnAdd" onclick="return btnAdd_Click();"/>
                                            <input type="hidden" id="hid_isAdded" name="hid_isAdded" Value="0"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </div>

                    </div>
                    <div class="box ">
                        <div class="box-body table-responsive " >
                            <div style="min-height: 200px;">
                                <table  id = "products" class="table  table-bordered table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th >
                                                Product
                                            </th>
                                            <th >
                                                Category
                                            </th>
                                            <th  >
                                                Qty
                                            </th>
                                            <th  >
                                                Offer
                                            </th>
                                            <th  >
                                                Price
                                            </th>
                                            <th  >
                                                Total Price
                                            </th>
                                            <th >
                                                Remove
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="addedRows"></tbody>
                                </table>
                            </div>

                            <div id="total_content">
                                <div class ="total">
                                    <a>Total</a>
                                    <input type="text" id="txtTotal" name="txtTotal"/>
                                </div><!--total-->
                            </div><!--totalcontent-->
                            <div id="modediv" class="row-fluid">
                                <div class="mode">
                                    <a>Mode</a>
                                    <select id="ddlMode" name="ddlMode" onchange="sendModeChange();" >
                                        <option value="-1">--Select--</option>
                                        <option value="0">By Parcel</option>
                                        <option value="1">By Courier</option>
                                        <option value="2">By Supply</option>
                                        <option value="3">By Hand</option>
                                    </select>
                                </div><!--mode-->
                                <div id="divDispatch">
                                    <a>Despatch</a>
                                    <input type="text" id="txtDespatch" name="txtDespatch" />
                                </div>
                                <div id="divParcel">
                                    <a>To</a>
                                    <input type="text" id="txtTo" name="txtTo" />
                                    <a>Carrier</a>
                                    <input type="text" id="txtCarrier" name="txtCarrier"  />
                                    <a>Destination</a>
                                    <input type="text" id="txtDestination" name="txtDestination" />
                                </div>
                            </div><!--modediv-->
                            <div id = "button_part" class="row-fluid">
                                <table  class="row-fluid">
                                    <tr>
                                        <td class="button span1">
                                            <input type="submit" name="btnPartialSave" class="btn btn-primary" id="btnPartialSave" onclick="return partialSave_Click('partial');" Value="Partial Save" />
                                        </td>
                                        <td class="button span1">
                                            <input type="submit" name="btnConfirmOrder" class="btn btn-primary" Value="Confirm Order" onclick="return partialSave_Click('confirm');"/>
                                            <input type="hidden" name="isConfirmBtn" id="isConfirmBtn" value="0"/>
                                        </td>
                                        <td class="button span1" >
                                            <input type="button" name="btnCommunication"  class="btn btn-info disable" Value="Communication" disabled="disabled"/>
                                        </td>
                                        <td class="button span1">
                                            <input type="button" name="btnCollection" class="btn btn-info disable" Value="Collection" disabled="disabled"/>
                                        </td>
                                        <td class="button span1">
                                            <input type="button" name="btnDownload"  class="btn btn-info disable" Value="Download" disabled="disabled"/>
                                        </td>
                                        <td class="button span1">
                                            <input type="button" name="btnCancelOrder" class="btn btn-info disable" Value="Cancel Order" disabled="disabled"/>
                                        </td>
                                        <td class="button span1">
                                            <input type="reset" name="btnReset" class="btn btn-primary" Value="Reset" onclick="javascript:btnResetClick();"/>
                                        </td>
                                    </tr>
                                </table>
                            </div><!--button-->
                            <input type ="hidden" id="hid_time" name="hid_time" />
                        </div>
                    </div>
                </form>
            </div><!--table1-->
        </div><!--subcontent-->
    </div>
</section>



<div class="store" id="productMaster" style="display: none;">
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
                    <td rowspan="2" class="searchbtn">
                        <input type="submit" value="Search"  class="linkButton" id="productSearch" />
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
                <!--div class="col3"></div-->
            </div>
            <div class="items" id="productsList">
                <table cellpadding="0" cellspacing="0" id="productResult">

                </table>
            </div>
        </div>
        <div class="footer">
            <div>
                <input type="submit" class="linkButton" value="Ok" id="productSelect" />
                <a href="#" id="closeProduct" class="linkButton">Cancel</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="areaMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Areas</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="areaList"> 
                            <table  id="areaResult" class="table  table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td>Area Name</td>

                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="first" >ALL</td>
                                        <td class="last" ><input type="hidden" value="-2" /></td>
                                    </tr>
                                    <?php
                                    if ($areaArray->num_rows() > 0) {
                                        foreach ($areaArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->amAreaName; ?>
                                                </td>

                                                <td class="last">
                                                    <input type="hidden" value="<?php echo $row->amId; ?>" />
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="closearea" >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left" id="areaSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="divMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Divisions</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="divList"> 
                            <table  id="divResult" class="table  table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td>Division Name</td>

                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="first">ALL</td>
                                        <td class="last">
                                            <input type="hidden" value="-2" />
                                            -2
                                        </td>
                                    </tr>
                                    <?php
                                    if ($divisionArray->num_rows() > 0) {

                                        foreach ($divisionArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->dmDivisionName; ?>
                                                </td>

                                                <td class="last">
                                                    <input type="hidden" value="<?php echo $row->dmId; ?>" />
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="closediv" >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left" id="divSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="storeMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Stores</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="storeList"> 

                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="closeStore" >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left" id="storeSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#areaResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": false,
            "bAutoWidth": true,
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
