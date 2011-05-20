<div class="title">Upload Media</div>
<p>If you use a modern web browser, you should be able to upload multiple files</p>
<form method="post" enctype="multipart/form-data" action="upload-media.php?popup=<?php echo $_GET['popup']; ?>">
	<input type="file" multiple="true" name="files" />
	<br/>
	<input type="submit" />
</form>