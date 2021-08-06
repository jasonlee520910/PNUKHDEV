<?php 
	$root = "..";
	$odCode=$_GET["odCode"];
	$apiprinterData = "odCode=".$odCode;
	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
	/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
	html{background:none; min-width:0; min-height:0;}
	..section_print{width: 21cm;min-height: 29.7cm;}
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
	#sweetlist td{border:1;border-left:1px solid black;border-right:1px solid black;text-align: center;}
</style>

<input type="hidden" name="odChubcnt" id="odChubcnt" value="">
<div class="section_print">
    <div class="form_cont">
        <!-- view_lst안에 들어가는 부분 -->
        <h3 class="dtl_tit" id="titleDiv"></h3><!--  - <?=$txtdt["1615"]?>탕전일지 -->
        <div class="form_dtl">
            <div class="barcode" id="barcodeDiv">
            </div>
            <div class="form_info">
                <dl>
                    <dt><?=$txtdt["1597"]?></dt><!-- 문서번호 -->
                    <dd><em id="dcCodeDiv"></em></dd>
                </dl>
                <dl>
                    <dt><?=$txtdt["1368"]?> :</dt><!-- 탕전사 -->
                    <dd><em id="staffDiv"></em></dd>
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
					<?php include_once $root."/99_LayerPop/document.basic.php";?>
					<div style="clear:both;padding-top:30px;">
						<h3 class="tit"><?=$txtdt["1616"]?></h3><!-- 탕전지시사항 -->
						<div class="order_chk" id="decocorderDiv">
								<!-- <?php 
									$carr=array("infirst","inmain","inafter","inlast");
									//$tarr=array("선전","일반","후하","별전");
									$tarr=array($txtdt["1171"],$txtdt["1251"],$txtdt["1420"],$txtdt["1115"]);
								?>
								<?php foreach($carr as $val){?>
									<?php if($jsonmedi["deCoction"][$val]=="Y"){?>
										<span class="chk_area">
												<input type="checkbox" id="decoction_order1" checked disabled/><label for="decoction_order1"><?=$txtdt[$val]?></label>
										</span>
									<?php }?>
								<?php }?> -->
						</div>
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
									<div id="sweetDiv"></div> <!-- 앰플/기타약재  내용  -->
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
									<div class="img" style="height:90px;" id="odPackimgDiv">
									</div>
							</div>
						</div>
					</div>
				</div>
    </div>
</div>
</body>
</html>
<!-- <script  type="text/javascript" src="<?=$adm?>/cmmJs/jquery/jquery-2.2.4.js"></script>
<script>
	$(document).ready(function() {
		print();
	});
</script> -->
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
			var title = obj["miName"]+' - <?=$txtdt["1615"]?>';
			var staff = (!isEmpty(obj["dcStaff"])) ? obj["dcStaff"] : '<?=$txtdt["1256"]?>';

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


			$("#titleDiv").text(title);
			$("#barcodeDiv").barcode(obj["dcCode"], "code128", {barWidth:2, barHeight: 50, fontSize:15});
			$("#barcodeDiv").css('width', 'auto');
			$("#barcodeDiv").css('height', '70px');
			$("#barcodeDiv").css('margin', '0 auto');

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


			$("#dcCodeDiv").text(obj["dcCode"]);
			$("#staffDiv").text(staff);
			$("#odCodeDiv").text(obj["odCode"]);
			$("#odDateDiv").text(obj["odDate"]);

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
				$("#odPackimgDiv").html("");
			}
			else
			{
				var img='<img src="'+getUrlData("FILE_DOMAIN")+obj["odPackimg"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'">';
				$("#odPackimgDiv").html(img);
			}



			var url = "medicine="+obj["rcMedicine"]+"&sweet="+obj["rcSweet"];

			callapi('GET','medicine','medicinetitle',url);
		}
		else if(obj["apiCode"]=="medicinetitle")
		{
			var medicapa = parseInt(obj["totMedicapa"]) * parseInt($("#odChubcnt").val());
			var data = '<tr><td colspan="3" style="padding:20px;">-</td></tr>';

			$("#totMedicapaDiv").text(medicapa+' g');
			$("#cntMedicineDiv").text(obj["totMedicine"]+' ea');

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
			setTimeout('print();', 500);

			//별전  내용
			if(!isEmpty(obj["rcSweet"]))
			{
				var sweet_list = obj["sweet"];
				var data=cnt="";
				var sweet_max = 3;
				cnt=sweet_list.length;

				data+='<h3 class="lst_tit"><?=$txtdt["1618"]?></h3>';
				data+='<table id="sweetlist">';
				data+='		<colgroup>';
				data+='			<col width="20%" />';
				data+='			<col width="13%" />';
				data+='			<col width="20%" />';
				data+='			<col width="13%" />';
				data+='			<col width="20%" />';
				data+='			<col width="14%" />';
				data+='		</colgroup>';
				data+='		<thead>';
				data+='		</thead>';
				data+='		<tbody>';
				data+='		 <tr>';

				if(cnt>sweet_max)  //별전이 4이상일때
				{
					for(var key in sweet_list)
					{
						if(key<3) //첫번째 줄
						{
							data+='        <td>'+sweet_list[key]["rcMedititle"]+'</td>';
							data+='        <td>'+sweet_list[key]["rcCapa"]+' <?=$txtdt["1018"]?> </td>';
						}
					}

					data+='      </tr>';

					for(var key in sweet_list)
					{
						if(key>2)  //두번째 줄
						{
							data+='        <td>'+sweet_list[key]["rcMedititle"]+'</td>';
							data+='        <td>'+sweet_list[key]["rcCapa"]+' <?=$txtdt["1018"]?> </td>';
						}
					}
					data+='      </tr>';
					data+='		</tbody>';
					data+='</table>';
				}
				else  //별전이 3이하일때
				{

					for(var key in sweet_list)
					{
						data+='        <td>'+sweet_list[key]["rcMedititle"]+'</td>';
						data+='        <td>'+sweet_list[key]["rcCapa"]+' <?=$txtdt["1018"]?> </td>';
					}
				}
						data+='      </tr>';
						data+='		</tbody>';
						data+='</table>';

						$("#sweetDiv").html(data);
			}
		}
	}

	//한의원 상세 정보
	callapi('GET','order','orderprint','<?=$apiprinterData?>');

</script>
