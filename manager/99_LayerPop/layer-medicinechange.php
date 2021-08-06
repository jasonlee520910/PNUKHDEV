<?php 
	$root = "..";
	include_once $root."/_common.php";

	$page = $_GET["page"];//현재페이지
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//

	$title=$_GET["title"];
	$medicode=$_GET["medicode"];	

	$apiData = "page=".$page."&psize=".$psize."&block=".$block."&title=".$title."&medicode=".$medicode;

	$pagegroup = "medicine";
	$pagecode = "changemedicodelist";
?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><?=$title?></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<!-- s: 약재 검색 결과 -->
	<div class="layer-con medical-result">
		<!-- <div class="list-select">
			<p class="fl">
				<input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searpoptxt" value="<?=$_GET["searpoptxt"]?>" onkeydown="searchpopkeydown(event)" />
				<button type="button" class="cdp-btn medical-btn"  onclick="pop_medicinesearch()"><span><?=$txtdt["1020"]?>검색</span></button>
			</p>
		</div> -->
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table class="poptbl" id="pop_medichangetbl">
				<colgroup>
				 <col scope="col" width="20%">
				 <col scope="col" width="*">
				 <col scope="col" width="20%">
				 <col scope="col" width="20%">
				</colgroup>
				<thead>
					<tr>
						<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
						<th><?=$txtdt["1204"]?><!-- 약재명 --></th>
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
		<div class='pagingpop-wrap' id="medilistpage"></div>
		<!-- e : 게시판 페이징 -->
		<div class="mg20t c">
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>
	//table tr 클릭시 
	function putpopdata(obj)
	{
		console.log("putpopdata 약재 클릭시  ===========================  ");
		var newmedicode=obj.getAttribute("data-newcode");
		var medicode=obj.getAttribute("data-code");
		var meditype=obj.getAttribute("data-type");
		var medititle=$(obj).find("td:eq(1)").text();
		var mediorigin=$(obj).find("td:eq(2)").text();
		var medimaker=$(obj).find("td:eq(3)").text();
		var odKeycode=$("input[name=odKeycode]").val();

		console.log("odKeycode = "+odKeycode+", meditype="+meditype+", medititle="+medititle+", newmedicode = "+newmedicode+", medicode = "+medicode+", mediorigin = " + mediorigin+", medimaker="+medimaker);

		if(meditype=="medicine")
		{
			//if(confirm("약재명 : "+medititle+"\n원산지 : "+mediorigin+"\n제조사 : " + medimaker +"\n로 변경하시겠습니까?"))
			if(confirm("약재 : "+medititle+" / "+mediorigin+" / " + medimaker +"로 변경하시겠습니까?"))
			{
				var url="odKeycode="+odKeycode+"&medicode="+medicode+"&newmedicode="+newmedicode+"&meditype="+meditype;
				console.log("url = " + url);
				callapi('GET','medicine','changemedicodeupdate',url);
			}
		}
		else
		{
			alert("약재만 변경 가능합니다.");
		}
	}
	//주문리스트 API 호출
	callapi('GET','medicine','changemedicodelist',"<?=$apiData?>");
</script>
