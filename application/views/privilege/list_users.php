<section class="content-header">
    <h1>
        Users
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Users</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#admin/create_user"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Create New User</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table  id = "users" class="table  table-bordered table-striped table-hover" >
                        <thead>
                            <tr>
                                <th width=115>
                                    User Code
                                </th>
                                <th width=100>
                                    Name
                                </th>
                                <th  width=100>
                                    User Name
                                </th>
                                <th  width=100>
                                    City
                                </th>
                                <th  width=100>
                                    Email id
                                </th>
                                <th  width=40>
                                    Role
                                </th>
                                <th  width=40>
                                    Password
                                </th>
                                <th  width=40>
                                    Edit Role
                                </th>
                                <th width=40>
                                    Edit Privilege
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($table_data) {
                                foreach ($table_data as $row) {
                                    ?>
                                    <tr>
                                        <td width=115>
                                            <?php echo $row['umUserCode']; ?>
                                        </td>
                                        <td class="test">
                                            <?php echo $row['umFirstName'] . ' ' . $row['umLastName']; ?>
                                        </td>
                                        <td width=100>
                                            <?php echo $row['umUserName']; ?>
                                        </td>
                                        <td width=100>
                                            <?php echo $row['umCity']; ?>

                                        </td>
                                        <td width=40>
                                            <?php echo $row['umEmail']; ?>
                                        </td>
                                        <td width=40>
                                            <?php echo $row['role_name']; ?>
                                        </td>
                                        <td width=40>
                                            <a class="show-password">Show</a>
                                            <span class="hidden password"><?php echo $row['umPassword']; ?><br/></span>
                                             <a class="hidden hide-password">Hide</a>
                                        </td>
                                        <td width=40>
                                            <a href="<?php echo base_url(); ?>#privilege/edit_user_role/<?php echo $row['umId']; ?>">Edit Role</a>
                                        </td>
                                        <td width=40>
                                            <a id="<?php echo $row['umId']; ?>" href="<?php echo base_url(); ?>#privilege/edit_user_privileges/<?php echo $row['umId']; ?>" >Edit User Privilege</a>
                                        </td>
                                    </tr>
                                    <input type='hidden' id="user_Id" name='user_id' value="<?php echo $row['umId'] ?>"/>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div><!--tablecontent-->
        </div><!--maincontent-->
    </div>
</section>



<script type="text/javascript">
    $(function () {
        $('#users').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
    $('body').on('click','.show-password', function(){        
        $(this).addClass('hidden');
        $(this).next('.password').removeClass('hidden').next('.hide-password').removeClass('hidden');
    });
    $('body').on('click','.hide-password', function(){        
        $(this).addClass('hidden');
        $(this).prev('.password').addClass('hidden').prev('.show-password').removeClass('hidden');
    });
</script>

