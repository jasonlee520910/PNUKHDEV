<?php
	//
	$root = "../..";
	include_once $root."/_common.php";
?>
<div class="gap"></div>
<h3 class="u-tit02"><span class=""><?=$txtdt["1118"]?><!-- 복약지도 --></span></h3>
<!-- <div id="odCareDiv" style="margin-bottom:5px;"></div>
<div id="selAdviceDiv" style="margin-bottom:5px;"></div> -->
<input type="hidden" name="odAdvicekey" class="reqdata" value="">
<div id="odAdviceDiv" style="margin-bottom:5px;"></div>
<div id="odAdviceDownload">
<a href="" class="cw-btn" id="adfile">
	<span>다운로드</span>
</a>
</div>
<div class="order-txt">
	<textarea name="odAdvice" class="reqdata" title="<?=$txtdt["1118"]?>"></textarea>
</div>

<!-- <div class="gap"></div>
<h3 class="u-tit02"><span class="">조제지시</h3>
<div id="odCommentDiv" style="margin-bottom:5px;"></div> -->
