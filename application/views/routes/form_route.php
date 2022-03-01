<?php
/**
 * @author ajith
 * @date 6 Feb, 2015
 */
?>


<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Route
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_routes"><i class="fa fa-laptop"></i> Route</a></li>
        <li class="active">Add Route</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Route</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit draw_routes" action="routes/<?php echo $edit_mode ? "edit_routes/" . $routes[0]['route_id'] : "add_routes"; ?>">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-3">
                                        Route Name
                                    </div>
                                    <div class="col-xs-7">
                                        <input type="text"  class="required form-control" name="route_name" value="<?php echo @$routes[0]['route_name']; ?>" />
                                        <?php echo @$error['route_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-3">
                                        HeadQuarters
                                    </div>
                                    <div class="col-xs-7">
                                        <select name="amId" class="form-control">
                                            <?php echo $headquarters; ?>
                                        </select>
                                        <?php echo @$error['amId']; ?>
                                    </div>

                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-xs-3">
                                        Starting Location
                                    </div>
                                    <div class="col-xs-7">
                                        <input type="text"  class="required form-control" id="selected_location" name="starting_location" value="<?php echo @$routes[0]['starting_location']; ?>" />
                                        <?php echo @$error['starting_location']; ?>
                                    </div>

                                </div>
                                <br/>

                                <div class="row">
                                    <div class="col-xs-3">

                                    </div>
                                    <div class="col-xs-7">
<!--                                        <input type="text"  class="required form-control" name="customers_name" value="<?php echo @$form_data['customers_name']; ?>" />-->
                                       <!-- <select name="smId" class="form-control">
                                        <?php echo $customers; ?>
                                        </select>  
                                        <?php echo @$error['smId']; ?>-->
                                        <input type="button" class="btn btn-primary" id="select_customers" value="Select Customer">
                                    </div>
                                    <div class="col-xs-2">

<!--                                        <input type="button" class="btn btn-primary add_route_place" id="add_route" value="Add">-->

                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <?php if ($edit_mode = "Edit" && isset($routes)) { ?>
                                        <div class="col-xs-8 route_places" id="route" >
                                            <ul class="sortable">
                                                <?php foreach ($routes as $key => $value) { ?>
                                                    <li class="col-xs-12"  >
                                                        <input type="hidden" class="selected_place"name="customer_id[]" value="<?php echo $value['customer_id'] ?>">
                                                        <input type="hidden" class="selected_place"name="place[]" value="<?php echo $value['place'] ?>">
                                                        <input type="hidden" class="place_address"name="place_address[]" value="<?php echo $value['area'] . ", " . $value['location'];  ?>">
                                                        <input type="hidden" class="place_lat"name="place_lat[]" value="<?php echo $value['latitude'] ?>">
                                                        <input type="hidden" class="place_lng"name="place_lng[]" value="<?php echo $value['longitude'] ?>">
                                                        <label><?php echo $value['place']; ?></label>
                                                        <div><?php echo $value['area'] . ", " . $value['location']; ?></div>
                                                        <span class="closeList pull-right">X</span>
                                                    </li> 

                                                <?php } ?>
                                            </ul>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-xs-8 route_places hidden" id="route" >
                                            <ul class="sortable"></ul>
                                        </div>
                                    <?php } ?>
                                </div>
                                <br/> 

                                <div class="row">
                                    <div class="col-xs-3"></div>
                                    <div class="col-xs-7" id="directions-panel"></div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-3">
                                    </div>
                                    <div class="col-xs-7">
                                        <input type="submit" class="btn btn-primary" id="route_save"  Value="Save"/>
                                        <input type="reset" class="btn btn-warning"  Value="Reset"/>
                                        <input type="hidden"  name="route_id" Value="<?php echo @$routes[0]['route_id']; ?>"/>
                                    </div>
                                </div>
                                <br/>
                            </div>
                            <div class="col-xs-6" style="height: 80%">
                                <div id="map" style="width: 100%; height:400px"></div>
                            </div>
                        </div>                     
                    </form>
                </div><!--tablecontent-->
            </div><!--subcontent-->
        </div>
    </div>
</div>

<div class="modal fade in" id="storeMaster" tabindex="-1" role="dialog"
     aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeCustomer" data-dismiss="modal"
                        aria-hidden="true">×</button>
                <h4 class="modal-title">
                    <i class="fa fa-laptop"></i> Customers
                </h4>
            </div>
            <br />
            <div class="row">
                <div class="col-xs-12">

                    <div class="col-xs-12">

                        <table id="masterResult"
                               class="table  table-bordered table-striped dataTable table-hover">
                            <thead>
                                <tr>
                                    <td>Select</td>
                                    <td>Customer Name</td>
                                    <td>Area</td>
                                    <td>Location</td>
                                    <td>Rep_name</td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($customers > 0) {
                                    foreach ($customers as $row) {
                                        ?>
                                        <tr>
                                            <td class="customer_id">
                                                <input type="checkbox" class="checkboxStore" id="<?php echo $row['id']; ?>"/>
                                            </td>
                                            <td class="customer_name">
                                                <?php echo $row['name']; ?>
                                            </td>
                                            <td class="area">
                                                <?php echo $row['area']; ?>
                                            </td>
                                            <td class="location">
                                                <?php echo $row['location']; ?>
                                            </td>
                                            <td class="rep_name">
                                                <?php echo $row['rep_name']; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"
                        id="closemasterCustomer">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary pull-left add_route_place"
                        id="add_route">
                    <i class="fa fa-check"></i> Ok
                </button>
            </div>
        </div>
    </div>
</div>


</section>
<script type="text/javascript">

    initMap();
    $(".sortable").css("overflow-y", "auto");
    $(".sortable").sortable({
        connectWith: ".sortable",
        cursor: 'move',
        tolerance: 'pointer',
        scroll: true,
        start: function (e, ui) {
            ui.placeholder.height(ui.item.height());
        },
        stop: function (e, ui) {
            initMap();
        }


    });

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy'
    });
    $('body ').on('click', '#select_customers', function () {

        $('#storeMaster').slideDown();
    });
    $(function () {
        $('#masterResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "iDisplayLength": 10,
        });
    });
    $('body').on('click', '#closemasterCustomer', function () {
        $('#storeMaster').slideUp();
    });
    $('body').on('click', '#closeCustomer', function () {
        $('#storeMaster').slideUp();
    });

</script>

