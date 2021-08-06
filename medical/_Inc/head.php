<?php
	include_once ($root.'/_common.php');?>
<!doctype html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
 
    <title>부산대학교한방병원원외탕전실</title>
    <link rel="stylesheet" href="<?=$root?>/assets/plugins/slick/slick.css">
    <link rel="stylesheet" href="<?=$root?>/assets/plugins/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?=$root?>/assets/css/main_200709.css">
    <link rel="stylesheet" href="<?=$root?>/assets/plugins/jquery.dataTables.min.css">

	<script src="<?=$root?>/assets/plugins/jquery-2.2.4.js"></script>
	<script src="<?=$root?>/assets/plugins/jquery.cookie.js"></script>	
	<script src="<?=$root?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?=$root?>/assets/plugins/slick/slick.js"></script>
	<script src="<?=$root?>/assets/plugins/jquery.dataTables.min.js"></script>	
	<script src="<?=$root?>/assets/js/build.js"></script>
	<script src="<?=$root?>/assets/plugins/jquery.tablednd.js"></script>
	<script src="<?=$root?>/_Js/jquery.200826.js"></script>	
</head>
<body>
<style>
	.header .wrap{padding:0 10px;}
	.header__logo{width:23%;display:inline-block;}
	.header__nav{width:32%;display:inline-block;}
	.header__nav .nav{width:100%;margin:0;}
	.header__nav .nav a{width:33%;text-align:center;margin:0;display:inline-block;}
	.header__auth{width:45%;display:inline-block;}
	.header__auth .h-auth .h-auth__info{max-width:30%;}
	.header__auth .h-auth .h-auth__info span{display:inline-block;text-align:right;padding-right:3%;
		width:250px;max-width:250px;height:17px;overflow:hidden;line-height:150%;
	}
	.header__auth .h-auth a{text-align:center;display:inline-block;width:12%;margin:0;padding:0;}
	.header__auth .h-auth span{display:inline-block;}
	
</style>
<input type="hidden" name="medicalId" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">
<input type="hidden" name="medicalName" value="<?=$_COOKIE["ck_miName"]?>">
<input type="hidden" name="doctorId" class="ajaxdata" value="<?=$_COOKIE["ck_meUserId"]?>">
<input type="hidden" name="doctorName" value="<?=$_COOKIE["ck_meName"]?>">
<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>

<div class="wrapper">
    <header class="header">
        <div class="wrap d-flex">
            <div class="header__logo">
                <h1 class="logo">
                    <a href="/">
                        <img src="<?=$root?>/assets/images/icon/logo_pnuh.png" alt="">
                    </a>
                </h1>
            </div>
            <nav class="header__nav">
                <div class="nav d-flex">
						<?php if($_COOKIE["ck_meStatus"]=="confirm" && $_COOKIE["ck_miStatus"]=="confirm"){?>
						<a href="<?=$root?>/Patient/" class="nav__link">환자관리</a>
						<a href="<?=$root?>/Order/Potion.php" class="nav__link">처방하기</a>
						<a href="<?=$root?>/Dictionary/Formulary.php" class="nav__link">처방사전</a>
					<?php }?>
                </div>
            </nav>
			<div class="header__auth">
                <div class="h-auth d-flex" >
					
					<?php if($_COOKIE["ck_meStatus"]=="confirm" && $_COOKIE["ck_miStatus"]=="confirm"){?>
						<div class="h-auth__info d-flex" >
							<span><?=$_COOKIE["ck_miName"]?></span>				
							<span><?=$_COOKIE["ck_meName"]?></span>							
						</div>
						<span class="bar">|</span>
						<a href="javascript:;" class="h-auth__link" onclick="removeSession();">로그아웃</a>
						<span class="bar">|</span>
						<a href="<?=$root?>/Member/Info.php" class="h-auth__link">회원정보</a>
					<?php }else if($_COOKIE["ck_meName"]){?>
						<div class="h-auth__info d-flex" style="margin-left:200px;">
							<span><?=$_COOKIE["ck_miName"]?></span>				
							<span><?=$_COOKIE["ck_meName"]?></span>							
						</div>
						<span class="bar">|</span>
						<a href="javascript:;" class="h-auth__link" onclick="removeSession();">로그아웃</a>
						<span class="bar">|</span>
						<a href="<?=$root?>/Member/Info.php" class="h-auth__link">회원정보</a>
					<?php }else{?>
						<div class="h-auth__info d-flex">
							<span></span>							
						</div>
						<a href="javascript:;" class="h-auth__link"  style="margin-left:200px;" onclick="showModal('modal-login');">로그인</a>
	                    <span class="bar">|</span>
	                    <a href="<?=$root?>/Signup/Join.php" class="h-auth__link">회원가입</a>
					<?php }?>
                  
					<?php if($_COOKIE["ck_meStatus"]=="confirm" && $_COOKIE["ck_miStatus"]=="confirm"){?>
						<span class="bar">|</span>
						<a href="<?=$root?>/Order/" class="h-auth__link">주문내역</a>
						<span class="bar">|</span>
						<a href="<?=$root?>/Cart/" class="h-auth__link">장바구니</a>
						<span class="bar">|</span>
						<a href="<?=$root?>/CS/Notice.php" class="h-auth__link">고객센터</a>
					<?php }else{?>
					<?php }?>

                </div>
			</div>
        </div>
    </header>
