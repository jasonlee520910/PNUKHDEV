<?php
	///이건 안씀..
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
		.barcodetext {margin-top:-1px;font-size:16px;font-weight:bold;}
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

		.form_dtl_pop{overflow:hidden;width:100%;margin-bottom: 5px;}
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

		table.signtbl{width:100%;table-layout:fixed;}
		table.signtbl tr td{text-align:center;}
		table.signtbl tr td.lf{text-align:left;}
		table.signtbl tr td img{width:90%;height:100px;margin:5px auto;}

		.advice{width:100%;overflow:hidden;padding:0;margin:5px 0;}
		h2.tit{text-align:center;border:1px solid #333;padding:10px;margin:5px 0;overflow:hidden;}
		.advice .addiv{width:auto;min-height:100px;border:1px solid #666;margin:0;padding:0;}
		.ptdiv{padding:0;;margin:0;}
		.ptdiv.lf{float:left;width:66%;}
		.ptdiv.lf .img{width:535px;height:430px;padding:0;;margin:0;}
		.ptdiv.lf .img dl{padding:0;margin-top:5px;}
		.ptdiv.lf .img dl dd{float:left;width:40%;padding:0;margin:2px 0;}
		.ptdiv.lf .img dl dd img{width:99%;margin:2px auto;}
		.ptdiv.rt{float:left;width:33%;margin-left:0%;}
		.ptdiv.rt .ptdiv2{width:100%;margin-left:2%;;}
		.ptdiv.rt .ptdiv2 .img{padding:0;margin:0;}

		/* 약재정보 추가 */
		.meditbl{width:100%;border-top:1px solid #333;border-left:1px solid #333;margin-bottom:10px;font-size:12px;}
		.meditbl tr th, .meditbl tr td{border-right:1px solid #333;border-bottom:1px solid #333}

		/* table.signtbl{/* width:100%; *//*table-layout:fixed;} */
		/*  td.thumb img{max-width:90%;max-height:50px;}*/

</style>
<body>
<div style="display:none">
	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
</div>
<div class="section_print">
	<input type="hidden" name="ChubcntDiv" value="">
    <div class="form_cont" style="padding-top:10px;">
		<div>
			<table class="maintbl">
				<col width="10%"><col width="10%"><col width="10%"><col width="20%">
				<col width="10%"><col width="15%"><col width="10%"><col width="15%">
				<tr>
					<th align="center"><?=$txtdt["orderno"]?></dt><!-- 주문번호 --></th>
					<td id="odCodeDiv" colspan="3"></td>
					<th align="center"><?=$txtdt["oddate"]?></dt><!-- 주문일 --></th>
					<td id="reDelidateDiv" colspan="3" align="center"></td>
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
			<table class="maintbl">
				<col width="10%"><col width="13%"><col width="10%"><col width="10%">
				<col width="10%"><col width="15%"><col width="10%"><col width="22%">
				<tr>
					<th align="center">환자명<?//=$txtdt["chubcnt"]?></dt><!-- 첩수 --></th>
					<td id="odName" align="center"></td>
					<th align="center">성별<?//=$txtdt["packtype"]?></dt><!-- 팩종류 --></th>
					<td id="odGender" align="center"></td>
					<th align="center">생년월일<?//=$txtdt["packcapa"]?></dt><!-- 팩용량 --></th>
					<td id="odBirth" align="center"></td>
					<th align="center">전화번호<?//=$txtdt["packcnt"]?></dt><!-- 팩수 --></th>
					<td id="odMobile" align="center"></td>
				</tr>
			</table>
		</div>

		<!-- 조제자 정보 -->
		<table class="maintbl signtbl">
			<col width="46%"><col width="21%"><col width="33%">
			<tr>
				<th><?=$txtdt["making"]?><!-- 조제 --></th>
				<td id="maStaff"></td>
				<td id="maDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9036"]?></td>
				<td id="makingsignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["decoction"]?><!-- 탕전 --></th>
				<td id="dcStaff" ></td>
				<td id="dcDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9038"]?></td>
				<td id="decoctionsignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["marking"]?><!-- 마킹 --></th>
				<td id="mrStaff"></td>
				<td id="mrDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9039"]?></td>
				<td id="markingsignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["9046"]?><!-- 포장 --></th>
				<td id="reStaff"></td>
				<td id="reDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9040"]?></td>
				<td id="releasesignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["9045"]?><!-- 출하 --></th>
				<td id="delitype"></td>
				<td id="confirmdate"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>							
				<td colspan="2" align="center" style="width:70px;height:70px;"><?=$txtdt["9027"]?><!-- 한약사 확인 --></td>
				<td align="center" style="width:30px;" ></td>
			</tr>
		</table>

		<!-- 조제 /선전,일반,후하,별전 이미지 -->
		<div class="ptdiv lf">
			<h2 class="tit"><?=$txtdt["making"]?><!-- 조제 --></h2>
			<div class="img" id="imgDiv">
				<dl id="makingimglist"></dl>
			</div>
		</div>
		<div class="ptdiv rt">
			<div class="ptdiv2">
				<h2 class="tit"><?=$txtdt["9046"]?><!--포장--></h2>
				<div class="img" id="release_deliboxDiv"></div>
			</div>
		</div>
	</div>
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

			var title = obj["miName"]+' - <?=$txtdt["9047"]?>';  //9047 품질보고서
			$("#barcodeTextDiv").text(title);
					
			$("#odCodeDiv").html("<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;margin-right:5px;'>"+obj["odChartPK"]+"</span>"+obj["odCode"]+"  "); //주문번호		s
			$("#reDelidateDiv").text(obj["odDate"]); //주문일

			$("#odChubcnt").text(obj["odChubcnt"]+'<?=$txtdt["chub"]?>');  //첩수

			if(!isEmpty(obj["cyPouchImg"]))
			{
				//파우치
				$("#odPacktype").text(obj["cyPouchName"]);//파우치이름
			}
			else
			{
				$("#odPacktype").text(obj["odPacktype"]);  //팩종류
			}

			
			$("#odPackcapa").text(obj["odPackcapa"]+'ml'); //팩용량
			$("#odPackcnt").text(obj["odPackcnt"]+'<?=$txtdt["pack"]?>');  //팩수

			$("#odName").text(obj["odName"]);  //환자명
			$("#odGender").text(obj["odGenderTxt"]);  //성별
			$("#odBirth").text(obj["odBirth"]);  //생년월일
			$("#odMobile").text(obj["odMobile"]);  //전화번호

			/* 작업자 체크사항 부분 */
			$("#maStaff").text(obj["maStaff"]); //조제
			$("#maDate").text(obj["maDate"]);

			$("#dcStaff").text(obj["dcStaff"]); //탕전
			$("#dcDate").text(obj["dcDate"]);

			$("#mrStaff").text(obj["mrStaff"]); //검수
			$("#mrDate").text(obj["mrDate"]);

			$("#reStaff").text(obj["reStaff"]); //출고
			$("#reDate").text(obj["reDate"]);

			$("#delitype").text(obj["delitype"]); //택배종류 
			$("#confirmdate").text(obj["confirmdate"]);  //생성출하일



			

			/* 작업자 사인 */
			if(!isEmpty(obj["makingsign"]))
			{
				$("#makingsignDiv").html("<img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["makingsign"]+"'/>");
			}
			else
			{
				$("#makingsignDiv").html("");
			}

			if(!isEmpty(obj["decoctionsign"]))
			{
				$("#decoctionsignDiv").html("<img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["decoctionsign"]+"'/>");
			}
			else
			{
				$("#decoctionsignDiv").html("");
			}

			if(!isEmpty(obj["markingsign"]))
			{
				$("#markingsignDiv").html("<img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["markingsign"]+"'/>");
			}
			else
			{
				$("#markingsignDiv").html("");
			}

			if(!isEmpty(obj["releasesign"]))
			{
				$("#releasesignDiv").html("<img style='width:180px;height:auto;'src='"+getUrlData("FILE_DOMAIN")+obj["releasesign"]+"'/>");
			}
			else
			{
				$("#releasesignDiv").html("");
			}

			$("input[name=ChubcntDiv]").val(obj["odChubcnt"]);


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
			//console.log("medicinetitle url>>>   "+url);  //medicine=|HD10336_15,1.0,inmain,0|HD10365_07,2.0,inmain,0&sweet=|HD10176_07,3,inlast,0
			callapi('GET','release','medicinetitle',url);

			var data="";

			//선전, 일반, 후하, 별전
			//var marr=new Array("making_infirst","making_inmain","making_inafter","making_inlast","release_medibox", "release_pouch");
			var marr=new Array("making_infirst","making_inmain","making_inafter","making_inlast");
			
			//console.log(obj["files"]);
			for(var i=0;i<4;i++)
			{
				if(!isEmpty(obj["files"][marr[i]]))
				{
					data+="	<dd style='width:255px;height:200px;overflow:hidden;display:flex;align-items:center;justify-content:center;'><img src='"+getUrlData("FILE_DOMAIN")+obj["files"][marr[i]]["afUrl"]+"'/></dd> ";									
				}
				else
				{
					data+=""; //조제에서 선전, 일반, 후하, 별전 이미지가 없을경우 noimg 표시하지 않음									
				}
			}

			$("#makingimglist").html(data);  //조제등 이미지


			//포장이미지
			var data3="";
			var imglength=obj["boximg"].length;
			
			for(var i=0;i<imglength;i++)
			{
				if(!isEmpty(obj["boximg"]))
				{
					data3+="	<dd style='width:255px;height:200px;overflow:hidden;display:flex;align-items:center;justify-content:center;'><img src='"+getUrlData("FILE_DOMAIN")+obj["boximg"][i]["afUrl"]+"'/></dd> ";		
				}
				else
				{
					data3+=""; //이미지가 없을경우 noimg 표시하지 않음									
				}
			}

			$("#release_deliboxDiv").html(data3);//포장 이미지
			//setTimeout('print();', 500);
			//--------------------------------------------------------------------------------------------------------------
		}
	}
	callapi('GET','release','orderreport',"<?=$apiData?>");
</script>
