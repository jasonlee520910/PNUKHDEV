<?php 
	$root = "..";
	$odCode=$_GET["odCode"];
	$apiprinterData = "odCode=".$odCode;
	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
	/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/	
	html{background:none; min-width:0; min-height:0;}
	.section_print{width: 21cm;min-height: 29.7cm;}
	.barcode img{width:300px;height:54px;}
	.lst_tb{overflow:hidden;}
	.lst_tb table{width:49%;float:left;margin-right:1%;}
	.lst_tb table.one{width:100%;float:left;margin-right:1%;}
	.form_dtl .lst_tb table tbody tr.meditr td{padding:5px;}
	.form_dtl .lst_tb table tbody tr.meditr td.mediumfont{padding:5px;font-size: 13px;}
	.form_dtl .lst_tb table tbody tr.meditr td.smallfont{padding:5px;font-size: 12px;}
	.totalcapa {float:right;}
</style>

<div class="section_print">
    <div class="form_cont">
        <!-- view_lst안에 들어가는 부분 -->
        <h3 class="dtl_tit" id="titleDiv"><!-- <?=$json["meName"]?> - <?=$txtdt["1624"]?> --></h3><!-- 마킹/배송일지 -->
        <div class="form_dtl">
            <div class="barcode" id="barcodeDiv">
            </div>
						 <div class="form_info">
								<dl>
										<dt><?=$txtdt["1597"]?></dt><!-- 문서번호 -->
										<dd><em id="mrCodeDiv"><!-- <?=$json["mrCode"]?> --></em></dd>
								</dl>
								<dl>
										<dt><?=$txtdt["1625"]?> :</dt><!-- 마킹사 -->
										<dd><em id="staffDiv"><!-- <?=$staff?> --></em></dd>
								</dl>
								<dl>
										<dt><?=$txtdt["1609"]?></dt><!-- 주문번호 -->
										<dd id="odCodeDiv"><!-- <?=$json["odCode"]?> --></dd>
								</dl>
								<dl>
										<dt><?=$txtdt["1304"]?></dt><!-- 주문일 -->
										<dd id="odDateDiv"><!-- <?=$json["odDate"]?> --></dd>
								</dl>
						</div>

        </div>
        <!-- //view_lst안에 들어가는 부분 -->

        <div class="form_dtl">
					<?php include_once $root."/99_LayerPop/document.basic.php";?>
					<div style="clear:both;padding-top:30px;">
						<h3 class="tit"><?=$txtdt["mrdesctxt"]?></h3>
            <div class="fl">
                <div class="txt" style="height:80px;" id="mrdescDiv">
										<!-- <?php echo $json["me_company"];
												$mrdesctxt=str_replace("[mename]",$json["meName"],$json["mrDesc"]);
												$mrdesctxt=str_replace("[mephone]",$json["mePhone"],$mrdesctxt);
												$mrdesctxt=str_replace("[receiver]",$json["reName"],$mrdesctxt);
												$mrdesctxt=str_replace("[dear]",$txtdt["dear"],$mrdesctxt);
												$mrdesctxt=str_replace("[makingdate]",$txtdt["makingdate"],$mrdesctxt);
												echo str_replace("[oddate]",$json["odDate"],$mrdesctxt);
										?> -->
                </div>
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
                <div class="img" style="height:90px;" id="odPackimgDiv">
                </div>
                <h3 class="tit"><?=$txtdt["1637"]?></h3><!-- 포장재이미지 -->
                <div class="img" style="height:90px;" id="reBoxmediimgDiv">
                </div>

                <h3 class="tit"><?=$txtdt["1638"]?></h3><!-- 배송박스이미지 -->
                <div class="img" style="height:90px;" id="reBoxdeliimgDiv">
                </div>
            </div>
					</div>
				</div>
    </div>
</div>
</body>
</html>
<script>
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="orderprint")
		{
			var staff = (!isEmpty(obj["dcStaff"])) ? obj["dcStaff"] : '<?=$txtdt["1256"]?>';

			var title = obj["miName"]+' - <?=$txtdt["1624"]?>';

			$("#titleDiv").text(title);
			$("#barcodeDiv").barcode(obj["mrCode"], "code128", {barWidth:2, barHeight: 50, fontSize:15});
			$("#barcodeDiv").css('width', 'auto');
			$("#barcodeDiv").css('height', '70px');
			$("#barcodeDiv").css('margin', '0 auto');

			$("#mrCodeDiv").text(obj["mrCode"]);
			$("#staffDiv").text(staff);
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

			$("#odChubcnt").val(obj["odChubcnt"]);
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

			var img="";
			if(obj["odPackimg"]=="NoIMG"){img="";}
			else {img = '<img src="'+getUrlData("FILE_DOMAIN")+obj["odPackimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';}
			$("#odPackimgDiv").html(img);

			if(obj["reBoxmediimg"]=="NoIMG"){img="";}
			else {img = '<img src="'+getUrlData("FILE_DOMAIN")+obj["reBoxmediimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';}
			$("#reBoxmediimgDiv").html(img);

			if(obj["reBoxdeliimg"]=="NoIMG"){img="";}
			else {img = '<img src="'+getUrlData("FILE_DOMAIN")+obj["reBoxdeliimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';}
			$("#reBoxdeliimgDiv").html(img);	
			
			setTimeout('print();', 500);
		}
	}

	//한의원 상세 정보 
	callapi('GET','order','orderprint','<?=$apiprinterData?>');

</script>