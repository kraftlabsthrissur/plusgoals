
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/stockreg.css"/>
<section class="content-header">
    <h1>
        Change Password
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#user/profile"><i class="fa fa-laptop"></i> Profile</a></li>
        <li class="active">Change Password</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Change Password</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form name="userData" method="post" class="ajax-submit" action="common/changePasswd">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Current Password
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="password" id="" class="required form-control" name="txtCurrentPasswd"  />
                                        <?php echo @$error['txtCurrentPasswd']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        New Password 
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="password" name="txtNewPasswd" class="form-control" />
                                        <?php echo @$error['txtNewPasswd']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Confirm Password 
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="password" name="txtConfirmPasswd" class="form-control" />
                                        <?php echo @$error['txtConfirmPasswd']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">

                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
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