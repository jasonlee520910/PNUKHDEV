<div style="display:none">
	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
</div>
<div class="fl">
	<div class="row">
		<dl>
			<dt><?=$txtdt["1323"]?></dt><!-- 처방명 -->
			<dd><strong class="tit" id="odTitleDiv"></strong></dd>
		</dl>
	</div>
	<div class="row2">
		<dl>
			<dt><?=$txtdt["1403"]?></dt><!-- 한의원 -->
			<dd id="meNameDiv"></dd>
		</dl>
		<dl>
			<dt><?=$txtdt["1459"]?></dt><!-- 주문자 -->
			<dd id="odStaffDiv"></dd>
		</dl>
	</div>
	<div class="row2">
		<dl>
			<dt><?=$txtdt["1603"]?></dt><!-- 팩종류 -->
			<dd id="odPacktypeDiv"></dd>
		</dl>
		<dl>
			<dt><?=$txtdt["1386"]?></dt><!-- 팩용량 -->
			<dd id="odPackcapaDiv"></dd>
		</dl>
	</div>
</div>
<div class="fr">
	<div class="row">
		<dl>
			<dt id="dateDiv"><?=$txtdt["1112"]?></dt><!-- 배송희망일 -->
			<dd id="reDelidateDiv"></dd>
		</dl>
	</div>
	<div class="row">
		<dl>
			<dt><?=$txtdt["1335"]?></dt><!-- 첩수 -->
			<dd id="odChubcntDiv"><?=$txtdt["1330"]?><!-- 첩 --></dd>
		</dl>
	</div>
	<div class="row">
		<dl>
			<dt><?=$txtdt["1384"]?></dt><!-- 팩수 -->
			<dd id="odPackcntDiv"><?=$txtdt["1604"]?><!-- 팩 --></dd>
		</dl>
	</div>
</div>
