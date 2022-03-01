<section class="content-header">
    <h1>
        Expenses
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Expenses</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Expenses</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#expense/add_expense"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Expense</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="expenses" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="code">
                                    ID
                                </th>
                                <th class="Route">
                                    Route Name
                                </th>
                                <th class="Route">
                                    Date
                                </th>
                                <th class="Headquarters">
                                    Headquarters Name
                                </th>
                                <th class="UserName">
                                  UserName
                                </th>
                                <th class="Town">
                                  Town Visited
                                </th>
                                <th class="Expense">
                                Expense
                                </th>
                                <th class="Status">
                                Status
                                </th>
                                <th class="edit">
                                    Edit
                                </th>
                                <th class="view">
                                    View
                                </th>
                                <th class="delete">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($table_data) {
                                $k=1;
                                foreach ($table_data as $row =>$value) {
                                    
                                    ?>
                            <tr class="<?php echo $value['status'];?>">
                                        <td><?php echo $k; ?></td>
                                        <td><?php echo $value['route_name']; ?></td>
                                        <td><?php echo $value['date']; ?></td>
                                        <td><?php echo $value['amAreaName']; ?></td>
                                        <td><?php echo $value['umUserName']; ?></td>
                                        <td><?php echo $value['town_visited']; ?></td>
                                        <td><?php echo $value['total']; ?></td>
                                        <td><?php echo $value['status']; ?></td>
                                        <td><a href="<?php echo base_url() . '#expense/add_expense/' . $value['id']; ?>">Edit</a></td>
                                        <td><input type="hidden" id="expense_id" name="expense_id" value="<?php echo $value['id']?>"><a href="#" id="expenseView">View</a></td>
                                        <td><a href="<?php echo base_url() . '#expense/delete_expense/' . $value['id']; ?>" onClick="return confirm('Are you want to delete this expense?');">Delete</a></td>
                                    </tr>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade in" id="view_expenses" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
            </div>  

        </div>
    </div>
</section>



<script type="text/javascript">
    $(function () {
        $('#expenses').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true
        });
        

    });
    
</script>


