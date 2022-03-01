<section class="content-header">
    <h1>
        Users
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Users</h3>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <form action="xml/import_user" class="ajax-form" method="post"
                              enctype="multipart/form-data">

                            <div class="col-xs-4">
                                <input type="file" name="xml" class="form-control">
                            </div>
                            <div class="col-xs-4">
                                <input type="submit" name="submit" class="btn btn-default"
                                       value="Upload XML">
                            </div>
                        </form>
                        <div class="col-xs-4">
                            <div class="pull-right">
                                <a href="#admin/create_user"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Create New User</i></button></a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="box-body table-responsive">
                    <table  id = "users" class="table  table-bordered table-striped table-hover" >
                        <thead>
                            <tr>
                                <th width=115>
                                    User Code
                                </th>
                                <th width=100>
                                    Name
                                </th>
                                <th  width=100>
                                    User Name
                                </th>                               
                                <th  width=100>
                                    Email id
                                </th>
                                <th  width=100>
                                    City
                                </th>
                                <th  width=40>
                                    Edit
                                </th>
                                <th width=40>
                                    Delete
                                </th>
                            </tr>
                        </thead>

                    </table>
                </div>

            </div><!--tablecontent-->
        </div><!--maincontent-->
    </div>
</section>



<script type="text/javascript">
    $(function () {
        $('#users').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "serverSide": true,
            "stateSave": true,
            "aoColumns": [
                {mData: 'umUserCode'},
                {mData: 'userFullName'},
                {mData: 'umUserName'},
                {mData: 'umEmail'},
                {mData: 'umCity'},
                {mData: 'edit', "bSortable": false},
                {mData: 'delete', "bSortable": false},
            ],
            "ajax": {
                "url": base_url + "listcontrol/json_users",
            }
        });
    });
</script>

