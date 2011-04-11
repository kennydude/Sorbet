<html>
	<head>
		<title>Sorbet Admin</title>
		<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/zepto.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/admin/core.css" />
	</head>
	<body>
		<div class="headerbox"><div class="w980">
			<a href="index.php">Sorbet</a>
			<span class="sep">&nbsp;</span>
			<a href="list.php?type=page">Pages</a>
			<span class="sep">&nbsp;</span>
			<a href="list.php?type=list">Lists</a>
			<span class="sep">&nbsp;</span>
			<a href="list.php?type=post">Posts</a>
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