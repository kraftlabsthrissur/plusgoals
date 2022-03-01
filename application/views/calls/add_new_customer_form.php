<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> New Customer Call
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_call"><i class="fa fa-laptop"></i> New Customer Call</a></li>
        <li class="active">New Customer Call</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit " : "Add "; ?>New Customer Call</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body ">

                    <form  method="post" class="ajax-submit" action="calls/<?php echo $edit_mode ? "add_new_customer_calls/" . $new_customer[0]['id'] : "add_new_customer_calls"; ?>">

                        <div class="new_calls">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Customer Name</label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo isset($new_customer[0]['customer_name']) ? $new_customer[0]['customer_name'] : "";?>">
                                </div>   
                            </div>   
 <div class="row">
                                <div class="col-xs-4">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo isset($new_customer[0]['phone']) ? $new_customer[0]['phone'] : "";?>">
                                </div>   
                            </div>   
 <div class="row">
                                <div class="col-xs-4">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo isset($new_customer[0]['address']) ? $new_customer[0]['address'] : "";?>">
                                </div>   
                            </div>    
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Customer Details</label>
                                    <textarea type="text" class="form-control" name="customer_details" id="customer_details"><?php echo isset($new_customer[0]['customer_details']) ? $new_customer[0]['customer_details'] : "";?></textarea>
                                </div>   
                            </div>    
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>More Informations</label>
                                    <textarea type="text" class="form-control" name="customer_info" id="customer_info"><?php echo isset($new_customer[0]['customer_info']) ? $new_customer[0]['customer_info'] : "";?></textarea>
                                </div>   
                            </div> 
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Call Date</label>
                                    <input type="text" class="form-control datepicker" name="call_date" id="call_date" value="<?php echo isset($new_customer[0]['call_date']) ? $new_customer[0]['call_date'] : "";?>">
                                </div>   
                            </div> 
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <input type="hidden" class="form-control" name="id" id="id" value="<?php echo isset($new_customer[0]['id']) ? $new_customer[0]['id'] : "";?>">
                                    <input type="submit" id="add_new_customer_call" class="btn btn-primary" style="position: absolute;bottom:0px;" value="Save">
                                </div>   
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $("#call_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
</script>
