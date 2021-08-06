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
	<script src="<?=$root?>/_Js/jquery.200826.js"></script>
</head>
<body>
<style>
	.header__logo{margin-right:50px;}
	.header__nav,
	.header__nav .nav{height:100%;}
	.nav__link{font-size:17px;width:auto;padding:2px  20px;color:#000;height:100%;line-height:60px;font-weight:600;text-align:center;}
</style>
<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>