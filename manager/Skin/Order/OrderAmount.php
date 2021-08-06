<?php
	$root = "../..";
	include_once $root."/_common.php";
	$type=($_GET["type"]) ? $_GET["type"]:"N";
	$seq=$_GET["seq"];

	if($seq==="add")
	{
		$apiOrderData="seq=write";
	}
	else if($seq==="addg")
	{
		$apiOrderData="seq=write";
	}
	else
	{
		$apiOrderData="seq=".$_GET["seq"];
	}
?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1516"]?><!-- 주문금액 --></h3>
<div class="board-view-wrap" >
<table id="djmeditbl" style="float:left;">
	<colgroup>
		<col width="15%">
		<col width="30%">
		<col width="20%">
		<col width="*">
	</colgroup>
	<tbody>
		<tr style="border-top: 1px solid #e3e3e4;">
			<th><span><?=$txtdt["1606"]?><!-- 약재비 --></span></th>
			<td id="tot_mediprice"></td>
			<td id="tot_meditotalprice" class="tr"></td>
		</tr>
		<tr style="border-top: 1px solid #e3e3e4;" id="trsugar">
			<th><span>감미제</span></th>
			<td id="tot_sugarprice"></td>
			<td id="tot_sugartotalprice" class="tr"></td>
		</tr>


		<tr style="border-top: 1px solid #e3e3e4;">
			<th><span><?=$txtdt["1698"]?><!-- 조제비 --></span></th>
			<td id="tot_makingprice"></td>
			<td id="tot_makingtotalprice" class="tr"></td>
		</tr>
		<tr style="border-top: 1px solid #e3e3e4;">
			<th><span><?=$txtdt["1697"]?><!-- 탕전비 --></span></th>
			<td id="tot_decoctionprice"></td>
			<td id="tot_decoctiontotalprice" class="tr"></td>
		</tr>
		<tr style="border-top: 1px solid #e3e3e4;" id="trspecial">
			<th><span>특수탕전비</span></th>
			<td id="tot_specialprice"></td>
			<td id="tot_specialtotalprice" class="tr"></td>
		</tr>


		<tr style="border-top: 1px solid #e3e3e4;">
			<th><span><?=$txtdt["1700"]?><!-- 포장비 --></span></th>
			<td id="tot_packingprice"></td>
			<td id="tot_packingtotalprice" class="tr"></td>
		</tr>

		<tr style="border-top: 1px solid #e3e3e4;">
			<th><span><?=$txtdt["1701"]?><!-- 배송비 --></span></th>
			<td id="tot_releaseprice"></td>
			<td id="tot_releasetotalprice" class="tr"></td>
		</tr>
		<tr style="border-top: 1px solid #e3e3e4;">
			<th><span><?=$txtdt["1516"]?><!-- 주문금액 --></span></th>
			<td colspan="2" class="tr">
				<input type="hidden" id="odAmount" name="odAmount" value="" title="<?=$txtdt["1516"]?>" class="reqdata">
				<span><i class="b f18 cred" id="td_total_price"></i> <?=$txtdt["1235"]?></span>
			</td>
		</tr>
 </tbody>
</table>
</div>
