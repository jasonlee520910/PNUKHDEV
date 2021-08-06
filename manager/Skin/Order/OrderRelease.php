<?php 
	//
	$root = "../..";
	include_once $root."/_common.php";
?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1110"]?><!-- 배송정보 --></h3>
<div class="board-view-wrap">
<!-- 보내는사람 -->
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="16%">
		<col width="34%">
		<col width="16%">
		<col width="34%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec"><?=$txtdt["1852"]?><!-- 보내는사람선택 --></span></th>
			<td id="reSendTypeDiv">
			</td>
			<th><span class="nec"><?=$txtdt["1286"]?><!-- 전화번호 --></span></th>
			<td>
				<input type="hidden" class="reqdata necdata" id="reSendPhone" name="reSendPhone"  title="<?=$txtdt["1286"]?>" value=""/>
				<input type="text" class="w20p" id="reSendPhone1" name="reSendPhone1"  title="<?=$txtdt["1286"]?>" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" id="reSendPhone2" name="reSendPhone2"  title="<?=$txtdt["1286"]?>" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" id="reSendPhone3" name="reSendPhone3"  title="<?=$txtdt["1286"]?>" value="" maxlength="4" onchange="changePhoneNumber(event);"/>
			</td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1851"]?><!-- 보내는사람 --></span></th>
			<td><input type="text" class="w50p reqdata necdata " id="reSendName" name="reSendName" title="<?=$txtdt["1851"]?>"  value=""/></td>
			<th><span class=""><?=$txtdt["1422"]?><!-- 휴대폰번호 --></span></th>
			<td>
				<input type="hidden" class="reqdata " title="<?=$txtdt["1422"]?>" name="reSendMobile" value=""/>
				<input type="text" class="w20p" title="<?=$txtdt["1422"]?>" name="reSendMobile1" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" title="<?=$txtdt["1422"]?>" name="reSendMobile2" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" title="<?=$txtdt["1422"]?>" name="reSendMobile3" value="" maxlength="4" onchange="changePhoneNumber(event);"/>
			</td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1307"]?><!-- 주소 --></span></th>
			<td colspan="3">
				<input type="text" title="<?=$txtdt["1232"]?>" class=" reqdata w100 necdata" name="reSendZipcode" value="" readonly />
				<a href="javascript:;" onclick="getzip('reSendZipcode', 'reSendAddress');" class="cw-btn"><span><?=$txtdt["1232"]?><!-- 우편번호 --></span></a>
				<p class="mg5t">
					<input type="text" title="<?=$txtdt["1307"]?>" class=" reqdata w50p necdata" name="reSendAddress" value="" readonly/>
					<input type="text" title="<?=$txtdt["1640"]?>" class=" reqdata w40p necdata" name="reSendAddress1" value=""/>
				</p>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div class="board-view-wrap">
<!-- 받는사람 -->
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="16%">
		<col width="34%">
		<col width="16%">
		<col width="34%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec"><?=$txtdt["1111"]?><!-- 배송종류 --></span></th>
			<td id="reDelitypeDiv">
			<th><span><?=$txtdt["1286"]?><!-- 전화번호 --></span></th>
			<td>
				<input type="hidden" class="reqdata" id="rePhone" name="rePhone"  title="<?=$txtdt["1286"]?>" value=""/>
				<input type="text" class="w20p " id="rePhone1" name="rePhone1"  title="<?=$txtdt["1286"]?>" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" id="rePhone2" name="rePhone2"  title="<?=$txtdt["1286"]?>" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" id="rePhone3" name="rePhone3"  title="<?=$txtdt["1286"]?>" value="" maxlength="4" onchange="changePhoneNumber(event);"/>
			</td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1100"]?><!-- 받는사람 --></span></th>
			<td><input type="text" class="w50p reqdata necdata " id="reName" name="reName" title="<?=$txtdt["1100"]?>"  value=""/></td>
			</td>
			<th><span class="nec"><?=$txtdt["1422"]?><!-- 휴대폰번호 --></span></th>
			<td>
				<input type="hidden" class="reqdata necdata" title="<?=$txtdt["1422"]?>" name="reMobile" value=""/>
				<input type="text" class="w20p" title="<?=$txtdt["1422"]?>" name="reMobile1" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" title="<?=$txtdt["1422"]?>" name="reMobile2" value="" maxlength="4" onchange="changePhoneNumber(event);"/>-
				<input type="text" class="w20p" title="<?=$txtdt["1422"]?>" name="reMobile3" value="" maxlength="4" onchange="changePhoneNumber(event);"/>
			</td>
		</tr>
		<tr>
			<th><span class="nec"><?=$txtdt["1307"]?><!-- 주소 --></span></th>
			<td colspan="3">
				<input type="text" title="<?=$txtdt["1232"]?>" class=" reqdata w100 necdata" name="reZipcode" value="" readonly />
				<a href="javascript:;" onclick="getzip('reZipcode', 'reAddress');" class="cw-btn"><span><?=$txtdt["1232"]?><!-- 우편번호 --></span></a>
				<p class="mg5t">
					<input type="text" title="<?=$txtdt["1307"]?>" class=" reqdata w50p necdata" name="reAddress" value="" readonly/>
					<input type="text" title="<?=$txtdt["1640"]?>" class=" reqdata w40p necdata" name="reAddress1" value=""/>
				</p>
			</td>
		</tr>
		<tr>
			<th><span><?=$txtdt["1106"]?><!-- 배송요구사항 --></span></th>
			<td colspan="3"><input type="text" class="reqdata w98p" name="reRequest" value=""/></td>
		</tr>
	</tbody>
</table>
</div>
