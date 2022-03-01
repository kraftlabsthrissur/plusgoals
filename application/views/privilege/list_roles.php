<?php
/**
 * @author ajith
 * @date 6 Feb, 2015
 */
?>
<section class="content-header">
    <h1>
        Role
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Role</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Roles</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#privilege/add_role">
                            <button class="btn btn-primary" >
                                <i class="fa fa-pencil"> Add New Role</i>
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
                                    Role Name
                                </th>
                                <th>
                                    Description
                                </th>
                                <!-- <th>
                                    Access Level
                                </th> -->
                                <th>
                                    Edit role privileges
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
                                        <td><?php echo $row['role_name']; ?></td>
                                        <td><?php echo $row['role_description']; ?></td>
                                        <!-- <td><?php echo $row['access_level_name']; ?></td> -->
                                        <td>
                                            <a href="<?php echo  base_url() . '#privilege/edit_default_role_privilege/' . $row['role_id']; ?>">Edit role privileges</a>
                                        </td>
                                        <td><a href="<?php echo  base_url() . '#privilege/edit_role/' . $row['role_id']; ?>">Edit</a></td>
                                        <td><a href="<?php echo  base_url() . '#privilege/delete_role/' . $row['role_id']; ?>" onClick="return confirm('Are you want to delete this role?');">Delete</a></td>
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
