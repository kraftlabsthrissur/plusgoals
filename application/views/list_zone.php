<section class="content-header">
    <h1>
        Zone
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Zone</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Zones</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#admin/add_zone">
                            <button class="btn btn-primary" >
                                <i class="fa fa-pencil"> Add New Zone</i>
                            </button>
                        </a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="zones" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Zone Code
                                </th>
                                <th>
                                    Zone
                                </th>
                                <th>
                                    Branch
                                </th>
                                <th>
                                    Edit
                                </th>
                                <th>
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($zoneArray->num_rows() > 0) {
                                foreach ($zoneArray->result() as $row) {
                                    echo '<tr>
                                                <td>
                                                        ' . $row->zmCode . '
                                                </td>
                                                <td>
                                                        ' . $row->zmZoneName . '
                                                </td>
                                                <td>
                                                        ' . $row->bmBranchName . '
                                                </td>
                                                <td>
                                                        <a id="' . $row->zmId . '" href="' . base_url() . '#listcontrol/edit_zone/' . $row->zmId . '">Edit</a>
                                                </td>
                                                <td>
                                                        <a id="' . $row->zmId . '" href="' . base_url() . '#admin/delete_zone/' . $row->zmId . '" onClick="return confirm(\'Are you want to delete this zone?\');">Delete</a>
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
        $('#zones').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>