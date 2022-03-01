<?php
$this->load->view('includes/report_header');
?>
<style type="text/css">
	th{
		width:160px;
	}
	td{
		width: 160px;
		text-align: center;
	}
</style>

<div id="report_content">
	<div id="rep_inner_content">
		<div id="row_title">
			<table>
				<tr>
					<th>column1</th>
					<th>column2</th>
					<th>column3</th>
					<th>column4</th>
					<th>column5</th>
				</tr>
				<?php
					for($i=0;$i<50;$i++)
					{
					?>
				<tr>
					<td>value1</td>
					<td>value2</td>
					<td>value3</td>
					<td>value4</td>
					<td>value5</td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>
		<div>
		</div>
	</div>
</div>
<?php
$this->load->view('includes/report_footer');
?>
