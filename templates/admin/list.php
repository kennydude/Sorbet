<div>
	<span class="title"><?php echo $page_data['title']; ?></span>
	<?php foreach($page_data['global_actions'] as $title => $url){ ?>
	<form class="inline" method="get" action="redir.php">
	<input type="hidden" name="url" value="<?php echo $url; ?>" />
	<input type="submit" value="<?php echo $title; ?>" />
	</form>
	<?php } ?>
</div>
<table class="box">
	<tr>
		<?php foreach($page_data['headers'] as $k => $header){
			?><th><?php echo $header; ?></th><?php
		} ?>
		<th>Actions</th>
	</tr>
	<?php foreach($data as $row){ $row = (array) $row; ?>
	<tr>
		<?php foreach($page_data['headers'] as $k => $header){ ?>
			<td><?php echo $row[$k]; ?></td>
		<?php } ?>
		<td>
		<?php foreach($page_data['item_actions'] as $k => $v) { ?>
			<?php
				if(is_callable($v)){
					$url = $v($row);
				} else{
					$url = str_replace("$1", $row['id'], $v);
				}
			?>
			<a href="<?php echo $url; ?>">
				<?php echo $k; ?>
			</a>
		<?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>
