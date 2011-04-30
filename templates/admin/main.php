<html>
	<head>
		<title>Sorbet Admin</title>
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1, width=device-width">
		<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/zepto.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/admin/core.css" />
	</head>
	<body>
		<div class="headerbox"><div class="w980">
			<?php if(!function_exists("admin_header")) {?>
				<?php $sep = '<span class="sep">&nbsp;</span>'; ?>
				<a href="index.php">Sorbet</a>
				<?php echo $sep; ?>
				<a href="list.php?type=page">Pages</a>
				<?php echo $sep; ?>
				<a href="list.php?type=list">Lists</a>
				<?php echo $sep; ?>
				<a href="list.php?type=post">Posts</a>
				<?php echo $sep; ?>
				<a href="tags.php">Tags</a>
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