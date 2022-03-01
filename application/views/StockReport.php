<?php
$this->load->view('includes/header');
?>
<style type="text/css">
    .align
    {float:left;
    }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>JS/stockReport.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/stockreg.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/storemaster.css"/>
<?php
$this->load->view('includes/menu');
?>
<div id="content">
    <div id="main_content">
        <h2>Stock Report</h2>
        <div id="inner_content">
            <div id="main_panel">
                <form name="stockManager" method="post" >
                    <div class="panel">
                        <div id="pan_head"><b>Stock Report</b></div>
                        <div style="float:left;margin-right:10px;">
                            From 
                            <input type="text" id="txtFromDate" name="txtFromDate" readonly="true"/>
                        </div>
                        <div>
                            To 
                            <input type="text" id="txtToDate" name="txtToDate" readonly="true"/>
                        </div>
                        <div id="searchTypes">
                            <input type="radio" name="group1" id="radioAll" value="All" checked> All
                            <input type="radio" name="group1" value="BranchWise"> BranchWise
                            <input type="radio" name="group1" value="ItemWise"> ItemWise
                            <input type="radio" name="group1" value="CategoryWise"> CategoryWise
                        </div>
                        <div id="searchOpt">
                            <table>
                                <tr>
                                    <td>Branch:</td>
                                    <td>
                                        <input type="text" id="txtBranches" name="txtBranches" readonly="true"/>
                                        <input type="hidden" id="hid_Branches" name="hid_Branches"/>
                                    </td>
                                    <td><input type="button" id="btnBranch" name="btnBranch" value="..."></td>
                                </tr>
                                <tr>
                                    <td>Item:</td>
                                    <td>
                                        <input type="text" id="txtItems" name="txtItems" readonly="true"/>
                                        <input type="hidden" id="hid_Items" name="hid_Items"/>
                                    </td>
                                    <td><input type="button" id="btnItems" name="btnItems" value="..."></td>
                                </tr>
                                <tr>
                                    <td>Category:</td>
                                    <td>
                                        <input type="text" id="txtCategory" name="txtCategory" readonly="true"/>
                                        <input type="hidden" id="hid_Category" name="hid_Items"/>
                                    </td>
                                    <td><input type="button" id="btnCategory" name="btnCategory" value="..."></td>
                                </tr>
                            </table>
                        </div>
                        <div style="float:right;width: 185px;">
                            <div style="float:left">
                                <input type="button" id="btnShow" name="btnShow" value="Show" rel="1" onclick="return validation();"/>
                            </div>
                            <div style="float:left">
                                <input type="button" id="btnCancel" name="btnCancel" value="Cancel"/>
                            </div>
                            <div>
                                <input type="button" id="btnClear" name="btnClear" value=" Clear " onclick="return cleartext_hidFields('all');"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="overlay"></div>
    <div class="store" id="storeMaster">
        <div>
            <div class="title">
                <div class="titleText">
                    <b><span id="popHeadId"></span></b>
                </div>
                <div class="titleClose">
                    <a id="storeClose" href="#">X</a>
                </div>
            </div>
            <div class="search">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="2">
                            <img src="<?php echo base_url(); ?>/CSS/images/view_calendar_list.png" width="60" height="60" />
                        </td>
                        <td>
                            <b><span id="poptitle1Id"></span></b>
                        </td>
                        <td>
                            <input type="text" name="store" id="storeValue" />
                        </td>
                        <td rowspan="2">
                            <input type="submit" value="Search" id="storeSearch" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Code</b>
                        </td>
                        <td>
                            <input type="text" name="code" id="codeValue" />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="list">
                <div class="title">
                    <div class="col1">Branch Name</div>
                    <div class="col2">Branch Code</div>
                    <div class="col3"></div>
                </div>
                <div class="items" id="storeList">
                    <table cellpadding="0" cellspacing="0" id="storeResult">

                    </table>
                    <input type="hidden" id="hid_table" />
                </div>
            </div>
            <div class="footer">
                <div>
                    <input type="submit" value="OK" id="storeSelect" />
                    <a href="#" id="closeStore">CANCEL</a>
                </div>
            </div>
        </div>
        <input type="hidden" id="baseUrl" value="<?php echo base_url(); ?>" />
    </div>
</div>




<?php
$this->load->view('includes/footer');
?>