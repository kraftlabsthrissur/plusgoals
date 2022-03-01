<section class="content-header">
    <h1>
        Area
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Area</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Areas</h3>
                    </div>
                    <div class="box-tools pull-right">
                        
                    </div>
                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                 <div class="row">
					<div class="col-xs-12">
						<form action="xml/import_area" class="ajax-form" method="post"
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
									<a href="#admin/add_area"> <button class="btn btn-primary" data-widget="collapse"><i class="fa fa-pencil"> Add New Area</i></button></a>
								</div>
							</div>
						
					</div>
				</div>
                
                <div class="box-body table-responsive">
                    <table id="areas" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Area Code
                                </th>
                                <th>
                                    Area Name
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
                            if ($areaArray->num_rows() > 0) {
                                foreach ($areaArray->result() as $row) {
                                    echo '<tr>
                                                <td>
                                                        ' . $row->amCode . '
                                                </td>
                                                <td>
                                                        ' . $row->amAreaName . '
                                                </td>
                                                <td>
                                                        <a href="' . base_url() . '#listcontrol/edit_area/' . $row->amId . '">Edit</a>
                                                </td>
                                                <td>
                                                        <a id="' . $row->amId . '" href="' . base_url() . '#admin/delete_area/' . $row->amId . '" onClick="return confirm(\'Are you want to delete this area?\');">Delete</a>
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
        $('#areas').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>
