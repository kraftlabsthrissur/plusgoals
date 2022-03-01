<div class="box">
    <div class="box-header">
        <div class="col-xs-8">
            <h3 class="box-title">All Calls</h3>
        </div>
        
    </div><!-- /.box-header -->
    <div id="main_content">
        <h4><?php echo ($this->session->flashdata('item')); ?></h4>
    </div>
    <form  method="post" class="expense_report_pdf" action="<?php echo base_url();?>callreport/generate_call_report">
       <input type="hidden" name="user_id" class="form-control date datepicker" value="<?php echo isset($form_data['user_id']) ? $form_data['user_id'] :"";?>">
       <input type="hidden" name="status" class="form-control date datepicker" value="<?php echo isset($form_data['status']) ? $form_data['status'] :"";?>">
       <input type="hidden" name="from_date" class="form-control date datepicker" value="<?php echo isset($form_data['from_date']) ? $form_data['from_date'] :"";?>">
       <input type="hidden" name="to_date" class="form-control date datepicker" value="<?php echo isset($form_data['to_date']) ? $form_data['to_date'] :"";?>">
    <div class="box-body table-responsive">
        <table id="expenses" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="SNo">
                        S.No
                    </th>
                    <th class="name">
                        Name of the Customer
                    </th>
                    <th class="name">
                        Customer Type
                    </th>
                    <th class="product">
                       Product Prescribing
                    </th>
                    <th class="sample">
                        Sample Given
                    </th>
                    <th class="orderbooked">
                       Amount of Order Booked
                    </th>
                    <th class="orderbooked">
                       Status
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($table_data) {
                    $i = 1;
                    foreach ($table_data as $row => $value) {
                      
                         //  if ($value['customer_group'] == "Doctor") {
                            ?>
                            <tr class="<?php echo $value['status']; ?>">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value['smStoreName']; ?></td>
                                <td><?php echo $value['customer_group']; ?></td>
                                <td class="prescribing">
                                    <?php
                                       
                                       echo $value['prescribing_product'];
                                    ?>
                                </td>
                                <td class="sample">

                                    <?php
                                   
                                       echo $value['sample'];
                                    ?>      
                                </td>
                                <td> <?php echo $value['order_booked']; ?> </td>
                                <td> <?php echo $value['status']; ?> </td>
                            </tr>
                            <?php
                            $i++;
                  
                     //   }

                    }
                }
                ?>
            </tbody>
        </table>
        <br>
        <input type="submit" class="btn btn-primary " id="generate_call_report_pdf"  data-dismiss="modal" value="Export" >
    </div>
  </form>     
</div>