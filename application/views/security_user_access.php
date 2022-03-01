
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/securityuser.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/storemaster.css"/>
<script type="text/javascript">
    $(function () {
        $("#divRadio").hide();
        $(".divHOForm").hide();
        $(".divcommonUserForm").hide();
        $("#SettingsNav").hide();
        $("#AdminNav").hide();
        $("#MasterNav").hide();
        $("#AllocationNav").hide();
        $("#SONav").hide();
        $("#txtSelectedForm").attr("readonly", "readonly");
        $("#txtUser").attr("readonly", "readonly");
        $("#btnLevel").click(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/admin/getLevelList",
                success: function (message) {
                    $("#levelList").html(message);
                    $("#levelMaster").slideDown(500);
                }
            });
        });

        $("#btnSelectUser").click(function () {
            var userType = usertypeChange();
            if (userType != '') {
                $("#userNameValue").val("");
                $("#userCodeValue").val("");
                setUserList('all', '');
                $("#userSelectMaster").slideDown(500);
                return false;
            }
            else
            {
                alert("Please select UserType First");
            }
        });
        $("#userSearch").click(function () {
            var searchString = "";
            var type = "";
            if ($("#userNameValue").val().trim() != "") {
                searchString = $("#userNameValue").val();
                type = "Name";
            }
            else if ($("#userCodeValue").val().trim() != "") {
                searchString = $("#userCodeValue").val();
                type = "Code";
            }
            else {
                type = "all";
                searchString = '';
            }
            setUserList(type, searchString);
        });
        $("#userSelect").click(function () {
            if ($("#userResult .selected").length > 0)
            {
                $("#hid_userId").val($("#userResult .selected input").val());
                $("#txtUser").val($("#userResult .selected td.first").text().ltrim().rtrim());
            }
            $("#userSelectMaster").slideUp(500);
        });

        $("#btnSave").click(function () {
            if ($("#txtSelectedForm").val() == "") {
                alert("Please choose form");
                return false;
            }
            if ($("#hid_userId").val() == "") {
                alert("Please choose user");
                return false;
            }
            if ($("#ddlLevels").val() == "0") {
                alert("Please choose level");
                return false;
            }
        });
    });
    function setUrl(url, name)
    {
        $("#txtSelectedForm").val(name);
        $("#hid_url").val(url);
        return false;
    }

    function setUserList(type, searchString) {
        var userType = usertypeChange();
        if (userType != '') {
            if (searchString == '') {
                searchString = "searchstringMissing";
            }
            $.ajax({
                url: "<?php echo base_url(); ?>admin/getUsersDetails/" + userType + "/" + type + "/" + searchString,
                success: function (message) {
                    $("#userList").html(message);
                    setUserDet();
                }
            });
        } else {
            return false;
        }
    }
    String.prototype.ltrim = function () {
        return this.replace(/^\s+/, "");
    }
    String.prototype.rtrim = function () {
        return this.replace(/\s+$/, "");
    }
    function setUserDet() {
        $("#userList tr").dblclick(function () {
            $("#userList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#userResult .selected").length > 0)
            {
                $("#hid_userId").val($("#userResult .selected input").val());
                $("#txtUser").val($("#userResult .selected td.first").text().ltrim().rtrim());
            }
            $("#userSelectMaster").slideUp(500);
        });
        $("#userList tr").click(function () {
            $("#userList tr").removeClass("selected");
            $(this).addClass("selected");
        });
    }
    function usertypeChange() {
        var UserType = '';
        if ($("#ddlUserType").val() == 0) {
            UserType = 'umIsHOUser';
            $("#divRadio").show();
            $(".divHOForm").show();
            $(".divcommonUserForm").show();
            var $radio = $('input:radio[name=radioSelectPages]');
            $radio.filter('[value=custom]').attr('checked', true);
        } else {
            $(".divHOForm").hide();
            $(".divcommonUserForm").hide();
            $("#divRadio").hide();
        }

        return UserType;
    }
    function radioSelectAll_Click(type) {
        if (type == 'all') {
            $(".divHOForm").hide();
            $(".divcommonUserForm").hide();
            $("#txtSelectedForm").val('Allpages');
            $("#hid_url").val('AllPages');
        } else {
            $("#txtSelectedForm").val('');
            $(".divHOForm").show();
            $(".divcommonUserForm").show();
        }
    }
    function hideshowMainPages(name, divId) {
        $("#" + divId).toggle();
        $("#txtSelectedForm").val(name);
        $("#hid_url").val(name);
        return false;
    }
