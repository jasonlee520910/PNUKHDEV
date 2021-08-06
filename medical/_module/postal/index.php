<?php
	$root="../..";
	$postal=$root."/_module/postal";
	include_once $root."/_common.php";
?>
<script>
//우편번호조회 click
$(".postalbtn").on("click",function()
{
	$("input[name=currentPage]").val(1);
	postallist();
});
//우편번호조회 keydown
$(".postaldown").keyup(function(e)
{
	if(e.keyCode==13)
	{
		$("input[name=currentPage]").val(1);
		postallist();
	}
});
</script>
<body>
<link type="text/css" rel="stylesheet" href="<?=$postal?>/postal.css?v=<?=time();?>" />
<script src="<?=$postal?>/postal.js"></script>
<input type="hidden" style="width:100%;" name="apiUrl" value="http://www.juso.go.kr/addrlink/addrLinkApi.do">
<input type="hidden" style="width:100%;" name="confmKey" value="U01TX0FVVEgyMDE2MTAyNDExNDM0MDE1OTAx">
<input type="hidden" name="currentPage" value="1">
<input type="hidden" name="countPerPage" value="5">
<input type="hidden" name="zipfld" value="<?=$_GET["zipfld"]?>">
<input type="hidden" name="addrfld" value="<?=$_GET["addrfld"]?>">
<h1><?//=$txtdt["1479"]?>우편번호검색<!-- 우편번호검색 --><span class="closebtn" onclick="closediv('viewlayer')">닫기<?//=$txtdt["1595"]?><!-- 닫기 --></span></h1>
<ul id="zipdiv" class="zipdiv">
	<li class="search"><input type="text" name="keyword" id="keyword" value="" class="postaldown" style="border:1px solid #aaa;height:25px;float:left;"><span class="btn postalbtn" style="width:100px;height:27px;padding:10px 30px;text-align:center;float:left;">찾기<?//=$txtdt["1499"]?><!-- 찾기 --></span><p>도로명, 건물명, 지번에 대해 통합검색이 가능합니다.(예: 반포대로 58, 국립중앙박물관, 삼성동 25)<?//=$txtdt["1500"]?><!-- 도로명, 건물명, 지번에 대해 통합검색이 가능합니다.(예: 반포대로 58, 국립중앙박물관, 삼성동 25) --></p></li>
	<li id="postallist" class="postallist"><div class="nodata">-</div></li>
</ul>
</body>
<script>$("#keyword").focus();//postallist();</script>