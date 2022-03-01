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
                        <a href="#task/add"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Task</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="tasks" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Task Name
                                </th>
                                <th>
                                    Task Description
                                </th>
                                <th>
                                    Assign Task 
                                </th>
                                <th>
                                    Edit
                                </th>
                                <th>
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($table_data) && is_array($table_data)) {
                                foreach ($table_data as $row) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['task_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['task_desc']; ?>
                                        </td>
                                        <td>
                                            <input type="hidden" id="task_id" name="task_id" value="<?php echo $row['task_id'];?>"><a href="#" id="assignTask">Assign Task</a></td>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>#task/edit/<?php echo $row['task_id']; ?>">Edit</a>
                                        </td>
                                        <td>
                                            <a  href="<?php echo base_url(); ?>#task/delete/<?php echo $row['task_id']; ?>" onClick="return confirm('Are you want to delete this task?');">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="modal fade in assign_task" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
            </div>  
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('#tasks').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>
