<?php
	//사전조제 주문내역 
	$root = "../..";
	include_once $root."/_common.php";
?>
<!-- 주문내역 -->
<h3 class="u-tit02"><?=$txtdt["1300"]?><!-- 주문내역 -->
	- <span style='padding:2px 5px;border-radius:2px;background:#FF0000;color:#fff;font-size:15px;'>사전조제</span>
</h3>
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="15%">
		<col width="19%">
		<col width="15%">
		<col width="18%">
		<col width="15%">
		<col width="18%">
	</colgroup>
	<tbody>
		<tr>
			<th>
				<span><?=$txtdt["1305"]?><!-- 주문코드 --></span>
			</th>
			<td id="td_odCode"></td>
			<th><span class="nec"><?=$txtdt["1403"]?><!-- 한의원 --></span></th>
			<td>
				 <input type="hidden" class="w200 reqdata necdata " id="miUserid" name="odUserid" title="<?=$txtdt["1403"]?>" value="1000000000"/>
				  <input type="hidden" class="w200 " id="miGrade" name="miGrade" title="" value="C"/>
				  <input type="hidden" class="w200 " id="miZipcode" name="miZipcode" title="" value="10449"/>
				  <input type="hidden" class="w400 " id="miAddress" name="miAddress" title="" value="경기도 고양시 일산동구 호수로 358-25 (백석동)||601호"/>
				  <input type="hidden" class="w400 " id="miPhone" name="miPhone" title="" value="031-111-5555"/>
				  <input type="hidden" class="w400 " id="miMobile" name="miMobile" title="" value="031-111-5555"/>
				 <span id="miNamediv"></span>
			</td>
			<th>
				<span><?=$txtdt["1328"]?><!-- 처방자 --></span>
			</th>
			<input type="hidden" class="reqdata" id="odStaff" name="odStaff" title="<?=$txtdt["1328"]?>" value="" readonly/>
			<td id="odStaffDiv"></td>
		</tr>
		<tr>


		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1323"]?><!-- 처방명 --></span></th>
			<td colspan="5">
				<input type="hidden" class="w500 reqdata" title="<?=$txtdt["1323"]?>" name="rc_seq" value="" readonly/>
				<input type="hidden" class="w500 reqdata" title="<?=$txtdt["1323"]?>" name="rc_type" value="" readonly/>
				<input type="hidden" class="w500 reqdata" title="<?=$txtdt["1323"]?>" name="rc_source" value="" readonly/>
				<input type="hidden" class="w500 reqdata" title="<?=$txtdt["1323"]?>" name="odScription" value="" readonly/>
				<input type="text" class="w500 reqdata necdata " title="<?=$txtdt["1323"]?>" id="odTitle" name="odTitle" value="" readonly />
				<button type="button" class="cdp-btn" id="btnrecipe" onclick="javascript:viewlayerPopup(this);" data-bind="layer-recipe" data-value="700,600" data-goods="Y" ><span><?=$txtdt["1321"]?><!-- 처방검색 --></span></button>
			</td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1614"]?><!-- 조제타입 --></span></th>
			<td colspan="5" id="maTypeDiv">
				
			</td>
		</tr>
 </tbody>
</table>
