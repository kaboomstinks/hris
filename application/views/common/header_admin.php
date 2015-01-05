<!doctype html>
<html>
	<head>
		<title>HR</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
		
		<style>
		
			body{
				font-family: 'Archivo Narrow', sans-serif;
			}
			
			#logincontainer {
				width: 200px;
				margin: 150px auto;
				padding: 40px 20px 30px;
				border-radius: 10px;
				background: #e5e5e5;
			}
			
			#loginwrap {
				width: 160px;
				margin: auto;
			}
			
			#logout {
				cursor: pointer;
			}
				
				
		</style>
	</head>
	<body>
	<nav class="navbar navbar-default navbar-static-top" role="navigation">
		<a class="navbar-brand" href='board'>HRIS</a>
		<a id="logout" class="navbar-brand navbar-right" style="display:none">Logout</a>		
	</nav>
	<script>
	
	
		$('#logout').click(function(){
			$.ajax({
				url: '<?php echo base_url(); ?>hr/out',
				complete: function(){
					window.location.href = '<?php echo base_url(); ?>hr';
				}
			});	
				
		});

	</script>