<html>
	<head>
		<title>Sorbet Admin</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/admin/core.css" />
	</head>
	<body>
		<div class="headerbox">
			<a href="index.php">Sorbet</a>
			<span class="sep">&nbsp;</span>
			<a href="pages.php">Pages</a>
			<span class="sep">&nbsp;</span>
			<a href="lists.php">Lists</a>
			<span class="sep">&nbsp;</span>
			<a href="posts.php">Posts</a>
		</div>
		<?php foreach(get_messages() as $message) { ?>
		<div class="done"><?php echo $message; ?></div>
		<?php } ?>
		<?php require($template); ?>
		<hr/>
		<div class="footer">
			Created by <a href="http://twitter.com/kennydude">@kennydude</a>
		</div>
	</body>
</html>