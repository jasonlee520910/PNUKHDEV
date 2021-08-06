<?php 
	$root = "..";
	include_once $root."/_common.php";

	$page = $_GET["page"];//현재페이지
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//
	$miUserid=$_GET["miUserid"];//


	if($_GET["searchPop"])
	{
		$searchPop = $_GET["searchPop"];//
		$arr=explode("|",$_GET["searchPop"]);
		foreach($arr as $val)
		{
			$arr2=explode(",",$val);
			${$arr2[0]}=$arr2[1];
		}
	}
	$_GET["searpoptxt"]=$searpoptxt;

	$apidata = "page=".$page."&psize=".$psize."&block=".$block."&miUserid=".$miUserid."&searchPop=".$searchPop;
	$pagegroup = "member";
	$pagecode = "commpacking";
?>
<!-- s: 한의원 검색 -->
<style>
	.medical-detail{display:none;}
</style>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2>공통 포장재 가져오기<?//=$txtdt["1405"]?><!-- 한의원 검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<!-- s: 한의원 검색 결과 -->
	<div class="layer-con medical-result">
		<div class="list-select">
			<p class="fl">
				<input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searpoptxt" value="<?=$_GET["searpoptxt"]?>" onkeydown="searchpopkeydown(event)" />
				<button type="button" class="cdp-btn medical-btn"  onclick="pop_search()"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>

				<!-- <?=str_replace("00","<strong>".$json["tcnt"]."</strong>",$txtdt["1020"])?> -->
				<!-- <a href="javascript:;" class="cw-btn mg10r medical-prev"><span>◀</span></a>
				병원 아이디 <span class="cblue">--> <!-- 검색 결과 총 <strong><?//=$json["tcnt"]?></strong>건이 검색 되었습니다. -->
			</p>
		</div>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table class="poptbl" id="pop_cptbl">
				<colgroup>
				<col width="20%">
				<col width="20%">
				<col width="20%">
				<col width="20%">		
				<col width="*">
				</colgroup>
				<thead>
				 <tr>
					<th><?=$txtdt["1247"]?><!-- 이미지 --></th>
					<th><?=$txtdt["1132"]?><!-- 분류 --></th>			
					<th><span class="nec"><?=$txtdt["1392"]?><!-- 포장재코드 --></span></th>
					<th><span class="nec"><?=$txtdt["1440"]?><!-- 1440 --></span></th>				
					<th><?=$txtdt["1072"]?><!-- 등록일 --></th>
					</tr>
				</thead>
				 <tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="commpacklistpage"></div>
		<!-- e : 게시판 페이징 -->
		<div class="mg20t c">
			<!-- <a href="javascript:;" class="cdp-btn medical-btn research"><span><?=$txtdt["1493"]?>재검색</span></a> -->
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>

	function popcompackdata(obj)
	{
		var seq=obj.getAttribute("data-seq");  //포장재 seq 
		//var fseq=obj.getAttribute("data-fseq"); //이미지 seq
		//var code=obj.getAttribute("data-code");  //포장재의 코드값
		var miUserid=$("input[name=miUserid]").val();
		//var ck_stStaffid=getCookie("ck_stStaffid");
		//var type=code.substring(0,3);
		//var newpbCode = getNowFull(2);
		//var pbCode=type+newpbCode;

		console.log("popcompackdata  seq = " + seq+", miUserid = " + miUserid);

		var data="seq="+seq+"&miUserid="+miUserid;


		callapi('GET','member','commpackingupdate',data);
		closediv('viewlayer');
	}

	//주문리스트 API 호출
	callapi('GET','member','commpacking',"<?=$apidata?>");

</script>
