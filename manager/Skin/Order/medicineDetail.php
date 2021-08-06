<?php
	$root = "../..";
	include_once $root."/_common.php";

	$medicine = $_GET["medicine"];
	$sweet = $_GET["sweet"];

	//주문리스트 API 호출할 파라미터값
	$apiOrderData ="medicine=".$medicine."&sweet=".$sweet;
?>

<input type="hidden" name="rcMedicine" class="reqdata necdata" class="w90p" title="<?=$txtdt["1205"]?>" value="<?=$_GET["medicine"];?>">
<input type="hidden" name="rcShortage" class="reqdata" class="w90p" title="<?=$txtdt["1205"]?>" value="">
<input type="hidden" name="rcSweet" class="reqdata" class="w90p" value="<?=$_GET["sweet"];?>">

<div class="board-list-wrap" id="board-list-wrap">
	<span class="bd-line"></span>

	<div class="list-select">
		<p class="fl info-txt">
			<span id="totmedicnt"><?=$txtdt["1498"]?> : <!-- 약미 --><i id="totMedicineDiv"></i></span>
			<span id="totmedicnt"><?=$txtdt["1064"]?> : <!-- 독성 --> <i id="totPoisonDiv"></i></span>
			<span id="totmedicnt"><?=$txtdt["1158"]?> : <!-- 상극 --> <i id="totDismatchDiv" class="cred"></i></span>
		</p>
	</div>
	<table id="medicinetbl">
		<colgroup>
			 <col scope="col" width="9%">
			 <col scope="col" width="7%">
			 <col scope="col" width="*">
			 <col scope="col" width="5%">
			 <col scope="col" width="2%">
			 <col scope="col" width="5%">
			 <col scope="col" width="10%">
			 <col scope="col" width="11%">
			 <col scope="col" width="8%">
			 <col scope="col" width="11%">
			 <col scope="col" width="7%">
			 <col scope="col" width="10%">		
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th><span class="nec"><?=$txtdt["1359"]?><!-- 타입 --></span></th>
				<th colspan="3"><?=$txtdt["1204"]?>(<?=$txtdt["1669"]?>)<!-- 약재명 --><!-- 약재함 --></th>
				<th><?=$txtdt["1064"]?>/<?=$txtdt["1158"]?><!-- 독성/상극 --></th>
				<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
				<th><?=$txtdt["1712"]?><!-- 현재재고량 --></th>
				<th><span class="nec"><?=$txtdt["1334"]?><!-- 첩당약재 --></th>
				<th><?=$txtdt["1338"]?><!-- 총약재량 --></th>
				<th><?=$txtdt["1606"]?><!-- 약재비 --></th>
				<th><?=$txtdt["1607"]?><!-- 총약재비 --></th>				
			</tr>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7" class="r b cred">별전은 약재량에 포함되지 않습니다.</td>
				<td colspan="2" class="r"><span><!-- <?=$txtdt["1333"]?> --><!-- 첩당무게 --> <i class="b f15" id="chubtotal"></i>g</span></td>
				<td class="r"> <i class="b f15" id="meditotal"></i>g / <i class="b f15" id="schubtotal"></i>g</td>
				<td colspan="2" class="r"><span><?=$txtdt["1607"]?><i class="b f18 cred" id="pricetotal"></i><?=$txtdt["1235"]?></span></td>
			</tr>
		</tfoot>
	</table>

	<div class="list-select">
		<p class="fl" id="sweetDiv"></p>
	</div>
</div>

<script>
	//select box (선전,일반,후하) 선택시
	function mediChange()
	{
		resetamount();
		resetmedi();
	}

	function deletemedi(code)
	{
		$("#md"+code).remove();
		resetamount();
		resetmedi();
	}

	var medicine = '<?=$medicine?>';
	if(!isEmpty(medicine)) //
	{
		//약재리스트 API 호출
		callapi('GET','medicine','medicinetitle','<?=$apiOrderData?>');
	}

</script>
