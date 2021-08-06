<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<title><?=$txtdt["logo"]?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta property="og:title" content="">
<meta property="og:image" content="">
<meta name="format-detection" content="telephone=no" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />


<script src="<?=$root?>/_Js/jquery-2.2.4.js"></script>
<script src="<?=$root?>/_Js/jquery.cookie_new.js"></script>
<script src="<?=$root?>/_Js/jquery-ui.1.12.1.min.js"></script>
<script src="<?=$root?>/_Js/jquery_201125.js"></script>
<script src="<?=$root?>/_Js/jquery-barcode.js"></script> <!-- 새로추가한 jquery -->

<link rel="stylesheet" type="text/css" href="<?=$root?>/_Css/print_style.css">
<link rel="stylesheet" media="all" href="<?=$root?>/_Css/font_print.css?version=<?=date("YmdHis")?>" /> 
</head>

<body>	
	<textarea id="comTxtdt" name="comTxtdt" cols="200" style="display:none;"><?=json_encode($ComTxtdt)?></textarea> <!--style="display:none;"-->
	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>
