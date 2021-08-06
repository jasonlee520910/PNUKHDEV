<?php //자재등록 상세내용
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
	.outcodetr{display:none;}
</style>

<script>
	 $.datepicker.setDefaults({
			dateFormat: 'yy-mm-dd'
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
		//달력
		$("#whDate").datepicker();
	})
</script>
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
				<td colspan="3">
					<input type="text" name="whCode" class="w200 barcode reqdata necOut" title="<?=$txtdt["1097"]?>" value="" />
					<span class="mg5 info-ex02"><?=$txtdt["1095"]?><!-- 바코드를 스캔해 주세요 --></span>
				</td>
			</tr>
			<tr class="incodetr">
				<th><span><?=$txtdt["1271"]?><!-- 자재분류 --></span></th>
				<td colspan="3" id="whCategoryGeStockDiv"></td>
			</tr>
			<tr class="incodetr">
				<th><span class="nec"><?=$txtdt["1273"]?><!-- 자재코드 --></span></th>
				<td>
					<span id="whCodeDiv"></span>
				</td>
				<th><span class="nec"><?=$txtdt["1264"]?><!-- 입고일 --></span></th>
				<td><input type="text" id="whDate" name="whDate" value="" class="reqdata necdata" title="<?=$txtdt["1264"]?>" readonly></td>
			</tr>
			 <tr class="incodetr">
				<th><span class="nec"><?=$txtdt["1275"]?><!-- 자재품명 --></span></th>
				<td><input type="text" name="whTitle"  class="reqdata necdata" maxlength="10" title="<?=$txtdt["1275"]?>"/></td>
				<th><span class="nec"><?=$txtdt["1237"]?><!-- 원산지 --></span></th>
				<td><input type="text" name="whOrigin"  class="reqdata necdata" title="<?=$txtdt["1237"]?>"/></td>
			</tr>
			<tr class="incodetr">
				<th><span><?=$txtdt["1054"]?><!-- 담당자 --></span></th>
				<td><input type="text" name="whStaff" class="reqdata"/></td>
				<th><span class="nec"><?=$txtdt["1288"]?><!-- 제조사 --></span></th>
				<td><input type="text" name="whMaker" class="reqdata necdata" title="<?=$txtdt["1288"]?>"/></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1258"]?><!-- 입/출고량 --></span></th>
				<td><input type="text" name="whQty" class="reqdata necdata necOut" title="<?=$txtdt["1258"]?>" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th><span class="nec"><?=$txtdt["1037"]?><!-- 금액 --></span></th>
				<td><input type="text" name="whPrice" class="reqdata necdata necOut" title="<?=$txtdt["1037"]?>" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1029"]?><!-- 관리자 메모 --></span></th>
				<td colspan="3">
					<textarea class="text-area reqdata" name="whMemo"></textarea>
				</td>
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
				<td><input type="text" name="whEtc" class="reqdata" /></td>
				<th><span class=""><?=$txtdt["1046"]?><!-- 납품코드 --></span></th>
				<td><input type="text" name="whEtccode" class="reqdata" /></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1054"]?><!-- 담당자 --></span></th>
				<td><input type="text" name="whEtcstaff" class="reqdata" /></td>
				<th><span class=""><?=$txtdt["1225"]?><!-- 연락처 --></span></th>
				<td>
					<input type="hidden" title="<?=$txtdt["1225"]?>" class="w200 " maxlength="13" name="whEtcphone" value=""/>
					<input type="text" title="<?=$txtdt["1225"]?>" class="w100 reqdata" maxlength="4" name="whEtcphone1" onchange="changePhoneNumber(event, false);"/> -
					<input type="text" title="<?=$txtdt["1225"]?>" class="w100 reqdata" maxlength="4" name="whEtcphone2" onchange="changePhoneNumber(event, false);"/> -
					<input type="text" title="<?=$txtdt["1225"]?>" class="w100 reqdata" maxlength="4" name="whEtcphone3" onchange="changePhoneNumber(event, false);"/>
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1307"]?><!-- 주소 --></span></th>
				<td colspan="3">
					<input type="text" title="<?=$txtdt["1233"]?>" class="w100 reqdata" name="whEtczipcode" readonly/>
					<a href="javascript:getzip('whEtczipcode','whEtcaddress1');" class="cw-btn"><span><?=$txtdt["1232"]?><!-- 우편번호 --></span></a>
					<p class="mg5t">
						<input type="hidden" class="w200" name="whEtcaddress" value=""/>
						<input type="text" title="<?=$txtdt["1308"]?>" class="w40p reqdata" name="whEtcaddress1"  readonly/>
						<input type="text" title="<?=$txtdt["1308"]?>" class="w40p reqdata" name="whEtcaddress2" />
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btn-box c" id="btnDiv"></div>
</div>

