<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><i class="fa fa-laptop"></i> View Assign Route</h4>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <div class="list box box-info">
                    <div class="">
                        <?php
                        if (isset($assigned_route) and $assigned_route != "") {
                            foreach ($assigned_route as $row) {                 
                                ?>
                                <div class="modal-body col-xs-12">
                                    <div class="col-xs-12" style="text-align:center;background-color:#f9f9f9; ">
                                        <div class="col-xs-6 ">
                                            <label>Route :</label> <span><?php echo $row['route_name']; ?></span>
                                        </div><div class="col-xs-6 ">
                                            <label>Assigned To : </label> <span><?php echo $row['umUserName']; ?></span>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Starting Location : </label><span><?php echo $row['starting_location']; ?></span>
                                        </div><div class="col-xs-6 ">
                                            <label>Created By :  </label> <span><?php echo $row['created_by']; ?></span>
                                        </div>
                                        <div class="col-xs-6">
                                            <label>Headquarters : </label><span><?php echo $row['amAreaName']; ?></span>    
                                        </div>
                                        <br>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th style="text-align:center !important">Customers</th>
                                                <th style="text-align:center !important">Visited/Not Visited</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (isset($routes) and $routes != "") {
                                                foreach($routes as $value){ 
                                                   if($value['route_id']==$row['route_id']){
                                                    ?>
                                               <tr>
                                                   <td><?php echo $value['place']; ?></td>
                                                    <td></td>
                                                </tr>
                                                   <?php } } } ?>
                                            </tbody>
                                            <tfoot>
                                            <td></td>
                                            <td></td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            <?php }
                        } else {
                            ?>
                            <div class="modal-body col-xs-12">
                                <div class="col-xs-12" style="text-align:center;background-color:#f9f9f9; ">
                                    <h4> No route has been assigned to this date!!</h4> 
                                </div>
                            </div>  
                        <?php }
                        ?>   
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
