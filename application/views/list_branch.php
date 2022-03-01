<section class="content-header">
    <h1>
        Branches
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Branches</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Branches</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#admin/add_branch"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Branch</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="branches" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="code">
                                    Branch Code
                                </th>
                                <th class="name">
                                    Branch Name
                                </th>
                                <th class="edit">
                                    Edit
                                </th>
                                <th class="delete">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($branchArray->num_rows() > 0) {
                                foreach ($branchArray->result() as $row) {
                                    echo '<tr>
                                                <td>
                                                        ' . $row->bmBranchCode . '
                                                </td>
                                                <td>
                                                        ' . $row->bmBranchName . '
                                                </td>
                                                <td>
                                                        <a href="' . base_url() . '#listcontrol/edit_branch/' . $row->bmBranchID . '">Edit</a>
                                                </td>
                                                <td>
                                                        <a id="' . $row->bmBranchID . '" href="' . base_url() . '#admin/delete_branch/' . $row->bmBranchID . '" onClick="return confirm(\'Are you want to delete this branch?\');">Delete</a>
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
