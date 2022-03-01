<section class="content-header">
    <h1>
        Divisions
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Divisions</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Divisions</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#admin/add_division"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Division</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="divisions" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="first">
                                    Division Code
                                </th>
                                <th class="second">
                                    Division Name
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
                            if ($divisionArray->num_rows() > 0) {
                                foreach ($divisionArray->result() as $row) {
                                    echo '<tr>
                                                <td>
                                                        ' . $row->dmCode . '
                                                </td>
                                                <td>
                                                        ' . $row->dmDivisionName . '
                                                </td>
                                                <td>
                                                        <a href="' . base_url() . '#listcontrol/edit_division/' . $row->dmId . '">Edit</a>
                                                </td>
                                                <td>
                                                        <a id="' . $row->dmId . '" href="' . base_url() . '#admin/delete_division/' . $row->dmId . '" onClick="return confirm(\'Are you want to delete this division?\');">Delete</a>
                                                </td>
                                        </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div><!--tablecontent-->
            </div><!--subcontent-->
        </div>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        $('#divisions').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>
