<?php //약재출고등록 상세내용
$root = "../..";
include_once ($root.'/_common.php');
$apidata="seq=".$_GET["seq"];
?>
<script>
	$.datepicker.setDefaults({
			dateFormat: 'yy-mm-dd',
			prevText: '이전 달',
      nextText: '다음 달',
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
      showMonthAfterYear: true,
      yearSuffix: '년'
		});

	$(function(){
		//출고일 달력
		$("#whDate").datepicker();
	})
</script>
<input type="hidden" name="seq" class="reqdata" value="">
<input type="hidden" name="apiCode" class="reqdata" value="outstockupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Stock/OutStockList.php">
<input type="hidden" name="mbTalbe" class="reqdata" value="">

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
				<th>
					<span class="nec"><?=$txtdt["1207"]?><!-- 약재바코드스캔 --></span>
				</th>
				<td colspan="3" id="bcScanDiv">

				</td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1132"]?><!-- 분류 --></span>
				</th>
				<td id="whCategoryOutStockDiv">

				</td>
				<th>
					<span><?=$txtdt["1237"]?><!-- 원산지 --></span>
				</th>
				<td id="mdOrigin"></td>
			</tr>
			<tr>
				<th>
					<span class="nec"><?=$txtdt["1204"]?><!-- 약재명 --></span>
				</th>
				<td id="mdTitle"></td>
				<th>
					<span class=""><?=$txtdt["1288"]?><!-- 제조사 --></span>
				</th>
				<td id="mdMaker"></td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1264"]?><!-- 입고일 --></span>
				</th>
				<td id="whInDate"></td>
				<th>
					<span><?=$txtdt["1242"]?><!-- 유통기한 --></span>
				</th>
				<td id="whInExpired"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1713"]?><!-- 조제대 --></span></th>
				<td id="mbTableDiv"></td>
				<th><span><?=$txtdt["1164"]?><!-- 상태 --></span></th>
				<td id="whStatusDiv"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1353"]?><!-- 출고지 --></span></th>
				<td id="whEtcOutStockDiv"></td>
				<th><span class="nec"><?=$txtdt["1350"]?><!-- 출고일 --></span></th>
				<td id="whDate"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1352"]?><!-- 출고제목 --></span></th>
				<td id="whTitle"></td>
				<th><span class="nec"><?=$txtdt["1351"]?><!-- 출고자 --></span></th>
				<td id="whStaff"></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1282"]?><!-- 재고수량 --></span></th>
				<td><div id="mdQty"></div></td>
				<th><span class="nec"><?=$txtdt["1347"]?><!-- 출고량 --></span></th>
				<td id="whQty"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1348"]?><!-- 출고사유 --></span></th>
				<td colspan="3">
				<textarea class="text-area reqdata" name="whMemo" title="<?=$txtdt["1348"]?>" ></textarea>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btn-box c" id="btnDiv">

	</div>
</div>

<!--// page end -->

<script>
	function outstockcancelupdate()
	{
		if(!confirm("<?=$txtdt['1696']?>")){return;}//출고취소를 하시겠습니까?

		if(necdata()=="Y") //필수조건 체크
		{
			var key=data="";
			var jsondata={};

			//radio data
			$(".radiodata").each(function()
			{
				key=$(this).attr("name");
				data=$(":input:radio[name="+key+"]:checked").val();
				jsondata[key] = data;
			});

			$(".reqdata").each(function(){
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});

			console.log(JSON.stringify(jsondata));
			callapi("POST","stock","outstockcancelupdate",jsondata);
			$("#btnDiv a").eq(0).attr("onclick","alert('<?=$txtdt['1885']?>')").children("span").text("<?=$txtdt['1884']?>");
		}

	}
    function makepage(json)
    {
	    var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="outstockdesc") //약재출고등록
		{
			$("input[name=seq").val(obj["seq"]);//seq

			$("#bcScanDiv").text(obj["whCode"]); //약재바코드스캔

			var whDate = (isEmpty(obj["whDate"])) ? getNewDate() : obj["whDate"];
			$("#whDate").text(whDate);//출고일
			$("#whTitle").text(obj["whTitle"]); //출고제목
			$("#whQty").text(comma(obj["whQty"]) + " g"); //출고량
			//$("input[name=mdQty]").val(obj["mdQty"]); //재고수량
			$("#mdQty").text(comma(obj["mdQty"]) + " g"); //재고수량


			var stUserid=isEmpty(obj["whStaff"]) ? '' : obj["whStaff"];
			$("#whStaff").text(stUserid); //출고자
			$("textarea[name=whMemo]").text(obj["whMemo"]); //출고사유

			$("#mdOrigin").text(obj["mdOrigin"]); //원산지
			$("#mdTitle").text(obj["mdTitle"]); //약재명
			$("#mdMaker").text(obj["mdMaker"]); //제조사

			$("#whInDate").text(obj["whInDate"]); //입고일
			$("#whInExpired").text(obj["whInExpired"]); //유통기한 

			
			var category = isEmpty(obj["whCategory"]) ? "basic" : obj["whCategory"];
			getListData("whCategoryOutStockDiv", obj["whCategoryOutStockList"],category);
			getListData("whEtcOutStockDiv", obj["whEtcOutStockList"],obj["whEtc"]);

			//조제대 
			$("input[name=mbTalbe").val(obj["whTable"]);
			getListData("mbTableDiv", obj["mbTableList"],obj["whTable"]);

			getListData("whStatusDiv", obj["whStatusOutStockList"],obj["whStatus"]);//출고상태 
			

			var btnHtml='';
			var json = "seq="+obj["seq"];
			if(obj["whStatus"]!="cancel")// && obj["cancelStatus"]=="false")
				btnHtml+='<a href="javascript:;" onclick="outstockcancelupdate();" class="bdp-btn"><span><?=$txtdt["1695"]?></span></a> ';//출고취소
			btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록

			$("#btnDiv").html(btnHtml);


		}

		return false;
    }

	callapi('GET','stock','outstockdesc','<?=$apidata?>'); 	//약재출고등록 상세 API 호출
</script>
