<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/area_allocation.css"/>
<script type="text/javascript">

    function submit_click()
    {
        if ($('#subArealistId').val() == -1)
        {
            alert("Please Choose SubArea");
            return false;
        }
        if (($("#txtStores").val().trim() == "") && ($("#txtSp").val().trim() == "") && ($("#txtManager").val().trim() == ""))
        {
            alert("Please Choose any Usertype");
            return false;
        }
        return true;
    }
    function setStoreMaster() {
        $("#storeList").on('click','tbody tr',
                function () {
                    selectRow("storeList", $(this));
                }
        );
        $("#storeList").on('dblclick','tbody tr',function () {
            selectRow("storeList", $(this));
            if ($("#storeResult .selected").length > 0)
            {
                $("#hid_txtStore").val($("#storeResult .selected input").val());
                $("#txtStores").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            //closePopup("storeMaster");
            $("#storeMaster").slideUp(500);
        });
        $("#managerList").on('click','tbody tr',function () {
            selectRow("managerList", $(this));
        }
        );
        $("#managerList").on('dblclick','tbody tr',function () {
            selectRow("managerList", $(this));
            if ($("#managerResult .selected").length > 0)
            {
                $("#hid_Manger_id").val($("#managerResult .selected input").val());
                $("#txtManager").val($("#managerResult .selected td.first").text().ltrim().rtrim());
                $("#hid_manager_code").val($("#managerResult .selected td.second").text().ltrim().rtrim());
            }
            //closePopup("managerdet");
            $("#managerdet").slideUp(500);
        });
        $("#SRList tbody tr").click(function () {
            selectRow("SRList", $(this));
        }
        );
        $("#SRList tbody tr").dblclick(function () {
            selectRow("SRList", $(this));
            if ($("#SRResult .selected").length > 0)
            {
                $("#hid_sp_id").val($("#SRResult .selected input").val());
                $("#txtSp").val($("#SRResult .selected td.first").text().ltrim().rtrim());
                $("#hid_sp_code").val($("#SRResult .selected td.second").text().ltrim().rtrim());
            }
            $("#SalesRepdet").slideUp(500);
        });
    }
    function selectRow(divId, el)
    {
        $("#" + divId + " tr").removeClass("selected");
        el.addClass("selected");
    }
//function setStoreList(type, subAreaId,searchString) {
    function setStoreList(type, searchString) {
        if (searchString == '')
        {
            searchString = "searchstringMissing";
        }
        var selectedId = $("#subArealistId").val();
        $.ajax({
            url: "<?php echo base_url(); ?>admin/getStoreMaster/" + type + "/" + searchString + "/" + selectedId,
            success: function (message) {
                $("#storeList").html(message);
                $("#storeMaster").slideDown(500);
                setStoreMaster();
            }
        });
    }


    $(function () {
        $("#txtStores").attr("readonly", "readonly");
        $("#txtManager").attr("readonly", "readonly");
        $("#txtSp").attr("readonly", "readonly");
        setStoreMaster();
        $("#viewStore").click(function () {
            setStoreList('all', '');

        });
        $("#viewManager").click(function () {
            $("#managerdet").slideDown(500);
        });
        $("#viewSalesRep").click(function () {
            $("#SalesRepdet").slideDown(500);
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
                $("#hid_txtStore").val($("#storeResult .selected input").val());
                $("#txtStores").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            $("#storeMaster").slideUp(500);
        });

        $("#managerSelect").click(function () {
            if ($("#managerResult .selected").length > 0)
            {
                $("#hid_Manger_id").val($("#managerResult .selected input").val());
                $("#txtManager").val($("#managerResult .selected td.first").text().ltrim().rtrim());
                $("#hid_manager_code").val($("#managerResult .selected td.second").text().ltrim().rtrim());
            }
            $("#managerdet").slideUp(500);
        });

        $("#SRSelect").click(function () {
            if ($("#SRResult .selected").length > 0)
            {
                $("#hid_sp_id").val($("#SRResult .selected input").val());
                $("#txtSp").val($("#SRResult .selected td.first").text().ltrim().rtrim());
                $("#hid_sp_code").val($("#SRResult .selected td.second").text().ltrim().rtrim());
            }
            $("#SalesRepdet").slideUp(500);
        });


    });


    function subAreaChange()
    {
        //alert('a');
        var selectedId = $("#subArealistId").val();
        $.ajax({
            url: "<?php echo base_url(); ?>admin/showSubAreaAllocation/" + selectedId,
            success: function (message) {
                $("#allocatedResult").html("");
                $("#allocatedResult").html(message);
            }
        });
    }
    $("#hideshowCustomer").click(function () {
        $("#subAreaCustomer").hide();
    });
    function hideshowCustomer()
    {
        $(".divCustomers").toggle();
    }
    function hideshowManager()
    {
        $(".divManagers").toggle();
    }
    function hideshowSalesRep()
    {
        $(".divSalesReps").toggle();
    }
    function deleteAllocation(allocationId, type)
    {
        var deletingId = $("#" + allocationId).val();
        if (confirm('Do you want to delete this Allocation'))
        {
            $.ajax({
                url: "<?php echo base_url(); ?>admin/deleteSubAreaAllocation/" + deletingId + "/" + type,
                success: function (message) {
                    //alert('Deleted successfully');
                    subAreaChange();
                }
            });
        }
        else
        {
            return false;
        }
    }
    function btnResetClick() {
        $('#allocatedResult').html('');
    }
</script>
<section class="content-header">
    <h1>
        Sub Area Allocation
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sub Area Allocation</li>
    </ol>
</section>

<!-- Main content -->

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Sub Area Allocation</h3>
                    </div>
                </div><!-- /.box-header -->
                <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                <div class="box-body table-responsive">
                    <form name="subAraeallocation" method="post" class="ajax-submit" action="admin/AllocateSubArea"> 
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Sub Area 
                                    </div>
                                    <div class="col-xs-4">
                                        <?php echo form_dropdown('subAreaList', $dbArray, '', 'id="subArealistId" onchange="subAreaChange();" class="form-control"'); ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Sales Rep. 
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="txtSp" id="txtSp" readonly value="" />
                                            <input type="hidden" name="hid_sp_code" id="hid_sp_code" value=""/>
                                            <input type="hidden" id="hid_sp_id" name="hid_sp_id" value="" />
                                            <span class="input-group-btn">
                                                <button id="viewSalesRep" class="btn btn-info btn-flat" type="button">View</button>
                                            </span>
                                        </div>
                                        <?php //echo @$error['zmBranchId']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Manager
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="txtManager" id="txtManager" readonly value="" />
                                            <input type="hidden" name="hid_manager_code" id="hid_manager_code" value=""/>
                                            <input type="hidden" id="hid_Manger_id" name="hid_Manger_id" value=""/>
                                            <span class="input-group-btn">
                                                <button id="viewManager" class="btn btn-info btn-flat" type="button">View</button>
                                            </span>
                                        </div>
                                        <?php //echo @$error['zmBranchId']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Store
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="txtStore_name" id="txtStores" readonly value="" />
                                            <input type="hidden" name="txtStore" id="hid_txtStore" value=""/>
                                            <input type="hidden" id="hid_Code" name="hid_Code" value="" />
                                            <span class="input-group-btn">
                                                <button id="viewStore" class="btn btn-info btn-flat" type="button">View</button>
                                            </span>
                                        </div>
                                        <?php //echo @$error['zmBranchId']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">

                                        <input type="submit" onclick="return submit_click();" class="btn btn-primary" name="btnSave" Value="Save" />
                                        <input type="reset" name="btnReset" class="reset btn btn-warning" Value="Reset" onclick="return btnResetClick();" />

                                    </div>
                                </div>

                            </div>                            
                        </div>
                        <br/>
                    </form>
                </div><!--table-->	
            </div>
            <div class="box">
                <div class="box-body table-responsive " >
                    <div style="min-height: 200px;">
                        <table  id = "allocation" class="table  table-bordered table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th style="width: 36px;">

                                    </th>
                                    <th >
                                        Name
                                    </th>
                                    <th >
                                        Code
                                    </th>
                                    <th >
                                        Delete
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="allocatedResult">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


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
<div class="modal fade in" id="managerdet" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Manager</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="managerList"> 
                            <table id="managerResult" class="table table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td>Manager</td>
                                        <td>Usercode</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($managerArray->num_rows() > 0) {

                                        foreach ($managerArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->umUserName; ?>
                                                </td>
                                                <td class="second"><?php echo $row->umUserCode; ?>
                                                    <input type="hidden" value="<?php echo $row->umId; ?>">
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
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal" >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left" id="managerSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="SalesRepdet" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Sales Representative</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="SRList"> 
                            <table id="SRResult" class="table table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td>Sales Representative name </td>
                                        <td>Usercode</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($SRArray->num_rows() > 0) {

                                        foreach ($SRArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->umUserName; ?>
                                                </td>
                                                <td class="second"><?php echo $row->umUserCode; ?>
                                                    <input type="hidden" value="<?php echo $row->umId; ?>">
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
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal" >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left" id="SRSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#right-content').on('click', '.modal .close, .modal .close-btn', function () {
        $('.modal').slideUp(800);
    });
    if ($('#managerResult tbody tr td').length > 1) {
        $(function () {
            $('#managerResult').dataTable({
                "bInfo": true,
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bAutoWidth": true,
            });
        });
    }
    if ($('#SRResult tbody tr td').length > 1) {
        $(function () {
            $('#SRResult').dataTable({
                "bInfo": true,
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bAutoWidth": true,
            });
        });
    }
</script>
