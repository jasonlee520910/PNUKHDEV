<?php //약재입고등록 상세내용
	$root = "../..";
	include_once $root."/_common.php";
	$upload=$root."/_module/upload";
	include_once $upload."/upload.lib.php";

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

<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>


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
<input type="hidden" name="apiCode" class="reqdata" value="instockupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Stock/InStockList.php">
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
				<td colspan="3"><div id="whCategoryInStockDiv" style="float:left;width:90%;"></div></td>
			</tr>
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
					<span class="nec">제조번호<?//=$txtdt["1895"]?><!-- 규격 --></span>
				</th>
				<td>
					<input type="text" name="whSerialno" value="" title="<?=$txtdt["1261"]?>" class="necdata reqdata"/>
				</td>
				<th>
					<span class="nec">시험번호<?//=$txtdt["1261"]?><!-- 입고담당자 --></span>
				</th>
				<td>
					<input type="text" name="whTrialno" value="" title="<?=$txtdt["1261"]?>" class="necdata reqdata" />
				</td>
			</tr>
			<tr>
				<th>
					<span class="nec"><?=$txtdt["1895"]?><!-- 규격 --></span>
				</th>
				<td>
					<input type="text" name="whStandard" value="" title="<?=$txtdt["1895"]?>" class="necdata reqdata"/>
				</td>
				<th>
					<span class="nec"><?=$txtdt["1261"]?><!-- 입고담당자 --></span>
				</th>
				<td>
					<input type="text" name="whStaff" value="" class="necdata reqdata" title="<?=$txtdt["1261"]?>" readonly/>
					<input type="text" name="whName" value="" title="<?=$txtdt["1261"]?>" readonly/>
				</td>
			</tr>
			<tr>
				<th>
					<span class="nec"><?=$txtdt["1045"]?><!-- 규격 --></span>
				</th>
				<td>
					<select name="whEtc" title="<?=$txtdt["1045"]?>" style="width:200px;margin-right:20px;" class="necdata reqdata">
						<option value="" selected>선택
						<option value="0001">바른본초원
						<option value="0002">주식회사 내몸에~
						<option value="0003">광명당
						<option value="9999">기타
					</select><div style="display:inline-block;"><a href="javascript:;" onclick="alert('등록준비중입니다.');" class="sp-btn"><span>납품처 등록하기</span></a></div>
				</td>
				<th></th>
				<td></td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1248"]?><!-- 이미지첨부--></span>
				</th>
				<td colspan="3">
					<?=upload("instock",$_COOKIE["ck_stStaffid"],$_COOKIE["ck_language"])?>
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

	<div class="btn-box c" id="btnDiv">

	</div>
</div>

<!--// page end -->


<script>
	function instockupdate()
	{
		
		$("input[name=whEtcaddress]").val($("input[name=addr1]").val()+"||"+$("input[name=addr2]").val());
		$("input[name=whEtcphone]").val($("input[name=whEtcphone1]").val()+"-"+$("input[name=whEtcphone2]").val()+"-"+$("input[name=whEtcphone3]").val());

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
			callapi("POST","stock","instockupdate",jsondata);
			$("#btnDiv a").eq(0).attr("onclick","alert('<?=$txtdt['1885']?>')").children("span").text("<?=$txtdt['1884']?>");//저장중으로 버튼 바뀜
			//viewlist();
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

		if(obj["apiCode"]=="instockdesc") //약재입고등록
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


			parseradiocodes("whCategoryInStockDiv", obj["whCategoryInStockList"], '<?=$txtdt["1132"]?>', "whCategory", "whCategory-list", obj["whCategory"], 'readonly');
			parseradiocodes("whStatusInStockDiv", obj["whStatusInStockList"], '<?=$txtdt["1164"]?>', "whStatus", "medi-list", obj["whStatus"]);


			var btnHtml='';
			var json = "seq="+obj["seq"];

			btnHtml='<a href="javascript:;" onclick="instockupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
			btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록

			$("#btnDiv").html(btnHtml);


			btnHtml='<a href="javascript:;" onclick="instockupdate();" class="sdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기

			console.log("setFileCodesetFileCodesetFileCodesetFileCode");
			var whCode=	$("input[name=whCode]").val(); 
			console.log("whCode   >>> "+whCode);
			setFileCode("instock", whCode, $("input[name=seq]").val());



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


	callapi('GET','stock','instockdesc','<?=$apidata?>'); 	//약재입고등록 상세 API 호출

	$("input[name=whTitle]").focus();
</script>
