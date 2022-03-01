
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
            url: "<?php echo base_url(); ?>index.php/common/getProductsList/" + categoryName + "/" + type + "/" + searchstring,
            success: function (message) {
                $("#productResult").html("");
                $("#productResult").html(message);
                setProduct();
                openPopUp("productMaster");
            }
        });
    }
    function download_Click()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/downloadSalesOrder",
            success: function (result) {
                console.log(result);
            }
        });
    }

    function setProduct()
    {
        $("#productsList tr").dblclick(function () {
            selectRow("productsList", $(this));
            if ($("#productResult .selected").length > 0)
            {
                $("#hid_PrdctId").val($("#productResult .selected input").val());
                $("#txtProductName").val($("#productResult .selected td.first").text().ltrim().rtrim());
                $("#hid_PrdctMRP").val($("#hidMRP_" + $("#hid_PrdctId").val()).val());
            }
            $("#productMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
        });

        $("#areaList tr").dblclick(function () {
            $("#areaList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#areaResult .selected").length > 0)
            {
                $("#hid_txtArea").val($("#areaResult .selected input").val());
                $("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
            }
            $("#areaMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
        });

        $("#divList tr").dblclick(function () {
            $("#divList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#divResult .selected").length > 0)
            {
                $("#hid_txtDivision").val($("#divResult .selected input").val());
                $("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
            }
            $("#divMaster").slideUp(500, function () {
                $("#overlayD").fadeOut(500);
            });
        });

        $("#storeList tr").dblclick(function () {
            $("#storeList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#storeResult .selected").length > 0)
            {
            	$("#hid_txtCustomer").val($("#storeResult .selected .smId ").val());
                $("#hid_txtCustomerPriceGroup").val($("#storeResult .selected .CustomerPriceGroup ").val());
                $("#txtCustomer").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            $("#storeMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
            //closePopup("storeMaster");
        });

        $(".modal .table tr").click(function () {
            $(this).parent().find('tr').removeClass("selected");
            $(this).addClass("selected");
        });
    }
    function sendModeChange()
    {
        if ($("#ddlMode").val() == -1 || $("#ddlMode").val() == 2 || $("#ddlMode").val() == 3)
        {
            $("#divParcel").hide();
            $("#divDispatch").show();
            if ($("#ddlMode").val() != 3 && $("#txtDespatch").val() == '')
            {
                $("#txtDespatch").val('By Supply:');
            }
            else if ($("#ddlMode").val() != 2 && $("#txtDespatch").val() == '') {
                $("#txtDespatch").val('By Hand:');
            }
        }
        else
        {
            $("#divParcel").show();
            $("#divDispatch").hide();
        }
    }
    function selectRow(divId, el)
    {
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
    function setareaList(searchString) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/getArea/" + searchString,
            success: function (message) {
                $("#areaResult").html("");
                $("#areaResult").html(message);
                setProduct();
            }
        });
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
    function setStoreList(type, searchString) {
        if (searchString == '')
        {
            searchString = "searchstringMissing";
        }
        var areaId = $("#hid_txtArea").val();
        var divId = $("#hid_txtDivision").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/common/getStoreMaster/" + type + "/" + searchString + "/" + areaId + "/" + divId,
            success: function (message) {
                $("#storeResult").html("");
                $("#storeResult").html(message);
                setProduct();
            }
        });
    }
    function row_Click() {
        //var a = '';
        $('#products tbody').on("click", 'tr', function (e) {
            if (e.target.localName === 'input') {
                return;
            }
            IsEdit = true;
            var customerId = $(this).find(".colName").html();
            $('#txtProductName').val(customerId);
            $('#txtQty').val($(this).find(".colQty").html());
            $('#txtOfferQty').val($(this).find(".colOffer").html());
            $("#ddlcategory").val($(this).find(".colCateg").html());
            $("#hid_PrdctMRP").val($(this).find(".colMRP").html());
            //alert($(this).find(".colcloseval input[type=hidden]").attr('id'));
            var a = $(this).find(".colcloseval input[type=hidden]").attr('id');
            // $('hid_PrdctId').val('');
            $('#hid_PrdctId').val(a);
            //alert(a);
        });

    }
    function setSOComn(summaryId)
    {
        $.ajax({
            url: "<?php echo base_url(); ?>common/getSOComm/" + summaryId,
            success: function (message) {
                $("#communicationResult").html("");
                $("#communicationResult").html(message);
                var status = $("#hid_status").val();
                if (status != "")
                {
                    $("#" + status).attr("checked", true);
                }
                $('.last').mouseenter(function () {
                    var a = $(this).attr('id');
                    $('#msg_hover').html($('#' + a).text());
                    $('#msg_hover').show();
                });
                $('.last').mouseout(function () {
                    $('#msg_hover').hide();
                });
            }
        });
    }
    function saveCommunication() {
        var field = '';
        if ($("input[name=statusType]").is(':checked')) {
            field = $("input[name=statusType]:checked").attr('id');
        }
        var comment = 'NA'
        if ($("#txtComment").val().trim() != '') {
            comment = $("#txtComment").val().trim();
        }
        summaryId = $("#hid_sumId").val();
        $.ajax({
            url: "<?php echo base_url(); ?>common/saveSOComm/" + summaryId + "/" + comment + "/" + field,
            success: function () {
                $("#txtComment").val('');
                setSOComn(summaryId);
            }
        });
    }
    function setSOCollection(StoreID, DivisionId)
    {
        //alert(StoreID+':'+DivisionId);
        $.ajax({
            url: "<?php echo base_url(); ?>common/getSOCollection/" + StoreID + "/" + DivisionId,
            success: function (message) {
                $("#collectionResult").html("");
                $("#collectionResult").html(message);
            }
        });
    }
    $(function () {

        var category = 1;
        row_Click();
        $("#txtProductName").autocomplete({
            //source: "<?php echo base_url(); ?>index.php/common/getProductAutocomplete/" + $("#ddlCategory").val(),
            source: function (request, response) {
                if ($("#ddlcategory").length > 0) {
                    $("#hid_PrdctId").val("");
                    $("#hid_PrdctMRP").val("");
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/common/getProductAutocomplete/",
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
            select: function (event, ui) {
                $("#hid_PrdctId").val(ui.item.productID);
                $("#hid_PrdctMRP").val(ui.item.productMRP);
            }
        });

        //$("#txtProductName").attr("readonly","readonly");
        $("#txtArea").attr("readonly", "readonly");
        $("#txtTotal").attr("readonly", "readonly");
        $("#txtDivision").attr("readonly", "readonly");
        $("#txtCustomer").attr("readonly", "readonly");
        $("#divParcel").hide();
        $("#ddlMode").val(<?php echo $sodetails['DespatchMode']; ?>);
        $("#btnArea").attr("disabled", "disabled");
        $("#btnDivision").attr("disabled", "disabled");
        $("#btnCustomer").attr("disabled", "disabled");
        //alert(<?php echo $sodetails['isConfirmed']; ?>);
        //if(<?php echo $sodetails['isCancelled']; ?> || <?php echo $sodetails['isConfirmed']; ?>)

        if (<?php echo $sodetails['isPartial']; ?>)
        {
            //$("#btnCancelOrder").removeAttr("disabled");
            $("#btnPartialSave").removeAttr("disabled");
            $("#btnConfirmOrder").removeAttr("disabled");
        }
        else
        {
            //$("#btnCancelOrder").attr("disabled","disabled");
            $("#btnPartialSave").attr("disabled", "disabled");
            $("#btnConfirmOrder").attr("disabled", "disabled");

        }
        sendModeChange();
        setProducts();
        // $.ajax({
        // url: "<?php echo base_url(); ?>index.php/common/getSOProductDetails",
        // success: function(message){
        // $("#addedRows").append(message);
        // $("#hid_isAdded").val(1);
        // }
        // });

        $("#productSearch").click(function () {
            var type = "product";
            var searchString = "";
            if ($("#productValue").val().trim() != "") {
                searchString = $("#productValue").val();
            }
            else if ($("#codeValue").val().trim() != "") {
                type = "code";
                searchString = $("#codeValue").val();
            }
            else {
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
                    }
                    else {
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
        $("#productSelect").click(function () {
            if ($("#productResult .selected").length > 0)
            {
                $("#hid_PrdctId").val($("#productResult .selected input").val());
                $("#txtProductName").val($("#productResult .selected td.first").text().ltrim().rtrim());
                $("#hid_PrdctMRP").val($("#hidMRP_" + $("#hid_PrdctId").val()).val());
                //$("#hid_Code").val($("#productResult .selected td.second").text().ltrim().rtrim());
                //alert('id is: ' + $("#hid_PrdctId").val() + 'name is:'+ $("#txtProductName").val()+ 'mrp is:' + $("#hid_PrdctMRP").val());
            }
            closePopup("productMaster");
        });

        $("#closeProduct ,#productClose").click(function () {
            closePopup("productMaster");
            return false;
        });
        $("#communicationClose").click(function () {
            closePopup("communicationMain");
            return false;
        });
        $("#collectionClose").click(function () {
            closePopup("collectionMain");
            return false;
        });

        $("#closediv ,#divClose").click(function () {
            $("#divMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
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
            setDivisionList('all');
            $("#divMaster").slideDown(500);
            return false;
        });
        $("#btnCustomer").click(function () {
            if ($("#hid_txtArea").val() != "" && $("#hid_txtDivision").val() != "") {
                $("#storeValue").val("");
                $("#codeValue").val("");
                //setStoreList('all', $("#subArealistId").val(),'');
                setStoreList('all', '');
                openPopUp("storeMaster");
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
            setareaList('all');

            var dWidth = $(document).width();
            var pLeft = (($(window).width())) - 502;
            var dHeight = $(document).height();
            var pHeight = (($(window).height())) - 386 + $(window).scrollTop();
            $("#overlay").css("width", dWidth + "px");
            $("#overlay").css("height", dHeight + "px");
            $("#overlay").fadeIn(500, function () {
                $("#areaMaster").css("left", pLeft / 2 + "px");
                $("#areaMaster").css("top", pHeight / 2 + "px");
                $("#areaMaster").slideDown(500);
            });
            return false;
        });
        $("#areaSearch").click(function () {
            var searchString = "";
            if ($("#areaValue").val().trim() != "") {
                searchString = $("#areaValue").val();
            }
            else {
                alert("Please enter a value.");
                return false;
            }
            setareaList(searchString);
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
            $("#areaMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
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
                $("#overlay").fadeOut(500);
            });
        });
        $("#divSelect").click(function () {
            if ($("#divResult .selected").length > 0)
            {
                $("#hid_txtDivision").val($("#divResult .selected input").val());
                $("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
            }
            $("#divMaster").slideUp(500, function () {
                $("#overlayD").fadeOut(500);
            });
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
        $("#btnCommunication").click(function () {
            setSOComn($("#hid_sumId").val());

            $("#communicationMain").slideDown(500);

            $('.last').mouseenter(function () {
                var a = $(this).attr('id');
                $('#msg_hover').html($('#' + a).text());
                $('#msg_hover').show();
            });
            // $('.last').mouseleave(function(){
            // $('#msg_hover').fadeOut();
            // });
            $('.last').mouseout(function () {
                $('#msg_hover').hide();
            });
            return false;
        });
        $("#btnCollection").click(function () {
            setSOCollection($("#hid_txtCustomer").val(), $("#hid_txtDivision").val());
            $("#collectionMain").slideDown(500);
            return false;
        });

        $("#btnCancelOrder").click(function () {
            if (confirm("Do you want to cancel this Sales Order"))
            {
                $.ajax({
                    url: "<?php echo base_url(); ?>common/cancelSalesOrder/" + $("#hid_sumId").val(),
                    success: function (message) {
                        if (message)
                        {
                            alert('Successfully cancelled SO!!');
                            window.location.hash = "salesorder/view_sales_order";
                        }
                    }
                });
            }
        });
    });
    function setProducts()
    {
        $.ajax({
            //url: "<?php echo base_url(); ?>index.php/common/getSOProductDetails",
            url: "<?php echo base_url(); ?>index.php/common/getProducts/" +<?php echo $sodetails['summaryId']; ?>,
            success: function (message) {
                //alert(message);
                $("#addedRows").append(message);
                $("#hid_isAdded").val(1);
            }
        });
    }
    function btnAdd_Click()
    {
        if ($("#hid_PrdctId").val() == '')
        {
            alert("Choose product name");
        }
        else
        {
            var existingId = 0;
            $('#addedRows tr').each(function () {
                if ($("#hid_PrdctId").val() == $(this).find(".colcloseval input[type=hidden]").attr('id'))
                    existingId = $("#hid_PrdctId").val();
            });

            if (IsEdit || existingId === 0) {
                var qty = $("#txtQty").val() === '' ? 1 : parseFloat($("#txtQty").val());
                var offer_qty = $("#txtOfferQty").val() === '' ? 0 : parseFloat($("#txtOfferQty").val());
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/common/seteditSOListSess/" + $("#hid_PrdctId").val() + "/" + qty + "/" + offer_qty,
                    success: function (message) {
                        if ($("#hid_PrdctId").val() != "") {
                            var existId = 0;
                            $('#addedRows tr').each(function () {
                                if ($("#hid_PrdctId").val() == $(this).find(".colcloseval input[type=hidden]").attr('id'))
                                    existId = $("#hid_PrdctId").val();
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
                            $("#txtTotal").val(total);
                            $("#hid_PrdctId").val("");
                            $("#txtProductName").val("");
                            $('#txtProductName').focus();
                            $('#txtQty').val('');
                            $('#txtOfferQty').val('');
                            //$("#hid_isAdded").val(1);
                        }
                        // }
                        // else
                        // {
                        // alert('The product is already added!');
                        // }
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
            else
            {
                alert('This Product is already added');
            }
        }
    }

    function remove_SO_item(productId)
    {
        //$("#hid_PrdctId").val("");
        //$("#txtProductName").val("");
        $.ajax({
            url: "<?php echo base_url(); ?>common/removeEditSOList/" + productId,
            success: function (message) {
                //alert(message);
                if (message)
                {
                    $("#addedRows").find("#" + productId).parents("tr").remove();
                    $("#addedRows").find("#" + productId).parents("tr").children().removeClass('amt');
                    var total = 0;
                    $(".amt").each(function () {
                        //total = total + parseFloat($(this).text());
                        total = (parseFloat(total) + (parseFloat($(this).text() * 100) / 100)).toFixed(2);
                        //alert(total);
                    });
                    $("#txtTotal").val('');
                    $("#txtTotal").val(total);
                }
                else
                {
                    alert('Not removed');
                }
            }
        });
        $("#" + productId).val("");
        $("#" + productId).html("");
        $("#" + productId).hide();

    }

    function partialSave_Click(isConfirm)
    {
        var confirmed = 0;
        if (isConfirm != 'partial')
        {
            confirmed = 1;
        }
        var amount = $("#txtTotal").val();
        var divcode = $("#hid_txtDivision").val();
        var divName = $("#txtDivision").val();
        var areaId = $("#hid_txtArea").val();
        var DespatchMode = $("#ddlMode").val();
        if (areaId == "") {
            alert("Select Area!!!");
            return false;
        }
        if (divcode == "") {
            alert("Select Division!!!");
            return false;
        }
        if ($("#txtCustomer").val() == "") {
            alert("Please Choose Store!!!");
            return false;
        }
        if ($("#hid_isAdded").val() != 1) {
            alert("Please Select and Add Product!!!");
            return false;
        }
        if (DespatchMode != -1) {
            if (DespatchMode == 0 || DespatchMode == 1) {
                Despatch = 'NA';
                if ($('#txtTo').val().trim() != "") {
                    sosTo = $('#txtTo').val();
                } else {
                    alert('Please add Despatch To:');
                    return false;
                }
                if ($('#txtCarrier').val().trim() != "") {
                    sosCarrier = $('#txtCarrier').val();
                } else {
                    alert('Please add Despatch Carrier:');
                    return false;
                }
                if ($('#txtDestination').val().trim() != "") {
                    sosDestination = $('#txtDestination').val();
                }
            } else {
                if ($('#txtDespatch').val().trim() != "") {
                    Despatch = $('#txtDespatch').val();
                } else {
                    alert('Please add Despatch:');
                    return false;
                }
                sosTo = 'NA';
                sosCarrier = 'NA';
                sosDestination = 'NA';
            }
        } else {
            alert('Please select Despatch mode');
            return false;
        }
        if ($("#hid_isAdded").val() != 0) {
            $.ajax({
                url: "<?php echo base_url(); ?>salesorder/update_sales_order/" +<?php echo $sodetails['summaryId']; ?> + "/" + amount + "/" + DespatchMode + "/" + Despatch + "/" + sosTo + "/" + sosCarrier + "/" + sosDestination + "/" + confirmed,
                data: {
                    sales_type:$("#hid_txtCustomerPriceGroup").val() 
                },
                     success: function (message) {
                    if (message) {
                        alert('Updated successfully');
                        window.location.hash = "salesorder/view_sales_order";
                    } else {
                        alert('Not Updated');
                        window.location.hash = "salesorder/view_sales_order";
                    }
                }
            });
        } else {
            alert("Please add product details");
        }
    }
    function goback_Click()
    {
        document.location.hash = "common/view_sales_order";
    }
    function downloadSO()
    {
        $("#linkDownload").attr("href", "<?php echo base_url(); ?>common/downloadSalesOrder" + "/" + "<?php echo $sodetails['summaryId'] ?>");
    }
function downloadCSV()
    {
        $("#linkDownloadcsv").attr("href", "<?php echo base_url(); ?>common/downloadSalesOrderCSV" + "/" + "<?php echo $sodetails['summaryId'] ?>");
    }
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Edit Sales Order
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#salesorder/view_sales_order"><i class="fa fa-bar-chart-o"></i> Sales Orders</a></li>
        <li class="active">Edit Sales Order</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="table1">
                <input type="hidden" name="hid_sumId" id="hid_sumId" value="<?php echo $sodetails['summaryId']; ?>"/>
                <form name="salesOData" method="POST" action="<?php echo base_url(); ?>salesorder/update_sales_order">
                    <div class="box ">
                        <div class="box-header">
                            <div class="col-xs-8">
                                <h3 class="box-title">Edit Products</h3>
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
                                            <input type="text" class="form-control" name="txtArea" id="txtArea" value="<?php echo $sodetails['AreaName']; ?>"/>
                                            <input type="hidden" name="hid_txtArea" id="hid_txtArea" value="<?php echo $sodetails['areaId']; ?>"/>
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
                                            <input type="text" name="txtDivision" class="form-control" id="txtDivision" value="<?php echo $sodetails['DivisionName']; ?>"/>
                                            <input type="hidden" id="hid_txtDivision" name="hid_txtDivision" value="<?php echo $sodetails['divId']; ?>"/>
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
                                            <input type="text" name="txtCustomer" id="txtCustomer" class="form-control" value="<?php echo $sodetails['StoreName']; ?>"/>
                                            <input type="hidden" name="hidTxtCustomer" id="hid_txtCustomer" value="<?php echo $sodetails['storeId']; ?>"/>
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
                                        <?php echo form_dropdown('catogoryList', $dbArray, '', 'id="ddlcategory" class="form-control"'); ?>
                                    </div>
                                    <?php
                                    $userdata = $this->session->userdata('userdata');
                                    if ($userdata['umIsHOUser'] == 1) {
                                        ?>
                                        <div class="col-xs-1">
                                            Ordered By 
                                        </div>
                                        <div class="col-xs-3" id="divddlSalesRep">
                                            <input type="text" name="txtOrderedBy" Readonly="ReadOnly" class="form-control" id="txtOrderedBy" value="<?php echo $sodetails['OrderedBy']; ?>"/>
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
                                        <input type="text" name="txtPrdctName" id="txtProductName" class="form-control" />
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
                                    <input type="text" id="txtTotal" name="txtTotal" value="<?php echo $sodetails['Amount']; ?>" />
                                </div><!--total-->
                            </div><!--totalcontent-->
                            <div id="modediv" class="row-fluid">
                                <div class="mode">
                                    <a>Mode</a>
                                    <select id="ddlMode" name="ddlMode" onchange="sendModeChange();" value="<?php echo $sodetails['DespatchMode']; ?>">
                                        <option value="-1">--Select--</option>
                                        <option value="0">By Parcel</option>
                                        <option value="1">By Courier</option>
                                        <option value="2">By Supply</option>
                                        <option value="3">By Hand</option>
                                    </select>
                                </div><!--mode-->
                                <div id="divDispatch">
                                    <a>Despatch</a>
                                    <input type="text" id="txtDespatch" name="txtDespatch" value="<?php echo $sodetails['Despatch']; ?>" />
                                </div>
                                <div id="divParcel">
                                    <a>To</a>
                                    <input type="text" id="txtTo" name="txtTo" value="<?php echo $sodetails['To']; ?>" />
                                    <a>Carrier</a>
                                    <input type="text" id="txtCarrier" name="txtCarrier" value="<?php echo $sodetails['Carrier']; ?>" />
                                    <a>Destination</a>
                                    <input type="text" id="txtDestination" name="txtDestination" value="<?php echo $sodetails['Destination']; ?>" />
                                </div>
                            </div><!--modediv-->
                            <div id = "button_part" class="row-fluid">
                                <table  class="row-fluid">
                                    <tr>
                                        <td class="button span1">
                                            <input type="button" name="btnPartialSave" class="btn btn-primary" id="btnPartialSave" onclick="return partialSave_Click('partial');" Value="Partial Save" />
                                        </td>
                                        <td class="button span1">
                                            <input type="button" name="btnConfirmOrder" class="btn btn-primary" Value="Confirm Order" onclick="return partialSave_Click('confirm');"/>
                                            <input type="hidden" name="isConfirmBtn" id="isConfirmBtn" value="0"/>
                                        </td>
                                        <td class="button span1" >
                                            <input type="button" name="btnCommunication"  class="btn btn-info" Value="Communication" id="btnCommunication" />
                                        </td>
                                        <td class="button span1">
                                            <input type="button" name="btnCollection" class="btn btn-info" Value="Collection" id="btnCollection" />
                                        </td>
                                        <td class="button span1">
                                            <a id="linkDownload" href="#" class="linkButton btn btn-primary" onclick="downloadSO();">Download XLS</a>
                                        </td>
<td class="button span1">
                                            <a id="linkDownloadcsv" href="#" class="linkButton btn btn-primary" onclick="downloadCSV();">Download CSV</a>
                                        </td>
                                        <td class="button span1">
                                            <input type="button" class="btn btn-primary" name="btnCancelOrder" Value="Cancel Order" id="btnCancelOrder" />
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
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
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

<div class="modal fade in" id="communicationMain" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Sales Order Communication</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">
                        <br/>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="col-xs-3">
                                    <input type="radio" name="statusType" id="sosIsPending" Value="0"/>
                                    Pending 
                                </div>
                                <div class="col-xs-3">
                                    <input type="radio" name="statusType" id="sosIsInProcess" Value="0"/>
                                    In Process 
                                </div>
                                <div class="col-xs-3">
                                    <input type="radio" name="statusType" id="sosIsSuspended" Value="0"/>
                                    Suspended 
                                </div>
                                <div class="col-xs-3">
                                    <input type="radio" name="statusType" id="sosIsCompleted" Value="0"/>
                                    Completed 
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="col-xs-12">
                            <div class="col-xs-4">
                                So Number: <?php echo $sodetails['SONo']; ?>
                            </div>
                            <div class="col-xs-2">
                                Comment: 
                            </div>
                            <div class="col-xs-4">
                                <textarea name="txtComment" id ="txtComment" class="form-control" cols="20" rows="2" ></textarea>
                            </div>
                            <div class="col-xs-2">
                                <input type="submit" value="Save" id="saveCommunication" class=" linkButton btn btn-primary" onclick="saveCommunication();"/>
                            </div>
                        </div>
                        <br/>
                        <div class="items box-body table-responsive" id="communicationList"> 
                            <table   class="table  table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td>Date</td>
                                        <td>Created By</td>
                                        <td>Description</td>
                                    </tr>
                                </thead>
                                <tbody  id="communicationResult" >

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left close-btn"  >
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
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
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
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
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

<div class="modal fade in" id="collectionMain" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Collection Details</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" > 
                            <table   class="table  table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td id="cdate">Date</td>
                                        <td id="chckdate">Check Date</td>
                                        <td id="chckdate">Mode</td>
                                        <td id="bankname">Ref.No/Bank Name</td>
                                        <td >Amount</td>
                                        <td id="colum1">Remarks</td>
                                    </tr>
                                </thead>
                                <tbody  id="collectionResult" >

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left close-btn"  >
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
