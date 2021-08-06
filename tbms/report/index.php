<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/headpop.php";
	
	//HQhR3EHfUZwCAmZywQbJhnuzU5UW5jSeLOoBTuf9pQA=
	//$data="2006220000407883|2323";
	//$key=djEncrypt($data, $labelAuthkey);
	//echo "key:".$key;

	$key=$_GET["key"];
	if($key)
	{
		//$reportkey = djDecrypt($key, $labelAuthkey);
		////$reArr=explode("|",$reportkey);
		//$odcode=$reArr[0];//odcode
		//$mobile=$reArr[1];//전화번호 
		$apiData="code=ODD".$key."&report=Y";
	}
	else
	{
		//echo "<script>alert('key가 없습니다.');self.close();</script>";
		echo "<script>alert('key가 없습니다.');</script>";
	}
	//echo "key=".$key."<br>";
	//echo "odcode=".$odcode."<br>";
	//echo "mobile=".$mobile."<br>";
?>
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

		#layersign{display:none;}

.section_login{color:#fff; text-align:center;}
.section_login h2{margin-top:80px; font-size:36px; font-weight:700;}
.section_login .info_txt{margin:10px 0 25px; line-height:30px; font-size:18px;}
.section_login .btn_go{display:inline-block; padding:0 10px; min-width:220px; line-height:40px; font-size:14px; color:#fff; background-color:rgba(0,0,0,.3);}
.section_login .login_box{display:block; margin:50px auto; padding:50px 56px 0; width:382px; height:197px; background-color:rgba(0,0,0,.3);}
.section_login .login_box input{margin-bottom:8px; padding:0 10px; width:100%; height:46px; font-size:18px; color:#fff; text-align:center; background-color:rgba(255,255,255,.5); border:none;}
.section_login .login_box input::-webkit-input-placeholder{color:#fff;}
.section_login .login_box input:-moz-placeholder,
.section_login .login_box input::-moz-placeholder{color:#f2f2f2; opacity:1;}
.section_login .login_box .btn{display:block; margin:6px 0 13px; width:100%; height:50px; line-height:50px; font-size:18px; color:#fff; background-color:#f26161;}





</style>
<body>
<div style="display:none">
	<input type="hidden" name="mobile" id="mobile" class="" placeholder="" value="<?=$mobile;?>" />
	<input type="hidden" name="odcode" id="odcode" class="" placeholder="" value="<?=$key;?>" />
	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
</div>
<div class="section_login">
	<div class="login_box" id="lbl_login">
		<input type="password" name="lblpwd" id="lblpwd" class="reqdata" placeholder="비밀번호를 입력해 주세요." value="" onKeydown="enterchkpwd();" />
		<button type="button" class="btn" onclick="javascript:labelchkpwd();">확인</button>
	</div>	
</div><!-- section_print div -->

<div class="section_print" id="lbl_data"></div>

</body>
</html>

<script>
	function enterchkpwd()
	{
		var keyCode = window.event.keyCode;
		if(keyCode==13) 
		{
			labelchkpwd();
		}
	}
	function labelchkpwd()
	{
		var odcode=$("input[name=odcode]").val();
		var lblpwd=$("input[name=lblpwd]").val();

		if(isEmpty(lblpwd))
		{
			alert("비밀번호를 입력해 주세요.");
		}
		else
		{
			var data="pwd="+lblpwd+"&code="+odcode;
			callopenapi('GET','release','orderreportpwd',data);
			/*if(mobile==lblpwd)
			{
				$("#lbl_login").hide();
				$("#lbl_data").load("<?=$root?>/report/report.php", function(){callopenapi('GET','release','orderreport',"<?=$apiData?>");});
			}
			else
			{
				alert("비밀번호가 다릅니다. 다시 입력해 주세요.");
				$("input[name=lblpwd]").val("");
				$("input[name=lblpwd]").focus();
			}*/
		}

	}
	function callopenapi(type,group,code,data)
	{
		//alert("callopenapi : "+ data);
		console.log("callopenapi data : "+data);
		var language=$("#gnb-wrap").attr("value");
		var timestamp = new Date().getTime();
		if(isEmpty(language)){language="kor";}
		language="kor";
		var url=getUrlData("API_TBMS")+group+"/";
		switch(type)
		{
		case "GET": case "DELETE":
			url+="?apiCode="+code+"&language="+language+"&v="+timestamp+"&"+data;
			data="";
			break;
		case "POST":
			data["apiCode"]=code;
			data["language"]=language;
			break;
		}

		//var key=getCookie("ck_authkey");
		//var id=getCookie("ck_stStaffid");

		//console.log("callapi url : "+url+", key="+key+"&id="+id);
		$.ajax({
			type : type, //method
			url : url,
			data : data,
			//headers : {"ck_authkey" : key, "ck_stStaffid" : id },
			success : function (result) {
				//chkMember(type, result);
				//alert("ajax : "+ result);
				makepage(result);
			},
			error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
	   });
	}
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		//alert("makepage1 : "+ obj);
		
		$("#hublist tbody").html("");

		if(obj["apiCode"]=="orderreport")
		{
			$("#decocID").hide();
			$("#sfextID").hide();
			$("#edextractID").hide();
		
			$("#odTitleDiv").text(obj["odTitle"]);//처방명
			
			//바코드
			//$("#barcodeDiv").barcode(obj["qmCode"], "code128", {barWidth:2, barHeight: 40, fontSize:15, showHRI:false});
			//$("#barcodeDiv").css('width', 'auto');
			//$("#barcodeDiv").css('height', '40px');
			//$("#barcodeDiv").css('margin-left', '-20px');

			//바코드텍스트 
			//$("#barcodeTextDiv").text(obj["qmCode"]);
			var title = obj["miName"]+' - <?=$txtdt["9047"]?>';  //9047 품질보고서
			$("#barcodeTextDiv").text(title);
					
			//$("#odCodeDiv").html("<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;margin-right:5px;'>"+obj["odChartPK"]+"</span>"+obj["odCode"]+"  "); //주문번호
			$("#odCodeDiv").text(obj["odCode"]); //주문번호
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
			
/*
			$("#maStaffDiv").text(obj["maStaff"]); //조제
			$("#maDateDiv").text(obj["maDate"]);

			$("#dcStaffDiv").text(obj["dcStaff"]); //탕전
			$("#dcDateDiv").text(obj["dcDate"]);

			$("#mrStaffDiv").text(obj["mrStaff"]); //검수
			$("#mrDateDiv").text(obj["mrDate"]);

			$("#reStaffDiv").text(obj["reStaff"]); //출고
			$("#reDateDiv").text(obj["re_date"]);
*/
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

			$("#odAdviceDiv").html(obj["odAdvice"]);//복약지도

			$("input[name=ChubcntDiv]").val(obj["odChubcnt"]);

			//20191004 조제정보 추가

			if(obj["odMatype"]=="decoction")//탕제
			{
				$("#decocID").show();
			}
			else if(obj["odMatype"]=="sfextract")//연조엑스
			{

			}
			else if(obj["odMatype"]=="jewan")//제환
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
			//탕전기코드
			$("#dcBoiler").text(obj["dcBoiler"]);
			//포장기코드
			$("#dcPacking").text(obj["dcPacking"]);
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
			//console.log("medicinetitle url>>>   "+url);  //medicine=|HD10336_15,1.0,inmain,0|HD10365_07,2.0,inmain,0&sweet=|HD10176_07,3,inlast,0
			//callapi('GET','release','medicinetitle',url);

			var data="";

			//선전, 일반, 후하, 별전
			//var marr=new Array("making_infirst","making_inmain","making_inafter","making_inlast","release_medibox", "release_pouch");
			var marr=new Array("making_infirst","making_inmain","making_inafter","making_inlast");
			
			//console.log(obj["files"]);
			for(var i=0;i<4;i++)
			{
				if(!isEmpty(obj["files"][marr[i]]))
				{
					data+="	<dd style='overflow:hidden;display:flex;align-items:center;justify-content:center;'><img src='"+getUrlData("FILE_DOMAIN")+obj["files"][marr[i]]["afUrl"]+"'/></dd> ";									
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
					data3+="	<dd style='overflow:hidden;display:flex;align-items:center;justify-content:center;'><img src='"+getUrlData("FILE_DOMAIN")+obj["boximg"][i]["afUrl"]+"'/></dd> ";		
				}
				else
				{
					data3+=""; //이미지가 없을경우 noimg 표시하지 않음									
				}
			}

			$("#release_deliboxDiv").html(data3);//포장 이미지
			//setTimeout('print();', 500);


			//약재정보----------------------------------------------------------------------------------------------------------
			var	data=afFile="";

			$("#mdtbl tbody").html("");
			if(!isEmpty(obj["qualitylist"]))
			{		
				$(obj["qualitylist"]).each(function( index, value )
				{		
					afFile = (value["afThumbUrl"] == 'NoIMG') ? "<img src='../_Img/noimg.png'>" : "<img src='"+getUrlData("FILE_DOMAIN")+value["afThumbUrl"]+"'>";

					if(isEmpty(value["whExpired"])){whExpiredDiv=" - ";}else{whExpiredDiv=value["whExpired"];}
					if(isEmpty(value["whIndate"]))
					{
						whIndateDiv=" - ";
					}
					else if(value["whIndate"]=="1970.01.01")  //warehouse에 없을경우 이 날짜로 나옴
					{
						whIndateDiv=" - ";
					}
					else
					{
						whIndateDiv=value["whIndate"];
					}

					data+="<tr>";
					data+="<td class='l'>"+afFile+"</td>"; //이미지  //2017/12/12/20171212110619.png
					data+="<td class='l'>"+value["mdTitleKor"]+"</td>"; //약재명
					data+="<td class='r'>"+value["capaTotal"]+" g"+"</td>"; //총약재량
					data+="<td>"+value["mdOrigin_kor"]+"</td>"; //원산지
					data+="<td>"+value["mdMaker_kor"]+"</td>"; //생산자
					data+="<td>"+whIndateDiv+"</td>"; //재고입고일	
					data+="<td>"+whExpiredDiv+"</td>"; //유통기한
					data+="</tr>";
				});
				
			}
			$("#mdtbl tbody").html(data);
		
			//--------------------------------------------------------------------------------------------------------------
		}
		else if(obj["apiCode"]=="orderreportpwd")
		{
			if(obj["resultCode"]=="200")
			{
				$("#lbl_login").hide();
				$("#lbl_data").load("<?=$root?>/report/report.php", function(){callopenapi('GET','release','orderreport',"<?=$apiData?>");});
			}
			else
			{
				alert(obj["resultMessage"]);
			}
		}
	}
	$("input[name=lblpwd]").focus();
</script>
