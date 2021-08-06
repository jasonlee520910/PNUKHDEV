
<header class="div-wrap header-wrap-abs">
    <!-- s : header-wrap -->
	<div id="header-wrap" class="div-wrap header-wrap">
		<span class="mn-bar"></span>
		<div id="header" class="div-cont header">
			<ul id="gnb-wrap" value="<?=$_COOKIE["ck_language"];?>"></ul>
				
			<div id="logo" style="width:350px;">
				<a href="/"><img src="../_Img/logo_pnuh.png" alt="" style="height:28px;"/>
				<div id="" style="float:left;width:270px;">
					<!-- <span style="font-weight:bold;font-size:19px;display:block;padding-bottom:7px;color:#111;"><?=$txtdt["1750"]?>세명대 한방병원</span> -->
					<span style="font-weight:bold;font-size:14px;padding-left:60px;">관리자사이트</span>
				</div>
				</a>
			</div>
		</div>
		<button class="bt-mnall" id="mn-ctrs-btns"><span class="blind">전체메뉴</span></button>
		<div id="mainNavi-wrap" >
			<h2 class="blind"><!--사이트이름 --> 주메뉴</h2>
			<div id="mainNavi">
				<div class="tmn-tit">
					<strong>ALL MENU</strong>
					<button class="bt-mnclose"><span class="blind">전체메뉴</span></button>
				</div>
				<?php  include_once ($root."/cmmInc/mmenuInc.php");?>
				<!-- <script type='text/javascript'>initNavigation(0,0)</script> -->
			</div>
		</div>
		<div class="mn-bg"></div>
		<!-- 190522 주석처리함 -->
		<!-- <div id="option-wrap">
			<button class="" id="option-btn"><span class="blind">설정변경하기</span></button>
			<ul class="option-list">
				<li><a href="#"><span>업체정보</span></a></li>
				<li><a href="#"><span>정보수정</span></a></li>
				<li><a href="#"><span>사용자관리</span></a></li>
				<li><a href="#"><span>게시판추가</span></a></li>
				<li><a href="#"><span>게시판관리</span></a></li>
				<li><a href="#"><span>정보보기</span></a></li>
			</ul>
		</div> -->
	</div>
	<!-- e : header-wrap -->
</header>
	<div style="display:none">
		<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
	</div>