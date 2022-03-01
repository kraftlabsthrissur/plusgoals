<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/listsubarea.css"/>
<section class="content-header">
    <h1>
        Sub Area for Representative Master
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sub Area List</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Subareas</h3>
                    </div>
                    <div class="box-tools pull-right">
                        <a href="#admin/sub_area_for_rep"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Subarea</i></button></a>
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <table id="subareas" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="id">
                                    Sub-Area Id
                                </th>
                                <th class="name">
                                    Sub-Area Name
                                </th>
                                <th>
                                    Edit
                                </th>
                                <th class="delete">
                                    Delete
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($subAreaArray->num_rows() > 0) {
                                foreach ($subAreaArray->result() as $row) {
                                    echo '<tr>
                                                <td>
                                                        ' . $row->saId . '
                                                </td>
                                                <td>
                                                        ' . $row->saSubAreaName . '
                                                </td>
                                                <td>
                                                        <a href="' . base_url() . '#listcontrol/edit_sub_area/' . $row->saId . '">Edit</a>
                                                </td>
                                                <td>
                                                        <a id="' . $row->saId . '" href="' . base_url() . '#admin/delete_sub_area/' . $row->saId . '" onClick="return confirm(\'Are you want to delete this Sub-Area?\');">Delete</a>
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
        $('#subareas').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>