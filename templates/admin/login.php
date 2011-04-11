<?php /* Sorbet Login */ ?>
<html>
	<head>
		<title>Please login to admin site</title>
		<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/zepto.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#username")[0].focus();
			$("#username")[0].select();
		});
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/admin/core.css" />
	</head>
	<body>
		<div class="centrebox">
			<span class="title">Sorbet</span><br/>
			<?php if($post_response == "auth_error"){ ?>
			<div class="error">
				Your username or password was incorrect!
			</div>
			<?php } ?>
			<form method="post" action="login.php">
				Username:<br/>
				<input type="text" id="username" name="username" tabindex="0" /><br/>
				Password:<br/>
				<input type="password" name="password" /><br/>
				<input type="submit" value="Login" />
			</form>
		</div>
	</body>
</html>