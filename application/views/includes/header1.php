<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="utf-8">
		<title><?php echo $this->config->item('app_title'); ?></title>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>CSS/login.css"/>
		<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- Le styles -->
		<link href="<?php echo base_url(); ?>CSS/bootstrap.css" rel="stylesheet">
		<style type="text/css">
		  body {
			
		  }
		  .sidebar-nav {
			padding: 9px 0;
		  }

		  @media (max-width: 980px) {
			/* Enable use of floated navbar text */
			.navbar-text.pull-right {
			  float: none;
			  padding-left: 5px;
			  padding-right: 5px;
			}
		  }
		</style>
		
		<link href="<?php echo base_url(); ?>CSS/bootstrap-responsive.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="<?php echo base_url(); ?>JS/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="../assets/ico/favicon.png">
		<script type="text/javascript" src="<?php echo base_url(); ?>JS/JQuery.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>JS/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>JS/superfish.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".sf-menu").superfish();
			})
		</script>
	</head>
	<body>