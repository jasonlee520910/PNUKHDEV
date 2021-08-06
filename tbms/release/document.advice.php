<?php  //복약지도서
	$root="..";
	include_once $root."/_common.php";
	$code=$_GET["code"];
	$apiData="code=".$code;
?>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"><!--ie 최상위버전 -->
	<script  type="text/javascript" src="<?=$root?>/_Js/jquery-2.2.4.js"></script> <!-- 새로추가한 jquery -->
	<script  type="text/javascript" src="<?=$root?>/_Js/jquery.cookie_new.js"></script> <!-- 새로추가한 jquery -->
	<script  type="text/javascript" src="<?=$root?>/_Js/jquery.js"></script> <!-- 새로추가한 jquery -->
	<script  type="text/javascript" src="<?=$root?>/_Js/jquery-barcode.js"></script> <!-- 새로추가한 jquery -->
	<link rel="stylesheet" type="text/css" href="<?=$root?>/_Css/print_style.css">
	<style type="text/css">
			/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
			html{background:none; min-width:0; min-height:0;font-weight:bold;}
			.section_print{width: 21cm;min-height: 29.7cm;font-size: 20px;}
	</style>

	<textarea id="urldata" cols="100" rows="100" style="display:none;"><?=json_encode($NetURL)?></textarea>

		<body>
			<div>
				<div id="orderadviceDiv" class="section_print"></div>
			</div>
		</body>
	</html>

<script>
	function makepage(json)
	{		
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="orderadvice")//본초분류관리 상세
		{
			//console.log("data   >>>  "+obj["data"]);

			if(isEmpty(obj["data"]))
			{
				alert("해당주문은 복약지도서가 없습니다.");
				self.close();  
			}
			else
			{
				if(obj["data"].substring(0,4)=='http'){
					location.href=obj["data"];
				}else{
					$("#orderadviceDiv").html(obj["data"]);
					setTimeout('print();', 500);
				}
			}
		}
	}

		callapi('GET','release','orderadvice',"<?=$apiData?>");
</script>