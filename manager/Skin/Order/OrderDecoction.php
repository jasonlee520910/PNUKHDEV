<?php
	//
	$root = "../..";
	include_once $root."/_common.php";
	
	$goods=$_GET["goods"];

	//order seq 
	$seq=($_GET["seq"])?$_GET["seq"]:"write";
	//medical code 
	$medical=($_GET["medical"])?$_GET["medical"]:"";

	$rc_seq=($_GET["rc_seq"])?$_GET["rc_seq"]:"";
	$rc_type=($_GET["rc_type"])?$_GET["rc_type"]:"";

	$apidata="seq=".$seq."&medical=".$medical."&rc_seq=".$rc_seq."&rc_type=".$rc_type;
	//echo $apidata;

	$result=curl_get($NET_URL_API_MANAGER,"order","orderdecoction",$apidata);
	$odData=json_decode(urldecode($result),true);
	//var_dump($odData);

	$odChubcnt=($odData["odChubcnt"])?$odData["odChubcnt"]:"<?=$BASE_CHUBCOUNT?>";//$BASE_CHUBCOUNT;
	$odPackcnt=($odData["odPackcnt"])?$odData["odPackcnt"]:"<?=$BASE_PACKCOUNT?>";//$BASE_PACKCOUNT;
	$odPackcapa=($odData["odPackcapa"])?$odData["odPackcapa"]:"<?=$BASE_PACKCAPA?>";//$BASE_PACKCAPA;
	$mrDesc=($odData["mrDesc"])?$odData["mrDesc"]:"";

	//약재리스트 
	$rcMedicine=($odData["rcMedicine"])?$odData["rcMedicine"]:"";
	$rcSweet=($odData["rcSweet"])?$odData["rcSweet"]:"";
	echo "<script>console.log('orderdecoction');callMedicine('medicine=".$rcMedicine."&sweet=".$rcSweet."');</script>";

?>
<style>
	#odMrdescDiv li{width:50%;}
	#odMrdescDiv li p{width:20%;}
	#odMrdescDiv li div{width:80%;text-align:left;}
	#odMrdescDiv li div .btxt{width:100%;}
</style>
<!-- 첩수팩수팩용량 -->
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1300"]?><!-- 주문내역 --></h3>
<div class="board-view-wrap">
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
			<th><span class="nec"><?=$txtdt["1335"]?><!-- 첩수 --></span></th>
			<td>
				<input autocomplete="off" type="text" class="w20p tc reqdata necdata" title="<?=$txtdt["1335"]?>" id="odChubcnt" name="odChubcnt" value="<?=$odChubcnt?>" maxlength="4" onfocus="this.select();" onchange="changeNumber(event, false);"  onkeyup="onKeyupChubcnt();" /> <span class="mg5"> ea</span>
			</td>
			<th><span class="nec"><?=$txtdt["1384"]?><!-- 팩수 --></span></th>
			<td>
			<input autocomplete="off" type="text" class="w20p tc reqdata necdata" title="<?=$txtdt["1384"]?>" id="odPackcnt" name="odPackcnt" value="<?=$odPackcnt?>"  maxlength="3" onfocus="this.select();" onchange="changeNumber(event, false);" onkeyup="onKeyupPackcnt();" /> <span class="mg5"> <?=$txtdt["1018"]?><!-- 개 --></span>
			</td>
			<th><span class="nec"><?=$txtdt["1386"]?><!-- 팩용량 --></span></th>
			<td>
			<input autocomplete="off" type="text" class="w20p tc reqdata necdata" title="<?=$txtdt["1386"]?>" id="odPackcapa"name="odPackcapa" value="<?=$odPackcapa?>"  maxlength="3" onfocus="this.select();" onchange="changeNumber(event, false);"  onkeyup="onKeyupPackcapa();" /> <span class="mg5"> ml</span>
			</td>
		</tr>
 </tbody>
</table>
</div>

