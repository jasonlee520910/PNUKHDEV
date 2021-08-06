<?php 
	//$adm="../../_adm";
	//include_once $adm."/common.php";
	//$json=json_decode(getapidata("medicaldesc"),true);
	$root = "..";
	include_once $root."/_common.php";

	$userid=$_GET["userid"];
	$apiHospitalData = "userid=".$userid;

?>
<!-- s: -->
<div class="layer-wrap">
	<div class="layer-top">
		<h2 id="h2_name"></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con medical-search">
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
					<caption><span class="blind"></span></caption>
					<colgroup>
						<col width="150">
						<col width="*">
					</colgroup>
					<tbody>
						<!-- <tr>
							<th class="l"><span><?=$txtdt["1492"]?>병원아이디</span></th>
							<td id="td_id"></td>
						</tr> -->
						<tr>
							<th class="l"><span><?=$txtdt["1593"]?><!-- 병원이름 --></span></th>
							<td id="td_name"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1642"]?><!-- 원장 --></span></th>
							<td id="td_staff"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1143"]?><!-- 사업자등록번호 --></span></th>
							<td id="td_bno"></td>
						</tr>
						 <!-- <tr>
							<th class="l"><span><?=$txtdt["1246"]?><!-- 이메일 --><!-- </span></th> -->
							<!-- <td id="td_email"></td>
						</tr> --> 
						 <tr>
							<th class="l"><span><?=$txtdt["1286"]?><!-- 전화번호 --></span></th>
							<td id="td_phone"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1307"]?><!-- 주소 --></span></th>
							<td id="td_addr"></td>
						</tr>
				 </tbody>
			</table>
		</div>
		<div class="mg20t c">
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>

	//한의원 상세 정보
	callapi('GET','member','medicaldesc','<?=$apiHospitalData?>');

</script>
