<?php 
//나의처방상세 
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
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Recipebasic/MyRecipeList.php">

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
				<th><span class="">등록일</span></th>
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
				<th><span class="">한의사</span></th>
				<td id="odStaff"></td>
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
		</tbody>
	</table>

	<div class="btn-box c">
		 <button class="bw-btn" onclick="viewlist();"><?=$txtdt["1087"]?><!-- 목록 --></button>
	</div>
</div>

<!--// page end -->


<script>
    function makepage(json)
    {
    	var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"] == 'myrecipedesc')
		{
			$("#rcDate").text(obj["rcDate"]); //처방일
			$("#miName").text(obj["miName"]); //한의원
			$("#odStaff").text(obj["meName"]); //한의사
			$("#odChubcnt").text(obj["rcChub"] + " ea"); //첩수
			$("#odPackcnt").text(obj["rcPackcnt"] + " <?=$txtdt[1018]?>"); //팩수
			$("#odPackcapa").text(obj["rcPackcapa"] + " ml"); //팩용량
			$("#rcTitle").text(obj["rcTitle"]); //처방명
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

	callapi('GET','recipe','myrecipedesc','<?=$apidata?>'); 	//처방등록 상세 API 호출

</script>
