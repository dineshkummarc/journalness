<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Upload
{

	function Upload(){

	}

	function addPicture($type="0"){
		global $database, $session;

		$unique_name = uniqid(rand(), true);
		$extension = explode('.', $_FILES['userfile']['name']);
		$extension = array_pop($extension);
		$extension = strtolower($extension);
		$extension = addslashes($extension);

		if($type){
			$file = $_FILES['userfile']['tmp_name'];
			$handle = fopen($file,'r');
			$file_content = fread($handle,filesize($file));
			fclose($handle);
			$encoded = chunk_split(base64_encode($file_content));

			$query = "INSERT INTO #__uploads (image_name, image_path, image_data, uid) VALUES ('" . $_FILES['userfile']['name'] . "', '[img]image.php?image=" . $unique_name . "." . $extension . "[/img]', '" . $encoded . "', '" . $session->uid . "')";
			$result = $database->Execute($query);

			$value = "[img]image.php?image=" . $unique_name . "." . $extension . "[/img]";
		}else{
			if(!is_dir('uploads/' . $session->uid)){
				mkdir('uploads/' . $session->uid, 0775);
			}
			copy($_FILES['userfile']['tmp_name'], 'uploads/' . $session->uid . '/' . $unique_name . '.' . $extension)
				or die('Could not copy the file. Please try again later.');

			$query = "INSERT INTO #__uploads (image_name, image_path, uid) VALUES ('" . $_FILES['userfile']['name'] . "', '[img]uploads/" . $session->uid . "/" . $unique_name . "." . $extension . "[/img]', '" . $session->uid . "')";
			$result = $database->Execute($query);

			$value = "[img]uploads/" . $session->uid . "/" . $unique_name . "." . $extension . "[/img]";
		}

		return $value;
	}

}

$upload = new Upload;

?>