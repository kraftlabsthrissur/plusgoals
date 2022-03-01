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

                    <form  method="post" class="ajax-submit" id="task-form" enctype="multipart/form-data"  action="task/<?php echo $edit_mode ? "edit/" . $form_data['task_id'] : "add"; ?>">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-4">
                                        Task
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text" id="dmCode" class="required form-control" name="task_name" value="<?php echo @$form_data['task_name']; ?>" />
                                        <?php echo @$error['task_name']; ?>
                                    </div>

                                </div>
                                <br/> 
                               
                              
                                <div class="row">
                                    <div class="col-xs-4">
                                        Task Level
                                    </div>
                                    <div class="col-xs-8">
                                    <select class="form-control" name="task_level">
                                    <?php echo $levels; ?>
                                    </select>
                                        <?php echo @$error['task_level']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Difficulty Level
                                    </div>
                                    <div class="col-xs-8">
                                        <select class="form-control" name="difficulty_level">
                                        <?php echo $difficulty_levels; ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Priority
                                    </div>
                                    <div class="col-xs-8">
                                        <select class="form-control" name="priority">
                                            <?php echo $priorities; ?>
                                        </select>
                                        <?php echo @$error['priority']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                       Start Date
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text"  class="required form-control date" readonly="readonly" name="task_date" value="<?php echo @$form_data['task_date']; ?>" />
                                        <?php echo @$error['task_date']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Due Date
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text"  class="required form-control date" readonly="readonly" name="due_date" value="<?php echo @$form_data['due_date']; ?>" />
                                        <?php echo @$error['due_date']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Repeating Task?
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="checkbox"  class="required form-control" id="is_repeating" name="is_repeating" value="1" <?php echo isset($form_data['is_repeating']) && $form_data['is_repeating'] == 1 ? "checked='checked'" : ""; ?> />
                                        <?php echo @$error['is_repeating']; ?>
                                    </div>
                                </div>

                                <div class="row repeat-criteria" <?php echo isset($form_data['is_repeating']) && $form_data['is_repeating'] == 1 ? "" : "style='display:none'"; ?> >
                                    <br/>
                                    <div class="col-xs-4">
                                        Frequency
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="row" >                                            
                                            <div class="col-xs-3 ">
                                                Daily
                                            </div>
                                            <div class="col-xs-2 no-padding">
                                                <input type="radio"  class="required form-control" name="frequency" value="daily" <?php echo isset($form_data['frequency']) && $form_data['frequency'] == "daily" ? "checked='checked'" : ""; ?> />
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row" >                                            
                                            <div class="col-xs-3">
                                                Weekly
                                            </div>
                                            <div class="col-xs-2  no-padding">
                                                <input type="radio"  class="required form-control" name="frequency" value="weekly" <?php echo isset($form_data['frequency']) && $form_data['frequency'] == "weekly" ? "checked='checked'" : ""; ?> />
                                            </div>
                                            <div class="col-xs-3 no-padding ">
                                                Week Day
                                            </div>
                                            <div class="col-xs-4 ">
                                                <select class="form-control" name="week_day">
                                                    <?php echo $weeks; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row" >                                            
                                            <div class="col-xs-3 ">
                                                Monthly
                                            </div>
                                            <div class="col-xs-2 no-padding">
                                                <input type="radio"  class="required form-control" name="frequency" value="monthly" <?php echo isset($form_data['frequency']) && $form_data['frequency'] == "monthly" ? "checked='checked'" : ""; ?> />
                                            </div>
                                            <div class="col-xs-3 no-padding ">
                                                Day
                                            </div>
                                            <div class="col-xs-4 ">
                                                <select class="form-control" name="day">
                                                    <?php echo $days; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php echo @$error['frequency']; ?>
                                    </div>
                                </div>

                                <div class="row repeat-criteria" <?php echo isset($form_data['is_repeating']) && $form_data['is_repeating'] == 1 ? "" : "style='display:none'"; ?> >
                                    <br/>
                                    <div class="col-xs-4">
                                        Repeat upto
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text"  class="required form-control date" readonly="readonly" id="repeat_upto" name="repeat_upto" value="<?php echo @$form_data['repeat_upto']; ?>" />
                                        <?php echo @$error['repeat_upto']; ?>
                                    </div>
                                </div>

                                <div class="row repeat-criteria" <?php echo isset($form_data['is_repeating']) && $form_data['is_repeating'] == 1 ? "" : "style='display:none'"; ?> >
                                    <br/>
                                    <div class="col-xs-4">
                                        Time Limit in Days
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="number"  class="required form-control"  name="time_limit" value="<?php echo isset($form_data['time_limit']) ? $form_data['time_limit'] : 1; ?>" />
                                        <?php echo @$error['time_limit']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                        Chargeable
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="checkbox"  class="required form-control" id="chargeble" name="chargeble" value="1" <?php echo isset($form_data['chargeble']) && $form_data['chargeble'] == 1 ? "checked='checked'" : ""; ?> />
                                        <?php echo @$error['chargeble']; ?> 
                                    </div>
                                </div>
                                <div class="row repeat" <?php echo isset($form_data['chargeble']) && $form_data['chargeble'] == 1 ? "" : "style='display:none'"; ?> >
                                    <br/>
                                    <div class="col-xs-4">
                                        Estimated Cost
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text"  id = 'estimate_cost' class="required form-control" name="estimate_cost" id='estimate_cost' value="" <?php echo isset($form_data['estimate_cost']) && $form_data['estimate_cost']; ?> />
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">
                                          Assign
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="row" >     
                                            <div class="col-xs-4">
                                                <input type="button" class="btn btn-default select-users" value="Select Users"/>
                                            </div>                                           
                                            <div class="col-xs-2  no-padding">
                                                <input type="checkbox"  class="required form-control" name="is_group_task" value="1" <?php echo isset($form_data['is_group_task']) && $form_data['is_group_task'] == "1" ? "checked='checked'" : ""; ?> />
                                            </div>
                                            <div class="col-xs-5">
                                                Group Task
                                            </div>
                                            <br/>
                                        </div>
                                        <div id="assigned-users">
                                            <?php
                                                if (@$assigned_persons) {
                                                    foreach ($assigned_persons as $key => $value) { 
                                                      //print_r($assigned_persons);
                                                    ?>
                                                        <div class='assign_users row'> 
                                                            <p class='pull-left'><?php echo $value['umFirstName'] ?></p>
                                                            <!-- <input type='hidden' name='users[]' value="<?php echo $value['umId'] ?>"> -->
                                                            <input type='hidden' name='users[]' value="<?php echo $value['assigned_user_id'] ?>">
                                                            <input type='hidden' name='user_name[]' value="<?php echo $value['umFirstName'] ?>">
                                                            <span class='pull-right'><a  class='remove-item'>X</a></span>
                                                        </div>
                                                    <?php  
                                                    }
                                                }    
                                            ?>
                                            
                                            <?php echo @$error['number-of-assigned-persons']; ?> 
                                        </div>
                                        <input type='hidden' id="number-of-assigned-persons" value="<?php echo isset($assigned_persons)? sizeof($assigned_persons):0; ?>"/>
                                    </div>
                                </div>
                                <br/>                                                       
                                <div class="row">
                                    <div class="col-xs-4">
                                        Upload file
                                        
                                    </div>
                                    <div class="col-xs-8">                                
                                            <input type="file"  id='file' />  <br/>
                                           <!-- <input type="submit"  name="submit" value='Upload' />  -->
                                            <div id='attachments'>
                                                <?php
                                               if (@$files) {
                                                foreach ($files as $key => $value) { 
                                                      ?>
                                                     <div class='attachment row'> 
                                                     <p class='pull-left'><?php echo $value['file_name'] ?></p>
                                                     <input type = "hidden" name = 'attachment_id[]' value="<?php echo $value['file_id'] ?>"/> 
                                                     <span class='pull-right'><a  class='remove-item'>X</a></span></div>
                                                      <?php  
                                                      }
                                                    }    
                                                 ?>
                                                 <?php echo @$error['file']; ?>
                                            </div>              
                                       
                                   </div>
                                </div>    
                                <br/> 
                                <div class="row">
                                    <div class="col-xs-4">
                                        Save As Template
                                    </div>
                                    <div class="col-xs-8" >     
                                            <input type="checkbox"  class="required form-control" id="save_template" name="save_template" value="1" <?php echo isset($form_data['save_template']) && $form_data['save_template'] == "1" ? "checked='checked'" : ""; ?> />                 
                                            <?php echo @$error['save_template']; ?>                                        
                                    </div>
                                </div>
                                <div class="row repeated" <?php echo isset($form_data['save_template']) && $form_data['save_template'] == 1 ? "" : "style='display:none'"; ?> >
                                    <br/>
                                    <div class="col-xs-4">
                                       Template Name
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text"  id = 'template_name' class="required form-control" name="template_name" value="<?php echo @$template_names['template_name']; ?>" />
                                    </div>
                                </div>
                                <br/> 
                                <div class="row">
                                    <div class="col-xs-4">
                                        Select Project
                                    </div>
                                    <div class="col-xs-8">
                                        <select class="form-control" name="project">
                                         <option value = "select" selected>Select</option>
                                        <?php echo $projects; ?>
                                        </select>
                                        <?php echo @$error['project']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-4">

                                    </div>
                                    <div class="col-xs-8">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" id = "task" name="task_id" Value="<?php echo @$form_data['task_id']; ?>"/>
                                        <input type="hidden" class="btn btn-warning" name="project_id" Value="<?php echo @$form_data['project_id']; ?>"/>
                                        <input type="hidden" class="btn btn-warning" id = "clone_task" name="clone_task_id" Value="<?php echo @$clone_task_id; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div  class='col-xs-6'>
                            <div class="col-xs-4">
                                        Task Description
                                    </div>
                            <div class="row">
                                    <div class="col-xs-8">
                                    <br/>
                                        <textarea  class="cleditor" name="task_desc" id="task_desc"><?php echo @$form_data['task_desc']; ?></textarea>
                                        <?php echo @$error['task_desc']; ?>
                                    </div>
                              </div>  
                            </div>
                        </div>                   
                    </form>
                </div><!--tablecontent-->
            </div><!--subcontent-->
            <div class="modal fade in assign_task" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title"><i class="fa fa-laptop"></i> Assign Tasks</h4>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="col-xs-12" id="assignUser"> 
                                    <table  id = "users" class="table  table-bordered table-striped table-hover" >
                                        <thead>
                                            <tr>
                                                <th >
                                                    Select
                                                </th>                               
                                                <th >
                                                    User Name
                                                </th>                               
                                                <th >
                                                    Email id
                                                </th>
                                                <th >
                                                    City
                                                </th>

                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"  >
                                <i class="fa fa-times"></i> Cancel
                            </button>
                            <button type="button" class="btn btn-primary pull-Right" id="assign-users" >
                                <i class="fa fa-check"></i> Ok
                            </button>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
