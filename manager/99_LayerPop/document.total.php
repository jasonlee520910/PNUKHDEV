<?php 
	$root = "..";
	$odCode=$_GET["odCode"];
	$apiprinterData = "odCode=".$odCode;
	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
	/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
	html{background:none; min-width:0; min-height:0;}
	.section_print{width: 21cm;min-height: 29.7cm; page-break-after: always }
	.barcode img{width:300px;height:54px;}
	.lst_tb{overflow:hidden;}
	.lst_tb table{width:49%;float:left;margin-right:1%;}
	.lst_tb table.one{width:100%;float:left;margin-right:1%;}
	.form_dtl .lst_tb table tbody tr.meditr td{padding:5px;}
	.form_dtl .lst_tb table tbody tr.meditr td.mediumfont{padding:5px;font-size: 13px;}
	.form_dtl .lst_tb table tbody tr.meditr td.smallfont{padding:5px;font-size: 12px;}
	.totalcapa {float:right;}

	#sweetlist{width:99%;border:0;border-right:1px solid #ddd;border-left:1px solid #ddd;font-size:15px;}
	#sweetlist tr{border:1;border-top:1px solid black;border-bottom:1px solid black;}
	#sweetlist td{border:1;border-left:1px solid black;border-right:1px solid black;text-align: center;font-size: 12px;}
</style>
<input type="hidden" name="odChubcnt" id="odChubcnt" value="">
<!--making-->
<div class="section_print">
    <div class="form_cont">
        <!-- view_lst안에 들어가는 부분 -->
        <h3 class="dtl_tit" id="titleDiv"></h3>
        <div class="form_dtl">
            <div class="barcode" id="barcodeDiv">

            </div>
			 <div class="form_info">
				<dl>
					<dt><?=$txtdt["1597"]?></dt><!-- 문서번호 -->
					<dd><em id="maCodeDIV"></em></dd>
				</dl>
				<dl>
					<dt><?=$txtdt["1602"]?> :</dt><!-- 조제사 -->
					<dd><em id="staffDIV"></em></dd>
				</dl>
				<dl>
					<dt><?=$txtdt["1609"]?></dt><!-- 주문번호 -->
					<dd id="odCodeDiv"></dd>
				</dl>
				<dl>
					<dt><?=$txtdt["1304"]?></dt><!-- 주문일 -->
					<dd id="odDateDiv"></dd>
				</dl>
			</div>
        </div>
        <!-- //view_lst안에 들어가는 부분 -->

        <div class="form_dtl">
			<div> <!-- basic -->
				<div class="fl">
					<div class="row">
						<dl>
							<dt><?=$txtdt["1323"]?></dt><!-- 처방명 -->
							<dd><strong class="tit" id="dodTitleDiv"></strong></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1403"]?></dt><!-- 한의원 -->
							<dd id="dmeNameDiv"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1328"]?></dt><!-- 처방자 -->
							<dd id="dodStaffDiv"></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1603"]?></dt><!-- 팩종류 -->
							<dd id="dodPacktypeDiv"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1386"]?></dt><!-- 팩용량 -->
							<dd id="dodPackcapaDiv"></dd>
						</dl>
					</div>
				</div>
				<div class="fr">
					<div class="row">
						<dl>
							<dt id="dateDiv"><?=$txtdt["1112"]?></dt><!-- 배송희망일 -->
							<dd id="dreDelidateDiv"></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1335"]?></dt><!-- 첩수 -->
							<dd id="dodChubcntDiv"><?=$txtdt["1330"]?><!-- 첩 --></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1384"]?></dt><!-- 팩수 -->
							<dd id="dodPackcntDiv"><?=$txtdt["1604"]?><!-- 팩 --></dd>
						</dl>
					</div>
				</div>
			</div>

			<div class="lst_tb">
				<h3 class="lst_tit"><?=$txtdt["1203"]?></h3><!-- 약재리스트 -->
				<div id="medilstDiv"></div>
				<h3 id="totalcapaDiv" class="totalcapa"></h3> <!-- 누적량 -->
			</div>
			<div class="lst_tb2" >
				<div id="sweetDiv"></div> <!-- 앰플/기타약재  내용  -->
			</div>
			<div class="ip_txt">
				<h3 class="tit"><?=$txtdt["1610"]?></h3><!-- 조제요청사항 -->
				<div class="txt" style="height:50px;"><!-- <?=nl2br($json["odRequest"])?> --></div>
			</div>
        </div>
    </div>
