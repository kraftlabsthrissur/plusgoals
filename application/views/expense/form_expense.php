<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Expense
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_expense"><i class="fa fa-laptop"></i> Expense</a></li>
        <li class="active">Add Expense</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Expense</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body ">

                    <form  method="post" class="ajax-submit" action="expense/<?php echo $edit_mode ? "add_expense/" . $expense[0]['id'] : "add_expense"; ?>">

                        <div class="expenses">
                            <div class="row">
                                <div class="col-xs-6">
                                    Select Route 
                                    <select name="route_id" class="form-control">
                                        <?php echo $routes; ?>
                                    </select>
                                    <?php echo isset($error['route_id']); ?>
                                </div>
                                <div class="col-xs-6">
                                    Town visited 
                                    <input type="text" name="town_visited"  class="form-control town_visited" value="<?php
                                    if (isset($expense[0]['town_visited'])) {
                                        echo $expense[0]['town_visited'];
                                    }
                                    ?>">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Date 
                                    <input type="text" id="visited_date" name="date" class="form-control date datepicker" value="<?php
                                    if (isset($expense[0]['date'])) {
                                        echo $expense[0]['date'];
                                    } else {
                                        echo Date('Y-m-d');
                                    }
                                    ?>">
                                </div>
                                <div class="col-xs-3">
                                    DA 
                                    <input type="text" name="da"  class="form-control da" value="<?php
                                           if (isset($expense[0]['da'])) {
                                               echo $expense[0]['da'];
                                           } else {
                                               echo 0;
                                           }
                                           ?>">
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-xs-3">
                                    Lodge 
                                    <input type="text" name="lodge" class="form-control lodge" value="<?php
                                           if (isset($expense[0]['lodge'])) {
                                               echo $expense[0]['lodge'];
                                           } else {
                                               echo 0;
                                           }
                                           ?>">
                                </div>
                            
                                <div class="col-xs-3">
                                    Courier 
                                    <input type="text" name="courier"  class="form-control courier" value="<?php
                                           if (isset($expense[0]['courier'])) {
                                               echo $expense[0]['courier'];
                                           } else {
                                               echo 0;
                                           }
                                           ?>">
                                </div>
                           
                                <div class="col-xs-3">
                                    Sundries 
                                    <input type="text" name="sundries"  class="form-control sundries" value="<?php
                                           if (isset($expense[0]['sundries'])) {
                                               echo $expense[0]['sundries'];
                                           } else {
                                               echo 0;
                                           }
                                           ?>">
                                </div>
                            </div>
                               <div class="row">
                                <div class="col-xs-3">
                                    TA 
                                    <select name="ta_type" class="form-control ta_type">
                                        <option >select TA Type</option>
                                        <option value="by_bus" 
                                            <?php if(isset($expense[0]['ta_type']) && $expense[0]['ta_type'] == "by_bus")  echo 'selected="selected"'; ?> >By Bus</option>
                                        <option value="by_bike" <?php if(isset($expense[0]['ta_type']) && $expense[0]['ta_type'] == "by_bike") echo 'selected="selected"'; ?> >By Bike</option>
                                    </select><br>
                                </div>   
                                    <div class="ta_bus hidden col-xs-3">
                                        Amount
                                        <input type="text" name="ta_bus" id="ta_bus_amount" class="form-control by_bus" value="<?php
                                           if (isset($expense[0]['ta_bus'])) {
                                               echo $expense[0]['ta_bus'];
                                           } else {
                                               echo 0;
                                           }
                                           ?>">
                                    </div>
                                    <div class="ta_bike hidden col-xs-3">
                                        Kilometer
                                        <input type="text" name="ta_bike_km"  class="form-control ta_bike_km" value="<?php
                                        if (isset($expense[0]['ta_bike_km'])) {
                                            echo $expense[0]['ta_bike_km'];
                                        } else {
                                            echo 0;
                                        }
                                        ?>">
                                    </div>
                                    <div class="ta_bike hidden col-xs-3">
                                        Amount
                                        <input type="text" name="ta_bike_amount"  class="form-control ta_bike_amount" value="<?php
                                        if (isset($expense[0]['ta_bike_amount'])) {
                                            echo $expense[0]['ta_bike_amount'];
                                        } else {
                                            echo 0;
                                        }
                                        ?>">
                                    </div> 
                              
                            </div>
                            <div class="row">

                                <div class="col-xs-4" >
                                    Total 
                                    <input type="text" name="total" class="form-control total" value="<?php
                                           if (isset($expense[0]['total'])) {
                                               echo $expense[0]['total'];
                                           } else {
                                               echo 0;
                                           }
                                           ?>">
                                </div>
                                <div class="col-xs-4" style="height:54px !important;">
<?php if (isset($expense[0]['id'])) { ?>
                                        <input type="hidden" name="id" value="<?php echo $expense[0]['id']; ?>">
                                        <input type="submit" id="save_expense" class="btn btn-primary" style="position: absolute;bottom:0px;" value="Save">
<?php } else {
    ?>
                                        <input type="submit" id="add_expense" class="btn btn-primary" style="position: absolute;bottom:0px;" value="submit">
<?php } ?>

                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  

</section>
<script>
    $("#visited_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
     var ta_type=$('body').find('select.ta_type option:selected').val();
    console.log(ta_type);
    if(ta_type =="by_bike"){
       
        $('.ta_bike').removeClass('hidden');
        $('.ta_bus').addClass('hidden');
     }else if(ta_type=="by_bus"){
        
        $('.ta_bus').removeClass('hidden');   
        $('.ta_bike').addClass('hidden');
     }else{
          $('.ta_bus').addClass('hidden');   
         $('.ta_bike').addClass('hidden');
     }  
    
</script>

