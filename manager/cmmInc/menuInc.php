<?php if($_SESSION["ss_depart"]=="sales"){?>
	<div class="leftmenu" id="leftmenu">
		<ul class='depth2'>
			<?php if($_SESSION["ss_auth"]=="sales"){?>
				<li id="Customers" class='lm_l2'>
					<a href='<?=$root?>/81_Customer/Customers.php' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1556"]?><!-- 고객정보 --></span></a>
					<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/81_Customer/Customers.php' class='lm_a3 <?php if($file=="Customers")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1557"]?><!-- 일반고객 --></span></a></li>
					</ul>
				</li>
			<?php }?>
			<?php if($_SESSION["ss_auth"]=="headquarters"||$_SESSION["ss_auth"]=="sales"){?>
			<li id="Estimates" class='lm_l2'>
				<a href='<?=$root?>/82_Estimate/EstimateBasic.php' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1558"]?><!-- 견적 --></span></a>
				<ul class='depth3'>
				<?php if($_SESSION["ss_auth"]=="headquarters"){?>
					<li class='lm_l3'><a href='<?=$root?>/82_Estimate/EstimateBasic.php' class='lm_a3 <?php if($file=="EstimateBasic")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1559"]?><!-- 기본견적 --></span></a></li>
				<?php }?>
				<?php if($_SESSION["ss_auth"]=="sales"){?>
					<li class='lm_l3'><a href='<?=$root?>/82_Estimate/Estimate.php' class='lm_a3 <?php if($file=="Estimate")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1560"]?><!-- 세부견적 --></span></a></li>
				<?php }?>
				</ul>
			</li>
			<?php }?>
				<li id="SetSales" class='lm_l2'>
					<a href='<?=$root?>/83_SetSale/SetPrice.php' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1561"]?><!-- 설정 --></span></a>
					<ul class='depth3'>
						<?php if($_SESSION["ss_auth"]=="headquarters"){?>
							<li class='lm_l3'><a href='<?=$root?>/83_SetSale/SetCategory.php' class='lm_a3 <?php if($file=="SetCategory")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1562"]?><!-- 분류설정 --></span></a></li>
						<?php }?>
						<li class='lm_l3'><a href='<?=$root?>/83_SetSale/SetPrice.php' class='lm_a3 <?php if($file=="SetPrice")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1563"]?><!-- 가격설정 --></span></a></li>
						<?php if($_SESSION["ss_auth"]!="sales"){?>
							<li class='lm_l3'><a href='<?=$root?>/83_SetSale/SetSales.php' class='lm_a3 <?php if($file=="SetSales")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1564"]?><!-- 영업설정 --></span></a></li>
						<?php }?>
					</ul>
				</li>
		</ul>
	</div>
<?php }else if($_SESSION["ss_depart"]=="marketing"){?>
	<div class="leftmenu" id="leftmenu">
		<ul class='depth2'>
			<?//if($_SESSION["ss_auth"]=="tutadmin"){?>
				<li id="Marketing" class='lm_l2'>
					<a href='<?=$root?>/61_Marketing/Tutorials.php' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1565"]?><!-- 마케팅 --></span></a>
					<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/61_Marketing/Tutorials.php' class='lm_a3 <?php if($file=="Tutorials")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1566"]?><!-- 튜토리얼관리 --></span></a></li>
					</ul>
				</li>
			<?//}?>
		</ul>
	</div>
<?php }else{?>
	<div class="leftmenu" id="leftmenu">
		<ul class='depth2'>
			<li id="DashBoards" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'>DashBoard<?//=$txtdt["1306"]?></span></a>
				<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/00_DashBoard/OrderDashBoard.php' class='lm_a3 <?php if($file=="OrderDashBoard")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1280"]?><!-- 작업현황 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/00_DashBoard/Orders.php' class='lm_a3 <?php if($file=="Orders")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1783"]?><!-- 주문보고서 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/00_DashBoard/Makings.php' class='lm_a3 <?php if($file=="Makings")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1784"]?><!-- 조제보고서 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/00_DashBoard/Recipes.php' class='lm_a3 <?php if($file=="Recipes")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1785"]?><!-- 처방보고서 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/00_DashBoard/Medicines.php' class='lm_a3 <?php if($file=="Medicines")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1786"]?><!-- 약재보고서 --></span></a></li>
				</ul>
			</li>
			<li id="Orders" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1306"]?></span></a>
				<ul class='depth3'>

						<li class='lm_l3'><a href='<?=$root?>/01_Order/Order.php' class='lm_a3 <?php if($file=="Order")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1301"]?><!-- 주문리스트 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/01_Order/Delivery.php' class='lm_a3 <?php if($file=="Delivery")echo "on";?>'><span class='isMask'></span><span class='isTxt'>배송리스트<?//=$txtdt["1915"]?><!--배송리스트--></span></a></li>
				</ul>
			</li>
			<li id="Members" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1147"]?><!-- 사용자관리 --></span></a>
				<ul class='depth3'>
					<li class='lm_l3'><a href='<?=$root?>/02_Member/Member.php' class='lm_a3 <?php if($file=="Member"||$file=="MemberList"||$file=="MemberWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1406"]?><!-- 한의원관리 --></span></a>
					</li>
					<li class='lm_l3'><a href='<?=$root?>/02_Member/Doctor.php' class='lm_a3 <?php if($file=="Doctor"||$file=="DoctorList"||$file=="DoctorWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'>한의사관리</span></a>
					</li>
					<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>  <!-- admin도 보이게 처리함 -->
						<li class='lm_l3'>
							<a href='<?=$root?>/02_Member/Staff.php' class='lm_a3 <?php if($file=="Staff"||$file=="StaffList"||$file=="StaffWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1183"]?><!-- 스탭관리 --></span>
							</a>
						</li>
					<?php }?>
				</ul>
			</li>
			<li id="Medicines" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1200"]?><!-- 약재관리 --></span></a>
				<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/03_Medicine/HubCategory.php' class='lm_a3 <?php if($file=="HubCategory")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1126"]?><!-- 본초분류관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/03_Medicine/Hub.php' class='lm_a3 <?php if($file=="Hub")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1123"]?><!-- 본초관리 --></span></a></li>
							<?php if($modifyAuth == "true"){?>
								<li class='lm_l3'>
									<a href='<?=$root?>/03_Medicine/Medicine.php' class='lm_a3 <?php if($file=="Medicine")echo "on";?>'>
										<span class='isMask'></span><span class='isTxt'><?=$txtdt["1205"]?>_<?=$txtdt["1725"]?><!-- 약재목록 --><!-- 디제이메디 --></span>
									</a>
								</li>
							<?php }?>
						<li class='lm_l3'><a href='<?=$root?>/03_Medicine/MedicineSmu.php' class='lm_a3 <?php if($file=="MedicineSmu")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1205"]?><!-- 약재목록--></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/03_Medicine/Maker.php' class='lm_a3 <?php if($file=="Maker")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1288"]?>관리<!-- 1288 --></span></a>
						</li>
						<li class='lm_l3'><a href='<?=$root?>/03_Medicine/DismatchWarning.php' class='lm_a3 <?php if($file=="DismatchWarning")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1159"]?><!-- 상극알람 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/03_Medicine/PoisonWarning.php' class='lm_a3 <?php if($file=="PoisonWarning")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1066"]?><!-- 독성알람 --></span></a></li>

				</ul>
			</li>
			<li id="Stocks" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1281"]?><!-- 재고관리 --></span></a>
				<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/04_Stock/Stock.php' class='lm_a3 <?php if($file=="Stock")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1209"]?><!-- 약재재고목록 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/04_Stock/InStock.php' class='lm_a3 <?php if($file=="InStockList"||$file=="InStock")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1208"]?><!-- 약재입고 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/04_Stock/OutStock.php' class='lm_a3 <?php if($file=="OutStockList"||$file=="OutStock")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1212"]?><!-- 약재출고 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/04_Stock/GeneralStock.php' class='lm_a3 <?php if($file=="GeneralStockList"||$file=="GeneralStock")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1272"]?><!-- 자재입출고 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/04_Stock/StockRoute.php' class='lm_a3 <?php if($file=="StockRoute")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1787"]?><!-- 약재이력추적 --></span></a></li>

				</ul>
			</li>
			<li id="Recipebasics" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1322"]?><!-- 처방관리 --></span></a>
				<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/05_Recipebasic/Resource.php' class='lm_a3 <?php if($file=="Resource")echo "on";?>'>
						<span class='isMask'></span><span class='isTxt'><?=$txtdt["1324"]?><!-- 처방서적 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/05_Recipebasic/Recommend.php' class='lm_a3 <?php if($file=="Recommend"||$file=="RecommendWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'>추천처방</span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/05_Recipebasic/MyRecipe.php' class='lm_a3 <?php if($file=="MyRecipe"||$file=="MyRecipeWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'>나의처방</span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/05_Recipebasic/GeneralPrescription.php' class='lm_a3 <?php if($file=="GeneralPrescription"||$file=="GeneralPrescriptionWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'>이전처방</span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/05_Recipebasic/Commercial.php' class='lm_a3 <?php if($file=="Commercial"||$file=="CommercialWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1925"]?><!-- 상용처방 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/05_Recipebasic/recipeGoods.php' class='lm_a3 <?php if($file=="recipeGoods"||$file=="recipeGoodsWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1924"]?><!-- 약속처방 --></span></a></li>

				</ul>
			</li>
			<li id="Inventorys" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1274"]?><!-- 자재코드관리 --></span></a>
				<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/MedicineBox.php' class='lm_a3 <?php if($file=="MedicineBox")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1217"]?><!-- 약재함관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/PouchTag.php' class='lm_a3 <?php if($file=="PouchTag")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1295"]?><!-- 조제태그관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/PotCode.php' class='lm_a3 <?php if($file=="PotCode")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1363"]?><!-- 탕전기관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/Packing.php' class='lm_a3 <?php if($file=="Packing")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1918"]?><!-- 포장기관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/MakingTable.php' class='lm_a3 <?php if($file=="MakingTable")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1599"]?><!-- 조제대관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/MarkingPrinter.php' class='lm_a3 <?php if($file=="MarkingPrinter")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1868"]?><!-- 마킹프린터관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/PackagingCode.php' class='lm_a3 <?php if($file=="PackagingCode"||$file=="PackagingWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1393"]?><!-- 포장재관리 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/06_Inventory/Equipment.php' class='lm_a3 <?php if($file=="Equipment")echo "on";?>'><span class='isMask'></span><span class='isTxt'>장비관리</span></a></li>
				</ul>
			</li>
			<li id="Goodss" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?//=$txtdt["1274"]?>제품관리<!-- 제품관리 --></span></a>
				<ul class='depth3'>
						<li class='lm_l3'><a href='<?=$root?>/08_Goods/GoodsG.php' class='lm_a3 <?php if($file=="GoodsG")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?//=$txtdt["1295"]?>사전조제</span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/08_Goods/Goods.php' class='lm_a3 <?php if($file=="Goods")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?//=$txtdt["1295"]?>제품목록<!-- 제품목록 --></span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/08_Goods/GoodsMedicine.php' class='lm_a3 <?php if($file=="GoodsMedicine")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?//=$txtdt["1295"]?>제품원재료관리</span></a></li>
						<li class='lm_l3'><a href='<?=$root?>/08_Goods/GoodsLog.php' class='lm_a3 <?php if($file=="GoodsLog")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?//=$txtdt["1295"]?>제품입출고목록</span></a></li>
				</ul>
			</li>
				
			<li id="Contents" class='lm_l2'>
				<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'>콘텐츠관리<?//=$txtdt["1950"]?><!-- 콘텐츠관리 --></span></a>
				<ul class='depth3'>
					<li class='lm_l3'><a href='<?=$root?>/09_Content/Notice.php' class='lm_a3 <?php if($file=="Notice")echo "on";?>'><span class='isMask'></span><span class='isTxt'>공지사항<?//=$txtdt["1357"]?><!-- 코드관리 --></span></a></li>
					<li class='lm_l3'><a href='<?=$root?>/09_Content/Faq.php' class='lm_a3 <?php if($file=="Faq")echo "on";?>'><span class='isMask'></span><span class='isTxt'>FAQ<?//=$txtdt["1223"]?><!-- 언어TextDB --></span></a></li>
					<li class='lm_l3'><a href='<?=$root?>/09_Content/Qna.php' class='lm_a3 <?php if($file=="Qna")echo "on";?>'><span class='isMask'></span><span class='isTxt'>1:1 문의<?//=$txtdt["1840"]?><!-- 기본설정 --></span></a></li>
					<li class='lm_l3'><a href='<?=$root?>/09_Content/Popup.php' class='lm_a3 <?php if($file=="Popup")echo "on";?>'><span class='isMask'></span><span class='isTxt'>팝업<?//=$txtdt["1840"]?><!-- 기본설정 --></span></a></li>
					<li class='lm_l3'><a href='<?=$root?>/09_Content/Policy.php' class='lm_a3 <?php if($file=="Policy"||$file=="PolicyWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'>개인정보처리방침</span></a></li>
				</ul>
			</li>
				
				<?php if($modifyAuth == "true"){?>
					<li id="Settings" class='lm_l2'>
						<a href='' class='lm_a2'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1413"]?><!-- 환경설정 --></span></a>
						<ul class='depth3'>
							<li class='lm_l3'><a href='<?=$root?>/07_Setting/CodeManager.php' class='lm_a3 <?php if($file=="CodeManager"||$file=="CodeWrite")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1357"]?><!-- 코드관리 --></span></a></li>
							<li class='lm_l3'><a href='<?=$root?>/07_Setting/TextDB.php' class='lm_a3 <?php if($file=="TextDB")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1223"]?><!-- 언어TextDB --></span></a></li>
							<li class='lm_l3'><a href='<?=$root?>/07_Setting/Config.php' class='lm_a3 <?php if($file=="Config")echo "on";?>'><span class='isMask'></span><span class='isTxt'><?=$txtdt["1840"]?><!-- 기본설정 --></span></a></li>
						</ul>
					</li>
				<?php }?>
			<!-- <li id="Stats" class='lm_l2'>
				<a href='#' class='lm_a2'><span class='isMask'></span><span class='isTxt'>통계관리</span></a>
				<ul class='depth3'>
					<li class='lm_l3 over'><a href='#' class='lm_a3'><span class='isMask'></span><span class='isTxt'>시간대별</span></a></li>
					<li class='lm_l3'><a href='#' class='lm_a3'><span class='isMask'></span><span class='isTxt'>일별</span></a></li>
					<li class='lm_l3'><a href='#' class='lm_a3'><span class='isMask'></span><span class='isTxt'>월별</span></a></li>
					<li class='lm_l3'><a href='#' class='lm_a3'><span class='isMask'></span><span class='isTxt'>방문경로</span></a></li>
					<li class='lm_l3'><a href='#' class='lm_a3'><span class='isMask'></span><span class='isTxt'>시스템분석</span></a></li>
				</ul>
			</li> -->
		</ul>
	</div>
<?php }?>
