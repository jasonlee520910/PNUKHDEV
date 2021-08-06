<?php
	//수기처방 주문내역 
	$root = "../..";
	include_once $root."/_common.php";
?>
<script>
	$.datepicker.setDefaults({
			dateFormat: 'yy.mm.dd',
			prevText: '이전 달',
      nextText: '다음 달',
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
      showMonthAfterYear: true,
      yearSuffix: '년'
		});

	$(function(){
		//달력
		$("#reDelidate").datepicker();
	})
</script>
<!-- 주문내역 -->
<h3 class="u-tit02"><?=$txtdt["1300"]?><!-- 주문내역 --></h3>
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="10%">
		<col width="23%">
		<col width="10%">
		<col width="23%">
		<col width="10%">
		<col width="23%">
	</colgroup>
	<tbody>
		<tr>
			<th>
				<span class="nec">환자구분</span>
			</th>
			<td colspan="3" id="odPatientDiv">
			<th>
				<span><?=$txtdt["1305"]?><!-- 주문코드 --></span>
			</th>
			<td id="td_odCode"></td>
			</td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1403"]?><!-- 한의원 --></span></th>
			<td colspan="3">
				 <input type="hidden" class="w200 reqdata necdata " id="miUserid" name="odUserid" title="<?=$txtdt["1403"]?>" value=""/>
				  <input type="hidden" class="w200 " id="miGrade" name="miGrade" title="" value=""/>
				  <input type="hidden" class="w200 " id="miZipcode" name="miZipcode" title="" value=""/>
				  <input type="hidden" class="w400 " id="miAddress" name="miAddress" title="" value=""/>
				  <input type="hidden" class="w400 " id="miPhone" name="miPhone" title="" value=""/>
				  <input type="hidden" class="w400 " id="miMobile" name="miMobile" title="" value=""/>
				 <input type="text" class="w200" id="miName" name="miName" title="<?=$txtdt["1403"]?>"   value="" onkeydown="javascript:layerPopupKeydown(event,this);" data-bind="layer-medical" data-value="700,600"  />
				<button type="button" id="btnmedical" class="cdp-btn" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medical" data-value="700,600"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>

			</td>
			<th>
				<span><?=$txtdt["1328"]?><!-- 처방자 --></span>
			</th>
			<input type="hidden" class="reqdata" id="odStaff" name="odStaff" title="<?=$txtdt["1328"]?>" value="" readonly/>
			<td id="odStaffDiv"></td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1323"]?><!-- 처방명 --></span></th>
			<td colspan="3">
				<input type="hidden" class="w500 reqdata" title="<?=$txtdt["1323"]?>" name="rc_seq" value="" readonly/>
				<input type="hidden" class="w500 reqdata" title="<?=$txtdt["1323"]?>" name="rc_type" value="" readonly/>
				<input type="hidden" class="w500 reqdata" title="<?=$txtdt["1323"]?>" name="odScription" value="" readonly/>
				<input type="text" class="w500 reqdata necdata " title="<?=$txtdt["1323"]?>" id="odTitle" name="odTitle" value=""/>
				<button type="button" class="cdp-btn" id="btnrecipe" onclick="javascript:viewlayerPopup(this);" data-bind="layer-recipe" data-value="700,600"><span><?=$txtdt["1321"]?><!-- 처방검색 --></span></button>
			</td>
			<th>
				<span class="nec"><?=$txtdt["1112"]?><!-- 배송희망일 --></span>
			</th>
			<td>
				<input type="text" id="reDelidate" name="reDelidate" value="" class="reqdata necdata" title="<?=$txtdt["1112"]?>" readonly>
			</td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1614"]?><!-- 조제타입 --></span></th>
			<td colspan="3" id="maTypeDiv">					
			</td>
			<th colspan="2">
				<div id="tdMediTitle">첩제</div><span id="tdMedi"></span>
			</th>
		</tr>
 </tbody>
</table>
