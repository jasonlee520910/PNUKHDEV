<?php
function upload($type,$staffid,$language)
{
	$img_txt="이미지첨부";
	
	if($language == "chn")
		$img_txt="附加图片";
	else if($language == "eng")
		$img_txt="image upload";
	else 
		$img_txt="파일첨부";
	
	$str="";
	$str.='<div class="upload">';
	$str.='	<div class="uploaddiv">';
	$str.='	<form id="frm" method="post" enctype="multipart/form-data">';
	$str.='		<span class="fileNone">';
	$str.='			<input type="file" name="uploadFile" id="input_imgs" onchange="fileup()" />';
	$str.='			<input type="text" name="filecode" id="filecode" data-type="'.$type.'" value="'.$type.'|add|1">';
	$str.='			<input type="text" name="fileck" id="fileck" value="'.$staffid.'|'.$language.'">';
	$str.='		</span>';
	$str.='		<button type="button" class="sp-btn" onclick="uploadImage();">'.$img_txt.'</button>';
	$str.='	</form>';
	$str.='	</div>';
	$str.='	<div class="progress">';
	$str.='		<div class="bar" id="bar"></div>';
	$str.='		<div class="percent" id="percent">0%</div>';
	$str.='	</div>';
	$str.='	<div>';
	$str.='		<div class="imgs_wrap" id="imgs_wrap_id"></div>';
	$str.='	</div>';
	//$str.='	<div id="status" style="border:1px solid green;"></div>';
	$str.='</div>';
	return $str;
}
?>
