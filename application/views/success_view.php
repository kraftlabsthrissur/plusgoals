<?php
$this->load->view('includes/header');
?>
<?php
$this->load->view('includes/menu');
?>
			<div id="content">
				<div id="main_content">
					<div>
						<h2>
							<?php 
								if($methodeType == "add") {
									echo "Added new ";
								}
								else if($methodeType == "update") {
									echo "Updated ";
								}
								else if($methodeType == "delete") {
									echo "Deleted ";
								}
								echo $module;
								echo " successfully.";
							?>
						</h2>
					</div>
					<div>
						<p>
							Your datas are successfully saved.
						</p>
					</div>
				</div>
			</div>



<?php
$this->load->view('includes/footer');
 ?>