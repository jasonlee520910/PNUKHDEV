<?php 
	$root="..";
	include_once $root."/_common.php";
	$code=$_GET["code"];
	$apiData="code=".$code;
?>
<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="author" content="" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery-2.2.4.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery.cookie_new.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/_Js/jquery-barcode.js"></script> <!-- 새로추가한 jquery -->
<link rel="stylesheet" type="text/css" href="<?=$root?>/_Css/print_style.css">

<style type="text/css">
		/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
		html{background:none; min-width:0; min-height:0;font-weight:bold;}
		.section_print{width: 21cm;min-height: 29.7cm;}
		.barcode img{width:300px;height:54px;}
		.barcodetext {margin-top:-1px;font-size:14px;font-weight:bold;}
		.lst_tb{overflow:hidden;}
		.lst_tb table{width:49%;float:left;margin-right:1%;}
		.lst_tb table.one{width:100%;float:left;margin-right:1%;}
		.form_dtl .lst_tb table tbody tr.meditr td{padding:5px;}
		.form_dtl .lst_tb table tbody tr.meditr td.mediumfont{padding:5px;font-size: 13px;}
		.form_dtl .lst_tb table tbody tr.meditr td.smallfont{padding:5px;font-size: 12px;}
		.totalcapa {float:right;}
		table tr th, table tr td{padding:5px;font-size:15px;}
		.maintbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;margin-bottom:5px;}
		.maintbl tr th, .maintbl tr td{border-right:1px solid #333;border-bottom:1px solid #333}
		.tbltitle tr th{font-size:25px;font-weight:bold;}
		.subtbl{width:255px;height:29px;float:left;border:none;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;}
		.subtbl tr td{border:none;border-left:1px solid #333;border-top:1px solid #333;font-size:14px;text-align:center;height:29px;font-weight:bold;}
		.subtbl tr td.lt{text-align:left;}
		.subtbl tr td.fi{border-left:none;}
		.fitbl{/*margin-left:0;margin-right:1px;border-left:none;;*/}
		.lstbl, .lstbl tr th{border-right:red;border-left: 1px solid #333}
		dl.subbot{/*margin:1%;*/overflow:hidden;padding-left:10px;}
		dl.subbot dt{float:left;width:auto;padding-right:10px;}
		dl.subbot dd{float:left;width:12%;text-align:left;}
		dl.subbot dd.total{float:left;width:17%;}
		
		.form_cont .half{float:left;width:46%;font-size:14px;padding:5px 2%;margin-bottom:10px;overflow:hidden;}
		.form_cont .rt{float:right;text-align:right;line-height:180%;}
		.form_cont .line{clear:both;margin:15px 15px 20px 15px;;border-top:1px dotted #999;}
		span.spanrt{float:right;margin-right:20px;}
		.etc{font-size:13px;padding:4px;}

		.form_dtl_pop{overflow:hidden; clear:both;width:100%;margin-bottom: 5px;}
		.form_dtl_pop .fl{float:left; width:69%;}
		.form_dtl_pop .fr{float:right; width:30%;}

		.decoctbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-top:5px;}
		.decoctbl tr th, .decoctbl tr td{width:10%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:30px;}
		.decoctbl tr td{width:15%;font-weight:bold;}

		.markingtbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.markingtbl tr th, .markingtbl tr td{width:7%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:30px;}
		.markingtbl tr td{width:15%;font-weight:bold;}

		.relesetbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.relesetbl tr th, .relesetbl tr td{width:4%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:50px;}
		.relesetbl tr td{width:15%;font-weight:bold;text-align:left;}

		.requesttbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;border-right:1px solid #333;margin-left:2px;margin-top:5px;}
		.requesttbl tr th, .requesttbl tr td{width:4%;border:none;border-right:1px solid #333;border-bottom:1px solid #333;font-size:13px;text-align:center;height:130px;}
		.requesttbl tr td{width:15%;font-weight:bold;text-align:left;}

		.mrktbl{margin-top:5px;width:100%;border:1px solid #333;}
		.mrktbl tr th, .mrktbl tr td{border:1px solid #333;font-size:14px;text-align:center;padding:5px 0 5px 0;}
		.mrktbl tr td{font-weight:bold;}
		.mrktbl tr td img{width:70%;height:100px;}

		#odRequestDiv {height:60px;text-align: left;overflow-y:auto;}
		.inth {padding-left:10px;padding-right:10px;letter-spacing: -1px;}

		#sweetlist{width:100%;border:0;border-right:1px solid #ddd;border-left:1px solid #ddd;font-size:15px;border:1px solid red;}
		#sweetlist tr{border:1;border-top:1px solid black;border-bottom:1px solid black;}
		#sweetlist td{border:1;border-left:1px solid black;border-right:1px solid black;text-align: left;font-size: 15px;}
		.lst_tit{color:#000;}

		/*dl.capture dd{float:left;width:50%;margin-bottom:1%;}*/
		dl.capture dd{float:left;width:100%;padding:5px;}
		dl.capture dd img{width:100%;}
		#makingimglist {padding:0;}
		#makingimglist  dd{padding:0;}
		#makingimglist  dd img, #release_mediboxDiv img{width:100%;}
		#odAdviceDiv{min-height:200px;width:775px;border:1px solid #333;position:absolute;height:410px;word-break:break-all;word-wrap:break-word;}
</style>
<body>
<div style="display:none">
	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
</div>
<div class="section_print">
<input type="hidden" name="ChubcntDiv" value="">
    <div class="form_cont" style="padding-top:10px;">
		<div class="barcode" id="barcodeDiv" ></div>
		<div class="barcodetext" id="barcodeTextDiv"></div>
		<div>
			<table class="maintbl tbltitle">
				<tr>
					<th id="smuInoutFlagDiv"></th>
					<th id="odTitleDiv"></th>
				</tr>
			</table>
			<table class="maintbl">
				<tr>
					<th colspan="2" align="center"><?=$txtdt["orderno"]?></dt><!-- 주문번호 --></th>
					<td id="odCodeDiv" colspan="2" align="center"></td>
					<th colspan="2" align="center"><?=$txtdt["oddate"]?></dt><!-- 주문일 --></th>
					<td id="reDelidateDiv" colspan="2" align="center"></td>
				</tr>
				<tr>
					<th align="center"><?=$txtdt["chubcnt"]?></dt><!-- 첩수 --></th>
					<td id="odChubcnt" align="center"></td>
					<th align="center"><?=$txtdt["packtype"]?></dt><!-- 팩종류 --></th>
					<td id="odPacktype" align="center"></td>
					<th align="center"><?=$txtdt["packcapa"]?></dt><!-- 팩용량 --></th>
					<td id="odPackcapa" align="center"></td>
					<th align="center"><?=$txtdt["packcnt"]?></dt><!-- 팩수 --></th>
					<td id="odPackcnt" align="center"></td>
				</tr>
			</table>
			<!-- <table class="maintbl">
				<tr>
					<th colspan="2" align="center"><?=$txtdt["making"]?><!-- 조제 --></th>
					<!-- <td id="maStaffDiv" colspan="2" align="center" style="width:70px;"></td>
					<td id="maDateDiv" colspan="2" align="center" style="width:130px;"></td>
					<th colspan="2" align="center"><?=$txtdt["decoction"]?><!-- 탕전 --></th>
					<!-- <td id="dcStaffDiv" colspan="2" align="center"></td>
					<td id="dcDateDiv" colspan="2" align="center"></td>
				</tr>
				<tr>
					<th colspan="2" align="center"><?=$txtdt["marking"]?><!-- 마킹 --></th>
					<!-- <td id="mrStaffDiv" colspan="2" align="center"></td>
					<td id="mrDateDiv" colspan="2" align="center"></td>
					<th colspan="2" align="center"><?=$txtdt["release"]?><!-- 출고 --></th>
					<!-- <td id="reStaffDiv" colspan="2" align="center"></td>
					<td id="reDateDiv" colspan="2" align="center"></td>
				</tr>
				<tr>
					<th colspan="2" align="center"><?=$txtdt["9027"]?><!-- 한약사 확인 --></th>
					<!-- <td colspan="9" id="" align="center"></td>
				</tr>
			</table> -->  
			<table class="maintbl">
				</tr>
					<td style="padding:0;" id="medilist">
					</td>
				</tr>
			</table>
		</div>

	<!-- 탕전정보 -->
			<div class="form_dtl_pop">
				<div class="">
					<table class="decoctbl" id="decocID">
						<tbody>
						<tr>
							<th><?=$txtdt["titdecoction"]?><!-- 탕전법 --></th>
							<td id="dcTitle"></td>
							<th><?=$txtdt["decoctime"]?><!-- 탕전시간 --></th>
							<td id="dcTime"></td>
						</tr>
						<tr>
							<th><?=$txtdt["decocwater"]?><!-- 탕전물량 --></th>
							<td id="dcWater"></td>
							<th><?=$txtdt["spdecoction"]?><!-- 특수탕전 --></th>
							<td id="dcSpecial"></td>
						</tr>
						</tbody>
					</table>

					<table class="decoctbl" id="sfextID">
						<tbody>
						<tr>
							<th><?=$txtdt["9028"]?><!-- 제형 --></th>
							<td id="dcShape"></td>
							<th><?=$txtdt["9029"]?><!-- 결합제 --></th>
							<td id="dcBinders"></td>
						</tr>
						<tr>
							<th><?=$txtdt["9030"]?><!-- 분말도 --></th>
							<td id="dcFineness"></td>							
							<th><?=$txtdt["9002"]?><!-- 건조시간 --></th>
							<td id="dc_dry"></td>
						</tr>
						<tr>
							<th><?=$txtdt["9031"]?><!-- 제분손실 --></th>
							<td id="dcMillingloss"></td>
							<th><?=$txtdt["9032"]?><!-- 제환손실 --></th>
							<td id="dcLossjewan"></td>
						</tr>
						<tr>
							<th><?=$txtdt["9029"]?><!-- 결합제 --></th>
							<td id="dcBindersliang"></td>
							<th><?=$txtdt["9033"]?><!-- 완성량 --></th>
							<td id="dcCompleteliang"></td>
						</tr>
						</tbody>
					</table>
			</div>
		</div>

	<!-- 탕전정보end -->

		<div style="width:100%;overflow:hidden;padding:0;margin:0;">
			<!-- 조제 /선전,일반,후하,별전 이미지 -->
			<div class="fl" style="float:left;width:69%;padding:0;;margin:0;" >
				<h2 class="tit" align="center" style="border:1px solid #333;padding:10px;"><?=$txtdt["making"]?><!-- 조제 --></h2>
				<div class="img" id="imgDiv" style="width:535px;height:430px;padding:0;;margin:0;" >
					<dl class="capture" id="makingimglist" style="padding:0;margin-top:5px;"></dl>
				</div>
			</div>
			<div class="fr" style="float:left;width:29%;paddingn:0;margin-left:2%;; ">
				<h2 class="tit" align="center" style="border:1px solid #333;padding:10px;"><?=$txtdt["packingimg"]?><!-- 포장재이미지 --></h2>
				<div class="img" id="release_mediboxDiv" style="margin-top:5px;width:230px;height:175px;overflow:hidden;display:flex;align-items:center;justify-content:center;"></div>
			</div>
			<div class="fr" style="float:left;width:29%;paddingn:0;margin-left:2%;margin-top:0px;">
				<h2 class="tit" align="center" style="border:1px solid #333;padding:10px;"><?=$txtdt["pouchimg"]?><!--파우치이미지  --></h2>
				<div class="img" id="release_deliboxDiv" style="margin-top:5px;width:230px;height:175px;overflow:hidden;display:flex;align-items:center;justify-content:center;"></div>
			</div> 
		</div>

		<!-- 조제자 정보 -->
			<table class="maintbl" style="">
				<tr>
					<th colspan="2" align="center" ><?=$txtdt["making"]?><!-- 조제 --></th>
					<td id="maStaff" colspan="2" align="center" style="width:60px;"></td>
					<td id="maDate" colspan="2" align="center" style="width:40px;"></td>
				</tr>
				<tr>							
					<td colspan="4" align="center" style="width:70px;"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
					<td colspan="2" align="center" style="width:30px;"><?=$txtdt["9041"]?><!-- 서명 --></td>
				</tr>
				<tr>							
					<td colspan="4" align="left" style="width:70px;"><?=$txtdt["9036"]?></td><!-- 9036 텍스트가 길어서 두개에 걸쳐 나눠서 데이터 입력하여 수정하기 -->
					<td colspan="2" align="center" style="width:30px;" id="makingsignDiv"></td>
				</tr>
			</table>
		<!-- 조제자 정보 end -->

		<!-- 탕제 정보 -->
			<table class="maintbl" style="">
				<tr>
					<th colspan="2" align="center" ><?=$txtdt["decoction"]?><!-- 탕전 --></th>
					<td id="dcStaff" colspan="2" align="center" style="width:60px;"></td>
					<td id="dcDate" colspan="2" align="center" style="width:40px;"></td>
				</tr>
				<tr>							
					<td colspan="4" align="center" style="width:70px;"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
					<td colspan="2" align="center" style="width:30px;"><?=$txtdt["9041"]?><!-- 서명 --></td>
				</tr>
				<tr>							
					<td colspan="4" align="left" style="width:70px;"><?=$txtdt["9038"]?></td>
					<td colspan="2" align="center" style="width:30px;" id="decoctionsignDiv"></td>
				</tr>
			</table>
		<!-- 탕제 정보 end -->

		<!-- 마킹 정보 -->
			<table class="maintbl" style="">
				<tr>
					<th colspan="2" align="center" ><?=$txtdt[""]?>마킹<!-- 마킹marking --></th>
					<td id="mrStaff" colspan="2" align="center" style="width:60px;"></td>
					<td id="mrDate" colspan="2" align="center" style="width:40px;"></td>
				</tr>
				<tr>							
					<td colspan="4" align="center" style="width:70px;"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
					<td colspan="2" align="center" style="width:30px;"><?=$txtdt["9041"]?><!-- 서명 --></td>
				</tr>
				<tr>							
					<td colspan="4" align="left" style="width:70px;"><?=$txtdt["9039"]?></td>
					<td colspan="2" align="center" style="width:30px;" id="markingsignDiv"></td>
				</tr>
			</table>
		<!-- 마킹 정보 end -->

		<!-- 출고 정보 -->
			<table class="maintbl" >
				<tr>
					<th colspan="2" align="center" ><?=$txtdt["release"]?><!-- 출고 --></th>
					<td id="reStaff" colspan="2" align="center" style="width:60px;"></td>
					<td id="reDate" colspan="2" align="center" style="width:40px;"></td>
				</tr>
				<tr>							
					<td colspan="4" align="center" style="width:70px;"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
					<td colspan="2" align="center" style="width:30px;"><?=$txtdt["9041"]?><!-- 서명 --></td>
				</tr>
				<tr>							
					<td colspan="4" align="left" style="width:70px;"><?=$txtdt["9040"]?></td>
					<td colspan="2" align="center" style="width:30px;" id="releasesignDiv"></td>
				</tr>
				<tr>							
					<td colspan="4" align="center" style="width:70px;height:70px;"><?=$txtdt["9027"]?><!-- 한약사 확인 --></td>
					<td colspan="2" align="center" style="width:30px;" ></td>
				</tr>
			</table>
		<!-- 출고 정보 end -->

		<div style="width:100%;overflow:hidden;padding:0;margin:5px 0;">
			<h2 class="tit" align="center" style="border:1px solid #333;padding:10px;margin-bottom:5px;"><?=$txtdt["advice"]?><!-- 복약지도 --></h2>
			<div class="txt" id="odAdviceDiv">
			</div>
		</div>		
    </div> <!-- form_cont div -->
</div><!-- section_print div -->

</body>
</html>

<script>
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		
		$("#hublist tbody").html("");

		if(obj["apiCode"]=="orderreport")
		{
			$("#decocID").hide();
			$("#sfextID").hide();
			$("#edextractID").hide();

			var title = obj["miName"]+' - <?=$txtdt["9013"]?>';

			$("#smuInoutFlagDiv").text(title); 
			$("#odTitleDiv").text(obj["odTitle"]);//처방명
			
			//바코드
			$("#barcodeDiv").barcode(obj["qmCode"], "code128", {barWidth:2, barHeight: 40, fontSize:15, showHRI:false});
			$("#barcodeDiv").css('width', 'auto');
			$("#barcodeDiv").css('height', '40px');
			$("#barcodeDiv").css('margin-left', '-20px');

			//바코드텍스트 
			$("#barcodeTextDiv").text(obj["qmCode"]);
					
			$("#odCodeDiv").text(obj["odCode"]); //주문번호		
			$("#reDelidateDiv").text(obj["odDate"]); //주문일

			$("#odChubcnt").text(obj["odChubcnt"]+'<?=$txtdt["chub"]?>');  //첩수
			$("#odPacktype").text(obj["odPacktype"]);  //팩종류
			$("#odPackcapa").text(obj["odPackcapa"]+'ml'); //팩용량
			$("#odPackcnt").text(obj["odPackcnt"]+'<?=$txtdt["pack"]?>');  //팩수

			$("#maStaffDiv").text(obj["maStaff"]); //조제
			$("#maDateDiv").text(obj["maDate"]);

			$("#dcStaffDiv").text(obj["dcStaff"]); //탕전
			$("#dcDateDiv").text(obj["dcDate"]);

			$("#mrStaffDiv").text(obj["mrStaff"]); //검수
			$("#mrDateDiv").text(obj["mrDate"]);

			$("#reStaffDiv").text(obj["reStaff"]); //출고
			$("#reDateDiv").text(obj["re_date"]);

			/* 작업자 체크사항 부분 */
			$("#maStaff").text(obj["maStaff"]); //조제
			$("#maDate").text(obj["maDate"]);

			$("#dcStaff").text(obj["dcStaff"]); //탕전
			$("#dcDate").text(obj["dcDate"]);

			$("#mrStaff").text(obj["mrStaff"]); //검수
			$("#mrDate").text(obj["mrDate"]);

			$("#reStaff").text(obj["reStaff"]); //출고
			$("#reDate").text(obj["re_date"]);

			/* 작업자 사인 */
			$("#makingsignDiv").html("<div><img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["makingsign"]+"'/></div>");
			$("#decoctionsignDiv").html("<div><img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["decoctionsign"]+"'/></div>");
			$("#markingsignDiv").html("<div><img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["markingsign"]+"'/></div>");
			$("#releasesignDiv").html("<div><img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["releasesign"]+"'/></div>");

			$("#odAdviceDiv").text(obj["odAdvice"]);//복약지도

			$("input[name=ChubcntDiv]").val(obj["odChubcnt"]);

			//20191004 조제정보 추가

			if(obj["odMatype"]=="decoction")//탕제
			{
				$("#decocID").show();
			}
			else if(obj["odMatype"]=="sfextract")//연조엑스
			{

			}
			else if(obj["odMatype"]=="jehwan")//제환
			{
				$("#sfextID").show();
			}
			else if(obj["odMatype"]=="edextract")//농축엑기스
			{
				$("#edextractID").show();
			}


			//탕전구분 : 탕
			$("#odMeditype1").text(obj["odMeditype"]);


			//첩약처방명 : TS57022(대명전 가감)
			$("#odTitle").text(obj["odTitle"]);//<!-- 첩약처방명 -->

			//----------------------------------------------------------------------------
			//탕제 
			//----------------------------------------------------------------------------
			//탕전법
			$("#dcTitle").text(obj["dcTitle"]);
			//탕전시간
			var dcTime=!isEmpty(obj["dcTime"]) ? obj["dcTime"] : 60;
			$("#dcTime").text(dcTime+"<?=$txtdt['1437']?>");
			//탕전물량
			$("#dcWater").text(comma(obj["dcWater"])+"ml");
			//특수탕전 
			$("#dcSpecial").text(obj["dcSpecial"]);
			//----------------------------------------------------------------------------

			//----------------------------------------------------------------------------
			//제환  
			//----------------------------------------------------------------------------
			$("#dcShape").text(obj["dcShapeName"]);
			$("#dcBinders").text(obj["dcBindersName"]);
			$("#dcFineness").text(obj["dcFinenessName"]);
			$("#dcTerm").text(obj["dcTermsName"]);
			$("#dcMillingloss").text(obj["dc_millingloss"]+"g");
			$("#dcLossjewan").text(obj["dc_lossjewan"]+"g");
			$("#dcBindersliang").text(obj["dc_bindersliang"]+"g");
			$("#dcCompleteliang").text(obj["dc_completeliang"]+"g / "+obj["dc_completecnt"]+"ea");
			$("#dc_dry").text(obj["dc_dry"]+"<?=$txtdt['1842']?>");//건조시간 
			//----------------------------------------------------------------------------

			//농축엑기스 
			$("#edcFineness").text(obj["dcFinenessName"]);
			$("#dcRipen").text(obj["dcRipenName"]);
			$("#dcJungtang").text(obj["dcJungtangName"]);

			var url = "medicine="+obj["rcMedicine"]+"&sweet="+obj["rcSweet"];
			console.log("medicinetitle url>>>   "+url);  //medicine=|HD10336_15,1.0,inmain,0|HD10365_07,2.0,inmain,0&sweet=|HD10176_07,3,inlast,0
			callapi('GET','release','medicinetitle',url);

			var data=data2=data3="";

			//선전, 일반, 후하, 별전, 포장재이미지
			var marr=new Array("making_infirst","making_inmain","making_inafter","making_inlast","release_medibox", "release_pouch");
			
			//console.log(obj["files"]);
			for(var i=0;i<6;i++)
			{
				if(!isEmpty(obj["files"][marr[i]]))
				{
					if(i==4)//포장재이미지일경우(release_medibox)
					{
						data2+="<dd style=''><img src='"+getUrlData("FILE_DOMAIN")+obj["files"][marr[i]]["afUrl"]+"'/></dd> ";
					}
					else if(i==5)//박스이미지일경우(release_pouch)
					{
						
						data3+="<dd style=''><img src='"+getUrlData("FILE_DOMAIN")+obj["files"][marr[i]]["afUrl"]+"'/></dd> ";
					}
					else
					{
						data+="	<dd style='width:265px;height:200px;overflow:hidden;display:flex;align-items:center;justify-content:center;'><img src='"+getUrlData("FILE_DOMAIN")+obj["files"][marr[i]]["afUrl"]+"'/></dd> ";
					}
				}
				else
				{
					if(i==4)
					{
						data2+="<dd><img src='<?=$root?>/_Img/noimg.png'/></dd> ";
					}
					else if(i==5)
					{
						data3+="<dd><img src='<?=$root?>/_Img/noimg.png'/></dd> ";
					}
					else
					{
						data+=""; //조제에서 선전, 일반, 후하, 별전 이미지가 없을경우 noimg 표시하지 않음
					}				
				}
			}

			$("#makingimglist").html(data);  //조제등 이미지
			$("#release_mediboxDiv").html(data2);//포장재 이미지
			$("#release_deliboxDiv").html(data3);//박스 이미지
		
			setTimeout('print();', 500);
		}
		else if(obj["apiCode"]=="medicinetitle") 
		{
			var totcapa=sweetcapa=medicapa=cnt=0;
			var value=rcmedicine=medibox=data="";

			//별전&약재리스트
			var	data='<table class="subtbl fitbl">';
					data+='<col style="width:10%;"><col style="width:60%;"><col style="width:30%;">';					
					data+='<tbody>';
			var	table='<table class="subtbl">';
					table+='<col style="width:10%;"><col style="width:60%;"><col style="width:30%;">';					
					table+='<tbody>';

			
			var newMediSweet;
			if(!isEmpty(obj["sweet"]))
			{
				newMediSweet=obj["sweet"].concat(obj["medicine"]);
			}
			else
			{
				newMediSweet=obj["medicine"];
			}

			cnt=newMediSweet.length;
			
			for(var i=0;i<42;i++)
			{
				if(i==0 || i % 14 == 0)
				{
					if(i==0){
						data+=table.replace("subtbl","subtbl fitbl");
					}else if(i==28){
						data+="</tbody></table>"+table.replace("subtbl","subtbl lstbl");
					}else{
						if(i>0){data+="</tbody></table>"+table;}
					}
					data+="<tr><th colspan='2'><?=$txtdt['9025']?><!-- 품목 --></th><th><?=$txtdt['9026']?><!-- 용량 --></th></tr>";
				}
				if(i<cnt)
				{
					value=newMediSweet[i];//obj["medicine"][i];
					if(value["rcDecoctype"]=='inlast')
					{
						medicapa=parseFloat(value["rcCapa"]);
						sweetcapa+=medicapa;
					}
					else
					{					
						medicapa = parseFloat(value["rcCapa"]) * $("input[name=ChubcntDiv]").val();
					}

					if(value["rcmedibox"].indexOf("00000") >= 0)
					{
						medibox = "▲";
					}
					else
					{
						if(isEmpty(value["rcmedibox"]))
							medibox = "X";
						else
							medibox = "O";
					}				
					data+='<tr>';

						var rcDecoctypedata="";
						if(value["rcDecoctype"]=='infirst')
						{
							rcDecoctypedata="선";
						}
						else if(value["rcDecoctype"]=='inmain')
						{
							rcDecoctypedata="일";
						}
						else if(value["rcDecoctype"]=='inafter')
						{
							rcDecoctypedata="후";
						}
						else if(value["rcDecoctype"]=='inlast')
						{
							rcDecoctypedata="별";
						}

					data+='	<td class="lt fi">'+rcDecoctypedata+'</td>';

					if(!isEmpty(value["exceltitle"]))
					{
						data+='	<td class="lt">'+value["exceltitle"]+''+'</td>';
					}
					else
					{

						data+='	<td class="lt">'+value["rcMedititle"]+''+'</td>';//품목 
					}
					
					data+='	<td>'+(parseFloat(medicapa).toFixed(1))+'</td>';
					data+='</tr>';
				}
				else
				{
					data+='<tr><td class="lt fi"></td><td></td><td></td></tr>';
				}
			}
			data+='</tbody></table>';
			
			$("#medilist").html(data);
		}
	}

	callapi('GET','release','orderreport',"<?=$apiData?>");
</script>
