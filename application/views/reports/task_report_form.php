<section class="content-header">
   <h1>
       Task Report Form
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Task Report Form </li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Task Report Form</h3>
                    </div>
                    
                </div><!-- /.box-header -->
                <div class="box-body ">
                    
                    <form  method="post" class="task_report_from" action="">
                        
                        <div class="tasks">
                        <div class="row">

                            <div class="col-xs-6">
                                Select User
                                <select name="user_id" class="form-control">
                                    <option value="">select user</option>
                                        <?php echo $users; ?>
                                </select>
                                       <?php echo @$error['route_id']; ?>
                            </div>
                          
                        </div>
                        <div class="row">
                             <div class="col-xs-6">
                                From Date 
                                <input type="text" id="task_date_from" name="from_date" class="form-control date datepicker" value="<?php if(isset($expense[0]['date'])){ echo $expense[0]['date']; } else{
                                    echo Date('Y-m-d'); }?>">
                            </div>
                             <div class="col-xs-6">
                                To Date 
                                <input type="text" id="task_date_to" name="to_date" class="form-control date datepicker" value="<?php echo Date('Y-m-d'); ?>">
                            </div>
                            
                        </div>
                           
                        <div class="row">
                           
                           
                            <div class="col-xs-4" style="height:54px !important;">
                                   <input type="button" id="generate_task_report_table" class="btn btn-primary" style="position: absolute;bottom:0px;" value="View Report Table">
                             </div>
                        </div>
                       
                        </div>
                    </form>
                </div>
            </div>
             <div class="task_report_table hidden">
                
            </div>
        </div>
    </div>  
   
</section>
<script>
$("#task_date_from").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
$("#task_date_to").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
</script>

