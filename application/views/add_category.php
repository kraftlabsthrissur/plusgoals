<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/branchmaster.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/Masters.css"/>
<section class="content-header">
    <h1>
        <?php echo $edit_mode ? "Edit" : "Add"; ?> Category
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#admin/show_categories"><i class="fa fa-laptop"></i> Categories</a></li>
        <li class="active"><?php echo $edit_mode ? "Edit" : "Add"; ?> Category</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Add"; ?> Category</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form name="userData" method="post" class="ajax-submit" action="admin/add_category">
                        <div class="row">
                            <div class="col-xs-10">
                               
                                <div class="row">
                                    <div class="col-xs-2">
                                        Category Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="category" class="form-control" value="<?php echo @$form_data['category']; ?>"/>
                                        <?php echo @$error['category']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="old_category" Value="<?php echo @$form_data['old_category']; ?>"/>
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
