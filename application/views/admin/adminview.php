<div id="wrapper" style="width:1000px;margin:150px auto">
	<div style="width:150px;margin-right:25px;float:left;background:#f7f5fa;border-radius:5px">
		<?php include_once('asidemenu.php'); ?>
	</div>
	<div class="jumbotron" style="width:800px;margin-left:25px;float:right;border-radius:20px">
		<h1>Hello <?php echo $usersession; ?></h1> 
		<p>Im the admin...</p> 
	 </div> 
</div>

<script>
	$(document).ready(function(){
		$('#manage2 a, #manage a').css('padding', '10px 5px').css('font-size', '12px');
	});
</script>