<?php //약재입고등록 상세내용
	$root = "../..";
	include_once $root."/_common.php";
	$upload=$root."/_module/upload";
	include_once $upload."/upload.lib.php";

	$apidata="seq=".$_GET["seq"];
	//echo $apidata;
?>
<style type="text/css">
	.whCodeLeft {width:210px;float:left;margin-right:10px;}
	.whCodeRight {width:200px;float:left;}
</style>


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
<input type="hidden" name="seq" class="reqdata" value="">
<input type="hidden" name="whCode" class="reqdata" value="">
<input type="hidden" name="apiCode" class="reqdata" value="instockupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Stock/InStockList.php">


<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>

<!--// page start -->
<div class="list-select">
	<p class="fl">
	</p>
	<p class="fr">
		<a href="javascript:;" onclick="viewdetaildesc('add')"><button class="btn-blue"><span>+ <?=$txtdt["1208"]?><!-- 약재입고 --></span></button></a>
	</p>
</div>
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
				<td colspan="3" id="whCategoryInStockDiv"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1204"]?><!-- 약재명 --></span></th>
				<td id="mdTitle">
				</td>
				<th><span class="nec"><?=$txtdt["1264"]?><!-- 입고일 --></span></th>
				<td id="whDate">
				</td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1266"]?><!-- 입고품명 --></span></th>
				<td id="whTitle"></td>
				<th><span class="nec"><?=$txtdt["1265"]?><!-- 입고코드 --></span></th>
				<td><div class="whCodeLeft" id="whCodeTxt"></div><div id="bpDiv" class="whCodeRight"></div></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1237"]?><!-- 원산지 --></span></th>
				<td id="mdOrigin"></td>
				<th><span class=""><?=$txtdt["1288"]?><!-- 제조사 --></span></th>
				<td id="mdMaker"></td>
			</tr>
			<tr>
				<th><span class="nec"><?=$txtdt["1262"]?><!-- 입고량 --></span></th>
				<td id="whQty"></td>
				<th><span class="nec"><?=$txtdt["1037"]?><!-- 금액 --></span></th>
				<td id="whPrice"></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1164"]?><!-- 상태 --></span></th>
				<td id="whStatusInStockDiv"></td>
				<th><span class="nec"><?=$txtdt["1242"]?><!-- 유통기한 --></span></th>
				<td id="whExpired"></td>
			</tr>
			<tr>
				<th><span  class="nec">제조번호<?//=$txtdt["1164"]?><!-- 상태 --></span></th>
				<td id="whSerialnoDiv"></td>
				<th><span class="nec">시험번호<?//=$txtdt["1242"]?><!-- 유통기한 --></span></th>
				<td id="whTrialnoDiv"></td>
			</tr>
			<tr>
				<th>
					<span class="nec"><?=$txtdt["1895"]?><!-- 규격 --></span>
				</th>
				<td id="whStandardDiv">
				</td>
				<th>
					<span class="nec"><?=$txtdt["1261"]?><!-- 입고담당자 --></span>
				</th>
				<td id="whStaff">
				</td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1248"]?><!-- 이미지첨부--></span>
				</th>
				<td colspan="3" id="instockDiv">
					<?=upload("instock",$_COOKIE["ck_stStaffid"],$_COOKIE["ck_language"])?>
				</td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1029"]?><!-- 관리자 메모 --></span>
				</th>
				<td colspan="3" id="whMemo">
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
				<td id="whEtc"></td>
				<th><span class=""><?=$txtdt["1046"]?><!-- 납품코드 --></span></th>
				<td id="whEtccode"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1054"]?><!-- 담당자 --></span></th>
				<td id="whEtcstaff"></td>
				<th><span class=""><?=$txtdt["1225"]?><!-- 연락처 --></span></th>
				<td id="whEtcphone"></td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1307"]?><!-- 주소 --></span></th>
				<td colspan="3" id="whEtcaddress">
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btn-box c" id="btnDiv">

	</div>
</div>

<!--// page end -->


