<?php 
	$root = "..";
	include_once $root."/_common.php";

	$whStock=$_GET["whStock"];
	$page = $_GET["page"];//현재페이지 
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//

	$apiData = "page=".$page."&psize=".$psize."&block=".$block."&whStock=".$whStock;
?>
<div id="pagegroup" value="stock"></div>
<div id="pagecode" value="medistockdesc"></div>
<input type="hidden" class="reqdata" name="medidescstock" value=""/>
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><?=$txtdt["1709"]?><!-- 입출고 내역 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con medical-result">
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table class="poptbl" id="pop_sdtbl">
				<colgroup>
				<!--  <col scope="col" width="15%"> -->
				 <col scope="col" width="18%">
				 <col scope="col" width="20%">
				 <col scope="col" width="*">
				 <col scope="col" width="20%">
				
				</colgroup>
				<thead>
				 <tr>
						<!-- <th><?=$txtdt["1359"]?>타입</th> -->
						<th><?=$txtdt["1044"]?><!-- 날짜 --></th>
						<th><?=$txtdt["1164"]?><!-- 상태 --></th>	
						<th><?=$txtdt["1713"]?><!-- 조제대 --></th>
						<th><?=$txtdt["1620"]?><!-- 수량 --></th>
					
					</tr>
				</thead>
				 <tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="medistockdescpage"></div>
		<!-- e : 게시판 페이징 -->
		<div class="mg20t c">
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>

	
	callapi('GET','stock','medistockdesc','<?=$apiData?>');
</script>
