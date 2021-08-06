<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		alert("처방하기로 갑니다.");
		$("#listdiv").load("<?=$root?>/Skin/Order/OrderList.php");
		
	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
