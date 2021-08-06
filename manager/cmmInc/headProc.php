<?php  include_once ($root.'/_common.php');?>
<!doctype html>
<html lang="ko" >
<head>
    <meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1.0, minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi"> -->
	<title><?=$txtdt["1750"]?><!-- 부산대학교한방병원원외탕전실 --></title>

	<!-- script 공통-->
	<script  type="text/javascript" src="<?=$root?>/cmmJs/defalut.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery-2.2.4.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery-ui.1.12.1.min.js"></script><!-- 새로추가한 jquery -->
<!-- 	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.cookie.js"></script>새로추가한 jquery -->
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.cookie_new.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.easing.1.3.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.tab.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/circles.min.js"></script>
	<script  type="text/javascript" src="<?=$root?>/_module/ckeditor/ckeditor.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/common.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/topmenu.js"></script>
	<script  type="text/javascript" src="<?=$root?>/_Js/jquery_20200812.js"></script> <!-- 새로추가한 jquery -->
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.tablednd.js?t=<?php echo time();?>"></script><!-- 새로추가한 jquery -->
	<script  type="text/javascript" src="<?=$root?>/_Js/jquery_order_201125.js"></script> <!-- 새로추가한 jquery -->


	<!-- 20190410 Chart css & js 추가  -->
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/Chart.min.js"></script>
	<link rel="stylesheet" media="all" href="<?=$root?>/cmmJs/jquery/Chart.min.css" />

	<!--- plugin 공통 CSS-->
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />
	<link rel="stylesheet" media="all" href="<?=$root?>/cmmJs/jquery/jquery-ui.1.12.1.min.css" /><!-- 새로추가한 css -->
	<link rel="stylesheet" media="all" href="<?=$root?>/_Css/font.css" /> 
	<!-- <link rel="stylesheet" media="all" href="<?=$root?>/cmmCss/webfont.css" /> -->
	<link rel="stylesheet" media="all" href="<?=$root?>/cmmCss/common.css" />
	<link rel="stylesheet" media="all" href="<?=$root?>/cmmCss/styleDefault.css" />
	<link rel="stylesheet" media="all" href="<?=$root?>/cmmCss/board.css" />
	<link rel="stylesheet" media="all" href="<?=$root?>/cmmCss/board-rspvn.css" />

	<!-- 사이트구분별 기본 css -->
	<link rel="stylesheet" media="all" href="<?=$root?>/_Css/layout.css" />
	<link rel="stylesheet" media="all" href="<?=$root?>/_Css/main.css" />
	<link rel="stylesheet" media="all" href="<?=$root?>/_Css/content_190906.css" />
	<link rel="stylesheet" media="all" href="<?=$root?>/_Css/style.css" />

	<!-- 페이지구분별 script -->
</head>

<!-- 일단은 우리쪽에서만 오른쪽 방지를 풀자 -->
<?php if($_SERVER["REMOTE_ADDR"]=='59.7.50.122'){?>
<body id="page-code"> 
<?php }else{?>
<body id="page-code" oncontextmenu='return blockRightClick()' onselectstart='return false' ondragstart='return false'> <!-- ///우측클릭 방지 소스 -->
<?php }?>
    <div id="ss_ip" value="<?=$ip?>"></div>
    <div id="ck_staffid" value="<?=$_COOKIE["ck_stStaffid"]?>"></div>
<!--[if lt IE 9]>
	<div id="uppopup" class="lowIE-update">
		<div class="update-cont">
			<p class="tit">본 사이트는<strong>Internet Explorer 9버전 이상</strong>에 최적화 되어 <br />있습니다.</p>
			<p class="txt">Explorer를 최신 버전으로 업데이트 하시거나, Chrome, Fire fox 등의 브라우저를 이용해 주시기 바랍니다.</p>
			<a href="http://windows.microsoft.com/ko-kr/internet-explorer/download-ie" target="_blank" title="새창열림" class="btn-upgrade"><span class="ico"></span><span class="atxt">Internet Explorer 업그레이드</span></a>
			<span class="chk-uclose"><input type="checkbox" name="chk-uclose" id="chkuppopup" /><label for="chkuppopup">하루동안 열지 않기</label></span>
			<button type="button" onclick="javascript:popHide('uppopup')" class="btn-uclose"><span class="blind">현재창 닫기</span></button>
		</div>
		<span class="bg"></span>
	</div>
	<script type="text/javascript">checkPop('uppopup');</script>
<![endif]-->

