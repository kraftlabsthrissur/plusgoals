<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Project
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_departments"><i class="fa fa-laptop"></i> Department</a></li>
        <li class="active"><?php echo $edit_mode ? "Edit" : "Add"; ?> Department</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Departmemt</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form name="userData" method="post" class="ajax-submit" action="admin/add_department">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Department Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="department_code" class="required form-control" name="department_code" value="<?php echo @$department_details['department_code']; ?>" />
                                        <?php echo @$error['department_code']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Department Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="department_name" class="required form-control" name="department_name" value="<?php echo @$department_details['department_name']; ?>" />
                                        <?php echo @$error['department_name']; ?>

                                    </div>
                                </div>
                            <div class="col-xs-4">
                                <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                <input type="hidden" class="btn btn-warning" name="department_id" Value="<?php echo @$department_details['department_id']; ?>"/>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>                     
            </form>
        </div><!--tablecontent-->
    </div><!--subcontent-->
</div>
</section>

<script type="text/javascript">
</script>



