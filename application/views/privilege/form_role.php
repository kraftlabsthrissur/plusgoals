<?php
/**
 * @author ajith
 * @date 6 Feb, 2015
 */
?>
<section class="content-header">
    <h1>
        Add Role
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_zones"><i class="fa fa-laptop"></i> Role</a></li>
        <li class="active">Add Role</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Role</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit" action="privilege/<?php echo $edit_mode ? "edit_role/" . $form_data['role_id'] : "add_role"; ?>">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Role Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required form-control" name="role_name" value="<?php echo @$form_data['role_name']; ?>" />
                                        <?php echo @$error['role_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Role Description
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea   name="role_description" class="form-control"><?php echo @$form_data['role_description']; ?></textarea>
                                        <?php echo @$error['role_description']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Access Level
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="access_level_id" class="form-control">
                                            <?php echo $access_levels; ?>
                                        </select>
                                        <?php echo @$error['access_level_id']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"   Value="Save"/>
                                        <input type="reset" class="btn btn-warning"  Value="Reset"/>
                                        <input type="hidden"  name="role_id" Value="<?php echo @$form_data['role_id']; ?>"/>
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

