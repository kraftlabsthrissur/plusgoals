<?php
$this->load->view('includes/header');
?>
<script type="text/javascript">
	function getContent()
	{
		$.ajax({
		  url: "<?php echo base_url(); ?>index.php/admin/test",
		  success: function(message){
			$("#main_content").html("");
			$("#main_content").html(message);
		  }
		});
	}
</script>
<?php
$this->load->view('includes/menu');
?>
		<div class ="span10">
			<div id="content" class="well">
				<!--a href="javascript:getContent()">Get Content</a-->
					<div id="main_content">
						
						
						<h2><?php echo ($this->session->flashdata('item'));?></h2>
						<p style="clear:both;margin:0px 0px 0px 25px;">OrderWala helps you send instant orders in an easy way.</p>
					</div>
				<!--div>
					
				</div-->
			</div>
		</div><!--span10-->
		

<?php
$this->load->view('includes/footer');
 ?>