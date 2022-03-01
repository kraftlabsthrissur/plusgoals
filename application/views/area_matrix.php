<script type="text/javascript">
    function setSubArea() {
        $("#subAreaList tbody tr").click(
                function () {
                    $("#subAreaList tr").removeClass("selected");
                    $(this).addClass("selected");
                }
        );
        $("#zoneList tbody tr").click(
                function () {
                    $("#zoneList tr").removeClass("selected");
                    $(this).addClass("selected");
                }
        );
        $("#areaList tbody tr").click(
                function () {
                    $("#areaList tr").removeClass("selected");
                    $(this).addClass("selected");
                }
        );
        $("#divList tbody tr").click(
                function () {
                    $("#divList tr").removeClass("selected");
                    $(this).addClass("selected");
                }
        );
        $("#subAreaList tbody tr").dblclick(function () {
            if ($("#subAreaResult .selected").length > 0)
            {
                $("#hid_txtSubArea").val($("#subAreaResult .selected input").val());
                $("#txtSubArea").val($("#subAreaResult .selected td.first").text().ltrim().rtrim());
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/admin/showAreaMatrix/" + $("#hid_txtSubArea").val(),
                    success: function (message) {
                        $("#areamatrixresults").html(message);
                    }
                });
            }
            $("#SubAreaMaster").slideUp(500);
        });

        $("#zoneList tbody tr").dblclick(function () {
            if ($("#zoneResult .selected").length > 0)
            {
                $("#hid_txtZone").val($("#zoneResult .selected input").val());
                $("#txtZone").val($("#zoneResult .selected td.first").text().ltrim().rtrim());
            }
            $("#zoneMaster").slideUp(500);
        });
        $("#areaList tbody tr").dblclick(function () {
            if ($("#areaResult .selected").length > 0)
            {
                $("#hid_txtArea").val($("#areaResult .selected input").val());
                $("#txtArea").val($("#areaResult .selected td.first").text().ltrim().rtrim());
            }
            $("#areaMaster").slideUp(500);
        });
        $("#divList tbody tr").dblclick(function () {
            if ($("#divResult .selected").length > 0)
            {
                $("#hid_txtDivision").val($("#divResult .selected input").val());
                $("#txtDivision").val($("#divResult .selected td.first").text().ltrim().rtrim());
            }
            $("#divMaster").slideUp(500);
        });
    }

    $(document).ready(function () {
        String.prototype.ltrim = function () {
            return this.replace(/^\s+/, "");
        }
        String.prototype.rtrim = function () {
            return this.replace(/\s+$/, "");
        }
        $('.nobg').hide();
        $("#txtSubArea").attr("readonly", "readonly");
        $("#txtZone").attr("readonly", "readonly");
        $("#txtArea").attr("readonly", "readonly");
        $("#txtDivision").attr("readonly", "readonly");
        setSubArea();

        $("#viewSubArea").click(function () {
            $("#SubAreaMaster").slideDown(500);
        });
        $("#viewZone").click(function () {
            $("#zoneMaster").slideDown(500);
            return false;
        });
        $("#viewArea").click(function () {
            $("#areaMaster").slideDown(500);
        });
        $("#viewDivision").click(function () {
            $("#divMaster").slideDown(500);
        });

        $("#subAreaSelect").click(function () {
            if ($("#subAreaResult .selected").length > 0)
            {
                $("#hid_txtSubArea").val($("#subAreaResult .selected input").val());
                $("#txtSubArea").val($("#subAreaResult .selected td.first").text().ltrim().rtrim());
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/admin/showAreaMatrix/" + $("#hid_txtSubArea").val(),
                    success: function (message) {
                        $("#areamatrixresults").html(message);
                    }
                });
            }
            $("#SubAreaMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
        });

        $("#zoneSelect").click(function () {
            if ($("#zoneResult .selected").length > 0)
            {
                $("#hid_txtZone").val($("#zoneResult .selected input").val());
                $("#txtZone").val($("#zoneResult .selected td.first").text().ltrim().rtrim());
            }
            $("#zoneMaster").slideUp(500);
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
            }
            $("#divMaster").slideUp(500);
        });
    });
    function fillAddAreamatrixDet()
    {
        if ($("#txtSubArea").val().trim() != "")
        {
            if ($("#txtZone").val().trim() == "")
            {
                alert("Please Choose Zone!");
            }
            else if ($("#txtArea").val().trim() == "")
            {
                alert("Please Choose Area!");
            }
            else if ($("#txtDivision").val().trim() == "")
            {
                alert("Please Choose Division!");
            }
            else
            {
                $("#addViewZone").text($("#txtZone").val());
                $("#addViewArea").text($("#txtArea").val());
                $("#addViewDivision").text($("#txtDivision").val());
                $("#btnAddtoAreaMatrix").show();
            }
            $('.nobg').show();
        }
        else
        {
            alert("Plase choose SubArea first.");
        }
    }
    function btnAddtoAreaMatrix_Click()
    {
        var subAreaId = $("#hid_txtSubArea").val();
        var zoneName = $("#txtZone").val();
        var AreaName = $("#txtArea").val();
        var DivisionName = $("#txtDivision").val();
        var zoneId = $("#hid_txtZone").val();
        var AreaId = $("#hid_txtArea").val();
        var DivisionId = $("#hid_txtDivision").val();
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/admin/add_area_matrix_details/" + subAreaId + "/" + zoneName + "/" + zoneId + "/" + AreaName + "/" + AreaId + "/" + DivisionName + "/" + DivisionId,
            success: function (message) {
                alert("successfully saved");
                $("#areamatrixresults").html(message);
                //$("#viewAddZoneView").hide();
                $("#txtZone").val("");
                $("#txtArea").val("");
                $("#txtDivision").val("");
                $("#addViewZone").text("");
                $("#addViewArea").text("");
                $("#addViewDivision").text("");
                $("#btnAddtoAreaMatrix").hide();
            }
        });
    }
    function removeAreaMatrix(amxId, subAreaId)
    {
        if (confirm('Do you want to delete this?'))
        {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/admin/removeAreaMatrixById/" + amxId + "/" + subAreaId,
                success: function (message) {
                    $("#areamatrixresults").html(message);
                }
            });
        }
    }
    function btnReset() {
        $('#txtSubArea').val('');
        $('#hid_txtSubArea').val('');
        $('#txtZone').val('');
        $('#hid_txtZone').val('');
        $('#txtArea').val('');
        $('#hid_txtArea').val('');
        $('#txtDivision').val('');
        $('#hid_txtDivision').val('');
        $('#areamatrixresults').html('');
        $("#viewAddZoneView div:not(#addViewAdd)").text("")

        $(".nobg").hide()

    }
