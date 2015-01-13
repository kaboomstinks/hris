<!doctype html>
<meta charset=utf-8>
<html>
	<head>
		<title>HR</title>
		<script src="<?php echo base_url(); ?>js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>
		<script src="<?php echo base_url(); ?>js/timepicker.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.alphanumeric.js"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.min.css">
		
		<style>
		
			#logincontainer {
				width: 214px;
				margin: 150px auto;
				padding: 40px 20px 30px;
				border-radius: 10px;
				background: #e5e5e5;
			}
			
			#loginwrap {
				width: 174px;
				margin: auto;
			}
			
			.link {
				cursor: pointer;
				font-size: 15px;
			}

			#logout {
				cursor: pointer;
			}
				
				
		</style>
	</head>
	<body>
	
		<div class="navbar navbar-inverse navbar-fixed-top" id="page_header" role="pagination">
			<div class="container">
				<a class="link navbar-brand" href='<?php echo base_url(); ?>'><b><span style="color:#ffa500;">HRIS</span> <span style="color:#FFFFFF;">Human Resource Information System</span></b></a>
		   		<a id="logout" class="link navbar-brand navbar-right" style="color:#ccc;">Logout</a>
		   	</div>
		    <div class="container">
		        <div id="mobile-header"> <a id="responsive-menu-button" class="navbar-toggle open" href="#slidenavi"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> </div>
		        <div class="collapse navbar-collapse" id="opennavi">
		        </div>
		        <div id="basenavi">
		            <a class="navbar-brand" href='<?php echo base_url(); ?>hr'>&nbsp;&nbsp;&nbsp;&nbsp;</a>
		            <ul class="nav nav-pills navbar-left" style="margin-top:5px;">
		                <li><a href="<?php echo base_url(); ?>">Home</a></li>
		                <li><a href="<?php echo base_url(); ?>employee/employeeview">Profile</a></li>
		               <!--  <li><a href="<?php echo base_url(); ?>employee/employee_create_request">Request</a></li>
		                <li><a href="<?php echo base_url(); ?>employee/employee_create_leave">Leave</a></li> -->
		            </ul>
		        </div>
		        <!--/.nav-collapse -->
		    </div>
		</div>	

	<script>
		$(document).ready(function(){
	        $('#logout').show();
	    });

		var EMPLOYEE_URI = '<?php echo base_url(); ?>';
	
		$('#logout').click(function(){
			$.ajax({
				url: EMPLOYEE_URI + 'login/log_out',
				complete: function(){
					window.location.href = EMPLOYEE_URI + 'login';
				}
			});	
				
		});

	</script>