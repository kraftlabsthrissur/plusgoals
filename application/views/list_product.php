<section class="content-header">
    <h1>
        Products <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Products</h3>
                    </div>
                </div>
                <!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <form action="xml/import_items" class="ajax-form" method="post"
                              enctype="multipart/form-data">

                            <div class="col-xs-4">
                                <input type="file" name="xml" class="form-control">
                            </div>
                            <div class="col-xs-4">
                                <input type="submit" name="submit" class="btn btn-default"
                                       value="Upload XML">
                            </div>
                            <div class="col-xs-4">
                                <div class="pull-right">
                                    <a href="#admin/add_product" class="btn btn-primary"> <i
                                            class="fa fa-pencil"> Add New Product</i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="products"
                           class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="productcode">Code</th>
                                <th>Product Name</th>
                                <th>Packing Code</th>
                                <th>Inside Kerala Price</th>
                                <th>Outside Kerala Price</th>
                                <th>Category</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
                <!--tablecontent-->
            </div>
            <!--subcontent-->
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('#products').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "serverSide": true,
            "stateSave": true,
            "aoColumns": [
                {mData: 'pmProductCode'},
                {mData: 'pmProductName'},
                {mData: 'packingCode'},
                {mData: 'insideKeralaPrice'},
                {mData: 'outsideKeralaPrice'},
                {mData: 'pmCategory'},                
                {mData: 'edit', "bSortable": false},
                {mData: 'delete', "bSortable": false},
            ],
            "ajax": {
                "url": base_url + "listcontrol/json_products",
            }
        });
    });
</script>
