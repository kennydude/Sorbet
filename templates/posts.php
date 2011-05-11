<?php
function template($data){
	include getTemplate($data->view_template);
}

foreach($data as $post){
	template($post);
	echo "<hr/>";
}