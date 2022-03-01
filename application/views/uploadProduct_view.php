
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/uploadproduct.css"/>
<script type="text/javascript">
    function btnDeleteAll_Click()
    {
        if (confirm("Do you want to delete all the product details!!!"))
        {
            $("#btnDeleteAll").attr("href", "<?php echo base_url(); ?>index.php/admin/deleteAllProducts");
        }
    }
</script>

<div class="span10">
    <div id="content" class="well">
        <div id="main_content">
            <h2>Upload Product List</h2>
        </div>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <div id="subcontent">
            <div id="tablecontent" class="well">
                <?php echo form_open_multipart('upload/do_upload'); ?>
                <div class="table1">
                    <table>
                        <tr>
                            <td class="click muted">
                                To Delete all products details:				
                                <a href="#" id="btnDeleteAll" onclick="btnDeleteAll_Click();">Click here</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="table2">
                    <table>
                        <tr>
                            <td>
                                Branch		 :
                            </td>
                            <td>
                                Thrissur
                            </td>
                        </tr>

                        <tr>
                            <td>
                                File Name:
                            </td>
                            <td>
                                <input type="file" name="userfile" size="20" />
                            </td>
                        </tr>
                        <tr>
                            <td class="button">
                                <input type="submit" Value="Upload" class="btn btn-primary"/>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>#listcontrol/show_products"class="linkButton btn btn-small btn-primary" >Cancel</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</div>


