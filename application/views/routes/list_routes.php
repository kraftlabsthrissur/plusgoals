<section class="content-header">
    <h1>
        Routes
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Routes</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Routes</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#routes/add_routes"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Route</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="routes" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="code">
                                    Route ID
                                </th>
                                <th class="name">
                                    Route Name
                                </th>
                                <th class="name">
                                    Headquarters Name
                                </th>
                                <th class="assigned_user">
                                    Assigned User-for today
                                </th>
                                <th class="assign">
                                    Assign Route
                                </th>
                                <th class="edit">
                                    Edit
                                </th>
                                <th class="delete">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($table_data) {
                                foreach ($table_data as $row =>$value) {
                                   
                                    ?>
                                    <tr>
                                        <td><?php echo $value['route_id']; ?></td>
                                        <td><?php echo $value['route_name']; ?></td>
                                        <td><?php echo $value['headquartersName']; ?></td>
                                        <td>
                                        <?php if ($assigned_user) {
                                         foreach ($assigned_user as $r) {  
                                             if($value['route_id']== $r['route_id']) { 
                                              echo @$r['umUserName']; 
                                             }
                                         }
                                             } ?>
                                        </td>
                                        <td><input type="hidden" class="route_id" value="<?php echo $value['route_id']; ?>" ><button type="button" class="btn btn-info btn-flat assign_route" >Assign Routes</button></td>
                                        <td><a href="<?php echo base_url() . '#routes/edit_routes/' . $value['route_id']; ?>">Edit</a></td>
                                        <td><a href="<?php echo base_url() . '#routes/delete_route/' . $value['route_id']; ?>" onClick="return confirm('Are you want to delete this role?');">Delete</a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade in" id="assignroutes" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
            </div>  

        </div>
    </div>
</section>



<script type="text/javascript">
    $(function () {
        $('#routes').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true
        });
        

    });
    
</script>
