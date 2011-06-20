<div class="title">Plugins</div>
<?php cie("mid_header"); ?>
<div class="box">
	<form method="post" action="settings.php?tab=plugins">
	<input type="hidden" name="__" value="y" />
	<table style="width: 100%">
		<?php 
		foreach($data as $code => $plugin){
			$selected = $plugin['selected'] ?  "checked='checked'" : "";
			?>
			<tr>
				<td>
					<input type="checkbox" <?php echo $selected; ?> name="<?php echo $code; ?>"
							id="plugin-<?php echo $code; ?>" />
				</td>
				<td style="width: 100%">
					<label for="plugin-<?php echo $code; ?>" style="width:100%;display:block">
						<b><?php echo $plugin['plugin_name']; ?></b>
						<br/>
						<?php echo $plugin['plugin_description']; ?>
						<br/>
						<small>
							Created by <?php echo $plugin['plugin_creator']; ?>
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
