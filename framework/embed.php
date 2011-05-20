<?php
require_once("cache.php");

class Embed{
	function embed($url){
		return "ERROR: This function (embed) must be overriden!";
	}
}

class TwitterEmbed extends Embed{
	function embed($url){
		$tweetid = substr($url, strrpos($url,'/') + 1);
		// TODO: Move to cache
		$tweet = get_page_contents("http://api.twitter.com/1/statuses/show/$tweetid.json");
		$tweet = json_decode($tweet, true);
		$user = $tweet['user'];
		$background = "#${user['profile_background_color']}";
		if($user['profile_use_background_image'])
			$background = "url('${user['profile_background_image_url']}') $background";
		return <<<EOF
<div class="tweet" style="background: $background; padding: 20px">
	<div class="innertweet" style="background: #fff; padding: 10px;">
		<big>${tweet['text']}</big>
		<br/>
		<small>${tweet['created_at']} via ${tweet['source']}</small>
		<hr/>
		<table>
			<tr>
				<td><img src="${user['profile_image_url']}" /></td>
				<td><b>${user['screen_name']}</b><br/>${user['name']}</td>
			</tr>
		</table>
	</div>
</div>
EOF;
	}
}