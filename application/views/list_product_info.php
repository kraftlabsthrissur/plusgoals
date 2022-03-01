<section class="content-header">
    <h1>
        Product Info
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product Info</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Product Info</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#listcontrol/add_product_info"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add Product Info</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="product_info" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="code">
                                    Product Code
                                </th>
                                <th class="name">
                                    Product Name
                                </th>
                                <th class="name">
                                    Category
                                </th>
                                <th class="name">
                                    Ingredients
                                </th>
                                <th class="name">
                                    Dosage
                                </th>
                                <th class="name">
                                    Anupana
                                </th>
                                <th class="name">
                                    Indication
                                </th>
                                <th class="name">
                                    Reference
                                </th>
                                <th class="edit">
                                    Edit
                                </th>
                                <th class="delete">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('#product_info').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "serverSide": true,
            "stateSave": true,
            "aoColumns": [
                {mData: 'productCode'},
                {mData: 'productName'},
                {mData: 'category'},
                {mData: 'ingredients'},
                {mData: 'dosage'},
                {mData: 'anupana'},                
                {mData: 'indication'},                
                {mData: 'reference'},                
                {mData: 'edit', "bSortable": false},
                {mData: 'delete', "bSortable": false},
            ],
            "ajax": {
                "url": base_url + "listcontrol/json_product_info",
            }
        });
    });
</script>
