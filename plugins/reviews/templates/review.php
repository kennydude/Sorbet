<h1><a href="<?php echo $data->permalink(); ?>"><?php echo $data->title ?></a></h1>
<?php echo $data->body_html(); ?>
<p>
	<a href="<?php echo $data->extra_data['review_url']; ?>">Product Link</a>
	<br/>
	This product was given <?php echo $data->extra_data['rating']; ?> stars
</p>
<?php if(!defined("PAGE_MULTI_POSTS")) { ?>
	<hr/>
	<h2>Comments</h2>
	<?php echo $data->getComments()->render(); ?>
<?php } ?>
