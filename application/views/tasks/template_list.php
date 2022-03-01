<section class="content-header">
    <h1>
        Task
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Task</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Tasks</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <?php if (has_privilege('task', 'add')) { ?><a href="#task/add"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Task</i></button></a><?php } ?>
                    </div>
                </div><!-- /.box-header -->
                <div class="row">
                    <div class="col-xs-12">
                        <form action="task/template_list"  class="ajax-submit" method="POST" >
                            <div class="col-xs-2">
                                <label>Level</label>
                                <select class="form-control" name="task_level">
                                    <?php echo $levels; ?>
                                </select>
                            </div>

                            <div class="col-xs-2">
                                <label>Difficulty</label>
                                <select class="form-control" name="difficulty_level">
                                    <?php echo $difficulty_levels; ?>
                                </select>
                            </div>

                            <div class="col-xs-2">
                                <label>&nbsp;<br/></label>
                                <br/>
                                <input type="submit" value="Filter" class="btn btn-primary"  />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">

                    <table id="tasks" class="table table-bordered table-striped table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <!-- <th>
                                    Serial No
                                </th> -->
                                <th>
                                    Template Name
                                </th>
                                <th>
                                    Level
                                </th>                               
                                <th>
                                    Difficulty
                                </th>  
                                <!-- <th>
                                    Assigned By
                                </th>
                                <th>
                                    Assigned To
                                </th>                               
                                <th>
                                    Status
                                </th>                               
                                <th>
                                    Percentage
                                </th>                                -->
                                <th>
                                    Action
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
                            <button class="btn btn-primary" data-dismiss="modal">Ok</button>
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
                <button type="button" class="btn btn-danger" data-dismiss="modal"  >
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-primary pull-left" id="assign-users" >
                    <i class="fa fa-check"></i> Ok
                </button>
                <input type="hidden" id="task_id"  />
                <input type="hidden" id="group_ref" />
            </div>
        </div>
    </div>  
</div>
<script type="text/javascript">

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
            "url": base_url + "task/json_users",
        },
        "drawCallback": function (settings) {
            $(selected_users).each(function (i, rec) {
                $('#users .user[value="' + rec + '"]').prop('checked', true);
            });
        }
    });

    var tasks = $('#tasks').dataTable({
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bAutoWidth": true,
        "serverSide": true,
        "stateSave": true,
        "aoColumns": [
            {mData: 'template_name'},
            {mData: 'name'},
            {mData: 'difficulty_level'},
            // {mData: 'assigned_by', 'sortable': false},
            // {mData: 'assigned_to', 'sortable': false},
            // {mData: 'status'},
            // {mData: 'perc_of_completion'},
            {mData: 'action', 'sortable': false},
        ],
        "ajax": {
            "url": base_url + "task/json_task_templates",
        }
    });

    $('#task_details').on('hidden.bs.modal', function () {
        tasks._fnAjaxUpdate();
    });
    $('.assign_task').on('hidden.bs.modal', function () {
        tasks._fnAjaxUpdate();
    });
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
</script>
