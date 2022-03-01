<section class="content-header">
    <h1>
        Department <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Department</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-7">
                        <h3 class="box-title">All Departments</h3>
                    </div>

                </div>
                <!-- /.box-header -->
                <div id="main_content">
                    <!-- <h4><?php echo ($this->session->flashdata('item')); ?></h4> -->
                </div>
                <div class="row">
                    <div class="col-xs-12">
                         <form  class="ajax-form" method="post"
                              enctype="multipart/form-data"> 

                            <!-- <div class="col-xs-4">
                                <input type="file" name="xml" class="form-control">
                            </div>
                            <div class="col-xs-4">
                                <input type="submit" name="submit" class="btn btn-default"
                                       value="Upload XML">
                            </div> -->
                            <div class="col-xs-12">
                                <div class="pull-right">
                                    <a href="#admin/add_department" class="btn btn-primary"> <i
                                            class="fa fa-pencil"> Add New Department</i>
                                    </a>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="departments"
                           class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Department Code</th>
                                <th>Department Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        <thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<script type="text/javascript">
    $(function () {
        $('#departments').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "serverSide": true,
            "stateSave": true,
            "aoColumns": [
                {mData: 'department_code'},
                {mData: 'department_name'},
                
                {mData: 'edit', "bSortable": false},
                {mData: 'delete', "bSortable": false},
            ],
            "ajax": {
                "url": base_url + "listcontrol/json_departments",
            }
        });
    });
</script>
