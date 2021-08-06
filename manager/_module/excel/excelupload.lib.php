<?php 
function excelupload($language, $url)
{	
	$str="";
	$str.='<div class="excelupload">';
	$str.='	<div class="exceluploaddiv">';
	$str.='	<form id="excelfrm" method="post" enctype="multipart/form-data">';
	$str.='		<span class="fileNone">';
	$str.='			<input type="file" name="exceluploadFile" id="exceluploadFile" onchange="excelfileup()" />';
	$str.='			<input type="text" name="filelanguage" id="filelanguage" value="'.$language.'">';
	$str.='			<input type="text" name="fileapiurl" id="fileapiurl" value="'.$url.'">';
	$str.='		</span>';
	$str.='		<button type="button" class="sp-btn" onclick="exceluploadfile();">Excel Upload</button>';
	$str.='	</form>';
	$str.='	</div>';
	$str.='</div>';
	return $str;
}
?>
