<?php 
	$root = "../..";
	include_once $root."/_common.php";
	$type=($_GET["type"]) ? $_GET["type"]:"N";
	$seq=$_GET["seq"];

	if($seq==="add")
	{
		$apiOrderData="seq=write";
	}
	else if($seq==="addg")
	{
		$apiOrderData="seq=write";
	}
	else
	{
		$apiOrderData="seq=".$_GET["seq"];
	}
?>
<style>
	.table_style { width: 100%; }
	.table_style ul { clear: left; margin: 0;  padding: 0; list-style-type: none; }
	.table_style ul li { float: left; margin: 0; padding: 2px 1px;}
	.table_style ul .left { width: 130px; }

	.td_text_overflow {overflow:hidden;white-space : nowrap;text-overflow: ellipsis;}

	.pack-list11 {overflow:hidden; margin:0 -1%;}
	.pack-list11 li{ float:left;width:10%; margin:0 1% 1% 1%;text-align:left;height:170px;}
	.pack-list11 li .check-box{display:block}
	.pack-list11 li .check-box span{ display:block;text-align:center;}
	.pack-list11 li .check-box .btxt{padding-top:7px;font-size:13px;}
	.pack-list11 li .check-box .stxt{color:#949494}
	.pack-list11 li .check-box label{display:block; padding:0;}
	.pack-list11 li .check-box img{width:100%; height:100px;border:1px solid #d7d7d7;box-sizing:border-box}
`
	span.mdtype{display:inline-block;width:15px;height:15px;border-radius:50%;margin-right:5px;line-height:100%;vertical-align:middle;}
	.mdsweet{background-color:#f2C2D6;}
	.mdmedi{background-color:#8BE0ED;}
	.sugar{background-color:#01DF74;}

	#td_odCode{font-size:19px;font-weight:bold;color:#000;}
	#tdMediTitle {float:left;width:30px;}
	#tdMedi {display: inline-block;width: 18px;height: 18px;cursor: pointer;}

	#meGenderDiv ul li{width:auto;}
	#maTypeDiv ul li{width:auto;}
</style>

<input type="hidden" name="apiCode" class="reqdata" value="orderupdate">

<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="rcSeq" class="reqdata" value="<?=$_GET["rcSeq"];?>">
<input type="hidden" name="odCode" class="reqdata" value="<?=$_GET["odCode"];?>">
<input type="hidden" name="odKeycode" class="reqdata" value="<?=$_GET["odKeycode"];?>">
<input type="hidden" name="odGoods" class="reqdata" value="<?=$type?>">
<input type="hidden" name="odStatus" class="reqdata" value="">
<input type="hidden" name="od_canceltype" class="reqdata" value="">
<input type="hidden" name="restarttxt" class="reqdata" value="">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Order/OrderList.php">

<!-- djmedi 주문금액 json data -->
<textarea name="odAmountdjmedi" class="reqdata"  style="display:none;"></textarea> 

<!-- 배송정보에서 보내는 사람 기본 선택시 들어갈 사이트 정보  -->
<input type="hidden" name="cfCompany" class="" value="">
<input type="hidden" name="cfPhone" class="" value="">
<input type="hidden" name="cfStaffmobile" class="" value="">
<input type="hidden" name="cfZipcode" class="" value="">
<input type="hidden" name="cfAddress" class="" value="">

<input type="hidden" name="odSitecategory" class="" value="">

<!-- 20190917 : 조제비,탕전비,배송비 json data -->
<textarea name="odAllPrice" class="" style="display:none;"></textarea>
<input type="hidden" name="maPrice" class="reqdata" value=""><!-- 조제비 -->
<input type="hidden" name="dcPrice" class="reqdata" value=""><!-- 탕전비 -->
<input type="hidden" name="rePrice" class="reqdata" value=""><!-- 배송비 -->
<input type="hidden" name="firstPrice" class="reqdata" value=""><!-- 선전비 -->
<input type="hidden" name="afterPrice" class="reqdata" value=""><!-- 후하비 -->
<input type="hidden" name="packPrice" class="reqdata" value=""><!-- 포장비 -->

<!-- 물량 계산하기 위한 정보 -->
<input type="hidden" name="packaddcnt" class="" value="<?=$BASE_ADDPACK?>">
<input type="hidden" name="base_nok_dctime" class="" value="<?=$BASE_NOK_DCTIME?>">
<input type="hidden" name="base_dctime" class="" value="<?=$BASE_DCTIME?>">

<!-- 100팩당1박스 -->
<input type="hidden" name="reBox" class="reqdata" value="0">
<!-- 한약박스50팩당1박스 -->
<input type="hidden" name="reBoxmedibox" class="reqdata" value="">

<input type="hidden" name="recipeChubCnt" class="" value="">
<input type="hidden" name="recipePackcnt" class="" value="">

<textarea name="jsobj" style="display:none;"></textarea>

<textarea name="rcPillorder" class="reqdata " style="display:none;"></textarea>

<!-- 주문내역 -->
<div class="board-view-wrap" id="orderinfo"></div>

<!-- 환자정보 -->
<div class="board-view-wrap" id="orderpatient"></div>

<!-- 주문자요청사항 -->
<div class="gap"></div>
<h3 class="u-tit02"><?=$txtdt["1292"]?></h3>
<div class="order-txt">
	<textarea name="odRequest" class="reqdata" style="margin: 0px; width: 100%; height: 80px;"></textarea>
</div>


<!-- 약재리스트 -->
<div class="board-list-wrap" id="ordermedicine"></div>

<div id="orderpill">
	<?=inputpill();?>
</div>

<!-- 탕전 & 제환  -->
<div id="ordermatype"></div>

<!-- 배송정보, 복약지도 -->
<div class="order-box">
	<div class="fl">
		<!-- 배송정보 -->
		<div id="orderrelease"></div>
	</div>
	<div class="fr">
		<!-- 복약지도 -->
		<div id="orderadvice"></div>
	</div>
</div>

<!-- 주문금액 -->
<div id="orderamount"></div>

<!-- 취소 -->
<div class="gap"></div>
<div id="addDiv"></div>

<!-- 버튼 -->
<div class="gap"></div>
<div class="btn-box c" id="btnDiv" ></div>



<!-- 각 페이지 로드하는 함수 -->
<script>
	/// 사전조제인지 체크 
	function chkGWrite()
	{
		var odGoods=$("input[name=odGoods]").val();
		if(odGoods==="G")///사전인지
		{
			return true;
		}
		return false;
	}
	//조제타입 
	function chkMatype()
	{
		var matype = $('input:radio[name="maType"]:checked').val();
		matype=!isEmpty(matype)?matype:"decoction";
		return matype;
	}
	function advicechange()
	{
		var odAdvice=$("select[name=odAdvice]").val();
		$("input[name=odAdvicekey]").val(odAdvice);
		if(!isEmpty(odAdvice)&&parseInt(odAdvice)>0)
		{
			$("#odAdviceDownload").show();
			var afName=$("select[name=odAdvice]").children("option:selected").data("afname");
			var afSize=$("select[name=odAdvice]").children("option:selected").data("afsize");
			var afUrl=$("select[name=odAdvice]").children("option:selected").data("afurl");
			console.log("odAdvice == " + odAdvice+", afName = " + afName+", afSize = " + afSize+", afUrl = " + afUrl);
			$("#adfile").attr('href','/_module/download/fileDown.php?filename='+encodeURI(afName)+'&imgurl='+encodeURI(getUrlData("FILE_DOMAIN")+afUrl)+"&imgsize="+afSize);
		}
		else
		{
			$("#odAdviceDownload").hide();
		}
	}

	//복약지도 
	function loadAdviceData()
	{
		var obj = JSON.parse($("textarea[name=jsobj]").val());
		$("#odAdviceDiv").hide();
		$("#odAdviceDownload").hide();
		$("input[name=odAdvicekey]").val("");
		if(!isEmpty(obj["odSitecategory"])&&obj["odSitecategory"]=="MEDICAL")
		{
			$("#odAdviceDiv").show();
			//복약지시
			$("#odAdviceDiv").html("");
			var txt="<select class='reqdata resetcode w60p' name='odAdvice' id='odAdvice' onchange='advicechange();'>";
			txt+='<option value="0">선택안함</option>';
			$.each(obj["odAdviceList"], function(idx, val){
				var seq=val["mdSeq"];
				var title=val["mdTitle"];
				var contents=val["mdContents"];

				var afName=val["afName"];
				var afSize=val["afSize"];
				var afUrl=val["afUrl"];
				txt+='<option value="'+seq+'"  data-afname="'+afName+'" data-afurl="'+afUrl+'" data-afsize="'+afSize+'">'+title+'</option>';

			});
			txt+="</select>";
			$("#odAdviceDiv").html(txt);

			if(!isEmpty(obj["odAdvicekey"]))
			{
				$("input[name=odAdvicekey]").val(obj["odAdvicekey"]);
				$("#odAdviceDiv option[value="+obj["odAdvicekey"]+"]").attr("selected", "selected");
				if(!isEmpty(obj["odAdvicekey"]))
				{
					$("#odAdviceDownload").show();
					$("#adfile").attr('href','/_module/download/fileDown.php?filename='+encodeURI(obj["afAdviceName"])+'&imgurl='+encodeURI(getUrlData("FILE_DOMAIN")+obj["afAdviceUrl"])+"&imgsize="+obj["afAdviceSize"]);
				}
			}
		}

//selstr='<select title="'+title+'" class="reqdata resetcode '+width+'" name="'+name+'" id="'+name+'" onchange="codeChange(this);" '+disable+' >';

		//조제지시 
		/*
		$("#odCommentDiv").html("");
		var txt="<select class='reqdata resetcode w60p' name='adComment' id='adComment'>";
		txt+='<option value="">선택안함</option>';
		$.each(obj["odCommentList"], function(idx, val){
			var seq=val["mdSeq"];
			var title=val["mdTitle"];
			var contents=val["mdContents"];
			txt+='<option value="'+seq+'">'+title+'</option>';
		});
		txt+="</select>";
		$("#odCommentDiv").html(txt);
		if(!isEmpty(obj["odCommentkey"]))
		{
			console.log("조제지시 ==> "+obj["odCommentkey"]);
			$("#odCommentDiv option[value="+obj["odCommentkey"]+"]").attr("selected", "selected");
		}
		*/


		//parsecodes("odAdviceDiv", obj["odAdviceList"], '<?=$txtdt["1119"]?>', 'odCare', 'odCare', obj["odCare"], '<?=$txtdt["1484"]?>');

		
		//==================================
		//	복약방법코드
			//parsecodes("odCareDiv", obj["odCareList"], '<?=$txtdt["1119"]?>', 'odCare', 'odCare', obj["odCare"], '<?=$txtdt["1484"]?>');
		//==================================

		//==================================
		//	복약지도코드 : selAdviceList
			//parsecodes("selAdviceDiv", obj["selAdviceList"], '<?=$txtdt["1119"]?>','selAdvice', 'selAdvice', obj["selAdvice"], '<?=$txtdt["1484"]?>');
		//==================================

		//==================================
		// 복약지도 textarea
			$("textarea[name=odAdvice]").val(obj["odAdvice"]);
		//==================================
	}
	//배송정보
	function loadReleaseData()
	{
		var obj = JSON.parse($("textarea[name=jsobj]").val());
		
		//==================================
		// 보내는사람
			//이름
			$("input[name=reSendName]").val(obj["reSendname"]);
			//전화번호
			var sphone=sphone1=sphone2=sphone3=smobile=smobile1=smobile2=smobile3="";
			if(!isEmpty(obj["reSendphone"]))
			{
				var addr=obj["reSendphone"].split("-");
				sphone=obj["reSendphone"];
				sphone1=addr[0];
				sphone2=addr[1];
				sphone3=addr[2];
			}
			$("input[name=reSendPhone]").val(sphone);
			$("input[name=reSendPhone1]").val(sphone1);
			$("input[name=reSendPhone2]").val(sphone2);
			$("input[name=reSendPhone3]").val(sphone3);

			//휴대전화 
			if(!isEmpty(obj["reSendmobile"]))
			{
				var addr=obj["reSendmobile"].split("-");
				smobile=obj["reSendmobile"];
				smobile1=addr[0];
				smobile2=addr[1];
				smobile3=addr[2];
			}
			$("input[name=reSendMobile]").val(smobile);
			$("input[name=reSendMobile1]").val(smobile1);
			$("input[name=reSendMobile2]").val(smobile2);
			$("input[name=reSendMobile3]").val(smobile3);

			
			//우편번호
			$("input[name=reSendZipcode]").val(obj["reSendzipcode"]);
			//주소 
			$("input[name=reSendAddress]").val(obj["reSendaddress"]);
			$("input[name=reSendAddress1]").val(obj["reSendaddress1"]);
		//==================================

		//==================================
		// 받는사람
			//이름 
			$("input[name=reName]").val(obj["reName"]);
			console.log(obj["rePhone"]);
			var phone=phone1=phone2=phone3=mobile=mobile1=mobile2=mobile3="";
			//전화번호 
			if(!isEmpty(obj["rePhone"]))
			{
				var addr = obj["rePhone"].split("-");
				phone=obj["rePhone"];				
				phone1=addr[0];
				phone2=addr[1];
				phone3=addr[2];
			}
			$("input[name=rePhone]").val(phone);//전화번호
			$("input[name=rePhone1]").val(phone1);
			$("input[name=rePhone2]").val(phone2);
			$("input[name=rePhone3]").val(phone3);

			//휴대전화 
			console.log(obj["reMobile"]);
			if(!isEmpty(obj["reMobile"]))
			{
				var addr = obj["reMobile"].split("-");
				mobile=obj["reMobile"];
				mobile1=addr[0];
				mobile2=addr[1];
				mobile3=addr[2];
			}
			$("input[name=reMobile]").val(mobile);//휴대폰번호
			$("input[name=reMobile1]").val(mobile1);
			$("input[name=reMobile2]").val(mobile2);
			$("input[name=reMobile3]").val(mobile3);
			//우편번호 
			$("input[name=reZipcode]").val(obj["reZipcode"]);
			//주소 
			$("input[name=reAddress]").val(obj["addr1"]);
			$("input[name=reAddress1]").val(obj["addr2"]);//상세주소
		//==================================

		//==================================
		// 배송요청사항 
			$("input[name=reRequest]").val(obj["reRequest"]);//배송요구사항
		//==================================

		console.log("배송방법 : " + obj["reDelitype"]);
		//배송송방법
		parseradiocodes("reDelitypeDiv", obj["reDelitypeList"], '<?=$txtdt["1111"]?>', "reDelitype", "delitype-list", obj["reDelitype"]);

		//보내는사람
		parseradiocodes("reSendTypeDiv", obj["reSendTypeList"], '<?=$txtdt["1852"]?>', "reSendType", "resendtype-list", obj["reSendType"]);
		//$('input:radio[name="reSendType"]:checked').click();
	}
	//공통으로 쓰이는 기본정보 
	function loadInfoData(type, obj)
	{
		//주문코드
		var odCode=!isEmpty(obj["odCode"])?obj["odCode"]:"New Order";
		$("#td_odCode").text(odCode);
		var miGrade=miMobile=miName=miZipcode=miAddress=odUserid=odStaff=odStaffName="";

		if(type=="G")
		{
			miGrade=!isEmpty(obj["miGrade"]) ? obj["miGrade"] : "A";
			miMobile=!isEmpty(obj["miPhone"]) ? obj["miPhone"] : "031-111-5555";
			miName=!isEmpty(obj["miName"]) ? obj["miName"] : "부산대공용";
			miZipcode=!isEmpty(obj["miZipcode"]) ? obj["miZipcode"] : "";
			miAddress=!isEmpty(obj["miAddress"]) ? obj["miAddress"] : "";
			odUserid=!isEmpty(obj["odUserid"]) ? obj["odUserid"] : "1000000000";

			//처방자
			odStaff=!isEmpty(obj["odStaff"]) ? obj["odStaff"] : "1000000000";
			odStaffName=!isEmpty(obj["odStaffName"]) ? obj["odStaffName"] : "부산대약사";

		}
		else
		{
			miGrade=!isEmpty(obj["miGrade"]) ? obj["miGrade"] : "";
			miMobile=!isEmpty(obj["miPhone"]) ? obj["miPhone"] : "";
			miName=!isEmpty(obj["miName"]) ? obj["miName"] : "";
			miZipcode=!isEmpty(obj["miZipcode"]) ? obj["miZipcode"] : "";
			miAddress=!isEmpty(obj["miAddress"]) ? obj["miAddress"] : "";
			odUserid=!isEmpty(obj["odUserid"]) ? obj["odUserid"] : "";

			//처방자
			odStaff=!isEmpty(obj["odStaff"]) ? obj["odStaff"] : "";
			odStaffName=!isEmpty(obj["odStaffName"]) ? obj["odStaffName"] : "";
		}

		$("#miNamediv").text(miName);//한의원명 
		$("input[name=miName]").val(miName);//한의원코드
		$("input[name=odUserid]").val(odUserid);//한의원코드
		$("input[name=miGrade]").val(miGrade);//한의원등급
		$("input[name=miZipcode]").val(miZipcode);//한의원우편번호
		$("input[name=miAddress]").val(miAddress);//한의원주소 
		$("input[name=miPhone]").val(miMobile);//한의원전화번호
		$("input[name=miMobile]").val(miMobile);//한의원핸드폰 

		$("input[name=odTitle]").val(obj["odTitle"]);//처방명
		$("input[name=odScription]").val(obj["odScription"]);//처방전

		$("#odStaffDiv").text(odStaffName);//처방자
		$("input[name=odStaff]").val(odStaff);

		if(!isEmpty(obj["seq"]))
		{
			//한의원검색
			$("#btnmedical").hide();
			//처방검색
			$("#btnrecipe").hide();
			$("#miName").attr("readonly",true);
		}
		else
		{
			//한의원검색
			$("#btnmedical").show();
			//처방검색
			$("#btnrecipe").show();
			$("#miName").attr("readonly",false);
		}

		//조제타입 
		parseradiocodes("maTypeDiv", obj["maTypeList"], "<?=$txtdt['1614']?>","maType", "maType-list", obj["odMatype"], "readonly");

	}
	//사전조제 기본정보 
	function loadGInfoData()
	{
		var obj = JSON.parse($("textarea[name=jsobj]").val());

		loadInfoData("G", obj);

		//rcSource
		console.log("rcSource::::"+obj["rcSource"]);
		$("input[name=rc_source]").val(obj["rcSource"]);
	}
	//수기처방 기본정보 
	function loadWInfoData()
	{
		var obj = JSON.parse($("textarea[name=jsobj]").val());

		loadInfoData("N", obj);

		var delidate = (isEmpty(obj["reDelidate"])) ? getNewDate() : obj["reDelidate"];
		$("input[name=reDelidate]").val(delidate);//배송희망일

		var mCheck=deliException="";
		if(!isEmpty(obj["odGoods"]) && obj["odGoods"]=="M")//첩약(약재포장)
		{
			mCheck="checked";
		}
		deliException='disabled="disabled"';
		if(isEmpty(obj["odStatus"])|| !isEmpty(obj["odStatus"]) && obj["odStatus"] =="order" || !isEmpty(obj["odStatus"])&& obj["odStatus"] =="paid")
		{
			deliException="";
		}

		var tdMedi = "<input type='checkbox' name='tdMedi' id='tdMedi' value='M' class='reqdata' "+mCheck+" "+deliException+" onclick='resetamount();'>";
		$("#tdMedi").html(tdMedi);//첩약 

		//환자구분 
		console.log("odRecipe :: " + obj["odRecipe"]);
		parseradiocodes("odPatientDiv", obj["patientTypeList"], '환자구분', "odRecipe", "maType-list", obj["odRecipe"]);

	}
	//환자정보 
	function loadPatientData()
	{
		var obj = JSON.parse($("textarea[name=jsobj]").val());

		//환자명
		$("input[name=odName]").val(obj["odName"]);
		//성별 
		parseradiocodes("meGenderDiv", obj["meSexList"], '<?=$txtdt["1888"]?>', "odGender", "resendtype-list", obj["odGender"]);
		//생년월일 
		$("input[name=odBirth]").val(obj["odBirth"]);
		if(!isEmpty(obj["odBirth"]))
		{
			var birth=obj["odBirth"].split("-");
			$("input[name=odBirth1]").val(birth[0]);
			$("input[name=odBirth2]").val(birth[1]);
			$("input[name=odBirth3]").val(birth[2]);
		}
	}
	//주문금액 
	function loadAmountData()
	{
		var obj = JSON.parse($("textarea[name=jsobj]").val());	;
		$("textarea[name=odAmountdjmedi]").val(obj["odAmountdjmedi"]);
	}
</script>

<!-- OrderWrite 함수 -->
<script>
	//등록/처방하기 
	function chart_update()
	{
		var odGoods=(chkGWrite()==true) ? "Y":"N";

		var chkmedi = $("input[name=rcMedicine]").val();
		console.log("chkmedi :: "+chkmedi);
		if(!isEmpty(chkmedi) && chkmedi.indexOf("*") >= 0)
		{
			alertsign('error',"<?=$txtdt['1835']?>",'','2000'); //등록된 약재가 없습니다. 약재 등록 후 사용하세요!
			return; 
		}

		if(isEmpty($("input[name=rcMedicine]").val()) && !isEmpty($("input[name=rcSweet]").val()))
		{
			alertsign('error',"<?=$txtdt['1909']?>",'','2000'); //별전만 주문이 불가능합니다. 약재도 추가해 주세요.
			return; 
		}

		if(odGoods==="N")
		{
			if(setBirth()==false)
			{
				alertsign("warning", "<?=$txtdt['1890']?>", "", "2000");//생년월일에 년도를 4자리로 해주세요
				return;
			}
		}

		var rcPillorder=$("textarea[name=rcPillorder]").val();
		if(chkMatype()=="pill"&&isEmpty(rcPillorder))
		{
			alertsign("warning", "구성요소를 확인해 주세요.", "", "2000");//생년월일에 년도를 4자리로 해주세요
			return;
		}

		//if(checkmaTypeMedicineCapa()) //제환은 약재용량이 3000 이상일때만 가능하게 하기위해서 체크 
		//{
		//	alertsign("warning", getMaTypeCapaText(), "", "2000");//[1] 처방은 [2]g 이상부터 주문 가능합니다. 총약재량을 확인해 주세요.
		//}
		//else
		{
			if(odGoods=="N")
			{
				setPhoneMobile();
			}

			//약재리스트 첩당약재
			if(necdata()=="Y") //필수조건 체크
			{
				$("#chartupdateid").removeAttr("onclick");
				$("#chartupdateid span").text("주문등록/수정중...");

				var key=data="";
				var jsondata={};

				var type = $('input:radio[name="maType"]:checked').val();

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

				
				var jsdata = maTypeSetting(type, jsondata);

				console.log(JSON.stringify(jsdata));

				callapi("POST","order","orderupdate",jsdata);
			}
		}
	}
	//재시작하기 
	function orderchangeupdate()
	{
		var today=new Date();
		var d=$("input[name=reDelidate]").val().split("-");
		var delidate=new Date(d[0],parseInt(d[1])-1,parseInt(d[2])+1);

		var chkmedi = $("input[name=rcMedicine]").val();
		console.log("chkmedi :: "+chkmedi);
		if(!isEmpty(chkmedi) && chkmedi.indexOf("*") >= 0)
		{
			alertsign('error',"<?=$txtdt['1835']?>",'','2000'); //등록된 약재가 없습니다. 약재 등록 후 사용하세요!
			return; 
		}

		if(isEmpty($("input[name=rcMedicine]").val()) && !isEmpty($("input[name=rcSweet]").val()))
		{
			alertsign('error',"<?=$txtdt['1909']?>",'','2000'); //별전만 주문이 불가능합니다. 약재도 추가해 주세요.
			return; 
		}

		if(setBirth()==false)
		{
			alertsign("warning", "<?=$txtdt['1890']?>", "", "2000");//생년월일에 년도를 4자리로 해주세요
			return;
		}

		//if(today > delidate)
		//{
		//	alertsign("warning", '<?=$txtdt["1113"]?>', "", "2000");/*1113::배송희망일은 주문일 이후여야 합니다.*/
		//}
		if(checkmaTypeMedicineCapa()) //제환은 약재용량이 3000 이상일때만 가능하게 하기위해서 체크 
		{
			alertsign("warning", getMaTypeCapaText(), "", "2000");//[1] 처방은 [2]g 이상부터 주문 가능합니다. 총약재량을 확인해 주세요.
		}
		else
		{
			var restarttext = $("#odRestarttext").val();
			if(isEmpty(restarttext))
			{
				alertsign("warning", "<?=$txtdt['1676']?>", "", "2000"); //재시작사유를 작성해 주세요.
			}
			else
			{
				setPhoneMobile();

				//약재리스트 첩당약재
				if(necdata()=="Y") //필수조건 체크
				{
					var key=data="";
					var jsondata={};

					var type = $('input:radio[name="maType"]:checked').val();

					console.log("chart_update  type = " + type);

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

					
					var jsdata = maTypeSetting(type, jsondata);

					console.log(JSON.stringify(jsdata));

					callapi("POST","order","orderchangeupdate",jsdata);
				}
			}
		}
	}
	//취소 
	function setOrderCancel(obj)
	{
		var addData="";
		//------------------------------------------
		// 이전주문코드
		//------------------------------------------
		if(!isEmpty(obj["odOldodcode"]))
		{
			addData += parseDivTable('<?=$txtdt["1678"]?>', obj["odOldodcode"]);
			addData+='<div class="sgap"></div>';
		}
		//------------------------------------------
		// 취소사유 && 재시작사유
		//------------------------------------------
		if(!isEmpty(obj["odStatus"]))
		{
			var cstatus = obj["odStatus"];
			if(cstatus.indexOf("_cancel") != -1)
			{
				var retxt = !isEmpty(obj["odRestarttext"]) ? obj["odRestarttext"] : "";
				var ta = '<textarea class="w100p reqdata" rows="5" name="odRestarttext" id="odRestarttext">'+retxt+'</textarea>';
				
				addData += parseDivTable('<?=$txtdt["1670"]?>', obj["cancelTypeName"] + "( "+obj["odCanceltext"]+" )");
				addData+='<div class="sgap"></div>';
				addData += parseDivTable('<?=$txtdt["1675"]?>', ta);


			}

			$("input[name=od_canceltype]").val(obj["od_canceltype"]);
			$("input[name=restarttxt]").val(obj["restarttxt"]);
		}

		$("#addDiv").html(addData);
	}
	//버튼
	function setOrderButton(obj)
	{
		//------------------------------------------
		// 버튼
		//------------------------------------------
		var btn_html = "";
		var ck_stDepart=getCookie("ck_stDepart");
		var ck_stUserid=getCookie("ck_stUserid");

		if(!isEmpty(obj["odStatus"]))
		{
			var status = obj["odStatus"];
			if(status.indexOf("_cancel") != -1){
				if(isEmpty(obj["odRestarttext"]))
					btn_html='<a href="javascript:;" onclick="orderchangeupdate();" class="bdp-btn"><span><?=$txtdt["1283"]?></span></a> ';/*"재시작하기*/
			}else if(status=="order"||status==""){
				btn_html='<a href="javascript:;" onclick="chart_update();" id="chartupdateid" class="bdp-btn"><span><?=$txtdt["1071"]?></span></a> ';/*"등록/수정하기*/
			}else if(status.substr(0,6)=="making"){
				//***********************************************************
				//20190403 done일때는 조제진행중 안나오게 하자 
				//***********************************************************
				if(status.indexOf("_done") < 0)
					btn_html='<a class="bdp-btn"><span><?=$txtdt["1294"]?></span></a> ';/*"조제진행중*/
				//***********************************************************
			}else if(status.substr(0,9)=="decoction"){
				btn_html='<a class="bdp-btn"><span><?=$txtdt["1371"]?></span></a> ';/*"탕전진행중*/
			}else if(status.substr(0,7)=="marking"){
				btn_html='<a class="bdp-btn"><span><?=$txtdt["1079"]?></span></a> ';/*"마킹진행중*/
			}else if(status.substr(0,7)=="release"){
				btn_html='<a class="bdp-btn"><span><?=$txtdt["1354"]?></span></a> ';/*"출고진행중*/
			}else if(status=="done"){
				btn_html='<a class="bdp-btn"><span><?=$txtdt["1349"]?></span></a> ';/*"출고완료*/
			}
			else
			{
				if(ck_stDepart=="pharmacist" && obj["odStatus"]=="paid" || ck_stUserid.indexOf("djmedi") != -1 && obj["odStatus"]=="paid")
				{
					btn_html='<a href="javascript:;" onclick="chart_update();" id="chartupdateid" class="bdp-btn"><span><?=$txtdt["1071"]?></span></a> ';/*"등록/수정하기*/
				}
			}
		}
		else
		{
			btn_html='<a href="javascript:;" onclick="chart_update();" id="chartupdateid" class="bdp-btn"><span><?=$txtdt["1071"]?></span></a> ';/*"등록/수정하기*/
		}

		btn_html+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';
			
		$("#btnDiv").html(btn_html);
	}
	//탕전인지제환인지 
	function changeMatype()
	{
		console.log("changeMatype orderwrite 탕제인지 제환인지 ");

		var odGoods=(chkGWrite()==true) ? "Y":"N";

		var obj = JSON.parse($("textarea[name=jsobj]").val());

		var seq=$("input[name=seq]").val();//od_seq
		var medical=$("input[name=odUserid]").val();//medical_code 
		var rc_seq=$("input[name=rc_seq]").val();//rc_seq 
		var rc_type=$("input[name=rc_type]").val();//rc_type 

		if(chkMatype()==="pill") //제환
		{
			$("#ordermedicine").html("");
			$("#orderpill").html('<?=inputpill()?>');

			$("input[name=odPillcapa]").val(obj["odPillcapa"]);
			$("input[name=odQty]").val(obj["odQty"]);

			var odPillcapa=$("input[name=odPillcapa]").val();//odPillcapa 
			var odQty=$("input[name=odQty]").val();//odQty 

		
			odPillcapa=!isEmpty(odPillcapa)?odPillcapa:0;
			odQty=!isEmpty(odQty)?odQty:0;

			pilltotalcapa=odPillcapa*odQty;
			console.log("seq : " + seq+", medical :" +medical+", rc_seq : " + rc_seq+"&rc_type : " + rc_type+", pilltotalcapa = " + pilltotalcapa);

			console.log("##############  : " + obj["odStatus"]);
			if(obj["odStatus"]=="pill_done")
			{
				$("#odPillcapa").attr("disabled", true);
				$("#odQty").attr("disabled", true);
			}


			$("#ordermatype").load("<?=$root?>/Skin/Goods/GoodsGPill.php?seq="+seq+"&medical="+medical+"&rc_seq="+rc_seq+"&rc_type="+rc_type+"&pilltotalcapa="+pilltotalcapa+"&goods="+odGoods, function(){setAmountDjmedi();});

		}
		else //탕제 
		{
			console.log("seq : " + seq+", medical :" +medical+", rc_seq : " + rc_seq+"&rc_type : " + rc_type);

			$("#orderpill").html('');
			$("#ordermatype").load("<?=$root?>/Skin/Order/OrderDecoction.php?seq="+seq+"&medical="+medical+"&rc_seq="+rc_seq+"&rc_type="+rc_type+"&goods="+odGoods, function(){resetamount();resetmedi();});
		}

	}
	function pillkeyup()
	{
		var odGoods=(chkGWrite()==true) ? "Y":"N";

		if(chkMatype()=="pill") //제환
		{
			var seq=$("input[name=seq]").val();//od_seq
			var medical=$("input[name=odUserid]").val();//medical_code 
			var rc_seq=$("input[name=rc_seq]").val();//rc_seq 
			var rc_type=$("input[name=rc_type]").val();//rc_type 
			var pillodPillcapa=$("input[name=odPillcapa]").val();
			var pillodQty=$("input[name=odQty]").val();
			var pilltotalcapa=0;

			pillodPillcapa=!isEmpty(pillodPillcapa)?pillodPillcapa:0;
			pillodQty=!isEmpty(pillodQty)?pillodQty:0;

			pilltotalcapa=pillodPillcapa*pillodQty;
			console.log("seq : " + seq+", medical :" +medical+", rc_seq : " + rc_seq+"&rc_type : " + rc_type+", pilltotalcapa = " + pilltotalcapa);
			$("#ordermatype").load("<?=$root?>/Skin/Goods/GoodsGPill.php?seq="+seq+"&medical="+medical+"&rc_seq="+rc_seq+"&rc_type="+rc_type+"&pillodPillcapa="+pillodPillcapa+"&pillodQty="+pillodQty+"&pilltotalcapa="+pilltotalcapa+"&goods="+odGoods);

		}
	}

	//첩수,팩수,팩용량 입력시
	//$("input[name=odChubcnt], input[name=odPackcnt], input[name=odPackcapa], input[name=dcTime]").keyup(function()
	//{	
	//	console.log("keyupkeyupkeyupkeyupkeyup");
	//	resetamount();
	//	resetmedi();
	//});




	//약재리스트에서 첩당약재에서 약재량 입력시
	function chubamt_keyup()
	{
		console.log("chubamt_keyupchubamt_keyupchubamt_keyupchubamt_keyup");
		resetamount();
		resetmedi();
	}
	//팝업
	function viewlayerPopup(obj)
	{
		var url=obj.getAttribute("data-bind");
		var size=obj.getAttribute("data-value");
		var odGoods=(chkGWrite()==true) ? "Y":"N";
		var data = "&page=1&psize=5&block=10&goods="+odGoods; //page,psize,block 사이즈 초기화

		console.log("url = " + url);
		if(url == "layer-medical")
		{
			data+= "&ordertype=order";
		}
		if(url == "layer-medical" && !isEmpty($("input[name=miName]").val())) //한의원 검색이면
		{
			data+= "&searchPop=searpoptxt,"+encodeURI($("input[name=miName]").val());
		}
		if(url == "layer-recipe"){//
			data+= "&goodstype=pill";
		}
		if(url == "layer-medicine"){ //약재추가
			$("#comPageData").val("");
		}
		if(url == "layer-medicinechange"){ //약재변경 
			var title=obj.getAttribute("data-title");
			var medicode=obj.getAttribute("data-medicode");
			data+="&title="+encodeURI(title)+"&medicode="+medicode;
		}

		console.log("viewlayerPopup  data = " + data);

		getlayer(url,size,data);
	}
	//한의원 텍스트에서 한의원 이름 입력후 엔터키 입력하면 검색된 팝업이 뜬다
	function layerPopupKeydown(event, obj)
	{
		if(event.keyCode == 13)
		{
			viewlayerPopup(obj);
		}
	}
	//생년월일 
	function setBirth()
	{
		var birth="";
		var birth1=$("input[name=odBirth1]").val();
		var birth2=$("input[name=odBirth2]").val();
		var birth3=$("input[name=odBirth3]").val();

		if(!isEmpty(birth1) && birth1.length < 4)
		{
			return false;
		}
		//생년월일
		if( birth1 != '' && birth2 != '' && birth3 != '' )
		{
			birth = birth1 +"-"+pad(birth2, 2) +"-"+pad(birth3,2);
		}
		$("input[name=odBirth]").val(birth);
	}
	//핸드폰,전화번호 
	function setPhoneMobile()
	{
		var phone=mobile="";
		//받는사람
		if( $("input[name=rePhone1]").val() != '' && $("input[name=rePhone2]").val() != '' && $("input[name=rePhone3]").val() != '' )
		{
			phone = $("input[name=rePhone1]").val() +"-"+$("input[name=rePhone2]").val() +"-"+$("input[name=rePhone3]").val();
		}
		$("input[name=rePhone]").val(phone);

		if( $("input[name=reMobile1]").val() != '' && $("input[name=reMobile2]").val() != '' && $("input[name=reMobile3]").val() != '' )
		{
			mobile = $("input[name=reMobile1]").val() +"-"+$("input[name=reMobile2]").val() +"-"+$("input[name=reMobile3]").val();
		}
		$("input[name=reMobile]").val(mobile);

		//20191018 : 보내는사람 초기화 
		mobile=phone="";

		//보내는사람 
		if( $("input[name=reSendPhone1]").val() != '' && $("input[name=reSendPhone2]").val() != '' && $("input[name=reSendPhone3]").val() != '' )
		{
			phone = $("input[name=reSendPhone1]").val() +"-"+$("input[name=reSendPhone2]").val() +"-"+$("input[name=reSendPhone3]").val();
		}
		$("input[name=reSendPhone]").val(phone);

		if( $("input[name=reSendMobile1]").val() != '' && $("input[name=reSendMobile2]").val() != '' && $("input[name=reSendMobile3]").val() != '' )
		{
			mobile = $("input[name=reSendMobile1]").val() +"-"+$("input[name=reSendMobile2]").val() +"-"+$("input[name=reSendMobile3]").val();
		}
		$("input[name=reSendMobile]").val(mobile);
	}
	//제환일때에는 약재용량이 3000 이상일때만 가능하게 하기위해서 체크 
	function checkmaTypeMedicineCapa()
	{
		var type = $('input:radio[name="maType"]:checked').val();
		var meditotal = removeComma($("#meditotal").text());
		var maxcapa="<?=$BASE_MAXCAPA;?>";
		meditotal=isEmpty(meditotal) ? 0 : parseInt(meditotal);
		maxcapa=isEmpty(maxcapa) ? "<?=$BASE_MAXCAPA;?>" : parseInt(maxcapa);
		if(type == "pill")
		{
			if(meditotal < maxcapa)
			{
				return true;
			}
		}
		return false;
	}
	//okchart 가격 
	function setOKChartAmount()//x
	{
		var aokchart = JSON.parse($("textarea[name=odAmountokchart]").val());

		$("#ok_makingprice").text(comma(aokchart["making"])+"<?=$txtdt['1235']?>");
		$("#ok_mediprice").text(comma(aokchart["medicine"])+"<?=$txtdt['1235']?>");
		$("#ok_decoctionprice").text(comma(aokchart["decoction"])+"<?=$txtdt['1235']?>");
		$("#ok_addprice").text(comma(aokchart["addprice"])+"<?=$txtdt['1235']?>");
		$("#ok_poutchprice").text(comma(aokchart["poutch"])+"<?=$txtdt['1235']?>");
		$("#ok_boxprice").text(comma(aokchart["box"])+"<?=$txtdt['1235']?>");
		$("#ok_releaseprice").text(comma(aokchart["release"])+"<?=$txtdt['1235']?>");
		$("#ok_paperprice").text(comma(aokchart["paper"])+"<?=$txtdt['1235']?>");
		$("#ok_etcprice").text(comma(aokchart["etc"])+"<?=$txtdt['1235']?>");
		$("#ok_inputprice").text(comma(aokchart["input"])+"<?=$txtdt['1235']?>");
	}
	function changeOrderCount()
	{
		var ordercnt=$("input[name=orderCnt]").val();
		var odChubcnt=$("input[name=recipeChubCnt]").val();
		var odPackcnt=$("input[name=recipePackcnt]").val();
		var medicine=$("input[name=rcMedicine]").val();

		console.log("changeOrderCount  1 ordercnt = " + ordercnt+", odChubcnt = " + odChubcnt+", odPackcnt = " + odPackcnt);
		ordercnt=(!isEmpty(ordercnt)) ? parseInt(ordercnt) : 1;


		odChubcnt=parseInt(odChubcnt)*ordercnt;
		odPackcnt=parseInt(odPackcnt)*ordercnt;


		console.log("changeOrderCount 2 ordercnt = " + ordercnt+", odChubcnt = " + odChubcnt+", odPackcnt = " + odPackcnt);

		$("input[name=odChubcnt]").val(odChubcnt);
		$("input[name=odPackcnt]").val(odPackcnt);

		console.log("changeOrderCount 3 medicine = " + medicine);

		if(!isEmpty(medicine))
		{
			var nok_dctime="<?=$BASE_NOK_DCTIME?>";
			var dctime="<?=$BASE_DCTIME?>";
			if(medicine.indexOf("HD10337") != -1 || medicine.indexOf("HD10336_15") != -1) //녹용이 있다면 탕전시간을 120으로 수정 
			{
				$("input[name=dcTime]").val(nok_dctime);
			}
			else
			{
				$("input[name=dcTime]").val(dctime);
			}
		}

		resetamount();
		resetmedi();
	}
	//총약재량 확인 메세지 
	function getMaTypeCapaText()
	{
		var capatxt=getTxtData("1831"); //[1] 처방은 [2]g 이상부터 주문 가능합니다. 총약재량을 확인해 주세요.

		var radioId = $("input:radio[name=maType]:checked").attr("id");
		var matypetxt=$("label[for='"+radioId+"']").text();
		capatxt=capatxt.replace("[2]","<?=$BASE_MAXCAPA;?>");
		capatxt=capatxt.replace("[1]",matypetxt); ////[1] 처방은 [2]g 이상부터 주문 가능합니다. 총약재량을 확인해 주세요.

		return capatxt;
	}
	//사전조제 주문정보
	function callGInfo()
	{
		$("#orderinfo").load("<?=$root?>/Skin/Order/OrderGInfo.php", function(){loadGInfoData();changeMatype();});
	}
	//수기처방 주문정보 
	function callWInfo()
	{
		$("#orderinfo").load("<?=$root?>/Skin/Order/OrderInfo.php", function(){loadWInfoData();callPatient();});
	}
	//환자정보
	function callPatient()
	{
		$("#orderpatient").load("<?=$root?>/Skin/Order/OrderPatient.php", function(){loadPatientData();callRelease();});
	}
	//배송정보
	function callRelease()
	{
		$("#orderrelease").load("<?=$root?>/Skin/Order/OrderRelease.php", function(){loadReleaseData();callAdvice();});
	}
	//복약지도 
	function callAdvice()
	{
		$("#orderadvice").load("<?=$root?>/Skin/Order/OrderAdvice.php", function(){loadAdviceData();callAmount();});
	}
	//주문금액 
	function callAmount()
	{
		$("#orderamount").load("<?=$root?>/Skin/Order/OrderAmount.php", function(){loadAmountData();changeMatype();});
	}
	//약재리스트
	function callMedicine(data)
	{
		var odGoods=$("input[name=odGoods]").val();
		var url=data+"&type="+odGoods;
		$("#ordermedicine").load("<?=$root?>/Skin/Order/OrderMedicine.php?" + url);
	}
	function setOrderpill()
	{
		console.log("setOrderpill  ======");
		if(!isEmpty($("textarea[name=rcPillorder]").val()))
		{
			var adpill=JSON.parse($("textarea[name=rcPillorder]").val());
			//console.log(adpill);
			//pillorder data 풀기 
			var poarr=adpill["pillorder"];
			//console.log(poarr);

			for(var key in poarr)
			{
				console.log(poarr[key]);				
				if(!isEmpty(poarr[key]["order"]))
				{
					switch(poarr[key]["type"])
					{
					case "decoction": //탕전						
						poarr[key]["order"][0]["plDctitle"]=$("#dcTitle option:selected").val();
						poarr[key]["order"][0]["plDcspecial"]=$("#dcSpecial option:selected").val();
						poarr[key]["order"][0]["plDctime"]=$("input[name=dcTime]").val();
						poarr[key]["order"][0]["plDcwater"]=$("input[name=dcWater]").val();
						break;
					case "smash"://분쇄
						poarr[key]["order"][0]["plFineness"]=$('input:radio[name="pillFineness"]:checked').val();
						poarr[key]["order"][0]["plMillingloss"]=$("input[name=pillMillingloss]").val();
						break;
					case "concent"://농축
						poarr[key]["order"][0]["plConcentratio"]=$('input:radio[name="pillConcentRatio"]:checked').val();
						poarr[key]["order"][0]["plConcenttime"]=$('input:radio[name="pillConcentTime"]:checked').val();
						break;
					case "juice"://착즙
						poarr[key]["order"][0]["plJuice"]=$('input:radio[name="pillJuice"]:checked').val();
						break;
					case "mixed"://혼합
						console.log("혼합결합제 : " + $('input:radio[name="pillBinders"]:checked').val());
						poarr[key]["order"][0]["plBinders"]=$('input:radio[name="pillBinders"]:checked').val();
						break;
					case "stir"://교반
						console.log("교반결합제 : " + $('input:radio[name="pillstirBinders"]:checked').val());
						poarr[key]["order"][0]["plstirBinders"]=$('input:radio[name="pillstirBinders"]:checked').val();
						break;
					case "warmup"://중탕
						poarr[key]["order"][0]["plWarmuptemperature"]=$('input:radio[name="pillWarmupTemperature"]:checked').val();
						poarr[key]["order"][0]["plWarmuptime"]=$('input:radio[name="pillWarmupTime"]:checked').val();
						break;
					case "ferment"://숙성 
						poarr[key]["order"][0]["plFermenttemperature"]=$('input:radio[name="pillFermentTemperature"]:checked').val();
						poarr[key]["order"][0]["plFermenttime"]=$('input:radio[name="pillFermentTime"]:checked').val();
						break;
					case "plasty"://제형
						poarr[key]["order"][0]["plShape"]=$('input:radio[name="pillShape"]:checked').val();
						poarr[key]["order"][0]["plLosspill"]=$("input[name=pillLosspill]").val();
						break;
					case "dry"://건조 
						poarr[key]["order"][0]["plDrytemperature"]=$('input:radio[name="pillDryTemperature"]:checked').val();
						poarr[key]["order"][0]["plDrytime"]=$('input:radio[name="pillDryTime"]:checked').val();
						break;
					}
				}				
			}

			//console.log(poarr);
			console.log(adpill);
			console.log(JSON.stringify(adpill));
			$("textarea[name=rcPillorder]").val(JSON.stringify(adpill));
		}
	}
	//첩수 입력시
	function onKeyupChubcnt()
	{
		var recipeChubCnt=$("input[name=recipeChubCnt]").val();
		var odChubcnt=$("input[name=odChubcnt]").val();

		console.log("첩수 입력시  recipeChubCnt = " + recipeChubCnt+", odChubcnt = " + odChubcnt);
		if(recipeChubCnt!=odChubcnt)
		{
			$("input[name=recipeChubCnt]").val(odChubcnt);
		}


		resetamount();
		resetmedi();
	}
	
	//팩수 입력시
	function onKeyupPackcnt()
	{	
		var recipePackcnt=$("input[name=recipePackcnt]").val();
		var odPackcnt=$("input[name=odPackcnt]").val();

		console.log("팩수 입력시 recipePackcnt = " + recipePackcnt+", odPackcnt = " + odPackcnt);
		if(recipePackcnt!=odPackcnt)
		{
			$("input[name=recipePackcnt]").val(odPackcnt);
		}

		resetamount();
		resetmedi();
	}
	//팩용량 입력시
	function onKeyupPackcapa()
	{	
		console.log("팩용량 입력시");

		resetamount();
		resetmedi();
	}

	//팩용량 입력시
	function onKeyupDctime()
	{	
		console.log("탕전시간 입력시");
		var base_dctime=$("input[name=base_dctime]").val();
		var dcTime=$("input[name=dcTime]").val();

		console.log("탕전시간 base_dctime = " + base_dctime+", dcTime = " + dcTime);
		if(base_dctime!=dcTime)
		{
			$("input[name=base_dctime]").val(dcTime);
		}

		resetamount();
		resetmedi();
	}

	//첩수,팩수,팩용량 입력시
	function onKeyupOrderPill()
	{	
		setOrderpill();
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj)
		if(obj["apiCode"]==="goodspilldesc")
		{
			$("textarea[name=jsobj]").val(json);

			//사전조제인지 체크하기 위해서 데이터 체크하기 
			var odGoods=!isEmpty(obj["odGoods"])?obj["odGoods"]:"<?=$type?>";
			$("input[name=odGoods]").val(odGoods);

			//20190917 : 조제비,탕전비, 배송비 셋팅 
			setAllPrice(obj);

			//사이트 정보(보내는사람에서 기본 선택하면 들어갈 정보) 
			$("input[name=cfCompany]").val(obj["config"]["cfCompany"]);//config 회사명
			$("input[name=cfPhone]").val(obj["config"]["cfPhone"]);//config 대표전화번호
			$("input[name=cfStaffmobile]").val(obj["config"]["cfStaffmobile"]);//config 담당자전화번호 
			$("input[name=cfZipcode]").val(obj["config"]["cfZipcode"]);//config 우편번호 
			$("input[name=cfAddress]").val(obj["config"]["cfAddress"]);//config 주소 
		

			$("input[name=seq]").val(obj["seq"]);//seq
			$("input[name=rcSeq]").val(obj["rcSeq"]);//rcSeq
			$("input[name=rc_seq]").val(obj["rcSeq"]);//rcSeq
			$("input[name=odCode]").val(obj["odCode"]);//주문코드
			$("input[name=odStatus]").val(obj["odStatus"]);//상태
			$("input[name=odKeycode]").val(obj["odKeycode"]);//주문코드
			$("input[name=odSitecategory]").val(obj["odSitecategory"]);

			//주문자요청사항
			$("textarea[name=odRequest]").val(obj["odRequest"]);

			//제환순서 
			$("textarea[name=rcPillorder]").val(obj["rcPillorder"]);


			//주문내역 
			if(chkGWrite()===true)//사전조제인지 
			{
				callGInfo();
			}
			else
			{
				callWInfo();
			}

			//취소
			setOrderCancel(obj);
			//버튼 
			setOrderButton(obj);


			
		}
		else if(obj["apiCode"]=="medicinetitle") //약재구성
		{
			var boardpage=$("#board-list-wrap").hasClass("board-list-wrap");//약재리스트 테이블
			var layerpage=$("#layer_medicine_wrap").hasClass("layer-wrap");//약재추가 팝업 테이블

			var selDecoc = parsedecocodes(obj["decoctypeList"], '<?=$txtdt["1367"]?>', 'rcDecoctype', null);
			$("#board-list-wrap").prepend("<textarea name='selDecoctype' style='display:none;'>"+selDecoc+"</textarea>");

			var dismatch = "_"+obj["dismatch"]; //여기에 _를 붙여야지.. 밑에 dismatch.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var poison = "_"+obj["poison"]; //여기에 _를 붙여야지.. 밑에 poison.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var data = medilist = medicode = sweetcode=cls = clstitle = medibox = "";
			var capa = totalqty = 0;
			var decoc=[];
			var mpricecls;

			$(obj["medicine"]).each(function( index, value )
			{
				var rcmedicine = value["rcMedicode"];

				if(dismatch.indexOf(rcmedicine) != -1) //
				{
					cls="dismatch";
					clstitle='<span style="color:red;font-weight:bolder;"><?=$txtdt["1158"]?></span>';//상극
				}
				else if(poison.indexOf(rcmedicine) != -1)
				{
					cls="poison";
					clstitle='<span style="color:#444;font-weight:bolder;"><?=$txtdt["1064"]?></span>';//독성
				}
				else
				{
					cls="";
					clstitle="-";
				}

				capa = parseFloat(value["rcCapa"]);
				capa = (isNaN(capa)==false) ? capa : 0;
				capa = !isEmpty(capa) ? capa : 0;
				capa = capa.toFixed(1);//소수점 1자리


				//20190917 : 가격 5단계 적용 
				price = (!isEmpty(value["rcPrice"])) ? value["rcPrice"] : '';
				mpricecls=" data-pricea="+value["rcPriceA"]+"  data-priceb="+value["rcPriceB"]+"  data-pricec="+value["rcPriceC"]+"  data-priced="+value["rcPriceD"]+"  data-pricee="+value["rcPriceE"]+"  data-price="+price+" ";

				if(layerpage == false)
				{
					if(value["rcmedibox"].indexOf("00000") >= 0)//공통약재이면
					{
						medibox = "▲";
					}
					else
					{
						if(isEmpty(value["rcmedibox"]) || value["rcmedibox"] == '-')
							medibox = "X";
						else
							medibox = "O";
					}

					//console.log("title : " + value["rcMedititle"]+", rcmedibox : "+value["rcmedibox"]+", medibox  : " + medibox+", capa = " + capa);


					totalqty = parseInt(value["mdQty"]) + parseInt(value["mbCapacity"]); //qty : medicine에 있는 창고량, capacity : medibox에 있는 박스 재고량
					totalqty = isNaN(totalqty) ? 0 : totalqty;
					//console.log("totalqty : " + totalqty);


					if(checkMedicine(value["rcMedicode"])==false)
					{
						data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
						data+='	<td><?=$txtdt["1836"]?><input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
					}
					else
					{
						data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
						data+='	<td>'+value["mmCode"]+'<input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
					}
					
					data+='	<td>'+$("textarea[name=selDecoctype]").val()+'</td>';

					//약재명 
					if(checkMedicine(value["rcMedicode"])==false)
					{
						var mcode=(!isEmpty(value["mmCode"])) ? '('+value["mmCode"]+')' : "";
						var mtitle=!isEmpty(value["exceltitle"]) ? value["exceltitle"] : value["rcMedititle"];
						data+='	<td class="l"><span class="mdtype mdmedi"></span><input type="hidden" id="id_exceltitle" class="exctitle" value="'+value["exceltitle"]+'" /><b>'+mtitle+mcode+'</b> <button type="button" class="cp-btn" onclick="javascript:noneMediUpdate(\''+value["mmCode"]+'\', \''+value["rcMedititle"]+'\');" ><span><?=$txtdt["1202"]?></span></button></td>';  //약재명(약재함)
					}
					else
					{
						var mtitle=!isEmpty(value["exceltitle"]) ? value["exceltitle"] : value["rcMedititle"];
						if(medibox=="X")
						{
							data+='	<td class="l"><span class="mdtype mdmedi"></span><input type="hidden" id="id_exceltitle" class="exctitle" value="'+value["exceltitle"]+'" /><b>'+mtitle+'</b> <button type="button" class="cp-btn" onclick="javascript:viewlayerPopup(this);" data-bind="layer-medicinechange" data-value="700,600" data-title="'+mtitle+'" data-medicode="'+value["rcMedicode"]+'"><span>약재변경</span></button</td>';  //약재명(약재함)
						}
						else
						{
							data+='	<td class="l"><span class="mdtype mdmedi"></span><input type="hidden" id="id_exceltitle" class="exctitle" value="'+value["exceltitle"]+'" /><b><a href="javascript:;" onclick="viewlayerPopup(this);" data-bind="layer-medicinechange" data-value="700,600" data-title="'+mtitle+'" data-medicode="'+value["rcMedicode"]+'">'+mtitle+'</a></b></td>';  //약재명(약재함)
						}
					}

					data+='	<td>'+medibox+'</td>';
					data+='	<td>'+clstitle+'</td>';
					data+='	<td>'+value["rcOrigin"]+' / '+value["rcMaker"]+'</td>';
					data+='	<td class="rctotalqty r" id="idTotalQty">'+comma(totalqty)+'g</td>';
					data+='	<td ><input type="text" name="nchubamt" class="w50p tc chubamt necdata" value="'+capa+'" title="<?=$txtdt["1334"]?>" style="text-align:right;" maxlength="6" onfocus="this.select();" onkeyup="chubamt_keyup()"  onchange="changeNumber(event,true);" /> g ';
					data+=' <input type="hidden" id="id_water" class="w30p" value="'+value["rcWater"]+'" readonly/>';
					data+=' <input type="hidden" id="id_total_qty" class="w30p" value="'+totalqty+'" readonly/>';
					data+=' <input type="hidden" id="id_dismatch_poison" class="w30p dispoison" value="'+cls+'" readonly/></td>';
					data+='	<td class="r"><span id="id_mediamt" class="w70p tc mediamt"></span>g</td>';
					data+='	<td class="r"><span id="id_mprice" class="w50p tc mgprice" '+mpricecls+'>'+price+'</span><?=$txtdt["1235"]?></td>';
					data+='	<td class="r"><span id="id_mediprice" class="w70p tc mediprice"></span><?=$txtdt["1235"]?></td>';

					if(checkMedicine(value["rcMedicode"])==false)
					{
						if(!isEmpty(value["mmCode"]))
						{
							data+='	<td><a style="text-decoration:none;font-weight:normal;" href="javascript:deletemedi(\''+value["mmCode"]+'\');">X</a></td>';
						}
						else
						{
							data+='	<td></td>';
						}
					}
					else
					{
						data+='	<td><a style="text-decoration:none;font-weight:normal;" href="javascript:deletemedi(\''+value["rcMedicode"]+'\');">X</a></td>';
					}
					
					data+='</tr>';

					decoc.push(value["rcDecoctype"]);
				}
				else if(layerpage == true)
				{
					medilist+="<dt class='"+cls+"'>";
					medilist+="	<span class='delspan'>";
					medilist+="		<span class='delbtn' value='"+value["rcMedicode"]+"'>X</span>";
					medilist+="	</span>";
					medilist+=" "+value["rcMedititle"]+","+capa;
					medilist+="</dt>";
					medilist+="<dd>";
					medilist+="	<input type='text' /> g";
					medilist+="</dd>";

					medicode+="|"+value["rcMedicode"]+","+value["rcCapa"]+","+value["rcDecoctype"]+","+value["rcPrice"];
				}

			});

			sweetcode="";
			$(obj["sweet"]).each(function( index, value )
			{
				var rcmedicine = value["rcMedicode"];

				if(dismatch.indexOf(rcmedicine) != -1) //
				{
					cls="dismatch";
					clstitle='<span style="color:red;font-weight:bolder;"><?=$txtdt["1158"]?></span>';//상극
				}
				else if(poison.indexOf(rcmedicine) != -1)
				{
					cls="poison";
					clstitle='<span style="color:#444;font-weight:bolder;"><?=$txtdt["1064"]?></span>';//독성
				}
				else
				{
					cls="";
					clstitle="-";
				}

				capa = parseFloat(value["rcCapa"]);
				capa = (isNaN(capa)==false) ? capa : 0;
				capa = !isEmpty(capa) ? capa : 0;
				capa = capa.toFixed(1);//소수점 1자리

				//20190917 : 가격 5단계 적용 
				price = (!isEmpty(value["rcPrice"])) ? value["rcPrice"] : '';
				mpricecls=" data-pricea="+value["rcPriceA"]+"  data-priceb="+value["rcPriceB"]+"  data-pricec="+value["rcPriceC"]+"  data-priced="+value["rcPriceD"]+"  data-pricee="+value["rcPriceE"]+"  data-price="+price+" ";


				if(layerpage == false)
				{
					if(value["rcmedibox"].indexOf("00000") >= 0)//공통약재이면
					{
						medibox = "▲";
					}
					else
					{
						if(isEmpty(value["rcmedibox"]) || value["rcmedibox"] == '-')
							medibox = "X";
						else
							medibox = "O";
					}

					totalqty = parseInt(value["mdQty"]) + parseInt(value["mbCapacity"]); //qty : medicine에 있는 창고량, capacity : medibox에 있는 박스 재고량
					totalqty = isNaN(totalqty) ? 0 : totalqty;

					if(checkMedicine(value["rcMedicode"])==false)
					{
						if(!isEmpty(value["mmCode"]))
						{
							data+='<tr class="meditr" id="md'+value["mmCode"]+'">';
							//미등록약재
							data+='	<td><?=$txtdt["1836"]?><input type="hidden" id="nrccode" class="srccode" value="'+value["rcMedicode"]+'" readonly/></td>';
						}
						else
						{
							data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
							data+='	<td><?=$txtdt["1836"]?><input type="hidden" id="nrccode" class="srccode" value="'+value["rcMedicode"]+'" readonly/></td>';
						}
					}
					else
					{
						data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
						data+='	<td>'+value["mmCode"]+'<input type="hidden" id="nrccode" class="srccode" value="'+value["rcMedicode"]+'" readonly/></td>';
					}
					
					data+='	<td><input type="hidden" class="srcDecoctype" value="inlast">별전</td>';
					//약재명
					if(checkMedicine(value["rcMedicode"])==false)
					{
						var mcode=(!isEmpty(value["mmCode"])) ? '('+value["mmCode"]+')' : "";
						data+='	<td class="l"><span class="mdtype mdsweet"></span><input type="hidden" id="id_exceltitle" class="exctitle" value="'+value["exceltitle"]+'" /><b>'+value["rcMedititle"]+mcode+'</b> <button type="button" class="cp-btn" onclick="javascript:noneMediUpdate(\''+value["mmCode"]+'\', \''+value["rcMedititle"]+'\');" ><span><?=$txtdt["1202"]?></span></button></td>';  //약재명(약재함)
					}
					else
					{
						data+='	<td class="l"><span class="mdtype mdsweet"></span><input type="hidden" id="id_exceltitle" class="exctitle" value="'+value["exceltitle"]+'" /><b>'+value["rcMedititle"]+'</b></td>';  //약재명(약재함)
					}

					data+='	<td>'+medibox+'</td>';
					data+='	<td>'+clstitle+'</td>';
					data+='	<td>'+value["rcOrigin"]+'</td>';
					data+='	<td class="srctotalqty r" id="idTotalQty">'+comma(totalqty)+'g</td>';
					data+='	<td ><input type="text" name="nchubamt" class="w50p tc schubamt necdata" value="'+capa+'" title="<?=$txtdt["1334"]?>" style="text-align:right;" maxlength="6" onfocus="this.select();" onkeyup="chubamt_keyup()"  onchange="changeNumber(event,true);" /> g ';
					data+=' <input type="hidden" id="id_water" class="w30p" value="'+value["rcWater"]+'" readonly/>';
					data+=' <input type="hidden" id="id_total_qty" class="w30p" value="'+totalqty+'" readonly/>';
					data+=' <input type="hidden" id="id_dismatch_poison" class="w30p dispoison" value="'+cls+'" readonly/></td>';
					data+='	<td class="r"><span id="id_mediamt" class="w70p tc smediamt"></span>g</td>';
					data+='	<td class="r"><span id="id_mprice" class="w50p tc smgprice"  '+mpricecls+' >'+price+'</span><?=$txtdt["1235"]?></td>';
					data+='	<td class="r"><span id="id_mediprice" class="w70p tc mediprice"></span><?=$txtdt["1235"]?></td>';

					if(checkMedicine(value["rcMedicode"])==false)
					{
						if(!isEmpty(value["mmCode"]))
						{
							data+='	<td><a style="text-decoration:none;font-weight:normal;" href="javascript:deletemedi(\''+value["mmCode"]+'\');">X</a></td>';
						}
						else
						{
							data+='	<td></td>';
						}
					}
					else
					{
						data+='	<td><a style="text-decoration:none;font-weight:normal;" href="javascript:deletemedi(\''+value["rcMedicode"]+'\');">X</a></td>';
					}
					
					data+='</tr>';

					decoc.push(value["rcDecoctype"]);
				}
				else if(layerpage == true)
				{
					medilist+="<dt class='"+cls+"'>";
					medilist+="	<span class='delspan'>";
					medilist+="		<span class='delbtn' value='"+value["rcMedicode"]+"'>X</span>";
					medilist+="	</span>";
					medilist+=" "+value["rcMedititle"]+","+capa;
					medilist+="</dt>";
					medilist+="<dd>";
					medilist+="	<input type='text' /> g";
					medilist+="</dd>";

					sweetcode+="|"+value["rcMedicode"]+","+value["rcCapa"]+","+value["rcDecoctype"];
				}

			});

			//약재추가 팝업
			if(layerpage == true)
			{
				var txt = datatxt="";

				if(!isEmpty(obj["dismatchtxt"]))
				{
					datatxt = obj["dismatchtxt"].replace("[DISMATCH]", "<?=$txtdt['1159']?>");//상극알람
					txt+="<dl class='dismatchtxt'><dt><dd> "+datatxt+"</dd></dl>";
				}
				if(!isEmpty(obj["poisontxt"]))
				{
					datatxt = obj["poisontxt"].replace("[POISON]", "<?=$txtdt['1066']?>"); //독성알람
					txt+="<dl class='poisontxt'><dt><dd> "+datatxt+"</dd></dl>";
				}

				$("#stuff-tab").html(txt);


				$("#popmedilist").html(medilist);
				$("input[name=rcMedicine_pop]").val(medicode);
				$("input[name=rcSweet_pop]").val(sweetcode);

			}
			else if(layerpage == false)//약재리스트
			{
				$("#totMedicineDiv").text(obj["totMedicine"]);//총약재
				$("#totPoisonDiv").text(obj["totPoison"]);//독성
				$("#totDismatchDiv").text(obj["totDismatch"]);//상극

				$("#medicinetbl tbody").html(data);



				$.each(decoc, function(key, value){
					$("#medicinetbl tbody tr").eq(key).find("select").val(value);
				});


				console.log("medicinetitlemedicinetitlemedicinetitlemedicinetitle");
				resetamount();
				resetmedi();


				checkPoisonDismatch();
			}
		}
		else if(obj["apiCode"]=="medicallist") //한의원리스트
		{
			var data = "";

			$("#pop_medicaltbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["miUserid"]+'" data-name="'+value["miName"]+'" data-doctor="'+value["miDoctor"]+'" data-zipcode="'+value["miZipcode"]+'" data-addr="'+value["miAddress"]+'" data-phone="'+value["miPhone"]+'" data-mobile="'+value["miMobile"]+'" data-grade="'+value["miGrade"]+'" >';
					data+='<td>'+value["miName"]+'</td>';
					data+='<td>'+value["miPersion"]+'</td>';
					data+='<td>'+value["miBusinessno"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			//한의원리스트
			$("#pop_medicaltbl tbody").html(data);

			//페이징
			getsubpage_pop("medicallistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "uniquesclist")//고유처방 리스트
		{
			var data = "";

			$("#pop_recipetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["seq"]+'" data-code="'+value["rcCode"]+'" data-title="'+value["rcTitle"]+'">';
					data+='<td class="td_text_overflow">'+value["rbSourcetxt"]+'</td>';
					data+='<td class="td_text_overflow">'+value["rcTitle"]+'</td>';
					data+='<td class="l td_text_overflow">'+value["rcMedicineTxt"]+'</td>';
					data+='<td>'+value["rcMedicineCnt"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#pop_recipetbl tbody").html(data);

			//페이징
			getsubpage_pop("recipelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "generalsclist")//이전처방 리스트
		{
			$("#pop_recipetbl tbody").html("");
			var data = title = name = "";

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					title = isEmpty(value["rcTitle"]) ? "-" : value["rcTitle"];
					name = isEmpty(value["reName"]) ? "-" : value["reName"];
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["seq"]+'" data-code="'+value["rcCode"]+'" data-title="'+value["rcTitle"]+'">';
					data+='<td class="td_text_overflow">'+title+'</td>';
					data+='<td>'+name+'</td>';
					data+='<td class="l td_text_overflow">'+value["rcMedicineTxt"]+'</td>';
					data+='<td>'+value["rcMedicineCnt"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#pop_recipetbl tbody").html(data);

			//페이징
			getsubpage_pop("recipelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "worthylist")//실속처방 리스트
		{
			var data = "";

			$("#pop_recipetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["seq"]+'" data-code="'+value["rcCode"]+'" data-title="'+value["rcTitle"]+'">';
					data+='<td class="l td_text_overflow">'+value["rcTitle"]+'</td>';
					//data+='<td class="td_text_overflow">'+''+'</td>';
					data+='<td class="l td_text_overflow">'+value["rcMedicineTxt"]+'</td>';
					data+='<td>'+value["rcMedicineCnt"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#pop_recipetbl tbody").html(data);

			//페이징
			getsubpage_pop("recipelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "commerciallist")//상용처방 리스트
		{
			var data = "";

			$("#pop_recipetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["seq"]+'" data-code="'+value["rcCode"]+'" data-title="'+value["rcTitle"]+'">';
					data+='<td class="l td_text_overflow">'+value["rcTitle"]+'</td>';
					//data+='<td class="td_text_overflow">'+''+'</td>';
					data+='<td class="l td_text_overflow">'+value["rcMedicineTxt"]+'</td>';
					data+='<td>'+value["rcMedicineCnt"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#pop_recipetbl tbody").html(data);

			//페이징
			getsubpage_pop("recipelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "recipegoodslist")//약속처방 리스트
		{
			var data = "";

			$("#pop_recipetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["seq"]+'" data-code="'+value["rcCode"]+'" data-title="'+value["rcTitle"]+'">';
					data+='<td class="l td_text_overflow">'+value["rcTitle"]+'</td>';
					//data+='<td class="td_text_overflow">'+''+'</td>';
					data+='<td class="l td_text_overflow">'+value["rcMedicineTxt"]+'</td>';
					data+='<td>'+value["rcMedicineCnt"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#pop_recipetbl tbody").html(data);

			//페이징
			getsubpage_pop("recipelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "recipepilllist")//제환처방 리스트
		{
			var data = "";

			$("#pop_recipetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-id="'+value["seq"]+'" data-code="'+value["rcCode"]+'" data-title="'+value["rcTitle"]+'" >';
					data+='<td class="l td_text_overflow">'+value["rcTitle"]+'<textarea name="pillorder'+value["seq"]+'" class="reqdata " style="display:none;" >'+value["gdPillorder"]+'</textarea></td>';
					//data+='<td class="td_text_overflow">'+''+'</td>';
					data+='<td class="l td_text_overflow">'+value["rcMedicineTxt"]+'</td>';
					data+='<td>'+value["rcMedicineCnt"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='3'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#pop_recipetbl tbody").html(data);

			//페이징
			getsubpage_pop("recipelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "medicinerecipe") //고유처방, 이전처방 클릭시
		{
			if(!isEmpty(obj["type"])&&obj["type"]=="pill")
			{
				console.log("aaaaaaaaaaaa");
				//제환순서 
				$("#pilldiv").html(obj["pillorder"]);
			}
			else
			{
				$("input[name=recipeChubCnt]").val(obj["rcChub"]);//첩수
				$("input[name=recipePackcnt]").val(obj["rcPackcnt"]);//첩수

				$("input[name=odChubcnt]").val(obj["rcChub"]);//첩수
				$("input[name=odPackcnt]").val(obj["rcPackcnt"]);//팩수
				$("input[name=odPackcapa]").val(obj["rcPackcapa"]);//팩용량

				$("input[name=rcMedicine]").val(obj["rcMedicine"]);

				//----------------------------------------------------------------------------------------------------------
				// 포장 및 박스
				//----------------------------------------------------------------------------------------------------------
				//탕제파우치
				parsepackcodes("odPacktypeDecocDiv", obj["odPacktypeList"], '<?=$txtdt["1382"]?>', 'odPacktype', obj["rcPacktype"], obj["odPackprice"],'<?=$txtdt["1235"]?>','');

				//한약박스종류선택
				parsepackcodes("reBoxmediDiv", obj["reBoxmediList"], '<?=$txtdt["1468"]?>', 'reBoxmedi', obj["rcMedibox"], obj["reBoxmediprice"],'<?=$txtdt["1235"]?>','');
				//------------------------------------------

				var rcMedicine = isEmpty(obj["rcMedicine"]) ? "" : obj["rcMedicine"];
				var rcSweet = isEmpty(obj["rcSweet"]) ? "" : obj["rcSweet"];
				var data = "medicine="+rcMedicine+"&sweet="+rcSweet;
				console.log("medicinerecipe medicinerecipemedicinerecipemedicinerecipedata = " + data);
				callMedicine(data);
				closediv('viewlayer');

				changeOrderCount();
			}
		}
		else if(obj["apiCode"] == "medicinelist") //약재리스트
		{
			var data = spancls="";
			var capa = 0;
			$("#laymedicinetbl tbody").html("");
			var miGrade=$("input[name=miGrade]").val();
			miGrade=chkGrade(miGrade);

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var mdprice=getMediGradePrice(miGrade, value["mdPrice"+miGrade], value["mdPriceE"]);
					
					capa = (isNaN(value["mdProperty"])==false) ? value["mdProperty"] : 0;
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mdCode"]+'" data-smu="'+value["mmCode"]+'" data-property="'+capa+'" data-type="'+value["mdType"]+'">';
					data+='<td class="td_text_overflow">'+value["mdTypeName"]+'</td>';
					data+='<td class="td_text_overflow">'+value["mhTitle"]+'</td>';

					if(value["mdType"]=="medicine")
					{
						spancls="mdmedi";
					}
					else
					{
						spancls="mdsweet";
					}
					data+='<td class="td_text_overflow l"><span class="mdtype '+spancls+'"></span>'+value["mmtitle"]+'</td>';  //medicine 테이블이 아니라 medicine_djmedi 테이블에 있는 약재명이 보임(190524수정함)
					data+='<td class="td_text_overflow l">'+value["mdOrigin"]+'/'+value["mdMaker"]+'</td>';
					//data+='<td>'+capa+'</td>';
					data+='<td>'+mdprice+' <?=$txtdt["1235"]?> </td>';
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
			getsubpage_pop("medicinelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}
		else if(obj["apiCode"] == "nonemedicine") //미등록 약재 약재등록되었는지 체크하고 등록되었으면 업데이트, 아니면 메세지 
		{
			if(obj["resultCode"]=="399" && obj["resultMessage"] == "NONE_MEDICINE") //약재등록이 안되어있다. 
			{
				alertsign('error',"<?=$txtdt['1835']?>",'','2000');
				//alert("등록된 약재가 없습니다. 약재 등록 후 사용하세요!!");
			}
			else if(obj["resultCode"]=="399" && obj["resultMessage"] == "POP_MEDICINE") //약재코드가 없는 미등록 약재  
			{
				getlayer('layer-medicinehanpure','800,550',"page=1&psize=5&block=10&medititle="+obj["medititle"]+"&medicine="+obj["medicine"]+"&odKeycode="+obj["odKeycode"]+"&site="+obj["site"]);
			}
			else if(obj["resultCode"]=="398" && obj["resultMessage"] == "NONE_ORDER") //주문번호를 확인해 주세요.
			{
				alertsign("error", "<?=$txtdt['1838']?>", "", "2000");//주문번호가 존재하지 않습니다. 확인해 주세요.
			}
			else if(obj["resultCode"]=="397" && obj["resultMessage"] == "POP_NOMATCHING") //
			{
				alertsign("error", obj["nomatchTitle"]+"로 등록되어 있습니다. 다시 선택해 주세요.", "", "2000");//해당 약재로 등록되어있습니다. 
			}
			else if(obj["resultCode"]=="200" && obj["resultMessage"] == "OK")
			{
				alertsign("info", "<?=$txtdt['1837']?>", "", "2000");//'약재가 등록되었습니다.'
				var data="medicine="+(obj["rc_medicine"]);
				callapi('GET','medicine','medicinetitle',data);
			}
		}
		else if(obj["apiCode"] == "medicinehanpurelist")
		{
			var data = "";

			$("#pop_medicaltbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-medicode="'+value["mdCode"]+'">';
					data+='<td class="l">'+value["mhTitle"]+'</td>';//본초명
					if(value["mdType"]=="medicine")
					{
						data+='<td class="l"><span class="mdtype mdmedi"></span>'+value["mmTitle"]+'</td>';//약재명
					}
					else
					{
						data+='<td class="l"><span class="mdtype mdsweet"></span>'+value["mmTitle"]+'</td>';//약재명
					}
					//data+='<td>'+value["mdPrice"]+'</td>';//가격
					data+='<td>'+value["mdOrigin"]+'</td>';//원산지
					data+='<td>'+value["mdMaker"]+'</td>';//조제사 
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			//한의원리스트
			$("#pop_medicaltbl tbody").html(data);

			//페이징
			getsubpage_pop("medicallistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"] == "changemedicodelist")
		{
			var data = spancls="";
			$("#pop_medichangetbl tbody").html("");

			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					var mdprice=getMediGradePrice(miGrade, value["mdPrice"+miGrade], value["mdPriceE"]);
					
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-type="'+value["mdType"]+'" data-newcode="'+value["mdCode"]+'" data-code="'+obj["medicode"]+'">';
					data+='<td class="td_text_overflow">'+value["mhTitle"]+'</td>';//본초명 

					if(value["mdType"]=="medicine")
					{
						spancls="mdmedi";
					}
					else
					{
						spancls="mdsweet";
					}
					data+='<td class="td_text_overflow l"><span class="mdtype '+spancls+'"></span>'+value["mdTitle"]+'</td>';//약재명 
					data+='<td class="td_text_overflow ">'+value["mdOrigin"]+'</td>';
					data+='<td>'+value["mdMaker"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='4'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#pop_medichangetbl tbody").html(data);

			//페이징
			getsubpage_pop("medilistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}
		else if(obj["apiCode"] == "changemedicodeupdate")
		{
			if(obj["resultCode"]=="200")
			{
				closediv('viewlayer');
				alertsign('success',"약재가 변경되었습니다.",'','2000');
				var data="medicine="+(obj["newmedicine"]);
				callapi('GET','medicine','medicinetitle',data);
			}
			else
			{
				alertsign('error',obj["resultMessage"],'','2000');
			}
		}


	}

	callapi('GET','goods','goodspilldesc','<?=$apiOrderData?>');
</script>