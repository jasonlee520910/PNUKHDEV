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


	$pilltotalcapa=($_GET["pilltotalcapa"])?$_GET["pilltotalcapa"]:"0";

	$apidata="seq=".$seq."&medical=".$medical."&rc_seq=".$rc_seq."&rc_type=".$rc_type."&pilltotalcapa=".$pilltotalcapa;
	//echo $apidata."<Br><br>";

	$result=curl_get($NET_URL_API_MANAGER,"order","orderpill",$apidata);
	$odData=json_decode(urldecode($result),true);
	//var_dump($odData);

	$pillData=$odData["mrlist"];
	//var_dump($pillData);
	//var_dump($odData["decoctiondoo"]);
	if(intval($pillData["baseCapa"])<=0 || !$pillData["pillorder"])
	{
		echo "<script>$('#pillorderdiv').data('check','false')</script>";
	}
	else
	{
		echo "<script>$('#pillorderdiv').data('check','true')</script>";
	}


	//제환손실
	$plLosspill=($odData["plLosspill"])?$odData["plLosspill"]:"200";
	//제분손실
	$plMillingloss=($odData["plMillingloss"])?$odData["plMillingloss"]:"200";
	//결합제량 
	$plBindersliang=($odData["plBindersliang"])?$odData["plBindersliang"]:"10";


