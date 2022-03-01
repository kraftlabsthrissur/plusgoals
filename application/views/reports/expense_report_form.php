<section class="content-header">
   <h1>
        Expense Report Form
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Expense Report Form </li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Expense Report Form</h3>
                    </div>
                   
                </div><!-- /.box-header -->
                <div class="box-body ">
                    
                    <form  method="post" class="expense_report_from" action="">
                        
                        <div class="expenses">
                        <div class="row">

                            <div class="col-xs-6">
                                Select User
                                <select name="user_id" class="form-control">
                                    <option value="">select user</option>
                                        <?php echo $users; ?>
                                </select>
                                       <?php echo @$error['route_id']; ?>
                            </div>
                            <div class="col-xs-6">
                                Status
                                <select name="expense_status" class="form-control"> 
                                    <option value="">Select Expense Status</option>
                                    <option value="Accepted By ASM">Accepted By ASM</option>
                                    <option value="Accepted By Marketing dept.">Accepted By Marketing dept.</option>
                                    <option value="Accepted By Accounts dept.">Accepted By Accounts dept.</option>
                                    <option value="Rejected By ASM">Rejected By ASM</option>
                                    <option value="Rejected By Marketing dept.">Rejected By Marketing dept.</option>
                                    <option value="Rejected By Accounts dept.">Rejected By Accounts dept.</option>
                                    <option value="Not_verified">Not Verified</option>
                                    <option value="Refunded">Refunded</option>
                                </select> 
                            </div>
                          
                        </div>
                        <div class="row">
                             <div class="col-xs-6">
                                From Date 
                                <input type="text" id="visited_date_from" name="from_date" class="form-control date datepicker" value="<?php if(isset($expense[0]['date'])){ echo $expense[0]['date']; } else{
                                    echo Date('Y-m-d'); }?>">
                            </div>
                             <div class="col-xs-6">
                                To Date 
                                <input type="text" id="visited_date_to" name="to_date" class="form-control date datepicker" value="<?php echo Date('Y-m-d'); ?>">
                            </div>
                            
                        </div>
                           
                        <div class="row">
                           
                           
                            <div class="col-xs-4" style="height:54px !important;">
                                   <input type="button" id="expense_report_table" class="btn btn-primary" style="position: absolute;bottom:0px;" value="View Report Table">
                             </div>
                        </div>
                       
                        </div>
                    </form>
                </div>
            </div>
            <div class="expense_report_table hidden">
                
            </div>
        </div>
    </div>  

</section>
<script>
$("#visited_date_from").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
$("#visited_date_to").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
</script>

