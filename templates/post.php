<h1><a href="<?php echo $data->permalink(); ?>"><?php echo $data->title ?></a></h1>
<?php $data->share_buttons('small'); ?>
<hr/>
<?php echo $data->body_html(); ?>
<?php if(!defined("PAGE_MULTI_POSTS")) { ?>
	<hr/>
	<h2>Comments</h2>
	<?php echo $data->getComments()->render(); ?>
<?php } ?>
