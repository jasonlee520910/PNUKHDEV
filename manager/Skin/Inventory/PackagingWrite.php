<?php //포장재등록
$root = "../..";
$upload=$root."/_module/upload";
include_once $root.'/_common.php';
include_once $upload."/upload.lib.php";
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
?>
<style type="text/css">
	/* 등급  */
	.pbGrade-list{overflow:hidden;}
	.pbGrade-list li {position:relative; width:7%; float:left; text-align:left; margin-right:3px;}

	.whCodeLeft {width:210px;float:left;margin-right:10px;}
	.whCodeRight {width:200px;float:left;}
	.meditit{margin-right:10px;}
	.delmedi{display:inline-block;width:13px;height:13px;text-align:center;line-height:100%;padding:2px;
		border:1px solid #666;border-radius:50%;}
	.delmedi:hover{cursor:pointer;background:#666;color:#fff;}
</style>
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>

<input type="hidden" name="pbseq" class="reqdata" value="">
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="packingupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Inventory/PackagingCode.php">
<input type="hidden" name="pbCodeonly" class="reqdata necdata" value="" title="포장재마킹">

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
				<th><span class="nec"><?=$txtdt["1132"]?><!-- 분류 --></span></th>
				<td colspan="3" id="selcatetdDiv"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1403"]?><!-- 한의원 --></span>
					<button type="button" class="cdp-btn " onclick="javascript:viewlayerPopup(this);" data-bind="layer-medical" data-value="700,600">
						<span><?=$txtdt["1405"]?><!-- 한의원검색 --></span>
					</button>
				</th>
				<td>
					<input type="hidden" class="w200 reqdata necdata" title="<?=$txtdt["1403"]?>"  id="miUserid" name="pbMember" value=""/>
					<!-- <div id="miName"></div> -->
					<input type="text" class="w200 reqdata" name="miName" value="" readonly/>					
				</td>
				<th><span class="nec"><?=$txtdt["1392"]?></span></th>
				<td>
					<div class="whCodeLeft">
						<input type="text" name="pbCode" class="w200 reqdata necdata" title="<?=$txtdt["1392"]?>" readonly/>
					</div>
					<div id="bpDiv" class="whCodeRight"></div>
				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1440"]?><!-- 포장재명 --></span></th>
				<td><input type="text" name="pbTitle"  class="w200 reqdata necdata" title="<?=$txtdt["1440"]?>" /></td>
				<th><span class="nec"><?=$txtdt["1771"]?><!-- 용량 --></span></th>
				<td><input type="text" class="reqdata necdata" title="<?=$txtdt["1771"]?>" id="pbCapa" name="pbCapa" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1588"]?><!-- 가격 --></span></th>
				<td><input type="text" class="reqdata necdata" title="<?=$txtdt["1588"]?>" id="pbPrice" name="pbPrice" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th><span class=""><?=$txtdt["1588"]?>A<!-- 가격 --></span></th>
				<td><input type="text" class="reqdata" title="<?=$txtdt["1588"]?>" id="pbPriceA" name="pbPriceA" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>

			<tr>
				<th><span class=""><?=$txtdt["1588"]?>B<!-- 가격 --></span></th>
				<td><input type="text" class="reqdata" title="<?=$txtdt["1588"]?>" id="pbPriceB" name="pbPriceB" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th><span class=""><?=$txtdt["1588"]?>C<!-- 가격 --></span></th>
				<td><input type="text" class="reqdata" title="<?=$txtdt["1588"]?>" id="pbPriceC" name="pbPriceC" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1588"]?>D<!-- 가격 --></span></th>
				<td><input type="text" class="reqdata" title="<?=$txtdt["1588"]?>" id="pbPriceD" name="pbPriceD" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th><span class=""><?=$txtdt["1588"]?>E<!-- 가격 --></span></th>
				<td><input type="text" class="reqdata" title="<?=$txtdt["1588"]?>" id="pbPriceE" name="pbPriceE" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th id="pbVolumeth"><span class=""><?=$txtdt["1943"]?><!-- 부피 --></span></th>
				<td><input type="text" class="reqdata" title="<?=$txtdt["1588"]?>" id="pbVolume" name="pbVolume" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th id="pbMaxcntth"><span class=""><?=$txtdt["1944"]?><!-- 최대팩수 --></span></th>
				<td><input type="text" class="reqdata" title="<?=$txtdt["1588"]?>" id="pbMaxcnt" name="pbMaxcnt" value="" maxlength="6" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span class="nec">포장재마킹<?//=$txtdt["1393"]?><!-- 포장재관리 --></span></th>
				<td colspan="3" id="mrDescDiv"></td>
				<!-- <td colspan="3">
					<dl>
						<dt><input type="radio" name="aa"><input type="checkbox" name=""></dt>
						<dd>주문번호</dd>
					</dl>
					<dl>
						<dt><input type="radio" name="aa"><input type="checkbox" name=""></dt>
						<dd>주문번호</dd>
					</dl>
					<dl>
						<dt><input type="radio" name="aa"><input type="checkbox" name=""></dt>
						<dd>주문번호</dd>
					</dl>
					<dl>
						<dt><input type="radio" name="aa"><input type="checkbox" name=""></dt>
						<dd>주문번호</dd>
					</dl>
				</td> -->
			</tr>
<!-- 			<tr>
				<!-- <th><span class=""><?=$txtdt["1822"]?>공통</span></th>
				<td>
					<input type="radio" name="allPbMember" class="radiodata" title="<?=$txtdt["1822"]?>" value="all"/>Y, 
					<input type="radio" name="allPbMember" class="radiodata" title="<?=$txtdt["1822"]?>" value="none"/>N
				</td>
				<th><span class=""><?=$txtdt["1902"]?>등급</span></th>
				<td colspan="3">
					<div id="GradeDiv"></div>
				</td>
			<tr> -->
				<th><span class=""><?=$txtdt["1248"]?><!-- 이미지첨부 --></span></th> 
				<td colspan="3"><?=upload("packingbox",$_COOKIE["ck_stStaffid"],$_COOKIE["ck_language"])?></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1173"]?><!-- 설명 --></span></th>
				<td colspan="3">
					<textarea class="text-area reqdata" name="pbDesc"></textarea>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btn-box c" id="btnDiv"></div>

</div>

<!--// page end -->
<script>
	function necdataclassadd(type)
	{
		console.log("type >>> "+type);

		if(type=="reBoxmedi" || type=="reBoxdeli")
		{
			$('#pbVolumeth span').addClass('nec'); 
			$('#pbMaxcntth span').addClass('nec');		
		}
		else
		{	
			$('#pbVolumeth span').removeClass('nec'); 
			$('#pbMaxcntth span').removeClass('nec');		
		} 
	}



	function repageload(){
	console.log("no  repageload ");
	}

	function packingupdate()
	{
		var pbtype=$("input:radio[name=pbType]:checked").val();

		if(pbtype=="reBoxmedi" || pbtype=="reBoxdeli") // 한약박스나 포장박스일때만 부피, 최대팩수 필수입력하기
		{
			var pbVolume = $("input[name=pbVolume]").val();
			var pbMaxcnt = $("input[name=pbMaxcnt]").val();

			if(pbVolume==0) 
			{
				alertsign("info", "<?=$txtdt['1945']?>", "", "2000");//부피를 입력해주세요
				$("input[name=pbVolume]").focus();
				return false;
			}
			else if(pbMaxcnt==0)
			{
				alertsign("info", "<?=$txtdt['1946']?>", "", "2000");//최대팩수를 입력해주세요
				$("input[name=pbMaxcnt]").focus();
				return false;
			}
		}

		/*
		if(pbtype=="reBoxmedi" || pbtype=="reBoxdeli")
		{
			$("input[name=pbCapa]").val("0");
		}
		else
		{
			var pbcapa=$("input[name=pbCapa]").val();
			pbcapa=(!isEmpty(pbcapa)) ? parseInt(pbcapa) : 0;

			if(pbcapa <= 0)
			{
				alertsign("info", "<?=$txtdt['1833']?>", "", "2000");//팩용량을 입력해주세요.
				return false;
			}
		}
/*
		var allPbMemberchk= $('input:radio[name=allPbMember]').is(':checked');

		if(!allPbMemberchk)
		{
			alertsign("info", "<?=$txtdt['1880']?>", "", "2000");//공통여부를 선택해주세요 
		}
*/
		var pcode=$("input[name=pbCodeonly]").val();
		if(isEmpty(pcode))
		{
			alertsign("error", "포장재마킹을 한가지 이상 선택해 주세요.", "", "2000");
			return false;
		}		

		if(necdata()=="Y") //필수조건 체크
		{
			var key=data="";
			var jsondata={};

			//radio data
			$(".radiodata").each(function()
			{
				key=$(this).attr("name");
				data=$("input:radio[name="+key+"]:checked").val();
				jsondata[key] = data;
			});

			$(".reqdata").each(function(){
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});

			console.log(JSON.stringify(jsondata));

			callapi("POST","inventory","packingupdate",jsondata);
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
	function markingChange(obj)
	{
		// var radioVal = $('input[name="rmrDesc"]:checked').val();
		var data=value=Status="";
		var i=0;
		value=$("input[name='rmrDesc']:checked").val();
		$("input:checkbox[id='"+value+"']").prop("checked", true);
		console.log("markingChange value = " + value);
		//예)marking01|Y,marking02|N - Y는기본
		$('input:checkbox[name="mrDesc"]').each(function(){
			if(this.checked){//checked 처리된 항목의 값
				Status="N";
				if(value==this.value){Status="Y";}
				if(i>0){data+=",";}
				data+=this.value+"|"+Status;
				i++;
			}
			else
			{
				if(value==this.value)
				{
					Status="Y";
					if(i>0){data+=",";}
					data+=this.value+"|"+Status;
					i++;
				}
			}
		});

		$("input[name=pbCodeonly]").val(data);

		console.log("markingChange data = " + data);
	}
	function parsemarkingcodes(pgid, list, title, name, type, data, readonly)
	{
		var radiostr=idstr=checked=checked2=disable="";
		var i=0;

		//data
		//marking01|Y,marking02|N
		if(!isEmpty(data))
		{
			var code=data.split(",");
			var choice;
			var gibon=select="";
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

		disable = (readonly == 'readonly') ? "disabled='disabled'" : "";

		for(var key in list)
		{
			idstr = "0" + i;
			idstr = idstr.slice(-2);
			checked=checked2="";
			if(!isEmpty(data))
			{
				console.log("data = " +data);
				if(data.indexOf(list[key]["cdCode"]) != -1)
				{
					checked='checked="checked"';
				}
				if(gibon==list[key]["cdCode"])
				{
					checked2='checked="checked"';
				}
			}

			radiostr += '<li style="float:left;width:20%;" onclick="markingChange(this)">';
			radiostr += '	기본 <input type="radio"  name="r'+name+'" id="mr'+idstr+'" value="'+list[key]["cdCode"]+'" '+checked2+' '+disable+' >';
			radiostr += '	<input type="checkbox" name="'+name+'" id="'+list[key]["cdCode"]+'" value="'+list[key]["cdCode"]+'" '+checked+' '+disable+'>';
			radiostr += '	<label for="marking-'+idstr+'">'+list[key]["cdDesc"]+'</label>';
			radiostr += '</li>';

			i++;

		}

		$("#"+pgid).html(radiostr);
	}
    function makepage(json)
    {
    	var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="packingdesc")
		{
			parseradiocodes("selcatetdDiv", obj["pbTypeList"], '<?=$txtdt["1132"]?>', "pbType", "pbtype-list", obj["pbType"]);//분류
			//20191218 : 포장재마킹 
			$("input[name=pbCodeonly]").val(obj["pbchk"]);
			parsemarkingcodes("mrDescDiv", obj["mrDescList"], '<?=$txtdt["1077"]?>','mrDesc', 'mrDesc', obj["pbchk"]);
				
			var newpbDate = getNewDate();
			var newpbCode = getNowFull(2);
			var pbCode = (!isEmpty(obj["pbCode"])) ? obj["pbCode"] : "PCB"+newpbCode;
			var pbDate = (!isEmpty(obj["pbDate"])) ? obj["pbDate"] : newpbDate;

			$("input[name=pbseq]").val(obj["seq"]); //포장재명
			$("input[name=pbTitle]").val(obj["pbTitle"]); //포장재명
			$("input[name=pbCode]").val(pbCode); //포장재코드
			$("input[name=pbMember]").val(obj["miUserid"]); //한의원
			$("input[name=miName]").val(obj["miName"]); //한의원
			/*
			var miName="";
			var mediinfo="";
			console.log(obj["miName"]);
			if(obj["miName"]!="" && obj["miName"]!=null){
				miName=obj["miName"].split(",");
				for(var i=0;i<miName.length;i++){
					if(miName[i]!=""){
						mediinfo+="<span class='meditit'>"+miName[i]+" <i class='delmedi' onclick=\"deletemedical('"+i+"')\">X</i></span>"
					}
				}
			}
			$("#miName").html(mediinfo); //한의원
			*/
			$("input[name=pbStaff]").val(obj["pbStaff"]); //담당자
			$("input[name=pbPrice]").val(obj["pbPrice"]); //가격
			$("input[name=pbPriceA]").val(obj["pbPriceA"]); //가격
			$("input[name=pbPriceB]").val(obj["pbPriceB"]); //가격
			$("input[name=pbPriceC]").val(obj["pbPriceC"]); //가격
			$("input[name=pbPriceD]").val(obj["pbPriceD"]); //가격
			$("input[name=pbPriceE]").val(obj["pbPriceE"]); //가격
			$("input:radio[name=allPbMember]:input[value="+obj["pbAll"]+"]").prop("checked", true);
			$("input[name=pbCapa]").val(obj["pbCapa"]); //팩용량 

			$("input[name=pbVolume]").val(obj["pbVolume"]); //부피
			$("input[name=pbMaxcnt]").val(obj["pbMaxcnt"]); //최대팩수

			if(obj["pbType"]=="reBoxmedi")
			{
				$('#pbVolumeth span').addClass('nec'); 
				$('#pbMaxcntth span').addClass('nec');		
			}
			else
			{	
				$('#pbVolumeth span').removeClass('nec'); 
				$('#pbMaxcntth span').removeClass('nec');		
			} 
			CodeRadio("GradeDiv", obj["pbGradeList"],'<?=$txtdt["1894"]?>',"pbGrade","pbGrade-list", obj["pbGrade"])  //등급 

			//$("#pbDate").text(pbDate); //등록일
			$("textarea[name=pbDesc]").text(obj["pbDesc"]); //설명


			if(!isEmpty(obj["seq"]))
			{
				var barHtml = '';
				barHtml='<a href="javascript:;" onclick="printbarcode(\'label\',\''+obj["pbType"]+'|'+obj["seq"]+'\',500)" ><button class="sp-btn"><span>+ <?=$txtdt["1098"]?><!-- 바코드출력 --></span></button></a>';//<!-- 바코드출력 -->
				$("#bpDiv").html(barHtml);
			}

			var btnHtml='';
			var json = "seq="+obj["seq"];


			var Auth = $("input[name=modifyAuth]").val();

			if(Auth=="true" || Auth=="admin")
			{		
				btnHtml='<a href="javascript:;" onclick="packingupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
				btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
				if(!isEmpty(obj["seq"]))
					btnHtml+='<a href="javascript:;" onclick="callapidel(\'inventory\',\'packingdelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기
			}
			else
			{
				btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
			}

			$("#btnDiv").html(btnHtml);
			//var seq = isEmpty(obj["seq"]) ? "0" : obj["seq"];

			console.log("setFileCodesetFileCodesetFileCodesetFileCode");
			setFileCode("packingbox", pbCode, $("input[name=pbseq]").val());

			console.log("pbCode = " + pbCode);

			//upload된 이미지가 있다면
			if(!isEmpty(obj["afFiles"]))
			{
				console.log(">>>>>>>>>>>>>>>>"+JSON.stringify(obj["afFiles"]))
				handleImgFileSelect(obj["afFiles"]);
			}
			return false;
		}
		else if(obj["apiCode"]=="medicallist") //한의원리스트
		{
			$("#pop_medicaltbl tbody").html("");
			var data = "";
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["miUserid"]+'" data-name="'+value["miName"]+'" data-etc="'+value["miDoctor"]+'">';
					data+='<td>'+value["miName"]+'</td>';
					data+='<td>'+value["miPersion"]+'</td>';
					data+='<td>'+value["miBusinessno"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			//한의원리스트
			$("#pop_medicaltbl tbody").html(data);

			//페이징
			getsubpage_pop("medicallistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
	}

	function deletemedical(no){
		$(".meditit").eq(no).css({"text-decoration":"line-through"});
		var userid=$("input[name=pbMember]").val().split(",");
		var medicode="";
		for(var i=0;i<userid.length;i++){
			if(medicode!="")medicode+=",";
			if(i != no){
				medicode+=userid[i];
			}else{
				medicode+="0000";
			}
		}
		$("input[name=pbMember]").val(medicode);
	}

	callapi('GET','inventory','packingdesc','<?=$apidata?>'); 	//포장재등록 API 호출
	$("input[name=pbTitle]").focus();
</script>
