<?php
/**
 * @author ajith
 * @date 6 Feb, 2015
 */
?>
<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Actions
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_zones"><i class="fa fa-laptop"></i> Actions</a></li>
        <li class="active"><?php echo $edit_mode ? "Edit" : "Add"; ?> Action</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Action</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit" action="privilege/<?php echo $edit_mode ? "edit_action/".$form_data['action_id'] : "add_action"; ?>">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Action Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required form-control" name="action_name" value="<?php echo @$form_data['action_name']; ?>" />
                                        <?php echo @$error['role_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        File Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required form-control" <?php echo $edit_mode ? "disabled" : ""; ?> name="file_name" value="<?php echo @$form_data['file_name']; ?>" />
                                        <?php echo @$error['file_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Class Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required form-control" <?php echo $edit_mode ? "disabled" : ""; ?> name="class_name" value="<?php echo @$form_data['class_name']; ?>" />
                                        <?php echo @$error['class_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Method Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required form-control" <?php echo $edit_mode ? "disabled" : ""; ?> name="method_name" value="<?php echo @$form_data['method_name']; ?>" />
                                        <?php echo @$error['method_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Description
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea   name="description" class="form-control"><?php echo @$form_data['description']; ?></textarea>
                                        <?php echo @$error['description']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"   Value="Save"/>
                                        <input type="reset" class="btn btn-warning"  Value="Reset"/>
                                        <input type="hidden"  name="action_id" Value="<?php echo @$form_data['action_id']; ?>"/>
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

