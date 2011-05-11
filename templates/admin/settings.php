<div class="title">Settings</div>
<div class="box">
	<form method="post" action="settings.php">
	<table>
		<?php foreach($data as $group => $settings) { ?>
		<tr>
			<th colspan="2"><?php echo $group; ?></th>
		<?php foreach($settings as $key => $setting) { ?>
		<tr>
			<td><?php echo $setting['name']; ?></td>
			<td><input type="text" name="<?php echo $key; ?>"
				value="<?php echo $setting['value']; ?>" /></td>
		</tr>
		<?php } } ?>
	</table>
	</form>
</div>