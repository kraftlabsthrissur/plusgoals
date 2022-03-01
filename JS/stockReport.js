
$(function () {

    var baseUrl = $("#baseUrl").val();
    $("#txtFromDate").datepicker();
    $("#txtToDate").datepicker();
    $("#searchOpt input").attr('disabled', 'disabled');
    radiocheckchange();
    setBranchMaster();
    $.datepicker.setDefaults({
        dateFormat: 'dd.mm.yy'
    });
    $("#btnBranch,#btnItems,#btnCategory").click(function () {
        var id = $(this).attr('id');
        $("#storeValue").val("");
        $("#codeValue").val("");
        $("#hid_table").val(id);
        setBranchList('all', '', id);

        var dWidth = $(document).width();
        var pLeft = (($(window).width())) - 502;
        var dHeight = $(document).height();
        var pHeight = (($(window).height())) - 386 + $(window).scrollTop();
        $("#overlay").css("width", dWidth + "px");
        $("#overlay").css("height", dHeight + "px");
        $("#overlay").fadeIn(500, function () {
            $("#storeMaster").css("left", pLeft / 2 + "px");
            $("#storeMaster").css("top", pHeight / 2 + "px");
            $("#storeMaster").slideDown(500);
        });
        return false;
    });
    $("#closeStore").click(function () {
        $("#storeMaster").slideUp(500, function () {
            $("#overlay").fadeOut(500);
        });
        return false;
    });
    $("#storeSearch").click(function () {
        var type = "name";
        var searchString = "";
        if ($("#storeValue").val().trim() != "") {
            searchString = $("#storeValue").val();
        }
        else if ($("#codeValue").val().trim() != "") {
            type = "code";
            searchString = $("#codeValue").val();
        }
        else {
            type = "all";
        }
        setBranchList(type, searchString, $("#hid_table").val());
    });
    String.prototype.ltrim = function () {
        return this.replace(/^\s+/, "");
    }
    String.prototype.rtrim = function () {
        return this.replace(/\s+$/, "");
    }
    $("#storeSelect").click(function () {
        if ($("#storeResult .selected").length > 0)
        {
            $("#txtBranchId").val($("#storeResult .selected input").val());
            $("#txtBranch").val($("#storeResult .selected td.first").text().ltrim().rtrim());
        }
        $("#txtBranchCode").val($("#storeResult .selected td.second").text().ltrim().rtrim());
        $("#storeMaster").slideUp(500, function () {
            $("#overlay").fadeOut(500);
        });
    });
    $("#storeClose").click(function () {
        $("#storeMaster").slideUp(500, function () {
            $("#overlay").fadeOut(500);
        });
    });

    $("#storeSelect").click(function () {
        if ($("#storeResult .selected").length > 0)
        {
            cleartext_hidFields('');
            if ($("#hid_table").val() == 'btnBranch') {
                $("#hid_Branches").val($("#storeResult .selected input").val());
                $("#txtBranches").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                //$("#txtBranchCode").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            else if ($("#hid_table").val() == 'btnItems') {
                $("#hid_Items").val($("#storeResult .selected input").val());
                $("#txtItems").val($("#storeResult .selected td.first").text().ltrim().rtrim());
            }
            else if ($("#hid_table").val() == 'btnCategory') {
                $("#hid_Category").val($("#storeResult .selected input").val());
                $("#txtCategory").val($("#storeResult .selected td.first").text().ltrim().rtrim());
            }
        }
        $("#storeMaster").slideUp(500, function () {
            $("#overlay").fadeOut(500);
        });
    });

    //////////////////////////////////////////////////////////////////////////////////////////////

    //$("#lblrptHeading").text('StockReport');
    //$("#lblFrom").text($('#txtFromDate').val());
    //$("#lblTo").text($('#txtToDate').val());
});





