<?php /* Sorbet Login */ ?>
<html>
	<head>
		<title>Please login to admin site</title>
		<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/sha1.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#username")[0].focus();
			$("#username")[0].select();
			$("#password").addClass("secure-password");
			$("#secured").css("display", "inline");
			$("#leform").bind("submit", function(){
				$("#password").val(sha1($("#password").val() + "-<?php echo $settings->salts[1]; ?>"));
				$("#prehashed").val("true");
				return true;
			});
		});
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/admin/core.css" />
	</head>
	<body>
		<div class="centrebox">
			<span class="title">Sorbet</span><br/>
			<?php if($post_response == "username"){ ?>
			<div class="error">
				There is no user with that username
			</div>
			<?php } else if($post_response == "password") { ?>
			<div class="error">
				Incorrect password!
			</div>
			<?php } ?>
			<form method="post" id="leform" action="login.php">
				Username:<br/>
				<input type="text" id="username" name="username" value="<?php echo $_POST['username']; ?>" tabindex="0" /><br/>
				Password:<br/>
				<input type="password" id="password" name="password" /><br/>
				<div id="secured" style="display: none;">
					<img src="<?php echo resdir(); ?>/res/lock.png" />
					Your password is encrypted <abbr title="Your password will be encrypted on YOUR computer before being sent over the airways">?</abbr>
				</div>
				<input type="hidden" id="prehashed" name="prehashed" value="false" />
				<input type="submit" value="Login" />
			</form>
		</div>
	</body>
</html>
