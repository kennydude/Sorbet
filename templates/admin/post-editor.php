<form method="post" action="<?php echo get_url(); ?>">
<div id="main-post" class="box left-col">
	<input type="text" name="title" value="<?php echo $data->title; ?>" />
	<span class="clear"></span>
	<?php call_hook("post_editor_bellow_title"); ?>
	<div class="toolbar"><!-- Javascript toolbar!!!! --></div>
	<textarea name="body" id="body" style="width:100%; min-height:400px;padding:6px;"><?php echo $data->body; ?></textarea>
	<input type="submit" value="Save Post" />
</div>
<div id="main-side" class="right-col">
	<div class="box-toppad">
		<span class="subtitle">Post options</span><br/>
		<hr/>
		Url Slug:<br/>
		<input type="text" placeholder="automatic" name="url_slug" value="<?php echo $data->url_slug; ?>" /><br/>
		Date posted:<br/>
		<input type="text" style="width:30px" class="smallinput" name="date[day]" id="day" maxlength="2" value="<?php echo date('j', strtotime($data->created)); ?>" />
		&nbsp;/&nbsp;
		<?php $m = date('n', strtotime($data->created)); ?>
		<select name="date[month]" id="month">
			<option value="1" <?php if($m==1){ echo "selected='selected'"; } ?>>January</option>
			<option value="2" <?php if($m==2){ echo "selected='selected'"; } ?>>February</option>
			<option value="3" <?php if($m==3){ echo "selected='selected'"; } ?>>March</option>
			<option value="4" <?php if($m==4){ echo "selected='selected'"; } ?>>April</option>
			<option value="5" <?php if($m==5){ echo "selected='selected'"; } ?>>May</option>
			<option value="6" <?php if($m==6){ echo "selected='selected'"; } ?>>June</option>
			<option value="7" <?php if($m==7){ echo "selected='selected'"; } ?>>July</option>
			<option value="8" <?php if($m==8){ echo "selected='selected'"; } ?>>August</option>
			<option value="9" <?php if($m==9){ echo "selected='selected'"; } ?>>September</option>
			<option value="10" <?php if($m==10){ echo "selected='selected'"; } ?>>October</option>
			<option value="11" <?php if($m==11){ echo "selected='selected'"; } ?>>November</option>
			<option value="12" <?php if($m==12){ echo "selected='selected'"; } ?>>December</option>
		</select>
		&nbsp;/&nbsp;
		<input type="text" name="date[year]" class="smallinput" style="width:50px" id="year" value="<?php echo date('Y', strtotime($data->created)); ?>" /><br/>
		Time posted:<br/>
		<input type="text" name="date[hour]" style="width:30px" name="hour" class="smallinput" id="hour" maxlength="2" value="<?php echo date('G', strtotime($data->created)); ?>" /> : 
		<input type="text" name="date[min]" style="width:30px" name="min" class="smallinput" id="min" maxlength="2" value="<?php echo date('i', strtotime($data->created)); ?>" />
		&nbsp;<button type="button" class="hide smallinput" id="time-to-now">Set To Now</button>
		<br/>
		Status:<br/>
		<?php $pub = $data->status; ?>
		<select name="status">
			<option value="published" <?php if($pub == "published"){ echo "selected='selected'"; } ?>>Published</option>
			<option value="draft" <?php if($pub == "draft"){ echo "selected='selected'"; } ?>>Draft</option>
			<option value="private" <?php if($pub == "private"){ echo "selected='selected'"; } ?>>Private</option>
		</select>
	</div>
	<div class="box-toppad">
		<span class="subtitle">Permissions</span>
		<b>Design only</b>
		<hr/>
		<table>
			<tr>
				<td></td>
				<td>User</td>
				<td>Group</td>
				<td>World</td>
			</tr>
			<tr>
				<td>Read</td>
				<td><input type="checkbox" /></td>
				<td><input type="checkbox" /></td>
				<td><input type="checkbox" /></td>
			</tr>
			<tr>
				<td>Write</td>
				<td><input type="checkbox" /></td>
				<td><input type="checkbox" /></td>
				<td><input type="checkbox" /></td>
			</tr>
			<tr>
				<td>Change PMs</td>
				<td><input type="checkbox" /></td>
				<td><input type="checkbox" /></td>
				<td><input type="checkbox" /></td>
			</tr>
		</table>
	</div>
	<div class="box-toppad">
		<span class="subtitle">Social Publishing Options</span><br/>
		<hr/>
		<b>This is design-only for now</b>
		<table>
			<tr>
				<td>
					<img src="<?php echo $coredir; ?>/admin/res/twitter.png" />
				</td><td>
					<input type="checkbox" /> Send a tweet<br/>
					<textarea class="limit" data-limit="140"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<img src="<?php echo $coredir; ?>/admin/res/fb.png" />
				</td><td>
					<input type="checkbox" /> Share on Facebook<br/>
					<textarea class="limit" data-limit="420"></textarea>
				</td>
			</tr>	
		</table>
	</div>
	<!-- <div class="title">Help</div>
	Here's a quick Markdown refresher!
	<php include("markdown-guide.php"); > -->
</div>
</form>
<div class="reset"></div>
<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/jquery.limit.js"></script>
<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/post-editor.js"></script>
