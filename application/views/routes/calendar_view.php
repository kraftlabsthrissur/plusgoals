<section class="content-header">
    <h1>
        Routes
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Routes</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Routes</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#routes/add_routes"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Route</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body" id="calendar">
                    <div class="pull-left">
                        <h3><?php
                            if (isset($month)) {
                                echo $month;
                            }
                            ?></h3>
                    </div>
                    <div class="pull-right">
                        <a href="#routes/calendar_view?c=<?php echo $p; ?>" class="btn btn-info"><i class="fa fa-angle-double-left">  Previous</i></a>   
                        <a href="#routes/calendar_view" class="btn btn-info">Current</a>   
                        <a href="#routes/calendar_view?c=<?php echo $n; ?>" class="btn btn-info">Next  <i class="fa fa-angle-double-right"></i></a>   

                    </div>
                    <?php
                    $this->load->library('SimpleCalendar');
                    $calendar = new SimpleCalendar();
                    if (isset($date))
                        $calendar = new SimpleCalendar($date);

                    $calendar->setStartOfWeek('Sunday');
                    if (isset($assigned_route) && $assigned_route != null) {
                        foreach ($assigned_route as $row) {

                            $description = "<div data-assigned-route-id='".$row['ar_id']."'>Route :" . $row['route_name'] . "<br> Assigned to :" . $row['umUserName'].'<a  class="remove-assigned-route pull-right">X</a></div>';
                            $calendar->addDailyHtml($description, $row['date']);
                        }
                    }

                    $calendar->show(true);
                    ?>
                </div>
            </div>


        </div>
    </div>
    <div class="modal fade in" id="cal_assignroutes" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><i class="fa fa-laptop"></i> Assign Route</h4>
                </div>
                <br/>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="list box box-info">
                            <div class="items box-body" id="assignUser"> 
                                <div class="row">
                                    <div class="col-xs-6" > 
                                        Select User
                                        <select name="selected_user" class="form-control">
                                            <?php echo $users; ?>
                                        </select>
                                        <?php echo @$error['id']; ?>

                                    </div>
                                    <div class="col-xs-6" > 
                                        Select Routes
                                        <select name="selected_route" class="form-control">
                                            <?php echo $routes; ?>
                                        </select>
                                        <?php echo @$error['id']; ?>
                                    </div>
                                    <div class="col-xs-6">
                                        Date
                                        <input class="form-control datepicker" value="" disabled="" name="date" id="cal_assigned_date" />
                                    </div>     
                                </div>
                            </div>
                            <div class="modal-footer clearfix">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="close" >
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal" id="cal_assign" >
                                    <i class="fa fa-check"></i> Ok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="modal fade in" id="cal_view_assignroutes" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">

    </div> 
</section>
<script>
    $(document).ready(function () {
        $('.SimpleCalendar tbody tr').each(function () {
            $(this).find('td time').append('<div class="pull-down"><a  class="route_assign pull-left">Assign Route</a> <a class="route_view pull-right">View</a></div>');
        });
        $('.SimpleCalendar tbody tr td time').each(function () {
            $(this).parents('td').css('position', 'relative');
            // $(this).parents('td').append('<div style="position:absolute;bottom:0px;display:block;text-align:center;font-size: .7em;font-weight:bold;"><a href="#" class="get_daily_report">Report</a></div>');
        });
        $('.route_assign').on('click', function () {
            var date = $(this).parents('time').attr('datetime');
            $('#cal_assignroutes').modal('toggle');

            $("#cal_assigned_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
            $('#cal_assigned_date').datepicker('setDate', date);

        });

        $('.route_view').on('click', function () {
            var vdate = $(this).parents('time').attr('datetime');
            $.ajax({
                url: base_url + 'routes/view_assign_route',
                method: 'POST',
                dataType: 'html',
                data: {date: vdate}
            }).success(function (response) {
                $('#cal_view_assignroutes').html(response);
                $('#cal_view_assignroutes').modal('toggle');
            });
        });


    });
</script>