<script>
	function repageload(){
	console.log("no  repageload ");
	}

	function viewdetaildesc(seq)
	{
		console.log("상세보기 seq    :"+seq);
		if(seq=='add')
		{
			var hdata=location.hash.replace("#","").split("|");
			var page=hdata[0];
			if(page==undefined){page="";}
			var search=hdata[2];
			if(search ===undefined){search="";}
			makehash(page,seq,search)
			$("#listdiv").load("<?=$root?>/Skin/Stock/InStockWrite.php?seq="+seq);
		}
		else
		{
			viewdesc(seq);
		}	
	}

	function instockcancelupdate()
	{
		var data="code="+$("input[name=whCode]").val();
		callapi("GET","stock","checkoutstock",data);
		$("#btnDiv a").eq(0).attr("onclick","alert('<?=$txtdt['1885']?>')").children("span").text("<?=$txtdt['1884']?>");
/*
		if(!confirm("<?=$txtdt['1681']?>")){return;}//입고취소를 하시겠습니까?

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

			callapi("POST","stock","instockcancelupdate",jsondata);
		}
		*/

	}
    function makepage(json)
    {
		console.log("makepage ----------------------------------------------- start")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])

		if(obj["apiCode"]=="instockdesc") //약재입고등록
		{
			$("input[name=seq").val(obj["seq"]);//seq

			$("#whStock").text(obj["whStock"]); //약재코드
			$("#mdTitle").text(obj["mdTitle"]); //약재명
			$("#whTitle").text(obj["whTitle"]); //입고품명

			var whDate = (isEmpty(obj["whDate"])) ? getNewDate() : obj["whDate"];
			$("#whDate").text(whDate); //입고일

			var date1 = '<?=date("YmdHis")?>';
			var whCode = (!isEmpty(obj["whCode"])) ? obj["whCode"] : "STO"+date1;
			$("#whCodeTxt").text(whCode); //입고코드
			$("input[name=whCode]").val(whCode);


			$("#mdOrigin").text(obj["mdOrigin"]); //원산지
			$("#mdMaker").text(obj["mdMaker"]); //제조사
			var whQty = !isEmpty(obj["whQty"]) ? comma(obj["whQty"]) : "0";
			$("#whQty").text(whQty+" g"); //입고량

			var whprice = !isEmpty(obj["whPrice"]) ? comma(obj["whPrice"]) : "0";
			$("#whPrice").text(whprice+' <?=$txtdt["1235"]?>');//금액

			$("#whExpired").text(obj["whExpired"]); //유통기한

			$("#whSerialnoDiv").text(obj["whSerialno"]); //유통기한
			$("#whTrialnoDiv").text(obj["whTrialno"]); //유통기한
			$("#whStandardDiv").text(obj["whStandard"]); //유통기한


			$("#whMemo").text(obj["whMemo"]); //관리자메모

			//$("input[name=whStatus]").val(obj["whStatus"]); //상태

			stUserid = isEmpty(obj["stUserid"]) ? "":obj["stUserid"];
			stName = isEmpty(obj["stName"]) ? "":obj["stName"];
			$("#whStaff").text(stUserid); //입고담당자
			$("#whName").text(stName); //입고담당자

			$("#whEtc").text(obj["whEtc"]); //납품처
			$("#whEtccode").text(obj["whEtccode"]); //납품코드
			$("#whEtcstaff").text(obj["whEtcstaff"]); //담당자
			$("#whEtcphone").text(obj["whEtcphone"]); //연락처

			var addr = isEmpty(obj["whEtcaddress"]) ? "":obj["whEtcaddress"];
			addr = addr.replace("||", " ");
			var zipcode = isEmpty(obj["whEtczipcode"]) ? "" : "["+obj["whEtczipcode"]+"]";
			$("#whEtcaddress").text(zipcode+addr); //주소

			if(!isEmpty(obj["seq"]) && obj["whStatus"] != 'cancel')
			{
				var barHtml = '';
				barHtml='<a href="javascript:;" onclick="printbarcode(\'label\',\'stock|'+obj["seq"]+'\',500)" ><button class="sp-btn"><span>+ <?=$txtdt["1098"]?><!-- 바코드출력 --></span></button></a>';//<!-- 바코드출력 -->
				$("#bpDiv").html(barHtml);
			}

			var category = isEmpty(obj["whCategory"]) ? "basic" : obj["whCategory"];
			getListData("whCategoryInStockDiv", obj["whCategoryInStockList"], category);
			getListData("whStatusInStockDiv", obj["whStatusInStockList"], obj["whStatus"]);  //상태


			var btnHtml='';
			var json = "seq="+obj["seq"];
			if(obj["whStatus"]!="cancel" && obj["cancelStatus"]=="false")
				btnHtml+='<a href="javascript:;" onclick="instockcancelupdate();" class="bdp-btn"><span><?=$txtdt["1680"]?></span></a> ';//입고취소

			btnHtml+='<a href="javascript:;" onclick="golistload();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록

			$("#btnDiv").html(btnHtml);


			console.log("setFileCodesetFileCodesetFileCodesetFileCode");
			var whCode=	$("input[name=whCode]").val(); 
			console.log("whCode   >>> "+whCode);
			setFileCode("instock", whCode, $("input[name=seq]").val());

			//upload된 이미지가 있다면
			if(!isEmpty(obj["afFiles"]))
			{
				console.log(">>>>>>>>>>>>>>>>"+JSON.stringify(obj["afFiles"]))
				handleImgFileSelect(obj["afFiles"]);
			}
			return false;


	//instockDiv
		}
		else if(obj["apiCode"]=="checkoutstock")
		{
			if(obj["CHKOUT"]=="OUTCANCELOK")
			{
				if(!confirm("<?=$txtdt['1681']?>")){return;}//입고취소를 하시겠습니까?

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

					callapi("POST","stock","instockcancelupdate",jsondata);
				}
			}
			else if(obj["CHKOUT"]=="OUTCANCELFAIL")
			{
				alertsign('warning',"<?=$txtdt['1881']?>",'instockconfirm',"");//출고한 내역이 있어 입고취소를 하실수 없습니다.|출고취소 후 입고취소를 해주세요.
			}
		}
		

        return false;
    }


	callapi('GET','stock','instockdesc','<?=$apidata?>'); 	//약재입고등록 상세 API 호출

</script>
