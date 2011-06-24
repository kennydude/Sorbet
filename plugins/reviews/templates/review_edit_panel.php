<!-- Review Edit Panel -->
<!-- TODO: Customizable? -->
<?php
function x($v){
	if($page->data->extra_data['rating'] == $v){
		echo "selected='selected'";
	}
}
?>
Product Rating:<br/>
<select id="ratingBox" name="extra_data[rating]">
	<option <?php echo x("1"); ?> value="1">1 Star</option>
	<option <?php echo x("2"); ?> value="2">2 Stars</option>
	<option <?php echo x("3"); ?> value="3">3 Stars</option>
	<option <?php echo x("4"); ?> value="4">4 Stars</option>
	<option <?php echo x("5"); ?> value="5">5 Stars</option>
</select>
<div id="niceRatingBox"></div>
<script type="text/javascript">
var rating = <?php echo $page->data->extra_data['rating'] * 1; ?>;
var fullstar = "<?php echo resdir(); ?>/star.png";
var nostar = "<?php echo resdir(); ?>/star-empty.png";
$(document).ready(function(){
	$("#ratingBox").hide();
	for(var i = 1; i <= 5; i++){
		img = $("<img>").attr("id", "niceRating" + i).appendTo("#niceRatingBox").mouseover(function(){
			$(this).attr("src", fullstar).prevAll().attr("src", fullstar);
			$(this).nextAll().attr("src", nostar);
		}).click(function(){
			$(this).attr("src", fullstar).attr("data-proper-src", fullstar).prevAll().attr("src", fullstar).attr("data-proper-src", fullstar);
			$(this).nextAll().attr("src", nostar).attr("data-proper-src", nostar);
			$("#ratingBox").val($(this).attr("data-value"));
		}).attr("data-value", i);
		if(i <= rating){
			img.attr("src", fullstar).attr("data-proper-src", fullstar);
		} else{
			img.attr("src", nostar).attr("data-proper-src", nostar);
		}
	}
	$("#niceRatingBox").mouseout(function(){
		$("#niceRatingBox img").each(function(){ $(this).attr("src", $(this).attr("data-proper-src")); });
	});
});
</script>
<br/>
Product Link:<br/>
<input type="text" name="extra_data[review_url]" value="<?php echo $page->data->extra_data['review_url']; ?>" />
