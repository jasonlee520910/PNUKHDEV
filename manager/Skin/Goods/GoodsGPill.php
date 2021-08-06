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


	$pillodPillcapa=($_GET["pillodPillcapa"])?$_GET["pillodPillcapa"]:"0";
	$pillodQty=($_GET["pillodQty"])?$_GET["pillodQty"]:"0";
	$pilltotalcapa=($_GET["pilltotalcapa"])?$_GET["pilltotalcapa"]:"0";

	$apidata="seq=".$seq."&medical=".$medical."&rc_seq=".$rc_seq."&rc_type=".$rc_type."&pillodPillcapa=".$pillodPillcapa."&pillodQty=".$pillodQty."&pilltotalcapa=".$pilltotalcapa;
	//echo $apidata."<Br><br>";

	$result=curl_get($NET_URL_API_MANAGER,"goods","goodsgpill",$apidata);
	$odData=json_decode(urldecode($result),true);
	//var_dump($odData);
	//echo "<br>==============================<br>";

	
	//echo "<br>==============================<br>";
	//echo "제환순서 리스트 <br>";
	//$pillorder=$odData["pillorder"];
	//$jspillorder=json_encode($pillorder);
	//echo $jspillorder;


	$pillData=$odData["mrlist"];
	//요데이터를 저장해야함 나중에 불러오기할때 저걸로 불러와서 그대로 보여준다. 
	//echo "<br>==============================<br>";
	//echo "공정한 리스트 <br>";
	$pilllist=$pillData["pilllist"];
	//$jspill=json_encode($pilllist, JSON_UNESCAPED_UNICODE);
	//echo $jspill;

	//echo "<br>==============================<br>";
	//echo "수정한 pilldata<br>";
	//$pilldata=$pillData["pilldata"];
	//$jspilldata=json_encode($pilldata, JSON_UNESCAPED_UNICODE);
	//echo $jspilldata;


	

	//print_r($pilllist);

	//echo "<br>==============================<br>";
	//echo "제환전체 리스트 <br>";
	$pillOrderList=$odData["pillOrderList"];
	//$jspillOrderList=json_encode($pillOrderList, JSON_UNESCAPED_UNICODE);
	//echo $jspillOrderList;


	//echo "<br>==============================<br>";
	//echo "제환순서 리스트 <br>";
	$pillOrder=$odData["pillorder"];
	//$jspillOrder=json_encode($pillOrder);
	//echo $jspillOrder;

	//약재리스트 
	$pillmedicine=$odData["pillmedicine"];
	//echo "<br>==============================<br>";
	//echo "pillmedicine 약재 리스트 <br>";
	//$jspillmedicine=json_encode($pillmedicine);
	//echo $jspillmedicine;


	

	if(intval($pillData["baseCapa"])<=0 || !$pillData["pillorder"])
	{
		echo "<script>$('#pillorderdiv').data('check','false')</script>";
	}
	else
	{
		echo "<script>$('#pillorderdiv').data('check','true')</script>";
	}

	echo "<script>$('input[name=odPillcapa]').val('".$odData["odPillcapa"]."');</script>";

	$rcPillorder=array("pilllist"=>$pilllist, "pillmedicine"=>$pillmedicine, "totmedicapa"=>$odData["totmedicapa"], "totmediprice"=>$odData["totmediprice"]);
	$jsonpillorder=json_encode($rcPillorder);

	echo "<script>$('textarea[name=rcPillorder]').val('".$jsonpillorder."');</script>";

	$dcWater=$odData["dcWater"];


