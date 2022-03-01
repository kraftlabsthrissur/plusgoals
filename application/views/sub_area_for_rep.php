<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/subarea.css"/>
<section class="content-header">
    <h1>
        Sub Area for Representative Master
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_sub_area"><i class="fa fa-laptop"></i> Sub Area</a></li>
        <li class="active">Sub Area for Representative Master</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Add Subarea</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form name="SubArea" class="ajax-submit" action="admin/add_sub_area" method="post">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Sub-Area name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" class="form-control" name="saSubAreaName" value="<?php echo @$sub_area_details['saSubAreaName']; ?>"/>
                                    </div>
                                    <div class="col-xs-6">
                                         <?php echo @$error['saSubAreaName']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Is Active
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="checkbox" name="saIsActive" <?php echo isset($sub_area_details['isActive']) && $sub_area_details['isActive'] == 1  ? 'checked' : ''; ?> value="1"/>
                                    </div>
                                    <div class="col-xs-6">
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" id="btnSave" class="btn btn-primary" Value="Save"/>
                                        <input type="reset" id="btnReset" class="btn btn-primary" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="saId" Value="<?php echo @$sub_area_details['saId']; ?>"/>
                                    </div>
                                    <div class="col-xs-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--subarea-->
        </div><!--subcontent-->
    </div><!--span10-->
</section>