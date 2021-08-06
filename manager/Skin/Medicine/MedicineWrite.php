<?php //약재목록 상세
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

<input type="hidden" name="seq" class="reqdata" value="<?=$seq?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Medicine/MedicineList.php">

<div class="board-view-wrap">
	<h3 class="u-tit02"><?=$txtdt["1130"]?>_<?=$txtdt["1725"]?><!-- 본초정보 --><!-- 디제이메디 --></h3>
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
				<th><span class="nec"><?=$txtdt["1456"]?><!-- 본초코드검색 --></span></th>
				<td colspan="3">
					<input type="hidden" class="w150p reqdata necdata" name="mhCode" title="<?=$txtdt["1131"]?>" value="" readonly/><!-- 본초코드 -->
					<a href="javascript:;" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medihub" data-value="700,600">
					<button type="button" class="cw-btn" style=""><span>+ <?=$txtdt["1122"]?><!-- 본초검색 --></span></button>
					</a>
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1124"]?><!-- 본초명 --></span></th>
				<td><div id="mhTitle"></div></td>
				<th><span><?=$txtdt["1117"]?><!-- 별칭/이명 --></span></th>
				<td><div id="mhDtitle"></div></td>
			</tr>
			 <tr>
				<th><span><?=$txtdt["1400"]?><!-- 학명 --></span></th>
				 <td><div id="mhStitle"></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1028"]?><!-- 과명 --></span></th>
				 <td colspan="3"><div id="mhCtitle"></td>
			</tr> 
		</tbody>
    </table>
	<div class="gap"></div>
	<h3 class="u-tit02"><?=$txtdt["1450"]?>_<?=$txtdt["1725"]?><!-- 약재정보 --></h3>
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
				<td><input type="text" name="mdTitle" class="w70p reqdata necdata" title="<?=$txtdt["1204"]?>"/></td>
				<th><span class="nec"><?=$txtdt["1213"]?><!-- 약재코드 --></span></th>
					<td>
				<?php if(!empty($seq)){?>						
						<input type="text" name="mdCode" onblur="medichk()" class="w70p reqdata necdata" title="<?=$txtdt["1213"]?>" readonly />
						<input type="hidden" id="chk_code" name="chk_code" value="1">					
				<?php }else{?>				
						<!-- <input type="text" name="mdCode" onblur="medichk()" class="w70p reqdata necdata" title="<?=$txtdt["1213"]?>" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/g,'');" onkeydown='textOut()'/>
						<input type="hidden" id="chk_code" name="chk_code" value="0">	 -->	
						 <span><?=$txtdt["1481"]?><!-- 자동추가 --></span>
				<?php }?>
				<div id="chkcodeText"></div>
				</td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1115"]?><!-- 별전 --></span></th>
				<td colspan="3" id="mdSweetDiv"></td>

			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1626"]?><!-- 약재흡수율코드 --></span></th>
				<td colspan="3" id="mdWaterDiv"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1627"]?><!-- 약재흡수율예외처리 --></span></th>
				<td colspan="1" id="mdWaterchkDiv"></td>
				<th><span class="nec"><?=$txtdt["1608"]?><!-- 흡수율 --></span></th>
				<td><input type="text" name="mdWater" id="mdWater" class="w70p reqdata necdata" title="<?=$txtdt["1608"]?>" /></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1383"]?><!-- 판매가격 --></span></th>
				<td><input type="text" id="mdPrice" name="mdPrice" class="w70p reqdata necdata" title="<?=$txtdt["1383"]?>" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/><?=$txtdt["1235"]?><!-- 원 -->/1g</td>
				<th><span class="nec"><?=$txtdt["1931"]?><!-- 로스율 --></span></th>
				<td><input type="text" name="mdLoss" class="w70p reqdata necdata" title="<?=$txtdt["1931"]?>" onfocus="this.select();" onchange="changeNumber(event,true);"/></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1383"]?>A<!-- 판매가격 --></span></th>
				<td><input type="text" id="mdPriceA" name="mdPriceA" class="w70p reqdata necdata " title="<?=$txtdt["1383"]?>A" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/><?=$txtdt["1235"]?><!-- 원 -->/1g</td>
				<th><span class="nec"><?=$txtdt["1237"]?><!-- 원산지 --></span></th>
				<td colspan="1" id="CountryCodeDiv"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1383"]?>B<!-- 판매가격 --></span></th>
				<td><input type="text" id="mdPriceB" name="mdPriceB" class="w70p reqdata necdata " title="<?=$txtdt["1383"]?>B" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/><?=$txtdt["1235"]?><!-- 원 -->/1g</td>
				<th><span class="nec"><?=$txtdt["1288"]?><!-- 제조사 --></span></th>
				<td colspan="1" id="MakerDiv"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1383"]?>C<!-- 판매가격 --></span></th>
				<td><input type="text" id="mdPriceC" name="mdPriceC" class="w70p reqdata necdata " title="<?=$txtdt["1383"]?>C" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/><?=$txtdt["1235"]?><!-- 원 -->/1g</td>
				<th><span><?=$txtdt["1224"]?><!-- 연관어 --></span></th>
				<td><input type="text" name="mdRelate" class="w70p reqdata" title="<?=$txtdt["1224"]?>"/></td>
			</tr>

			<tr>
				<th><span class="nec"><?=$txtdt["1383"]?>D<!-- 판매가격 --></span></th>
				<td><input type="text" id="mdPriceD" name="mdPriceD" class="w70p reqdata necdata " title="<?=$txtdt["1383"]?>D" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/><?=$txtdt["1235"]?><!-- 원 -->/1g</td>
				<th><span class=""><?=$txtdt["1114"]?><!-- 법제 --></span></th>
				<td><input type="text" name="mdProperty" id="mdProperty" class="w70p reqdata" title="<?=$txtdt["1114"]?>"/></td>
			</tr>

			<tr>
				<th><span class="nec"><?=$txtdt["1383"]?>E<!-- 판매가격 --></span></th>
				<td><input type="text" id="mdPriceE" name="mdPriceE" class="w70p reqdata necdata " title="<?=$txtdt["1383"]?>E" maxlength="10" onfocus="this.select();" onchange="changeNumber(event,true);"/><?=$txtdt["1235"]?><!-- 원 -->/1g</td>
				<th><span class=""><?=$txtdt["1549"]?><!-- 적정수량 --></span></th>
				<td><input type="text" name="mdStable" id="mdStable" class="w70p reqdata" title="<?=$txtdt["1549"]?>" maxlength="10" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1457"]?><!-- 약재상태 --></span></th>
				<td colspan="1" id="mdStatusDiv"></td>
				<th><span class=""><?=$txtdt["1282"]?><!-- 재고수량 --></span></th>
				<td><div id="mdQty"></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1116"]?><!-- 별칭 --></span></th>
				<td colspan="3"><input type="text" name="mdAlias" class="w70p reqdata" title="<?=$txtdt["1116"]?>"/></td>
			</tr>

			<tr>
				<th><span><?=$txtdt["1047"]?><!-- 내용 --></span></th>
				<td colspan="3"><textarea name="mdDesc" class="text-area reqdata" title="<?=$txtdt["1047"]?>"/></textarea></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1039"]?><!-- 기미(氣味)특징 --></span></th>
				<td colspan="3"><input type="text" name="mdFeature"  class="w70p reqdata" title="<?=$txtdt["1039"]?>"/></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1198"]?><!-- 약리학적 참고사항 --></span></th>
				<td colspan="3"><input type="text" name="mdNote"  class="w70p reqdata" title="<?=$txtdt["1198"]?>"/></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1065"]?><!-- 독성 및 약물상호작용 --></span></th>
				<td colspan="3"><input type="text" name="mdInteract"  class="w70p reqdata" title="<?=$txtdt["1065"]?>"/></td>
			</tr>
			<tr>	
				<th><span class=""><?=$txtdt["1072"]?><!-- 등록일 --></span></th>
				<td><div id="mdDate"></td>

			</tr>
		</tbody>
	</table>

    <div class="btn-box c">
			<?php if($modifyAuth == "true"){?>
				<a href="javascript:medicine_update();" class="bdp-btn"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
				<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
				<a href="javascript:medicine_del();" class="bdp-btn"><span><?=$txtdt["1154"]?><!-- 삭제 --></span></a>
			<?php }else{?>
				<a href="javascript:viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?><!-- 목록 --></span></a>
			<?php }?>
    </div>
