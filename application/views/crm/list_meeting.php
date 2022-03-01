<section class="content-header">
    <h1>
        Meeting
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Meeting</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Meetings</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#meeting/add"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Meeting</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="meetings" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Meeting Name
                                </th>
                                <th>
                                    Meeting Description
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
                                            <?php echo $row['meeting_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['meeting_name']; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>#meeting/edit/<?php echo $row['meeting_id']; ?>">Edit</a>
                                        </td>
                                        <td>
                                            <a  href="<?php echo base_url(); ?>#meeting/delete/<?php echo $row['meeting_id']; ?>" onClick="return confirm('Are you want to delete this meeting?');">Delete</a>
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

        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('#meetings').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>
