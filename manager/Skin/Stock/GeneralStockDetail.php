<?php //자재등록 상세내용
$root = "../..";
include_once ($root.'/_common.php');
$apidata="seq=".$_GET["seq"];
?>

<style>
	.outcodetr{display:none;}
</style>

<input type="hidden" name="inOutType" class="reqdata" value="">
<input type="hidden" name="seq" class="reqdata" value="">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Stock/GeneralStockList.php">

<!--// page start -->
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
				<th><span><?=$txtdt["1257"]?><!-- 입/출고 구분 --></span></th>
				<td colspan="3" id="whStatusGeStockDiv"></ul></td>
			</tr>
			<tr class="outcodetr">
				<th><span class="nec"><?=$txtdt["1097"]?><!-- 바코드스캔 --></span></th>
				<td colspan="3" id="barcodeDiv"></td>
			</tr>
			<tr class="incodetr">
				<th><span><?=$txtdt["1271"]?><!-- 자재분류 --></span></th>
				<td colspan="3" id="whCategoryDiv"></td>
			</tr>
			<tr class="incodetr">
				<th><span class="nec"><?=$txtdt["1273"]?><!-- 자재코드 --></span></th>
				<td><span id="whCategoryGeStockDiv"></span><span id="whCodeDiv"></span></td>
				<th><span class="nec"><?=$txtdt["1264"]?><!-- 입고일 --></span></th>
				<td id="whDate"></td>
			</tr>
			 <tr class="incodetr">
				<th><span class="nec"><?=$txtdt["1275"]?><!-- 자재품명 --></span></th>
				<td id="whTitle"></td>
				<th><span class="nec"><?=$txtdt["1237"]?><!-- 원산지 --></span></th>
				<td id="whOrigin"></td>
			</tr>
			<tr class="incodetr">
				<th><span><?=$txtdt["1054"]?><!-- 담당자 --></span></th>
				<td id="whStaff"></td>
				<th><span class="nec"><?=$txtdt["1288"]?><!-- 제조사 --></span></th>
				<td id="whMaker"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1258"]?><!-- 입/출고량 --></span></th>
				<td id="whQty"></td>
				<th><span class="nec"><?=$txtdt["1037"]?><!-- 금액 --></span></th>
				<td id="whPrice"></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1029"]?><!-- 관리자 메모 --></span></th>
				<td colspan="3" id="whMemo"></td>
			</tr>
	</tbody>
</table>

<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1041"]?><!-- 기타메모 --></h3>
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
				<th><span class=""><?=$txtdt["1045"]?><!-- 납품처 --></span></th>
				<td id="whEtc"></td>
				<th><span class=""><?=$txtdt["1046"]?><!-- 납품코드 --></span></th>
				<td id="whEtccode"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1054"]?><!-- 담당자 --></span></th>
				<td id="whEtcstaff"></td>
				<th><span class=""><?=$txtdt["1225"]?><!-- 연락처 --></span></th>
				<td id="whEtcphone1"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1307"]?><!-- 주소 --></span></th>
				<td colspan="3" id="whEtcaddress1"></td>
			</tr>
		</tbody>
	</table>
	<div class="btn-box c" id="btnDiv"></div>
</div>

<script>

    function makepage(json)
    {
    	var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="genstockdesc")
		{
			if(obj["whStatus"]=="outgoing")
			{
				//출고 페이지가 보이게 해야함
				$(".outcodetr").fadeIn(0);
				$(".incodetr").fadeOut(0);
			}

			var json = "seq="+obj["seq"];
			var btnHtml=whCodeHtml='';

			btnHtml+='<button class="bw-btn" onclick="viewlist();"><?=$txtdt["1087"]?></button> ';//목록
			$("#btnDiv").html(btnHtml);

			if(!isEmpty(obj["seq"]))  //신규 입력일때는 바코드출력 버튼이 안보임
			{
				whCodeHtml+='<button class="sp-btn" type="button">';
				whCodeHtml+='<span class="" onclick="printbarcode(\'label\',\'warehouse|'+obj["seq"]+'\',500)"><?=$txtdt["1098"]?>';
				whCodeHtml+='</span>';
				whCodeHtml+='</button>';
			}
			$("input[name=seq]").val(obj["seq"]); //입고일
			$("#whCodeDiv").html(whCodeHtml);//자재코드

			getListData("whStatusGeStockDiv", obj["whStatusGeStockList"], obj["whStatus"]);   //입/출고 구분
			getListData("whCategoryDiv", obj["whCategoryGeStockList"], obj["whCategory"]);   //자재분류


			$("#barcodeDiv").text(obj["whCode"]); //자재코드
			$("#whCategoryGeStockDiv").text(obj["whCode"]); //자재코드
			$("#whTitle").text(obj["whTitle"]); //자재품명
			$("#whStaff").text(obj["whStaff"]); //담당자
			$("#whQty").text(obj["whQty"]); //입출고량

			$("#whMemo").text(obj["whMemo"]); //관리자메모
			$("#whDate").text(obj["whDate"]); //입고일
			$("#whOrigin").text(obj["whOrigin"]); //원산지
			$("#whMaker").text(obj["whMaker"]); //제조사
			$("#whPrice").text(comma(obj["whPrice"])+"<?=$txtdt["1235"]?>"); //금액

			$("#whEtc").text(obj["whEtc"]); //납품처
			$("#whEtccode").text(obj["whEtccode"]); //납품코드
			$("#whEtcstaff").text(obj["whEtcstaff"]); //담당자
			$("#whEtcphone1").text(obj["whEtcphone1"]+' - '+obj["whEtcphone2"]+' - '+obj["whEtcphone3"]); //연락처
			$("#whEtcaddress1").text(obj["whEtczipcode"]+'  '+obj["whEtcaddress1"]+'  '+obj["whEtcaddress2"]); //주소
		}
       	return false;
    }
	callapi('GET','stock','genstockdesc','<?=$apidata?>'); 	//약재입고등록 상세 API 호출
</script>
