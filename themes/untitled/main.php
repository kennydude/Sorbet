<html>
<head>
<title><?php echo $this->title; ?></title>
<style type="text/css">
body{ font-family: sans-serif; font-size: 75%; margin: 0 auto; width: 980px; }
hr{ border: none; border-top: 1px dotted #333 }
.box{
	background: #0066CC;
	padding: 10px; 
	color: #fff;
}
.box *{ color: #fff; }
@media (max-width: 980px) { 
	body{
		margin: 0;
		width: 100%;
	}
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo $coredir; ?>/core.css" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1, width=device-width">
</head>
<body>
	<h1 class="box"><a href="/"><?php echo $settings->site_title; ?></a></h1>
	<?php require_once($template); ?>
	<div class="box">
		Thanks for using Sorbet
	</div>
</body>
</html>