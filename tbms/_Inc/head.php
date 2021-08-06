<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<title><?=$txtdt["logo"]?></title>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta name="format-detection" content="telephone=no" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->

<script src="<?=$root?>/_Js/jquery-2.2.4.js"></script>
<script src="<?=$root?>/_Js/jquery.cookie_new.js"></script>
<script src="<?=$root?>/_Js/jquery-ui.1.12.1.min.js"></script>
<script src="<?=$root?>/_Js/jquery_21031301.js"></script>

<link rel="stylesheet" media="all" href="<?=$root?>/_Css/font.css" /> 
<link rel="stylesheet" type="text/css" href="<?=$root?>/_Css/style_191121.css">
<link rel="stylesheet" type="text/css" href="<?=$root?>/_Css/jquery-ui.1.12.1.min.css">
</head>

<body>	
	<textarea id="comTxtdt" name="comTxtdt" cols="200" style="display:none;"><?=json_encode($ComTxtdt)?></textarea> <!--style="display:none;"-->
	<div id="wrap" class="bg">
		<ul id="gnb-wrap" value="<?=$_COOKIE["ck_language"];?>"></ul>
			