<!-- 감미제 -->
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1703"]?></h3>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="16%">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<th><span class="nec"><?=$txtdt["1703"]?></span></th>
				<td id="dcSugarDiv"><?=selectsugar('dcSugar');?></td>
			</tr>
		</tbody>
	</table>
</div>

<!-- 탕전정보 -->
<div class="gap"></div>
<h3 class="u-tit02" id="decocTitleDiv"><?=$txtdt["1370"]?><!-- 탕전정보 입력 --></h3>
<div class="board-view-wrap">
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
			<th><span class="nec"><?=$txtdt["1367"]?><!-- 탕전법 --></span></th>
			<td id="odDctitleDiv"><?=selectdecoction('dcTitle');?></td>
			<th><span class="nec"><?=$txtdt["1369"]?><!-- 탕전시간(분) --></span></th>
			<td>
				<input type="text" class="w50p reqdata necdata " title="<?=$txtdt["1369"]?>" name="dcTime" value="<?=$odData["dcTime"]?>" maxlength="3" onfocus="this.select();" onchange="changeNumber(event, false);" onkeyup="onKeyupDctime();" /><span class="mg5"><?=$txtdt["1437"]?><!-- 분 --></span>
			</td>
		</tr>

		<tr>
			<th><span class="nec"><?=$txtdt["1381"]?><!-- 특수탕전 --></span></th>
			<td id="odDcspecialDiv"><?=selectdecoction('dcSpecial');?></td>
			<th><span class="nec"><?=$txtdt["1366"]?><!-- 탕전물량 -->(ml)</span></th>
			<td>
				<input type="text" class="w50p reqdata necdata " title="<?=$txtdt["1366"]?>" name="dcWater" value="<?=$odData["dcWater"]?>" readonly /><span class="mg5"> ml</span>							
			</td>
		</tr>
	</tbody>
</table>
</div>

<?php if($goods!="Y"){?>
<!-- 마킹/출력 정보 입력 -->
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1077"]?><!-- 마킹/출력 정보 입력 --></h3>
<div class="board-view-wrap">
<ul class="marking-list" id="odMrdescDiv">
	<?php
		foreach($odData["mrDescList"] as $key => $value)
		{ 
			$idstr = sprintf('%02d',$key);
			
			$checked="";
			if($mrDesc==$odData["mrDescList"][$key]["cdCode"])
			{
				$checked=' checked="checked" ';
			}
			else if(intval($key) == 0)
			{
				$checked=' checked="checked" ';
			}
	?>
			<li>
				<p class="radio-box">
					<input type="radio"  name="mrDesc" class="radiodata" id="marking-<?=$idstr?>" value="<?=$odData["mrDescList"][$key]["cdCode"]?>"  <?=$checked?> >
					<label for="marking-<?=$idstr?>"><?=$odData["mrDescList"][$key]["cdName"]?></label>
				</p>
				<div>
					<p class="btxt"><?=$odData["mrDescList"][$key]["cdDesc"]?></p>
				</div>
			</li>
	<?php }?>
</ul>


</div>
<?php }?>

<!-- 파우치, 한약박스, 배송포장박스 -->
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1394"]?><!-- 포장 및 박스 --></h3>
<ul>	
	<li class="liBoxSize">
		<h5><?=$txtdt["1470"]?><!-- 파우치 --></h5>
		<div id="odPacktypeDiv"> <!-- 탕제파우치 -->
			<?=selectpack("odPacktype");?>
		</div>
	</li>
	<li class="liBoxSize">
		<h5><?=$txtdt["1438"]?><!-- 한약박스종류 선택 --></h5>
		<div id="reBoxmediDiv">
			<?=selectpack("reBoxmedi");?>
		</div>
	</li>
	<li class="liBoxSize">
		<h5><?=$txtdt["1439"]?><!-- 배송포장재종류 선택 --></h5>
		<div id="reBoxdeliDiv">
			<?=selectpack("reBoxdeli");?>
		</div>
	</li>
</ul>
	
	