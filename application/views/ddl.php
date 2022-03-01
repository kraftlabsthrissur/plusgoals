<?php 
echo "<select name='ddlCategory' id='ddlcategory' class='form-control' >";
	foreach($dbarray as $result)
	{
		echo "<option value='".$result."'>".$result."</option>";
	}
	echo "</select>";
?>