</div>

<script>

	function textOut()
	{
		$("#chkcodeText").html('');  //중복입니다. 사용가능합니다 글자를 입력하면 안보이게 처리함 
	}

	//코드 중복확인
	function medichk()
	{
		console.log("약재코드를 입력해하면 0이 된다.")
		$("#chk_code").val(0);   //코드값을 누르면 일단 0으로 바뀐다.  
		if(!isEmpty($("input[name=mdCode]").val()))
		{
			var data = "mdCode="+$("input[name=mdCode]").val();
			console.log('중복체크하러 갑니다~'+data); 
			callapi('GET','medicine','chkmedicode',data); //코드 중복 체크 
		}
		else
		{
			alertsign("warning", "<?=$txtdt['1755']?>", "", "2000"); //약재코드를 입력해 주세요.
		}
	}

	function medicine_update(status)//등록&수정
	{
		//if($("input[name=chk_code]").val()==1) //중복확인이 1이어야 등록가능
		//{
			if(necdata()=="Y") //필수값체크
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

				$(".reqdata").each(function()
				{
					key=$(this).attr("name");
					data=$(this).val();
					jsondata[key] = data;
				});
				
				console.log(JSON.stringify(jsondata));
				callapi("POST","medicine","medicineupdate",jsondata); //약재 등록&수정
			}
		//}
		/*
		else
		{
			if(!$("input[name=mhCode]").val())
			{
				alertsign("warning", "<?=$txtdt['1755']?>", "", "2000"); //약재코드를 입력해 주세요.
				$("input[name=mhCode]").focus();
				return false;
			}
			else
			{
				alertsign("warning", "<?=$txtdt['1754']?>", "", "2000"); //중복약재코드입니다.
				$("input[name=mhCode]").focus();
				return false;
			}	
		}
		*/
	}

	function medicine_del() //삭제
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);

		callapidel('medicine','medicinedelete',data);
		return false;
	}

	//본초검색버튼 누르면 팝업 열림
	function viewlayerPopup(obj)
	{
		var url=obj.getAttribute("data-bind");
		var size=obj.getAttribute("data-value");
		var data = "&page=1&psize=5&block=10"; //page,psize,block 사이즈 초기화
		console.log("=========>>>> viewlayerPopup url = " + url+", size = " + size);
		getlayer(url,size,data);
	}

	var mdWater = document.getElementById('mdWater');
    mdWater.onkeyup = function(event){
            event = event || window.event;
            var _val = this.value.trim();
            this.value = Number_Only(_val) ;
    }


	//숫자와 -만 입력 (흡수율은 음수값있음)
	function Number_Only(str)
	{
		str = str.replace(/[^\-0-9]/g, '');
		return str;
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="medicinedesc") //약재상세
		{
			$("#mhTitle").text(obj["mhTitle"]); //본초명
			$("#mhDtitle").text(obj["mhDtitle"]); //별칭/이명
			$("#mhStitle").text(obj["mhStitle"]);//학명
			$("#mhCtitle").text(obj["mhCtitle"]); //과명

			$("input[name=mdTitle]").val(obj["mdTitle"]);  //약재명
			$("input[name=mdCode]").val(obj["mdCode"]); //약재코드
			$("input[name=mdOrigin]").val(obj["mdOrigin"]); //원산지
			$("input[name=mdMaker]").val(obj["mdMaker"]);//제조사
			$("input[name=mdRelate]").val(obj["mdRelate"]); //연관어
			$("input[name=mdProperty]").val(obj["mdProperty"]); //법제

			$("input[name=mdLoss]").val(obj["mdLoss"]); //법제

			$("input[name=mdPrice]").val(obj["mdPrice"]); //판매가격
			$("input[name=mdPriceA]").val(obj["mdPriceA"]); //판매가격
			$("input[name=mdPriceB]").val(obj["mdPriceB"]); //판매가격
			$("input[name=mdPriceC]").val(obj["mdPriceC"]); //판매가격			
			$("input[name=mdPriceD]").val(obj["mdPriceD"]); //판매가격
			$("input[name=mdPriceE]").val(obj["mdPriceE"]); //판매가격
			
			$("input[name=mdStable]").val(obj["mdStable"]); //적정수량
			$("input[name=mdAlias]").val(obj["mdAlias"]); //별칭

			$("input[name=mdWater]").val(obj["mdWater"]); //흡수율
			$("input[name=mhCode]").val(obj["mhCode"]); //본초코드

			$("input[name=mdFeature]").val(obj["mdFeature"]); //기미(氣味)특징
			$("input[name=mdNote]").val(obj["mdNote"]);//약리학적 참고사항
			$("input[name=mdInteract]").val(obj["mdInteract"]); //독성 및 약물상호작용

			$("#mdQty").text(obj["mdQty"]); //재고수량
			$("#mdDate").text(obj["mdDate"]); //등록일
			$("textarea[name=mdDesc]").text(obj["mdDesc"]); //내용
			
			///국가코드 리스트
			OriginMakerSelect("CountryCodeDiv", obj["CountryCodeList"], "mdOrigin",obj["mdOrigin"], "mdOrigin", "<?=$txtdt['1172']?>"); 



			

			
			if(obj["seq"] && obj["mdOrigin"])   //seq가 있을때 선택한 값을 보이게 CountryCode
			{
				//OriginMakerSelect("CountryCodeDiv", obj["CountryCodeList"], "mdOrigin",obj["mdOrigin"], "mdOrigin", "<?=$txtdt['1172']?>");
				$("#CountryCodeDiv").text(obj["mdOrigin"]); 
			}
			

			///제조사
			OriginMakerSelect("MakerDiv", obj["MakerList"], "mdMaker",obj["mdMaker"], "mdMaker", "<?=$txtdt['1172']?>"); 
			
			if(obj["seq"] && obj["mdMaker"])   //seq가 있을때 선택한 값을 보이게 CountryCode
			{
				//OriginMakerSelect("MakerDiv", obj["MakerList"], "mdMaker",obj["mdMaker"], "mdMaker", "<?=$txtdt['1172']?>");
				$("#MakerDiv").text(obj["mdMaker"]); 
			}
			

			parseradiocodes("mdStatusDiv", obj["StatusList"], "<?=$txtdt['1457']?>", "mdStatus", "medi-list", obj["mdStatus"]);//약재상태 리스트
			parseradiocodes("mdWaterDiv", obj["WaterList"], "<?=$txtdt['1626']?>", "mdWatercode", "water-list", obj["mdWatercode"]);//약재흡수율 리스트
			CodeRadio("mdWaterchkDiv", obj["WaterchkList"], "<?=$txtdt['1627']?>", "mdWaterchk", "medi-list", obj["mdWaterchk"]);//약재흡수율예외처리 리스트
			CodeRadio("mdSweetDiv", obj["SweetList"], "<?=$txtdt['1115']?>", "mdType", "sweet-list", obj["mdType"]);//별전 리스트
	   }
	   else if(obj["apiCode"]=="hublist") //본초리스트(팝업)
	   {
		   var data = "";

			$("#laymedicinetbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mhCode"]+'">';
					data+='<td>'+value["mhCode"]+'</td>'; //본초코드
					data+='<td>'+value["mhTitle"]+'</td>'; //본초명
					data+='<td>'+value["mhStitle"]+'</td>'; //학명
					data+='<td>'+value["mhDtitle"]+'</td>'; //이명
					data+='<td>'+value["mhCtitle"]+'</td>'; //과명
					data+='</tr>'
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
		   $("#laymedicinetbl tbody").html(data);

		   //페이징
		   getsubpage_pop("hublistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
	   }
	   /*
	   else if(obj["apiCode"]=="chkmedicode") //코드 중복체크
	   {
			if(obj["resultCode"] == "200")
			{
				$("#chkcodeText").css("color", "blue");
				$("#chkcodeText").text("<?=$txtdt['1476']?>"); //사용 가능합니다.
				$("#chk_code").val(1);
				
			}
			else if(obj["resultCode"] == "999")
			{				
				$("#chkcodeText").css("color", "red");
				$("#chkcodeText").text("<?=$txtdt['1726']?>"); //이미 사용중인 약재코드입니다.
				$("#chk_code").val(0);	
			}
	   }
	   */
	}
   callapi('GET','medicine','medicinedesc','<?=$apidata?>'); //약재 상세 API 호출 & 옵션 호출

	///국가코드  제조사 select 박스
	function OriginMakerSelect(pgid, list, code, data, name,text)
	{

		var shtml=codeval=title=selected="";
			shtml+="<dl class='chkdl'>";
			shtml+="<dd>";
			shtml+="<select title='"+name+"' id='"+name+"' name='"+name+"' class='reqdata'>";
			//shtml+="<option value=''>"+text+"</option>";  //선택해주세요

			for(var key in list)
			{
				//console.log("codeval = " + codeval);
				//console.log("title = " + title);

				codeval = list[key]["cdName"];
				title = list[key]["cdName"];
				
				if(data==codeval){selected=" selected";}else{selected=" ";}
				shtml+="<option value='"+codeval+"' "+selected+">"+title+"</option>";
			}

			shtml+="</select>";
			shtml+="</dd>";
			shtml+="</dl>";

		//console.log("shtml   >>> "+shtml);
		$("#"+pgid).html(shtml);
	}

</script>
