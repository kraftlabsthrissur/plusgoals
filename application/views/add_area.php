
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/areamaster.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/Masters.css"/>
<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Area
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_areas"><i class="fa fa-laptop"></i> Area</a></li>
        <li class="active"><?php echo $edit_mode ? "Edit" : "Add"; ?> Area</li>
    </ol>
</section>


<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Area</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form name="userData" method="post" class="ajax-submit" action="admin/add_area">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Area Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="dmCode" class="required form-control" name="amCode" value="<?php echo @$area_details['amCode']; ?>" />
                                        <?php echo @$error['amCode']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Area Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="amAreaName" class="form-control" value="<?php echo @$area_details['amAreaName']; ?>"/>
                                        <?php echo @$error['amAreaName']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="amId" Value="<?php echo @$area_details['amId']; ?>"/>
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