?>
<style>
	.pill dl{width:7%;margin:1%;display:inline-block;vertical-align:top;}
	.pill dl dt{width:auto;border:1px solid #ddd;border-radius:7px;text-align:center;padding:10px 5px;color:#999;font-size:17px;font-weight:bold;}
	.pill dl dt.on{color:#111;border:1px solid #48DAFF;background:#48DAFF;}
	.pill dl dd{margin:2px auto;width:100%;}
	.pill dl dd select{width:100%;}
</style>



<?php if($pillData["medicine"]){?>
<div class="gap"></div>
<!-- 약재리스트 -->
<h3 class="u-tit02"><?=$txtdt["1203"]?><!-- 약재리스트 --></h3>
<div class="board-list-wrap" id="board-list-wrap">
	<span class="bd-line"></span>

	<div class="list-select">
		<p class="fl info-txt">
			<span id="totmedicnt"><?=$txtdt["1498"]?> : <!-- 약미 --><i id="totMedicineDiv"><?=$pillData["rcMedicineCnt"]?></i></span>
		</p>
	</div>

	<table id="medicinetbl">
		<colgroup>
			 <col scope="col" width="9%">
			 <col scope="col" width="7%">
			 <col scope="col" width="*">
			 <col scope="col" width="3%">
			 <col scope="col" width="5%">
			 <col scope="col" width="10%">
			 <col scope="col" width="11%">
			 <col scope="col" width="11%">
			 <col scope="col" width="7%">
			 <col scope="col" width="10%">
		</colgroup>

		<thead>
			<tr>
				<th>No</th>
				<th><span class="nec"><?=$txtdt["1359"]?><!-- 타입 --></span></th>
				<th colspan="2"><?=$txtdt["1204"]?>(<?=$txtdt["1669"]?>)<!-- 약재명 --><!-- 약재함 --></th>
				<th><?=$txtdt["1064"]?>/<?=$txtdt["1158"]?><!-- 독성/상극 --></th>
				<th><?=$txtdt["1237"]?><!-- 원산지 --></th>
				<th><?=$txtdt["1712"]?><!-- 현재재고량 --></th>
				<th><?=$txtdt["1338"]?><!-- 총약재량 --></th>
				<th><?=$txtdt["1606"]?><!-- 약재비 --></th>
				<th><?=$txtdt["1607"]?><!-- 총약재비 --></th>
			</tr>
		</thead>

		<tbody>
		<!--  {"type":"smash","typetxt":"분쇄","code":"HD026201KR0001B","title":"백작약","origin":"한국/㈜광명당제약","dismatch":"-","poison":"-","medibox":"▲","totalqty":"10000","medicapa":"100","mediprice":"17","totalprice":"1700"}  -->

		
		
		<?php
		//|HD10300_12,5.0,inmain,105.0

			$rcmedicine="";
			//$totmediprice=0;
			//$totmedicapa=0;
			for($i=0;$i<$pillData["rcMedicineCnt"];$i++)
			{
				//$totmediprice+=intval($pillData["medicine"][$i]["totalprice"]);
				//$totmedicapa+=intval($pillData["medicine"][$i]["medicapa"]);
				if($pillData["medicine"][$i]["medi"]=="Y")
				{
					$rcmedicine.="|".$pillData["medicine"][$i]["code"].",".$pillData["medicine"][$i]["medicapa"].",".$pillData["medicine"][$i]["type"].",".$pillData["medicine"][$i]["mediprice"];
					echo "<tr>";
					echo "<td>".$pillData["medicine"][$i]["code"]."</td>";
					echo "<td>".$pillData["medicine"][$i]["typetxt"]."</td>";
					echo "<td class='l'>".$pillData["medicine"][$i]["title"]."</td>";
					echo "<td>".$pillData["medicine"][$i]["medibox"]."</td>";
					echo "<td>".$pillData["medicine"][$i]["poison"]."/".$pillData["medicine"][$i]["dismatch"]."</td>";
					echo "<td>".$pillData["medicine"][$i]["origin"]."</td>";
					echo "<td class='r'>".number_format($pillData["medicine"][$i]["totalqty"])."</td>";
					echo "<td class='r'>".number_format($pillData["medicine"][$i]["medicapa"])."</td>";
					echo "<td class='r'>".number_format($pillData["medicine"][$i]["mediprice"])."</td>";
					echo "<td class='r'>".number_format($pillData["medicine"][$i]["totalprice"])."</td>";
					echo "</tr>";
				}
			}			
		?>
		<input type="hidden" name="rcMedicine" class="reqdata necdata" class="w90p" title="<?=$txtdt["1205"]?>" value="<?=$rcmedicine;?>">
		</tbody>

		<tfoot>
			<tr>
				<td colspan="7" class="r b cred">별전은 약재량에 포함되지 않습니다.</td>
				<td class="r"> <i class="b f15" id="meditotal"><?=number_format($pillData["totmedicapa"])?></i>g</td>
				<td colspan="2" class="r"><span><?=$txtdt["1607"]?><i class="b f18 cred" id="pricetotal"><?=number_format($pillData["totmediprice"])?></i><?=$txtdt["1235"]?> </span></td>
			</tr>
		</tfoot>
	</table>
</div>
<?php }?>

<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1949"]?><!-- 제환순서 --></h3>
<div class="board-view-wrap">	
	<div class='pill' id="pillorderdiv" data-check="">
	<?=$pillData["pillorder"];?>
	</div>
</div>

<!-- 분쇄 - pillFineness(분말도), pillMillingloss(제분손실) -->
<?php if($pillData["pilllist"]["smash"]){?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1953"]?><!-- 분쇄 --></h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec"><?=$txtdt["1796"]?><!-- 분말도 --></span></th>
			<td><?=selectpill('pillFineness');?></td>
			<th><span class="nec"><?=$txtdt["1797"]?><!-- 제분손실 --></span></th>
			<td><input type="text" class="cred w15p reqdata necdata r" title="<?=$txtdt["1797"]?>" name="pillMillingloss" value="<?=$plMillingloss?>" onkeyup="onKeyupOrderPill();" /> g</td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>


<!-- 탕전 - 탕전법, 특수탕전, 탕전시간, 탕전물량  -->
<?php if($pillData["pilllist"]["decoction"]){?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1361"]?><!-- 탕전 --></h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec"><?=$txtdt["1367"]?><!-- 탕전법 --></span></th>
			<td><?=selectdecoction('dcTitle');?></td>
			<th><span class="nec"><?=$txtdt["1369"]?><!-- 탕전시간(분) --></span></th>
			<td>
				<input type="text" class="w30p reqdata necdata " title="<?=$txtdt["1369"]?>" name="dcTime" value="<?=$odData["plDctime"]?>" maxlength="3" onfocus="this.select();" onchange="changeNumber(event, false);" onkeyup="onKeyupOrderPill();" /><span class="mg5"><?=$txtdt["1437"]?><!-- 분 --></span>
			</td>
		</tr>

		<tr>
			<th><span class="nec"><?=$txtdt["1381"]?><!-- 특수탕전 --></span></th>
			<td id="odDcspecialDiv"><?=selectdecoction('dcSpecial');?></td>
			<th><span class="nec"><?=$txtdt["1366"]?><!-- 탕전물량 -->(ml)</span></th>
			<td>
				<input type="text" class="w30p reqdata necdata " title="<?=$txtdt["1366"]?>" name="dcWater" value="<?=$odData["plDcwater"]?>" onkeyup="onKeyupOrderPill();" /><span class="mg5"> ml</span>	
			</td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>


<!-- 농축 - pillRatio(농축비율), pillTime(농축시간) -->
<?php if($pillData["pilllist"]["concent"]){?>
<div class="gap"></div>
<h3 class="u-tit02">농축</h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec"><?=$txtdt["1950"]?><!-- 농축비율 --></span></th>
			<td><?=selectpill('pillConcentRatio');?></td>
			<th><span class="nec"><?=$txtdt["1951"]?><!-- 농축시간 --></span></th>
			<td><?=selectpill("pillConcentTime");?></td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>

<!-- 착즙 - 착즙유무 -->
<?php if($pillData["pilllist"]["juice"]){?>
<div class="gap"></div>
<h3 class="u-tit02">착즙</h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="*">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec">착즙유무</span></th>
			<td><?=selectpill('pillJuice');?></td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>

<!-- 혼합 - pillBinders(결합제), 결합제(몇g) -->
<?php if($pillData["pilllist"]["mixed"]){?>
<div class="gap"></div>
<h3 class="u-tit02">혼합</h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec"><?=$txtdt["1770"]?><!-- 결합제 --></span></th>
			<td><?=selectpill('pillBinders');?></td>
			<th><span class="nec">결합제량</span></th>
			<td><input type="text" class="w15p reqdata necdata r" title="<?=$txtdt["1770"]?>" name="pillBindersliang" value="<?=$plBindersliang?>" onkeyup="onKeyupOrderPill();" /> g</td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>

<!-- 중탕 - pillTemperature(중탕온도), pillTime(중탕시간) -->
<?php if($pillData["pilllist"]["warmup"]){?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1845"]?><!-- 중탕 --></h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec">중탕온도</span></th>
			<td><?=selectpill('pillWarmupTemperature');?></td>
			<th><span class="nec">중탕시간</span></th>
			<td><?=selectpill('pillWarmupTime');?></td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>

<!-- 숙성 - pillRipen(숙성시간), pillTemperature(숙성온도) -->
<?php if($pillData["pilllist"]["ferment"]){?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1844"]?><!-- 숙성 --></h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec">숙성온도</span></th>
			<td><?=selectpill('pillFermentTemperature');?></td>
			<th><span class="nec">숙성시간</span></th>
			<td><?=selectpill('pillFermentTime');?></td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>

<!-- 제형 - pillShape(제형), pillLossjehwan(제환손실) -->
<?php if($pillData["pilllist"]["plasty"]){?>
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1664"]?><!-- 제형 --></h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec"><?=$txtdt["1664"]?><!-- 제형 --></span></th>
			<td><?=selectpill('pillShape');?></td>
			<th><span class="nec"><?=$txtdt["1798"]?><!-- 제환손실 --></span></th>
			
			<td><input type="text" class="cred w15p reqdata necdata r" title="<?=$txtdt["1798"]?>" name="pillLosspill" value="<?=$plLosspill?>"  onkeyup="onKeyupOrderPill();" /> g</td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>


<!-- 건조 - pillTemperature(건조온도), pillTime(건조시간) -->
<?php if($pillData["pilllist"]["dry"]){?>
<div class="gap"></div>
<h3 class="u-tit02">건조</h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="12%">
		<col width="38%">
		<col width="12%">
		<col width="38%">
	</colgroup>
	<tbody>
		<tr>
			<th><span class="nec">건조온도</span></th>
			<td><?=selectpill('pillDryTemperature');?></td>
			<th><span class="nec"><?=$txtdt["1841"]?><!-- 건조시간 --></span></th>
			<td><?=selectpill('pillDryTime');?></td>
		</tr>
	</tbody>
</table>
</div>
<?php }?>

<div class="gap"></div>
