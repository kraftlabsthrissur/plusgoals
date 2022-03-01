<section class="content-header">
    <h1>
        Call Report Form
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Call Report Form </li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Call Report Form</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body ">

                    <form  method="post" class="call_report_from" action="">

                        <div class="calls">
                            <div class="row">
                                <div class="col-xs-6">
                                    From Date 
                                    <input type="text" id="visited_date_from" name="from_date" class="form-control date datepicker" value="<?php
                                    if (isset($expense[0]['date'])) {
                                        echo $expense[0]['date'];
                                    } else {
                                        echo Date('Y-m-d');
                                    }
                                    ?>">
                                </div>
                                <div class="col-xs-6">
                                    To Date 
                                    <input type="text" id="visited_date_to" name="to_date" class="form-control date datepicker" value="<?php echo Date('Y-m-d'); ?>">
                                </div>

                            </div>    
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
                                    Select Status
                                    <select name="call_status" class="form-control">
                                        <option value="">select status</option> 
                                        <option value="visited">Visited</option> 
                                        <option value="Not_visited">Not Visited</option> 
                                    </select>    
                                </div>

                            </div>


                            <div class="row">


                                <div class="col-xs-4" style="height:54px !important;">
                                    <input type="button" id="call_report" class="btn btn-primary" style="position: absolute;bottom:0px;" value="View Report Table">
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
            <div class="call_report_table hidden">

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

