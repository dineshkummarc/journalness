<?php

// no direct access
defined( '_VALID_JOURNALNESS' ) or die( 'Restricted access' );

class Images {

	function Images(){

	}

	function getUploads($uid){
		global $database, $journalnessConfig_absolute_path, $journalnessConfig_live_site;

		if($uid == 0){
			$query = "SELECT DISTINCT(up.uid), u.username FROM #__uploads AS up LEFT JOIN #__users AS u ON u.id = up.uid ORDER BY up.uid";
			$result = $database->GetArray($query);
		}else{
			$uid = intval($uid);
			$uid = $database->QMagic($uid);
			$query = "SELECT * FROM #__uploads WHERE uid = $uid ORDER BY id";
			$result = $database->GetArray($query);

			for($i=0; $i<count($result); $i++){
				$width = 95;
				$height = 95;

				$result[$i]['image_path'] = str_replace("[img]", "", $result[$i]['image_path']);
				$result[$i]['image_path'] = str_replace("[/img]", "", $result[$i]['image_path']);

				if(isset($result[$i]['image_data'])){
					$img_info = @getimagesize($journalnessConfig_live_site . "/" . $result[$i]['image_path']);
				}else{
					$img_info = @getimagesize($journalnessConfig_absolute_path . "/" . $result[$i]['image_path']);
				}

				$result[$i]['image_width_orig'] = $img_info[0];
				$result[$i]['image_height_orig'] = $img_info[1];
      			$ratio_orig = $img_info[0]/$img_info[1];
      
      			if ($width/$height > $ratio_orig) {
					$width = $height*$ratio_orig;
				} else {
					$height = $width/$ratio_orig;
				}
				$result[$i]['image_width'] = $width;
				$result[$i]['image_height'] = $height;
			}
		}
		return $result;
	}

	function getImageInfo($id){
		global $database, $adminsession;

		$id = $database->QMagic($id);
		$query = "SELECT id, image_name, uid FROM #__uploads WHERE id = $id AND (uid = '$adminsession->uid' OR '$adminsession->is_admin')";
		$results = $database->GetArray($query);

		return $results[0];
	}

	function saveImageInfo($id, $image_name){
		global $database, $adminsession;

		$id = $database->QMagic($id);
		$image_name = $database->QMagic($image_name);
		$query = "UPDATE #__uploads SET image_name = $image_name WHERE id = $id AND (uid = '$adminsession->uid' OR '$adminsession->is_admin')";
		$result = $database->Execute($query);

		return $result;
	}

	function deleteImage($id){
		global $database, $adminsession, $journalnessConfig_absolute_path;

		$id = $database->QMagic($id);
		$query = "SELECT image_path, image_data FROM #__uploads WHERE id = $id AND (uid = '$adminsession->uid' OR '$adminsession->is_admin')";
		$result = $database->GetArray($query);
		$image_data = $result[0]['image_data'];
		$image_path = $result[0]['image_path'];
		$image_path = str_replace("[img]", "", $image_path);
		$image_path = str_replace("[/img]", "", $image_path);

		$query = "DELETE FROM #__uploads WHERE id = $id AND (uid = '$adminsession->uid' OR '$adminsession->is_admin')";
		$result = $database->Execute($query);

		if($result && empty($image_data)){
      		unlink($journalnessConfig_absolute_path . '/' . $image_path);

			return true;
		}

		return false;
	}

}

$images = new Images;