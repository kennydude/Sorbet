<?php
function template($data){
	define("PAGE_MULTI_POSTS", "");
	include getTemplate($data->view_template);
}

foreach($data as $post){
	template($post);
	echo "<hr/>";
}
?>
<table style="width:100%;text-align:center;padding:10px"><tr>
<td style="width:50%;text-align:center">
<?php if(count($data) >= 10) {
$page = $_GET['page'];
if(!$page)
	$page = 1;
?>
<a href="?page=<?php echo $page + 1; ?>">Older Posts</a>
<?php } ?>
</td>
<td style="width:50%;text-align:center">
<?php if($_GET['page'] > 0) { ?>
<a href="?page=<?php echo $page - 1; ?>"">Newer Posts</a>
<?php } ?>
</td>
<?php ?>
</tr></table>

