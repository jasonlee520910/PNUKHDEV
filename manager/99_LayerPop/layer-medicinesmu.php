<?php   //약재관리_세명대
	$root = "..";
	include_once $root."/_common.php";

	if($_GET["searchPop"])
	{
		$arr=explode("|",$_GET["searchPop"]);
		foreach($arr as $val)
		{
			$arr2=explode(",",$val);
			${$arr2[0]}=$arr2[1];
		}
	}
	$_GET["searchType"]=$searchType;
	$_GET["searchTxt"]=$searchTxt;

	if($_GET["type"]=="")$type=$_GET["type"]="medicinesmu";
	if($_GET["page"]=="")$page=$_GET["page"]=1;
	if($_GET["psize"]=="")$psize=$_GET["psize"]=5;
	if($_GET["block"]=="")$block=$_GET["block"]=10;
	$_GET["reData"]=$_GET["type"];

	$apimedicineData = "reData=".$_GET["reData"]."&returnData=".$_GET["returnData"]."&page=".$_GET["page"]."&psize=".$_GET["psize"]."&block=".$_GET["block"]."&searchPop=".URLEncode($_GET["searchPop"]);

	$pagegroup = "medicine";
	$pagecode = "smumedicinelist";

?>
<style>
.delspan{position:relative;display:none;overflow:hidden;width:0;height:0;}
.delspan .delbtn{position:absolute;background:#fff;color:#111;padding:0 5px 0 5px;cursor:pointer;}
#popmedilist dt{display:inline-block;background:#215295;color:#fff;padding:5px;margin:0 3px 3px 0;}
#popmedilist dt.dismatch{background:red;}
#popmedilist dt.poison{background:#444;}
#popmedilist dd{display:none;}
.stuff-list{min-height:20px;}
.stuff-list .btxt{clear:both;margin-top:-9px;}
.stuff-tab{padding:0 0 5px 0;overflow:hidden;}
.stuff-tab dl{clear:both;padding:3px 0 0 0;}
.stuff-tab dl dt{float:left;width:13px;height:13px;margin-right:0;}
.stuff-tab dl dd{float:left;line-height:110%;}
.stuff-tab .dismatchtxt dt{background:red;}
.stuff-tab .poisontxt dt{background:#444;}
</style>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<!-- s: 약재검색 -->
<div class="layer-wrap" id="layer_medicine_wrap">
	<div class="layer-top">
		<h2><?=$txtdt["1199"]?><!-- 약재검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con">
			<input type="hidden" name="poptype" value="<?=$_GET["type"]?>">
			<input type="hidden" name="popcode" value="<?=$_GET["code"]?>">
			<input type="hidden" name="rcMedicine_pop" value="" style="width:100%;">
			<input type="hidden" name="medititle" value="" >
			<input type="hidden" name="mediorigine" value="" >
			<input type="hidden" name="medihub"  value="" >
			<input type="hidden" name="medicode"  value="" >

			<div class="list-select">
				<p class="fl"><?=selectsearch()?></p>
			</div>
			<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table id="laymedicinetbl" class="layertbl" style="table-layout:fixed">
				<colgroup>
				 <col scope="col" width="20%">
				 <col scope="col" width="*%">
				 <col scope="col" width="20%">
				 <col scope="col" width="17%">
				 <col scope="col" width="17%">
				</colgroup>
				<thead>
			 		<tr>
						<!-- <th><?=$txtdt["1131"]?><!-- 본초코드 --><!-- </th> -->
						<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
						<th><?=$txtdt["1213"]?><!-- 약재코드 --></th>
						<th><?=$txtdt["1204"]?>_한글<!-- 약재명 --></th>
						<!-- <th><?=$txtdt["1204"]?>_中文<!-- 약재명 --><!-- </th>  -->
						<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
						<th><?=$txtdt["1288"]?><!-- 제조사 --></th>
					</tr>
				</thead>
				 <tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="smumedicinelistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>

<script>
	function putpopdata(obj)
	{
		var mediCode123=$(obj).find("td:eq(0)").text(); //본초이름
		var mediCode=$(obj).find("td:eq(1)").text();  //약재코드

		var mediName=$(obj).find("td:eq(2)").text();  //약재명
		var mdOrigin=$(obj).find("td:eq(3)").text();  //원산지 
		var mdMaker=$(obj).find("td:eq(4)").text();  //제조사

		$("input[name=djmediCode]").val(mediCode); //약재코드
		$("input[name=mdCode]").val(mediCode);  //약재코드

		$("#djmediNameKor").text(mediName);
		//$("#djmediNameChn").text(mediTitleChn);

		$("input[name=smuCode]").val(mediCode);  //약재코드

		//$("input[name=mm_code]").val(mediCode); //약재코드

		$("input[name=md_origin]").val(mdOrigin);   //원산지
		$("input[name=md_maker]").val(mdMaker);   //제조사 

		closediv('viewlayer');
	}

	callapi('GET','medicine','smumedicinelist','<?=$apimedicineData?>');
</script>

