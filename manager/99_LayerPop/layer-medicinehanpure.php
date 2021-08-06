<?php 
	$root = "..";
	include_once $root."/_common.php";

	$page = $_GET["page"];//현재페이지
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//

	$medicine=$_GET["medicine"];
	$medititle=$_GET["medititle"];
	$odKeycode=$_GET["odKeycode"];
	$site=$_GET["site"];
	

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

	$apiData = "page=".$page."&psize=".$psize."&block=".$block."&searchPop=".$searchPop."&site=".$site;

	$pagegroup = "medicine";
	$pagecode = "medicinehanpurelist";
?>
<style>
	.medical-detail{display:none;}
</style>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><?=$txtdt["1199"]?><!-- 약재검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<!-- s: 약재 검색 결과 -->
	<div class="layer-con medical-result">
		<div class="list-select">
			<p class="fl">
				<input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searpoptxt" value="<?=$_GET["searpoptxt"]?>" onkeydown="searchpopkeydown(event)" />
				<button type="button" class="cdp-btn medical-btn"  onclick="pop_medicinesearch()"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>
			</p>
		</div>
		<p style="font-size:15px;font-weight:bold;color:red;margin-bottom:7px;">
			[<?=$site?>]<?=$medititle?>(<?=$medicine?>)<br>
		</p>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table class="poptbl" id="pop_medicaltbl">
				<colgroup>
				 <col scope="col" width="20%">
				 <col scope="col" width="*">
<!-- 				 <col scope="col" width="10%"> -->
				 <col scope="col" width="20%">
				 <col scope="col" width="20%">
				</colgroup>
				<thead>
					<tr>
						<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
						<th><?=$txtdt["1204"]?><!-- 약재명 --></th>
<!-- 						<th><?=$txtdt["1588"]?>가격</th> -->
						<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
						<th><?=$txtdt["1602"]?><!-- 조제사 --></th>
					</tr>
				</thead>
				 <tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="medicallistpage"></div>
		<!-- e : 게시판 페이징 -->
		<div class="mg20t c">
			<!-- <a href="javascript:;" class="cdp-btn medical-btn research"><span><?=$txtdt["1493"]?>재검색</span></a> -->
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>
	//table tr 클릭시 
	function putpopdata(obj)
	{
		console.log("putpopdata 약재 클릭시  ===========================  ");

		var medititle="<?=$medititle?>";
		var clickmedititle=$(obj).find("td:eq(1)").text();//약재명 
		var clickmedicode=obj.getAttribute("data-medicode");
		var site="<?=$site?>";
		var cymedicode="<?=$medicine?>";

		var message="<?=$txtdt['1866']?>";//등록할 약재 : [1]선택한 약재 : [2]선택하신 약재로 등록하시겠습니까?
		message=message.replace("[1]",medititle+"\n");
		message=message.replace("[2]",clickmedititle+"\n\n");

		if(confirm(message) == true)
		{	
			closediv('viewlayer');
			var url="odKeycode=<?=$odKeycode?>&medicine="+clickmedicode+"&medititle="+medititle+"&site="+site+"&cymedicode="+cymedicode;
			console.log("url = " + url);
			callapi('GET','medicine','nonemedicine',url);
		}
	}
	//검색
	function pop_medicinesearch()
	{
		subpage_pop(1,5,10, null);
	}

	//주문리스트 API 호출
	callapi('GET','medicine','medicinehanpurelist',"<?=$apiData?>");
	$("input[name=searpoptxt]").focus();
</script>
