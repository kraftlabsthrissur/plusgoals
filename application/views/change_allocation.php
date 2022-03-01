<?php
/**
 * @author ajith
 * @date 6 Feb, 2015
 */
?>
<section class="content-header">
    <h1>
        Allocation
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#admin/allocation"><i class="fa fa-laptop"></i> Allocation</a></li>
        <li class="active">Change Allocation</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Change Allocation</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit" action="admin/change_allocation/<?php echo $form_data['smId']; ?>" >
                        <div class="row">
                            <div class="col-xs-10">

                                <div class="row">
                                    <div class="col-xs-2">
                                        Store Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required  form-control" readonly  value="<?php echo @$form_data['smStoreCode']; ?>" />
                                    </div>
                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">
                                        Store Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required  form-control" readonly  value="<?php echo @$form_data['smStoreName']; ?>" />
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">
                                        Type
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required  form-control" readonly value="<?php echo @$form_data['customer_group']; ?>" />
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">
                                        Rep Name
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="rep_name" id="rep_name" readonly value="<?php echo @$form_data['rep_name']; ?>" />

                                            <span class="input-group-btn">
                                                <button id="viewRep" class="btn btn-info btn-flat" type="button"> Representatives</button>
                                            </span>
                                        </div>


                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">
                                        Branch Name
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="smCity" id="smCity" readonly value="<?php echo @$form_data['smCity']; ?>" />

                                            <span class="input-group-btn">
                                                <button id="viewBranch" class="btn btn-info btn-flat" type="button"> Branches</button>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"   Value="Save"/>
                                        <input type="hidden"  name="smId" Value="<?php echo @$form_data['smId']; ?>"/>
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
                                    if ($branches) {
                                        foreach ($branches as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row['bmBranchName']; ?>

                                                </td>
                                                <td class="second"><?php echo $row['bmBranchCode']; ?></td>
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

<div class="modal fade in" id="repMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Representatives</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="repList"> 
                            <table  id="repResult" class="table  table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <td>Rep Name</td>

                                        <td>Rep Code</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($rep > 0) {
                                        foreach ($rep as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row['umFirstName'] . ' ' . $row['umLastName']; ?>

                                                </td>
                                                <td class="second"><?php echo $row['umUserCode']; ?></td>
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

<script>
    $("#viewBranch").click(function () {
        $("#branchMaster").slideDown(500);
    });
    $("#viewRep").click(function () {
        $("#repMaster").slideDown(500);
    });
    $('#right-content').on('click', '.modal .close, .modal .close-btn', function () {
        $('.modal').slideUp(800);
    });
    $("#branchResult").dataTable({
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bAutoWidth": true,
    });
    $("#repResult").dataTable({
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bAutoWidth": true,
    });


    $("body").on('click', '#branchList tr,#repList tr', function () {
        $("#branchList tr").removeClass("selected");
        $(this).addClass("selected");
    });


    $("body").on('dblclick', '#branchList tr', function () {

        $("#smCity").val($(this).find('td.first').text().trim().replace('BRANCH', ''));

        $("#branchMaster").slideUp(500);
    });
    $("body").on('dblclick', '#repList tr', function () {
        $("#rep_name").val($(this).find('td.first').text().trim());

        $("#repMaster").slideUp(500);
    });

</script>

