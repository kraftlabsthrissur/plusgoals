<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Task Activity Report</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="row">
                    <div class="col-xs-12">
                        <form action="taskdailyreport/task_report"  class="ajax-submit" method="POST" >
                            <div class="col-xs-2">
                                <label>From Date</label>
                                <input type="text" name="from_date" readonly="readonly" class="datepicker from_date form-control" value="<?php echo isset($from_date) ? $from_date : ''; ?>" />
                            </div>
                            <div class="col-xs-2">
                                <label>To Date</label>
                                <input type="text" name="to_date" readonly="readonly" class="datepicker from_date form-control" value="<?php echo isset($to_date) ? $to_date : ''; ?>" />
                            </div>     
                            <div class="col-xs-2">
                                <label>Select User</label>
                                <select name="user_id" class="form-control">
                                    <option value="">select user</option>
                                        <?php echo $users; ?>
                                </select>
                            </div>                  
                            <div class="col-xs-2">
                                <label>&nbsp;<br/></label>
                                <br/>
                                <input type="submit" value="Submit" class="btn btn-primary"  />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">

                    <table id="tasks" class="table table-bordered table-striped table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th>
                                    Sl.No
                                </th>

                                <th>
                                    Task
                                </th>
                                <th >
                                   Due Date
                                </th>
                                <th>
                                    Updated On
                                </th>
                                <th>
                                    Assigned By
                                </th>
                                 <th>
                                   Assigned To
                                </th>
                                <th style="width: 150px;">
                                    Comments
                                </th>
                                <th>
                                    % Completion
                                </th>                               
                                <th>
                                    Status
                                </th> 
                                <th>
                                    Approved/Rejected
                                </th> 
                                <th>
                                    Approved By
                                </th>
                                <th>
                                    Rejected By
                                </th> 
                                <th>
                                    Actions
                                </th>                            
                            </tr>
                        </thead>
                        <tbody>   
                        </tbody>
                    </table>
                </div>          
            </div>

            <div class="modal fade in " id="task_details" tabindex="-1" role="dialog" aria-hidden="false" >
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title"><i class="fa fa-laptop"></i> Task Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 ">
                                <br/>
                                <div class="col-xs-12  details"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id = "comment-submit" data-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade in assign_task" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Assign Tasks</h4>
            </div>
            <br />
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-12" id="assignUser">
                        <table id="users" class="table  table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        Select
                                    </th>
                                    <th>
                                        User Name
                                    </th>
                                    <th>
                                        Email id
                                    </th>
                                    <th>
                                        City
                                    </th>

                                </tr>
                            </thead>

                        </table>
                    </div>


                </div>
            </div>
        <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary pull-left" id="assign-users">
                    <i class="fa fa-check"></i> Ok
                </button>
                <input type="hidden" id="task_id" /> 
                <input type="hidden" id="group_ref" />
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    // $('#users').dataTable({
    //     "bInfo": true,
    //     "bPaginate": true,
    //     "bLengthChange": true,
    //     "bFilter": true,
    //     "bSort": true,
    //     "bAutoWidth": true,
    //     "serverSide": true,
    //     "stateSave": true,
    //     "aoColumns": [
    //         {mData: 'select'},
    //         {mData: 'userFullName'},
    //         {mData: 'umEmail'},
    //         {mData: 'umCity'},
    //     ],
    //     "ajax": {
    //         "url": base_url + "task_daily__report/json_users",
    //     },
    //     "drawCallback": function (settings) {
    //         $(selected_users).each(function (i, rec) {
    //             $('#users .user[value="' + rec + '"]').prop('checked', true);
    //         });
    //     }
    // });

    var tasks = $('#tasks').dataTable({
        "bInfo": true,
        "bPaginate": true,
        "searching": false,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bAutoWidth": true,
        "serverSide": true,
        "stateSave": true,
        "sScrollX": "100%",
        "sScrollXInner": "110%",
        "aoColumns": [   
            {mData: null,"render":function(data,type,full,meta){
                return meta.row + 1;
            }},
            {mData: 'task_name'},
            {mData: 'due_date'},
            {mData:  'date'},
            {mData: 'assigned_by'},
            {mData: 'assigned_to'},
            {mData: 'comment'},
            {mData: 'perc_of_completion'},
            {mData: 'status'},
            {mData: 'approved_status'},
            {mData: 'approved_by'},
            {mData: 'rejected_by'},
            {mData: 'action', 
            'visible' :true,
            className:"hidden"},
        ],
        "ajax": {
            "url": base_url + "taskdailyreport/json_taskreport",
        }
    });

   $('#task_details').on('hidden.bs.modal', function () {
    tasks._fnAjaxUpdate();
    });
    // $('.assign_task').on('hidden.bs.modal', function () {
    //     tasks._fnAjaxUpdate();
    // });

    //  $('body').on('click', '#comment-submit', function () {
    //      location.reload();
    //    });

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
</script>