<script>

	// function barcodeScan(obj)
	//  {
	// 	console.log("바코드입력됨")
	//
	// 	if (event.keyCode == 13)
	// 	{
	//
	// 		var codetext= obj.value;
	// 		var chkcode=codetext.substr(0,3);
	// 		console.log("세자리     :"+chkcode);
	// 		if(chkcode=="BLR" ||chkcode=="PCB" ||chkcode=="RBM" ||chkcode=="RBD" ||chkcode=="MDT")
	// 		{
	// 			console.log("5가지 코드에 해당")
	// 		}
	// 		else
	// 		{
	// 			alert('<?=$txtdt["1667"]?>');  /*잘못된 코드입니다.*/
	// 			return false;
	// 		}
	// 	}
	 // }


	//입고/출고 선택시   --->jquery.js function radioClick(obj) 로 이동
	// $(".selstattd").on("click",function()
	// {
	// 	alert("입출고 전환"+type);
	// 	var type=$(':radio[name="whStatus"]:checked').val();
	// 	if(type=="outgoing")
	// 	{
	// 		$("input[name=whCode]").val("");
	// 		$(".outcodetr").fadeIn(0);
	// 		$(".incodetr").fadeOut(0);
	// 	}
	// 	else
	// 	{
	// 		$(".outcodetr").fadeOut(0);
	// 		$(".incodetr").fadeIn(0);
	// 	}
	// });
	function genstockupdate()
	{
	 	var inOutType = $("input[name=inOutType]").val();  //입고인지 출고인지 확인

		if(inOutType==""|| inOutType=="incoming")
		{
			if(necdata()=="Y") //입고의 필수조건 체크
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
				callapi("POST","stock","genstockupdate",jsondata);
			}
		}

		if(inOutType=="outgoing")
		{
			if(necOut()=="Y") //출고의 필수조건 체크
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

				//바코드 앞 3자리 확인
				var whCodeText =$("input[name=whCode]").val();
				var chkcode=whCodeText.substr(0,3);

				if(chkcode=="BLR" ||chkcode=="PCB" ||chkcode=="RBM" ||chkcode=="RBD" ||chkcode=="MDT")
				{
					console.log(JSON.stringify(jsondata));
					callapi("POST","stock","genstockupdate",jsondata);
				}
				else
				{
					alert('<?=$txtdt["1667"]?>');  /*잘못된 코드입니다.*/
					return false;
				}
			}
		}
	}

    function makepage(json)
    {
    	var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="genstockdesc")
		{
			if(obj["whStatus"]=="outgoing")
			{
				//출고 페이지가 보이게 해야함
				$("input[name=whCode]").val("");
				$(".outcodetr").fadeIn(0);
				$(".incodetr").fadeOut(0);
			}

			var btnHtml=whCodeHtml='';

			whCodeHtml='<input type="text" name="barcode" title="<?=$txtdt["1273"]?>"  class="w200 reqdata necdata"  readonly />';  //입고할때 바코드 출력옆 text
			if(!isEmpty(obj["seq"]))  //신규 입력일때는 바코드출력 버튼이 안보임
			{
				whCodeHtml+='<button class="sp-btn" type="button">';
				whCodeHtml+='<span class="" onclick="printbarcode(\'label\',\'warehouse|'+obj["seq"]+'\',500)"><?=$txtdt["1098"]?>';
				whCodeHtml+='</span>';
				whCodeHtml+='</button>';
			}
			$("input[name=seq]").val(obj["seq"]); //입고일
			$("#whCodeDiv").html(whCodeHtml);//자재코드
			var whDate = isEmpty(obj["whDate"]) ? getNewDate():obj["whDate"];
			$("input[name=whDate]").val(whDate); //입고일
			$("input[name=whTitle]").val(obj["whTitle"]); //자재품명
			$("input[name=whCode]").val(obj["whCode"]); //자재코드
			$("input[name=barcode]").val(obj["barcode"]); //바코드
			$("input[name=whOrigin]").val(obj["whOrigin"]); //원산지

			$("input[name=whStaff]").val(obj["whStaff"]); //담당자
			$("input[name=whMaker]").val(obj["whMaker"]); //제조사
			$("input[name=whQty]").val(obj["whQty"]); //입/출고량
			$("input[name=whPrice]").val(obj["whPrice"]); //가격

			$("textarea[name=whMemo]").text(obj["whMemo"]); //관리자메모

			$("input[name=whEtc]").val(obj["whEtc"]); //납품처
			$("input[name=whEtccode]").val(obj["whEtccode"]); //납품코드
			$("input[name=whEtcstaff]").val(obj["whEtcstaff"]); //담당자
			$("input[name=whEtcphone1]").val(obj["whEtcphone1"]); //연락처
			$("input[name=whEtcphone2]").val(obj["whEtcphone2"]); //연락처
			$("input[name=whEtcphone3]").val(obj["whEtcphone3"]); //연락처

			$("input[name=whEtczipcode]").val(obj["whEtczipcode"]); //우편번호
			$("input[name=whEtcaddress1]").val(obj["whEtcaddress1"]); //주소1
			$("input[name=whEtcaddress2]").val(obj["whEtcaddress2"]); //주소2

			parseradiocodes("whStatusGeStockDiv", obj["whStatusGeStockList"], '<?=$txtdt["1257"]?>', "whStatus", "water-list", obj["whStatus"]); //입/출고 구분
			parseradiocodes("whCategoryGeStockDiv", obj["whCategoryGeStockList"], '<?=$txtdt["1271"]?>', "whCategory", "whCategory-list",obj["whCategory"]);

			var json = "seq="+obj["seq"];

			btnHtml='<a href="javascript:;" onclick="genstockupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
			btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
			if(!isEmpty(obj["seq"]))
				btnHtml+='<a href="javascript:;" onclick="callapidel(\'stock\',\'genstockdelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기

			$("#btnDiv").html(btnHtml);

			if(isEmpty(obj["seq"]))
				$('.selcatetd').eq(0).trigger('click');
		}
		// else if(obj["apiCode"]=="instocksearch")
		// {
		// 	if(!isEmpty(obj["seq"]))
		// 	{
		// 		if(obj["whCategory"] == 'medicine')
		// 			obj["whCategory"] = 'basic';
		//
		// 		parseradiocodes("whCategoryGeStockDiv", obj["whCategoryGeStockList"], '<?=$txtdt["1271"]?>', "whCategory", "water-list",obj["whCategory"], 'readonly');
		//
		// 		//자재코드
		// 		$('input[name=whCode]').val(obj["whCode"]);
		// 		//원산지
		// 		$("input[name=whOrigin]").val(obj["mdOrigin"]); //원산지
		// 		//제조사
		// 		$("input[name=whMaker]").val(obj["mdMaker"]); //제조사
		// 		//자재품명
		// 		$("input[name=whTitle]").val(obj["mdTitle"]); //자재품명
		// 		//입출고량
		// 		$("input[name=whQty]").val(obj["whQty"]); //입출고량
		// 		$('input[name=whQty]').attr('data-value',obj["whRemain"]).val(obj["whRemain"]).focus();
		// 		//입고일
		// 		$('input[name=whDate]').val(obj["whDate"]);
		// 	}
		// 	else
		// 	{
		// 		url = "code="+obj["whCode"];
		// 		console.log("mediboxdesc  url = " + url);
		// 		callapi("GET","inventory","mediboxdesc",url);
		// 	}
		// }
       	return false;
    }

	//------------------------------------------------------------------------------------
	// 출고의 필수데이터체크- 따로함
	//------------------------------------------------------------------------------------
	function necOut()
	{
		var chk="Y";
		var data=title="";
		$(".necOut").each(function()
		{
			title+=","+$(this).attr("title")+"/"+$(this).val()+"";
			console.log("출고시 필수값 체크 >>>>>>>>>>  this = "+$(this)+", name = " + $(this).attr("name")+", title = " + $(this).attr("title")+", val = " + $(this).val());
			if(isEmpty($(this).val()) || $(this).val() == 0)
			{
				if(data!=""){data+=",";}
				data+="-"+$(this).attr("title")+"-";
				chk="N";
			}
		});
		if(chk=="N")
		{
			var alertdata = getTxtData("NECDATA") + "(" + data + ")";//필수데이터 입력필요
			alertsign("info", alertdata, "", "2000");
			//alert(alertdata);
		}
		return chk;
	}
	callapi('GET','stock','genstockdesc','<?=$apidata?>'); 	//약재입고등록 상세 API 호출

	$("input[name=whTitle]").focus();
</script>
