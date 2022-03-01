<?php
/**
 * @author ajith
 * @date 6 Feb, 2015
 */
?>
<section class="content-header">
    <h1>
        Edit User Role
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#privilege/list_users"><i class="fa fa-laptop"></i> Users</a></li>
        <li class="active">Edit User Role</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?>User Role</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit" action="privilege/<?php echo $edit_mode ? "edit_user_role/" . $form_data['umId'] : "add_user_role"; ?>">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        User Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required form-control" name="umUserName" value="<?php echo @$form_data['umUserName']; ?>" />
                                        <?php echo @$error['umUserName']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Access Level
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="role_id" class="form-control">
                                            <?php echo $role; ?>
                                        </select>
                                        <?php echo @$error['role_id']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"   Value="Save"/>
                                        <input type="reset" class="btn btn-warning"  Value="Reset"/>
                                        <input type="hidden"  name="umId" Value="<?php echo @$form_data['umId']; ?>"/>
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

