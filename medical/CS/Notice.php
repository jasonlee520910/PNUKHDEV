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
		var hdata=location.hash.replace("#","").split("|");
		$("#listdiv").load("<?=$root?>/Skin/CS/NoticeList.php",function(){
			getlist();
		});//공지사항
	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
