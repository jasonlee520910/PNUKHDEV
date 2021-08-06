<?php //goods 원재료 입고 상세
	$root = "../..";
	include_once $root."/_common.php";
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
	//echo $apidata;
?>
<style type="text/css">
	.whCodeLeft {width:210px;float:left;margin-right:10px;}
	.whCodeRight {width:200px;float:left;}
</style>

<script>
	 $.datepicker.setDefaults({
			dateFormat: 'yy.mm.dd',
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
		//입고일 달력
		$("#whDate").datepicker();
		//유통기한 달력
		$("#whExpired").datepicker();
	})
</script>

<?php
	function selectdate()
	{
		global $txtdt;
		$carr=array("3m","6m","1y","2y","3y");
		$tarr=array($txtdt["1011"],$txtdt["1013"],$txtdt["1488"],$txtdt["1489"],$txtdt["1490"]);
		$txt="<dl class='btndiv'>";
		for($i=0;$i<count($carr);$i++){
			$txt.="<dd class='selectdate' data-value='".$carr[$i]."' onclick='javascript:selectDateClick(this)'>".$tarr[$i]."</dd> ";
		}
		$txt.="</dl>";
		return $txt;
	}
?>
<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="apiCode" class="reqdata" value="goodsstockupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Goods/GoodsMedicine.php">
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
				<th><span class="nec"><?=$txtdt["1204"]?><!-- 약재명 --></span></th>
				<td>
					<input type="hidden" name="whStock" value="" class="reqdata necdata" title="<?=$txtdt["1204"]?>">
					<!-- <input type="text" name="mdTitle" class="reqdata" title="<?=$txtdt["1204"]?>" readonly /> -->
					<span id="mdTitle"></span>
					<a href="javascript:;" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medicine" data-value="700,600">
						<button type="button" class="sp-btn"><span>+ <?=$txtdt["1204"]?><!-- 약재검색 --></span></button>
					</a>
				</td>
				<th><span class="nec"><?=$txtdt["1264"]?><!-- 입고일 --></span></th>
				<td>
					<input type="text" id="whDate" name="whDate" title="<?=$txtdt["1264"]?>" class="necdata reqdata" value=""  readonly >
					<div id="btn2Div" style="float:right;"></div>
				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1266"]?><!-- 입고품명 --></span></th>
				<td><input type="text" name="whTitle" title="<?=$txtdt["1266"]?>" class="reqdata necdata" /></td>
				<th><span class="nec"><?=$txtdt["1265"]?><!-- 입고코드 --></span></th>
				<td><div class="whCodeLeft"><input type="text" name="whCode" title="<?=$txtdt["1265"]?>" class="w200 reqdata necdata" readonly/></div><div id="bpDiv" class="whCodeRight"></div></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1237"]?><!-- 원산지 --></span></th>
				<td><input type="text" name="mdOrigin" title="<?=$txtdt["1237"]?>" readonly /></td>
				<th><span class="nec"><?=$txtdt["1288"]?><!-- 제조사 --></span></th>
				<td><input type="text" name="mdMaker" title="<?=$txtdt["1288"]?>" readonly /></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1262"]?><!-- 입고량 --></span></th>
				<td><input type="text" name="whQty" title="<?=$txtdt["1262"]?>" class="reqdata necdata" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/>g</td>
				<th><span class="nec"><?=$txtdt["1037"]?><!-- 금액 --></span></th>
				<td><input type="text" name="whPrice" title="<?=$txtdt["1037"]?>" class="reqdata necdata" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/><?=$txtdt["1235"]?><!-- 원 --></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1164"]?><!-- 상태 --></span></th>
				<td id="whStatusInStockDiv"></td>
				<th><span class="nec"><?=$txtdt["1242"]?><!-- 유통기한 --></span></th>
				<td><input  type="text" id="whExpired" name="whExpired"  title="<?=$txtdt["1242"]?>" value="" class="necdata reqdata" readonly><?=selectdate()?></td>
			</tr>
			<tr>
				<th>
					<span class="nec"><?=$txtdt["1261"]?><!-- 입고담당자 --></span>
				</th>
				<td>
					<input type="hidden" name="whStaff" value="" class="necdata reqdata" title="<?=$txtdt["1261"]?>" readonly/>
					<input type="text" name="whName" value="" title="<?=$txtdt["1261"]?>" readonly/>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1029"]?><!-- 관리자 메모 --></span>
				</th>
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
				<td><input type="text" name="whEtc" value="" class="reqdata"/></td>
				<th><span class=""><?=$txtdt["1046"]?><!-- 납품코드 --></span></th>
				<td><input type="text" name="whEtccode" value="" class="reqdata"/></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1054"]?><!-- 담당자 --></span></th>
				<td><input type="text" name="whEtcstaff" value="" class="reqdata"/></td>
				<th><span class=""><?=$txtdt["1225"]?><!-- 연락처 --></span></th>
				<td>
					<input type="hidden" name="whEtcphone" value="" class="reqdata"/>
					<input type="text" name="whEtcphone1" value="" class="w10p" maxlength="4" onchange="changePhoneNumber(event);"/>-
					<input type="text" name="whEtcphone2" value="" class="w10p" maxlength="4" onchange="changePhoneNumber(event);"/>-
					<input type="text" name="whEtcphone3" value="" class="w10p" maxlength="4" onchange="changePhoneNumber(event);"/>
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1307"]?><!-- 주소 --></span></th>
				<td colspan="3">
					<input type="hidden" class="w90p reqdata" name="whEtcaddress" value="" >
					<input type="text" title="<?=$txtdt["1233"]?>" class="w100 reqdata" name="whEtczipcode" value="">
					<a href="javascript:;" onclick="getzip('whEtczipcode', 'addr1');" class="cw-btn"><span><?=$txtdt["1232"]?><!-- 우편번호 --></span></a>
					<p class="mg5t">
						<input type="text" title="<?=$txtdt["1308"]?>" class="w40p" name="addr1" readonly/>
						<input type="text" title="<?=$txtdt["1308"]?>" class="w40p" name="addr2"/>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btn-box c" id="btnDiv">

	</div>
