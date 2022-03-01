
<script type="text/javascript">

    function setStoreMaster() {
        $("#storeList tr").click(function () {
            $("#storeList tr").removeClass("selected");
            $(this).addClass("selected");
        }
        );
        $("#storeList tr").dblclick(function () {
            if ($("#storeResult .selected").length > 0)
            {
                $("#hid_txtStore").val($("#storeResult .selected input").val());
                $("#txtStores").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            $("#storeMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
        });
    }

    function setStoreList(type, searchString) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/admin/getStoreMaster/" + type + "/" + searchString + "/" + 0,
            success: function (message) {
                $("#storeResult").html("");
                $("#storeResult").html(message);
                setStoreMaster();
            }
        });
    }

    $(function () {

        setStoreMaster();
        $("#viewStore").on('click', function () {
            $("#storeMaster").slideDown(500);
            return false;
        });

        $("#storeSearch").click(function () {
            var type = "store";
            var searchString = "";
            if ($("#storeValue").val().trim() != "") {
                searchString = $("#storeValue").val();
            }
            else if ($("#codeValue").val().trim() != "") {
                type = "code";
                searchString = $("#codeValue").val();
            }
            else {
                alert("Please erter a value.");
                return false;
            }
            setStoreList(type, searchString);
        });
        String.prototype.ltrim = function () {
            return this.replace(/^\s+/, "");
        }
        String.prototype.rtrim = function () {
            return this.replace(/\s+$/, "");
        }
        $("#storeSelect").click(function () {
            if ($("#storeResult .selected").length > 0)
            {
                $("#hid_txtStore").val($("#storeResult .selected input").val());
                $("#txtStores").val($("#storeResult .selected td.first").text().ltrim().rtrim());
                $("#hid_Code").val($("#storeResult .selected td.second").text().ltrim().rtrim());
            }
            $("#storeMaster").slideUp(500);
        });
        $("#storeClose").click(function () {
            $("#storeMaster").slideUp(500);
        });
    });

