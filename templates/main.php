<html>
<head>
<!-- Default backup theme -->
<title><?php echo $this->title; ?></title>
<style type="text/css">
body{ font-family: sans-serif; font-size: 75%; }
hr{ border: none; border-top: 1px dotted #333 }
</style>
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1, width=device-width">
</head>
<body>
	<h1><a href="/"><?php echo $settings->site_title; ?></a></h1>
	<hr/>
	<?php require_once($template); ?>
	<hr/>
	You are using Sorbet. This is the default theme
</body>
</html>