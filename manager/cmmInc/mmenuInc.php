<?php if($_SESSION["ss_depart"]=="sales"){?>
	<ul class="topmenu">
		<?php if($_SESSION["ss_auth"]=="sales"){?>
			<li id="Customer" class="mn_l1 mn_type"><a href="<?=$root?>/81_Customer/Customers.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1556"]?><!-- 고객정보 --></span></a>
				<div class="depth2-wrap">
					<span class="mn-btxt"><?=$txtdt["1556"]?><!-- 고객정보 --></span>
					<ul class='depth2'>
						<li id="" class="mn_l2 first"><a href="<?=$root?>/81_Customer/Customers.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1557"]?><!-- 일반고객 --></span></a></li>
						<!-- <li id="" class="mn_l2"><a href="<?=$root?>/81_Customer/Partners.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1183"]?>파트너</span></a></li> -->
					</ul>
				</div>
			</li>
		<?php }?>
		<?php if($_SESSION["ss_auth"]=="headquarters")$tlink="EstimateBasic";?>
		<?php if($_SESSION["ss_auth"]=="sales")$tlink="Estimate";?>
		
		<li id="Estimate" class="mn_l1 mn_type"><a href="<?=$root?>/82_Estimate/<?=$tlink?>.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1558"]?><!-- 견적 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1558"]?><!-- 견적 --></span>
				<ul class='depth2'>
					<?php if($_SESSION["ss_auth"]=="headquarters"){?>
						<li id="" class="mn_l2 first"><a href="<?=$root?>/82_Estimate/Estimate.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1559"]?><!-- 기본견적 --></span></a></li>
					<?php }?>
					<?php if($_SESSION["ss_auth"]=="sales"){?>
						<li id="" class="mn_l2"><a href="<?=$root?>/82_Estimate/Estimate.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1560"]?><!-- 세부견적 --></span></a></li>
					<?php }?>
				</ul>
			</div>
		</li>
		<li id="SetSale" class="mn_l1 mn_type"><a href="<?=$root?>/83_SetSale/SetPrice.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1561"]?><!-- 설정 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1561"]?><!-- 설정 --></span>
				<ul class='depth2'>
					<?php if($_SESSION["ss_auth"]=="headquarters"){?>
						<li id="" class="mn_l2 first"><a href="<?=$root?>/83_Setting/SetCategory.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1562"]?><!-- 분류설정 --></span></a></li>
					<?php }?>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/83_Setting/SetPrice.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1563"]?><!-- 가격설정 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/83_Setting/SetSales.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1564"]?><!-- 영업설정 --></span></a></li>
				</ul>
			</div>
		</li>
		<li>
			<style>
				.langdiv{padding:20px 10px 0 0;}
				.langdiv input{margin:0 5px 0 10px;}
			</style>
			<!-- <div class="langdiv">
				<input type="radio" id="langkor" name="langkor" <?php if($language=="kor")echo "checked";?> onclick="setlanguage('kor')" value="kor"/><label for="">한글</label>
				<input type="radio" id="langeng" name="langeng" <?php if($language=="eng")echo "checked";?> onclick="setlanguage('eng')" value="eng"/><label for="">Eng</label>
				<input type="radio" id="langchn" name="langchn" <?php if($language=="chn")echo "checked";?> onclick="setlanguage('chn')" value="chn"/><label for="">中文</label>
			</div> -->
		</li>
	</ul>
<?php }else if($_SESSION["ss_depart"]=="marketing"){?>
	<ul class="topmenu">
		<li id="Estimate" class="mn_l1 mn_type"><a href="<?=$root?>/61_Marketing/Tutorial.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1565"]?><!-- 마케팅 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1565"]?><!-- 마케팅 --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/61_Marketing/Tutorial.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1566"]?><!-- 튜토리얼관리 --></span></a></li>
				</ul>
			</div>
		</li>
	</ul>
