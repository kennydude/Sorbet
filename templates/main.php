<html>
<head>
<!-- Default backup theme -->
<title><?php echo $this->title; ?></title>
<style type="text/css">
body{ font-family: sans-serif; font-size: 75%; }
hr{ border: none; border-top: 1px dotted #333 }
</style>
</head>
<body>
	<h1><a href="/">Title</a></h1>
	<hr/>
	<?php require_once($template); ?>
	<hr/>
	You are using Sorbet. This is the default theme
</body>
</html>