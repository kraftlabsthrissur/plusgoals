<section class="content-header">
	<h1>
		Sale Price <small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Sale Price</li>
	</ol>
</section>

<!-- Main content -->
<section id="content" class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="col-xs-7">
						<h3 class="box-title">Sale Price</h3>
					</div>

				</div>
				<!-- /.box-header -->
				<div id="main_content">
					<h4><?php echo ($this->session->flashdata('item')); ?></h4>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<form action="xml/import_sales_price" class="ajax-form"
							method="post" enctype="multipart/form-data">

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
								</div -->
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
								<th>Item No</th>
								<th>Sales Type</th>
								<th>Sales Code</th>
								<th>Starting Date</th>
								<th>Currency Code</th>
								<th>Variant Code</th>
								<th>UOM</th>
								<th>Minimum Quantity</th>
								<th>Unit Price</th>
								<th>MRP</th>
								<th>Delete</th>
							</tr>
						
						
						<thead>
						
						
						<tbody>
                             <?php
																													
																													if($rows){
																														foreach($rows as $row){
																															?>
																														
                            	<tr>
								<td><?php echo $row['item_no'];?></td>
								<td><?php echo $row['sales_type'];?></td>
								<td><?php echo $row['sales_code'];?></td>
								<td><?php echo $row['starting_date'];?></td>
								<td><?php echo $row['currency_code'];?></td>
								<td><?php echo $row['variant_code'];?></td>
								<td><?php echo $row['uom'];?></td>
								<td><?php echo $row['minimum_quantity'];?></td>
								<td><?php echo $row['unit_price'];?></td>
								<td><?php echo $row['mrp_price'];?></td>
								<td><a
									href="#admin/delete_sales_price/<?php echo $row['sales_price_id'];?>"
									onclick="return confirm('Are you want to delete this sale price ?');">Delete</a>
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
