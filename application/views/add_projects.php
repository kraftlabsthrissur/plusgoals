<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Project
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_projects"><i class="fa fa-laptop"></i> Projects</a></li>
        <li class="active"><?php echo $edit_mode ? "Edit" : "Add"; ?> Projects</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Project</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form name="userData" method="post" class="ajax-submit" action="admin/add_project">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Project Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="project_code" class="required form-control" name="project_code" value="<?php echo @$project_details['project_code']; ?>" />
                                        <?php echo @$error['project_code']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                       Project Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="project_name" class="required form-control" name="project_name" value="<?php echo @$project_details['project_name']; ?>" />
                                        <?php echo @$error['project_name']; ?>

                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                <div class="col-xs-2">
                                    Customer Name
                                </div>
                                    <div class="col-xs-4">
                                    <select class="form-control" name="customer_id">
                                    <option value = "select" selected>Select</option>
                                        <?php echo $customer_details; ?>
                                    </select>                                           
                                    <?php echo @$error['customer_id']; ?>
                                </div>
                                    <div class="col-xs-2">
                                        Budget
                                    </div>
                                    <div class="col-xs-4">    
                                        <input type="text" id="budget" class="required form-control" name="budget" value="<?php echo @$project_details['budget']; ?>" />
                                        <?php echo @$error['budget']; ?>
                                    </div>
                                </div>    
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Assign
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="row" >
                                            <div class="col-xs-2">     
                                                <input type="button" class="btn btn-default select-users" value="Select Users"/>
                                            </div>                                           
                                            <br/>
                                        </div>    
                                        <div id="assigned-users">
                                            <?php
                                                if (@$assigned_persons) {
                                                    foreach ($assigned_persons as $key => $value) { 
                                                    ?>
                                                    <div class='assign_users_for_projects row'> 
                                                        <p class='pull-left'><?php echo $value['umFirstName'] ?></p>
                                                            <input type='hidden' name='users[]' value="<?php echo $value['assigned_user_id'] ?>">
                                                            <span class='pull-right'><a  class='remove-item'>X</a></span>
                                                    </div>
                                                    <?php  
                                                    }
                                                }    
                                            ?>                                            
                                            <?php echo @$error['number-of-assigned-persons']; ?> 
                                        </div>
                                        <input type='hidden' id="number-of-assigned-persons" name='number-of-assigned-persons' value="<?php echo isset($assigned_persons)? sizeof($assigned_persons):0; ?>"/>
                                    </div>
                                    <!-- <br/>   -->
                                    <div class="col-xs-2">
                                        Department Name
                                    </div>
                                    <div class="col-xs-4">    
                                        <select class="form-control" name="department_id">
                                        <option value = "select" selected>Select</option>
                                            <?php echo $department_details; ?>
                                        </select>                                           
                                            <?php echo @$error['department_id']; ?>
                                    </div>                                 
                                </div>
                            </div>                                                             
                            <br/>
                            <div class="col-xs-4">
                                <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                <input type="hidden" class="btn btn-warning" name="project_id" Value="<?php echo @$project_details['project_id']; ?>"/>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>                     
            </form>
        </div><!--tablecontent-->
    </div><!--subcontent-->
</div>
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
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"  >
                                <i class="fa fa-times"></i> Cancel
                            </button>
                            <button type="button" class="btn btn-primary pull-Right" id="assign-users" >
                                <i class="fa fa-check"></i> Ok
                            </button>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
</section>

<script type="text/javascript">
$('body').on('click', '.select-users', function () {
        $('.assign_task').modal();
    });
    $(function () {
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
            }
        });
    });

</script>



