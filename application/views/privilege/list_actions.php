<?php
/**
 * @author ajith
 * @date 6 Feb, 2015
 */
?>
<section class="content-header">
    <h1>
        Actions
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Actions</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Actions</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#">
                            <button class="btn btn-primary" >
                                <i class="fa fa-pencil"> Refresh Actions</i>
                            </button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="roles" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Class Name
                                </th>
                                <th>
                                    Method Name
                                </th>
                                <th>
                                    Action Name
                                </th>
                                <th>
                                    Description
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
                            if ($table_data) {
                                foreach ($table_data as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['class_name']; ?></td>
                                        <td><?php echo $row['method_name']; ?></td>
                                        <td><?php echo $row['action_name']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><a href="<?php echo  base_url() . '#privilege/edit_action/' . $row['action_id']; ?>">Edit</a></td>
                                        <td><a href="<?php echo  base_url() . '#privilege/delete_action/' . $row['action_id']; ?>" onClick="return confirm('Are you want to delete this Action?');">Delete</a></td>
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
        $('#roles').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>
