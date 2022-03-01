<script type="text/javascript">
    $(function () {
        $("#txtMrp").keydown(function (event) {

            var keyCodeEntered = (event.which) ? event.which : (window.event.keyCode) ? window.event.keyCode : -1;
            // Allow: backspace, delete, tab and escape
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
                    // Allow: Ctrl+A
                            (event.keyCode == 65 && event.ctrlKey === true) ||
                            // Allow: home, end, left, right
                                    (event.keyCode >= 35 && event.keyCode <= 39) ||
                                    (keyCodeEntered == 110))
                    {
                        // let it happen, don't do anything
                        return;
                    }
                    else {
                        // Ensure that it is a number and stop the keypress
                        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                            event.preventDefault();
                        }
                    }
                });
    });
</script>
<section class="content-header">
    <h1>
        Add Product
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_products"><i class="fa fa-laptop"></i> Products</a></li>
        <li class="active">Add Product</li>
    </ol>
</section>


<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Product</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    
                    <form name="userData" method="post" class="ajax-submit" action="admin/add_product">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Product Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="pmProductCode" class="required form-control" name="pmProductCode" value="<?php echo @$product_details['pmProductCode']; ?>" />
                                        <?php echo @$error['pmProductCode']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Product Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="pmProductName" class="form-control" value="<?php echo @$product_details['pmProductName']; ?>"/>
                                        <?php echo @$error['pmProductName']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Packing Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="packingCode" class="form-control" value="<?php echo isset($product_details['packingCode'])?str_pad(@$product_details['packingCode'], 4, '0', STR_PAD_LEFT):''; ?>"/>
                                        <?php echo @$error['packingCode']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Inside Kerala Price
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="insideKeralaPrice"  class="form-control" value="<?php echo @$product_details['insideKeralaPrice']; ?>"/>
                                        <?php echo @$error['insideKeralaPrice']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Outside Kerala Price
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="outsideKeralaPrice"  class="form-control" value="<?php echo @$product_details['outsideKeralaPrice']; ?>"/>
                                        <?php echo @$error['outsideKeralaPrice']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Category
                                    </div>
                                    <div class="col-xs-4">
                                        <?php echo form_dropdown('pmCategory', $dbArray, isset($product_details['pmCategory']) ? $product_details['pmCategory'] : '', 'id="ddlcategory" class="form-control"'); ?>
                                        <?php echo @$error['pmCategory']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Division
                                    </div>
                                    <div class="col-xs-4">
                                        <?php echo form_dropdown('pmDivisionCode', $divisionArray, isset($product_details['pmDivisionCode']) ? $product_details['pmDivisionCode'] : '', 'id="ddlDivision" class="form-control"'); ?>
                                        <?php echo @$error['pmDivisionCode']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Description
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="pmDescription" class="required form-control" cols="20" rows="2" ><?php echo @$product_details['pmDescription']; ?></textarea>
                                        <?php echo @$error['pmDescription']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="pmProductId" Value="<?php echo @$product_details['pmProductId']; ?>"/>
                                    </div>
                                </div>
                                <br/>
                            </div>
                        </div>                     
                    </form>
                </div><!--tablecontent-->
            </div><!--subcontent-->
        </div>
    </div>
</section>

