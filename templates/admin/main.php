<?php
// Call if exists
function cie($name){
	if(function_exists($name)){
		call_user_func($name);
	}
}
?>
<html>
	<head>
		<title>Sorbet Admin</title>
		<script type="text/javascript">
			var resdir = "<?php echo resdir(); ?>";
		</script>
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1, width=device-width">
		<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/admin.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/admin/core.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/core.css" />
	</head>
	<body>
		<div class="headerbox"><div class="w980">
			<?php if(!function_exists("admin_header")) {?>
				<div class="right">
					Hello <?php echo $_SESSION['ADMIN_AUTH']; ?>
				</div>
				<?php $sep = '<span class="sep">&nbsp;</span>'; ?>
				<a href="index.php">Sorbet</a>
				<?php echo $sep; ?>
				<a id="postsAndMore" href="list.php?type=post">Posts + more</a>
				<?php echo $sep; ?>
				<?php call_hook("admin_header"); ?>
				<a href="users.php">Users</a>
				<?php echo $sep; ?>
				<a href="settings.php">Settings</a>
			<?php } else{ admin_header(); } ?>
		</div></div>
		<div id="wcontent" class="w980">
			<?php foreach(get_messages() as $message) { ?>
			<div class="done"><?php echo $message; ?></div>
			<?php } ?>
			<?php require($template); ?>
			<hr/>
			<div class="footer">
				Created by <a href="http://twitter.com/kennydude">@kennydude</a>
			</div>
		</div>
	</body>
</html>
