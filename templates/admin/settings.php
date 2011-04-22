<div class="title">Settings</div>
<div class="box">
	<form method="post" action="settings.php">
	<table>
		<?php foreach($data as $key => $setting) { ?>
		<tr>
			<th><?php echo $setting['name']; ?></th>
			<td><input type="text" name="<?php echo $key; ?>"
				value="<?php echo $setting['value']; ?>" /></td>
		</tr>
		<?php } ?>
	</table>
	</form>
</div>