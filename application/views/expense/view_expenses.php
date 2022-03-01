 <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><i class="fa fa-laptop"></i> View Expenses</h4>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <div class="list box box-info">
                    <div class="">
                        <?php
                       
                        if (isset($expense) and $expense != "") {
                            foreach ($expense as $row) {
                                ?>
                                <div class="modal-body col-xs-12">
                                    <div class="col-xs-12" style="text-align:center;background-color:#f9f9f9; ">
                                        <div class="col-xs-6 ">
                                            <label>Route :</label> <span><?php echo $row['route_name']; ?></span>
                                        </div><div class="col-xs-6 ">
                                            <label>Expense Created By: </label> <span><?php echo $row['umUserName']; ?></span>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Date : </label><span><?php echo $row['date']; ?></span>
                                        </div><div class="col-xs-6 ">
                                            <label>Town Visited :  </label> <span><?php echo $row['town_visited']; ?></span>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Headquarters : </label><span><?php echo $row['amAreaName']; ?></span>    
                                        </div>
                                        <div class="col-xs-6">
                                            <label>TA : </label><span><?php echo $row['ta']; ?></span>    
                                        </div>
                                        <div class="col-xs-6">
                                            <label>DA : </label><span><?php echo $row['da']; ?></span>    
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Lodge : </label><span><?php echo $row['lodge']; ?></span>    
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Courier : </label><span><?php echo $row['courier']; ?></span>    
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Sundries : </label><span><?php echo $row['sundries']; ?></span>    
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Total : </label><span><?php echo $row['total']; ?></span>    
                                        </div>

                        <?php } } else {
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
                                <?php if($role[0]['role_id']==9 || $role[0]['role_id']==10 ||$role[0]['role_id']==11) { ?>
                                <input type="hidden" class="expense_id" name="expense_id" value="<?php echo $row['id']?>">
                                <input type="hidden" class="role_id" name="role_id" value="<?php echo $role[0]['role_id']?>">
                                <a href="#expense/accept_expense/<?php echo $row['id']?>" id="accept_expense" class="btn btn-info accept_expense" data-dismiss="modal" >
                                    <i class="fa fa-check"></i> Accept
                                </a>
                                <a href="#expense/reject_expense/<?php echo $row['id']?>" class="btn btn-danger reject_expense" id="reject_expense" data-dismiss="modal" >
                                    <i class="fa fa-times"></i> Reject
                                </a>
                                <?php }?>
                                <button type="button" class="btn btn-primary "  data-dismiss="modal" >
                                    <i class="fa fa-check"></i> Ok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 