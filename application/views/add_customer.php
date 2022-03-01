<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Customer
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_customers"><i class="fa fa-laptop"></i> Customers</a></li>
        <li class="active"><?php echo $edit_mode ? "Edit" : "Add"; ?> Customer</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Customer</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form name="userData" method="post" class="ajax-submit" action="admin/add_customer">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Customer Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="smStoreCode" class="required form-control" name="smStoreCode" value="<?php echo @$store_details['smStoreCode']; ?>" />
                                        <?php echo @$error['smStoreCode']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                      Customer Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="smStoreName" class="required form-control" name="smStoreName" value="<?php echo @$store_details['smStoreName']; ?>" />
                                        <?php echo @$error['smStoreName']; ?>

                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Address 1
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="smAddress1" class="required form-control" cols="20" rows="2" ><?php echo @$store_details['smAddress1']; ?></textarea>
                                        <?php echo @$error['smAddress1']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Address 2
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="smAddress2" class="required form-control" cols="20" rows="2" ><?php echo @$store_details['smAddress2']; ?></textarea>
                                        <?php echo @$error['smAddress2']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        City
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="smCity" class="form-control" value="<?php echo @$store_details['smCity']; ?>"/>
                                        <?php echo @$error['smCity']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        State
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="smState" class="form-control" value="<?php echo @$store_details['smState']; ?>"  />
                                        <?php echo @$error['smState']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Country
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="smCountry" class="form-control" value="<?php echo @$store_details['smCountry']; ?>"/>
                                        <?php echo @$error['smCountry']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Pin Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="smPin" maxlength="6" class="form-control" value="<?php echo @$store_details['smPin']; ?>"/>
                                        <?php echo @$error['smPin']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Phone 1
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="smPhone1" maxlength="14" class="form-control" value="<?php echo @$store_details['smPhone1']; ?>"/>
                                        <?php echo @$error['umPhone1']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Phone 2
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="smPhone2" maxlength="14" class="form-control" value="<?php echo @$store_details['smPhone2']; ?>"/>
                                        <?php echo @$error['smPhone2']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                    Customer Type
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="customer_group" class="form-control" ><?php echo @$types; ?></select>
                                        
                                    </div>
                                    <div class="col-xs-2">
                                        Email
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="smEmail" class="form-control" value="<?php echo @$store_details['smEmail']; ?>"/>
                                        <?php echo @$error['smEmail']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Is Active
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="checkbox" name="smIsActive"  value="1" <?php echo isset($store_details['smIsActive']) ? (($store_details['smIsActive'] === "1") ? 'checked' : '' ) : 'checked'; ?> />
                                    </div>
                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="smId" Value="<?php echo @$store_details['smId']; ?>"/>
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




