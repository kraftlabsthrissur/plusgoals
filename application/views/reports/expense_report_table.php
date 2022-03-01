<div class="box">
    <div class="box-header">
        <div class="col-xs-8">
            <h3 class="box-title">Report Table</h3>
        </div>

    </div><!-- /.box-header -->
    <div id="main_content">
        <h4><?php echo ($this->session->flashdata('item')); ?></h4>
    </div>
   <form  method="post" class="expense_report_pdf" action="<?php echo base_url();?>expensereport/generate_expense_report">
       <input type="hidden" name="user_id" class="form-control date datepicker" value="<?php echo isset($form_data['user_id']) ? $form_data['user_id'] :"";?>">
       <input type="hidden" name="status" class="form-control date datepicker" value="<?php echo isset($form_data['status']) ? $form_data['status'] :"";?>">
       <input type="hidden" name="from_date" class="form-control date datepicker" value="<?php echo isset($form_data['from_date']) ? $form_data['from_date'] :"";?>">
       <input type="hidden" name="to_date" class="form-control date datepicker" value="<?php echo isset($form_data['to_date']) ? $form_data['to_date'] :"";?>">
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

                </tr>
            </thead>
            <tbody>
                <?php
                if ($table_data) {
                    $k = 1;
                    foreach ($table_data as $row => $value) {
                        ?>
                        <tr class="<?php echo $value['status']; ?>">
                            <td><?php echo $k; ?></td>
                            <td><?php echo $value['route_name']; ?></td>
                            <td><?php echo $value['date']; ?></td>
                            <td><?php echo $value['amAreaName']; ?></td>
                            <td><?php echo $value['umUserName']; ?></td>
                            <td><?php echo $value['town_visited']; ?></td>
                            <td><?php echo $value['total']; ?></td>
                            <td><?php echo $value['status']; ?></td>

                        </tr>
                        <?php
                        $k++;
                    }
                }
                ?>
            </tbody>
        </table>
        <br>
        <input type="submit" class="btn btn-primary " id="generate_expense_report_pdf"  data-dismiss="modal" value="Export" >
     </div>
  </form> 
</div>