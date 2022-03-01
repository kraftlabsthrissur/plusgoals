
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/divisionmaster.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/Masters.css"/>
<script type="text/javascript">

</script>
<section class="content-header">
    <h1>
        Add Division
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_divisions"><i class="fa fa-laptop"></i> Division</a></li>
        <li class="active">Add Division</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Division</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form name="userData" method="post" class="ajax-submit" action="admin/add_division">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Division Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="dmCode" class="required form-control" name="dmCode" value="<?php echo @$division_details['dmCode']; ?>" />
                                        <?php echo @$error['dmCode']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Division Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmDivisionName" class="form-control" value="<?php echo @$division_details['dmDivisionName']; ?>"/>
                                        <?php echo @$error['dmDivisionName']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Description
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="dmDescription" class="required form-control" cols="20" rows="2" ><?php echo @$division_details['dmDescription']; ?></textarea>
                                        <?php echo @$error['dmDescription']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Is Active
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="checkbox" name="dmIsActive"  value="1" <?php echo isset($division_details['dmIsActive']) ? (($division_details['dmIsActive'] === "1") ? 'checked' : '' ) : 'checked'; ?> />
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="dmId" Value="<?php echo @$division_details['dmId']; ?>"/>
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