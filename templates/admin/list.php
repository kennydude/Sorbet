<div>
	<span class="title"><?php echo $page_data['title']; ?></span>
	<?php foreach($page_data['global_actions'] as $title => $url){ ?>
	<form class="inline" method="get" action="<?php echo $url; ?>">
	<input type="submit" value="<?php echo $title; ?>" />
	</form>
	<?php } ?>
</div>
<table>
	<tr>
		<?php foreach($page_data['headers'] as $k => $header){
			?><th><?php echo $header; ?></th><?php
		} ?>
		<th>Actions</th>
	</tr>
	<?php foreach($data as $row){ ?>
	<tr>
		<?php foreach($page_data['headers'] as $k => $header){ ?>
			<td><?php echo $row->$k; ?></td>
		<?php } ?>
		<td>
		<?php foreach($page_data['item_actions'] as $k => $v) { ?>
			<a href="<?php echo str_replace("$1", $row->id, $v); ?>">
				<?php echo $k; ?>
			</a>
		<?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>