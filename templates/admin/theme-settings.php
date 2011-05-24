<div class="title">Theme Settings</div>
<?php cie("mid_header"); ?>
<div class="box">
	<form method="post" action="settings.php?tab=themes">
	The current theme is called "<?php echo $data['current_theme']['theme_name']; ?>" and
	was created by <?php echo $data['current_theme']['theme_creator']; ?>
	<hr/>
	<h2>Available Themes</h2>
	<table style="width: 100%">
		<?php 
		foreach($data['themes'] as $code => $theme){
			$selected = ($code == $data['current_theme']['codename']) ?  "checked='checked'" : "";
			?>
			<tr>
				<td>
					<input type="radio" <?php echo $selected; ?> name="theme"
							value="<?php echo $code; ?>" id="theme-<?php echo $code; ?>" />
				</td>
				<td style="width: 100%">
					<label for="theme-<?php echo $code; ?>" style="width:100%;display:block">
						<b><?php echo $theme['theme_name']; ?></b>
						<br/>
						<?php echo $theme['theme_description']; ?>
						<br/>
						<small>
							Created by <?php echo $theme['theme_creator']; ?> -- 
							<a target="_blank" href="../index.php?theme=<?php echo $code; ?>">Test Drive</a>
						</small>
					</label>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
	<input type="submit" value="Save" />
	</form>
</div>