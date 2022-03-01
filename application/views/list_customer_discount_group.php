<section class="content-header">
	<h1>
		Customer Discout Group <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Customer Discout Group</li>
	</ol>
</section>

<!-- Main content -->
<section id="content" class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="col-xs-7">
						<h3 class="box-title">Customer Discout Groups</h3>
					</div>

				</div>
				<!-- /.box-header -->
				<div id="main_content">
					<h4><?php echo ($this->session->flashdata('item')); ?></h4>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<form action="xml/import_customer_discount_group" class="ajax-form" method="post"
							enctype="multipart/form-data">

							<div class="col-xs-4">
								<input type="file" name="xml" class="form-control">
							</div>
							<div class="col-xs-4">
								<input type="submit" name="submit" class="btn btn-default"
									value="Upload XML">
							</div>
							<div class="col-xs-4">
								<!-- div class="pull-right">
									<a href="#admin/add_customer" class="btn btn-primary"> <i
										class="fa fa-pencil"> Add New Customer</i>
									</a>
								</div-->
							</div>
						</form>
					</div>
				</div>
				<div class="box-body table-responsive">
					<table id="customers"
						class="table table-striped table-bordered table-hover">
						<thead>
							<!--thead-->
							<tr>
								<th>Code</th>
								<th>Description</th>
								<th>Delete</th>
							</tr>						
						<thead>
						<tbody>
						
                            <?php
																												
																												if($rows){
																													foreach($rows as $row){
																														?>
																														
                            	<tr>
								<td><?php echo $row['code'];?></td>
								<td><?php echo $row['description'];?></td>
								<td><a
									href="#admin/delete_customer_discount_group/<?php echo $row['customer_discount_group_id'];?>"
									onclick="return confirm('Are you want to delete this customer discout group?');">Delete</a>
								</td>
							</tr>
                            	
                            	<?php
																													}
																												}
																												?>
																												
																												
                        </tbody>
					</table>
				</div>
			</div>
			<!--subcontent-->
		</div>
	</div>

</section>

<script type="text/javascript">
    $(function () {
        $('#customers').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>