</div>

<!--decoction-->
<div class="section_print">
    <div class="form_cont">
        <!-- view_lst안에 들어가는 부분 -->
        <h3 class="dtl_tit" id="dtitleDiv"></h3><!--  - <?=$txtdt["1615"]?>탕전일지 -->
        <div class="form_dtl">
            <div class="barcode" id="dbarcodeDiv">
            </div>
            <div class="form_info">
                <dl>
                    <dt><?=$txtdt["1597"]?></dt><!-- 문서번호 -->
                    <dd><em id="dcCodeDiv"></em></dd>
                </dl>
                <dl>
                    <dt><?=$txtdt["1368"]?> :</dt><!-- 탕전사 -->
                    <dd><em id="dstaffDiv"></em></dd>
                </dl>
                <dl>
                    <dt><?=$txtdt["1609"]?></dt><!-- 주문번호 -->
                    <dd id="dodCodeDiv"></dd>
                </dl>
                <dl>
                    <dt><?=$txtdt["1304"]?></dt><!-- 주문일 -->
                    <dd id="dodDateDiv"></dd>
                </dl>
            </div>
        </div>
        <!-- //view_lst안에 들어가는 부분 -->

        <div class="form_dtl">
			<div><!-- basic -->
				<div class="fl">
					<div class="row">
						<dl>
							<dt><?=$txtdt["1323"]?></dt><!-- 처방명 -->
							<dd><strong class="tit" id="odTitleDiv"></strong></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1403"]?></dt><!-- 한의원 -->
							<dd id="meNameDiv"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1328"]?></dt><!-- 처방자 -->
							<dd id="odStaffDiv"></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1603"]?></dt><!-- 팩종류 -->
							<dd id="odPacktypeDiv"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1386"]?></dt><!-- 팩용량 -->
							<dd id="odPackcapaDiv"></dd>
						</dl>
					</div>
				</div>
				<div class="fr">
					<div class="row">
						<dl>
							<dt id="dateDiv"><?=$txtdt["1112"]?></dt><!-- 배송희망일 -->
							<dd id="reDelidateDiv"></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1335"]?></dt><!-- 첩수 -->
							<dd id="odChubcntDiv"><?=$txtdt["1330"]?><!-- 첩 --></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1384"]?></dt><!-- 팩수 -->
							<dd id="odPackcntDiv"><?=$txtdt["1604"]?><!-- 팩 --></dd>
						</dl>
					</div>
				</div>
			</div>

			<div style="clear:both;padding-top:30px;">
				<h3 class="tit"><?=$txtdt["1616"]?></h3><!-- 탕전지시사항 -->
				<div class="order_chk" id="decocorderDiv"></div>
				<div class="fl">
						<div class="txt" style="height:80px;"><?=$json["odRequest"]?></div>
						<div class="row2">
							<dl>
								<dt><?=$txtdt["1367"]?></dt><!-- 탕전법 -->
								<dd id="dcTitleDiv"></dd>
							</dl>
							<dl>
								<dt><?=$txtdt["1617"]?></dt><!-- 탕전기번호 -->
								<dd id="nodecocDiv"></dd>
							</dl>
						</div>
						<div class="row2">
							<dl>
								<dt><?=$txtdt["1381"]?></dt><!-- 특수탕전 -->
								<dd id="dcSpecialDiv"></dd>
							</dl>
							<dl>
								<dt><?=$txtdt["1369"]?></dt><!-- 탕전시간 -->
								<dd id="dcTimeDiv"></dd>
							</dl>
						</div>
						<div class="row2">
							<dl>
								<dt><?=$txtdt["1042"]?></dt><!-- 기타처리 -->
								<dd id="etcDiv"></dd>
							</dl>
							<dl>
								<dt><?=$txtdt["1366"]?></dt><!-- 탕전물량 -->
								<dd id="dcWaterDiv"></dd>
							</dl>
						</div>
						<div class="lst_tb">
							<h3 class="lst_tit"><?=$txtdt["1618"]?></h3><!-- 앰플/기타약재 -->
							<table summary="<?=$txtdt["1618"]?>" id="pdecoctiontbl">
								<caption class="hide"><?=$txtdt["1619"]?></caption><!-- 앰플/기타약재 리스트 -->
								<colgroup>
									<col width="30%" />
									<col width="" />
									<col width="15%" />
								</colgroup>
								<thead>
									<tr>
										<th scope="col"><?=$txtdt["1359"]?></th><!-- 타입 -->
										<th scope="col"><?=$txtdt["1521"]?></th><!-- 종류 -->
										<th scope="col"><?=$txtdt["1620"]?></th><!-- 수량 -->
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
				</div>
				<div class="fr">
					<div class="row">
						<dl>
							<dt><?=$txtdt["1621"]?></dt><!-- 시작시간 -->
							<dd></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1622"]?></dt><!-- 종료시간 -->
							<dd></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1623"]?></dt><!-- 포장기번호 -->
							<dd></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1613"]?></dt><!-- 약재량 -->
							<dd id="totMedicapaDiv"></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1498"]?></dt><!-- 약미 -->
							<dd id="cntMedicineDiv"></dd>
						</dl>
					</div>
					<br><br>
					<div class="row">
						<h3 class="tit"><?=$txtdt["1470"]?></h3><!-- 파우치 -->
						<div class="img" style="height:90px;" id="dodPackimgDiv"></div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<!--marking-->
