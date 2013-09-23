<?php

require_once( 'common.inc.php' );

$filename = $_GET['file'];

$loc = explode("/", $filename);

// Make sure image only comes from upload folder
if($loc[0] == "uploads"){

      list($width_orig,$height_orig,$type_orig)=@getimagesize($filename);
      
      $width = $journalnessConfig_resize_images_width;
      $height = $journalnessConfig_resize_images_height;
      
      if($width_orig > $width || $height_orig > $height){
      
      	switch($type_orig) {
      		case 1:  header('Content-type: image/gif');
      		break;
      
      		case 2:  header('Content-type: image/jpeg');
      		break;
      
      		case 3:  header('Content-type: image/png');
      		break;
      
      		default: die("Unkown filetype");
      		return;
      	}
      
      	$ratio_orig = $width_orig/$height_orig;
      
      	if ($width/$height > $ratio_orig) {
      		$width = $height*$ratio_orig;
      	} else {
      		$height = $width/$ratio_orig;
      	}
      
      	$image_p = imagecreatetruecolor($width, $height);
      
      	switch($type_orig) {
      		case 1:  $image = imagecreatefromgif($filename);
      		break;
      
      		case 2:  $image = imagecreatefromjpeg($filename);
      		break;
      
      		case 3:  $image = imagecreatefrompng($filename);
      			   imagealphablending($image_p, false);
      		break;
      
      		default: die("Unkown filetype");
      		return;
      	}
      
      	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
      
      	switch($type_orig) {
      		case 1:  imagegif($image_p);
      		break;
      	
      		case 2:  imagejpeg($image_p, null, 100);
      		break;
      
      		case 3:  imagesavealpha($image_p, true);
      			   imagepng($image_p);
      		break;
      
      		default: die("Unkown filetype");
      		return;
      	}
      
      }else{
      
      	switch($type_orig) {
      		case 1:  header('Content-type: image/gif');
      		$image = imagecreatefromgif($filename);
      		imagegif($image);
      		break;
      
      		case 2:  header('Content-type: image/jpeg');
      		$image = imagecreatefromjpeg($filename);
      		imagejpeg($image, null, 100);
      		break;
      
      		case 3:  header('Content-type: image/png');
      		$image = imagecreatefrompng($filename);
      		imagepng($image);
      		break;
      
      		default: die("Unkown filetype");
      		return;
      	}
      
      }

}

?> 
