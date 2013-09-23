<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title>Journalness - Upload</title>
  <link rel="stylesheet" type="text/css" href="templates/{$theme}/style.css"/>
</head>
<body style="background-color:#EEEEEE;">
{section name=imageuploaded show=$show_image_uploaded}
<table border="0" width="100%" style="height:100%;">
  <tr>
    <td align="center">
	<p>{$L_IMAGE_UPLOADED}</p><br/>
	<p><a href="javascript:void(window.close())">{$L_CLOSE_WINDOW}</a></p>
    </td>
  </tr>
</table>
<script type="text/javascript">
	window.onload=opener.addSelectOption('{$text}', '{$value}');
</script>
{/section}
{section name=uploadform show=$show_upload_form}
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%;">
  <tr>
    <td align="center" valign="top">
	<br/><h4>{$L_UPLOAD_PICTURE}</h4><br/>
	<form style="border-bottom:0;" enctype="multipart/form-data" action="upload.php" method="post"> 
	<div><input name="userfile" type="file"/>
	<input type="submit" value="{$L_UPLOAD}" name="file_uploaded"/></div>
	</form>
    </td>
  </tr>
</table>
{/section}
{section name=imagetoolarge show=$show_image_too_large}
<table border="0" width="100%" style="height:100%;">
  <tr>
    <td align="center">
	<h4>{$L_ERROR}</h4> 
	<p>{$L_IMAGE_TOO_LARGE}</p>
    </td>
  </tr>
</table>
{/section}
{section name="notuploaded" show=$show_picture_not_uploaded}
<table border="0" width="100%" style="height:100%;">
  <tr>
    <td align="center">
	<h4>{$L_ERROR}</h4>
	<p>{$L_IMAGE_NOT_UPLOADED}</p>
    </td>
  </tr>
</table>
{/section}
{section name="invalidfiletype" show=$show_invalid_filetype}
<table border="0" width="100%" style="height:100%;">
  <tr>
    <td align="center">
	<h4>{$L_ERROR}</h4>
	<p>{$L_INVALID_FILETYPE}</p>
    </td>
  </tr>
</table>
{/section}
</body>
</html>
