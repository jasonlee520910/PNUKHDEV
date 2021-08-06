<?php //약재출고등록 상세내용
$root = "../..";
include_once ($root.'/_common.php');
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
$step=$_GET["step"];
if($_GET["step"]=="")$step=$_GET["step"]=1;
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
	});
</script>
<input type="hidden" name="apiCode" class="reqdata" value="outstockupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Stock/OutStockList.php">
<input type="hidden" name="OutStockStep" class="reqdata" value="<?=$step?>">

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
				<td id="mdOrigin" class="outInitData"></td>
			</tr>
			<tr>
				<th>
					<span class="nec"><?=$txtdt["1204"]?><!-- 약재명 --></span>
					<input type="hidden" name="whStock" class="necdata reqdata" value="" title="<?=$txtdt["1204"]?>"><!-- 약재코드 -->
				</th>
				<td id="mdTitle" class="textbold outInitData"></td>
				<th>
					<span class="outInitData"><?=$txtdt["1288"]?><!-- 제조사 --></span>
				</th>
				<td id="mdMaker"></td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1264"]?><!-- 입고일 --></span>
				</th>
				<td id="whInDate" class="outInitData"></td>
				<th>
					<span><?=$txtdt["1242"]?><!-- 유통기한 --></span>
				</th>
				<td id="whExpired" class="outInitData"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1713"]?><!-- 조제대 --></span></th>
				<td colspan="3" id="mbTableDiv">

				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1353"]?><!-- 출고지 --></span></th>
				<td id="whEtcOutStockDiv"></td>
				<th><!-- <span class="nec"><?=$txtdt["1350"]?>출고일</span> --></th>
				<td><input type="hidden" id="whDate" name="whDate" title="<?=$txtdt["1350"]?>" class="necdata reqdata" value=""  readonly ></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1352"]?><!-- 출고제목 --></span></th>
				<td><input type="text" name="whTitle" class="w80p necdata reqdata" title="<?=$txtdt["1352"]?>" maxlength="80" /></td>
				<th><span class="nec"><?=$txtdt["1351"]?><!-- 출고자 --></span></th>
				<td><input type="text" name="whStaff"  class="reqdata necdata" title="<?=$txtdt["1351"]?>" readonly/></td>
			</tr>
			<tr>
				<th><span>총 <?=$txtdt["1282"]?><!-- 재고수량 --></span></th>
				<td><div id="mdQty" class="outInitData"></div></td>
				<th><span class="nec"><?=$txtdt["1347"]?><!-- 출고량 --></span></th>
				<td><input type="text" name="whQty"  title="<?=$txtdt["1347"]?>" class="reqdata necdata" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);" /></td>
			</tr>
			<tr>
				<th><span>현재 <?=$txtdt["1282"]?><!-- 재고수량 --></span></th>
				<td colspan="3">
					<div id="nowMdQty" class="outInitData"></div>
				</td>
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
	function barcodeScan(obj)
	{
		if (event.keyCode == 13)
		{
			//1708, 1709

			var step=$("input[name=OutStockStep]").val();
			var code=obj.value;
			var url = "code="+code;
			var chkcode=code.substr(0,3);
			var whStock=$('input[name=whStock]').val();//약재코드
			console.log("step = " + step+", code = " + code +", chkcode = " + chkcode+", whStock = " + whStock);
			if(step=='1' || step=='')
			{			
				if(chkcode=="MDB")
				{
					var whDate = (isEmpty(obj["whDate"])) ? getNewDate() : obj["whDate"];
					$("input[name=whDate]").val(whDate);//출고일
					var stUserid=isEmpty(obj["whStaff"]) ? getCookie("ck_stUserid") : obj["whStaff"];
					$("input[name=whStaff]").val(stUserid); //출고자

					$('input[name=whQty]').val('');//출고량
					$("input[name=OutStockStep]").val('2');//step
					callapi("GET","inventory","mediboxdesc",url);
				}
				else if(chkcode=="STO")
				{	
					var whDate = (isEmpty(obj["whDate"])) ? getNewDate() : obj["whDate"];
					$("input[name=whDate]").val(whDate);//출고일

					var stUserid=isEmpty(obj["whStaff"]) ? getCookie("ck_stUserid") : obj["whStaff"];
					$("input[name=whStaff]").val(stUserid); //출고자
					var mdqty = !isEmpty(obj["mdQty"]) ? comma(obj["mdQty"]) : "";
					$("#mdQty").text(mdqty); //총재고수량
					$("#nowMdQty").text(obj["nowqty"]); //현재재고수량
					$('#whInDate').text(obj["whDate"]);// 입고일
					$("input[name=OutStockStep]").val('2');//step					
					callapi("GET","stock","instocksearch",url);
				}
				else
				{
					alertsign('warning','<?=$txtdt["1206"]?>','','1500');//약재함이나 약재바코드를 스캔해 주세요.
					$('input[name=whQty]').val('');//출고량
					$('input[name=whCode]').val('');
					$('input[name=whCode]').focus();
					$('#outInfoTxt').text('<?=$txtdt["1206"]?>');//약재함이나 약재바코드를 스캔해 주세요.
				}
			}
			else if(step=='2')
			{
				if(chkcode=="STO")
				{
					$('input[name=whQty]').val('');//출고량
					url+="&whStock="+whStock;
					callapi("GET","stock","instocksearch",url);
				}
				else if(chkcode=="MDB")
				{
					$('input[name=whQty]').val('');//출고량
					$("input[name=OutStockStep]").val('2');
					url+="&whStock="+whStock;
					callapi("GET","inventory","mediboxdesc",url);
				}
				else
				{
					alertsign('warning','<?=$txtdt["1206"]?>','','1500');//약재함이나 약재바코드를 스캔해 주세요.		
					$('input[name=whQty]').val('');//출고량
					$('input[name=whCode]').val('');
					$('input[name=whCode]').focus();
					$('#outInfoTxt').text('<?=$txtdt["1206"]?>');//약재함이나 약재바코드를 스캔해 주세요.
				}

			}
		}
	}

	function outstockupdate()
	{
		var whCode=$("input[name=whCode]").val();
		var mdqty = Number($("#mdQty").text().replace(",",""));
		var whqty = Number($("input[name=whQty]").val());
		if(!isEmpty(whCode))
		{
			if(mdqty >= whqty)
			{
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
					
					callapi("POST","stock","outstockupdate",jsondata);
					$("#btnDiv a").eq(0).attr("onclick","alert('<?=$txtdt['1885']?>')").children("span").text("<?=$txtdt['1884']?>");
				}
			}
			else
			{
				alertsign('warning','<?=$txtdt["1679"]?>','','1500');//재고수량보다 출고량이 많습니다.
				$("input[name=whQty]").focus();
			}
		}
		else
		{
			$("input[name=OutStockStep]").val('1');
			alertsign('warning','<?=$txtdt["1206"]?>','','1500');//약재함이나 약재바코드를 스캔해 주세요.
		}

	}
	function initOutStock()
	{
		$('#mdMaker').text('');//제조사 
		$('#whInDate').text('');// 입고일
		$('#whExpired').text('');// 유통기한
		$("#mdQty").text(''); //재고수량
		$('#mdOrigin').text('');//원산지
		$('input[name=whStock]').val('');
		$("#mdTitle").text('');
		$('input[name=whQty]').val('');
		//$('input[name=whStaff]').val('');
		$('input[name=whTitle]').val('');
		$('input[name=whCode]').focus();
	}
    function makepage(json)
    {
	    var obj = JSON.parse(json);
		console.log(obj);
		
		if(obj["apiCode"]=="outstockdesc") //약재출고등록
		{
			if(isEmpty(obj["seq"]))
			{
				$("#bcScanDiv").html('<input type="email" name="whCode" class="w200 necdata reqdata" title="<?=$txtdt["1207"]?>" onkeydown="barcodeScan(this)" onfocus="this.select();" style="ime-mode:disabled;" /><span class="mg5 info-ex02 textbold" id="outInfoTxt"><?=$txtdt["1206"]?></span>');//<!-- 약재함이나 약재바코드를 스캔해 주세요.-->
			}
			else
			{
				$("#bcScanDiv").html('<input type="email" name="whCode" class="w200 necdata reqdata" title="<?=$txtdt["1207"]?>" onfocus="this.select();" readonly />');
			}

			$("input[name=whCode]").val(obj["whCode"]); //약재바코드스캔
			$("input[name=whCode]").focus();
			var whQty = !isEmpty(obj["whQty"]) ? comma(obj["whQty"]) : "";
			$("input[name=whQty]").val(whQty); //출고량
			var mdQty = !isEmpty(obj["mdQty"]) ? comma(obj["mdQty"]) : "";
			$("#mdQty").text(mdQty); //재고수량

			$("input[name=whStock]").val(obj["whStock"]); //약재코드
			$("textarea[name=whMemo]").text(obj["whMemo"]); //출고사유

			$("#mdOrigin").text(obj["mdOrigin"]); //원산지
			$("#mdTitle").text(obj["mdTitle"]); //약재명
			$("#mdMaker").text(obj["mdMaker"]); //제조사

			var stUserid=isEmpty(obj["whStaff"]) ? getCookie("ck_stUserid") : obj["whStaff"];
			$("input[name=whStaff]").val(stUserid); //출고자

			parseradiocodes("whCategoryOutStockDiv", obj["whCategoryOutStockList"], '<?=$txtdt["1132"]?>', "whCategory", "outStock-list", obj["whCategory"], 'readonly');
			parseradiocodes("whEtcOutStockDiv", obj["whEtcOutStockList"], '<?=$txtdt["1353"]?>', "whEtc", "outStock-list", obj["whEtc"], '');

			parseradiocodes("mbTableDiv", obj["mbTableList"], '<?=$txtdt["1713"]?>', "mbTalbe", "outStockTable-list", null, '');



			var btnHtml='';
			var json = "seq="+obj["seq"];

			btnHtml='<a href="javascript:;" onclick="outstockupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
			btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록

			$("#btnDiv").html(btnHtml);

			$('input[name=whCode]').focus();
		}
		else if(obj["apiCode"]=="instocksearch")
		{
			if(!isEmpty(obj["inState"]))
			{
				if(obj["inState"] == "NOSTO")//약재함 바코드가 아니다. 
				{
					alertsign('warning','<?=$txtdt["1206"]?>','','2000');//약재함이나 약재바코드를 스캔해 주세요.
					$('#outInfoTxt').text('<?=$txtdt["1206"]?>');//약재함이나 약재바코드를 스캔해 주세요.
					initOutStock();					
				}
				else if(obj["inState"] == "NOMEDICINE") //입고내역이 없습니다. 
				{
					alertsign('warning','<?=$txtdt["1523"]?>','','2000');//입고내역이 없습니다.
					$('#outInfoTxt').text('<?=$txtdt["1523"]?>');
					initOutStock();
				}
				else if(obj["inState"] == "NOQTY") //재고량이 없는 약재입니다. 
				{
					alertsign('warning','<?=$txtdt["1694"]?>','','2000');//재고량이 없는 약재입니다
					$('#outInfoTxt').text('<?=$txtdt["1694"]?>');
					initOutStock();
				}
				else if(obj["inState"] == "NOEXPIRED") //유통기한이 얼마남지 않는 약재가 있습니다. 먼저 출고해주세요 
				{
					alertsign('warning','<?=$txtdt["1605"]?>','','2000');//유통기한이 얼마남지 않는 약재가 있습니다. 먼저 출고해주세요
					$('#outInfoTxt').text('<?=$txtdt["1605"]?>');
					initOutStock();
				}
				else if(obj["inState"] == "NOREMAIN") //유통기한은 같고, 재고량이 더 적은 약재가 있습니다. 먼저 출고해주세요. 
				{
					alertsign('warning','<?=$txtdt["1830"]?>','','2000');//유통기한은 같고, 재고량이 더 적은 약재가 있습니다. 먼저 출고해주세요. 
					$('#outInfoTxt').text('<?=$txtdt["1830"]?>');
					initOutStock();
				}
				else if(obj["inState"] == "STATECANCEL") //입고취소한 약재입니다
				{
					alertsign('warning','<?=$txtdt["1693"]?>','','2000');//입고취소한 약재입니다
					$('#outInfoTxt').text('<?=$txtdt["1693"]?>');
					initOutStock();
				}				
				else
				{
					if(obj["mdType"] == "medicine")
					{
						obj["whCategory"] = 'basic';
					}
					else
					{
						obj["whCategory"] = 'ample';
					}

					parseradiocodes("whCategoryOutStockDiv", obj["whCategoryOutStockList"], '<?=$txtdt["1132"]?>', "whCategory","outStock-list", obj["whCategory"], 'readonly'); //1132 : 분류 

					$('input[name=whStock]').val(obj["whStock"]);//약재코드 
					$('#mdTitle').text(obj["mdTitle"]);//약재명
					$('#mdOrigin').text(obj["mdOrigin"]);//원산지
					$('#mdMaker').text(obj["mdMaker"]);//제조사 
					$('#whInDate').text(obj["whDate"]);// 입고일
					$('#whExpired').text(obj["whExpired"]);// 유통기한
					var mdQty = !isEmpty(obj["mdQty"]) ? comma(obj["mdQty"]) : "";
					$("#mdQty").text(mdQty); //재고수량
					$("#nowMdQty").text(obj["nowqty"]); //현재재고수량
					$('input[name=whQty]').attr('data-value',obj["whRemain"]).val(obj["whRemain"]).focus();
					alertsign('success','<?=$txtdt["1711"]?>','','1500');//출고량을 입력하세요.
					$('#outInfoTxt').text('<?=$txtdt["1711"]?>');

					$("input[name=whTitle]").val("<?=$txtdt['1291']?>("+obj["mdTitle"]+")"); //출고제목
					var stUserid=getCookie("ck_stUserid");//isEmpty(obj["whStaff"]) ? getCookie("ck_stUserid") : obj["whStaff"];
					$("input[name=whStaff]").val(stUserid); //출고자
				}
			}
			else
			{
				var data="code="+obj["wh_code"];
				$('input[name=whCode]').focus();
				callapi("GET","inventory","mediboxdesc",data);
			}
		}
		else if(obj["apiCode"]=="mediboxdesc")
		{
			$("input[name=whCode]").val("");
			$('input[name=whCode]').focus();
			//약재함이 있다면  
			if(!isEmpty(obj["seq"]))
			{
				$('#mdMaker').text('');//제조사 
				$('#whInDate').text('');// 입고일
				$('#whExpired').text('');// 유통기한
				$("#mdQty").text(''); //재고수량

				$("input[name=whTitle]").val("<?=$txtdt['1291']?>("+obj["mdTitle"]+")"); //출고제목

				$('#mdTitle').text(obj["mdTitle"]);//약재명
				$('#mdOrigin').text(obj["mdOrigin"]);//원산지
				$('input[name=whStock]').val(obj["mbMedicine"]);//약재코드
				parseradiocodes("mbTableDiv", obj["mbTableList"], '<?=$txtdt["1713"]?>', "mbTalbe", "outStockTable-list", obj["mbTable"], 'readonly'); //조제대 
				$('#outInfoTxt').text('<?=$txtdt["1710"]?>');//입력받은 약재함의 약재를 입력하세요

			}
			else
			{
				parseradiocodes("mbTableDiv", obj["mbTableList"], '<?=$txtdt["1713"]?>', "mbTalbe", "outStockTable-list", null, ''); //조제대 
				var code = obj["mb_code"];
				var chkcode=code.substr(0,3);
				switch(chkcode)
				{
				case "MDB":
					alertsign('warning','<?=$txtdt["1666"]?>','','1500');//약재함 코드가 아닙니다
					$('#outInfoTxt').text('<?=$txtdt["1666"]?>');
				return;
				case "STO":
					alertsign('warning','<?=$txtdt["1523"]?>','','1500');//입고내역이 없습니다.
					$('#outInfoTxt').text('<?=$txtdt["1523"]?>');
				return;
				default:
					alertsign('warning','<?=$txtdt["1667"]?>','','1500');//잘못된 코드입니다.
					$('#outInfoTxt').text('<?=$txtdt["1667"]?>');
				return;
				}
				initOutStock();

			}
		}

		return false;
    }

	callapi('GET','stock','outstockdesc','<?=$apidata?>'); 	//약재출고등록 상세 API 호출
</script>
