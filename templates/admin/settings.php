<?php
function q($x){
	if($_GET['tab'] == $x)
		echo 'class="selected"';
}
function mid_header(){
	?>
	<div class="tabs">
		<a <?php q("main"); ?> href="?tab=main">Main</a>
		<a <?php q("social"); ?> href="?tab=social">Social</a> 
		<a <?php q("themes"); ?> href="?tab=themes">Themes</a>
		<a <?php q("plugins"); ?> href="?tab=plugins">Plugins</a>
	</div>
	<?php
}
include "main.php";
