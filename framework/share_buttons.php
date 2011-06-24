<?php
// TODO: optimize to make scripts load once!

$share_buttons = array(
	"twitter" => TweetButton,
	"facebook" => FacebookShareButton,
	"formspring" => FormspringShareButton
);

class ShareButton{
	public function render($template, $blob){
		$this->real_render($template, $blob);
		hook_onto("close_body", array($this, "get_js"));
	}
	public function real_render($template, $blob){
		error("real_render function isn't implmeneted");
	}
	public function get_js(){ /* no error! */ }
}

class FormspringShareButton extends ShareButton{
	public function real_render($template, $blob){
		global $settings;
		switch($template){
		case "small":
?>
<a href="http://www.formspring.me/" class="formspring-button" data-question="What do you think?" data-url="<?php echo $blob->permalink(); ?>" data-title="<?php echo $blob->title ?> on <?php echo $settings->site_title; ?>">What do you think?</a> 
<?php		break;
		case "tall":
?>
<a href="http://www.formspring.me/" class="formspring-button" data-question="What do you think?" data-url="<?php echo $blob->permalink(); ?>" data-style="square" data-title="<?php echo $blob->title ?> on <?php echo $settings->site_title; ?>">What do you think?</a>
<?php
		break;
	}
	}
	public function get_js(){
?>
<script type="text/javascript">
	(function() {if (document.body.getAttribute('formspring-onload-attached') && window['fspring'] && window.fspring['button']) { fspring.run(); return; }var fs=document.createElement('script'); fs.type='text/javascript';fs.src='http://cdn.formspring.me/button/button.js';var s=document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(fs, s);
    })();
</script>
<?php
	}
}

class FacebookShareButton extends ShareButton{
	public function real_render($template, $blob){
		switch($template){
		case "tall":
?>
<span id="fb-root"></span><fb:like href="<?php echo $blob->permalink(); ?>" send="true" layout="box_count" show_faces="false" font=""></fb:like>
<?php
			break;
		case "small":
?>
<span id="fb-root"></span><fb:like href="<?php echo $blob->permalink(); ?>" send="true" layout="button_count" show_faces="false" font=""></fb:like>
<?php
			break;
		}
	}
	public function get_js(){
?>
<script src="http://connect.facebook.net/en_US/all.js#appId=201264686586698&amp;xfbml=1"></script>
<?php
	}
}

class TweetButton extends ShareButton{
	public function real_render($template, $blob){
		switch($template){
		case "tall":
?>
<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo $blob->permalink(); ?>" data-count="vertical">Tweet</a>
<?php
			break;
		case "small":
?>
<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo $blob->permalink(); ?>" data-count="horizontal">Tweet</a>
<?php
			break;
		}
	}
	public function get_js(){
?>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<?php
	}
}
