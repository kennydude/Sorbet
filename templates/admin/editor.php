<div id="main-post" class="box left-col">
	<form method="post" action="post-editor.php?post=<?php echo $_GET['post']; ?>">
		<div id="date-input">
			<select id="day">
				<option>1st</option>
				<option>2nd</option>
				<option>3rd</option>
			</select>
			<select id="month">
				<option>January</option>
				<option>Febrauary</option>
				<option>March</option>
				<option>April</option>
				<option>May</option>
				<option></option>
			</select>
		</div>
		<div id="title" class="pad10 most left">
			<input type="text" name="title" value="<?php echo $data->title; ?>" />
		</div>
		<span class="clear"></span>
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