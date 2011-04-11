<div>
	<span class="title"><?php echo $_GET['tag']; ?></span>
	<?php echo $_GET['type']; ?>
</div>
<div id="main-post" class="box left-col">
Appears in...<br/>
<hr/>
<?php
function inline_display($data){
	@include("../templates/" . $data->view_template);
}

foreach($data['appearances'] as $appear) {
	$blob = Blob::arrayToBlob($appear['blob']);
	inline_display($blob);
	echo "<hr/>";
} ?>
</div>
<div id="main-side" class="box right-col">
<span class="right">
	<a href="edit-tag-blob.php?tag=<?php echo $_GET['tag']; ?>&type=<?php echo $_GET['type']; ?>">Edit</a>
</span>
<?php
$blob = Blob::arrayToBlob($data['description']);
inline_display($blob);
if(!$blob){
	echo "There is no description. Edit it to create one";
}
?>
</div>
<div class="clear"></div>
