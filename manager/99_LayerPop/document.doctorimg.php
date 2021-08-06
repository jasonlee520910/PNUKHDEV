<?php 
	//20190906 : 바코드 일괄 출력 
	$root = "..";
	$img=$_GET["url"];
	include_once ($root.'/cmmInc/headPrint.php');

?>
<div class="fl">
	<img src="<?=$NET_FILE_URL?><?=$img?>" />
</div>