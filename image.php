<?php

require_once( 'common.inc.php' );

if(isset($_GET['image'])){
	$image = $_GET['image'];
	$image_db = "[img]image.php?image=" . $image . "[/img]";
	$image_db = $database->QMagic($image_db);

	$query = "SELECT image_data FROM #__uploads WHERE image_path = $image_db";
	$result = $database->GetArray($query);
	
	if($result){
		$image_result = $result[0]['image_data'];

		$extension = $image;
		$extension = explode('.', $extension);
		$extension = array_pop($extension);

		switch ($extension){
			case "gif":
				header('Content-type: image/gif');
				echo base64_decode($image_result);
				break;
			case "jpg":
			case "jpeg":
				header('Content-type: image/jpeg');
				echo base64_decode($image_result);
				break;
			case "pjpeg":
				header('Content-type: image/pjpeg');
				echo base64_decode($image_result);
				break;
			case "png":
				header('Content-type: image/png');
				echo base64_decode($image_result);
				break;
			}
	}
}

?>