<div class="section_print">
    <div class="form_cont">
        <!-- view_lst안에 들어가는 부분 -->
        <h3 class="dtl_tit" id="mtitleDiv"><!-- <?=$json["meName"]?> - <?=$txtdt["1624"]?> --></h3><!-- 마킹/배송일지 -->
        <div class="form_dtl">
			<div class="barcode" id="mbarcodeDiv">
			</div>
			<div class="form_info">
				<dl>
					<dt><?=$txtdt["1597"]?></dt><!-- 문서번호 -->
					<dd><em id="mrCodeDiv"><!-- <?=$json["mrCode"]?> --></em></dd>
				</dl>
				<dl>
					<dt><?=$txtdt["1625"]?> :</dt><!-- 마킹사 -->
					<dd><em id="mstaffDiv"><!-- <?=$staff?> --></em></dd>
				</dl>
				<dl>
					<dt><?=$txtdt["1609"]?></dt><!-- 주문번호 -->
					<dd id="modCodeDiv"><!-- <?=$json["odCode"]?> --></dd>
				</dl>
				<dl>
					<dt><?=$txtdt["1304"]?></dt><!-- 주문일 -->
					<dd id="modDateDiv"><!-- <?=$json["odDate"]?> --></dd>
				</dl>
			</div>
        </div>
        <!-- //view_lst안에 들어가는 부분 -->
        <div class="form_dtl">
			<div> <!-- basic -->
				<div class="fl">
					<div class="row">
						<dl>
							<dt><?=$txtdt["1323"]?></dt><!-- 처방명 -->
							<dd><strong class="tit" id="modTitleDiv"></strong></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1403"]?></dt><!-- 한의원 -->
							<dd id="mmeNameDiv"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1328"]?></dt><!-- 처방자 -->
							<dd id="modStaffDiv"></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1603"]?></dt><!-- 팩종류 -->
							<dd id="modPacktypeDiv"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1386"]?></dt><!-- 팩용량 -->
							<dd id="modPackcapaDiv"></dd>
						</dl>
					</div>
				</div>
				<div class="fr">
					<div class="row">
						<dl>
							<dt id="dateDiv"><?=$txtdt["1112"]?></dt><!-- 배송희망일 -->
							<dd id="mreDelidateDiv"></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1335"]?></dt><!-- 첩수 -->
							<dd id="modChubcntDiv"><?=$txtdt["1330"]?><!-- 첩 --></dd>
						</dl>
					</div>
					<div class="row">
						<dl>
							<dt><?=$txtdt["1384"]?></dt><!-- 팩수 -->
							<dd id="modPackcntDiv"><?=$txtdt["1604"]?><!-- 팩 --></dd>
						</dl>
					</div>
				</div>
			</div>

			<div style="clear:both;padding-top:30px;">
				<h3 class="tit"><?=$txtdt["mrdesctxt"]?></h3>
				<div class="fl">
					<div class="txt" style="height:80px;" id="mrdescDiv"></div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1628"]?></dt><!-- 포장방법 -->
							<dd id="reBoxdeliDiv"><!-- <?=$json["reBoxdeli"]?> --></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1629"]?></dt><!-- 포장수량 -->
							<dd></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1630"]?></dt><!-- 배송박스 -->
							<dd id="reBoxmediDiv"><!-- <?=$json["reBoxmedi"]?> --></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1631"]?></dt><!-- 배송방법 -->
							<dd id="reDelitypeDiv"><!-- <?=$json["reDelitype"]?> --></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1632"]?></dt><!-- 배송회사 -->
							<dd id="reDelicompDiv"><!-- <?=$json["reDelicomp"]?> --></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1633"]?></dt><!-- 송장번호 -->
							<dd id="reDelinoDiv"><!-- <?=$json["reDelino"]?> --></dd>
						</dl>
					</div>
					<h3 class="tit"><?=$txtdt["1634"]?></h3><!-- 보내는사람 -->
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1244"]?></dt><!-- 이름 -->
							<dd id="meNameDiv"><!-- <?=$json["meName"]?> --></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1286"]?></dt><!-- 전화번호 -->
							<dd id="mePhoneDiv"><!-- <?=$json["mePhone"]?> --></dd>
						</dl>
					</div>
					<div class="row">
						<dl style="height:auto;">
							<dt><?=$txtdt["1307"]?></dt><!-- 주소 -->
							<dd><span id="meAddressDiv"><!-- [<?=$json["meZipcode"]?>]<?=str_replace("||","<br>",$json["meAddress"])?> --></span></dd>
						</dl>
					</div>
					<h3 class="tit"><?=$txtdt["1100"]?></h3><!-- 받는사람 -->
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1244"]?></dt><!-- 이름 -->
							<dd id="reNameDiv"><!-- <?=$json["reName"]?> --></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1112"]?></dt><!-- 배송희망일 -->
							<dd id="reDelidateDiv"><!-- <?=$json["reDelidate"]?> --></dd>
						</dl>
					</div>
					<div class="row2">
						<dl>
							<dt><?=$txtdt["1286"]?></dt><!-- 전화번호 -->
							<dd id="rePhoneDiv"><!-- <?=$json["rePhone"]?> --></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1422"]?></dt><!-- 휴대폰번호 -->
							<dd id="reMobileDiv"><!-- <?=$json["reMobile"]?> --></dd>
						</dl>
					</div>
					<div class="row">
						<dl style="height:auto;">
							<dt><?=$txtdt["1307"]?></dt><!-- 주소 -->
							<dd><span id="reAddressDiv"><!-- [<?=$json["reZipcode"]?>]<?=str_replace("||","<br>",$json["reAddress"])?> --></span></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["1635"]?></dt><!-- 배송요청사항 -->
							<dd id="reRequestDiv"><!-- <?=$json["reRequest"]?> --></dd>
						</dl>
					</div>
				</div>

				<div class="fr">
					<h3 class="tit"><?=$txtdt["1118"]?></h3><!-- 복약지도 -->
					<div class="txt" style="height:180px;">
						<p id="odAdviceDiv"><!-- <?=$json["odAdvice"]?> --></p>
					</div>
					<h3 class="tit"><?=$txtdt["1636"]?></h3><!-- 파우치이미지 -->
					<div class="img" style="height:90px;" id="modPackimgDiv">
					</div>
					<h3 class="tit"><?=$txtdt["1637"]?></h3><!-- 포장재이미지 -->
					<div class="img" style="height:90px;" id="mreBoxmediimgDiv">
					</div>

					<h3 class="tit"><?=$txtdt["1638"]?></h3><!-- 배송박스이미지 -->
					<div class="img" style="height:90px;" id="mreBoxdeliimgDiv">
					</div>
				</div>
			</div>
		</div>

    </div>
