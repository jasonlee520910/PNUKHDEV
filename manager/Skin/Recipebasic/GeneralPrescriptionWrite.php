<?php //처방등록 상세
$root = "../..";
include_once ($root.'/_common.php');
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
?>
<style>
	#medilist{border:0;border-right:1px solid #ddd;}
	#medilist td{border:1;border-top:1px solid #ddd;}
	#sweetlist{border:0;border-right:1px solid #ddd;border-left:1px solid #ddd;}
	#sweetlist td{border:1;border-top:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;}
</style>

<input type="hidden" name="apiCode" class="reqdata" value="">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Recipebasic/GeneralPrescriptionList.php">

<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>

		<colgroup>
			<col width="180">
			<col width="*">
			<col width="180">
			<col width="*">
		</colgroup>

		<tbody>
			<tr>
				<th><span class=""><?=$txtdt["1327"]?><!-- 처방일 --></span></th>
				<td id="rcDate"></td>
				<th rowspan="13"><span class=""><?=$txtdt["1201"]?><!-- 약재구성 --></span></th>
				<td rowspan="13">
					<table id="medilist">
						<colgroup>
							<col width="25%"/>
							<col width="45%"/>
							<col width="30%"/>
						</colgroup>

						<thead>
						</thead>

						<tbody>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1403"]?><!-- 한의원 --></span></th>
				<td id="miName"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1328"]?><!-- 처방자  --></span></th>
				<td id="odStaff"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1414"]?><!-- 환자명 --></span></th>
				<td id="reName"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1323"]?><!-- 처방명 --></span></th>
				<td id="rcTitle"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1335"]?><!-- 첩수 --></span></th>
				<td id="odChubcnt"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1384"]?><!-- 팩수 --></span></th>
				<td id="odPackcnt"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1386"]?><!-- 팩용량 --></span></th>
				<td id="odPackcapa"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1367"]?><!-- 탕전법 --></span></th>
				<td id="dcTitle"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1381"]?><!-- 특수탕전 --></span></th>
				<td id="dcSpecial"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1369"]?><!-- 탕전시간 --></span></th>
				<td id="dcTime"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1366"]?><!-- 탕전물량 --></span></th>
				<td id="dcWater"></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1118"]?><!-- 복약지도 --></span></th>
				<td id="odAdvice"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1516"]?><!-- 주문금액 --></span></th>
				<td id="odAmount"></td>
				<th><span class=""><?=$txtdt["1017"]?><!-- 감미제구성 --></span></th>
				<td>
					<table id="sweetlist">
						<colgroup>
							<col width="21%"/>
							<col width="12%"/>
							<col width="21%"/>
							<col width="12%"/>
							<col width="22%"/>
							<col width="12%"/>
						</colgroup>
						<thead>
						</thead>
						<tbody>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btn-box c">
		 <!-- <a href="javascript:;" onclick="golistload();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
		 <button class="bw-btn" onclick="viewlist();"><?=$txtdt["1087"]?><!-- 목록 --></button>
	</div>
</div>

<!--// page end -->


<script>
    function makepage(json)
    {
    	var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"] == 'generalscdesc')
		{
			$("#rcDate").text(obj["rcDate"]); //처방일
			$("#miName").text(obj["miName"]); //한의원
			$("#odStaff").text(obj["odStaffname"]); //처방자
			$("#reName").text(obj["reName"]); //환자명
			$("#odChubcnt").text(obj["odChubcnt"] + " ea"); //첩수

			$("#odAmount").text(comma(obj["odAmount"]) + " <?=$txtdt["1235"]?>"); //주문금액

			$("#odPackcnt").text(obj["odPackcnt"] + " <?=$txtdt["1018"]?>"); //팩수
			$("#odPackcapa").text(obj["odPackcapa"] + " ml"); //팩용량

			$("#odAdvice").text(obj["odAdvice"]); //복약지도

			$("#dcTime").text(obj["dcTime"] + " <?=$txtdt["1437"]?>"); //탕전시간
			$("#dcWater").text(comma(obj["dcWater"]) +" ml"); //탕전물량


			//parsemedicine("medilist", obj["rcMedicine"]);

			//탕전법 : dcTitle
			var dcTitledata = (!isEmpty(obj["dcTitle"])) ? obj["dcTitle"] : "decoctype03";
			parsecodes("dcTitle", obj["dcTitleList"], '<?=$txtdt["1367"]?>', 'gdcTitle', 'dcTitle', dcTitledata, '', 'readonly');

			//특수탕전 : dcSpecial
			var dcSpecialdata = (!isEmpty(obj["dcSpecial"])) ? obj["dcSpecial"] : "spdecoc01";
			parsecodes("dcSpecial", obj["dcSpecialList"], '<?=$txtdt["1369"]?>', 'gdcSpecial', 'dcSpecial', dcSpecialdata, '', 'readonly');


			$("#rcTitle").text(obj["rcTitle"]); //처방명
			//$("#mhCapaImsi").text(obj["mhCapaImsi"]); //약재구성
			$("#rcSweet").text(obj["rcSweet"]); //감미제구성
			$("#rcTingue").text(obj["rcTingue"]); //설진단
			$("#rcPulse").text(obj["rcPulse"]); //맥상
			$("#mhCapaImsi").text(obj["mhCapaImsi"]); //복용법
			$("#mhCapaImsi").text(obj["mhCapaImsi"]); //주치
			$("#mhCapaImsi").text(obj["mhCapaImsi"]); //효능

			//약재구성
			var medicine_list = obj["rcMedicineList"];
			var data="";
			for(var key in medicine_list)
			{
				data+="<tr id='tr"+medicine_list[key]["code"]+"'>";
				data+="<td>"+medicine_list[key]["typeText"]+"</td>";
				data+="<td>"+medicine_list[key]["title"]+"</td>";
				data+="<td>"+medicine_list[key]["chub"]+" g</td>";
				data+="</tr>";
			}
			$("#medilist tbody").html(data);

			//감미제, 녹용, 자하거
			//|9980,2,inlast,730|9985,2,inlast,731|9986,2,inlast,732
			if(!isEmpty(obj["rcSweet"]))
			{
				var sweet_list = obj["rcSweetList"];
				var total = 0;
				var data="<tr>";
				var sweet_max = 3;
				var cnt=sweet_list.length;

				if(cnt>sweet_max)  //별전이 4이상일때
				{
					for(var key in sweet_list)
					{
						if(key<3) //첫번째 줄
						{
							data+="<td>"+sweet_list[key]["title"]+"</td>";
							data+="<td>"+sweet_list[key]["chub"]+" <?=$txtdt["1018"]?> </td>";
						}
					}
					data+='      </tr>';
					for(var key in sweet_list)
					{
						if(key>2)  //두번째 줄
						{
							data+="<td>"+sweet_list[key]["title"]+"</td>";
							data+="<td>"+sweet_list[key]["chub"]+" <?=$txtdt["1018"]?> </td>";
						}
					}
					data+='      </tr>';
				}
				else  //별전이 3이하일때
				{

					for(var key in sweet_list)
					{
						data+="<td>"+sweet_list[key]["title"]+"</td>";
						data+="<td>"+sweet_list[key]["chub"]+" <?=$txtdt["1018"]?> </td>";
					}
				}
				data+="</tr>";
				$("#sweetlist tbody").html(data);
			}
		}
        return false;
    }

	callapi('GET','recipe','generalscdesc','<?=$apidata?>'); 	//처방등록 상세 API 호출

</script>
