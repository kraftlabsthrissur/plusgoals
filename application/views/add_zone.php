<script type="text/javascript">
    function setBranchMaster() {
        $("#branchList tr").click(function () {
            $("#branchList tr").removeClass("selected");
            $(this).addClass("selected");
        }
        );
        $("#branchList tr").dblclick(function () {
            if ($("#branchResult .selected").length > 0)
            {
                $("#txtBranchId").val($("#branchResult .selected input").val());
                $("#txtBranch").val($("#branchResult .selected td.first").text().ltrim().rtrim());
                $("#txtBranchCode").val($("#branchResult .selected td.second").text().ltrim().rtrim());
            }
            $("#branchMaster").slideUp(500);
        });
    }
    function setBranchList(type, searchString) {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/getBranchMaster/" + type + "/" + searchString,
            success: function (message) {
                $("#branchResult").html(message);
                setBranchMaster();
            }
        });
    }
    $(function () {
        //$("#txtStores").attr("readonly","readonly");
        setBranchMaster();
        $("#viewBranches").click(function () {
            $("#branchMaster").slideDown(500);
        });
        return false;
    });
    $("#branchSelect").click(function () {
        if ($("#branchResult .selected").length > 0)
        {
            $("#txtBranchId").val($("#branchResult .selected input").val());
            $("#txtBranch").val($("#branchResult .selected td.first").text().ltrim().rtrim());
            $("#txtBranchCode").val($("#branchResult .selected td.second").text().ltrim().rtrim());
        }
        $("#branchMaster").slideUp(500);
    });
    String.prototype.ltrim = function () {
        return this.replace(/^\s+/, "");
    }
    String.prototype.rtrim = function () {
        return this.replace(/\s+$/, "");
    }
</script>
<section class="content-header">
    <h1>
        Add Zone
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_zones"><i class="fa fa-laptop"></i> Zone</a></li>
        <li class="active">Add Zone</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Zone</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit" action="admin/add_zone">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Zone Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="dmCode" class="required form-control" name="zmCode" value="<?php echo @$zone_details['zmCode']; ?>" />
                                        <?php echo @$error['zmCode']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Zone Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="zmZoneName" class="form-control" value="<?php echo @$zone_details['zmZoneName']; ?>"/>
                                        <?php echo @$error['zmZoneName']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Branch Name
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="bmBranchName" id="txtBranch" readonly value="<?php echo @$zone_details['bmBranchName']; ?>" />
                                            <input type="hidden" name="zmBranchId" id="txtBranchId" value="<?php echo @$zone_details['zmBranchId']; ?>"/>
                                            <input type="hidden" id="txtBranchCode" name="hid_Code" value="<?php echo @$zone_details['hid_Code']; ?>" />
                                            <span class="input-group-btn">
                                                <button id="viewBranches" class="btn btn-info btn-flat" type="button">View Branches</button>
                                            </span>
                                        </div>
                                        <?php echo @$error['zmBranchId']; ?>

                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="zmId" Value="<?php echo @$zone_details['zmId']; ?>"/>
                                    </div>
                                </div>
                                <br/>
                            </div>
                        </div>                     
                    </form>
                </div><!--tablecontent-->
            </div><!--subcontent-->
        </div>
    </div>
</section>



<div class="modal fade in" id="branchMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Branches</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="branchList"> 
                            <table  id="branchResult" class="table  table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td>Branch Name</td>

                                        <td>Branch Code</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($branches->num_rows() > 0) {
                                        foreach ($branches->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->bmBranchName; ?>
                                                    <input type="hidden" value="<?php echo $row->bmBranchID; ?>" />
                                                </td>
                                                <td class="second"><?php echo $row->bmBranchCode; ?></td>
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
                        <button type="submit" class="btn btn-primary pull-left" id="branchSelect" >
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
        $('#storeResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>