</script>
<section class="content-header">
    <h1>
        Security User Access
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Security User Access</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title"></h3>
                    </div>

                </div><!-- /.box-header -->


                <?php
                $userdata = $this->session->userdata('userdata');
                $username = $userdata['umUserName'];
                $isPriv = $isPrivilege;
                if ($isPriv == 'previleged0DR4RE6SE' || $username == 'admin') {
                    ?>
                    <div class="box-body table-responsive">
                        <form name="userAccessData" method="post" class="ajax-submit" action="admin/insertUserAccess">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class ="usertype col-xs-6">
                                        <select id="ddlUserType" class="form-control" name="ddlUserType" onchange="usertypeChange();">
                                            <option value="-1">Select User Type</option>
                                            <option value="0">Head Office</option>
                                        </select>
                                    </div><!--usertype-->
                                    <div id="divFormDet" class="col-xs-6 divFormDet">
                                        <div id="divRadio">
                                            <input type="radio" name="radioSelectPages" id="radioSelectAll" value="all" onclick="radioSelectAll_Click('all');" />Select All Pages
                                            <br />
                                            <input type="radio" name="radioSelectPages" id="radioSelect" value="custom" onclick="radioSelectAll_Click('custom');" />Custom Select
                                        </div>
                                        <div id="divHOForm" style="padding:10px;">
                                            <div class="divcommonUserForm">
                                                <input type="hidden" id="hid_url" name="hid_url"/>
                                                <div>
                                                    <div class="sign" onclick="javascript:hideshowMainPages('SalesOrders', 'SONav');">
                                                        <span class="ui-icon ui-icon-circle-arrow-e"></span>
                                                        <a>Sales Order</a>
                                                    </div>
                                                </div>
                                                <div id="SONav">
                                                    <a class="subNav" href="javascript:setUrl('/salesorder/view_sales_order', 'View Sales Order')">View Sales Order</a>
                                                    <a class="subNav" href="javascript:setUrl('/salesorder/create_sales_order', 'Create Sales Order')">Create Sales Order</a>
                                                </div>
                                            </div>
                                            <div class="divHOForm">
                                                <div>
                                                    <div class="sign" onclick="javascript:hideshowMainPages('Allocations', 'AllocationNav');"> 
                                                        <span class="ui-icon ui-icon-circle-arrow-e"></span> 
                                                        <a >Allocation</a>
                                                    </div>
                                                </div>
                                                <div id="AllocationNav">
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_sub_area', 'Sub Area For Rep')">Sub Area For Rep</a>
                                                    <a class="subNav" href="javascript:setUrl('/admin/sub_area_allocation', 'Sub Area Allocation')">Sub Area Allocation</a>
                                                    <a class="subNav" href="javascript:setUrl('/admin/area_matrix', 'Area Matrix')">Area Matrix</a>
                                                </div>
                                            </div>
                                            <div  class="divHOForm">
                                                <div><div class="sign" onclick="javascript:hideshowMainPages('Masters', 'MasterNav');"> 
                                                        <span class="ui-icon ui-icon-circle-arrow-e"></span> 
                                                        <a >Masters</a>
                                                    </div></div>
                                                <div id="MasterNav">
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_users', 'User Master')">User Master</a>
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_customers', 'Customer Master')">Customer Master</a>
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_products', 'Product Master')">Product Master</a>
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_divisions', 'Division Master')">Division Master</a>
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_areas', 'Area Master')">Area Master</a>
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_zones', 'Zone Master')">Zone Master</a>
                                                    <a class="subNav" href="javascript:setUrl('/listcontrol/show_branches', 'Branch Master')">Branch Master</a>
                                                </div>
                                            </div>
                                            <div  class="divHOForm">
                                                <div>
                                                    <div class="sign" onclick="javascript:hideshowMainPages('SecurityAccess', 'AdminNav');">
                                                        <span class="ui-icon ui-icon-circle-arrow-e"></span>
                                                        <a >Administration</a>
                                                    </div>
                                                </div>
                                                <div id="AdminNav">
                                                    <a class="subNav" href="javascript:setUrl('/admin/security_user_access', 'Security User Access')">Security User Access</a>
                                                </div>
                                            </div>
                                            <div class="divcommonUserForm">
                                                <div>
                                                    <div class="sign" onclick="javascript:hideshowMainPages('Settings', 'SettingsNav');">
                                                        <span class="ui-icon ui-icon-circle-arrow-e"></span>
                                                        <a >Settings</a>
                                                    </div>
                                                </div>
                                                <div id="SettingsNav">
                                                    <a class="subNav" href="javascript:setUrl('/common/change_password', 'Change Password')">Change Password</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--table2-->
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            Selected form
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="text" id="txtSelectedForm" class="form-control" name="txtSelectedForm"/>
                                        </div><!--selection-->
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            User
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="txtUser" id="txtUser"  />
                                                <input type="hidden" name="hid_userId" id="hid_userId" />
                                                <span class="input-group-btn">
                                                    <button id="btnSelectUser" class="btn btn-info btn-flat" type="button">View Users</button>
                                                </span>
                                            </div>                                           
                                        </div><!--selection-->
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-xs-3">
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="input-group input-group-sm">
                                                <select id="ddlLevels" name="ddlLevels" class="form-control" >
                                                    <option value="0">Select Level</option>
                                                    <option value="1">Level 0</option>
                                                    <option value="2">Level 1</option>
                                                    <option value="3">Level 2</option>
                                                    <option value="4">Level 3</option>
                                                </select>
                                                <span class="input-group-btn">
                                                    <input type="button" class="linkButton btn btn-info" id="btnLevel" name="btnLevel" value="Level"/>
                                                </span>
                                            </div>
                                        </div><!--selection-->
                                    </div>
                                </div>	
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-xs-6">

                                    <input type="submit" id="btnSave" class="pull-right btn btn-primary" name="btnSave" value="Save"/>

                                </div>
                            </div>
                        </form>
                    </div><!--subcontent-->
                    <?php
                } else {
                    echo "<div style='margin-top: 30px;text-align: center;font-size: 20px;color: #BD0707;'>You Have No Permission to access this Page.</div>";
                }
                ?>
            </div>
        </div>
    </div>
</section>

<div class="modal fade in" id="levelMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Security Level Master</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="box-body table-responsive" id="levelList"> 

                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left close-btn"  >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="userSelectMaster" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> User Master</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="box-body table-responsive" id="userList"> 

                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary pull-left" id="userSelect" >
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