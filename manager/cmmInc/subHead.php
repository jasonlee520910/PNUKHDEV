<?php 
include_once ($root.'/cmmInc/headProc.php');
?>
<?php 
	$catetit=array(
		"00_DashBoard"=>"DashBoard"/*$txtdt["1306"]"DashBoard"*/,
		"01_Order"=>$txtdt["1306"]/*"주문현황"*/,
		"02_Member"=>$txtdt["1147"]/*"사용자관리"*/,
		"03_Medicine"=>$txtdt["1200"]/*"약재관리"*/,
		"04_Stock"=>$txtdt["1281"]/*"재고관리"*/,
		"05_Recipebasic"=>$txtdt["1322"]/*"처방관리"*/,
		"06_Inventory"=>$txtdt["1274"]/*"자재코드관리"*/,
		"07_Setting"=>$txtdt["1413"]/*"환경설정"*/,
		"08_Goods"=>"제품관리"/*"제품관리"*/,
		"09_Content"=>"공지사항"/*"제품관리"*/,
		"81_Customer"=>$txtdt["1556"]/*"고객정보"*/,
		"82_Estimate"=>$txtdt["1558"]/*"견적"*/,
		"83_SetSale"=>$txtdt["1561"]/*"설정"*/
	);
	switch($_SESSION["ss_auth"])
	{
		case "headquarters": case "distributor": case "partner":
			$slaesarray=array("82_Estimate"=>$txt["1558"]/*"견적"*/,"83_Setsales"=>$txt["1561"]/*"설정"*/);
			array_push($catetit,$slaesarray);
			break;
		case "sales":
			$slaesarray=array("81_Customer"=>$txt["1556"]/*"고객정보"*/,"82_Estimate"=>$txt["1558"]/*"견적"*/,"83_Setsales"=>$txt["1561"]/*"설정"*/);
			array_push($catetit,$slaesarray);
			break;
		case "tutadmin":
			$slaesarray=array("61_Marketing"=>$txt["1565"]/*"마케팅"*/);
			array_push($catetit,$slaesarray);
			break;
	}

	$menutit=array(
		"OrderDashBoard"=>$txtdt["1280"]/*"작업현황"*/,
		"Orders"=>$txtdt["1783"]/*"주문보고서"*/,
		"Delivery"=>"배송리스트"/*$txtdt["1915"]"배송리스트"*/,
		"Makings"=>$txtdt["1784"]/*"조제보고서"*/,
		"Recipes"=>$txtdt["1785"]/*"처방보고서"*/,
		"Medicines"=>$txtdt["1786"]/*"약재보고서"*/,
		"Boiler"=>$txtdt["1938"]/*"탕전기보고서"*/,
		"Packing"=>$txtdt["1938"]/*"포장기보고서"*/,
		"Order"=>$txtdt["1301"]/*"주문리스트"*/,
		"OrderList"=>$txtdt["1301"]/*"주문리스트"*/,
		"OrderWrite"=>$txtdt["1301"]/*"주문리스트"*/,
		"Member"=>$txtdt["1406"]/*"한의원관리"*/,
		"MemberList"=>$txtdt["1406"]/*"한의원관리"*/,
		"MemberWrite"=>$txtdt["1407"]/*"한의원등록"*/,
		"Doctor"=>"한의사관리"/*"한의원관리"*/,
		"DoctorList"=>"한의사관리"/*"한의원관리"*/,
		"DoctorWrite"=>"한의사등록"/*"한의원등록"*/,
		"Staff"=>$txtdt["1183"],/*"스탭관리"*/
		"StaffList"=>$txtdt["1183"], /*"스탭관리"*/
		"StaffWrite"=>$txtdt["1184"], /*"스탭등록"*/
		"Hub"=>$txtdt["1123"],
		"HubList"=>$txtdt["1123"],
		"HubWrite"=>$txtdt["1428"],
		"HubCategory"=>$txtdt["1126"],
		"Medicine"=>$txtdt["1200"],
		"MedicineList"=>$txtdt["1200"],
		"MedicineSmu"=>$txtdt["1200"],
		"MedicineWrite"=>$txtdt["1202"],
		"DismatchWarning"=>$txtdt["1159"],
		"PoisonWarning"=>$txtdt["1066"],
		"Stock"=>$txtdt["1209"],
		"StockList"=>$txtdt["1429"],
		"InStockList"=>$txtdt["1208"],
		"InStock"=>$txtdt["1208"],//$txtdt["1431"],
		"OutStockList"=>$txtdt["1212"],
		"OutStock"=>$txtdt["1212"],//$txtdt["1432"],
		"GeneralStockList"=>$txtdt["1272"],
		"GeneralStock"=>$txtdt["1272"],//$txtdt["1433"],
		"StockRoute"=>$txtdt["1787"]/*"약재이력추적"*/,
		"MedicineUseDown"=>$txtdt["1892"]/* 약재사용다운로드"*/,
		"Resource"=>$txtdt["1324"],
		"GeneralPrescription"=>"이전처방",//$txtdt["1322"],
		"GeneralPrescriptionWrite"=>"이전처방",//$txtdt["1434"],
		"UniquePrescription"=>$txtdt["1026"],
		"UniquePrescriptionWrite"=>$txtdt["1430"],
		"Worthy"=>$txtdt["1909"], //실속처방
		"WorthyWrite"=>$txtdt["1910"], //실속처방등록
		"Commercial"=>$txtdt["1925"], //상용처방
		"CommercialList"=>$txtdt["1925"], //상용처방
		"CommercialWrite"=>$txtdt["1925"], //상용처방등록
		"recipeGoods"=>$txtdt["1924"], //약속처방
		"recipeGoodsList"=>$txtdt["1924"], //약속처방
		"recipeGoodsWrite"=>$txtdt["1924"], //약속처방등록

		"Recommend"=>"추천처방",//추천처방
		"RecommendList"=>"추천처방",//추천처방
		"RecommendWrite"=>"추천처방등록",//추천처방등록
		"MyRecipe"=>"나의처방",//나의처방
		"MyRecipeList"=>"나의처방",//나의처방
		"MyRecipeWrite"=>"나의처방등록",//나의처방등록

		"Policy"=>"개인정보처리방침",
		"PolicyWrite"=>"개인정보처리방침",
		



		"MedicineBox"=>$txtdt["1217"],
		"PouchTag"=>$txtdt["1295"],
		"PotCode"=>$txtdt["1363"],
		"Packing"=>$txtdt["1918"], //포장기 관리
		"MakingTable"=>$txtdt["1599"],
		"PackagingCode"=>$txtdt["1393"],
		"PackagingWrite"=>$txtdt["1435"],
		"CodeManager"=>$txtdt["1357"],
		"CodeWrite"=>$txtdt["1436"],
		"TextDB"=>$txtdt["1223"],
		"BarCode"=>$txtdt["1093"],
		"Equipment"=>"장비관리",
		"Api"=>"Api",
		"GoodsRegist"=>"제품등록",
		"Goods"=>"제품목록",
		"GoodsG"=>"사전조제",
		"GoodsMedicine"=>"제품원재료관리",
		"GoodsLog"=>"제품입출고목록",
		"Notice"=>"공지사항",
		"Faq"=>"FAQ",
		"Qna"=>"1:1문의",
		"Popup"=>"팝업",		
		"Customers"=>$txtdt["1557"]/*"일반고객"*/,
		"EstimateBasic"=>$txtdt["1559"]/*"기본견적"*/,
		"Estimate"=>$txtdt["1560"]/*"세부견적"*/,
		"SetCategory"=>$txtdt["1562"]/*"분류설정"*/,
		"SetPrice"=>$txtdt["1563"]/*"가격설정"*/,
		"SetSales"=>$txtdt["1564"]/*"영업설정"*/,
		"Tutorials"=>"튜토리얼관리"
		);