</div>

<!--// page end -->


<script>
	function goodsstockupdate()
	{
		
		$("input[name=whEtcaddress]").val($("input[name=addr1]").val()+"||"+$("input[name=addr2]").val());
		$("input[name=whEtcphone]").val($("input[name=whEtcphone1]").val()+"-"+$("input[name=whEtcphone1]").val()+"-"+$("input[name=whEtcphone3]").val());

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
			callapi("POST","goods","goodsstockupdate",jsondata);
			//$("#btnDiv a").eq(0).attr("onclick","alert('<?=$txtdt['1885']?>')").children("span").text("<?=$txtdt['1884']?>");
		}

	}
	function viewlayerPopup(obj)
	{
		var url=obj.getAttribute("data-bind");
		var size=obj.getAttribute("data-value");
		var data = "&page=1&psize=5&block=10"; //page,psize,block 사이즈 초기화
		console.log("=========>>>> viewlayerPopup url = " + url+", size = " + size);

		getlayer(url,size,data);
	}
	function selectDateClick(obj)
	{
		var data=obj.getAttribute("data-value");
		var tmp="";
		var d=new Date();
		switch(data){
			case "3m":d.setMonth(d.getMonth() + 3);break;
			case "6m":d.setMonth(d.getMonth() + 6);break;
			case "1y":d.setMonth(d.getMonth() + 12);break;
			case "2y":d.setMonth(d.getMonth() + 24);break;
			case "3y":d.setMonth(d.getMonth() + 36);break;
		}
		var s=d.getFullYear()+"-"+("0" +(d.getMonth() + 1)).slice(-2)+"-"+("0" +(d.getDate())).slice(-2);

		$("input[name=whExpired]").val(s);
	}


    function makepage(json)
    {
		console.log("makepage ----------------------------------------------- start")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])

		if(obj["apiCode"]=="goodsmedicinedesc") //약재입고등록
		{
			var whDate = (isEmpty(obj["whDate"])) ? getNewDate() : obj["whDate"];
			$("input[name=whDate]").val(whDate);//입고일

			var date1 = '<?=date("YmdHis")?>';
			var whCode = (!isEmpty(obj["whCode"])) ? obj["whCode"] : "STO"+date1;
			$("input[name=whCode]").val(whCode); //입고코드


			var stName=isEmpty(obj["stName"]) ? getCookie("ck_stName") : obj["stName"];
			var stUserid=isEmpty(obj["stUserid"]) ? getCookie("ck_stUserid") : obj["stUserid"];


			var whExpired = isEmpty(obj["whExpired"]) ? "" : obj["whExpired"];

			if(isEmpty(obj["whExpired"])) //약재입고 등록시 유통기한 입고일에서 1년 추가해서 기본으로 넣기
			{
				var d=new Date();
				d.setMonth(d.getMonth() + 12);
				var s=d.getFullYear()+"-"+("0" +(d.getMonth() + 1)).slice(-2)+"-"+("0" +(d.getDate())).slice(-2);
				$("input[name=whExpired]").val(s);
			}
			else
			{
				$("input[name=whExpired]").val(obj["whExpired"]);
			}

			$("input[name=whStaff]").val(stUserid); //입고담당자
			$("input[name=whName]").val(stName); //입고담당자

			parseradiocodes("whStatusInStockDiv", obj["whStatusInStockList"], '<?=$txtdt["1164"]?>', "whStatus", "medi-list", obj["whStatus"]);


			var btnHtml='';
			var json = "seq="+obj["seq"];

			btnHtml='<a href="javascript:;" onclick="goodsstockupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
			btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록

			$("#btnDiv").html(btnHtml);


			btnHtml='<a href="javascript:;" onclick="goodsstockupdate();" class="sdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기

			$("#btn2Div").html(btnHtml);


		}
		else if(obj["apiCode"] == "medicinelist") //약재리스트
		{
			var data = "";
			var capa = 0;
			$("#laymedicinetbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					capa = (isNaN(value["mdProperty"])==false) ? value["mdProperty"] : 0;
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mdCode"]+'" data-property="'+capa+'">';
					data+='<td>'+value["mdTypeName"]+'</td>';
					data+='<td>'+value["mhTitle"]+'</td>'; //본초명
					data+='<td>'+value["mmtitle"]+'</td>'; //고객 약재명(디제이메디아님)
					data+='<td>'+value["mdOrigin"]+'/'+value["mdMaker"]+'</td>';
					//data+='<td>'+capa+'</td>';
					data+='<td>'+value["mdPrice"]+' <?=$txtdt["1235"]?> </td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#laymedicinetbl tbody").html(data);

			//페이징
			$("#poptotcnt").text(obj["tcnt"]+" 건");
			getsubpage_pop("medicinelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}

        return false;
    }


	callapi('GET','goods','goodsmedicinedesc','<?=$apidata?>'); 	//약재입고등록 상세 API 호출

	$("input[name=whTitle]").focus();
</script>
