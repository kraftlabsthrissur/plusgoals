<section class="content-header">
    <h1>
        Categories
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Categories</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Categories</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#admin/add_category"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Category</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="branches" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                
                                <th class="name">
                                    Category Name
                                </th>
                                <th class="name">
                                    Number of Products
                                </th>
                                <th class="edit">
                                    Edit
                                </th>
                                <th class="edit">
                                    Delete
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($categories > 0) {
                                foreach ($categories as $row) {
                                    echo '<tr>
                                                <td>
                                                        ' . $row['category'] . '
                                                </td>
                                                <td>
                                                        ' . $row['number_of_products'] . '
                                                </td>
                                                <td>
                                                        <a href="' . base_url() . '#admin/edit_category/' . $row['category'] . '">Edit</a>
                                                </td>
                                                <td>
                                                        <a id="' . $row['category'] . '" href="' . base_url() . '#admin/delete_category/' . $row['category'] . '" onClick="return confirm(\'Are you want to delete this category?\');">Delete</a>
                                                </td>
                                        </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('#branches').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>
