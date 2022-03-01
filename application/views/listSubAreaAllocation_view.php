<?php
$this->load->view('includes/header');
?>
<?php
$this->load->view('includes/menu');
?>
			<div id="content">
				<div id="main_content">
					<h2><?php echo ($this->session->flashdata('item'));?></h2>
					<h2>Sub Area List</h2>
					<?php echo form_open('listcontrol/showsubArea');?>
						<div id="divsubArea" style="margin:30px 10px;">
							<table border="1" style="border-collapse:collapse;">
								<tr>
									<th>
										Sub-Area Id
									</th>
									<th>
										Sub-Area Name
									</th>
									<th>
										Edit
									</th>
									<th>
										Delete
									</th>
								</tr>
								<?php 
								if ($subAreaArray->num_rows() > 0)
								{
									foreach($subAreaArray->result() as $row)
									{
										echo '<tr>
												<td>
													'.$row->saId.'
												</td>
												<td>
													'.$row->saSubAreaName.'
												</td>
												<td>
													<a href="'.base_url().'index.php/listcontrol/subAreaEdit/'.$row->saId.'">Edit</a>
												</td>
												<td>
													<a id="'.$row->saId.'" href="'.base_url().'index.php/listcontrol/subAreaDelete/'.$row->saId.'" onClick="return confirm(\'Are you want to delete this Sub-Area?\');">Delete</a>
												</td>
											</tr>';
									}
								}
								?>
							</table>
						</div>
					<?php echo form_close();?>
					<div>
						<a href="<?php echo base_url();?>/index.php/admin/subAreaForRep">Back</a>
					</div>
				</div>
			</div>



<?php
$this->load->view('includes/footer');
 ?>