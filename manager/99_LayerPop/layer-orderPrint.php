
<?php 
	$root = "..";
	include_once $root."/_common.php";

	$odCode=$_GET["odCode"];
	$apiorderData = "odCode=".$odCode."&mDepart=making&dDepart=decoction";
?>
<input type="hidden" name="rcCode" class="reqdata" value="">
<input type="hidden" name="odKeycode" class="reqdata" value="">
<input type="hidden" name="odMatype" class="reqdata" value="">
<input type="hidden" name="maPrice" class="reqdata" value="">
<input type="hidden" name="dcPrice" class="reqdata" value="">
<input type="hidden" name="rePrice" class="reqdata" value="">
<input type="hidden" name="reBox" class="reqdata" value="">
<input type="hidden" name="reBoxmedibox" class="reqdata" value="">
<input type="hidden" name="dcTime" class="reqdata" value="">
<input type="hidden" name="watertotal" class="reqdata" value="">
<input type="hidden" name="dcShapeDesc" class="reqdata" value="">
<input type="hidden" name="odPackprice" class="reqdata" value="">
<input type="hidden" name="reBoxmediprice" class="reqdata" value="">
<input type="hidden" name="reBoxdeliprice" class="reqdata" value="">
<input type="hidden" name="odAmount" class="reqdata" value="">
<input type="hidden" name="rcSweet" class="reqdata" value="">
<input type="hidden" name="miGrade" class="reqdata" value="">
<input type="hidden" name="reZipcode" class="reqdata" value="">
<input type="hidden" name="reSendzipcode" class="reqdata" value="">
<input type="hidden" name="reZipDiv" value="">
<input type="hidden" name="reSendZipDiv" value="">
<input type="hidden" name="senderchkBtn" value="0">
<input type="hidden" name="receiverchkBtn" value="0">

<input type="hidden" name="mrDesc" class="reqdata" value="">

<input type="hidden" name="odSitecategoryDiv" value="">
<input type="hidden" name="odStatusDiv" value="">
<input type="hidden" name="odCodeDiv" value="">
<input type="hidden" name="odSeqDiv" value="">

<!-- 송장출력에 관한 -->
<input type="hidden" name="chkdelicode" value="">
<input type="hidden" name="reDeliexception" value="">
<input type="hidden" name="reDelicomp" value="">


<input type="hidden" name="reAddress" value="">
<input type="hidden" name="reSendaddress" value="">
<input type="hidden" name="chartpk" value="">
<input type="hidden" name="recieveName" value="">
<input type="hidden" name="odGoods" value="">


<input type="hidden" name="firstChk" class="reqdata" value="">



<input type="hidden" name="rcMedicine" class="reqdata" class="w90p" title="<?=$txtdt["1205"]?>" value="">

<input type="hidden" name="firstPrice" class="reqdata" value=""><!-- 선전비 -->
<input type="hidden" name="afterPrice" class="reqdata" value=""><!-- 후하비 -->
<input type="hidden" name="packPrice" class="reqdata" value=""><!-- 포장비 -->

<input type="hidden" name="dcSugar" class="reqdata" value=""><!-- 감미제 -->
<input type="hidden" name="dcSpecialPrice" class="reqdata" value=""><!-- 특수탕전비 -->
<input type="hidden" name="dcSpecialName" class="reqdata" value=""><!-- 특수탕전이름 -->



			
<textarea name="odAmountdjmedi" class="reqdata"  style="display:none;"></textarea> 
<textarea name="rcSweetData" class=""  style="display:none;"></textarea> 
<input type="hidden" name="packaddcnt" class="" value="<?=$BASE_ADDPACK?>">

