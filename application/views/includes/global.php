<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->config->item('app_title'); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/css/ionicons.min.css" rel="stylesheet" type="text/css" /><!-- Ionicons -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap-3.2.0.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/AdminLTE.css?t=11" rel="stylesheet" type="text/css" /><!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/css/SimpleCalendar.css" rel="stylesheet" type="text/css" /><!-- Theme style -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue fixed">
        <div id='loader'>
            <img id='loading-img' src='images/5.gif' alt='Loading...' />
        </div>
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <!-- <?php echo $this->config->item('app_title'); ?> -->
                <img src="<?php echo base_url(); ?>images/logo2.svg" class = "logo-style"/>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $user['umFirstName'] . ' ' . $user['umLastName']; ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo base_url(); ?>assets/img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $user['umFirstName'] . ' ' . $user['umLastName'] . ' - ' . $user['role']; ?>
                                        <small>Member since <?php echo date('M. Y', strtotime($user['umCreationDate'])); ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url(); ?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url(); ?>assets/img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $user['umFirstName']; ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <?php load_menu();?>
                    
                </section>
                <!-- /.sidebar -->
            </aside>
            <div id="log"></div>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside id="right-content" class="right-side">                




            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

		<div id="none" style="display:none" ></div>
        <!-- jQuery 2.0.2 -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

        <style type="text/css">



</style>

        <script src="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>assets/js/AdminLTE/app.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/plugins/jquery.form.min.js" type="text/javascript"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
            var app_title = '<?php echo $this->config->item('app_title'); ?>';
        </script>
        <script src="<?php echo base_url(); ?>assets/js/common.js?t=102" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/routes.js?t=100" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/expense.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/calls.js?t=100" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/task.js?t=111" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/message.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/routemap.js?t=100" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/fullcalendar.js" type="text/javascript"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhKZXS8GzDWzBS9zts0rEStbydHeyvFw0&libraries=places"></script>
        
<!--       <script src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>-->
       
    </body>
</html>
