<?php  include_once ($root.'/_common.php');?>
<!doctype html>
<html lang="ko" >
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.cookie_new.js"></script>
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery-2.2.4.js"></script>
	<script  type="text/javascript" src="<?=$root?>/_Js/jquery_20200812.js"></script> <!-- 새로추가한 jquery -->
	<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery-barcode.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.qrcode.js"></script> <!-- 새로추가한 jquery -->
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/qrcode.js"></script> <!-- 새로추가한 jquery -->
	<link rel="stylesheet" type="text/css" href="<?=$root?>/_Css/print/style.css">
</head>
<body id="page-code">
	<div style="display:none">
		<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
	</div>