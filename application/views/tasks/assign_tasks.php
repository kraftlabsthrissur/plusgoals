<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><i class="fa fa-laptop"></i> Assign Tasks</h4>
</div>
<br/>
<div class="row">
    <div class="col-xs-12">
        <div class="list box box-info">
            <div class="items box-body" id="assignUser"> 
                <div class="row">
                    <div class="col-xs-6" > 
                        Select User
                        <select name="selected_user" class="form-control">
                            <option value="">select user</option>
                            <?php echo $users; ?>
                        </select>

                        <input type="hidden" name="task_id" value="<?php echo @$task_id; ?>">
                    </div>
                    <div class="col-xs-6">
                        Date
                        <input type="text" class="form-control datepicker" value="" name="date" id="assigned_task_date" />
                    </div>     
                </div>
            </div>
            <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="close" >
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary pull-left" id="assign_task" >
                    <i class="fa fa-check"></i> Ok
                </button>
            </div>
        </div>
    </div>
</div>
</div>