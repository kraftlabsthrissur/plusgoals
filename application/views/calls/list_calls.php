<section class="content-header">
    <h1>
        Calls
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Calls</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Calls</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#calls/add_calls"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Call</i></button></a>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#calls/add_new_customer_calls"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Customer Call</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="row">
                    <div class="col-xs-12">
                        <form action="calls/list_calls"  class="ajax-submit" method="POST" >
                            <div class="col-xs-2">
                                <label>From Date</label>
                                <input type="text" name="c_from_date" readonly="readonly" class="datepicker from_date form-control" value="<?php echo isset($c_from_date) ? $c_from_date : ''; ?>" />
                            </div>
                            <div class="col-xs-2">
                                <label>To Date</label>
                                <input type="text" name="c_to_date" readonly="readonly" class=" datepicker from_date form-control" value="<?php echo isset($c_to_date) ? $c_to_date : ''; ?>" />
                            </div>
                            <div class="col-xs-2">
                                <label>User</label>
                                <select class="form-control" name="c_user_id">
                                    <option value="">Select</option>
                                    <?php echo $c_users; ?>
                                </select>
                            </div>

                            <div class="col-xs-2">
                                <label>&nbsp;<br/></label>
                                <br/>
                                <input type="submit" value="Filter" class="btn btn-primary"  />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="calls" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                            <tr>

                                <th class="Route">
                                    Route Name
                                </th>
                                <th class="UserName">
                                    User Name
                                </th>
                                <th class="UserName">
                                    Date
                                </th>
                                <th class="Date">
                                    Customer Name
                                </th>
                                <th class="Headquarters">
                                    Status
                                </th>

                                <th class="edit">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
            <br>

            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">New Customer Call</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <form action="calls/list_calls"  class="ajax-submit" method="POST" >
                            <div class="col-xs-2">
                                <label>From Date</label>
                                <input type="text" name="n_from_date" readonly="readonly" class="datepicker from_date form-control" value="<?php echo isset($n_from_date) ? $n_from_date : ''; ?>" />
                            </div>
                            <div class="col-xs-2">
                                <label>To Date</label>
                                <input type="text" name="n_to_date" readonly="readonly" class=" datepicker from_date form-control" value="<?php echo isset($n_to_date) ? $n_to_date : ''; ?>" />
                            </div>
                            <div class="col-xs-2">
                                <label>User</label>
                                <select class="form-control" name="n_user_id">
                                    <option value="">Select</option>
                                    <?php echo $n_users; ?>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <label>&nbsp;<br/></label>
                                <br/>
                                <input type="submit" value="Filter" class="btn btn-primary"  />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="new_calls" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                        <th>User Name</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Customer Details</th>
                        <th>Customer Info</th>
                        <th>Actions</th>

                        </thead>

                    </table>
                </div>    
            </div>

            <div class="modal fade in" id="view_calls" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"></div>
                </div>
            </div>  

        </div>
    </div>
</section>



<script type="text/javascript">
    $('#calls').dataTable({
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bAutoWidth": true,
        "serverSide": true,
        "stateSave": true,
        "aoColumns": [
            {mData: 'route_name'},
            {mData: 'umUserName'},
            {mData: 'date'},
            {mData: 'smStoreName'},
            {mData: 'status'},
            {mData: 'action', 'sortable': false},
        ],
        "ajax": {
            "url": base_url + "calls/json_calls",
        },
    });
    $('#new_calls').dataTable({
        "bInfo": true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bAutoWidth": true,
        "serverSide": true,
        "stateSave": true,
        "aoColumns": [
            {mData: 'umUserName'},
            {mData: 'creation_date'},
            {mData: 'customer_name'},
            {mData: 'phone'},
            {mData: 'address'},
            {mData: 'customer_details'},
            {mData: 'customer_info'},
            {mData: 'action', 'sortable': false},
        ],
        "ajax": {
            "url": base_url + "calls/json_new_calls",
        },
    });

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });

</script>