</script>
<section class="content-header">
    <h1>
        Area Matrix
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Area Matrix</li>
    </ol>
</section>

<section id="content" class="content">	
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <br/>
                    <div class="row">

                        <div class="col-xs-12">
                            <div class="col-xs-1">
                                Sub Area
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="txtSubArea" class="form-control" id="txtSubArea"/>
                                    <input type="hidden" name="hid_txtSubArea" id="hid_txtSubArea"/>
                                    <span class="input-group-btn">
                                        <button id="viewSubArea" class="btn btn-info btn-flat" type="button">View</button>
                                    </span>
                                </div>
                                <?php echo @$error['zmBranchId']; ?>

                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="box-body table-responsive" style="min-height: 200px;">
                            <table id="areas" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Zone Name
                                        </th>
                                        <th>
                                            Area Name
                                        </th>
                                        <th>
                                            Division Name
                                        </th>
                                        <th>
                                            Remove
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="areamatrixresults" >
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br/>
                    <div class="viewAreaDetails"></div>
                    <br/>
                    <div class="row">

                        <div class="col-xs-12">
                            <div class="col-xs-1">
                                Zone
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="txtZone" class="form-control" id="txtZone"/>
                                    <input type="hidden" id="hid_txtZone"/>
                                    <span class="input-group-btn">
                                        <button id="viewZone" class="btn btn-info btn-flat" type="button">View</button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-xs-1">
                                Area
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="txtArea" class="form-control" id="txtArea"/>
                                    <input type="hidden" id="hid_txtArea" />
                                    <span class="input-group-btn">
                                        <button id="viewArea" class="btn btn-info btn-flat" type="button">View</button>
                                    </span>
                                </div>

                            </div>
                            <div class="col-xs-1">
                                Division
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="txtDivision" class="form-control" id="txtDivision"/>
                                    <input type="hidden" id="hid_txtDivision"/>
                                    <span class="input-group-btn">
                                        <button id="viewDivision" class="btn btn-info btn-flat" type="button">View</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-1">
                                <input type="button" class="btn btn-primary" name="btnSubmit" Value="Submit" onclick="javascript:fillAddAreamatrixDet();"/>
                            </div>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="box-body table-responsive" style="min-height: 80px;">
                            <table id="areas" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Zone Name
                                        </th>
                                        <th>
                                            Area Name
                                        </th>
                                        <th>
                                            Division Name
                                        </th>
                                        <th>
                                            Add
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="viewAddZoneView" >
                                    <tr>
                                        <td id="addViewZone" ></td>
                                        <td id="addViewArea" ></td>
                                        <td id="addViewDivision" ></td>
                                        <td id="addViewAdd" >
                                            <input type="button" id="btnAddtoAreaMatrix" onclick="javascript:btnAddtoAreaMatrix_Click();" class="btn-primary btn-xs btn " style="display: none;" value="Add"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br/> 
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-1">
                                <input type="reset"  class ="reset_button btn btn-primary" id="btnReset" Value="Reset" onclick="return btnReset();"/>
                            </div>
                        </div>
                    </div>
                </div><!--subtab_content-->
            </div><!--subcontent-->
        </div>
    </div>
