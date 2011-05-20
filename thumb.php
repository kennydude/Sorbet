<?php
/**
 * Create a thumbnail image from $inputFileName no taller or wider than
 * $maxSize. Returns the new image resource or false on error.
 * Author: mthorn.net
 */
function thumbnail($inputFileName, $maxWidth = 100, $maxHeight = 100) {
	$info = getimagesize($inputFileName);
	
	$type = isset($info['type']) ? $info['type'] : $info[2];
	
	// Check support of file type
	if ( !(imagetypes() & $type) )
	{
		// Server does not support file type
		return false;
	}
	
	$width  = isset($info['width'])  ? $info['width']  : $info[0];
	$height = isset($info['height']) ? $info['height'] : $info[1];
	
	// Calculate aspect ratio
	$wRatio = $maxWidth / $width;
	$hRatio = $maxHeight / $height;
	
	// Using imagecreatefromstring will automatically detect the file type
	$ext = strtolower(substr($inputFileName, strrpos($inputFileName, '.')));
	if($ext == ".png"){
		$sourceImage = imagecreatefrompng($inputFileName);
		imagealphablending($sourceImage, true);
	} else
		$sourceImage = imagecreatefromstring(file_get_contents($inputFileName));
		
	// Calculate a proportional width and height no larger than the max size.
	if ( ($width <= $maxWidth) && ($height <= $maxHeight) )
	{
		// Input is smaller than thumbnail, do nothing
		return $sourceImage;
	}
	elseif ( ($wRatio * $height) < $maxWidth )
	{
		// Image is horizontal
		$tHeight = ceil($wRatio * $height);
		$tWidth  = $maxWidth;
	}
	else
	{
		// Image is vertical
		$tWidth  = ceil($hRatio * $width);
		$tHeight = $maxHeight;
	}
	
	$thumb = imagecreatetruecolor($tWidth, $tHeight);
	
	if ( $sourceImage === false )
	{
		// Could not load image
		return false;
	}
	
	$white = imagecolorallocate($thumb, 255, 255, 255);
	imagefilledrectangle($thumb, 0, 0, $tWidth, $tHeight, $white);
	// Copy resampled makes a smooth thumbnail
	imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height);
	imagedestroy($sourceImage);
	
	return $thumb;
}

/**
 * Save the image to a file. Type is determined from the extension.
 * $quality is only used for jpegs.
 * Author: mthorn.net
 */
function imageToFile($im, $fileName, $quality = 80)
{
	if ( !$im || file_exists($fileName) ) {
		return false;
	}
	
	$ext = strtolower(substr($fileName, strrpos($fileName, '.')));
	
	switch ( $ext ) {
		case '.gif':
			imagegif($im, $fileName);
			break;
		case '.jpg':
		case '.jpeg':
			imagejpeg($im, $fileName, $quality);
			break;
		case '.png':
			imagepng($im, $fileName);
			break;
		case '.bmp':
			imagewbmp($im, $fileName);
			break;
		default:
			return false;
	}
	return true;
}

// @kennydude code!

if(!$_GET['file'] || !$_GET['width'] || !$_GET['height']){
	die("ERROR: Misconfigured url. This url will be invoked by Sorbet itself. Please use the admin to generate a post with an image");
}
$file = realpath("files/") . "/" . $_GET['file'];
if(!file_exists($file)){
	die("ERROR: File '".$_GET['file']."' doesn't exist");
}
$thumb_url = "files/thumb/" . $_GET['file'] . "_" . sha1($_GET['width'] . 'x' . $_GET['height']) . ".jpg";
if(file_exists($thumb_url) && $_GET['refresh'] != "true"){
	header("Location: $thumb_url");
	exit();
}
// Actually thumbnail now!
header("X-SORBET: GENERATED");
$img = thumbnail($file, $_GET['width'], $_GET['height']);
if($img == false)
	die("ERORR: Image couldn't be thumbnailed");
imageToFile($img, $thumb_url);
header("Content-type: image/jpeg");
imagejpeg($img);