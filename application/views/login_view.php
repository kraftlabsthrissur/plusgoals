<?php
$this->load->view('includes/header1');
?>

<style type="text/css">
    .logo{
        font-size: 30px;
        line-height: 50px;
        text-align: center;
        margin-top: 10px;
        padding: 0 10px;
        width: 100%;
        font-family: 'Kaushan Script', cursive;
        font-weight: 500;
        height: 58px;
        display: block;
        background-color: #367fa9;
        color: #f9f9f9;
        box-sizing: border-box;
    }
    .logos{
        font-size: 30px;
        line-height: 50px;
        text-align: center;
        margin-top: 10px;
        padding: 0 10px;
        width: 100%;
        font-family: 'Kaushan Script', cursive;
        font-weight: 500;
        height: 58px;
        display: block;
        /* background-color: white; */
        color: #f9f9f9;
        box-sizing: border-box;
    }
</style>
<div class="container">
    <div class="form-signin">
        <div class="pnl-head">
            <!-- <span  class="logo"> -->
            <span  class="logos">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <!-- <?php echo $this->config->item('app_title'); ?> -->
                <img src="<?php echo base_url(); ?>images/logo2.svg"/>
            </span>
        </div>
        <hr/>
        <div class="pnl-cntwell">
            <div class="panelcontent">
                <?php
                echo form_open('login/index');
                ?>
                <!-- <h2>Send instant orders in an easy way.</h2> -->
                <div class="control-group">
                    <!--label for="user" class="c-label"> UserName:</label-->
                    <input type="text" name="username"  placeholder="UserName" class="frm-input controls input-block-level form-control" />
                </div>

                <div class="control-group">
                    <!--label for="emailaddress" class="c-pass"> Password:</label-->
                    <input type="password" name="password"  placeholder="Password" class="frm-input input-block-level" />
                </div>
                <div class="c-group">
                    <input type="submit" name="submit" class="frm-submit btn btn-primary"  value="Login"/>
                    <?php
                    form_close();
                    ?>
                </div>
            </div><!--panelcont-->
        </div><!--pnlcnt-->
        <?php
        if (isset($status)) {
            echo "<div class='errorTxt'>" . $status . "</div>";
        } else {
            
        }
        ?>

    </div>
    <!-- <div class="kraft">
        <a id="powered" href="http://www.kraftlabs.com">Copyright @ Kraftlabs2013</a>
    </div> -->
</div>						