?>
<textarea id="comTxtdt" name="comTxtdt" cols="200" style="display:none;"><?=json_encode($ComTxtdt)?></textarea> <!--style="display:none;"-->
<textarea id="comSearchData" name="comSearchData" cols="200" style="display:none;"></textarea> <!--style="display:none;"-->
<textarea id='comPageData' name="comPageData" cols='200' style="display:none;"></textarea>
<textarea name="tmpSearchTxt" cols='200' style="display:none;"></textarea>

<script  type="text/javascript" src="<?=$root?>/cmmJs/layoutSub.js"></script>
<script  type="text/javascript" src="<?=$root?>/_Js/sub.js"></script>
<script src="<?=$root?>/_module/chart/chart.min.2.8.0.js"></script>
<script src="<?=$root?>/_module/chart/utils.js"></script>
<!-- s: #doc //-->

<!-- <div id="skipNavi">
	<h1 class="blind">사이트이릅 - 스킵네비게이션</h1>
	<ul>
		<li><a href="#contents" class="skipLink">본문바로가기</a></li>
		<li><a href="#topmenu" class="skipLink">주메뉴바로가기</a></li>
	</ul>
</div> -->
<!-- s: .doc-pg //-->
<div id="pg-code" class="doc-pg">
	<?php  include_once ($root.'/cmmInc/headerInc.php');?>
	<!-- s: #container-wrap //-->
	<div id="container-wrap">
			<div id="subNavi-wrap">
				<div id="subNavi">
					<!-- s : 프로젝트 (추후 프로그램연동 필요) -->
					<div id="project-name">
						<span class="name"><?=$_COOKIE["ck_stName"]?></span>
						<button id="view-btn"><span class="blind">상세보기</span></button>
					</div>
					<!-- e : 프로젝트 (추후 프로그램연동 필요) -->
					<!-- s : 사용자정보 (추후 프로그램연동 필요) -->
					<div id="user-wrap">
						<div class="user-cont">
							<ul>
							   <li><span class="btxt"><?=$txtdt["1342"]?><!-- 최근접속시간 --></span><span class="stxt"><?=$_COOKIE["ck_stLogin"]?></span></li>
							   <!-- <li><span class="btxt">관리자 등급</span><span class="stxt nbl">:  최고관리자</span></li> -->
							</ul>
								<button class="logout-btn" onClick="removeSession()"><span>LOGOUT</span></button>
						</div>
					</div>
					<!-- e : 사용자정보 (추후 프로그램연동 필요) -->
					<div class="lm-wrap">
						<div class="lm-tit">
							<div class="tit">
								<span class="btxt">제목(데스크탑용)</span>
								<span class="stxt">소제목(모바일 용)<!-- (추후 프로그램연동 필요) --></span>
								<button  class="" type="button" onclick="$('#leftmenu').toggle();"><span>▼</span></button>
							</div>
						</div>
						<!-- s : 좌측메뉴 -->
						<?php  include_once ($root."/cmmInc/menuInc.php");?>
						<?php  include_once ('depthCtrl.php');?>
						<!-- e : 좌측메뉴 -->
					</div>
					<!-- e : 프로젝트 (추후 프로그램연동 필요) -->
					<script  type="text/javascript" src="<?=$root?>/cmmJs/leftMenu.js"></script>
					<script type="text/javascript" >
						$(document).ready(function(){
							subNavi._init();
							if($("#leftmenu li").length<1) $(".lm-tit button").hide();
						});
					</script>
				</div>
			</div>
			<div id="container"  class="div-cont">

				<div id="contents-wrap">
					<div id="contents">
						<div class="cont-top">
							<div class="cont-tit">
								<h2><?=$menutit[$file];?><!-- (추후 프로그램연동 필요) --></h2>
							    <!--<p>사이트관리화면입니다.</p>-->
							</div>
							<!-- <a href="#" class="homepage-btn" target="_blank" title="새창으로열림"><span>홈페이지 바로가기</span></a> -->
							<!-- s : cont-path -->
							<div class="cont-path">
								<dl>
									<dt>Home</dt>
									<dd><?=$catetit[$dir];?></dd>
									<dd><?=$menutit[$file];?></dd>
								</dl>
							</div>
							<!--// e : cont-path  -->
						</div>
