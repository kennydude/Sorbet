<?php /* Sorbet Login */ ?>
<html>
	<head>
		<title>Please login to admin site</title>
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
				<input type="text" name="username" /><br/>
				Password:<br/>
				<input type="password" name="password" /><br/>
				<input type="submit" value="Login" />
			</form>
		</div>
	</body>
</html>