function radiocheckchange()
{
    //var id = $("input[@name=group1]:checked").attr('id');
    $("input[name='group1']").change(function () {
        $("#searchOpt input").attr('disabled', 'disabled');
        if ($("input[name='group1']:checked").val() == 'BranchWise')
            $("#btnBranch,#txtBranches").removeAttr('disabled');
        else if ($("input[name='group1']:checked").val() == 'ItemWise')
            $("#btnItems,#txtItems").removeAttr('disabled');
        else if ($("input[name='group1']:checked").val() == 'CategoryWise')
            $("#btnCategory,#txtCategory").removeAttr('disabled');
        else {
            $("#searchOpt input").attr('disabled', 'disabled');
            cleartext_hidFields('');
            $("#hid_table").val('');
        }
    });
}
function setBranchMaster() {
    $("#storeList tr").click(
            function () {
                $("#storeList tr").removeClass("selected");
                $(this).addClass("selected");
            }
    );
    $("#storeList tr").dblclick(function () {
        if ($("#storeResult .selected").length > 0)
        {
            cleartext_hidFields('');
            if ($("#hid_table").val() == 'btnBranch') {
                $("#hid_Branches").val($("#storeResult .selected input").val());
                $("#txtBranches").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                //$("#txtBranchCode").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            else if ($("#hid_table").val() == 'btnItems') {
                $("#hid_Items").val($("#storeResult .selected input").val());
                $("#txtItems").val($("#storeResult .selected td.first").text().ltrim().rtrim());
            }
            else if ($("#hid_table").val() == 'btnCategory') {
                $("#hid_Category").val($("#storeResult .selected input").val());
                $("#txtCategory").val($("#storeResult .selected td.first").text().ltrim().rtrim());
            }
        }
        $("#storeMaster").slideUp(500, function () {
            $("#overlay").fadeOut(500);
        });
    });
}
function cleartext_hidFields(param)
{
    $("#txtBranches").val('');
    $("#txtItems").val('');
    $("#txtCategory").val('');
    $("#hid_Branches").val('');
    $("#hid_Items").val('');
    $("#hid_Category").val('');
    if (param != '')
    {
        $("#txtFromDate").val('');
        $("#txtToDate").val('');
        $("#hid_table").val('');
        $("#radioAll").prop('checked', true);
        $("#searchOpt input").attr('disabled', 'disabled');
    }
}
function setBranchList(type, searchString, id) {
    $.ajax({
        //url: "http://computer2/OrderWalaCode/index.php/stockManager/getPopUp/"+type+"/"+searchString+"/"+id,
        url: "getPopUp/" + type + "/" + id + "/" + searchString,
        success: function (message) {
            setpopUpConfig(id);
            $("#storeResult").html("");
            $("#storeResult").html(message);
            setBranchMaster();
        }
    });
}
function setpopUpConfig(id)
{
    if (id == 'btnBranch') {
        $("#popHeadId").text("Branch Master");
        $("#poptitle1Id").text("Branch");
    }
    else if (id == 'btnItems') {
        $("#popHeadId").text("Item Master");
        $("#poptitle1Id").text("Item");
    }
    else {
        $("#popHeadId").text("Category Master");
        $("#poptitle1Id").text("Category");
    }
}
function validation()
{
    if ($("#txtFromDate").val() == '')
    {
        //alert('Please Choose From Date'); 
        return false;
    }
    else if ($("#txtToDate").val() == '')
    {
        //alert('Please Choose To Date'); 
        return false;
    }
    else
    {
        var windowSizeArray = ["width=200,height=200",
            "width=300,height=400,scrollbars=yes"]
        var url = "openReportWindow/" + $("#txtFromDate").val() + "/" + $("#txtToDate").val();
        //alert(url);
        var windowName = "_Report";
        var windowSize = windowSizeArray[$(this).attr("rel")];
        window.open(url, windowName, windowSize);
    }
}
function btnDeleteClick()
{
    confirm('Are you sure you want to Delete the stocklist upto the date ' + $('#txtFromDate').val() + '');
}