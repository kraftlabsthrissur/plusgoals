<?php
$this->load->view('includes/header');
?>
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
                    $("#levelResult").html("");
                    $("#levelResult").html(message);
                    openPopUp("levelMaster");
                }
            });
        });
        $("#levelClose ,#Closelevel").click(function () {
            $("#levelMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
            return false;
        });
        $("#btnSelectUser").click(function () {
            var userType = usertypeChange();
            if (userType != '') {
                $("#userNameValue").val("");
                $("#userCodeValue").val("");
                setUserList('all', '');
                openPopUp("userSelectMaster");
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
            $("#userSelectMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
        });
        $("#closeUser ,#userClose").click(function () {
            $("#userSelectMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
            return false;
        });
        $("#btnSave").click(function () {
            if ($("#txtSelectedForm").val() == "")
            {
                alert("Please choose form");
                return false;
            }
            if ($("#hid_userId").val() == "")
            {
                alert("Please choose user");
                return false;
            }
            if ($("#ddlLevels").val() == "-1")
            {
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
    function openPopUp(divId)
    {
        var dWidth = $(document).width();
        var pLeft = (($(window).width())) - 502;
        var dHeight = $(document).height();
        var pHeight = (($(window).height())) - 386 + $(window).scrollTop();
        $("#overlay").css("width", dWidth + "px");
        $("#overlay").css("height", dHeight + "px");
        $("#overlay").fadeIn(500, function () {
            $("#" + divId).css("left", pLeft / 2 + "px");
            $("#" + divId).css("top", pHeight / 2 + "px");
            $("#" + divId).slideDown(500);
        });
        return false;
    }
    function setUserList(type, searchString) {
        var userType = usertypeChange();
        if (userType != '')
        {
            if (searchString == '')
            {
                searchString = "searchstringMissing";
            }
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/admin/getUsersDetails/" + userType + "/" + type + "/" + searchString,
                success: function (message) {
                    $("#userResult").html("");
                    $("#userResult").html(message);
                    setUserDet();
                }
            });
        }
        else {
            return false;
        }
    }
    String.prototype.ltrim = function () {
        return this.replace(/^\s+/, "");
    }
    String.prototype.rtrim = function () {
        return this.replace(/\s+$/, "");
    }
    function setUserDet()
    {
        $("#userList tr").dblclick(function () {
            $("#userList tr").removeClass("selected");
            $(this).addClass("selected");
            if ($("#userResult .selected").length > 0)
            {
                $("#hid_userId").val($("#userResult .selected input").val());
                $("#txtUser").val($("#userResult .selected td.first").text().ltrim().rtrim());
            }
            $("#userSelectMaster").slideUp(500, function () {
                $("#overlay").fadeOut(500);
            });
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
        }
        else {
            $(".divHOForm").hide();
            $(".divcommonUserForm").hide();
            $("#divRadio").hide();
        }

        return UserType;
    }
    function radioSelectAll_Click(type)
    {
        if (type == 'all')
        {
            $(".divHOForm").hide();
            $(".divcommonUserForm").hide();
            $("#txtSelectedForm").val('Allpages');
            $("#hid_url").val('AllPages');
        }
        else
        {
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
<?php
$this->load->view('includes/menu');
?>
<div class="span10">
    <div id="content" class="well">
        <div id="main_content">
            <h2>Security User Access</h2>
        </div>
        <div id="overlay"></div>
        <?php
        $userdata = $this->session->userdata('userdata');
        $username = $userdata['umUserName'];
        $isPriv = $isPrivilege;
        if ($isPriv == 'previleged0DR4RE6SE' || $username == 'admin') {
            ?>
            <div id ="subcontent">
                <div class="tablecontent well">
                    <form name="userAccessData" method="post" action="<?php echo base_url(); ?>index.php/admin/insertUserAccess">
                        <div class="table2 span5">
                            <div class ="usertype">
                                <select id="ddlUserType" name="ddlUserType" onchange="usertypeChange();">
                                    <option value="-1">Select User Type</option>
                                    <option value="0">Head Office</option>
                                </select>
                            </div><!--usertype-->
                            <div id="divFormDet" class="divFormDet">
                                <div id="divRadio">
                                    <input type="radio" name="radioSelectPages" id="radioSelectAll" value="all" onclick="radioSelectAll_Click('all');" />Select All Pages
                                    <br />
                                    <input type="radio" name="radioSelectPages" id="radioSelect" value="custom" onclick="radioSelectAll_Click('custom');" />Custom Select
                                </div>
                                <div id="divHOForm" style="padding:10px;">
                                    <div class="divcommonUserForm">
                                        <input type="hidden" id="hid_url" name="hid_url"/>
                                        <div><div class="sign" onclick="javascript:hideshowMainPages('SalesOrders', 'SONav');"> <span class="ui-icon ui-icon-circle-arrow-e"></span> <a href="#;return false;">Sales Order</a></div></div>
                                        <div id="SONav">
                                            <a class="subNav" href="javascript:setUrl('/common/viewsalesorder', 'View Sales Order')">View Sales Order</a>
                                            <a class="subNav" href="javascript:setUrl('/common/salesorder', 'Sales Order')">Sales Order</a>
                                        </div>
                                    </div>
                                    <div class="divHOForm">
                                        <div><div class="sign" onclick="javascript:hideshowMainPages('Allocations', 'AllocationNav');">  <span class="ui-icon ui-icon-circle-arrow-e"></span> <a href="#;return false;">Allocation</a></div></div>
                                        <div id="AllocationNav">
                                            <a class="subNav" href="javascript:setUrl('/admin/subAreaForRep', 'Sub Area For Rep')">Sub Area For Rep</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/subAreaAllocation', 'Sub Area Allocation')">Sub Area Allocation</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/areaMatrix', 'Area Matrix')">Area Matrix</a>
                                        </div>
                                    </div>
                                    <div  class="divHOForm">
                                        <div><div class="sign" onclick="javascript:hideshowMainPages('Masters', 'MasterNav');">  <span class="ui-icon ui-icon-circle-arrow-e"></span> <a href="#;return false;">Masters</a></div></div>
                                        <div id="MasterNav">
                                            <a class="subNav" href="javascript:setUrl('/admin/userMaster', 'User Master')">User Master</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/customerMaster', 'Customer Master')">Customer Master</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/productMaster', 'Product Master')">Product Master</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/divisionMaster', 'Division Master')">Division Master</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/areaMaster', 'Area Master')">Area Master</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/zoneMaster', 'Zone Master')">Zone Master</a>
                                            <a class="subNav" href="javascript:setUrl('/admin/branchMaster', 'Branch Master')">Branch Master</a>
                                        </div>
                                    </div>
                                    <div  class="divHOForm">
                                        <div><div class="sign" onclick="javascript:hideshowMainPages('SecurityAccess', 'AdminNav');">  <span class="ui-icon ui-icon-circle-arrow-e"></span> <a href="#;return false;">Administration</a></div></div>
                                        <div id="AdminNav">
                                            <a class="subNav" href="javascript:setUrl('/admin/SecurityUserAccess', 'Security User Access')">Security User Access</a>
                                        </div>
                                    </div>
                                    <div class="divcommonUserForm">
                                        <div><div class="sign" onclick="javascript:hideshowMainPages('Settings', 'SettingsNav');">  <span class="ui-icon ui-icon-circle-arrow-e"></span> <a href="#;return false;">Settings</a></div></div>
                                        <div id="SettingsNav">
                                            <a class="subNav" href="javascript:setUrl('/common/changePassword', 'Change Password')">Change Password</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--table2-->
                        <div class="tabright span5">
                            <div class="select">
                                <div class="selection">
                                    Selected form
                                    <input type="text" id="txtSelectedForm" name="txtSelectedForm"/>
                                </div><!--selection-->
                            </div>
                            <div class="user">
                                User
                                <input type="text" id="txtUser" name="txtUser"/>
                                <input type="hidden" id="hid_userId" name="hid_userId"/>
                                <input type="button" id="btnSelectUser" class=" btn btn-mini btn-warning" name="btnSelectUser" value="..."/>
                            </div><!--user-->
                            <div class="table3">
                                <div class="selectlevel">
                                    <select id="ddlLevels" name="ddlLevels">
                                        <option value="0">Select Level</option>
                                        <option value="1">Level 0</option>
                                        <option value="2">Level 1</option>
                                        <option value="3">Level 2</option>
                                        <option value="4">Level 3</option>
                                    </select>
                                </div><!--selectlevel-->
                                <div class="level">
                                    <input type="button" class="linkButton btn btn-primary" id="btnLevel" name="btnLevel" value="Level"/>
                                </div><!--level-->
                            </div><!--table3-->
                        </div>	
                        <div class="bottom">
                            <div class="button" >
                                <input type="submit" id="btnSave" class="btn btn-primary" name="btnSave" value="Save"/>
                            </div><!--button-->
                        </div>
                    </form>
                </div><!--tablecontent-->
            </div><!--subcontent-->
            <?php
        } else {
            echo "<div style='margin-top: 30px;text-align: center;font-size: 20px;color: #BD0707;'>You Have No Permission to access this Page.</div>";
        }
        ?>
    </div>
</div>
<div class="store" id="levelMaster">
    <div>
        <div class="title">
            <div class="titleText">
                <b>Security Level Master</b>
            </div>
            <div class="titleClose">
                <a id="levelClose" href="#">X</a>
            </div>
        </div>
        <div class="list">
            <div class="title" >
                <div class="colmT">Level Name</div>
                <div class="colmT">View</div>
                <div class="colmT">Insert</div>
                <div class="colmT" id="clmlast">Update</div>
            </div>
            <div class="items" id="storeList">
                <table  id="levelResult"></table>
            </div>
        </div>
        <div class="close">
            <a id="Closelevel" class="linkButton btn btn-primary" href="#">Cancel</a>
        </div>
    </div>
</div>

<div class="store" id="userSelectMaster">
    <div>
        <div class="title">
            <div class="titleText">
                <b>User Master</b>
            </div>
            <div class="titleClose">
                <a id="userClose" href="#">X</a>
            </div>
        </div>
        <div class="search">
            <table>
                <tr>
                    <td rowspan="2">
                        <img src="<?php echo base_url(); ?>/CSS/images/view_calendar_list.png" width="60" height="60" />
                    </td>
                    <td>
                        <b>User Name</b>
                    </td>
                    <td>
                        <input type="text" name="txtusername" id="userNameValue" />
                    </td>
                    <td rowspan="2" class="searchbtn">
                        <input type="submit" value="Search" id="userSearch"  class="linkButton btn btn-primary"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>User Code</b>
                    </td>
                    <td>
                        <input type="text" name="txtcode" id="userCodeValue" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="list">
            <div class="title">
                <div class="col1">User Name</div>
                <div class="col2">User Code</div>
            </div>
            <div class="items" id="userList">
                <table cellpadding="0" cellspacing="0" id="userResult">

                </table>
            </div>
        </div>
        <div class="footer">
            <div>
                <input type="submit" class="linkButton btn btn-primary" value="Ok" id="userSelect" />
                <a href="#" id="closeUser" class="linkButton btn btn-primary">Cancel</a>
            </div>
        </div>
    </div>
</div>



<?php
$this->load->view('includes/footer');
?>