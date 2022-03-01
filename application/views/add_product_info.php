<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/branchmaster.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/Masters.css"/>
<section class="content-header">
    <h1>
        Add Product Info
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_product_info"><i class="fa fa-laptop"></i> Product Info</a></li>
        <li class="active">Add Product Info</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Product Info</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form name="userData" method="post" class="ajax-submit" action="listcontrol/add_product_info">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Product Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="" class="form-control" name="productCode" value="<?php echo @$product_info['productCode']; ?>" />
                                        <?php echo @$error['productCode']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Product Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="productName" class="form-control" value="<?php echo @$product_info['productName']; ?>"/>
                                        <?php echo @$error['productName']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Category
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="category" class="form-control">
                                        <?php echo @$categories; ?>    
                                        </select>
                                        
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Ingredients
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="ingredients" class="form-control" ><?php echo @$product_info['ingredients']; ?></textarea>
                                        <?php echo @$error['ingredients']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Dosage
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="dosage" class="form-control" ><?php echo @$product_info['dosage']; ?></textarea>
                                        <?php echo @$error['dosage']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Anupana
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="anupana" class="form-control" ><?php echo @$product_info['anupana']; ?></textarea>
                                        <?php echo @$error['anupana']; ?>
                                    </div>

                                </div>
                                 <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Indication
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="indication" class="form-control" ><?php echo @$product_info['indication']; ?></textarea>
                                        <?php echo @$error['indication']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Reference
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="reference" class="form-control" ><?php echo @$product_info['reference']; ?></textarea>
                                        <?php echo @$error['reference']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="productId" Value="<?php echo @$product_info['productId']; ?>"/>
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
