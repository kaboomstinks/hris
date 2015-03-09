<style type="text/css">

	input[type="text"], input[type="password"] {
		font-size: 16px; 
		width: 250px;
		text-align:center;	
	}
	
	input[type="text"] {
		margin-bottom: 0px;
		border-bottom-left-radius: 0;
	  	border-bottom-right-radius: 0;
	}
	
	input[type="password"] {
		margin-bottom: 20px;
		border-top-left-radius: 0;
	  	border-top-right-radius: 0;
	}

	#logintitle{
		font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; 
		font-weight: 500; 
		line-height: 1.1; 
		color: inherit;
		margin-bottom: 20px;
	}
	
	#logincontainer {
		border-radius: 20px;
		margin: 35px auto;
		padding: 20px 0 35px;
		width: 250px;
	}
</style>

<!-- <div class="alert alert-danger" role="alert" style="margin:50px; text-align:center">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<strong>Warning!</strong> Please Enter username and password
</div> -->
<body style="background-color:#EEEEEE;">
<div id="logincontainer" >
		<form id="loginform">
			<h2 id='logintitle' style="margin-bottom: 10px;">HRIS</h2>
			<input class="form-control" type="text" name="username" placeholder="Username" required autofocus />
			<input class="form-control" type="password" name="password" placeholder="Password" required autofocus />
		</form>

		<button class="btn btn-lg btn-primary btn-block" id="login" style="width: 250px; " >Sign In</button>
</div>
<!-- <div align="center">
	<img src ="images/circus_logo.png"  height="120" width="120" /> &nbsp;&nbsp;
	<img src ="images/tavolozza_logo.png"  height="120" width="280" /> &nbsp;&nbsp;
	<img src ="images/hallo_hallo_logo.png"  height="120" width="120" />
	
</div> -->


<script>

	$(document).ready(function(){

		var logmein = $('#login');
		var username = $('input[name=username]');
		var password = $('input[name=password]');
		$('nav').hide();

		function validatelogin(){
			var valid = true;
			var error = '';
			
			if($.trim(username.val()) == ''){
				valid = false;
				error += 'Enter username <br />';
			}
			
			if($.trim(password.val()) == ''){
				valid = false;
				error += 'Enter password';
			}
			
			if(error != ''){
				alertify(error);
			}
			
			return valid;
		}
		
		logmein.click(function(){
			
			if(validatelogin()){
				var data = $('#loginform').serialize();
				
				$.ajax({
					url: 'login/log_in',
					type: 'post',
					data: data,
					dataType: 'json',
					success: function(data){
						if(data.success == 1){
							location.reload();
						}else if(data.success == 0) {
							alertify('Invalid Password.','Error')
						}else if(data.success == 2) {
							alertify('User account does not exist!','Incorrect Account')
						}
					},
					beforeSend: function(){
						logmein.text('Logging in...');
					},
					complete: function(){
						username.val('').focus();
						password.val('');
						logmein.text('Login');
					}
					
				});
			}
		});
		
		$('#logincontainer input').keypress(function(key){
			if(key.keyCode == 13){
				logmein.click();
			}
		});
		
		
	});


</script>
</body>