<?php
/**
 * @author ajith
 * @date 27 Mar, 2017
 */
?>
<div class="row">
    <div class="col-lg-1" >
        <!-- <?php if ($assigned_persons) { ?>
            <input type="checkbox" id="is-done" class="form-control" <?php echo isset($assigned_persons[0]['is_done']) && $assigned_persons[0]['is_done'] == 1 ? 'checked="checked"' : ''; ?>>
        <?php } ?> -->
    </div>
    <div class="col-lg-10 no-padding">
        <b><?php echo $task['task_name']; ?></b>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <p style="font-size: 115%;"><?php echo $task['task_desc'] ?></p>
    </div>
</div>

<br/>
<div id ="uploaded_files">View File
    <?php
    $this->load->view('tasks/file_download');
    ?>
</div>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">Priority : <?php echo $task['priority'] ?></div>
        <small><?php echo $task['created_date'] ?></small>
        <p>By:<?php echo $task['umFirstName'] . ' ', $task['umLastName'] ?></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="assigned_persons">
            <?php
            $this->load->view('tasks/assigned_persons');
            ?>
        </div>
        <a class="assign-users">Assign Users</a>
        <input type="hidden" class="task_id" value="<?php echo $task_id; ?>" />
        <input type="hidden" class="group_ref" value="<?php echo $group_ref; ?>" />
    </div>
</div>
<br/>
<div class="comments">
    <?php
    $this->load->view('tasks/task_comment');   
    ?>
</div>          
<br/>
<?php if ($assigned_persons) { ?>
    <div class="row">
        <div class="col-xs-8">
            <!-- <textarea id="comment" rows="3" class="form-control"></textarea> -->
            <textarea  class="cleditor" name = "comment" id="comment"></textarea>
        </div>
    </div>    
    <br/>
    <div class="row">
        <div class="col-xs-6">
            <select class="form-control" id='percentage' name = "percentage">
                <option value="0">Percentage of Completion</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="75">75</option>
                <option value="100">100</option>
            </select>
            <div class="row repeated" <?php echo isset($form_data['percentage']) && $form_data['percentage'] == 1 ? "" : "style='display:none'"; ?> >
                <br/>
                <div class="col-xs-4">
                    No.of Hours
                </div>
                <div class="col-xs-8">
                <input type="text"  id = 'no_of_hours' class="required form-control" name="no_of_hours" />
                <!-- value="<?php echo @$template_names['no_of_hours']; ?>" /> -->
                    <!-- <select class="hours" name="no_of_hours">
                        <option value = "Select" selected>Select</option>
                    </select> -->
                    <?php echo @$error['no_of_hours']; ?>
                </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-xs-4">
                 Upload file
               </div>
               <div class="col-xs-8" >                                           
                  <input type="file"  id='file'  />  
                  <br/>
                    <div id='attachments'>
                  </div>                                                    
               </div> 
            </div>   
            <br/>
            <?php if (has_privilege('task', 'approve_task_completion')) {?>
                <div class="row">
                    <div class="col-xs-4">
                        Rating
                    </div>
                    <div class="col-xs-8" >
                        <select class="form-control" id="rating">
                        <!-- <option >10</option> -->
                            <?php generate_options(array(), 1, 10, "1");?>
                            <?php echo $ratings;?>
                        </select>
                    </div>
                </div>
            <?php }?><br />
            <?php if (has_privilege('task', 'approve_task_completion')) { ?>
                <div class="col-xs-3 no-padding">
                    Approve
                </div>
            <!-- <input type="radio" class="btn btn-primary" id="approve" /> -->
                <input type="radio"  class="required form-control" id="approve" name = "task_approve" value="approve"<?php echo isset($approved) && $approved == 1 ? "checked='checked'" : ""; ?>/>
            <br /><?php } ?>   
            <?php if (has_privilege('task', 'reject_task_completion')) { ?>
                <div class="col-xs-3 no-padding">
                    Reject
                </div>
            <input type="radio"  class="required form-control" id="reject" name = "task_approve" value="reject" <?php echo isset($rejected) && $rejected == 1 ? "checked='checked'" : ""; ?> />
            <?php } ?>
            <input type="hidden" value="<?php echo $group_ref; ?>" class="group-ref" >
            <input type="hidden" value="<?php echo $task_id; ?>" class="task-id" >
            <?php
           // print_r($task_id);
            ?>
            <br />
            <input type="button" style="margin-top: 8px;" class="btn btn-primary" id="submit-comment" value="Submit"/>  
           <!-- <input type="button" style="margin-top: 8px;" class="btn btn-primary" id="approve" value="Approve"/>   -->
           <?php if($comments){
               foreach ($comments as $key => $value) {
                   if($value['approved'] == 1){?>
                <script>$('#submit-comment').hide();</script> 
                <?php } 
                }
            }?>
           <br />
        </div>
    </div>    
    <br/>
<?php } ?>
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
 
        var editor = $("#comment").cleditor(options);
    });

    $(document).ready(function () {
    $("#percentage").change(function () {
        var val = $(this).val();
        if (val == "100") {
            $('.repeated').show();
        } else {
            $('.repeated').hide();
        }
    });
});

    $('body').on('click', '#approve', function () {
        if ($(this).is(":checked")) {
            $('#submit-comment').hide();
        } else {
            $('#submit-comment').show();
        }
    });

    $('body').on("checked", '#approve', function () {
            $('#submit-comment').hide();
    });

    $('body').on('click', '#reject', function () {
        if ($(this).is(":checked")) {
            $('#submit-comment').hide();
        }else {
            $('#submit-comment').show();
        }
    });


</script>


