<form method="post" action="blob-editor.php?blob=<?php echo $_GET['blob']; ?>">
	<div id="main-post" class="box">
		<input type="text" name="title" value="<?php echo $data->title; ?>" />
		<textarea name="body" style="width:100%; min-height:50px;padding:6px;"><?php echo $data->body; ?></textarea>
	</div>
	<div><span class="title">List Children</span></div>
	<?php foreach($data->getChildren() as $child) { ?>
	<div class="box child">
		<input name="children_title[<?php echo $child->id; ?>]" type="text" value="<?php echo $child->title; ?>" />
		<textarea name="children_body[<?php echo $child->id; ?>]" style="width:100%; min-height:50px;padding:6px;"><?php echo $child->body; ?></textarea>
	</div>
	<?php } ?>
	<div id="addAnotherBox" class="hide"><a href="#" id="addAnotherItem">Add another item</a></div>
	<div class="box child listTemplate">
		<input data-name-template="children_title[new-{x}]" type="text" name="children_text[new-1]" value="" />
		<textarea data-name-template="children_body[new-{x}]" name="children_body[new-1]" style="width:100%; min-height:50px;padding:6px;"></textarea>
	</div>
	<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/list-editor.js"></script>
	<div class="box"><input type="submit" value="Save" /></div>
</form>