</div>

</body>
</html>

<script>
	function getDecoTypeName(list, data)
	{
		var str = "<?=$txtdt['1251']?>";//일반
		for(var key in list)
		{
			if(data == list[key]["cdCode"])
			{
				str = list[key]["cdName"];
				break;
			}
		}
		return str;
	}
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="orderprint")
		{
			var title=staff=img="";
			//*********************************************************************
			//making
			//*********************************************************************
			title = obj["miName"]+' - <?=$txtdt["1596"]?>';
			staff = (!isEmpty(obj["maStaff"])) ? obj["maStaff"] : '<?=$txtdt["1256"]?>';

			$("#titleDiv").text(title);
			if(!isEmpty(obj["maCode"]))
			{
				$("#barcodeDiv").barcode(obj["maCode"], "code128", {barWidth:2, barHeight: 50, fontSize:15});
				$("#barcodeDiv").css('width', 'auto');
				$("#barcodeDiv").css('height', '70px');
				$("#barcodeDiv").css('margin', '0 auto');
			}

			$("#maCodeDIV").text(obj["maCode"]);
			$("#staffDIV").text(staff);
			$("#odCodeDiv").text(obj["odCode"]);
			$("#odDateDiv").text(obj["odDate"]);

			//basic ---------------------------------------------------------
			$("#odTitleDiv").text(obj["odTitle"]);
			$("#meNameDiv").text(obj["miName"]);
			$("#odStaffDiv").text(obj["reName"]);

			$("#odPacktypeDiv").text(obj["odPacktype"]);
			$("#odPackcapaDiv").text(obj["odPackcapa"]+'ml');
			$("#reDelidateDiv").text(obj["reDelidate"]);
			$("#odChubcntDiv").text(obj["odChubcnt"]+'<?=$txtdt["1330"]?>');
			$("#odPackcntDiv").text(obj["odPackcnt"]+'<?=$txtdt["1604"]?>');
			//----------------------------------------------------------------
			$("#odChubcnt").val(obj["odChubcnt"]);
			//----------------------------------------------------------------

			//*********************************************************************

			//*********************************************************************
			//decoction
			//*********************************************************************
			title = obj["miName"]+' - <?=$txtdt["1615"]?>';
			staff = (!isEmpty(obj["dcStaff"])) ? obj["dcStaff"] : '<?=$txtdt["1256"]?>';

			var etc = "";
			if(obj["dcSterilized"]=='Y')
			{
				etc += '<?=$txtdt["1156"]?>';
			}
			if(obj["dcSterilized"]=='Y'&& obj["dcCooling"]=='Y')
			{
				etc += '/';
			}
			if(obj["dcCooling"]=='Y')
			{
				etc += '<?=$txtdt["1049"]?>';
			}


			$("#dtitleDiv").text(title);
			$("#dbarcodeDiv").barcode(obj["dcCode"], "code128", {barWidth:2, barHeight: 50, fontSize:15});
			$("#dbarcodeDiv").css('width', 'auto');
			$("#dbarcodeDiv").css('height', '70px');
			$("#dbarcodeDiv").css('margin', '0 auto');

			//basic ---------------------------------------------------------
			$("#dodTitleDiv").text(obj["odTitle"]);
			$("#dmeNameDiv").text(obj["miName"]);
			$("#dodStaffDiv").text(obj["reName"]);

			$("#dodPacktypeDiv").text(obj["odPacktype"]);
			$("#dodPackcapaDiv").text(obj["odPackcapa"]+'ml');
			$("#dreDelidateDiv").text(obj["reDelidate"]);
			$("#dodChubcntDiv").text(obj["odChubcnt"]+'<?=$txtdt["1330"]?>');
			$("#dodPackcntDiv").text(obj["odPackcnt"]+'<?=$txtdt["1604"]?>');
			//----------------------------------------------------------------


			$("#dcCodeDiv").text(obj["dcCode"]);
			$("#dstaffDiv").text(staff);
			$("#dodCodeDiv").text(obj["odCode"]);
			$("#dodDateDiv").text(obj["odDate"]);

			var dcTitle = (!isEmpty(obj["dcTitle"])) ? obj["dcTitle"] : "-";
			var dcSpecial = (!isEmpty(obj["dcSpecial"])) ? obj["dcSpecial"] : "-";
			$("#dcTitleDiv").text(dcTitle);
			$("#dcSpecialDiv").text(dcSpecial);

			$("#nodecocDiv").text();

			$("#dcTimeDiv").text(obj["dcTime"]+' <?=$txtdt["1437"]?>');
			$("#etcDiv").text(etc);
			$("#dcWaterDiv").text(comma(obj["dcWater"])+' ml');

			if(obj["odPackimg"] == "NoIMG")
			{
				img="";
			}
			else
			{
				img='<img src="'+getUrlData("FILE_DOMAIN")+obj["odPackimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';
			}
			$("#dodPackimgDiv").html(img);


			//*********************************************************************



			//*********************************************************************
			//marking
			staff = (!isEmpty(obj["dcStaff"])) ? obj["dcStaff"] : '<?=$txtdt["1256"]?>';
			title = obj["miName"]+' - <?=$txtdt["1624"]?>';

			$("#mtitleDiv").text(title);
			$("#mbarcodeDiv").barcode(obj["mrCode"], "code128", {barWidth:2, barHeight: 50, fontSize:15});
			$("#mbarcodeDiv").css('width', 'auto');
			$("#mbarcodeDiv").css('height', '70px');
			$("#mbarcodeDiv").css('margin', '0 auto');

			$("#mrCodeDiv").text(obj["mrCode"]);
			$("#mstaffDiv").text(staff);
			$("#modCodeDiv").text(obj["odCode"]);
			$("#modDateDiv").text(obj["odDate"]);

			//basic ---------------------------------------------------------
			$("#modTitleDiv").text(obj["odTitle"]);
			$("#mmeNameDiv").text(obj["miName"]);
			$("#modStaffDiv").text(obj["reName"]);

			$("#modPacktypeDiv").text(obj["odPacktype"]);
			$("#modPackcapaDiv").text(obj["odPackcapa"]+'ml');
			$("#mreDelidateDiv").text(obj["reDelidate"]);
			$("#modChubcntDiv").text(obj["odChubcnt"]+'<?=$txtdt["1330"]?>');
			$("#modPackcntDiv").text(obj["odPackcnt"]+'<?=$txtdt["1604"]?>');
			//----------------------------------------------------------------

			var reBoxdeli = !isEmpty(obj["reBoxdeli"]) ? obj["reBoxdeli"] : "";
			var reBoxmedi = !isEmpty(obj["reBoxmedi"]) ? obj["reBoxmedi"] : "";
			$("#reBoxdeliDiv").text(reBoxdeli);
			$("#reBoxmediDiv").text(reBoxmedi);
			$("#reDelitypeDiv").text(obj["reDelitype"]);

			$("#reDelicompDiv").text(obj["reDelicomp"]);
			$("#reDelinoDiv").text(obj["reDelino"]);

			$("#meNameDiv").text(obj["miName"]);
			$("#mePhoneDiv").text(obj["miPhone"]);

			var zip=(isEmpty(obj["miZipcode"])) ? "" : obj["miZipcode"];
			var add=(isEmpty(obj["miAddress"])) ? "" : obj["miAddress"].replace("||", " ");
			var addr = '['+zip+'] '+obj["miAddress"].replace("||", " ");
			$("#meAddressDiv").text(addr);

			$("#reNameDiv").text(obj["reName"]);
			$("#reDelidateDiv").text(obj["reDelidate"]);

			$("#rePhoneDiv").text(obj["rePhone"]);
			$("#reMobileDiv").text(obj["reMobile"]);

			addr = '['+obj["reZipcode"]+'] '+obj["reAddress"].replace("||", " ");
			$("#reAddressDiv").text(addr);

			$("#reRequestDiv").text(obj["reRequest"]);

			$("#odAdviceDiv").text(obj["odAdvice"]);



			if(obj["odPackimg"] == "NoIMG"){img="";}
			else{img='<img src="'+getUrlData("FILE_DOMAIN")+obj["odPackimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';}
			$("#modPackimgDiv").html(img);

			if(obj["reBoxmediimg"] == "NoIMG"){img="";}
			else{img='<img src="'+getUrlData("FILE_DOMAIN")+obj["reBoxmediimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';}
			$("#mreBoxmediimgDiv").html(img);

			if(obj["reBoxdeliimg"] == "NoIMG"){img="";}
			else{img='<img src="'+getUrlData("FILE_DOMAIN")+obj["reBoxdeliimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';}
			$("#mreBoxdeliimgDiv").html(img);
			//*********************************************************************



			//*********************************************************************
			//medicine api 호출
			var url = "medicine="+obj["rcMedicine"]+"&sweet="+obj["rcSweet"];
			callapi('GET','medicine','medicinetitle',url);
			//*********************************************************************
		}
		else if(obj["apiCode"]=="medicinetitle")
		{
			//*********************************************************************
			//making
			var dismatch = "_"+obj["dismatch"]; //여기에 _를 붙여야지.. 밑에 dismatch.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var poison = "_"+obj["poison"]; //여기에 _를 붙여야지.. 밑에 poison.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var data=clstitle=cls=rcmedicine=value="";
			var cnt=avg=maxLenlen=s=e=medicapa=totcapa=0;
			var ONE_TABLE_MAX = 20;

			//한용지안에 최대40개까지 보여짐. 40개이후로는 예외처리안함..어떻게 할지 정해서 작업할 예정
			cnt=obj["medicine"].length;
			if(cnt <= ONE_TABLE_MAX) //20개미만이면 한테이블로 보여주기
			{
				avg=cnt;
				maxLen=avg;
				len = 1;
			}
			else //20개이상이면 두테이블로 보여주자  최대 40개까지 보여짐
			{

				len=Math.ceil(cnt/ONE_TABLE_MAX);
				maxLen = ONE_TABLE_MAX;
			}

			for(var m=0;m<len;m++)
			{
				cls=(m==0) ? "" : "right";
				if(len == 1) cls="one";
				data+='<table id="pmakingtbl" class="'+cls+'" summary="<?=$txtdt["1203"]?>">';
				data+='		<caption class="hide"><?=$txtdt["1203"]?></caption>';
				data+='		<colgroup>';
				data+='				<col width="5%" />';
				data+='				<col width="12%" />';
				data+='				<col width="23%" />';
				data+='				<col width="15%" />';
				data+='				<col width="15%" />';
				data+='				<col width="" />';
				data+='		</colgroup>';
				data+='		<thead>';
				data+='			<tr>';
				data+='				<th scope="col">NO.</th>';
				data+='				<th scope="col"><?=$txtdt["1359"]?></th><!-- 타입 -->';
				data+='				<th scope="col"><?=$txtdt["1204"]?>(<?=$txtdt["1669"]?>)</th><!-- 약재명 -->';
				data+='				<th scope="col"><?=$txtdt["1064"]?>/<?=$txtdt["1158"]?></th><!-- 독성/상극 -->';
				data+='				<th scope="col"><?=$txtdt["1237"]?></th><!-- 원산지 -->';
				data+='				<th scope="col"><?=$txtdt["1612"]?>/<?=$txtdt["1613"]?></th><!-- 첩량 --><!-- 약재량 -->';
				data+='			</tr>';
				data+='		</thead>';
				data+='		<tbody>';
								if(len == 1)
								{
									s=0;
									e=cnt;
								}
								else
								{
									s=(m*ONE_TABLE_MAX);
									e=(s+1)*maxLen;
									e=(e>=cnt) ? cnt:e;
									console.log("s = " + s+", m = "+m+", e = " + e+", len = " + len+", maxLen = " + maxLen);
								}

								for(var i=s;i<e;i++)
								{
									value =obj["medicine"][i];
									rcmedicine = value["rcMedicode"];
									medicapa = parseInt(value["rcCapa"]) * parseInt($("#odChubcnt").val());
									totcapa+=parseInt(medicapa);
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
									if(dismatch.indexOf(rcmedicine) != -1) //
									{
										clstitle='<span style="color:red"><?=$txtdt["1158"]?></span>';//상극
									}
									else if(poison.indexOf(rcmedicine) != -1)
									{
										clstitle='<span style="color:#444"><?=$txtdt["1064"]?></span>';//독성
									}
									else
									{
										clstitle="-";
									}

									data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
									data+='	<td class="smallfont">'+(i+1)+'</td>';
									data+='	<td class="mediumfont">'+getDecoTypeName(obj["decoctypeList"], value["rcDecoctype"])+'</td>';
									data+='	<td>'+value["rcMedititle"]+' ('+medibox+')</td>';
									data+='	<td class="mediumfont">'+clstitle+'</td>';
									data+='	<td class="mediumfont">'+value["rcOrigin"]+'</td>';
									data+='	<td class="smallfont">'+(parseFloat(medicapa).toFixed(1))+' g / '+value["rcCapa"]+' g</td>';
									data+='</tr>';
								}
				data+='		</tbody>';
				data+='</table>';
			}

			$("#medilstDiv").html(data);


			//별전  내용
			if(!isEmpty(obj["rcSweet"]))
			{
				var sweet_list = obj["sweet"];
				var data="";
					data+='<h3 class="lst_tit"><?=$txtdt["1618"]?></h3>';
					data+='<table id="sweetlist">';
					data+='		<colgroup>';
					data+='			<col width="15%" />';
					data+='			<col width="5%" />';
					data+='			<col width="10%" />';
					data+='			<col width="5%" />';
					data+='			<col width="15%" />';
					data+='			<col width="5%" />';
					data+='			<col width="10%" />';
					data+='			<col width="5%" />';
					data+='			<col width="10%" />';
					data+='			<col width="5%" />';
					data+='			<col width="10%" />';
					data+='			<col width="*%" />';
					data+='		</colgroup>';
					data+='		<thead>';
					data+='		</thead>';
					data+='		<tbody>';
					data+='		 <tr>';

				for(var key in sweet_list)
				{
					data+='        <td>'+sweet_list[key]["rcMedititle"]+'</td>';
					data+='        <td>'+sweet_list[key]["rcCapa"]+' <?=$txtdt["1018"]?> </td>';
				}

					data+='      </tr>';
					data+='		</tbody>';
					data+='</table>';
					$("#sweetDiv").html(data);
			}

//			data='<?=$txtdt["1664"]?> : '+comma(totcapa)+' g';
//			$("#totalcapaDiv").html(data);
			//*********************************************************************


			//*********************************************************************
			//decoction
			var medicapa = parseInt(obj["totMedicapa"]) * parseInt($("#odChubcnt").val());

			if(isEmpty(obj["rcSweet"]))
			{
				data = '<tr><td colspan="3" style="padding:20px;">-</td></tr>';
			}
			else
			{
				data = '<tr></tr>';
			}


			$("#totMedicapaDiv").text(medicapa+' g');
			$("#cntMedicineDiv").text(obj["totMedicine"]+' ea');

			$(obj["sweet"]).each(function( index, value )
			{
				if(parseInt(value["rcCapa"]) > 0)
				{
					data+='<tr>';
					data+='	<td>'+getDecoTypeName(obj["decoctypeList"], value["rcDecoctype"])+'</td>';
					data+='	<td>'+value["rcMedititle"]+'</td>';
					data+='	<td>'+value["rcCapa"]+'g</td>';
					data+='</tr>';
				}
			});
			$("#pdecoctiontbl tbody").html(data);


			data = "";
			$(obj["decoctypeList"]).each(function( index, value )
			{
				if(obj["deCoction"][value["cdCode"]]=='Y')
				{
					data+='<span class="chk_area">';
					data+='<input type="checkbox" id="decoction_order1" checked disabled/><label for="decoction_order1">'+value["cdName"]+'</label>';
					data+='</span>';
				}

			});
			$("#decocorderDiv").html(data);
			//*********************************************************************




			setTimeout('print();', 500);

		}
	}

	//한의원 상세 정보
	callapi('GET','order','orderprint','<?=$apiprinterData?>');

</script>
