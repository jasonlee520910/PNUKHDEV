<?php
	//header("Location:/Order/");
	$root="..";
	//include_once $root."/_Inc/head.php";
?>
<!-- <div id="listdiv"></div> -->

<script>
location.href="/Order/";
/*
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		$("#listdiv").load("<?=$root?>/Skin/Payment/PaymentList.php");//장바구니리스트 
	}
*/
</script>

<?//php
 //  include_once $root."/_Inc/tail.php"; ?>
