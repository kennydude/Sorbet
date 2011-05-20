<?php 
// Cache framework

/**
 * Get page contents [cached] default to 12 hours
 */
function get_page_contents($url, $cache_time = 43200){
	$file = "../cache/" . sha1($url);
	if(file_exists($file)){
		$expire = file_get_contents($file . "_expires.txt");
		if($expire + $cache_time > time())
			return file_get_contents($file);
	}
	$data = file_get_contents($url);
	file_put_contents($file, $data);
	file_put_contents($file . "_expires.txt", time() + $cache_time);
	return $data;
}