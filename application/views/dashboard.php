<?php
/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2014, Ajith Vp <ajith@kraftlabs.com>
 * @date 14-Jan-2015
 */
?>

<link href="<?php echo base_url(); ?>assets/css/morris/morris.css" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo $new_task; ?>
                    </h3>
                    <p>
                        New Task
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo base_url(); ?>#salesorder/view_sales_order" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo $percentage_completed; ?>
                    </h3>
                    <p>
                        Percentage Completed
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <!-- <div class="col-lg-3 col-xs-6"> -->
            <!-- small box -->
            <!-- <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                       // <--?php echo $new_products; ?>
                    </h3>
                    <p>
                        New Products
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios7-pricetag-outline"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div> -->
        <!-- </div>./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php echo $users; ?>
                    </h3>
                    <p>
                        Users 
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->

    </div><!-- /.row -->

    <div class="row">
        <!-- Left col -->
        <!-- <section class="col-lg-7 connectedSortable">                            


            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <!-- <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                    <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
                    <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
                </ul> -->
                <!-- <div class="tab-content no-padding">
                    <!-- Morris chart - Sales -->
                    <!-- <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                </div> -->
            <!-- </div><!-- /.nav-tabs-custom -->
        <!-- </section> -->
        <!-- <!-- <section class="col-lg-5">
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">
                        <!-- <div class="modal-header">
                            <h4 class="modal-title"><i class="fa fa-laptop"></i> Orders</h4>
                        </div> -->

                        <!-- <div class="box-body table-responsive" > 
                            <table   class="table  table-bordered table-hover table-striped table-mailbox" >
                                <tbody>
                                    <tr>
                                        <td>New Communication </td>
                                        <td><?php echo $new_communication; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Partially Saved Orders</td>
                                        <td><?php echo $partial_orders; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pending Orders</td>
                                        <td><?php echo $pending_orders; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Processing Orders</td>
                                        <td><?php echo $processing_orders; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Suspended Orders</td>
                                        <td><?php echo $suspended_orders; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Canceled Orders</td>
                                        <td><?php echo $cancelled_orders; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Completed Orders</td>
                                        <td><?php echo $completed_orders; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->
                    <!-- </div>
                </div>
            </div>
        </section>
    </div>
</section> -->

<!-- <script type="text/javascript" >

    var url1 = "http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js";
    var url2 = base_url + "assets/js/plugins/morris/morris.min.js"; -->
    <!-- // $.getScript(url1, function () {
    //     $.getScript(url2, function () {
    //         $(function () {
    //             "use strict";
    //             var area = new Morris.Area({
    //                 element: 'revenue-chart',
    //                 resize: true,
    //                 data:<?php echo json_encode($divisionwise_sales); ?>,
    //                 xkey: 'y',
    //                 ykeys: <?php echo json_encode($ykeys); ?>,
    //                 labels: <?php echo json_encode($labels); ?>,
    //                 lineColors: <?php echo json_encode($line_colors); ?>,
    //                 hideHover: 'false'
    //             });


    //         });
    //     });
    // }); -->







<!-- </script> -->

