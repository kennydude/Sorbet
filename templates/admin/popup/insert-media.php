<div class="title">
	Insert Media
	<form class="inline" method="get" action="../upload-media.php">
		<input type="submit" value="Upload"/>
		<input type="hidden" name="popup" value="true"/>
	</form>
</div>
<noscript>This page is designed for JavaScript only browsers. Sorry!</noscript>
<table class="box">
	<tr>
		<?php $i = 0; foreach($data as $file) { if($i == 5){ echo "</tr><tr>";$i=0; } ?>
			<td style="text-align:center">
				<?php echo $file->get_thumbnail()->render_html(); ?>
				<input class="useme" data-file="<?php echo $file->title; ?>" type="submit" value="Use this file" />
			</td>
		<?php $i++; } ?>
	</tr>
</table>
<script type="text/javascript" src="<?php echo $coredir; ?>/admin/res/insert-media.js"></script>