<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Call
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_call"><i class="fa fa-laptop"></i> Call</a></li>
        <li class="active">Add call</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Call</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body ">

                    <form  method="post" class="ajax-submit" action="calls/<?php echo $edit_mode ? "add_calls/" . isset($call[0]['id']) ? $call[0]['id'] : '' : "add_calls"; ?>">

                        <div class="calls">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label> Select Route </label>
                                    <select name="route_id" class="form-control route">
                                        <option value="">Select Route</option>
                                        <?php echo $routes; ?>
                                    </select>
                                    <?php echo isset($error['route_id']); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4" >
                                    <label> Select Customer </label>
                                    <select id="select_customer" name="customer_id" class="form-control customer">
                                        <option value="" >Select Customer</option>
                                        <?php echo $customers; ?>
                                    </select>
                                    <?php echo isset($error['customer_id']); ?>
                                </div>
                                <div class="col-xs-2 customer_type hidden" style="height:60px !important;">
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <label> Visited Date </label>
                                    <input type="text" id="visited_date" name="date" class="form-control date datepicker" value="<?php
                                    if (isset($call[0]['date']) && $call[0]['status'] == "visited") {
                                        echo $call[0]['date'];
                                    } else {
                                        echo Date('Y-m-d');
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Product Discussed</label>
                                    <input type="text" name="products_prescribed" class="form-control promotional_product" value="<?php echo isset($call[0]['products_prescribed']) ? $call[0]['products_prescribed'] : ""; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Order Received</label>
                                    <input type="text" name="order_booked" class="form-control order_booked" value="<?php echo isset($call[0]['order_booked']) ? $call[0]['order_booked'] : ""; ?>">
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-xs-4" >
                                    <label>Payment Received</label>
                                    <input type="text" name="collection" class="form-control total" value="<?php
                                    if (isset($call[0]['collection'])) {
                                        echo $call[0]['collection'];
                                    } else {
                                        echo 0;
                                    }
                                    ?>">
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Remarks</label>
                                    <textarea type="text" name="information_conveyed" class="form-control information_conveyed" value=""><?php echo isset($call[0]['information_conveyed']) ? $call[0]['information_conveyed'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>Next Visit Date</label>
                                    <input type="text" name="next_visit_date" class="form-control next_visit_date date datepicker" value="<?php echo isset($call[0]['next_visit_date']) ? $call[0]['next_visit_date'] : ""; ?>">
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <label>visited</label>  <input type="checkbox" name="status" value="" <?php if (isset($call[0]['status']) && $call[0]['status'] == "visited") { ?> checked <?php } ?> >  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4" style="height:54px !important;">
                                    <?php if (isset($call[0]['id'])) { ?>
                                        <input type="hidden" name="id" value="<?php echo $call[0]['id']; ?>">
                                        <input type="submit" id="save_call" class="btn btn-primary" style="position: absolute;bottom:0px;" value="Save">
                                    <?php } else {
                                        ?>
                                        <input type="submit" id="add_call" class="btn btn-primary" style="position: absolute;bottom:0px;" value="submit">
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
    $(".date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
</script>