<?php }else{?>
	<ul class="topmenu">
		<?php if($modifyAuth == "true"){?>
		<li id="DashBoard" class="mn_l1 mn_type"><a href="<?=$root?>/00_DashBoard/OrderDashBoard.php" class="mn_a1"><span class="mn_s1">DashBoard<?//=$txtdt["1306"]?><!-- DashBoard --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt">DashBoard<?//=$txtdt["1306"]?><!-- DashBoard --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/00_DashBoard/OrderDashBoard.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1280"]?><!-- 작업현황 --></span></a></li>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/00_DashBoard/Orders.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1783"]?><!-- 주문보고서 --></span></a></li>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/00_DashBoard/Makings.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1784"]?><!-- 조제보고서 --></span></a></li>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/00_DashBoard/Recipes.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1785"]?><!-- 처방보고서 --></span></a></li>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/00_DashBoard/Medicines.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1786"]?><!-- 약재보고서 --></span></a></li>
				</ul>
			</div>
		</li>
		<?php }?>
		<li id="Order" class="mn_l1 mn_type"><a href="<?=$root?>/01_Order/Order.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1306"]?><!-- 주문현황 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1306"]?><!-- 주문현황 --></span>
				<ul class='depth2'>

					<li id="" class="mn_l2"><a href="<?=$root?>/01_Order/Order.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1301"]?><!-- 주문리스트 --></span></a></li>
				</ul>
			</div>
		</li>
		<li id="Member" class="mn_l1 mn_type"><a href="<?=$root?>/02_Member/Member.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1147"]?><!-- 사용자관리 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1147"]?><!-- 사용자관리 --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/02_Member/Member.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1406"]?><!-- 한의원관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/02_Member/Staff.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1183"]?><!-- 스탭관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/02_Member/Maker.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1288"]?>관리<!-- 제조사관리 --></span></a></li>
				</ul>
			</div>
		</li>
		<li id="Medicine" class="mn_l1 mn_type"><a href="<?=$root?>/03_Medicine/MedicineSmu.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1200"]?><!-- 약재관리 --></span></a>
				<div class="depth2-wrap">
						<span class="mn-btxt"><?=$txtdt["1200"]?><!-- 약재관리 --></span>
						<ul class='depth2'>
								<li id="" class="mn_l2 first"><a href="<?=$root?>/03_Medicine/HubCategory.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1126"]?><!-- 본초분류관리 --></span></a></li>
								<li id="" class="mn_l2"><a href="<?=$root?>/03_Medicine/Hub.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1123"]?><!-- 본초관리 --></span></a></li>
								<li id="" class="mn_l2"><a href="<?=$root?>/03_Medicine/Medicine.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1205"]?>_<?=$txtdt["1725"]?><!-- 약재목록 --><!-- 디제이메디 --></span></a></li>
								<li id="" class="mn_l2"><a href="<?=$root?>/03_Medicine/MedicineSmu.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1205"]?><!-- 약재목록 --></span></a></li>
								<li id="" class="mn_l2"><a href="<?=$root?>/03_Medicine/DismatchWarning.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1159"]?><!-- 상극알람 --></span></a></li>
								<li id="" class="mn_l2"><a href="<?=$root?>/03_Medicine/PoisonWarning.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1066"]?><!-- 독성알람 --></span></a></li>
						</ul>
				</div>
		</li>
		<li id="Stock" class="mn_l1 mn_type"><a href="<?=$root?>/04_Stock/GeneralStock.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1281"]?><!-- 재고관리 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1281"]?><!-- 재고관리 --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/04_Stock/Stock.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1209"]?><!-- 약재재고목록 --></span></a></li>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/04_Stock/InStock.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1208"]?><!-- 약재입고 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/04_Stock/OutStock.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1212"]?><!-- 약재출고 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/04_Stock/GeneralStock.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1272"]?><!-- 자재입출고 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/04_Stock/StockRoute.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1787"]?><!-- 약재이력추적 --></span></a></li>	
				</ul>
			</div>
		</li>
		<li id="Recipebasic" class="mn_l1 mn_type"><a href="<?=$root?>/05_Recipebasic/Resource.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1322"]?><!-- 처방관리 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1322"]?><!-- 처방관리 --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/05_Recipebasic/Resource.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1324"]?><!-- 처방서적 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/05_Recipebasic/GeneralPrescription.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1322"]?><!-- 처방관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/05_Recipebasic/UniquePrescription.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1026"]?><!-- 고유처방 --></span></a></li>
				</ul>
			</div>
		</li>
		<li id="Inventory" class="mn_l1 mn_type"><a href="<?=$root?>/06_Inventory/MedicineBox.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1274"]?><!-- 자재코드관리 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?=$txtdt["1274"]?><!-- 자재코드관리 --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/06_Inventory/MedicineBox.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1217"]?><!-- 약재함관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/06_Inventory/PouchTag.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1295"]?><!-- 조제태그관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/06_Inventory/PotCode.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1363"]?><!-- 탕전기관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="/06_Inventory/MakingTable.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1599"]?><!-- 조제대관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="/06_Inventory/MakingTable.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1868"]?><!-- 마킹프린터관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/06_Inventory/PackagingCode.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1393"]?><!-- 포장재관리 --></span></a></li>
				</ul>
			</div>
		</li>
		<li id="Goods" class="mn_l1 mn_type"><a href="<?=$root?>/08_Goods/Goods.php" class="mn_a1"><span class="mn_s1"><?//=$txtdt["1274"]?>제품관리<!-- 제품관리 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?//=$txtdt["1274"]?>제품관리<!-- 제품관리 --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/08_Goods/GoodsG.php" class="mn_a2"><span class="blt"></span><span class="txt">사전조제</span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/08_Goods/Goods.php#|add|" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1274"]?>제품등록<!-- 제품관리 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/06_Inventory/Goods.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1295"]?>제품목록<!-- 제품목록 --></span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/06_Inventory/GoodsLog.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1295"]?>제품입출고목록</span></a></li>
				</ul>
			</div>
		</li>
		<li id="Content" class="mn_l1 mn_type"><a href="<?=$root?>/09_Content/Notice.php" class="mn_a1"><span class="mn_s1"><?//=$txtdt["1274"]?>콘텐츠관리<!-- 제품관리 --></span></a>
			<div class="depth2-wrap">
				<span class="mn-btxt"><?//=$txtdt["1274"]?>콘텐츠관리<!-- 제품관리 --></span>
				<ul class='depth2'>
					<li id="" class="mn_l2 first"><a href="<?=$root?>/09_Content/Notice.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1274"]?>공지사항</span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/09_Content/Faq.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1295"]?>FAQ</span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/09_Content/Qna.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1295"]?>1:1 문의</span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/09_Content/Popup.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1295"]?>팝업</span></a></li>
					<li id="" class="mn_l2"><a href="<?=$root?>/09_Content/Policy.php" class="mn_a2"><span class="blt"></span><span class="txt"><?//=$txtdt["1295"]?>개인정보처리방침</span></a></li>
				</ul>
			</div>
		</li>
		<?php if($modifyAuth == "true"){?>
			<li id="Setting" class="mn_l1 mn_type"><a href="<?=$root?>/07_Setting/CodeManager.php" class="mn_a1"><span class="mn_s1"><?=$txtdt["1413"]?><!-- 환경설정 --></span></a>
				<div class="depth2-wrap">
					<span class="mn-btxt"><?=$txtdt["1413"]?><!-- 환경설정 --></span>
					<ul class='depth2'>
						<li id="" class="mn_l2 first"><a href="<?=$root?>/07_Setting/CodeManager.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1357"]?><!-- 코드관리 --></span></a></li>
						<li id="" class="mn_l2"><a href="<?=$root?>/07_Setting/TextDB.php" class="mn_a2"><span class="blt"></span><span class="txt"><?=$txtdt["1223"]?><!-- 언어TextDB --></span></a></li>
						<li id="" class="mn_l2"><a href="<?=$root?>/07_Setting/Policy.php" class="mn_a2"><span class="blt"></span><span class="txt">개인정보처리방침</span></a></li>

						
					</ul>
				</div>
			</li>
		<?php }?>
		<li>
			<style>
				.langdiv{padding:20px 10px 0 0;}
				.langdiv input{margin:0 5px 0 10px;}
			</style>
			<!-- <div class="langdiv">
				<?php if($modifyAuth == "true"){?>
					<input type="radio" id="langkor" name="langkor" <?php if($language=="kor")echo "checked";?> onclick="setlanguage('kor')" value="kor"/><label for="">한글</label>
					<input type="radio" id="langeng" name="langeng" <?php if($language=="eng")echo "checked";?> onclick="setlanguage('eng')" value="eng"/><label for="">Eng</label>
					<input type="radio" id="langchn" name="langchn" <?php if($language=="chn")echo "checked";?> onclick="setlanguage('chn')" value="chn"/><label for="">中文</label>
				<?php }?>
			</div> -->
		</li>
	</ul>
<?php }?>