</script>
<section class="content-header">

    <h1>
        <?php echo $edit_mode === TRUE ? "Edit" : "Create"; ?> User
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#listcontrol/show_users"><i class="fa fa-laptop"></i> Users</a></li>
        <li class="active">
            <?php echo $edit_mode === TRUE ? "Edit" : "Create"; ?> User</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"><?php echo $edit_mode ? "Edit" : "Create"; ?> User</h3>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form name="userData" method="post" class="ajax-submit" action="admin/create_user">
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        User Name 
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" id="txtUname" class="required form-control" name="umUserName" value="<?php echo @$user_details['umUserName']; ?>" />
                                        <span class="required"><?php echo @$error['umUserName']; ?></span>
                                    </div>
                                    <div class="col-xs-2">
                                        Password
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="password" id="password" name="umPassword" class="required form-control" <?php echo $edit_mode ? "disabled" : ""; ?> />
                                            <?php if ($edit_mode) { ?>
                                                <span class="input-group-btn">
                                                    <button id="edit-password" class="btn btn-info btn-flat" type="button">Edit</button>
                                                </span>
                                            <?php } ?>
                                        </div>
                                        <span class="required"><?php echo @$error['umPassword']; ?></span>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Prefix
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="umPrefix" class="form-control">
                                            <option value="Mr." <?php echo isset($user_details['umPrefix']) && $user_details['umPrefix'] === 'Mr.' ? 'selected' : ''; ?> >Mr.</option>
                                            <option value="Mrs." <?php echo isset($user_details['umPrefix']) && $user_details['umPrefix'] === 'Mrs.' ? 'selected' : ''; ?> >Mrs.</option>
                                            <option value="Miss." <?php echo isset($user_details['umPrefix']) && $user_details['umPrefix'] === 'Miss.' ? 'selected' : ''; ?> >Miss.</option>
                                        </select>
                                        <?php echo @$error['umPrefix']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        UserCode
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="txtUserCode" name="umUserCode" class="required form-control" value="<?php echo @$user_details['umUserCode']; ?>"/> 
                                        <span class="required"><?php echo @$error['umUserCode']; ?></span>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        First Name
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umFirstName" class="required form-control" value="<?php echo @$user_details['umFirstName']; ?>"/>
                                        <span class="required"><?php echo @$error['umFirstName']; ?></span>
                                    </div>
                                    <div class="col-xs-2">
                                        Last Name
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umLastName" class="required form-control" value="<?php echo @$user_details['umLastName']; ?>"/>
                                        <span class="required"><?php echo @$error['umLastName']; ?></span>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Address1
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="umAddress1" class="required form-control" cols="20" rows="2" ><?php echo @$user_details['umAddress1']; ?></textarea>
                                        <span class="required"><?php echo @$error['umAddress1']; ?></span>
                                    </div>
                                    <div class="col-xs-2">
                                        Address2
                                    </div>
                                    <div class="col-xs-4">
                                        <textarea name="umAddress2" class="form-control" cols="20" rows="2" ><?php echo @$user_details['umAddress2']; ?></textarea>
                                        <?php echo @$error['umAddress2']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        City
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umCity" class="form-control" value="<?php echo @$user_details['umCity']; ?>"/>
                                        <?php echo @$error['umCity']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        State
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umState" class="form-control" value="<?php echo @$user_details['umState']; ?>"  />
                                        <?php echo @$error['umState']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Country
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umCountry" class="form-control" value="<?php echo @$user_details['umCountry']; ?>"/>
                                        <?php echo @$error['umCountry']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Pin Code
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umPin" maxlength="6" class="form-control" value="<?php echo @$user_details['umPin']; ?>"/>
                                        <?php echo @$error['umPin']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Residence Ph:
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umPhone1" maxlength="14" class="form-control" value="<?php echo @$user_details['umPhone1']; ?>"/>
                                        <?php echo @$error['umPhone1']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Office Ph:
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umPhone2" maxlength="14" class="form-control" value="<?php echo @$user_details['umPhone2']; ?>"/>
                                        <?php echo @$error['umPhone2']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Mobile
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umPhone3" maxlength="14" class="form-control" value="<?php echo @$user_details['umPhone3']; ?>"/>
                                        <?php echo @$error['umPhone3']; ?>
                                    </div>
                                    <div class="col-xs-2">
                                        Email
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" name="umEmail" class="form-control" value="<?php echo @$user_details['umEmail']; ?>"/>
                                        <?php echo @$error['umEmail']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <!-- <div class="col-xs-2">
                                        Store
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" name="store_name" id="txtStores" readonly value="<?php echo @$user_details['store_name']; ?>" />
                                            <input type="hidden" name="umStoreId" id="hid_txtStore" value="<?php echo @$user_details['umStoreId']; ?>"/>
                                            <input type="hidden" id="hid_Code" name="hid_Code" value="<?php echo @$user_details['hid_Code']; ?>" />
                                            <span class="input-group-btn">
                                                <button id="viewStore" class="btn btn-info btn-flat" type="button">View Store</button>
                                            </span>
                                        </div>
                                        <?php echo @$error['store_name']; ?>

                                    </div> -->
                                    <div class="col-xs-2">
                                        User Type
                                    </div>
                                    <div class="col-xs-4">
                                        <!-- <select name="user_type" class="form-control">
                                            <option value="sales_representative" <?php echo isset($user_details['umIsSalesRep']) && $user_details['umIsSalesRep'] == 1 ? 'selected' : ''; ?> >Sales Representative</option>
                                            <option value="h.o.user" <?php echo isset($user_details['umIsHOUser']) && $user_details['umIsHOUser'] == 1 ? 'selected' : ''; ?> >H.O User</option>
                                            <option value="area_manager" <?php echo isset($user_details['umIsManager']) && $user_details['umIsManager'] == 1 ? 'selected' : ''; ?> >Area Manager</option>
                                        </select> -->
                                            
                                                <select class="form-control" name="role_id">
                                                    <?php echo $user_roles; ?>
                                                </select>
                                           
                                        <?php echo @$error['role_id']; ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                        Is Active
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="checkbox" name="umIsActive"  value="1" <?php echo isset($user_details['umIsActive']) ? (($user_details['umIsActive'] === "1") ? 'checked' : '' ) : 'checked'; ?> />
                                    </div>
                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"  name="btnSave" Value="Save"/>
                                        <input type="reset" class="btn btn-warning" name="btnreset" Value="Reset"/>
                                        <input type="hidden" class="btn btn-warning" name="umId" Value="<?php echo @$user_details['umId']; ?>"/>
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

<div class="modal fade in" id="storeMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Stores</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" id="storeList"> 
                            <table cellpadding="0" cellspacing="0" id="storeResult" class="table  table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>Store Name</td>
                                        <td>Store Code</td>
                                    </tr>
                                </thead>  
                                <tbody>
                                    <?php
                                    if ($storeArray->num_rows() > 0) {
                                        foreach ($storeArray->result() as $row) {
                                            ?>
                                            <tr>
                                                <td class="first">
                                                    <?php echo $row->smStoreName; ?>
                                                    <input type="hidden" value="<?php echo $row->smId; ?>">
                                                </td>
                                                <td class="second"><?php echo $row->smStorecode; ?></td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left" id="storeSelect" >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#right-content').on('click', '.modal .close, .modal .close-btn', function () {
        $('.modal').slideUp(800);
    });
    $(function () {
        $('#storeResult').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });
</script>