?>
<style>
	.pill dl{width:5%;margin:1%;display:inline-block;vertical-align:top;}
	.pill dl dt{width:auto;border:1px solid #ddd;border-radius:7px;text-align:center;padding:10px 5px;color:#999;font-size:17px;font-weight:bold;}
	.pill dl dt.on{color:#111;border:1px solid #48DAFF;background:#48DAFF;}
	.pill dl dd{margin:2px auto;width:100%;}
	.pill dl dd select{width:100%;}
	.board-view-wrap table thead th{padding:13px 20px;font-size:15px;}
</style>



<?php if($pillmedicine){ ?>
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

		//|HD051102KR0001J,122500,inmain,20|HD004401KR0003G,34083,inmain,21|HD024401KR0001F,4396,inmain,192|HD052601CN0001G,8804,inmain,14
			
			$rcmedicine="";
			//for($i=0;$i<$medicinecnt;$i++)
			//for($i=(count($pillmedicine)-1);$i>=0;$i--)
			foreach($pillmedicine as $key => $value)
			{
				//|HD031801KR0001E,4.0,inmain,31,P0|HD035201KR0001E,2.0,inmain,72,P0|HD024401KR000
				$rcmedicine.="|".$pillmedicine[$key]["mdCode"].",".$pillmedicine[$key]["medicapa"].",inmain,".$pillmedicine[$key]["mediprice"];
				echo "<tr>";
				echo "<td>".$pillmedicine[$key]["code"]."</td>";
				echo "<td>".$pillmedicine[$key]["typetxt"]."</td>";
				echo "<td class='l'>".$pillmedicine[$key]["title"]."</td>";
				echo "<td>".$pillmedicine[$key]["medibox"]."</td>";
				echo "<td>".$pillmedicine[$key]["poison"]."/".$pillmedicine[$key]["dismatch"]."</td>";
				echo "<td>".$pillmedicine[$key]["origin"]."</td>";
				echo "<td class='r'>".number_format($pillmedicine[$key]["totalqty"])."</td>";
				echo "<td class='r'>".number_format($pillmedicine[$key]["medicapa"])."</td>";
				echo "<td class='r'>".number_format($pillmedicine[$key]["mediprice"])."</td>";
				echo "<td class='r'>".number_format($pillmedicine[$key]["totalprice"])."</td>";
				echo "</tr>";
				
			}			
		?>
		<input type="hidden" name="rcMedicine" class="reqdata necdata" class="w90p" title="<?=$txtdt["1205"]?>" value="<?=$rcmedicine;?>">
		</tbody>

		<tfoot>
			<tr>
				<td colspan="7" class="r b cred">별전은 약재량에 포함되지 않습니다.</td>
				<td class="r"> <i class="b f15" id="meditotal"><?=number_format($odData["totmedicapa"])?></i>g</td>
				<td colspan="2" class="r"><span><?=$txtdt["1607"]?><i class="b f18 cred" id="pricetotal"><?=number_format($odData["totmediprice"])?></i><?=$txtdt["1235"]?> </span></td>
			</tr>
		</tfoot>
	</table>
</div>
<?php } ?>

<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1949"]?><!-- 제환순서 --></h3>
<div class="board-view-wrap">	
	<div class='pill' id="pillorderdiv" data-check="">
	<?php 
		foreach($pillOrderList as $key => $value) //han_code에 등록된 제환순서
		{
			$cdCode=$value["cdCode"];
			$cdName=$value["cdName"];
			$cls="";
			if(in_array($cdCode, $pillOrder))
			{
				$cls="on";
			}
			echo "<dl id='".$cdCode."' >";
			echo "<dt class='".$cls."'>".$cdName."</dt>";
			echo "</dl>";
		}
	?>
	</div>
</div>


<!-- 작업순서 -->
<div class="gap"></div>
<h3 class="u-tit02">작업순서</h3>
<div class="board-view-wrap">
<span class="bd-line"></span>
<table>
	<caption><span class="blind"></span></caption>
	<colgroup>
		<col width="7%">
		<col width="10%">
		<col width="18%">
		<col width="7%">
		<col width="7%">
		<col width="7%">
		<col width="">
	</colgroup>
	<thead>
	<tr>
		<th>분류</th>
		<th>반제품명</th>
		<th>투입재료</th>
		<th>투입량</th>
		<th>손실량</th>
		<th>산출량</th>
		<th>작업내용</th>
	</tr>
	</thead>
	<tbody>
	<?php 
		//for($i=(count($pilllist)-1);$i>=0;$i--)//조제부터 뿌려주기 위해서 
		foreach($pilllist as $key => $val)
		{
			$plkey=$pilllist[$key]["key"];
			$value=$pilllist[$key]["order"];				
			$piType=$value["type"];

			$medicinetxt="";
			$worktxt="";
			$drawChk="";

			$piName="";
			$piIncapa="";
			$piLosscapa="";
			$piOutcapa="";
			
			if(!isEmpty($worktxt))
			{
				$worktxt.="<Br>";
			}
			
			$piTypeTxt=$value["typetxt"];

			$piIncapa.=number_format($value["incapa"])."g<br>";
			$piLosscapa.=number_format($value["losscapa"])."<br>";
			if($piType=="packing")
			{
				$piOutcapa.=number_format($value["outcapa"])."개<br>";
			}
			else
			{
				$piOutcapa.=number_format($value["outcapa"])."g<br>";
			}

			$porder=$value["order"]["medicine"];
			
			$medidan="g";
			foreach($porder as $key=>$val)
			{
				$medidan="g";

				if($porder[$key]["kind"]=="unit")
				{
					$medidan="개";
				}

				if(strpos($piName, $porder[$key]["parentname"])!==false)
				{
					$piName.="<br>";
				}
				else
				{
					$piName.=$porder[$key]["parentname"]." <br>";
				}
				$medicinetxt.=$porder[$key]["name"]." : ".number_format($porder[$key]["capa"]).$medidan." <br>";
			}


			$work=$value["order"]["work"];
			
			$dan="g";
			foreach($work as $key => $val1)
			{
				$pwcode=$val1["code"];
				$pwcodetxt=$val1["codetxt"];
				$pwvalue=$val1["value"];
				$pwvaluetxt=$val1["valuetxt"];

				if($pwcode && $pwcodetxt)
				{
					$worktxt.=$pwcodetxt." : ".$pwvaluetxt.", ";
				}
			}

			echo "<tr>";
			echo "	<td class='c'>".$piTypeTxt."</td>";
			echo "	<td>".$piName."</td>";
			echo "	<td>".$medicinetxt."</td>";
			echo "	<td class='r'>".$piIncapa."</td>";
			echo "	<td class='r'>".$piLosscapa."</td>";
			echo "	<td class='r'>".$piOutcapa."</td>";
			echo "	<td>".$worktxt."</td>";
			echo "</tr>";

		}

	
		/*
		for($j=0;$j<count($pillOrderList);$j++)
		{
			
			$poType=$pillOrderList[$j]["cdCode"];
			$medicinetxt="";
			$worktxt="";
			$drawChk="";

			$piName="";
			$piIncapa="";
			$piLosscapa="";
			$piOutcapa="";
			

			for($i=(count($pilllist)-1);$i>=0;$i--)//조제부터 뿌려주기 위해서 
			{
				$plkey=$pilllist[$i]["key"];
				$value=$pilllist[$i]["order"];				
				$piType=$value["type"];
				
				if($poType==$piType)
				{
					$drawChk="Y";
					if(!isEmpty($worktxt))
					{
						$worktxt.="<Br>";
					}
					

					$piTypeTxt=$value["typetxt"];
					$piName.=$value["name"]."<br>";

					$piIncapa.=number_format($value["incapa"])."g<br>";
					$piLosscapa.=number_format($value["losscapa"])."<br>";
					if($poType=="packing")
					{
						$piOutcapa.=number_format($value["outcapa"])."개<br>";
					}
					else
					{
						$piOutcapa.=number_format($value["outcapa"])."g<br>";
					}

					$porder=$value["order"]["medicine"];
					
					$medidan="g";
					foreach($porder as $key=>$val)
					{
						$medidan="g";
						if($porder[$key]["kind"]=="unit")
						{
							$medidan="개";
						}

						$medicinetxt.=$porder[$key]["name"]." : ".number_format($porder[$key]["capa"]).$medidan." <br>";
					}


					$work=$value["order"]["work"];
					
					$dan="g";
					foreach($work as $key => $val1)
					{
						$pwcode=$val1["code"];
						$pwvalue=$val1["value"];
						
						switch($pwcode)
						{
						case "plFineness"://분말도 
						case "plSoakTime"://불리는시간 
						case "plDctitle"://탕전법
						case "plDcspecial"://특수탕전 
						case "plConcentRatio"://농축비율
						case "plConcentTime"://농축시간 
						case "plJuice"://착즙유무 
						case "plBinders"://결합제 
						case "plstirBinders"://교반결합제 
						case "plWarmupTemperature"://중탕온도
						case "plWarmupTime"://중탕시간 
						case "plFermentTemperature"://숙성온도
						case "plFermentTime"://숙성시간 
						case "plShape"://제형
						case "plDryTemperature"://건조온도
						case "plDryTime"://건조시간 
							$list=getpillcodelist($pwcode);
							
							foreach($list as $key2 => $val2)
							{
								if($pwvalue == $list[$key2]["cdCode"])
								{
									$worktxt.=$list[$key2]["cdTypeTxt"]." : ".$list[$key2]["cdName"].", ";
								}
							}
							break;
						case "plMillingloss"://제분손실 
						case "plDctime"://탕전시간 
						case "plLosspill"://제형손실 
							//$pwtitle=getpillcodename($pwcode);
							if($pwcode=="plDctime")
							{
								$pwtitle="탕전시간";
							}
							else if($pwcode=="plMillingloss")
							{
								$pwtitle="제분손실";
							}
							else if($pwcode=="plLosspill")
							{
								$pwtitle="제형손실";
							}

							$worktxt.=$pwtitle." : ".$pwvalue;
							//$str.='<td><input type="text" class="cred w15p reqdata necdata r" title="'.$pwtitle.'" name="'.$pwcode.$gdcode.'" value="'.$pwvalue.'" onkeyup="onKeyupOrderPill();" /></td>';
							break;
						case "plPacking"://포장
							//$pwname=$value["name"];
							//$str.=$pwname."<br>";
							
							$dan="개";
							break;
						}
					}
				}
			}

			if($drawChk=="Y")
			{
				echo "<tr>";
				echo "	<td class='c'>".$piTypeTxt."</td>";
				echo "	<td>".$piName."</td>";
				echo "	<td>".$medicinetxt."</td>";
				echo "	<td class='r'>".$piIncapa."</td>";
				echo "	<td class='r'>".$piLosscapa."</td>";
				echo "	<td class='r'>".$piOutcapa."</td>";
				echo "	<td>".$worktxt."</td>";
				echo "</tr>";
			}
		}
		*/
	?>	
	</tbody>
</table>
</div>

<div class="gap"></div>
