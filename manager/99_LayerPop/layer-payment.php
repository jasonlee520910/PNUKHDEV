<?php 
/*
$adm="../../_adm";
	include_once $adm."/common.php";
	$json=json_decode(getapidata("paymentdesc"),true);
//var_dump($json);
*/
	$root = "..";
	include_once $root."/_common.php";

	$odCode=$_GET["odCode"];
	$apiData = "odCode=".$odCode;
?>
<style>h2 time{margin-left:20px;font-size:13px;font-weight:bold;}</style>
<!-- s: -->
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><time><?=date("d M Y  H:i");?></time></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con medical-search">
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<form id="theform" name="theform" action="">
			<input type="hidden" name="seq" id="seq" class="reqdata" value="" >
			<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Order/OrderList.php">
			<table>
					<caption><span class="blind"></span></caption>
					<colgroup>
						<col width="150">
						<col width="*"> 
					</colgroup>
					<tbody>			  
						<tr>
							<th class="l"><span><?=$txtdt["1302"]?><!-- 주문상태 --></span></th>
							<td id="odStatusDiv"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1516"]?><!-- 주문금액 --></span></th>
							<td id="odAmount"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1517"]?><!-- 결제방법 --></span></th>
							<td id="odPaytypeDiv"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1518"]?><!-- 결제정보 --></span></th>
							<td><input type="text" name="odPayinfo" id="odPayinfo" class="w200 reqdata" value=""></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1519"]?><!-- 결제금액 --></span></th>
							<td><input type="text" name="odPayamount" id="odPayamount" class="w200 reqdata" value=""></td>
						</tr>
						 <tr>
							<th class="l"><span><?=$txtdt["1305"]?><!-- 주문코드 --></span></th>
							<td id="odCode">><b></b></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1520"]?><!-- 주문명 --></span></th>
							<td id="reName"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1521"]?><!-- 종류 --></span></th>
							<td id="odPacktype"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1522"]?><!-- 배송지 --></span></th>
							<td id="reAddress"></td>
						</tr>
				 </tbody>
			</table>
			</form>
		</div>
		<div class="mg20t c">
			<a href="javascript:;" class="cdp-btn" onclick="goupdate()"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
			<a href="javascript:;" class="cw-btn" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>
<!-- e: 서울한의원 -->
<script>
	function goupdate()
	{
		console.log("goupdate click ===========================  ");
		var key=data="";
		var jsondata={};

		//radio data
		$(".radiodata").each(function()
		{
			key=$(this).attr("name");
			data=$(":input:radio[name="+key+"]:checked").val();
			jsondata[key] = data;
		});

		$(".reqdata").each(function(){
			key=$(this).attr("name");
			data=$(this).val();
			jsondata[key] = data;
		});

		console.log(JSON.stringify(jsondata));

		callapi("POST","payment","paymentupdate",jsondata);

		closediv('viewlayer');
	}
	
	callapi('GET','payment','paymentdesc','<?=$apiData?>');
</script>
