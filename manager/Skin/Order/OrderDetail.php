<?php
	$root = "../..";
	include_once $root."/_common.php";

if($_GET["seq"]=="add"){
	$apiOrderData="seq=write";
}else{
	$apiOrderData="seq=".$_GET["seq"];
}
//echo "확인중 :".$apiOrderData;
?>

<style>
    #odMrdescDiv{height:70px;overflow:auto;}
	#odRequestDiv{border:1px solid #e3e3e4;height:70px;overflow:auto;}
	#odAdviceDiv{border:1px solid #e3e3e4;height:80px;overflow:auto;padding:30px 0;}
	#lefttext{float:left;width:49%;}
	#righttext{float:right;width:49%;}
	#leftinfo{float:left;width:49%;}
	#rightinfo{float:right;width:49%;}
	#maininfo {width:100%;}  
	#markinbox{height:25px;width:700px;position:absolute; margin-left:-90px}
	.pack-list02 li .check-box img{height:100px;border:1px solid #d7d7d7;box-sizing:border-box;}
	.table_style { width: 100%; /* 전체 테이블 폭 지정 */}
	.table_style ul { clear: left; margin: 0;  padding: 0; list-style-type: none; }
	.table_style ul li { float: left; margin: 0; padding: 2px 1px;}
	.table_style ul .left { width: 130px; }
	.td_text_overflow {overflow:hidden;white-space :2019-09-09 nowrap;text-overflow: ellipsis;}

	span.mdtype{display:inline-block;width:15px;height:15px;border-radius:50%;margin-right:5px;line-height:100%;vertical-align:middle;}
	.mdsweet{background-color:#f2C2D6;}
	.mdmedi{background-color:#8BE0ED;}
	.sugar{background-color:#01DF74;}

	#odGoodsMDiv {background:yellow;}
</style>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="orderupdate">
<input type="hidden" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="rcSeq" class="reqdata" value="<?=$_GET["rcSeq"];?>">
<input type="hidden" name="odCode" class="reqdata" value="<?=$_GET["odCode"];?>">
<input type="hidden" name="odKeycode" class="reqdata" value="<?=$_GET["odKeycode"];?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Order/OrderList.php">
<input type="hidden" name="odStatus" class="reqdata" value="">
<input type="hidden" name="od_canceltype" class="reqdata" value="">
<input type="hidden" name="restarttxt" class="reqdata" value="">
<input type="hidden" name="maPrice" class="reqdata" value="">
<input type="hidden" name="dcPrice" class="reqdata" value="">
<input type="hidden" name="rePrice" class="reqdata" value="">
<input type="hidden" name="reBox" class="reqdata" value="">
<input type="hidden" name="reBoxmedibox" class="reqdata" value="">
<input type="hidden"  name="reDelidate"  class="reqdata">
<input type="hidden"  name="odSitecategory"  class="reqdata">
<!-- djmedi 주문금액 json data -->
<textarea name="odAmountdjmedi" class="reqdata"  style="display:none;"></textarea> 
<!-- okchart 주문금액 json data -->
<textarea name="odAmountokchart" class="reqdata" style="display:none;"></textarea>

<input type="hidden"  name="odMatype"  class="reqdata">

<!-- =================================================================================== -->
<!-- 주문내역 -->
<h3 class="u-tit02"><?=$txtdt["1300"]?><!-- 주문내역 --></h3>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="15%">
			<col width="18%">
			<col width="15%">
			<col width="19%">
			<col width="15%">
			<col width="18%">
		</colgroup>
		<tbody>
			<tr>
				<th>
					<span><?=$txtdt["1305"]?><!-- 주문코드 --></span>
				</th>
				<td><span id="odChartPK"></span> <span  id="td_odCode"></span></td>
				<th>
					<span class="nec"><?=$txtdt["1112"]?><!-- 배송희망일 --></span>
				</th>
				<td id="reDelidateDiv">
					
				</td>
				<th>
					<span><?=$txtdt["1328"]?><!-- 처방자 --></span>
				</th>
				<td  id="odStaffDiv"></td> 
			</tr>
			<tr>
				<th><span><?=$txtdt["1614"]?><!-- 조제타입 --></span></th>
				<td  id="maTypeDiv"></td>
				
				<th><span class="nec"><?=$txtdt["1323"]?><!-- 처방명 --></span></th>
				<td id="odScriptionDiv"></td>

				<th><span><?=$txtdt["1403"]?><!-- 한의원 --></span></th>
				<td  id="reNameDiv"></td>
			</tr>
			<tr>
				<th>
					<span class="nec"><?=$txtdt["1335"]?><!-- 첩수 --></span>
				</th>
				<input type="hidden" class="w20p tc" title="<?=$txtdt["1335"]?>" id="odChubcnt" name="odChubcnt" value="" maxlength="4" onfocus="this.select();" />
				<td id="odChubcntDiv"></td>
				<th>
					<span class="nec"><?=$txtdt["1384"]?><!-- 팩수 --></span>
				</th>
				<input type="hidden" class="w20p tc title="<?=$txtdt["1384"]?>" id="odPackcnt" name="odPackcnt" value=""  maxlength="3" onfocus="this.select();" />
				<td id="odPackcntDiv"></td>
				<th>
					<span class="nec"><?=$txtdt["1386"]?><!-- 팩용량 --></span>
				</th>
				<input type="hidden" class="w20p tc title="<?=$txtdt["1386"]?>" id="odPackcapa"name="odPackcapa" value=""  maxlength="3" onfocus="this.select();" />
				<td id="odPackcapaDiv"></td>
			</tr>
	 </tbody>
	</table>
</div>
<div class="sgap"></div>
<h3 class="u-tit02"><?=$txtdt["1886"]?><!-- 환자정보 --></h3>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="12%">
			<col width="13%">
			<col width="12%">
			<col width="13%">
			<col width="12%">
			<col width="13%">
			<col width="12%">
			<col width="13%">
		</colgroup>
		<tbody>
			<tr>
				<th><span class="nec">환자구분</span></th>
				<td id="odRecipe"></td>
				<th><span class="nec"><?=$txtdt["1887"]?><!-- 환자명 --></span></th>
				<td id="odName"></td>

				<th><span class="nec"><?=$txtdt["1888"]?><!-- 성별 --></span></th>
				<td id="meGenderDiv"></td>

				<th><span><?=$txtdt["1889"]?><!-- 생년월일 --></span></th>
				<td id="odBirth">
				</td>

				<!-- <th><span class="nec"><?=$txtdt["1142"]?>사상</span></th>
				<td id="mhFeatureDiv"></td> -->
			</tr>
	 </tbody>
	</table>
</div>
<!-- =================================================================================== -->
<div class="sgap"></div>
<!-- 주문자요청사항 -->
<h3 class="u-tit02" ><?=$txtdt["1292"]?><!-- 주문자 요청사항 --></h3>
<div class="order-txt" id="odRequestDiv"></div>
<div class="sgap"></div>
<!-- =================================================================================== -->
<!-- 약재리스트 -->
<h3 class="u-tit02"><?=$txtdt["1203"]?><!-- 약재리스트 --><div id="odGoodsMDiv"></div></h3> </h3>
<div class="board-list-wrap" id="ordermedicine"></div>
<!-- =================================================================================== -->
<div id="dooChange"></div>
<div class="sgap"></div>
<!-- =================================================================================== -->
<!-- 탕전정보입력, 조제/탕전 요청사항, 마킹/출력정보입력, 배송정보, 복약지도, 포장재종류,  -->
<div class="order-box">
	<div class="fl">
		<!-- 감미제 -->
		<h3 class="u-tit02"><?=$txtdt["1703"]?><!-- 감미제 --></h3>
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="15%">
					<col width="*">
				</colgroup>
				<tbody>
					<tr>
						<th><span class="nec"><?=$txtdt["1703"]?><!-- 감미제 --></span></th>
						<td id="dcSugarDiv"></td>
					</tr>
				</tbody>
			</table>
			<div class="gap"></div>
		</div>
		<!-- ******************************************************************* -->
		<!-- 탕전정보 입력 -->
		<h3 class="u-tit02" id="decocTitleDiv"><?=$txtdt["1370"]?><!-- 탕전정보 입력 --></h3>
		<div class="board-view-wrap" id="decocDiv">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="30%">
				</colgroup>
				<tbody>
					<tr>
						<th><span class="nec"><?=$txtdt["1367"]?><!-- 탕전법 --></span></th>
						<td id="odDctitleDiv"></td>
						<th><span class="nec"><?=$txtdt["1369"]?><!-- 탕전시간(분) --></span></th>
						<td id="dcTimeDiv"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1381"]?><!-- 특수탕전 --></span></th>
						<td id="odDcspecialDiv"></td>
						<th><span class="nec"><?=$txtdt["1366"]?><!-- 탕전물량 -->ml</span></th>
						<td id="dcWaterDiv"></td>
					</tr>
				</tbody>
			</table>
			<div class="sgap"></div>
		</div>

		<h3 class="u-tit02" id="sfextTitleDiv"><?=$txtdt["1800"]?><!-- 제환 --></h3>
		<div class="board-view-wrap" id="sfextDiv">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="30%">
				</colgroup>
				<tbody>
					<tr>
						<th><span class="nec"><?=$txtdt["1664"]?><!-- 제형 --></span></th>
						<td id="dcShapeDiv"></td>
						<th><span class="nec"><?=$txtdt["1770"]?><!-- 결합제 --></span></th>
						<td id="dcBindersDiv"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1796"]?><!-- 분말도 --></span></th>
						<td id="dcFinenessDiv"></td>
						<th><span class="nec"><?=$txtdt["1841"]?><!-- 건조시간 --></span></th>
						<td id="dcDry"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1797"]?><!-- 제분손실 --></span></th>
						<td id="dcMillingloss"></td>
						<th><span class="nec"><?=$txtdt["1798"]?><!-- 제환손실 --></span></th>
						<td id="dcLossjewan"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1770"]?><!-- 결합제 --></span></th>
						<td id="dcBindersliang"></td>
						<th><span class="nec"><?=$txtdt["1799"]?><!-- 완성량 --></span></th>
						<td id="dcCompleteliang"></td>
					</tr>
				</tbody>
			</table>
			<div class="sgap"></div>
		</div>

		<h3 class="u-tit02" id="edextractTitleDiv"><?=$txtdt["1843"]?><!-- 농축엑기스 --></h3>
		<div class="board-view-wrap" id="edextractDiv">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="20%">
					<col width="30%">
					<col width="20%">
					<col width="30%">
				</colgroup>
				<tbody>
					<tr>
						<th><span class="nec"><?=$txtdt["1796"]?><!-- 분말도 --></span></th>
						<td id="edcFinenessDiv" colspan="3"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1844"]?><!-- 숙성 --></span></th>
						<td id="dcRipenDiv" colspan="3"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1845"]?><!-- 중탕 --></span></th>
						<td id="dcJungtangDiv"></td>
						<th></th>
						<td></td>
					</tr>

				</tbody>
			</table>
			<div class="gap"></div>
		</div>

		<!-- ******************************************************************* -->
		<!-- 마킹/출력 정보 입력 -->
		<h3 class="u-tit02"><?=$txtdt["1077"]?><!-- 마킹/출력 정보 입력 --></h3>
		<div class="board-view-wrap">
			<ul class="marking-list" id="odMrdescDiv"></ul>
		</div>
		
		<div class="sgap"></div>
		<!-- 복약지도 -->
		<h3 class="u-tit02"><?=$txtdt["1118"]?><!-- 복약지도 --><span class="nec"></span></h3>
		<div class="board-view-wrap" id="odAdviceDiv"></div>
		<!-- ******************************************************************* -->
	</div>
	<div class="fr">
		<!-- 포장 및 박스 -->
		<h3 class="u-tit02"><?=$txtdt["1394"]?><!-- 포장 및 박스 --></h3>
		<ul>
			<li class="liBoxSize">
				<div class="board-view-wrap">
					<span class="bd-line"></span>
					<table>
						<caption><span class="blind"></span></caption>
						<colgroup>
							<col width="30%">
							<col width="70%">
						</colgroup>
						<tbody>
							<tr>
								<th><span class="nec"><?=$txtdt["1470"]?><!-- 파우치 --></span></th>
								<td id="odPacktypeDiv"></td>
							</tr>
							<tr>
								<th><span class="nec"><?=$txtdt["1468"]?><!-- 한약박스 --></span></th>
								<td id="reBoxmediDiv"></td>
							</tr>
							<tr>
								<th><span class="nec"><?=$txtdt["1469"]?><!-- 포장박스 --></span></th>
								<td id="reBoxdeliDiv"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</li>
		</ul>
	</div>
</div>
<div class="sgap"></div>
<!-- 배송정보 -->
<div id="maininfo">		
	<div id="leftinfo">
	<h3 class="u-tit02"><?=$txtdt["1110"]?><!-- 배송정보 --></h3>
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
				<caption><span class="blind"></span></caption>
				<colgroup>
					<col width="13%">
					<col width="15%">
					<col width="*">
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="4"><?=$txtdt["1851"]?><!-- 보내는사람 --></th>
						<th><span class="nec"><?=$txtdt["1851"]?><!-- 보내는사람 --></span></th>
						<td colspan="3" id="reSendNameDiv"></td>
					</tr>
					<tr>
						<th><span><?=$txtdt["1286"]?><!-- 전화번호 --></span></th>
						<td colspan="3" id="reSendPhoneDiv"></td>
					</tr>
					<tr>
						<th><span><?=$txtdt["1422"]?><!-- 휴대폰번호 --></span></th>
						<td colspan="3" id="reSendMobileDiv"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1307"]?><!-- 주소 --></span></th>
						<td colspan="3" id="reSendZipcodeDiv"></td>
					</tr>



					<tr>
						<th rowspan="6"><?=$txtdt["1100"]?><!-- 받는사람 --></th>
						<th><span class="nec"><?=$txtdt["1100"]?><!-- 받는사람 --></span></th>
						<td colspan="3" id="reNametext"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1111"]?><!-- 배송종류 --></span></th>
						<td colspan="3" id="reDelitypeDiv"></td>
					</tr>
					<tr>
						<th><span><?=$txtdt["1286"]?><!-- 전화번호 --></span></th>
						<td colspan="3" id="rePhoneDiv"></td>
					</tr>
					<tr>
						<th><span><?=$txtdt["1422"]?><!-- 휴대폰번호 --></span></th>
						<td colspan="3" id="reMobileDiv"></td>
					</tr>
					<tr>
						<th><span class="nec"><?=$txtdt["1307"]?><!-- 주소 --></span></th>
						<td colspan="3" id="reZipcodeDiv"></td>
					</tr>
					<tr>
						<th><span><?=$txtdt["1106"]?><!-- 배송요구사항 --></span></th>
						<td colspan="3" id="reRequestDiv"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- 주문내역 -->
	<div id="rightinfo">
		<h3 class="u-tit02"><?=$txtdt["1516"]?><!-- 주문금액 --></h3>
		<div class="board-view-wrap">
			<table>
				<colgroup>
					<col width="17%">
					<col width="*">									
					<col width="25%">
				</colgroup>
				<tbody>
					<tr style="border-top: 1px solid #e3e3e4;">
						<th><span><?=$txtdt["1606"]?><!-- 약재비 --></span></th>
						<td id="tot_mediprice"></td>
						<td id="tot_meditotalprice" class="tr"></td>
					</tr>
					<tr style="border-top: 1px solid #e3e3e4;" id="trsugar">
						<th><span>감미제</span></th>
						<td id="tot_sugarprice"></td>
						<td id="tot_sugartotalprice" class="tr"></td>
					</tr>
					<tr style="border-top: 1px solid #e3e3e4;">
						<th><span><?=$txtdt["1698"]?><!-- 조제비 --></span></th>
						<td id="tot_makingprice"></td>
						<td id="tot_makingtotalprice" class="tr"></td>
					</tr>

					<tr style="border-top: 1px solid #e3e3e4;">
						<th><span><?=$txtdt["1697"]?><!-- 탕전비 --></span></th>
						<td id="tot_decoctionprice"></td>
						<td id="tot_decoctiontotalprice" class="tr"></td>
					</tr>

					<tr style="border-top: 1px solid #e3e3e4;" id="trspecial">
						<th><span>특수탕전비</span></th>
						<td id="tot_specialprice"></td>
						<td id="tot_specialtotalprice" class="tr"></td>
					</tr>

					<tr style="border-top: 1px solid #e3e3e4;">
						<th><span><?=$txtdt["1700"]?><!-- 포장비 --></span></th>
						<td id="tot_packingprice"></td>
						<td id="tot_packingtotalprice" class="tr"></td>
					</tr>

					<tr style="border-top: 1px solid #e3e3e4;">
						<th><span><?=$txtdt["1701"]?><!-- 배송비 --></span></th>
						<td id="tot_releaseprice"></td>
						<td id="tot_releasetotalprice" class="tr"></td>
					</tr>
					<tr style="border-top: 1px solid #e3e3e4;">
						<th><span><?=$txtdt["1516"]?><!-- 주문금액 --></span></th>
						<td colspan="2" class="tr">
							<input type="hidden" id="odAmount" name="odAmount" value="" title="<?=$txtdt["1516"]?>" class="reqdata">
							<span><i class="b f18 cred" id="td_total_price"></i> <?=$txtdt["1235"]?></span>
						</td>
					</tr>
			 </tbody>
			</table>
		</div>
	</div>
</div>
<!-- =================================================================================== -->
<div class="sgap"></div>
<!-- =================================================================================== -->
<div id="addDiv"></div>
<!-- =================================================================================== -->
<div class="btn-box c" id="btnDiv"></div>
<!-- =================================================================================== -->

<script>
	function getCodeName(list, data)
	{
		var reData = "";
		for(var key in list)
		{
			if(data == list[key]["cdCode"])
			{
				reData = list[key]["cdName"];
				break;
			}
		}
		return reData;
	}
	function viewmarking(pgid, data)
	{
		var radiostr = "";

		radiostr = '<li id="markinbox">';
		//radiostr += '	<div id="markinbox">';
		radiostr += data;
		//radiostr += '	</div>';
		radiostr += '</li>';

		$("#"+pgid).html(radiostr);
	}


	function viewpack(pgid, list, title, name, data, price, text, readonly)
	{
		var allstr = opstr = pricestr=imgstr = checked = disable = path = "";
		var i=selprice=selcapa=0;
		disable = (readonly == 'readonly') ? "disabled='disabled'" : "";
		opstr = "";
		price=isEmpty(price) ? 0 : price;

		for(var key in list)
		{
			checked = "";
			if(!isEmpty(data))
			{
				if(data == list[key]["pbCode"])
				{
					checked = "checked";
					selprice=list[key]["pbPriceE"];
					selcapa=list[key]["pbCapa"];

					opstr += '<li>';
					opstr += '<p class="check-box">';
					if(!isEmpty(list[key]["afFilel"]) && list[key]["afFilel"]=="NoIMG")
						opstr += '<img src="<?=$root?>/_Img/Content/noimg.png" alt=""/>';
					else
					{
						if(list[key]["afFilel"].substring(0,4)=="http")
						{
							opstr += '<img src="'+list[key]["afFilel"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" />';
						}
						else
						{
							opstr += '<img src="'+getUrlData("FILE_DOMAIN")+list[key]["afFilel"]+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" />';
						}
					}
					opstr += '<span class="btxt" style="margin-left:10px;">'+list[key]["pbTitle"]+'</span>';
					opstr += '</p>';
					opstr += '</li>';
				}
			}
		}

		selprice=(parseInt(price)<=0) ? selprice : price;
		console.log("name = " + name+", price = " + price+", selprice = " + selprice);
		
		pricestr='';
		if(name=='odPacktype')
		{
			pricestr = '<input type="hidden" name="odPackprice" class="reqdata" value="'+selprice+'">';
		}
		else if(name=='reBoxmedi')
		{
			pricestr = '<input type="hidden" name="reBoxmediprice" class="reqdata" value="'+selprice+'">';
			pricestr += '<input type="hidden" name="reBoxmedibox" class="reqdata" value="'+selcapa+'">';
			
		}
		else if(name=='reBoxdeli')
		{
			pricestr = '<input type="hidden" name="reBoxdeliprice" class="reqdata" value="'+selprice+'">';
		}
		
		allstr = '<ul class="pack-list02">';
		allstr += pricestr;
		allstr += opstr;
		allstr += '</ul>';
		$("#"+pgid).html(allstr);
	}
	function viewcypack(pgid, title, img)
	{
		var allstr = opstr = pricestr="";
		opstr = "";

		opstr += '<li>';
		opstr += '<p class="check-box">';

		if(!isEmpty(img) && img=="NoIMG")
		{
			opstr += '<img src="<?=$root?>/_Img/Content/noimg.png" alt=""/>';
		}
		else
		{
			if(img.substring(0,4)=="http")
			{
				opstr += '<img src="'+img+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" />';
			}
			else
			{
				opstr += '<img src="'+getUrlData("FILE_DOMAIN")+img+'" onerror="this.src=\'<?=$root?>/_Img/Content/noimg.png\'" />';
			}
		}

		opstr += '<span class="btxt" style="margin-left:10px;">'+title+'</span>';
		opstr += '</p>';
		opstr += '</li>';
		
		pricestr = '<input type="hidden" name="odPackprice" class="reqdata" value="0">';
		
		allstr = '<ul class="pack-list02">';
		allstr += pricestr;
		allstr += opstr;
		allstr += '</ul>';
		$("#"+pgid).html(allstr);
	}

	function viewcodes(list, title, name, data)
	{
		var selDecoc = "";

		for(var key in list)
		{
			if(isEmpty(data))
			{
				if('inmain' == list[key]["cdCode"])
				{
					selDecoc=list[key]["cdName"];
					break;
				}
			}
			else
			{
				if(data == list[key]["cdCode"])
				{
					selDecoc=list[key]["cdName"];
					break;
				}
			}
		}

		return selDecoc;
	}

	//viewsweets("sweetDiv", obj["sweet"], '<?=$txtdt["1146"]?>사용안함 ', '<?=$txtdt["1018"]?> 개');
	function viewsweets(pgid, list, notxt, cnttxt, readonly)
	{
		var str = selected="";
		var i=0;
		var disable = (readonly == 'readonly') ? "disabled='disabled'" : "";
		for(var key in list)
		{
			for(i=1;i<=10;i++)
			{
				if(list[key]["rcCapa"] == i)
				{
					var selected="selected";					
					str+='<span class="mg5r">'+'&nbsp;&nbsp;'+list[key]["rcMedititle"]+'</span>';  //별전이름
					str+='<select  class="reqdata selectsweet resetcode" '+disable+' data-price="'+list[key]["rcPrice"]+'" >';
					str+= '<option  "+selected+" readonly>'+'<span>'+list[key]["rcCapa"]+'</span>'+cnttxt+'</option>';
					str+='</select>';
				}
				//str+='<option value="'+i+'" '+selected+'>'+i+cnttxt;
			}
		}
		$("#"+pgid).html(str);
	}



	function checkMedicalCY(site)
	{
		if(site=="CY")
		{
			return true;
		}
		return false;
	}
	function makepage(json)
	{
		console.log("makepage ----------------------------------------------- start")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])

		if(obj["apiCode"]=="orderdesc") //주문상세
		{
			var maPrice=dcPrice=rePrice=reBox=reBoxmedibox=odPackprice=reBoxmediprice=reBoxdeliprice=0;

			$("#decocDiv").hide();
			$("#sfextDiv").hide();
			$("#edextractDiv").hide();
			$("#decocTitleDiv").hide();
			$("#sfextTitleDiv").hide();
			$("#edextractTitleDiv").hide();
			

			maPrice=(!isEmpty(obj["maPrice"]) ? parseFloat(obj["maPrice"]) : parseFloat(obj['config']['cfMakingprice']));//조제비
			maPrice=(parseFloat(maPrice)<=0) ? parseFloat(obj['config']['cfMakingprice']) : maPrice;

			dcPrice=(!isEmpty(obj["dcPrice"]) ? parseFloat(obj["dcPrice"]) : parseFloat(obj['config']['cfDecocprice']));//탕전비
			dcPrice=(parseFloat(dcPrice)<=0) ? parseFloat(obj['config']['cfDecocprice']) : dcPrice;

			rePrice=(!isEmpty(obj["rePrice"]) ? parseFloat(obj["rePrice"]) : parseFloat(obj['config']['cfReleaseprice']));//배송비
			rePrice=(parseFloat(rePrice)<=0) ? parseFloat(obj['config']['cfReleaseprice']) : rePrice;

			reBox=(!isEmpty(obj["reBox"]) ? parseFloat(obj["reBox"]) : parseFloat(obj['config']['cfBox']));//100팩당 1박스
			reBox=(parseFloat(reBox)<=0) ? parseFloat(obj['config']['cfBox']) : reBox;


			$("input[name=maPrice]").val(maPrice);//maPrice
			$("input[name=dcPrice]").val(dcPrice);//dcPrice
			$("input[name=rePrice]").val(rePrice);//rePrice
			$("input[name=reBox]").val(reBox);//reBox
			$("input[name=reBoxmedibox]").val(reBoxmedibox);//reBoxmedibox





			//------------------------------------------
			// 주문내역
			//------------------------------------------
			//djmedi 결제금액 json data 	
			$("textarea[name=odAmountdjmedi]").val(obj["odAmountdjmedi"]);
			//okchart 결제금액 json data 	
			$("textarea[name=odAmountokchart]").val(obj["odAmountokchart"]);

			setAmountDjmedi();

			$("input[name=odMatype]").val(obj["odMatype"]);//조제타입 

			$("input[name=odSitecategory]").val(obj["odSitecategory"]);
			

			$("input[name=seq]").val(obj["seq"]);//seq
			$("input[name=rcSeq]").val(obj["rcSeq"]);//rcSeq
			$("input[name=odCode]").val(obj["odCode"]);//주문코드
			$("input[name=odStatus]").val(obj["odStatus"]);//상태
			$("input[name=odKeycode]").val(obj["odKeycode"]);//주문코드	

			var delidate = (isEmpty(obj["reDelidate"])) ? getNewDate() : obj["reDelidate"];
			$("input[name=reDelidate]").val(delidate);//배송희망일
			$("#td_odCode").text(obj["odCode"]);//주문코드
			$("#reDelidateDiv").text(obj["reDelidate"]);//배송희망일
			$("#odStaffDiv").text(obj["odStaffName"]);//처방자
			$("#reNameDiv").text(obj["miName"]);//한의원

			$("#maTypeDiv").text(obj["maTypeName"]);//조제타입

			//20190822 : 환자명,성별,생년월일,사상 추가 
			$("#odRecipe").text(obj["patientTypeName"]);
			$("#odName").text(obj["odName"]);//환자명
			$("#odBirth").text(obj["odBirth"]);//생년월일
			$("#meGenderDiv").text(getCodeName(obj["meSexList"], obj["odGender"]));//성별
			$("#mhFeatureDiv").text(getCodeName(obj["mhFeatureList"], obj["odFeature"]));//사상						

			$("#odScriptionDiv").text(obj["odTitle"]);//처방명
			$("#odChartPK").html(obj["odChartPK"]);//odChartPK
			$("#odChubcntDiv").text(obj["odChubcnt"]+' ea');//첩수
			$("#odPackcntDiv").text(obj["odPackcnt"]+' '+'<?=$txtdt["1018"]?>');//팩수
			$("#odPackcapaDiv").text(obj["odPackcapa"]+' ml');//팩용량		

			var odChubcnt = isEmpty(obj["odChubcnt"]) ? "<?=$BASE_CHUBCOUNT?>" : obj["odChubcnt"];
			var odPackcnt = isEmpty(obj["odPackcnt"]) ? "<?=$BASE_PACKCOUNT?>" : obj["odPackcnt"];
			var odPackcapa = isEmpty(obj["odPackcapa"]) ? "<?=$BASE_PACKCAPA?>" : obj["odPackcapa"];
			$("input[name=odChubcnt]").val(odChubcnt);//첩수
			$("input[name=odPackcnt]").val(odPackcnt);//팩수
			$("input[name=odPackcapa]").val(odPackcapa);//팩용량
			$("input[name=odPackprice]").val(obj["odPackprice"]);

			//처방자
			$("input[name=odStaff]").val(obj["odStaff"]);

			//------------------------------------------
			// 탕전정보입력
			//------------------------------------------
			$("#odDctitleDiv").text(obj["dcTitletext"]);//탕전법
			$("#odDcspecialDiv").html(obj["dcSpecialtext"]);//특수탕전

			$("#dcTimeDiv").text(obj["dcTime"]+" "+'<?=$txtdt["1437"]?>');//탕전시간
			$("#dcWaterDiv").html(obj["dcWatertxt"]);//탕전물량


			$("#odGoodsMDiv").html(obj["gGoodsM"]);

			//감미제 
			$("#dcSugarDiv").html(obj["dcSugarName"]);



			//------------------------------------------
			// 마킹
			//------------------------------------------
			//$("#odMrdescDiv").html(obj["markingtxt"]);
			viewmarking("odMrdescDiv", obj["markingtxt"]);
			//viewmarking("odMrdescDiv", obj["mrDescList"], '<?=$txtdt["1077"]?>','mrDesc', 'mrDesc', obj["mrDesc"]);

			//------------------------------------------
			// 배송정보
			//------------------------------------------
			//보내는사람 
			$("#reSendNameDiv").text(obj["reSendname"]); //보내는사람 
			$("#reSendPhoneDiv").text(obj["reSendphone"]); //전화번호 
			$("#reSendMobileDiv").text(obj["reSendmobile"]); //배송종류
			$("#reSendZipcodeDiv").text("["+obj["reSendzipcode"]+"] "+obj["reSendaddress"]+" "+obj["reSendaddress1"]); //휴대폰번호

			//------------------------------------------
			//받는사람 
		
			$("#reNametext").text(obj["reName"]); //받는사람
			$("#rePhoneDiv").text(obj["rePhone"]); //전화번호 
			$("#reDelitypeDiv").text(obj["reDelitypetext"]); //배송종류
			$("#reMobileDiv").text(obj["reMobile"]); //휴대폰번호
			
			$("#reZipcodeDiv").text("["+obj["miZipcode"]+"] "+obj["addr1"]+obj["addr2"]); //우편번호
			$("#reMobileDiv").text(obj["reMobile"]); //배송요구사항
			$("#reRequestDiv").text(obj["reRequest"]); //배송요구사항

			$("#odRequestDiv").text(obj["odRequest"]); //조제/탕전 요청사항
			$("#odAdviceDiv").html(obj["odAdvice"]); //복약지도

			//------------------------------------------
			// 포장 및 박스
			//------------------------------------------
			if(obj["odMatype"]==="pill")
			{
				$("#decocTitleDiv").show();
				$("#decocDiv").show();
				viewcypack("odPacktypeDiv", obj["packname"], obj["packimg"]);
			}
			else
			{
				$("#decocTitleDiv").show();
				$("#decocDiv").show();
				viewcypack("odPacktypeDiv", obj["packname"], obj["packimg"]);
			}
		
			//한약박스종류선택
			/*if(!isEmpty(obj["cyBoxImg"]))
			{
				viewcypack("reBoxmediDiv", obj["cyBoxName"], obj["cyBoxImg"]);
			}
			else
			{
				viewpack("reBoxmediDiv", obj["reBoxmediList"], '<?=$txtdt["1468"]?>', 'reBoxmedi', obj["reBoxmedi"], obj["reBoxmediprice"],'<?=$txtdt["1235"]?>','');
			}*/
			viewcypack("reBoxmediDiv", obj["boxmediname"], obj["boxmediimg"]);

			//배송포장재종류
			viewcypack("reBoxdeliDiv", obj["boxdeliname"], obj["boxdeliimg"]);
			//viewpack("reBoxdeliDiv", obj["reBoxdeliList"], '<?=$txtdt["1396"]?>', 'reBoxdeli', obj["reBoxdeli"],obj["reBoxdeliprice"], '<?=$txtdt["1235"]?>','');

			//감미제 
			//$("#dcSugarDiv").text(obj["mdTitle"]);



			var tmpboxmedibox=$("input[name=reBoxmedibox]").val();
			reBoxmedibox=(!isEmpty(obj["reBoxmedibox"])) ? parseFloat(obj["reBoxmedibox"]) : parseFloat(tmpboxmedibox);//한약박스50팩당 1박스
			reBoxmedibox=(parseFloat(reBoxmedibox)<=0) ? parseFloat(tmpboxmedibox) : reBoxmedibox;


			$("#dcShapeDiv").text(getCodeName(obj["dcShapeList"], obj["dcShape"]));
			$("#dcBindersDiv").text(getCodeName(obj["dcBindersList"], obj["dcBinders"]));
			$("#dcFinenessDiv").text(getCodeName(obj["dcFinenessList"], obj["dcFineness"]));
			$("#dcDry").text(obj["dcDry"]+"<?=$txtdt['1842']?>");
			//$("#dcTerms").text(getCodeName(obj["dcTermsList"], obj["dcTerms"]));
			//$("#dcTermssfext").text(getCodeName(obj["dcTermsList"], obj["dcTerms"]));

			

			$("#dcMillingloss").text(obj["dcMillingloss"]+"g");
			$("#dcLossjewan").text(obj["dcLossjewan"]+"g");
			$("#dcBindersliang").text(obj["dcBindersliang"]+"g");
			$("#dcCompleteliang").text(obj["dcCompleteliang"]+"g / "+obj["dcCompletecnt"]+"ea");


			//농축엑기스 
			$("#edcFinenessDiv").text(getCodeName(obj["dcFinenessList"], obj["dcFineness"]));
			$("#dcJungtangDiv").text(getCodeName(obj["dcJungtangList"], obj["dcJungtang"]));
			$("#dcRipenDiv").text(getCodeName(obj["dcRipenList"], obj["dcRipen"]));

			//------------------------------------------
			// 약재리스트
			//------------------------------------------
			var rcMedicine = isEmpty(obj["rcMedicine"]) ? "" : obj["rcMedicine"];
			var rcSweet = isEmpty(obj["rcSweet"]) ? "" : obj["rcSweet"];
			var data = "medicine="+rcMedicine+"&sweet="+rcSweet;
			$("#ordermedicine").load("<?=$root?>/Skin/Order/medicineDetail.php?" + data);

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
					var ta = '<textarea class="w100p" rows="5" name="odRestarttext" id="odRestarttext">'+obj["odRestarttext"]+'</textarea>';					
					addData+= parseDivTable('<?=$txtdt["1670"]?>', obj["cancelTypeName"] + "( "+obj["odCanceltext"]+" )");
					addData+='<div class="sgap"></div>';
					addData+= parseDivTable('<?=$txtdt["1675"]?>', ta);
				}

				$("input[name=od_canceltype]").val(obj["od_canceltype"]);
				$("input[name=restarttxt]").val(obj["restarttxt"]);
			}

			$("#addDiv").html(addData);

			//------------------------------------------
			// 버튼
			//------------------------------------------
			var btn_html = "";
			var Auth = $("input[name=modifyAuth]").val();

			//if(Auth=="true")
			//{
				if(!isEmpty(obj["odStatus"]))
				{
					var status = obj["odStatus"];
					if(status.indexOf("_cancel") != -1){
						//if(isEmpty(obj["odRestarttext"]))
							//btn_html='<a href="javascript:;" onclick="orderchangeupdate();" class="bdp-btn"><span><?=$txtdt["1283"]?></span></a> ';/*"재시작하기*/
					}else if(status=="order"||status==""){
						//btn_html='<a href="javascript:;" onclick="chart_update();" class="bdp-btn"><span><?=$txtdt["1071"]?></span></a> ';/*"등록/수정하기*/
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
				}
				else
				{
					//btn_html='<a href="javascript:;" onclick="chart_update();" class="bdp-btn"><span><?=$txtdt["1071"]?></span></a> ';/*"등록/수정하기*/
				}

				btn_html+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';
				/*
				if(!isEmpty(obj["seq"]))
				{
					if(!isEmpty(obj["odStatus"]) && status.indexOf("_processing") == -1) //진행중일때는 삭제버튼이 나오지 않게 하자 
					{
						var json = "seq="+obj["seq"];
						btn_html+='<a href="javascript:;" onclick="callapidel(\'order\',\'orderdelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';
					}
				}
				*/
			//}
			//else
			//{
				//btn_html+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
			//}
			$("#btnDiv").html(btn_html);


		}
		else if(obj["apiCode"]=="medicinereupdate")
		{
			if(obj["resultCode"]=="200" && obj["resultMessage"] == "OK")
			{
				alertsign("info", "약재업데이트 완료!", "", "2000");//'약재가 등록되었습니다.'
				var data="seq="+obj["seq"];
				callapi('GET','order','orderdesc',data);
			}
		}
		else if(obj["apiCode"]=="medicinetitle") //약재구성
		{
			//var boardpage=$("#board-list-wrap").hasClass("board-list-wrap");//약재리스트 테이블
			var layerpage=$("#layer_medicine_wrap").hasClass("layer-wrap");//약재추가 팝업 테이블

			//var selDecoc = viewcodes(obj["decoctypeList"], '<?=$txtdt["1367"]?>', 'rcDecoctype', null);
			//$("#board-list-wrap").prepend("<textarea name='selDecoctype' style='display:none;'>"+selDecoc+"</textarea>");

			var dismatch = "_"+obj["dismatch"]; //여기에 _를 붙여야지.. 밑에 dismatch.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var poison = "_"+obj["poison"]; //여기에 _를 붙여야지.. 밑에 poison.indexOf(rcmedicine) != -1 이 인식이됨..머지?
			var data = medilist = medicode = cls = clstitle = medibox = beobje="";
			var capa = totalqty = 0;
			var decoc=[];

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

				//감미제, 녹용, 자하거
				//viewsweets("sweetDiv", obj["sweet"], '<?=$txtdt["1146"]?>', '<?=$txtdt["1018"]?>','readonly');
				capa = parseFloat(value["rcCapa"]);
				capa = (isNaN(capa)==false) ? capa : 0;
				capa = !isEmpty(capa) ? capa : 0;
				capa = capa.toFixed(1);//소수점 1자리

				price = parseFloat(value["rcPrice"]);
				price = (isNaN(price)==false) ? price : 0;
				price = !isEmpty(price) ? price:0;


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
					//console.log("totalqty : " + totalqty);

					//------------------------------------------------
					//미등록약재 & 약재코드 
					//------------------------------------------------
					if(checkMedicine(value["rcMedicode"])==false)
					{
						if(!isEmpty(value["mmCode"]))
						{
							data+='<tr class="meditr" id="md'+value["mmCode"]+'">';
							//미등록약재
							data+='	<td><?=$txtdt["1836"]?><input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
						}
						else
						{
							data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
							data+='	<td><?=$txtdt["1836"]?><input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
						}
					}
					else
					{
						data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
						data+='	<td>'+value["mmCode"]+'<input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
					}
					//------------------------------------------------
					var selDecoc = viewcodes(obj["decoctypeList"], '<?=$txtdt["1367"]?>', 'rcDecoctype', value["rcDecoctype"]);
					data+='	<td>'+selDecoc+'</td>';  //타입

					//------------------------------------------------
					//약재명
					//------------------------------------------------
					if(checkMedicine(value["rcMedicode"])==false)
					{
						var mcode=(!isEmpty(value["mmCode"])) ? '('+value["mmCode"]+')' : "";
						data+='	<td class="l"><span class="mdtype mdmedi"></span><b>'+value["rcMedititle"]+mcode+'</b> <button type="button" class="cp-btn" onclick="javascript:noneMediUpdate(\''+value["mmCode"]+'\', \''+value["rcMedititle"]+'\');" ><span><?=$txtdt["1202"]?></span></button></td>';  //약재명(약재함)
					}
					else
					{
						if(!isEmpty(value["exceltitle"]))
						{
							data+='	<td class="l"><span class="mdtype mdmedi"></span><b>'+value["exceltitle"]+'</b></td>';  //약재명(약재함)
						}
						else
						{
							data+='	<td class="l"><span class="mdtype mdmedi"></span><b>'+value["rcMedititle"]+'</b></td>';  //약재명(약재함)
						}
						
					}
					//------------------------------------------------


					//------------------------------------------------
					//법제 
					//------------------------------------------------
					beobje="";
					if(!isEmpty(value["exceltitle"]) && value["exceltitle"].match("-")) //약재명에 -가 있다면 
					{
						var titleSplit=value["exceltitle"].split("-");
						beobje=titleSplit[1];
					}
					data+='	<td style="font-size:15px;color:red;">'+beobje+'</td>';//법제 
					//------------------------------------------------

					//------------------------------------------------
					//약재함이 공통&조제대인지 
					//------------------------------------------------
					data+='	<td>'+medibox+'</td>';//약재함이 공통인지 조제대인지 
					//------------------------------------------------

				
					//------------------------------------------------
					//독성&상극					
					//------------------------------------------------
					data+='	<td>'+clstitle+'</td>';
					//------------------------------------------------

					//원산지 
					data+='	<td>'+value["rcOrigin"]+' / '+value["rcMaker"]+'</td>';
					data+='	<td class="rctotalqty r" id="idTotalQty">'+comma(totalqty)+'</td>';//현재재고량			
					data+='	<td class="r"><span class="chubamt ">'+capa+'</span>g '; //첩당약재량		
					data+=' <input type="hidden" id="id_water" class="w30p" value="'+value["rcWater"]+'" readonly/>';
					data+=' <input type="hidden" id="id_total_qty" class="w30p" value="'+totalqty+'" readonly/>';
					data+=' <input type="hidden" id="id_dismatch_poison" class="w30p dispoison" value="'+cls+'" readonly/></td>';
					data+='	<td class="r"><span id="id_mediamt" class="w70p tc mediamt"></span>g</td>';//총약재량
					data+='	<td class="r"><span id="id_mprice" class="w50p tc mgprice">'+price+'</span><?=$txtdt["1235"]?></td>';//약재비			
					data+='	<td class="r"><span id="id_mediprice" class="w70p tc mediprice" value="0"></span><?=$txtdt["1235"]?></td>';//총약재비
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

					medicode+="|"+value["rcMedicode"]+","+value["rcCapa"]+","+value["rcDecoctype"];
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

				//감미제, 녹용, 자하거
				//viewsweets("sweetDiv", obj["sweet"], '<?=$txtdt["1146"]?>', '<?=$txtdt["1018"]?>','readonly');
				capa = parseFloat(value["rcCapa"]);
				capa = (isNaN(capa)==false) ? capa : 0;
				capa = !isEmpty(capa) ? capa : 0;
				capa = capa.toFixed(1);//소수점 1자리

				price = parseFloat(value["rcPrice"]);
				price = (isNaN(price)==false) ? price : 0;
				price = !isEmpty(price) ? price:0;



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
					//console.log("totalqty : " + totalqty);

					//------------------------------------------------
					//미등록약재 & 약재코드 
					//------------------------------------------------
					if(checkMedicine(value["rcMedicode"])==false)
					{
						if(!isEmpty(value["mmCode"]))
						{
							data+='<tr class="meditr" id="md'+value["mmCode"]+'">';
							//미등록약재
							data+='	<td><?=$txtdt["1836"]?><input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
						}
						else
						{
							data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
							data+='	<td><?=$txtdt["1836"]?><input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
						}
					}
					else
					{
						data+='<tr class="meditr" id="md'+value["rcMedicode"]+'">';
						data+='	<td>'+value["mmCode"]+'<input type="hidden" id="nrccode" class="rccode" value="'+value["rcMedicode"]+'" readonly/></td>';
					}
					//------------------------------------------------
					data+='	<td><input type="hidden" class="srcDecoctype" value="inlast">별전</td>';

					//------------------------------------------------
					//약재명
					//------------------------------------------------
					if(checkMedicine(value["rcMedicode"])==false)
					{
						var mcode=(!isEmpty(value["mmCode"])) ? '('+value["mmCode"]+')' : "";
						data+='	<td class="l"><span class="mdtype mdsweet"></span><b>'+value["rcMedititle"]+mcode+'</b> <button type="button" class="cp-btn" onclick="javascript:noneMediUpdate(\''+value["mmCode"]+'\', \''+value["rcMedititle"]+'\');" ><span><?=$txtdt["1202"]?></span></button></td>';  //약재명(약재함)
					}
					else
					{
						if(!isEmpty(value["exceltitle"]))
						{
							data+='	<td class="l"><span class="mdtype mdsweet"></span><b>'+value["exceltitle"]+'</b></td>';  //약재명(약재함)
						}
						else
						{
							data+='	<td class="l"><span class="mdtype mdsweet"></span><b>'+value["rcMedititle"]+'</b></td>';  //약재명(약재함)
						}
						
					}
					//------------------------------------------------


					//------------------------------------------------
					//법제 
					//------------------------------------------------
					beobje="";
					if(!isEmpty(value["exceltitle"]) && value["exceltitle"].match("-")) //약재명에 -가 있다면 
					{
						var titleSplit=value["exceltitle"].split("-");
						beobje=titleSplit[1];
					}
					data+='	<td style="font-size:15px;color:red;">'+beobje+'</td>';//법제 
					//------------------------------------------------

					//------------------------------------------------
					//약재함이 공통&조제대인지 
					//------------------------------------------------
					data+='	<td>'+medibox+'</td>';//약재함이 공통인지 조제대인지 
					//------------------------------------------------

				
					//------------------------------------------------
					//독성&상극					
					//------------------------------------------------
					data+='	<td>'+clstitle+'</td>';
					//------------------------------------------------

					//원산지 
					data+='	<td>'+value["rcOrigin"]+'</td>';
					data+='	<td class="rctotalqty r" id="idTotalQty">'+comma(totalqty)+'</td>';//현재재고량			
					data+='	<td class="r"><span class="schubamt ">'+capa+'</span>g '; //첩당약재량		
					data+=' <input type="hidden" id="id_water" class="w30p" value="'+value["rcWater"]+'" readonly/>';
					data+=' <input type="hidden" id="id_total_qty" class="w30p" value="'+totalqty+'" readonly/>';
					data+=' <input type="hidden" id="id_dismatch_poison" class="w30p dispoison" value="'+cls+'" readonly/></td>';
					data+='	<td class="r"><span id="id_mediamt" class="w70p tc smediamt"></span>g</td>';//총약재량
					data+='	<td class="r"><span id="id_mprice" class="w50p tc smgprice">'+price+'</span><?=$txtdt["1235"]?></td>';//약재비			
					data+='	<td class="r"><span id="id_mediprice" class="w70p tc mediprice" value="0"></span><?=$txtdt["1235"]?></td>';//총약재비
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

					medicode+="|"+value["rcMedicode"]+","+value["rcCapa"]+","+value["rcDecoctype"];
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
				resetamountdetail();
				//resetmedi();

				checkPoisonDismatch();
			}
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


	}
	function resetamountdetail()
	{
		var chubcnt=0;
		var chubtotal=schubtotal=chubpricetotal=chubprice=meditotal=watertotal=pricetotal=medipricetotal=0;
		var tval=mediamt=tprice=mdprice=twater=mdwater=totalmediprice=0;

		//첩수
		chubcnt=parseFloat($("input[name=odChubcnt]").val());

		//첩당
		$(".chubamt").each(function(){
			//-------------------------------------------------------------------------------
			// 총약재
			//-------------------------------------------------------------------------------
			tval = parseFloat($(this).text());//첩당약재
			tval=((isNaN(tval)==false)) ? tval:0;
			mediamt= tval * parseFloat(chubcnt);//첩당약재 * 첩수 = 총약재
			//$(this).parent().next().children("input").val(commasFixed(mediamt));//총약재 input box
			$(this).parent().next().children("span").text(commasFixed(mediamt));//총약재 input box
			//-------------------------------------------------------------------------------
			//약재가 부족하면 현재약재량을 빨간색으로 바꾼다.
			var totalqty = $(this).parent().children("#id_total_qty").val();
			//console.log("totalqty : " + totalqty);
			if(parseFloat(totalqty) < parseFloat(mediamt) || (parseFloat(totalqty) == 0))
			{
				$(this).parent().prev().css('color','red');
				$(this).parent().prev().css('font-weight','bolder');
				$(this).parent().prev().css('font-size','15px');
			}

			//-------------------------------------------------------------------------------
			// 총약재비
			//-------------------------------------------------------------------------------
			tprice=$(this).parent().next().next().children("span").text();//1g당 약재비
			tprice=((isNaN(tprice)==false)) ? parseFloat(tprice):0;
			mdprice = (mediamt * parseFloat(tprice));//총약재 * 1g당약재비 = 총약재비 ---- 반올림

			$(this).parent().next().next().next().children("span").text(commasFixed(mdprice));//총약재비 input box
			//$(this).parent().next().next().next().children("input").val(commasFixed(mdprice));//총약재비 input box
			//-------------------------------------------------------------------------------

			//-------------------------------------------------------------------------------
			//흡수율 계산
			//-------------------------------------------------------------------------------
			twater = $(this).parent().children("#id_water").val();//해당약재 흡수율
			twater = ((isNaN(twater)==false)) ? twater:0;
			mdwater = (parseFloat(mediamt) * parseFloat(twater))/100; // (총약재*흡수율) 나누기 100
			//-------------------------------------------------------------------------------
			chubprice=(tval*tprice);
			chubpricetotal+=chubprice;
			chubtotal+=tval;//첩당무게 토탈
			meditotal+=mediamt;//총약재 토탈
			medipricetotal+=mdprice;//총약재비 토탈
			watertotal+=mdwater;//총물량 토탈
			pricetotal+=tprice;//1g당 약재비


			//console.log("흡수율 총약재 = "+mediamt+", 흡수율 = " + twater+", mdwater = " + mdwater+", watertotal = " + watertotal);

		});

		//-------------------------------------------------------------------------------
		// sweet 계산
		//-------------------------------------------------------------------------------
		var tsweetval=tsweettype=sweettotal=sweetcnt=stprice=smdprice=stwater=smdwater=sweetpricetotal=0;
		sweettotal=0;
		sweetcnt=0;
		sweetprice=0;
		schubtotal=0;
		$(".schubamt").each(function() {

			tsweetval = parseFloat($(this).text());//첩당약재
			$(this).parent().next().children("span").text(commasFixed(tsweetval));//총약재 input box

			//-------------------------------------------------------------------------------
			// 총약재비
			//-------------------------------------------------------------------------------
			stprice=$(this).parent().next().next().children("span").text();//1g당 약재비
			stprice=((isNaN(stprice)==false)) ? parseFloat(stprice):0;
			smdprice = (tsweetval * parseFloat(stprice));//총약재 * 1g당약재비 = 총약재비 ---- 반올림

			$(this).parent().next().next().next().children("span").text(commasFixed(smdprice));//총약재비 input box
			//-------------------------------------------------------------------------------

			//-------------------------------------------------------------------------------
			//흡수율 계산
			//-------------------------------------------------------------------------------
			stwater = $(this).parent().children("#id_water").val();//해당약재 흡수율
			stwater = ((isNaN(stwater)==false)) ? stwater:0;
			smdwater = (parseFloat(tsweetval) * parseFloat(stwater))/100; // (총약재*흡수율) 나누기 100
			//-------------------------------------------------------------------------------

			watertotal+=smdwater;//총물량 토탈
			schubtotal+=tsweetval;
			sweetpricetotal+=smdprice;

			console.log("흡수율 총별전 = "+tsweetval+", 흡수율 = " + stwater+", smdwater = " + smdwater+", watertotal = " + watertotal);

			sweetprice+=stprice;
			sweetcnt+=tsweetval;
			sweettotal+=smdprice;

		});
		//-------------------------------------------------------------------------------

		$("#chubtotal").text(commasFixed(chubtotal));//첩당무게 토탈
		$("#schubtotal").text(commasFixed(schubtotal));//첩당무게 토탈
		$("#meditotal").text(commasFixed(meditotal));//총약재 토탈
		$("#pricetotal").text(commasFixed((medipricetotal + sweetpricetotal)));//총약재비 토탈
	}

	//주문상세 API 호출
	callapi('GET','order','orderdesc','<?=$apiOrderData?>');

</script>
