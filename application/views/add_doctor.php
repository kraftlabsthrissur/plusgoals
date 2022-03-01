<section class="content-header">

    <h1>
        <?php echo $edit_mode === TRUE ? "Edit" : "Create"; ?> Doctor
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_doctors"><i class="fa fa-laptop"></i> Doctors</a></li>
        <li class="active">
            <?php echo $edit_mode === TRUE ? "Edit" : "Create"; ?> Doctor</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Create"; ?> Doctor</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form name="DoctorData" method="post" class="ajax-submit" action="admin/create_doctor">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Doctor Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="txtUname" class="required form-control" name="dmDoctorName" value="<?php echo @$doctor_details['dmDoctorName']; ?>" />
                                        <?php echo @$error['dmDoctorName']; ?>
                                    </div>
                              
                                    <div class="col-xs-2">
                                        Doctor Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="txtDoctorCode" name="dmDoctorCode" class="required form-control" value="<?php echo @$doctor_details['dmDoctorCode']; ?>"/> 
                                        <?php echo @$error['dmDoctorCode']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Address
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="dmAddress" class="required form-control" cols="20" rows="2" ><?php echo @$doctor_details['dmAddress']; ?></textarea>
                                        <?php echo @$error['dmAddress']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Street
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmStreet" class="form-control" value="<?php echo @$doctor_details['dmStreet']; ?>"/>
                                        <?php echo @$error['dmStreet']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Place
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmPlace" class="form-control" value="<?php echo @$doctor_details['dmPlace']; ?>"/>
                                        <?php echo @$error['dmPlace']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        City
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmCity" class="form-control" value="<?php echo @$doctor_details['dmCity']; ?>"/>
                                        <?php echo @$error['dmCity']; ?>
                                    </div>
                                   
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        District
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmDistrict" class="form-control" value="<?php echo @$doctor_details['dmDistrict']; ?>"  />
                                        <?php echo @$error['dmDistrict']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        State
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmState" class="form-control" value="<?php echo @$doctor_details['dmState']; ?>"  />
                                        <?php echo @$error['dmState']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Mobile
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmMobile" maxlength="14" class="form-control" value="<?php echo @$doctor_details['dmMobile']; ?>"/>
                                        <?php echo @$error['dmMobile']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Phone
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmPhone" maxlength="14" class="form-control" value="<?php echo @$doctor_details['dmPhone']; ?>"/>
                                        <?php echo @$error['dmPhone']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Qualification
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmQualification" maxlength="14" class="form-control" value="<?php echo @$doctor_details['dmQualification']; ?>"/>
                                        <?php echo @$error['dmQualification']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        RepName
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="dmRepName" maxlength="14" class="form-control" value="<?php echo @$doctor_details['dmRepName']; ?>"/>
                                        <?php echo @$error['dmRepName']; ?>
                                    </div>
                                </div>
                                <br/>
                               <div class="row">
                                    <div class="col-xs-2">
                                        Is Active
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="checkbox" name="dmIsActive"  value="" <?php echo isset($doctor_details['dmIsActive']) ? (($doctor_details['dmIsActive'] === "1") ? 'checked' : '' ) : 'checked'; ?> />
                                    </div>
                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <?php if($edit_mode === TRUE){?>
                                        <input type="hidden" class="btn btn-warning" name="dmid" Value="<?php echo @$doctor_details['dmid']; ?>"/>
                                        <?php } ?>
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



<script type="text/javascript">

</script>