</section>



<div class="modal fade in" id="zoneMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Zone Master</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="zoneList"> 
                            <table cellpadding="0" cellspacing="0" id="zoneResult" class="table  table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>Zone</td>
                                        <td></td>
                                    </tr>
                                </thead>  
                                <tbody>
                                    <?php
                                    if ($zoneArray->num_rows() > 0) {
                                        foreach ($zoneArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->zmZoneName; ?>
                                                </td>
                                                <td class="second"> 
                                                    <input type="hidden" value="<?php echo $row->zmId; ?>">
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
                        <button type="submit" class="btn btn-primary pull-left" id="zoneSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade in" id="areaMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Area Master</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="areaList"> 
                            <table cellpadding="0" cellspacing="0" id="areaResult" class="table  table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>Area</td>
                                        <td></td>
                                    </tr>
                                </thead>  
                                <tbody>
                                    <?php
                                    if ($areaArray->num_rows() > 0) {
                                        foreach ($areaArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->amAreaName; ?>
                                                </td>
                                                <td class="second"> 
                                                    <input type="hidden" value="<?php echo $row->amId; ?>">
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
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Division Master</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="divList"> 
                            <table cellpadding="0" cellspacing="0" id="divResult" class="table  table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>Division</td>
                                        <td></td>
                                    </tr>
                                </thead>  
                                <tbody>
                                    <?php
                                    if ($divisionArray->num_rows() > 0) {
                                        foreach ($divisionArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->dmDivisionName; ?>
                                                </td>
                                                <td class="second"> 
                                                    <?php echo $row->dmCode; ?>
                                                    <input type="hidden" value="<?php echo $row->dmId; ?>">
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
                        <button type="submit" class="btn btn-primary pull-left" id="divSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="SubAreaMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Sub Area Master</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="subAreaList"> 
                            <table cellpadding="0" cellspacing="0" id="subAreaResult" class="table  table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>Sub Area</td>
                                        <td></td>
                                    </tr>
                                </thead>  
                                <tbody>
                                    <?php
                                    if ($subAreaArray->num_rows() > 0) {
                                        foreach ($subAreaArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->saSubAreaName; ?>
                                                </td>
                                                <td class="second"> 
                                                    <input type="hidden" value="<?php echo $row->saId; ?>">
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
                        <button type="submit" class="btn btn-primary pull-left" id="subAreaSelect" >
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
    $(function () {
        $('#subAreaResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
        $('#divResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
        $('#areaResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
        $('#zoneResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>