<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author ajith
 * @date 9 Mar, 2015
 */
?>
<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Task
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#task/list_view"><i class="fa fa-laptop"></i> Tasks</a></li>
        <li class="active"><?php echo $edit_mode ? "Edit" : "Add"; ?> Task</li>
    </ol>
</section>


<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Task</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit" action="task/add">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Task
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="dmCode" class="required form-control" name="task_name" value="<?php echo @$form_data['task_name']; ?>" />
                                        <?php echo @$error['task_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Task Description
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea  class="form-control" name="task_desc" ><?php echo @$form_data['task_desc']; ?></textarea>
                                        <?php echo @$error['task_desc']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Priority
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="priority" class="required form-control" name="priority" value="<?php echo @$form_data['priority']; ?>" />
                                        <?php echo @$error['task_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="task_id" Value="<?php echo @$form_data['task_id']; ?>"/>
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


