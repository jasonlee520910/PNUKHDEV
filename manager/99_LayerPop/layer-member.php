<?php 
	$root = "..";
	include_once $root."/_common.php";

	$page = $_GET["page"];//현재페이지
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//

	$odSite=$_GET["site"];//site 
	$od_medicalname = $_GET["od_medicalname"];//한의원명
	$od_doctorname = $_GET["od_doctorname"];//한의사이름 
	$od_doctorpk = $_GET["od_doctorpk"];//한의사PK
	$od_keycode = $_GET["od_keycode"];//주문키코드 

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

	$apimedicalData = "page=".$page."&psize=".$psize."&block=".$block."&searchPop=".$searchPop;

	$pagegroup = "member";
	$pagecode = "memberlist";
?>
<!-- s: 한의원 검색 -->
<style>
	.medical-detail{display:none;}
</style>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><?=$txtdt["1405"]?><!-- 한의원 검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<!-- s: 한의원 검색 결과 -->
	<div class="layer-con medical-result">
		<div class="list-select">
			<p class="fl">
				<input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searpoptxt" value="<?=$_GET["searpoptxt"]?>" onkeydown="searchpopkeydown(event)" />
				<button type="button" class="cdp-btn medical-btn"  onclick="pop_membersearch()"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>
			</p>
		</div>
		<p style="font-size:15px;font-weight:bold;color:red;margin-bottom:7px;">
			<?=$od_medicalname?> / <?=$od_doctorname?>(<?=$od_doctorpk?>)<br>
		</p>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table class="poptbl" id="pop_medicaltbl">
				<colgroup>
				 <col scope="col" width="*">
				 <col scope="col" width="30%">
				 <col scope="col" width="20%">
				</colgroup>
				<thead>
				 <tr>
					<th><?=$txtdt["1593"]?><!-- 병원명 --></th>
					<th><?=$txtdt["1591"]?><!-- 한의사 --></th>
					<th><?=$txtdt["1591"]?>PK<!-- 한의사PK --></th>
					<th>부산대한의사PK<!-- CYPK --></th>						
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
		console.log("putpopdata 한의원&한의사 클릭시  ===========================  ");

		var medical="<?=$od_medicalname?>";
		var doctor="<?=$od_doctorname?>(<?=$od_doctorpk?>)";
		var keycode="<?=$od_keycode?>";
		var odSite="<?=$odSite?>";

		var clickmedical = $(obj).find("td:eq(0)").text();
		var clickdoctor = $(obj).find("td:eq(1)").text()+"("+$(obj).find("td:eq(2)").text()+")";
		var clickdoctorid = obj.getAttribute("data-doctorid");

		var message="<?=$txtdt['1865']?>";
		message=message.replace("[1]",medical+" / "+doctor+"\n");
		message=message.replace("[2]",clickmedical+" / "+clickdoctor+"\n\n");

		if(confirm(message) == true)
		{
			closediv('viewlayer');

			var url="odKeycode="+keycode+"&site="+odSite+"&memState=change&memDoctorid="+clickdoctorid+"&memDoctorpk=<?=$od_doctorpk?>";
			console.log("url = " + url);
			callapi('GET','member','nonemedical',url);
		}
	}
	//검색
	function pop_membersearch()
	{
		subpage_pop(1,5,10, null);
	}

	//주문리스트 API 호출
	callapi('GET','member','memberlist',"<?=$apimedicalData?>");
	$("input[name=searpoptxt]").focus();
</script>