<style>
	#tblop .inth {padding-left:10px;padding-right:10px;letter-spacing: -1px;}
	#td_odRequest {float:left;width:660px;height:60px;text-align: left;overflow-y:auto;}
	#td_sweetdata ul {float:left;width:240px;height:76px;text-align: left;overflow-y:auto;}
	#td_sweetdata li {width:160px;letter-spacing: -1px;}
	#td_sweetdata .sweetdel {float:right;text-align:right;cursor:pointer;}

	span.mdtype{display:inline-block;width:15px;height:15px;border-radius:50%;margin-right:5px;line-height:100%;vertical-align:middle;}
	.mdsweet{background-color:#f2C2D6;}
	.mdmedi{background-color:#8BE0ED;}
	.sugar{background-color:#01DF74;}
	.postbtn{float:right;background:#3D97BF;padding:7px 10px;border-radius:5px;color:#fff;margin:0px 0 0 10px;}
	.postok{background:blue;padding:3px 5px;border-radius:2px;color:#fff;font-size:11px;margin-right:10px;}
	.postno{background:red;padding:3px 5px;border-radius:2px;color:#fff;font-size:11px;margin-right:10px;}
	.postname{float:right;background:green;padding:3px 5px;border-radius:2px;color:#fff;font-size:12px;}
	.zip{width:50px;}
	#receiver input.address{width:50%;}
	#receiver input.address2{width:40%;}
	.twospan span{padding:0 10px 0 1px;}
	.twospan span input{width:20px;height:20px;font-size:15px;}
	
	.goodsbtn{position:absolute;background:#D35400;padding:7px 10px;border-radius:5px;color:#fff;margin:-7px 0 0 10px;right:40px;}
	.goodsok{float:right;background:blue;padding:3px 5px;border-radius:2px;color:#fff;font-size:11px;margin-right:10px;}
	.commercialbtn{position:absolute;background:#D35400;padding:7px 10px;border-radius:5px;color:#fff;margin:-7px 0 0 10px;right:40px;}
	.worthybtn{position:absolute;background:#D35400;padding:7px 10px;border-radius:5px;color:#fff;margin:-7px 0 0 10px;right:40px;}
	
	#div_goods {float:right;font-size:15px;font-weight:bold;margin-top:2px;}
	#div_goods input{width: 20px;height: 20px;}
	#div_outermaking {float:right;font-size:15px;font-weight:bold;margin-top:2px;}
	#div_outermaking input{width: 20px;height: 20px;}
	table.poptblprt tr th, table.poptblprt tr td{padding:0 7px;height:37px;}
	table.poptblprt tr td input[type=radio]{margin:0 7px 0 15px;vertical-align:middle;}

	#receiverzip {display:inline-block;height:35px;line-height:280%;}
	#wcMarkingTxt {font-size:15px;}
</style>
<!-- s: 탕제 작업지시서 출력 -->
<div class="layer-wrap2 layer-orderPrint">
	<div class="layer-top2">
		<h2 style="cursor:Pointer"><?=$txtdt["1504"]?><!-- 작업지시서출력 --></h2>
		<a href="javascript:;" class="close-btn2" onclick="orderprintclosediv()"><span class="blind"><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
	</div>
	<div class="layer-con">
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table class="poptblprt">
				<colgroup>
					<col width="11%">
					<col width="22%">
					<col width="13%">
					<col width="20%">
					<col width="13%">
					<col width="20%">
				</colgroup>
				<tbody>
					<tr>
						<th><span><?=$txtdt["1305"]?><!-- 주문코드 --></span></th>
						<td colspan="2"><span id="odChartPK"></span> <span id="td_code"></span></td>
						<!-- <th><span><?=$txtdt["1512"]?> --><!-- 처방 --><!-- </span></th> -->
						<td colspan="3"><span id="td_title" style="font-weight:bold;font-size:16px;"></span><span id="nonegoods"></span><input type="hidden" name="nonegoods" class="" value=""></td>
					</tr>
					<tr>
						<th><span><?=$txtdt["1403"]?><!-- 한의원 --></span></th>
						<td id="td_name"></td>
						<th><span>갯수<!-- <?=$txtdt["1513"]?> --><!-- 주문 --></span></th>
						<td id="td_ordercnt"></td>
						<th id="td_deli" colspan="2" class="twospan"><!-- 묶음배송<span id="td_tied"></span> -->해외배송<span id="td_oversea"></span>직배<span id="td_direct"></span><div id="tdMediTitle">첩제</div><span id="tdMedi"></span></th>
					</tr>
					<tr id="prttr1">
						<th><span><?=$txtdt["1851"]?><!-- 보내는사람 --></span></th>
						<td id="sendname"></td>
						<th><span><?=$txtdt["1100"]?><!-- 보내는사람 --></span></th>
						<td id="recename"></td>
						<th><span><?//=$txtdt["1851"]?>환자명</span></th>
						<td id="patientname"></td>
					</tr>
					<tr  id="prttr2">
						<th><span><?//=$txtdt["1851"]?>보내는주소</span></th>
						<td colspan="5" id="sender"></td>
					</tr>
					<tr  id="prttr3">
						<th><span><?//=$txtdt["1100"]?>받는주소</span></th>
						<td colspan="5" id="receiver">2,3 인 경우 - 한의원(환자명)</td>
					</tr>
					<tr  id="prttr4">
						<th><span><?//=$txtdt["1851"]?>품목선택</span></th>
						<td colspan="3"> 
						<input type="radio" name="subjectRadio" id="sub1" value="subject0" onclick="subRadioClick(this);">일반 
						<input type="radio" name="subjectRadio" id="sub2" value="subject1" onclick="subRadioClick(this);">한의원 
						<input type="radio" name="subjectRadio" id="sub3" value="subject2" onclick="subRadioClick(this);">한의원(환자명) 
						<input type="radio" name="subjectRadio" id="sub4" value="subject3" onclick="subRadioClick(this);">환자명(한의원)
						</td>
						<th><span><?//=$txtdt["1851"]?>품목</span></th>
						<td colspan="5" id="goodsNm"><!-- 0-"한약"(주문번호), 1-처방명(주문번호), 2-"한약"(주문번호), 3-"한약" --></td>
					</tr>
					<tr id="prttr5">
						<th><span>마킹</span></th>
						<td colspan="5"><ul class="" id="markingDiv"></ul><span id="td_delivery"></span></td>
					</tr>
				 </tbody>
			</table>
		 </div>

		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<div class="list-select">
				<p id="div_making" class="fl"></p>
				<p id="div_decoction" class="fl"></p>
				<p id="div_shortage" class="fl cred " style="margin-top:2px;"></p>
				<p id="div_mediboxshortage" class="fl cred " style="margin-top:2px;"></p>
				<p id="div_nonemedicine" class="fl cred " style="margin-top:2px;"></p>
				<p id="div_goodsDecoc" class="fl"></p>
				<p id="div_goods" class="fl"></p>
				<p id="div_outermaking" class="fl"><input type="checkbox" name="outermakingchk" id="outermakingchk" > 외부조제</p>
			</div>

			<table id="tblop" class="poptblprt">
				<colgroup>
					<col width="10%">

					<col width="10%">
					<col width="20%">

					<col width="10%">
					<col width="20%">

					<col width="10%">
					<col width="20%">
				</colgroup>
				<tbody>
					<tr>
						<th colspan="2" class="inth" style="height:60px;"><span><?=$txtdt["1292"]?><!-- 주문자 요청사항 --></span></th>
						<td colspan="5" id="td_odRequest"></td>
					</tr>
					<tr id="odmedi1">
						<th rowspan="2" class="inth" style="border-right:1px solid #e3e3e4;"><span><?=$txtdt["1450"]?><!-- 약재정보 --></span></th>

						<th class="inth"><span><?=$txtdt["1338"]?><!-- 총약재량 --></span></th>
					
						<td class="inth"><span class="mdtype mdmedi"></span><span id="sptotmediCapa"></span>g &nbsp;&nbsp;<span class="mdtype mdsweet"></span><span id="sptotsweetCapa"></span>g</td>


						<th rowspan="2"><?=$txtdt["1115"]?><!-- 별전 --></th>
						<td id="td_sweet" ></td>

						<td rowspan="2" colspan="2" id="td_sweetdata"></td>
					</tr>
					<tr id="odmedi2">
						<th class="inth"><span><?=$txtdt["1498"]?><!-- 약미 --></span></th>
						<td><span id="td_totMedicine" data-count=""></span><?=$txtdt['1090']?></td>
						<td id="td_sweetcnt"></td>
					</tr>
					<tr>
						<th rowspan="2" class="inth" style="border-right:1px solid #e3e3e4;"><span><?=$txtdt["1867"]?><!-- 포장정보 --></span></th>
						<th class="inth"><span><?=$txtdt["1470"]?><!-- 파우치 --></span></th>
						<td id="td_poutch"></td>
						<th class="inth"><?=$txtdt["1468"]?><!-- 한약박스 --></th>
						<td id="td_medibox"></td>
						<th class="inth"><?=$txtdt["1630"]?><!-- 배송박스 --></th>
						<td id="td_delibox"></td>
					</tr>
					<tr>						
						<th id="td_watertitle" class="inth"><?=$txtdt["1366"]?><!-- 탕전물량 --><input type="hidden" class="tc reqdata necdata" title="<?=$txtdt["1366"]?>" id="dcWater"name="dcWater" value="" /><input type="hidden" class="tc reqdata necdata" title="<?=$txtdt["1366"]?>" id="dcAlcohol"name="dcAlcohol" value="" /></th>
						<td id="td_water"><input type="hidden" id="dcSpecial" name="dcSpecial" value=""><span id="td_dcWater"></span> ml <br><span id="td_dcAlcohol"></span> <span id="td_alcoholunit">ml</span></td>
						<th class="inth"><span><?=$txtdt["1386"]?><!-- 팩용량 --></span></th>
						<td><input autocomplete="off" type="text" class="w50p tc reqdata necdata" title="<?=$txtdt["1386"]?>" id="odPackcapa"name="odPackcapa" value=""  maxlength="3" onfocus="this.select();" onchange="changeNumber(event, false);"  /> <span class="mg5"> ml</span></td>

						<th class="inth"><span><?=$txtdt["1384"]?><!-- 팩수 --></span></th>
						<td>
							<input type="hidden" class="w50p tc reqdata necdata" title="<?=$txtdt["1335"]?>" id="odChubcnt"name="odChubcnt" value=""  />
							<input type="text" class="w50p tc reqdata necdata" title="<?=$txtdt["1384"]?>" id="odPackcnt"name="odPackcnt" value=""  maxlength="4" /> <?=$txtdt["1018"]?>
						</td>
					</tr>
					<tr>
						<th rowspan="3" class="inth" style="border-right:1px solid #e3e3e4;"><span><?=$txtdt["1516"]?><!-- 주문금액 --></span></th>
						<th class="inth"><span><?=$txtdt["1606"]?><!-- 약재비 --></span></th>
						<td id="tot_meditotalprice"></td>
						<th class="inth"><span>감미제</span></th>
						<td id="tot_sugartotalprice"></td>
						<th class="inth"><?=$txtdt["1698"]?><!-- 조제비 --></th>
						<td id="tot_makingtotalprice"></td>
					</tr>
					<tr>
						<th class="inth"><?=$txtdt["1697"]?><!-- 탕전기 --></th>
						<td id="tot_decoctiontotalprice"></td>
						<th class="inth">특수탕전비</th>
						<td id="tot_specialtotalprice"></td>
						<th rowspan="2" class="inth"><?=$txtdt["1516"]?><!-- 주문금액 --></th>
						<td rowspan="2" id="td_total_price" class="cred"></td>
					</tr>
					<tr>
						<th class="inth"><span><?=$txtdt["1700"]?><!-- 포장비 --></span></th>
						<td id="tot_packingtotalprice"></td>
						<th class="inth"><?=$txtdt["1701"]?><!-- 배송비 --></th>
						<td id="tot_releasetotalprice"></td>
					</tr>
				 </tbody>
			</table>
			
			<div class="list-select">
				<p class="fl">
					
					<a id="reprintDiv" style="display:none;" href="javascript:reprint('<?=$odCode?>');"><button class="btn-blue" data-bind="" style="background:#FF8C00;border:1px solid #FF8C00;"><?//=$txtdt["1505"]?><!-- 작업일지출력 -->송장출력</span></button></a>
				</p>
				<p class="fl">
					<a id="directDiv" style="display:none;" href="javascript:directservice('<?=$odCode?>');" data-delicode="" data-delicomp="" ><button class="btn-blue" data-bind="" style="background:#CD8E26;border:1px solid #CD8E26;"><?//=$txtdt["1505"]?>직배변경</span></button></a>
				</p>
				<!-- <p class="fl">
					<a id="deliveryDiv" style="display:none;" href="javascript:changeDelivery('<?=$odCode?>');" data-delicode="" data-delicomp="" data-delicompchange="" ><button class="btn-blue" data-bind="" style="background:#B83A99;border:1px solid #B83A99;"><?//=$txtdt["1505"]?>택배변경</span></button></a>
				</p> -->
				<p class="fl">
					<a id="deliverycntDiv" style="display:none;" href="javascript:goDeliverycnt('<?=$odCode?>');" ><button class="btn-blue" data-bind="" style="background:#03BE10;border:1px solid #03BE10;"><?//=$txtdt["1505"]?>배송상품정보</span></button></a>
				</p>
				<p class="fl" id="odAdviceDiv" style="display:none;">
					<a id="" style="" href="javascript:printmanual('<?=$odCode?>');"><button class="btn-blue" data-bind="" style="background:#599704;border:1px solid #599704;"><?=$txtdt["1639"]?><!-- 복약지도서 --></span></button></a>
				</p>
				<p class="fr">
					<a href="javascript:;"><button class="btn-blue printdocument" data-bind="making"><?=$txtdt["1505"]?><!-- 작업일지출력 --></span></button></a>
					<a href="javascript:;" id="reportDiv"></a>
				</p>

				<p class="fr">
					<a href="javascript:;" id="medicationDiv"></a>
				</p>
			</div>

		</div>

		<div class="mg20t c" id="btnOPDiv">

		</div>
	</div>
</div>

<script>
	function goDeliverycnt(odCode)
	{
		var deliexception=$("input[name=reDeliexception]").val();
		var delicomp=$("#deliveryDiv").data("delicomp");
		var delicompchange=$("#deliveryDiv").data("delicompchange");
		if(isEmpty(odCode)) {alert("주문번호를 확인해 주세요.");return;}

		if(!isEmpty(deliexception)&&deliexception.indexOf("O") != -1){alert("해외배송입니다.\n배송상품정보 불가합니다.");return;}
		if(!isEmpty(deliexception)&&deliexception.indexOf("T") != -1){alert("묶음배송입니다.\n배송상품정보 불가합니다.");return;}
		if(!isEmpty(deliexception)&&deliexception.indexOf("D") != -1){alert("직배입니다.\n배송상품정보 불가합니다.");return;}		

		console.log("odCode = " + odCode);
		window.open(getUrlData("TBMS")+"marking/document.delicnt.php?odCode="+odCode+"&site=MANAGER", "proc_deli_cnt","width=800,height=500");//ok  -새창. 로딩이 걸리네.
	}
	function changegoodsDecoction()
	{
		var rccode=$("input[name=rcCode]").val();
		var gdmarking=$("#gdMarking option:selected").val();

		console.log("changegoodsDeco  rccode : " + rccode + ", gdmarking = " + gdmarking+", wcMarking = " + wcMarking);
		var url="rcCode="+rccode+"&gdMarking="+gdmarking;
		callapi('GET','order','ordergoodsdecocupdate',url);
	}
	function parseGoodsDecoction(pgid, name, list)
	{
		var str=selected="";
		str='<select id="'+name+'" name="'+name+'"  class="reqdata" style="width:310px;" onchange="changegoodsDecoction();">';
		str+='<option value=""><?=$txtdt["1172"]?></option> ';
		for(var key in list)
		{
			str+='<option value="'+list[key]["gdRecipe"]+'" '+selected+' data-qty="'+list[key]["gdQty"]+'" >'+list[key]["gdName"]+'</option> ';
		}
		str+='</select>';
		$("#"+pgid).html(str);
	}
	function goodsDecocCheck(obj)
	{
		if(obj.checked==true)
		{
			$("#wcMarking").show();
			$("#wcMarkingTxt").show();
			//$("#wcMarking").prop("disabled",true);
		}
		else
		{
			$("#wcMarking").hide();
			$("#wcMarkingTxt").hide();
			//$("#wcMarking").prop("disabled",false);
		}
	}
	function commMarkingCheck(obj)
	{
		if(obj.checked==true)
		{
			//첩제(약재포장) 비활성화 
			$("input:checkbox[id='tdMedi']").prop("disabled",true);
			$("input:checkbox[id='tdMedi']").prop("checked",false);
		}
		else
		{
			//첩제(약재포장) 비활성화 
			$("input:checkbox[id='tdMedi']").prop("disabled",false);
			$("input:checkbox[id='tdMedi']").prop("checked",false);
		}

		var rccode=$("input[name=rcCode]").val();
		var wcMarking=$("input:checkbox[id='wcMarking']").is(":checked");//실속,상비,탕제 

		console.log("commMarkingCheck  rccode : " + rccode +", wcMarking = " + wcMarking);
		var url="rcCode="+rccode+"&wcMarking="+wcMarking;
		callapi('GET','order','ordergoodscommercialupdate',url);
		//ordergoodsdecocupdate
	}
	function gdMarkingCheck(obj, type)
	{
		console.log("gdMarkingCheck  checked = " + obj.checked +", type = " + type);

		var wcMarking=$("input:checkbox[id='wcMarking']").is(":checked");//실속,상비,탕제 

		if(obj.checked==true)
		{
			$("#div_goodsDecoc").show();
			$("#goodsDecoction").prop("disabled",true);
			$("#goodsDecoction").prop("checked",false);
			//첩제(약재포장) 비활성화 
			$("input:checkbox[id='tdMedi']").prop("disabled",true);
			$("input:checkbox[id='tdMedi']").prop("checked",false);

			$("#nonegoods").hide();
			$("input[name=nonegoods]").val(2);
		}
		else
		{
			$("#nonegoods").show();
			$("input[name=nonegoods]").val(0);

			//첩제(약재포장) 비활성화 
			$("input:checkbox[id='tdMedi']").prop("disabled",false);
			$("input:checkbox[id='tdMedi']").prop("checked",false);

			if(type=="decoction")
			{				
				$("#goodsDecoction").prop("checked",true);
			}
			else
			{
				$("#goodsDecoction").prop("checked",false);
			}
			$("#goodsDecoction").prop("disabled",false);	

			$("#gdMarking option:eq(0)").prop("selected",true);
			$("#div_goodsDecoc").hide();

			if(type=="nonegoods_decoction")
			{
				$("#wcMarking").show();
				$("#wcMarkingTxt").show();
			}
			else
			{
				var goods=$("input:checkbox[id='goodsDecoction']").is(":checked");
				if(goods==true)
				{
					$("#wcMarking").show();
					$("#wcMarkingTxt").show();
				}
				else
				{
					$("#wcMarking").hide();
					$("#wcMarkingTxt").hide();
				}
			}

			changegoodsDecoction();
		}		
	}
	//------------------------------------------------------------------------------------
	//마킹함수
	//------------------------------------------------------------------------------------
	function parsemarkingcodes(pgid, list, title, name, type, data, readonly)
	{
		var radiostr = idstr = checked = disable = display="";
		var i = 0;
		var gibon=select="";

		disable = (readonly == 'readonly') ? "disabled='disabled'" : "";

		var odPackCode=$("#odPackType option:selected").data("codeonly");
		console.log("마킹 parsemarkingcodes odPackCode =  " + odPackCode+", data = " + data);

		if(!isEmpty(odPackCode))
		{
			var code=odPackCode.split(",");
			var choice;
			gibon=data;
			if(!isEmpty(code))
			{
				$(code).each(function( index, value )
				{
					choice=value.split("|");
					if(choice[1]=="Y")
					{
						gibon=choice[0];
					}
				});

			}
		}
		else
		{
			if(!isEmpty(data))
			{
				gibon=data;
			}
		}

		console.log("마킹 parsemarkingcodes gibon=" + gibon+",data=" + data);

		for(var key in list)
		{
			idstr = "0" + i;
			idstr = idstr.slice(-2);
			checked = "";
			if(!isEmpty(odPackCode))
			{
				display="display:none;";
			}
			else
			{
				display="display:block;";
			}
			if(!isEmpty(odPackCode) && odPackCode.indexOf(list[key]["cdCode"]) != -1)
			{
				display="display:block;";
			}

			if(!isEmpty(data))
			{
				if(data==gibon && data == list[key]["cdCode"])
					checked = ' checked="checked"';

				if(data!=gibon && gibon == list[key]["cdCode"])
					checked = ' checked="checked"';
			}


			radiostr += '<li id="mr_'+idstr+'" style="float:left;'+display+'" onclick="markingupdate(\''+list[key]["cdCode"]+'\')" data-code="'+list[key]["cdCode"]+'">';
			radiostr += '	<p class="radio-box">';
			radiostr += '		<input type="radio"  name="'+name+'" class="radiodata" id="marking-'+list[key]["cdCode"]+'" value="'+list[key]["cdCode"]+'" '+checked+' '+disable+'>';
			radiostr += '		<label for="marking-'+list[key]["cdCode"]+'">'+list[key]["cdDesc"]+'</label>';
			radiostr += '	</p>';
			radiostr += '</li>';

			i++;

		}

		$("#"+pgid).html(radiostr);
	}


	function markingupdate(cdCode)
	{
		var keycode=$("input[name=odKeycode]").val();
		var apidata="keycode="+keycode+"&cdCode="+cdCode;
		$("input[name=mrDesc]").val(cdCode);
		console.log("markingupdate apidata     : "+apidata);
		callapi('GET','order','ordermarkingupdate',apidata);
	}
	function subRadioClick(obj)
	{
		var type=$('input:radio[name="subjectRadio"]:checked').val();		
		var keycode=$("input[name=odKeycode]").val();
		var odGoods=$("input[name=odGoods]").val();
		odGoods=!isEmpty(odGoods) ? odGoods:"N";

		if(odGoods=="G") {return;}

		console.log("subRadioClick  type = " + type+", keycode = " + keycode + ",  odGoods = " + odGoods);
		//받는사람이름
		var reName=$("#recename").text();
		//환자명
		var odName=$("#patientname").text();
		//한의원이름 
		var miName=$("#td_name").text();
		//처방명 
		var td_title=$("#td_title").text();

		//처방전PK 
		var chartpk=$("input[name=chartpk]").val();
		//받는사람 
		var recieveName=$("input[name=recieveName]").val();
		recieveName=(!isEmpty(recieveName)) ? recieveName : reName;

		//새로운 받는사람 
		var newReName=reName;
		//품목
		var odSubject="";

		//0-"한약"(주문번호), 1-처방명(주문번호), 2-"한약"(주문번호), 3-"한약"
		if(type=="subject3") 
		{
			//3환자명(한의원)
			//받는사람 : 한의원(환자명) 표시
			newReName=miName+"("+odName+")";
			//3-"한약"
			odSubject="한약";
		}
		else if(type=="subject2")
		{
			//2한의원(환자명) 
			//받는사람 : 한의원(환자명) 표시
			newReName=miName+"("+odName+")";
			//2-"한약"(주문번호)
			odSubject="한약("+chartpk+")";
		}
		else if(type=="subject1")
		{
			//1한의원 
			//받는사람 
			newReName=recieveName;
			//1-처방명(주문번호)
			odSubject=td_title+"("+chartpk+")";
		}
		else
		{
			//0일반 
			//받는사람 
			newReName=recieveName;
			//0-"한약"(주문번호)
			odSubject="한약("+chartpk+")";
		}

		console.log("newReName = " + newReName+", odSubject = " + odSubject);

		$("#goodsNm").text(odSubject);
		$("#recename").text(newReName);


		
		var apidata="keycode="+keycode+"&odSubject="+odSubject+"&newReName="+newReName+"&odSubjectType="+type;
		console.log("apidata     : "+apidata);
		callapi('GET','order','ordersubjectupdate',encodeURI(apidata));


	}
	function orderprintclosediv()
	{
		//주문리스트 API 호출
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		var apiOrderData="";
		//searchTxt=1&searchStatus=
		var search=hdata[2];
		if(page==undefined){
			page=1;
		}

		if(search==undefined || search==""){
			var searchTxt="";
		}else{
			var sarr=search.split("&");
			if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
			if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
			if(sarr[2]!=undefined)var sarr3=sarr[2].split("=");
			if(sarr[3]!=undefined)var sarr4=sarr[3].split("=");
			if(sarr[4]!=undefined)var sarr5=sarr[4].split("=");
			if(sarr[5]!=undefined)var sarr6=sarr[5].split("=");
			if(sarr[6]!=undefined)var sarr7=sarr[6].split("=");
			if(sarr1[1]!=undefined)var sdate=sarr1[1];
			if(sarr2[1]!=undefined)var edate=sarr2[1];
			if(sarr3[1]!=undefined)var searchTxt=sarr3[1];
			if(sarr4[1]!=undefined)var searchStatus=sarr4[1];
			if(sarr5[1]!=undefined)var searchProgress=sarr5[1];
			if(sarr6[1]!=undefined)var searchPeriodEtc=sarr6[1];
			if(sarr7[1]!=undefined)var searchMatype=sarr7[1];

			
			//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
			$("input[name=sdate]").val(sdate);
			$("input[name=edate]").val(edate);
			$("input[name=searchTxt]").val(decodeURI(searchTxt));
			//searPeriodEtc
			//------------------------------------------------------
			//상태 체크박스 
			//------------------------------------------------------
			var starr=searchStatus.split(",");
			for(var i=0;i<starr.length;i++){
				if(starr[i]!=""){
					$(".searchStatus"+starr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------

			//------------------------------------------------------
			//진행 체크박스 
			//------------------------------------------------------
			var ptarr=searchProgress.split(",");
			for(var i=0;i<ptarr.length;i++){
				if(ptarr[i]!=""){
					$(".searchProgress"+ptarr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------

			//------------------------------------------------------
			//조제타입별 체크박스 
			//------------------------------------------------------
			var mtarr=searchMatype.split(",");
			for(var i=0;i<mtarr.length;i++){
				if(mtarr[i]!=""){
					$(".searchMatype"+mtarr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------
			
			//------------------------------------------------------
			//기간선택 라디오박스 
			//------------------------------------------------------
			var pearr=searchPeriodEtc.split(",");
			for(var i=0;i<pearr.length;i++){
				if(pearr[i]!=""){
					$(".searPeriodEtc"+pearr[i]).attr("checked",true);
				}
			}
			//------------------------------------------------------

			apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+encodeURI(searchTxt)+"&searchStatus="+searchStatus+"&searchProgress="+searchProgress+"&searchMatype="+searchMatype;
		}

		var apidata="page="+page+apiOrderData;
		console.log("apidata     : "+apidata);
		callapi('GET','order','orderlist',apidata);

		closediv('viewlayer');
	}
	//복약지시서 출력
	function printmanual(odcode)
	{
		console.log("odcode   >>> "+odcode);
		var url=getUrlData("TBMS")+"release/document.advice.php?code="+odcode;
		window.open(url, "printmanual", "width=900,height=1000");
	}

	function qareport(odcode){
		var url=getUrlData("TBMS")+"release/document.report.php?code="+odcode;
		console.log("url   >>  "+url);
		window.open(url, "qareport", "width=900,height=1000");
	}

	function qareport2()
	{
		var url=getUrlData("TBMS")+"report/?key=DjU/AboDp6lYpUM9eI0Z/HoMAseTSWK5pje/B/LHTbA=";
		console.log("url   >>  "+url);
		window.open(url, "qareport2", "width=900,height=1000");
	}

	function medicationreport(odcode)
	{
		//alert(odcode);
		var url=getUrlData("TBMS")+"release/document.medicationreport.php?code="+odcode;
		console.log("url   >>  "+url);
		window.open(url, "qareport", "width=900,height=1000");
	}

	function reprint(odcode)
	{
		var type="POST";
		var deliexception=$("input[name=reDeliexception]").val();
		var delicomp=$("input[name=reDelicomp]").val();
		window.open(getUrlData("TBMS")+"marking/document.deliprint.php?odCode="+odcode+"&type="+type+"&deliexception="+deliexception+"&delicomp="+delicomp+"&site=MANAGER", "proc_report_deli","width=800,height=500");//ok  -새창. 로딩이 걸리네.
	}
	//택배변경 
	/*
	function changeDelivery(odcode)
	{
		var deliexception=$("input[name=reDeliexception]").val();
		var delicode=$("#deliveryDiv").data("delicode");
		var delicomp=$("#deliveryDiv").data("delicomp");
		var delicompchange=$("#deliveryDiv").data("delicompchange");
		if(isEmpty(odcode)) {alert("주문번호를 확인해 주세요.");return;}

		if(!isEmpty(deliexception)&&deliexception.indexOf("O") != -1){alert("해외배송입니다.\n택배변경이 불가합니다.");return;}
		if(!isEmpty(deliexception)&&deliexception.indexOf("T") != -1){alert("묶음배송입니다.\n택배변경이 불가합니다.");return;}
		if(!isEmpty(deliexception)&&deliexception.indexOf("D") != -1){alert("직배입니다.\n택배변경이 불가합니다.");return;}		
		if(!isEmpty(delicode)) {alert("배송리스트에서 송장을 먼저 취소해 주세요.");return;}

		var deliCompName=deliCompChangeName="";
		if(delicomp.toUpperCase()=="LOGEN")
		{
			deliCompName="로젠";
		}
		else if(delicomp.toUpperCase()=="POST")
		{
			deliCompName="우체국";
		}

		if(delicompchange.toUpperCase()=="LOGEN")
		{
			deliCompChangeName="로젠";
		}
		else if(delicompchange.toUpperCase()=="POST")
		{
			deliCompChangeName="우체국";
		}
	
		if(confirm(deliCompName+"택배에서 "+deliCompChangeName+"택배로 변경하시겠습니까?"))
		{
			var url="odcode="+odcode+"&delicompchange="+delicompchange;
			callapi('GET','order','deliverychangeupdate',url);
		}
	}
	*/
	function directservice(odcode)
	{
		var delicode=$("#directDiv").data("delicode");
		var delicomp=$("#directDiv").data("delicomp");
		var delimsg="";
		if(isEmpty(odcode)) {alert("주문번호를 확인해 주세요.");return;}
		if(!isEmpty(delicode)) {alert("배송리스트에서 송장을 먼저 취소해 주세요.");return;}
		
		delimsg=delicomp+"에서 직배로 변경하시겠습니까?";
		if(confirm(delimsg))
		{
			var url="odcode="+odcode;
			callapi('GET','order','deliverydirectupdate',url);
		}
	}
	function setOrderGoodsMedi(){
		var tdmedi=$("input:checkbox[id='tdMedi']").is(":checked");//약재 체크 
		var odcode=$("#td_code").text();

		//사전조제재고 비활성화 
		$("input:checkbox[id='wcMarking']").prop("disabled",true);
		$("input:checkbox[id='wcMarking']").prop("checked",false);

		console.log("tdmedi="+tdmedi+", odcode="+odcode);
		var data="odcode="+odcode+"&odGoods="+tdmedi;
		callapi('GET','order','setordergoods',data);
	}
	function setDeliexception(){
		var reException="";
		$(".twospan span input").each(function(){
			if($(this).prop("checked")==true){
				reException+=","+$(this).val();
			}
		});
		var odcode=$("#td_code").text();
		var data="odcode="+odcode+"&delitype="+reException;
		callapi('GET','order','setdeliexception',data);
	}

	$(".printdocument").on("click",function(e)
	{
		var type=$(this).attr("data-bind");
		var code="<?=$odCode?>";
		var chk=code.length;
		var matype=$("input[name=odMatype]").val();
		var goods=$("input:checkbox[id='goodsDecoction']").is(":checked");
		var wcMarking=$("input:checkbox[id='wcMarking']").is(":checked");//실속,상비,탕제 
		console.log("printdocument  type = " + type+", code = " + code + ", matype = "+matype+", goods = " + goods+", wcMarking = " + wcMarking);
		if(chk=="22")
		{
			alertsign("warning", "<?=$txtdt['1594']?>", "", "2000");//작업등록을 먼저해야 합니다.
		}
		else
		{
			if(matype=="goods"&&goods==false&&wcMarking==false)
			{
				printdocument("goods",code,900);
			}
			else
			{
				printdocument(type,code,900);
			}
		}

	});

	$(".printreport").on("click",function(e){
		var proc=$(this).attr("data-bind");
		var code="<?=$odCode?>";
		var h=900;
		var page="document."+proc;
		window.open("<?=$root?>/99_LayerPop/"+page+".php?code="+code,"proc_"+proc,"width=800,height="+h);
	});

	function chnworker(code,depart)
	{
		var staff=$("select[name="+code+"_"+depart+"]").val();
		console.log("chnworker  code = "+code+", depart = "+depart+", staff = " + staff);
		var url = "odCode="+code+"&depart="+depart+"&stStaffid="+staff;
		callapi('GET','member','workerchange',url);
	}
	//작업등록
	function orderconfirm(seq)
	{
		$("#confirmid").removeAttr("onclick");
		$("#confirmid span").text("작업등록중...");

		var outermakingchk=$("input:checkbox[id='outermakingchk']").is(":checked");//외부조제체크 
		
		var nonemedi = $("#div_nonemedicine").attr("data-check");
		var mediboxshortage = $("#div_mediboxshortage").text();
		var mbshortageName = $("#div_mediboxshortage").attr("data-value");
		var reZipcode=$("input[name=reZipcode]").val();
		var matype=$("input[name=odMatype]").val();
		var goods=$("input:checkbox[id='goodsDecoction']").is(":checked");//약속
		var wcMarking=$("input:checkbox[id='wcMarking']").is(":checked");//실속,상비,탕제 
		var gdmarking=$("#gdMarking option:selected").val();
		var goodsok=$(".goodsok").length;
		var markingchk=$("input:radio[name='mrDesc']").is(":checked");

		console.log("matype = "+matype+", wcMarking = "+wcMarking+", gdmarking = " + gdmarking+", goodsok = "+goodsok+", markingchk = " + markingchk);
		
		var url="seq="+seq+"&returnData=";
		if(matype=="goods" && goods==false)
		{
			url+="&goods=goods";
		}
		else if(matype=="goods" && goods==true)
		{
			url+="&goods=goodsdecoction";
		}
		else if(matype=="commercial")
		{
			url+="&goods=commercial";
		}
		else if(matype=="worthy")
		{
			url+="&goods=worthy";
		}
		
		if((matype=="goods" && wcMarking==true) || (matype=="decoction" && wcMarking==true) || (matype=="commercial" && wcMarking==true) || (matype=="worthy" && wcMarking==true))//
		{
			url+="&wcMarking=marking";
		}

		if(!isEmpty(gdmarking))
		{
			url+="&gdmarking="+gdmarking;
		}
		//외부조제 인경우 
		if(outermakingchk==true)
		{
			url+="&outermakingchk=Y";
		}


		var tdOversea=$("input:checkbox[id='tdOversea']").is(":checked");//해외배송 
		console.log("tdOversea = " + tdOversea);

		//파우치		
		var chkPacktype=$("#odPackType option:selected").val();
		//한약박스
		var chkboxmeditype=$("#reBoxmedi option:selected").val();
		//배송박스 
		var reBoxdelitype=$("#reBoxdeli option:selected").val();
		
		var odGoods=$("input[name=odGoods]").val();

		console.log("odGoods = " + odGoods+", reBoxdelitype = " + reBoxdelitype+", url = " + url);

		if(!isEmpty(odGoods)&&odGoods=="G")//사전조제
		{
			url+="&odGoods=G";

			if(isEmpty(chkPacktype))
			{
				alertsign('error',"파우치를 선택해 주세요.",'','2000');
				$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
				$("#confirmid span").text("작업등록");
			}
			else if(isEmpty(chkboxmeditype))
			{
				alertsign('error',"한약박스 선택해 주세요.",'','2000');
				$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
				$("#confirmid span").text("작업등록");
			}
			else if(!isEmpty(nonemedi) && nonemedi=="true")//등록된 약재가 없을 경우 
			{
				alertsign('error',"<?=$txtdt['1835']?>",'','2000');
				$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
				$("#confirmid span").text("작업등록");
			}
			else if(!isEmpty(mediboxshortage))//약재함이 없을 경우 
			{
				alertsign("error", "<?=$txtdt['1752']?>("+mbshortageName+")", "", "3000");//약재함을 먼저 등록해 주세요.
				$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
				$("#confirmid span").text("작업등록");
			}
			else
			{
				callapi('GET','order','orderconfirm',url);
			}
		}
		else
		{
			if(!isEmpty(odGoods)&&odGoods=="M")//첩제(약재포장) 
			{
				url+="&odGoods=M";
			}

			//미등록상품 : matype=goods, wcMarking=false, gdmarking=, goods = true
			//등록된상품 : 
			//사전조제 : matype=goods, wcMarking=false, gdmarking=RC20191031110002, goods = true
			if(tdOversea==false && isEmpty(reZipcode))
			{
				alertsign('error',"받는사람 우편번호를 등록해 주세요.",'','2000');
				$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
				$("#confirmid span").text("작업등록");
			}
			else if(markingchk==false)
			{
				alertsign('error',"마킹을 선택해 주세요.",'','2000');
				$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
				$("#confirmid span").text("작업등록");
			}
			else
			{
				console.log("matype="+matype+", wcMarking="+wcMarking+", gdmarking="+gdmarking+", goods = " + goods);

				if((matype=="decoction" && wcMarking==false) || (matype=="worthy" && wcMarking==false))
				{
					if(isEmpty(chkPacktype))
					{
						alertsign('error',"파우치를 선택해 주세요.",'','2000');
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}
					else if(isEmpty(chkboxmeditype))
					{
						alertsign('error',"한약박스 선택해 주세요.",'','2000');
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}
					else if(!isEmpty(nonemedi) && nonemedi=="true")//등록된 약재가 없을 경우 
					{
						alertsign('error',"<?=$txtdt['1835']?>",'','2000');
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}
					else if(!isEmpty(mediboxshortage))//약재함이 없을 경우 
					{
						alertsign("error", "<?=$txtdt['1752']?>("+mbshortageName+")", "", "3000");//약재함을 먼저 등록해 주세요.
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}	
					else 
					{
						callapi('GET','order','orderconfirm',url);
					}
				}
				else if ((matype=="goods" && goods==true && goodsok > 0) || (matype=="commercial" && wcMarking==false) )
				{
					callapi('GET','order','orderconfirm',url);
				}
				else if (matype=="goods" && goods==false && goodsok ==0)
				{
					alertsign('error',"매칭된 상품이 없습니다.",'','2000');
					$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
					$("#confirmid span").text("작업등록");
				}
				else
				{
					var gdmarkingQty=$("#gdMarking option:selected").data("qty");
					gdmarkingQty=isEmpty(gdmarkingQty) ? "0":gdmarkingQty;

					if((matype=="decoction" && wcMarking==true && isEmpty(gdmarking)) || (matype=="goods" && wcMarking==true && isEmpty(gdmarking))) 
					{
						alertsign('error',"사전조제 목록을 선택해 주세요.",'','2000');
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}
					else if (matype=="goods" && goods==false && goodsok>0&&reBoxdelitype=="RBD190710182024")//포장박스없음이라면 
					{
						alertsign('error',"배송박스를 선택해 주세요.",'','2000');
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}
					else if(matype=="goods" && goods==true && goodsok == 0)
					{
						alertsign('error',"매칭된 상품이 없습니다.",'','2000');
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}
					/*else if(matype=="decoction" && wcMarking==true && parseInt(gdmarkingQty)<=0) //20191214 : 잠시 보류 
					{
						alertsign('error',"선택하신 사전조제의 재고가 없습니다.",'','2000');
						$("#confirmid").attr("onclick", "orderconfirm('"+seq+"')");
						$("#confirmid span").text("작업등록");
					}*/
					else
					{
						callapi('GET','order','orderconfirm',url);
					}
				}

			}
		}
	}
	//작업지시
	function orderchange(seq)
	{
		var outermakingchk=$("input:checkbox[id='outermakingchk']").is(":checked");//외부조제체크 

		console.log("bbbbb  orderchange url: " + url);
		var posion = $("#td_totPoison").text();
		var dismatch = $("#td_totDismatch").text();
		var shortage = $("#div_shortage").text();
		var mediboxshortage = $("#div_mediboxshortage").text();
		var mbshortageName = $("#div_mediboxshortage").attr("data-value");
		var data = text = goodsdata = "";
		var goods=$("input:checkbox[id='goodsDecoction']").is(":checked");//약속 
		var wcMarking=$("input:checkbox[id='wcMarking']").is(":checked");//실속,상비,탕제 
		var matype=$("input[name=odMatype]").val();
		var tdMedi=$("input:checkbox[id='tdMedi']").is(":checked");//첩제(약재포장) 

		console.log("matype = "+matype+", goods = " + goods+", wcMarking = " + wcMarking);

		//파우치		
		var chkPacktype=$("#odPackType option:selected").val();
		//한약박스
		var chkboxmeditype=$("#reBoxmedi option:selected").val();
		

		if(matype=="goods" && goods==false && wcMarking==false)
		{
			url="seq="+seq+"&process=order&status=goods_apply&goods=goods&returnData=";
		}
		else if((matype=="goods" && wcMarking==true) || (matype=="decoction" && wcMarking==true) || (matype=="commercial" && wcMarking==true) || (matype=="worthy" && wcMarking==true))
		{
			url="seq="+seq+"&process=order&status=marking_apply&wcMarking=marking&returnData=";

			if(isEmpty(chkPacktype))
			{
				alertsign('error',"파우치를 선택해 주세요.",'','2000');
				return false;
			}
			else if(isEmpty(chkboxmeditype))
			{
				alertsign('error',"한약박스 선택해 주세요.",'','2000');
				return false;
			}
		}
		else
		{
			url="seq="+seq+"&process=order&status=making_apply&returnData=";

			if(isEmpty(chkPacktype))
			{
				alertsign('error',"파우치를 선택해 주세요.",'','2000');
				return false;
			}
			else if(isEmpty(chkboxmeditype))
			{
				alertsign('error',"한약박스 선택해 주세요.",'','2000');
				return false;
			}
		}

		if(outermakingchk==true)
		{
			url+="&outermakingchk=Y";
		}

		console.log("goods = " + goods+", matype = " + matype+", posion = " + posion+", dismatch = " + dismatch+", shortage = " + shortage);

		if(!isEmpty(mediboxshortage))
		{
			alertsign("error", "<?=$txtdt['1752']?>("+mbshortageName+")", "", "3000");//약재함을 먼저 등록해 주세요.
		}
		else
		{
			data=goodsdata="";
			if(matype=="goods")
			{
				if(wcMarking==true)
				{
					goodsdata="[약속처방 재고]\n";
				}
				else
				{
					if(goods==false)
					{
						goodsdata="[약속처방]\n";
					}
					else
					{
						goodsdata="[약속처방 탕전]\n";
					}
				}
			}
			else if(matype=="commercial")//상비 
			{
				if(wcMarking==true)
				{
					goodsdata="[상비처방 재고]\n";
				}
				else if(tdMedi==true)
				{
					goodsdata="[상비 첩제]\n";
				}
				else
				{
					goodsdata="[상비처방]\n";
				}
			}
			else if(matype=="worthy")//실속
			{
				if(wcMarking==true)
				{
					goodsdata="[실속처방 재고]\n";
				}
				else
				{
					goodsdata="[실속처방]\n";
				}
			}
			else if(matype=="decoction")//탕제 
			{
				if(wcMarking==true)
				{
					goodsdata="[탕제처방 재고]\n";
				}
				else
				{
					if(tdMedi==true)
					{
						goodsdata="[탕제 첩제]\n";
					}
					else
					{
						goodsdata="[탕제처방]\n";
					}
				}
			}

			if(!isEmpty(posion) && posion != "0")
			{
				data+="<?=$txtdt['1064']?>"; //독성
			}
			if(!isEmpty(dismatch) && dismatch != "0")
			{
				data+=(!isEmpty(data)) ? ",":"";
				data+="<?=$txtdt['1158']?>"; //상극
			}
			if(!isEmpty(shortage))
			{
				data+=(!isEmpty(data)) ? ",":"";
				data+="<?=$txtdt['1245']?>"; //약재부족
			}

			if(!isEmpty(data))
			{
				data+="이 있습니다.\n";
			}
			
			
			text = goodsdata+data+"<?=$txtdt['1421']?>";//작업지시를 하시겠습니까?

			if(confirm(text)) //작업지시를 하시겠습니까?
			{
				callapi('GET','order','orderchange', url);
				viewpage();
			}
			
		}
	}

	//파우치,한약박스,배송포장 선택시
	function changepackcodeprint()
	{
		var odPackprice=odPackcapa=reBoxmediprice=reBoxdeliprice=0;
		var odPackCode="";

		var type = $("input[name=odMatype]").val();
		var miGrade=$("input[name=miGrade]").val();
		miGrade=chkGrade(miGrade);
		miGrade=miGrade.toLowerCase();

		reBoxmediprice=$("#reBoxmedi option:selected").data("price"+miGrade);
		reBoxdeliprice=$("#reBoxdeli option:selected").data("price"+miGrade);

		$("input[name=reBoxmediprice]").val(reBoxmediprice);//reBoxmediprice
		$("input[name=reBoxdeliprice]").val(reBoxdeliprice);//reBoxdeliprice

		console.log("changepackcodeprint reBoxmediprice = " + reBoxmediprice + ", reBoxdeliprice = " + reBoxdeliprice);

		resetamountprint();

	}
	//파우치 선택시
	function changepacktype()
	{
		var odPackprice=odPackcapa=reBoxmediprice=reBoxdeliprice=i=j=0;
		var odPackCode=idstr="";

		console.log("파우치 선택시 ");

		var type = $("input[name=odMatype]").val();
		var miGrade=$("input[name=miGrade]").val();
		miGrade=chkGrade(miGrade);
		miGrade=miGrade.toLowerCase();

		odPackprice=$("#odPackType option:selected").data("price"+miGrade);
		odPackCode=$("#odPackType option:selected").data("codeonly");

		$("input[name=odPackprice]").val(odPackprice);//odPackprice

		if(!isEmpty(odPackCode))
		{
			var len=$("#markingDiv li").length;

			//marking07|Y,marking05|N,marking03|N
			var carr=odPackCode.split(",");
			var markingcode="";

			for(i=0;i<len;i++)
			{
				idstr = "0" + i;
				idstr = idstr.slice(-2);
				var code=$("#mr_"+idstr).data("code");
				$("#mr_"+idstr).css("display","none");
				for(j=0;j<carr.length;j++)
				{
					var carr2=carr[j].split("|");
					if(code==carr2[0])
					{
						$("#mr_"+idstr).css("display","block");
						if(carr2[1]=="Y")
						{
							markingcode=carr2[0];
							$("#marking-"+carr2[0]).prop("checked", true);
						}
					}
				}
			}
			markingupdate(markingcode);
		}

		console.log("changepacktype  len = "+len+", odPackCode = "+odPackCode+", odPackprice = " + odPackprice+", reBoxmediprice = " + reBoxmediprice + ", reBoxdeliprice = " + reBoxdeliprice);

		resetamountprint();
	}
	//select box 
	function parsePackSelectBox(pgid, name, list, data, mrList, readonly)
	{
		var str=selected=opprice=opcode="";

		str='<select id="'+name+'" name="'+name+'"  class="packselect reqdata" style="width: 130px;" onchange="changepacktype();" '+readonly+'>';
		str+='<option value=""><?=$txtdt["1172"]?></option> ';
		for(var key in list)
		{
			selected="";
			opcode=" data-codeonly="+list[key]["pbCodeOnly"];
			opprice=" data-priceA="+list[key]["pbPriceA"]+" data-priceB="+list[key]["pbPriceB"]+" data-priceC="+list[key]["pbPriceC"]+" data-priceD="+list[key]["pbPriceD"]+" data-priceE="+list[key]["pbPriceE"];

			if(name=="dcSugar")
			{
				if(list[key]["mdCode"]==data)
				{
					selected='selected="selected"';
				}

				str+='<option value="'+list[key]["mdCode"]+'" '+selected+' data-capa="'+list[key]["pbCapa"]+'"  data-usage="'+list[key]["mdUsage"]+'" '+opprice+' '+opcode+'>'+list[key]["mdTitle"]+'</option> ';
			}
			else
			{
				if(list[key]["pbCode"]==data)
				{
					selected='selected="selected"';
				}

				str+='<option value="'+list[key]["pbCode"]+'" '+selected+' data-capa="'+list[key]["pbCapa"]+'"  '+opprice+' '+opcode+' >'+list[key]["pbTitle"]+'</option> ';
			}

		}
		str+='</select>';
		$("#"+pgid).html(str);
	}
	//select box 
	function parseSelectBox(pgid, name, list, data, readonly)
	{
		var str=selected=opprice=opvolcnt="";

		str='<select id="'+name+'" name="'+name+'"  class="reqdata" style="width: 130px;" onchange="changepackcodeprint();" '+readonly+'>';
		if(name!="reBoxdeli")
		{
			str+='<option value=""><?=$txtdt["1172"]?></option> ';
		}
		for(var key in list)
		{
			selected="";
			opvolcnt=" data-volcnt="+list[key]["pbVolume"]+"|"+list[key]["pbMaxcnt"];
			opprice=" data-priceA="+list[key]["pbPriceA"]+" data-priceB="+list[key]["pbPriceB"]+" data-priceC="+list[key]["pbPriceC"]+" data-priceD="+list[key]["pbPriceD"]+" data-priceE="+list[key]["pbPriceE"];

			if(name=="dcSugar")
			{
				if(list[key]["mdCode"]==data)
				{
					selected='selected="selected"';
				}

				str+='<option value="'+list[key]["mdCode"]+'" '+selected+' data-capa="'+list[key]["pbCapa"]+'"  data-usage="'+list[key]["mdUsage"]+'" '+opvolcnt+' '+opprice+' >'+list[key]["mdTitle"]+'</option> ';
			}
			else
			{
				if(list[key]["pbCode"]==data)
				{
					selected='selected="selected"';
				}

				str+='<option value="'+list[key]["pbCode"]+'" '+selected+' data-capa="'+list[key]["pbCapa"]+'" '+opvolcnt+' '+opprice+' >'+list[key]["pbTitle"]+'</option> ';
			}

		}
		str+='</select>';
		$("#"+pgid).html(str);
	}

	//별전 
	function parseSweetBox(pgid, name, list, data, readonly)
	{
		var str=selected=opprice="";

		str='<select id="'+name+'" name="'+name+'" style="width: 130px;" class="" onchange="sweetChange();" '+readonly+'>';
		str+='<option value=""><?=$txtdt["1172"]?></option> ';
		
		for(var key in list)
		{
			selected="";
			//20190918 : 별전에 가격추가 
			opprice=" data-priceA="+list[key]["rcPriceA"]+" data-priceB="+list[key]["rcPriceB"]+" data-priceC="+list[key]["rcPriceC"]+" data-priceD="+list[key]["rcPriceD"]+" data-priceE="+list[key]["rcPriceE"];

			str+='<option value="'+list[key]["rcMedicode"]+'" '+opprice+'  data-title="'+list[key]["rcMedititle"]+'" data-water="'+list[key]["rcWater"]+'" '+selected+'>'+list[key]["rcMedititle"]+'</option> ';
		}
		str+='</select>';

		$("#"+pgid).html(str);

		str='<input type="text" class="w90" id="sweetcnt" name="sweetcnt" value="" onchange="sweetChangeCnt();" >g';
		/*str+='<select id="sweetcnt" name="sweetcnt" style="width: 130px;" onchange="sweetChangeCnt();" '+readonly+'>';
		str+='<option value=""><?=$txtdt["1172"]?></option> ';
		for(i=1;i<=10;i++)
		{
			str+='<option value="'+i+'">'+i+'<?=$txtdt["1018"]?></option>';
		}
		str+='</select>';*/

		$("#td_sweetcnt").html(str);


		var sweet=$("input[name=rcSweet]").val();
		var newdata="";

		if(!isEmpty(sweet))
		{
			var sweetarr=$("input[name=rcSweet]").val().split("|");
			newdata="<ul>";
			for(i=1;i<sweetarr.length;i++)
			{
				var sweetarr2=sweetarr[i].split(",");
				var title=$("#rcSweetDiv option[value="+sweetarr2[0]+"]").data("title");
				newdata+=addSweet(title, sweetarr2[1], sweetarr2[0]);
			}
			newdata+="</ul>";
			$("#td_sweetdata").html(newdata);
			$("textarea[name=rcSweetData]").val(newdata);
		}
	}
	function addSweet(title, capa, code)
	{
		return "<li>"+title+" "+capa+"g <span class='sweetdel' onclick=\"sweetdelete('"+code+"')\">X</span></li>";
	}
	function sweetdelete(code)
	{
		//console.log("sweetdelete  code = " + code +", newsweet = " + $("input[name=rcSweet]").val());

		if(!isEmpty($("input[name=rcSweet]").val()))
		{
			var sweetarr=$("input[name=rcSweet]").val().split("|");

			newsweet=newdata=title="";
			newdata="<ul>";
			for(i=1;i<sweetarr.length;i++)
			{
				var sweetarr2=sweetarr[i].split(",");
				var sweetcnt=sweetarr2[1];
				
				if(sweetarr2[0]==code)
				{
					//newsweet+="|"+sweetarr2[0]+","+sweetcnt+",inlast,"+sweetarr2[3];
					//title=$("#rcSweetDiv option[value="+sweetarr2[0]+"]").data("title");
					//newdata+=addSweet(title, sweetcnt, sweetarr2[0]);
				}
				else
				{
					newsweet+="|"+sweetarr2[0]+","+sweetarr2[1]+",inlast,"+sweetarr2[3];
					title=$("#rcSweetDiv option[value="+sweetarr2[0]+"]").data("title");
					newdata+=addSweet(title, sweetarr2[1], sweetarr2[0]);
				}
			}
			newdata+="</ul>";

			//console.log("sweetdelete  newsweet = " + newsweet );

			$("#td_sweetdata").html(newdata);
			$("textarea[name=rcSweetData]").val(newdata);

			$("input[name=rcSweet]").val(newsweet);
			//console.log("sweetChange after ::  " + newsweet);

			resetamountprint();
		}

	}
	function sweetChangeCnt()
	{
		//var rccnt=$("select[name=sweetcnt]").val();
		var rccnt=$("input[name=sweetcnt]").val();
		var rctype=$("select[name=rcSweetDiv]").val()
		if(!isEmpty(rccnt) && isEmpty(rctype))
		{
			alertsign("warning", "<?=$txtdt['1908']?>", "", "2000");//별전을 먼저 선택해 주세요.
			$("input[name=sweetcnt]").val("");
			return; 
		}
		if(!isEmpty(rccnt) && !isEmpty(rctype))
		{
			sweetChange();
			$("input[name=sweetcnt]").val("");
			$('#rcSweetDiv option:eq(0)').prop('selected', true);
		}
	}
	function sweetChange()
	{
		var sweetdata=$("textarea[name=rcSweetData]").val();
		var sweet=$("input[name=rcSweet]").val();
		var rctype=$("select[name=rcSweetDiv]").val();
		var rctitle=$("#rcSweetDiv option:selected").data("title");
		//20190918 : miGramde 추가 
		var miGrade=$("input[name=miGrade]").val();
		miGrade=chkGrade(miGrade);
		miGrade=miGrade.toLowerCase();
		//20190918 : 별전가격 추가 
		var rcprice=$("#rcSweetDiv option:selected").data("price"+miGrade);
		//var rccnt=$("select[name=sweetcnt]").val();
		var rccnt=$("input[name=sweetcnt]").val();

		$('#sweetcnt option:eq(0)').prop('selected', true);

		

		if(!isEmpty(rccnt))
		{
			var chk=true;
			var newsweet=newdata="";
			newdata="<ul>";
			if(!isEmpty(sweet))
			{
				var sweetarr=$("input[name=rcSweet]").val().split("|");
				for(i=1;i<sweetarr.length;i++)
				{
					var sweetarr2=sweetarr[i].split(",");
					if(rctype==sweetarr2[0])
					{
						chk=false;
						newsweet+="|"+rctype+","+rccnt+",inlast,"+rcprice;
						newdata+=addSweet(rctitle, rccnt, rctype);
					}
					else
					{
						var title=$("#rcSweetDiv option[value="+sweetarr2[0]+"]").data("title");
						newsweet+="|"+sweetarr2[0]+","+sweetarr2[1]+",inlast,"+sweetarr2[3];
						newdata+=addSweet(title, sweetarr2[1], sweetarr2[0]);
					}
				}
			}
	
			if(chk==true)
			{
				newsweet+="|"+rctype+","+rccnt+",inlast,"+rcprice;
				newdata+=addSweet(rctitle, rccnt, rctype);
			}
			newdata+="</ul>";
			$("#td_sweetdata").html(newdata);
			$("textarea[name=rcSweetData]").val(newdata);

			$("input[name=rcSweet]").val(newsweet);
			console.log("sweetChange after ::  " + newsweet);
			resetamountprint();
		}

		
	}
	//첩수,팩수,팩용량 입력시
	$("input[name=odPackcnt], input[name=odPackcapa]").keyup(function()
	{	
		resetamountprint();
	});
	//주문금액 
	function resetamountprint()
	{

		console.log("resetamountprint   start ");
		//-------------------------------------------------------------------------------
		var data="";
		var odAmount = 0;
		var db_making=db_decoction=db_deliprice=p1=p2=p3=p4=packprice=db_box=db_boxmedibox=0;
		var chubcnt=packcnt=packcapa=boxcnt=boxmedicnt=packaddcnt=0;
		var chubtotal=chubpricetotal=chubprice=meditotal=watertotal=pricetotal=medipricetotal=0;
		var tval=mediamt=tprice=mdprice=twater=mdwater=totalmediprice=0;
		var amountdjmedi = JSON.parse($("textarea[name=odAmountdjmedi]").val());
		console.log(amountdjmedi);
		//-------------------------------------------------------------------------------
	
		//-------------------------------------------------------------------------------
		// 20190917 : 조제비,탕전비,배송비 저장된거 불러오기 
		//-------------------------------------------------------------------------------
		db_making = parseFloat($("input[name=maPrice]").val());//조제비
		db_decoction = parseFloat($("input[name=dcPrice]").val());//탕전비
		db_deliprice = parseFloat($("input[name=rePrice]").val());//배송비
		db_box = parseFloat($("input[name=reBox]").val());//100팩당 1박스 기준
		db_boxmedibox = $("#reBoxmedi option:selected").data("capa");//선택된 한약박스의 용량을 가져오자 
		$("input[name=reBoxmedibox]").val(db_boxmedibox);
		//-------------------------------------------------------------------------------

		console.log("DOO ====> db_making = " + db_making+", db_decoction = " + db_decoction + ", db_deliprice = " + db_deliprice + ", db_box = " + db_box + ", db_boxmedibox = " + db_boxmedibox);

		//조제타입
		var type = $("input[name=odMatype]").val();

		//파우치 가격 
		p1=$("input[name=odPackprice]").val();
		//한약박스가격
		p2 = $("input[name=reBoxmediprice]").val();
		//배송포장재종류 가격
		p3=$("input[name=reBoxdeliprice]").val();
		p4=$("input[name=packPrice]").val();


		console.log("DOO ====> p1 = "+p1+", p2 = " + p2+", p3 = " + p3+", p4 = "+ p4);

		//-------------------------------------------------------------------------------
		// 입력받은 첩수,팩수,팩용량
		//-------------------------------------------------------------------------------
		//첩수
		chubcnt=parseFloat($("input[name=odChubcnt]").val());
		//팩수
		packcnt=parseFloat($("input[name=odPackcnt]").val());
		//팩용량
		packcapa=parseFloat($("input[name=odPackcapa]").val());
		//입력받은 팩수에 + 4 해야함. (1개는 버리고 3개는 보관용)
		//20190826 11:11 분에 수정
		packaddcnt=parseInt($("input[name=packaddcnt]").val());
		//-------------------------------------------------------------------------------
		chubcnt = ((isNaN(chubcnt)==false)) ? parseFloat(chubcnt):0;
		packcnt = ((isNaN(packcnt)==false)) ? parseFloat(packcnt):0;
		packcapa = ((isNaN(packcapa)==false)) ? parseFloat(packcapa):0;
		//-------------------------------------------------------------------------------

		//-------------------------------------------------------------------------------
		//감미제 
		//-------------------------------------------------------------------------------
		var sugaramount=specialamount=0;
		var sugardata=sugarval="";

		console.log(amountdjmedi);

		if(!isEmpty(amountdjmedi["sugar"]))
		{
			var sugararr=amountdjmedi["sugar"].split(",");
			if(!isEmpty(sugararr[0]))
			{
				sugarname=sugararr[0];
				sugarcapa=sugararr[1];
				sugarprice=sugararr[2];
				sugaramount=parseFloat(sugararr[3]);
			}
		}
		if(!isEmpty(amountdjmedi["special"]))
		{
			var specialarr=amountdjmedi["special"].split(",");//amountdjmedi["special"]=specialName+","+specialAmount;//특수탕전비 
			if(!isEmpty(specialarr[1]))
			{
				console.log("특수탕전비 :: "+ specialarr[1]);
				specialamount=parseFloat(specialarr[1]);//특수탕전비  
			}
		}

		var totalpack=parseFloat(amountdjmedi["totalpack"]);//포장비
		var decoctionarr=amountdjmedi["decoction"].split(",");//탕전비
		var decoction=parseFloat(decoctionarr[2]);
		var making=parseFloat(amountdjmedi["making"]);//조제비 
		var releasearr=amountdjmedi["release"].split(",");//배송비 
		var release=parseFloat(releasearr[2]);
		var totalamount=parseFloat(amountdjmedi["totalamount"]);//주문금액


		var medicinearr=amountdjmedi["medicine"].split(",");//약재비 
		var medicine=parseFloat(medicinearr[2]);
		var sweet=0;
		if(!isEmpty(amountdjmedi["sweet"]))
		{
			var sweetarr=amountdjmedi["sweet"].split(",");//별전  
			sweet=parseFloat(sweetarr[2]);
		}


		var totmedicnt=$("#td_totMedicine").data("count");
		//-------------------------------------------------------------------------------
		// sweet 계산
		//-------------------------------------------------------------------------------
		var tsweetval=sweettotal=sweetcnt=sweetcount=stwater=smdwater=sweetprice=0;
		var tgamprice=tgamtotal=totsweetWater=0;
		var sweetdata="";

		var rcSweet=$("input[name=rcSweet]").val();
		console.log("rcSweet = " + rcSweet);
		if(!isEmpty(rcSweet)&&!isEmpty(sweetarr))
		{
			var sweetarr=$("input[name=rcSweet]").val().split("|");
			for(i=1;i<sweetarr.length;i++)
			{
				var sweetarr2=sweetarr[i].split(",");
				tsweetval = parseFloat(sweetarr2[1]);//갯수
				tgamprice = parseFloat(sweetarr2[3]);//가격 
				tgamtotal = tgamprice * tsweetval;

				//-------------------------------------------------------------------------------
				//흡수율 계산
				//-------------------------------------------------------------------------------
				stwater = $("#rcSweetDiv option[value="+sweetarr2[0]+"]").data("water");//해당약재 흡수율
				stwater = ((isNaN(stwater)==false)) ? stwater:0;
				smdwater = (parseFloat(tsweetval) * parseFloat(stwater))/100; // (총약재*흡수율) 나누기 100
				//-------------------------------------------------------------------------------

				totsweetWater+=smdwater;

				sweetprice+=tgamprice;
				sweetcnt+=tsweetval;
				sweettotal+=tgamtotal;
				//console.log("DOO ==> 별전 title = "+title+ ", tsweetval = " + tsweetval+", tgamprice = " + tgamprice+", tgamtotal = " + tgamtotal);

				var title=$("#rcSweetDiv option[value="+sweetarr2[0]+"]").data("title");

				sweetdata+="|"+title+","+tsweetval+","+tgamprice+","+tgamtotal;
			}


		}
		else
		{
			sweetdata="0,0,0";
			tgamprice=0;
			tsweetval=0;
			tgamtotal=0;
			sweetprice=0;
			sweetcnt=0;
			sweettotal=0;
		}
		amountdjmedi["sweet"]=sweetdata;//별전 
		sweet=sweettotal;


		sweetcount=0;
		if(!isEmpty(sweetarr))
		{
			sweetcount=sweetarr.length-1;
		}
			
		var totcount=totmedicnt+sweetcount;

		$("#td_totMedicine").text(totcount);//약미
		$("#sptotsweetCapa").text(sweetcnt);//약재량 

		var totalmediprice=medicine+sweettotal;
		$("#tot_meditotalprice").text(comma(setPriceFloor(totalmediprice))+"<?=$txtdt['1235']?>");//약재비

		//-------------------------------------------------------------------------------

		//-------------------------------------------------------------------------------
		//탕전물량
		//-------------------------------------------------------------------------------
		var dcAlcohol=dcWater=water=alcohol=0;
		var dcTime=$("input[name=dcTime]").val();
		var watertotal=parseFloat($("input[name=watertotal]").val());
		var dc_special=$("input[name=dcSpecial]").val();
		var dooWater=calcDcWater(dcTime, watertotal, packcnt, packcapa);
		dcWater=dooWater;
		
		if(chkdcSpecial(dc_special)=="alcohol")//주수상반
		{
			water=calcWaterAlcohol(dooWater);
			alcohol=dooWater - water;
			dcWater=water;
			dcAlcohol=alcohol;
		}
		else if(chkdcSpecial(dc_special)=="distillation")//증류탕전 
		{
			water=calcWaterDistillation(dooWater);
			dcWater=water;
		}
		else if(chkdcSpecial(dc_special)=="dry")//건조탕전 
		{
			dcWater=calcWaterDry(watertotal, packcnt, packcapa);
		}
		$("input[name=dcWaterbak]").val(dcWater);
		$("input[name=dcWater]").val(dcWater);
		$("#td_dcWater").text(dcWater);
		$("input[name=dcAlcohol]").val(dcAlcohol);
		$("#td_dcAlcohol").text(dcAlcohol);
		//-------------------------------------------------------------------------------

		//-------------------------------------------------------------------------------
		// 감미제 
		//-------------------------------------------------------------------------------
		sugaramount=!isEmpty(sugaramount)?sugaramount:0;
		if(isNaN(sugaramount)){sugaramount=0;}
		console.log("####DOO sugaramount : " + sugaramount);
		$("#tot_sugartotalprice").text(commasFixed(sugaramount)+"<?=$txtdt['1235']?>");//약재비
		//-------------------------------------------------------------------------------

		//-------------------------------------------------------------------------------
		// 특수탕전비  
		//-------------------------------------------------------------------------------
		$("#tot_specialtotalprice").text(commasFixed(specialamount)+"<?=$txtdt['1235']?>");//약재비
		//-------------------------------------------------------------------------------

//{"medicine":"567.9,20,11358","sweet":"","totalmedicine":11358,"sugar":"교이5bx,270,32,8640","special":"주수상반(청주),1000","decoction":"17600,1,17600","makingprice":"150,45,6750","infirst":"0,1,0","inafter":"0,1,0","making":6750,"poutch":"0,1,0","medibox":"0,1,0","delibox":"0,1,0","dcshape":"0,1,0","packing":"5000,1,5000","totalpack":5000,"release":"4000,1,4000","totalamount":54340}

		//-------------------------------------------------------------------------------
		//20190917 : 탕전비 계산 => 용량에 상관없이 Class 적용됨 공식은 약재비와 같음
		//-------------------------------------------------------------------------------
		var decoctionprice = db_decoction;
		$("#tot_decoctiontotalprice").text(commasFixed(decoctionprice)+"<?=$txtdt['1235']?>");//탕전비
		amountdjmedi["decoction"]=db_decoction+",1,"+decoctionprice;//탕전비  
		//-------------------------------------------------------------------------------

	
		var rcMedicinetxt=$("input[name=rcMedicine]").val();
		console.log("rcMedicinetxt = " + rcMedicinetxt);

		//-------------------------------------------------------------------------------
		//20190917 : 조제비 계산 => 팩수 * 조제비 적용
		//-------------------------------------------------------------------------------
		var makingprice = parseFloat(packcnt) * parseFloat(db_making); //조제비  * 팩수
		
		var inafter=infirst=0;
		if (rcMedicinetxt.indexOf("infirst") != -1) 
		{
			infirst=$("input[name=firstPrice]").val();
			console.log("infirst = " + infirst);
		}
		if (rcMedicinetxt.indexOf("inafter") != -1) 
		{
			inafter=$("input[name=afterPrice]").val();
			console.log("inafter = " + inafter);
		}


		amountdjmedi["makingprice"]=db_making+","+packcnt+","+makingprice;
		amountdjmedi["infirst"]=infirst+",1,"+infirst;
		amountdjmedi["inafter"]=inafter+",1,"+inafter;
		var totalmaking=parseFloat(makingprice)+parseFloat(infirst)+parseFloat(inafter);
		amountdjmedi["making"]=totalmaking;
		$("#tot_makingtotalprice").text(comma(setPriceFloor(totalmaking))+"<?=$txtdt['1235']?>");//조제비
		//-------------------------------------------------------------------------------

		//-------------------------------------------------------------------------------
		//20190917 : 파우치, 한약박스 계산 => 수량에 상관없이 적용됨 * 1
		//-------------------------------------------------------------------------------
		var pmdcnt=1;//수량에 상관없이 하기때문에 기본1로 셋팅 
		var packp = parseFloat(p1);
		var mediboxp = parseFloat(p2);
		var deliboxp = parseFloat(p3);
		var packingp=parseFloat(p4);

		//금박지 
		var dcShapeDesc=0;
		if(type=="jehwan" && !isEmpty($("input[name='dcShapeDesc']").val()))
		{
			dcShapeDesc=$("input[name='dcShapeDesc']").val();
			dcShapeDesc=(!isEmpty(dcShapeDesc)) ? parseInt(dcShapeDesc) : 0;
		}
		packprice = packp + mediboxp + deliboxp + dcShapeDesc + packingp;
		if(isNaN(packprice)){packprice=0;}

		data=commasFixed(packprice)+" <?=$txtdt['1235']?>";

		amountdjmedi["poutch"]=p1+","+pmdcnt+","+packp;//파우치 
		amountdjmedi["medibox"]=p2+","+pmdcnt+","+mediboxp;//한약박스
		amountdjmedi["delibox"]=p3+","+pmdcnt+","+deliboxp;//배송박스
		amountdjmedi["dcshape"]=dcShapeDesc+",1,"+dcShapeDesc;//금박지 
		amountdjmedi["packing"]=packingp+",1,"+packingp;//포장비 
		amountdjmedi["totalpack"]=packprice;//토탈포장비 

		$("#tot_packingtotalprice").text(data);//포장비
		//-------------------------------------------------------------------------------


		//-------------------------------------------------------------------------------
		//20190917 : 배송비 계산 => 배송비는 약재박스 단위로 계산하는데 2개당 하나의 송장이 부착 1개일때 - 송장한개, 2개일때  송장한개, 3개일일때 송장 2개...
		//-------------------------------------------------------------------------------
		var boxmax = Math.ceil(packcnt / db_boxmedibox);//올림 
		boxcnt=Math.ceil(boxmax/2);
		var boxprice = (boxcnt * db_deliprice);
		if(isNaN(boxprice)){boxprice=0;}
		$("#tot_releasetotalprice").text(commasFixed(boxprice)+"<?=$txtdt['1235']?>");//배송비
		amountdjmedi["release"]=db_deliprice+","+boxcnt+","+boxprice;//배송비 
		//-------------------------------------------------------------------------------
		//주문금액
		//-------------------------------------------------------------------------------
		odAmount = totalmediprice + decoctionprice + totalmaking + packprice + boxprice + sugaramount + specialamount;
		console.log("totalmediprice = "+totalmediprice+", decoctionprice = "+decoctionprice+", totalmaking = "+totalmaking+", packprice = "+packprice+", boxprice = "+boxprice+", sugaramount = "+sugaramount+", specialamount = "+specialamount);
		odAmount=Math.floor(odAmount/10)*10;
		if(isNaN(odAmount)){odAmount=0;}
		$("#td_total_price").text(commasFixed((odAmount))+"<?=$txtdt['1235']?>");
		$("input[name=odAmount]").val(odAmount);//seq //Math.floor(tdprice/10)*10; 1원단위는 버림
		//-------------------------------------------------------------------------------
		


		amountdjmedi["totalamount"]=odAmount;//총주문금액 

		console.log(JSON.stringify(amountdjmedi));			

		$("textarea[name=odAmountdjmedi]").val(JSON.stringify(amountdjmedi));

		if(type=="jehwan")
		{
			resetjewan();
		}

		ordersummaryupdate();
	}
	function resetjewan()
	{
		/*
		//결합제 
		var type=$('input:radio[name="dcBinders"]:checked').val();//결합제 

		//결합제량을 구하기 위해 DB에 등록된 퍼센트
		var dcBindersValue=$('input:radio[name="dcBinders"]:checked').data("value");
		dcBindersValue=(!isEmpty(dcBindersValue)) ? parseInt(dcBindersValue) : 6;//기본이 6이다 

		//금박지 가격 
		var desc=$('input:radio[name="dcBinders"]:checked').data("desc"); 
		desc=(!isEmpty(desc)) ? parseInt(desc) : 0;

		//총약재량 
		var meditotal = parseInt($("#meditotal").text().replace(",",""));

		//제형이 탄자대이면서 결합제가 봉밀일 경우에만 value가 *2 
		var dcShapeType=$('input:radio[name="dcShape"]:checked').val();
		if((dcShapeType == "tanjadae" && type == "honey") || (dcShapeType == "goldtanjadae" && type == "honey"))
		{
			dcBindersValue = dcBindersValue * 2;
		}
		
		//결합제량 
		var dbs = Math.floor((meditotal * (dcBindersValue / 100)));

		//console.log("type = " + type+", dcBindersValue = " + dcBindersValue + ", desc = " + desc+", meditotal = " + meditotal + ", dbs = " + dbs);
		//결합제 
		$("input[name=dcBindersliang]").val(dbs);

		//제분손실
		var dcMillingloss=parseInt($("input[name=dcMillingloss]").val());
		//제환손실 
		var dcLossjewan=parseInt($("input[name=dcLossjewan]").val());


		//완성량 
		var dcCompleteliang = parseInt(meditotal - dcMillingloss - dcLossjewan + dbs);

		$("input[name=dcCompleteliang]").val(dcCompleteliang);

		//제형종류에 따라 완성량에서 나눌 숫자 
		var dcShapeValue=$('input:radio[name="dcShape"]:checked').data("value");
		dcShapeValue=(!isEmpty(dcShapeValue)) ? parseInt(dcShapeValue) : 1;
		
		var dcCompletecnt = Math.floor(dcCompleteliang / dcShapeValue);

		//완성갯수 
		$("input[name=dcCompletecnt]").val(dcCompletecnt);


		var capa=$("input[name=odPackcapa]").val();
		if(parseInt(capa) > 0)
		{
			var packcnt=Math.floor(parseInt(dcCompleteliang) / parseInt(capa));
			packcnt = (isNaN(packcnt)==false) ? packcnt : 0;
			packcnt=(packcnt < 0) ? 0:packcnt;
			console.log("capa="+capa+", dcCompleteliang="+dcCompleteliang+", packcnt = " + packcnt);
			$("input[name=odPackcnt]").val(packcnt);
		}
		else
		{
			$("input[name=odPackcnt]").val("0");
		}
		*/

	}
	function ordersummaryupdate()
	{
		var key=data="";
		var jsondata={};

		$(".reqdata").each(function(){
			key=$(this).attr("name");
			data=$(this).val();
			jsondata[key] = data;
		});

		console.log("ordersummaryupdate  =========== start ");
		console.log(JSON.stringify(jsondata));
		console.log("ordersummaryupdate  =========== end ");

		callapi("POST","order","ordersummaryupdate",jsondata);
	}

	
	callapi('GET','order','ordersummary','<?=$apiorderData?>');


</script>