</section>
<link href="<?php echo base_url();?>assets/css/jquery.cleditor.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/plugins/jquery.cleditor.js" type="text/javascript"></script>
<script type="text/javascript">
 
    $(document).ready(function () {
        var options = {
            width: 500,
            height: 260,
            controls: "bold italic underline strikethrough subscript superscript | font size " +
                    "style | color highlight removeformat | bullets numbering | outdent " +
                    "indent | alignleft center alignright justify | undo redo | " +
                    "rule link image unlink | cut copy paste pastetext | print source"
            }
 
        var editor = $("#task_desc").cleditor(options);
    });

    $(".date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    $('body').on('click', '#is_repeating', function () {
        if ($(this).is(":checked")) {
            $('.repeat-criteria').show();
        } else {
            $('.repeat-criteria').hide();
        }
    });
    $('body').on('click', '#chargeble', function () {
        if ($(this).is(":checked")) {
            $('.repeat').show();
        } else {
            $('.repeat').hide();
        }
    });
    $('body').on('click', '#save_template', function () {
        if ($(this).is(":checked")) {
            $('.repeated').show();
        } else {
            $('.repeated').hide();
        }
    });
    $('body').on('click', '#select_project', function () {
        if ($(this).is(":checked")) {
            $('.row-repeat').show();
        } else {
            $('.row-repeat').hide();
        }
    });
    $('body').on('click', '.select-users', function () {
        $('.assign_task').modal();
    });
    $(function () {
        var task = $('#task').val();
        //alert(task);
        $('#users').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "serverSide": true,
            "stateSave": true,
            "aoColumns": [
                {mData: 'select'},
                {mData: 'userFullName'},
                {mData: 'umEmail'},
                {mData: 'umCity'},
            ],
            "ajax": {
                "url": base_url + "task/json_users/",
                // "data": {task:task},
            }
        });
    });
</script>

