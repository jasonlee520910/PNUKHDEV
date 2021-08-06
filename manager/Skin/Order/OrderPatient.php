<?php
	//수기처방 환자정보 
	$root = "../..";
	include_once $root."/_common.php";
?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1886"]?><!-- 환자정보 --></h3>
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
			<th><span class="nec"><?=$txtdt["1887"]?><!-- 환자명 --></span></th>
			<td><input type="text" class="w90p reqdata necdata " id="odName" name="odName" title="<?=$txtdt["1887"]?>"  value=""/></td>

			<th><span class="nec"><?=$txtdt["1888"]?><!-- 성별 --></span></th>
			<td id="meGenderDiv"></td>

			<th><span><?=$txtdt["1889"]?><!-- 생년월일 --></span></th>
			<td>
				<input type="hidden" id="odBirth" name="odBirth" value="" class="reqdata" maxlength="10" title="<?=$txtdt["1889"]?>">
				<input autocomplete="off" type="text" id="odBirth1" name="odBirth1" value="" class="w20p" maxlength="4" onfocus="this.select();" onchange="changeNumber(event, false);" title="<?=$txtdt["1889"]?>">-
				<input autocomplete="off" type="text" id="odBirth2" name="odBirth2" value="" class="w20p" maxlength="2" onfocus="this.select();" onchange="changeNumber(event, false);" title="<?=$txtdt["1889"]?>">-
				<input autocomplete="off" type="text" id="odBirth3" name="odBirth3" value="" class="w20p" maxlength="2" onfocus="this.select();" onchange="changeNumber(event, false);" title="<?=$txtdt["1889"]?>">
			</td>
		</tr>
 </tbody>
</table>
