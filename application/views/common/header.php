<!Doctype html>
<meta charset=utf-8>
<html>
	<head>
		<title>HR</title>
		<script src="<?php echo base_url(); ?>js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery-ui.min.js"></script>
		<script src="<?php echo base_url(); ?>js/timepicker.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.alphanumeric.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.jsonSuggest-2.min.js"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/timepicker.css">

		
		<style>
			.link {
				cursor: pointer;
				font-size: 15px;
			}

			#email_body{
				font-family: "Times New Roman, Serif";
			}
				
		</style>
	</head>
	<nav style="background-color: #000000;" class="navbar navbar-default navbar-static-top" role="navigation">
		<div style="width:1100px;margin:auto">
			<a class="link navbar-brand" href='<?php echo base_url(); ?>'><b><span style="color:#ffa500;">HRIS</span> <span style="color:#FFFFFF;">Human Resource Information System</span></b></a>
			<a id="logout" class="link navbar-brand navbar-right" style="color:#ccc;"> Logout</a>
			<a class="navbar-brand navbar-right" style="color:#ccc;"><span style="color:#FFFFFF;">Welcome </span><span style="color:#ffa500;"><?php echo $name['firstname']; ?></span><span style="color:#FFFFFF;">!</span></a>
		</div>		
	</nav>

	<div class="modal fade" id="alertModal" style="z-index:9999">
	  <div class="modal-dialog"  style="width:280px">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h3 class="modal-title" id="alertTitle" style="font-weight:bold">Error</h3>
		  </div>
		  <div class="modal-body" id="notifContent">
		 	
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal" id="okButton">Ok</button>
		  </div>
		</div>
	  </div>
	 </div>
	<body>
	<script>
		
		var EMPLOYEE_URI = '<?php echo base_url(); ?>';
		var ADMIN_URI = '<?php echo base_url(); ?>';
		var SITE_URI = '<?php echo site_url(); ?>';
		var alertModal = $('#alertModal');
		var alertTitle = $('#alertTitle');
		var notifContent = $('#notifContent');

		function alertify(content, title) {
			notifContent.html('').html(content);
			alertTitle.text(title);
			alertModal.modal('show');
		}

		$('#logout').click(function(){
			$.ajax({
				url: ADMIN_URI + 'login/log_out',
				complete: function(){
					window.location.href = ADMIN_URI;
				}
			});	
		});

	</script>