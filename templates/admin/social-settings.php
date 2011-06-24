<div class="title">Social</div>
<?php cie("mid_header"); ?>
<div class="box"><form method="post" action="settings.php?tab=social">
	<div class="title">Share Buttons</div>
	<?php foreach($data['share_buttons']['available'] as $share_button) { ?>
	<input type="checkbox" id="share<?php echo $share_button; ?>" name="share_buttons[<?php echo $share_button; ?>]" <?php
if(in_array($share_button, $data['share_buttons']['enabled'])){
	echo "checked='checked'";
}
?> />
	<label for="share<?php echo $share_button; ?>"><?php echo ucwords($share_button); ?></label>
	<br/>
	<?php } ?>
	<br/>
	<input type="submit" value="Save" />
</form></div>
