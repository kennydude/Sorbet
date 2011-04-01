<div id="main-post" class="box left-col">
	<form method="post" action="post-editor.php?post=<?php echo $_GET['post']; ?>">
		<input type="text" name="title" value="<?php echo $data->title; ?>" />
		<textarea name="body" style="width:100%; min-height:400px;padding:6px;"><?php echo $data->body; ?></textarea>
		<input type="submit" value="Save Post" />
	</form>
</div>
<div id="main-side" class="box right-col">
	<div class="title">Help</div>
	Here's a quick Markdown refresher!
	<?php include("markdown-guide.php"); ?>
</div>
<div class="reset"></div>