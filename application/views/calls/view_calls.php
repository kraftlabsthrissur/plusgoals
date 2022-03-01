<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><i class="fa fa-laptop"></i> View Calls</h4>
</div>
<br/>
<div class="row">
    <div class="col-xs-12">
        <div class="list box box-info">
            <div class="">
                <?php
                if (isset($calls) and $calls != "") {
                    foreach ($calls as $row) {
                        ?>
                        <div class="modal-body col-xs-12">
                            <div class="col-xs-12" style="background-color:#f9f9f9; ">
                                <div class="col-xs-6 ">
                                    <label>Route :</label> <span><?php echo $row['route_name']; ?></span>
                                </div><div class="col-xs-6 ">
                                    <label>user: </label> <span><?php echo $row['umUserName']; ?></span>
                                </div>
                                <div class="col-xs-6">
                                    <label>Customer Name : </label><span><?php echo $row['smStoreName']; ?></span>
                                </div>
                                <div class="col-xs-6 ">
                                    <label>Date :  </label> <span><?php echo $row['date']; ?></span>
                                </div>
                                <div class="col-xs-6">
                                    <label>Status : </label><span><?php echo $row['status']; ?></span>    
                                </div>

<div class="col-xs-6">
                                    <label>Product Discussed : </label><span><?php echo $row['products_prescribed']; ?></span>    
                                </div>

                                <div class="col-xs-6">
                                    <label>Order Received: </label><span><?php echo $row['order_booked']; ?></span>    
                                </div>

                                <div class="col-xs-6">
                                    <label>Remarks: </label><span><?php echo $row['information_conveyed']; ?></span>    
                                </div>
                               
                                <div class="col-xs-6">
                                    <label>Payment Received : </label><span><?php echo $row['collection']; ?></span>    
                                </div>
                                <div class="col-xs-6">
                                    <label>Next Visit Date : </label><span><?php echo $row['next_visit_date']; ?></span>    
                                </div>

                                <div class="clearfix"></div>

    <?php }
} else {
    ?>
                            <div class="modal-body col-xs-12">
                                <div class="col-xs-12" style="text-align:center;background-color:#f9f9f9; ">
                                    <h4> No Expense has been created to this date!!</h4> 
                                </div>
                            </div>  
                        <?php }
                        ?>   
                    </div>
                    <div class="modal-footer clearfix">
<?php if ($role[0]['role_id'] == 9) { ?>
    <!--                                <input type="hidden" class="expense_id" name="expense_id" value="//<?php echo $row['id'] ?>">
                            <a href="#expense/accept_expense///<?php echo $row['id'] ?>" id="accept_expense" class="btn btn-info accept_expense" data-dismiss="modal" >
                                <i class="fa fa-check"></i> Accept
                            </a>
                            <a href="#expense/reject_expense///<?php echo $row['id'] ?>" class="btn btn-danger reject_expense" id="reject_expense" data-dismiss="modal" >
                                <i class="fa fa-times"></i> Reject
                            </a>-->
<?php } ?>
                        <button type="button" class="btn btn-primary "  data-dismiss="modal" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
