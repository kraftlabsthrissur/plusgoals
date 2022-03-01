<section class="content-header">
    <h1>
        Allocation
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Allocation</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Allocation</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="<?php echo base_url(); ?>#admin/allocate"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Allocate</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table  id = "allocation" class="table  table-bordered table-striped table-hover" >
                        <thead>
                            <tr>
                                <th width=115>
                                    Store Code
                                </th>
                                <th width=100>
                                    Store Name
                                </th>
                                <th  width=100>
                                    Type
                                </th> 
                                <th  width=100>
                                    Rep Name
                                </th>
                                <th  width=100>
                                    Branch
                                </th>                              

                                <th width=40>
                                    Change
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
        $('#allocation').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "serverSide": true,
            "stateSave": true,
            "aoColumns": [
                {mData: 'smStoreCode'},
                {mData: 'smStoreName'},
                {mData: 'customer_group'},
                {mData: 'rep_name'},
                {mData: 'smCity'},
                
                {mData: 'c', "bSortable": false},
            ],
            "ajax": {
                "url": base_url + "admin/json_allocation",
            }
        });
    });
</script>