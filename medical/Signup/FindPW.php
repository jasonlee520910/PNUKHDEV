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
		var seq=hdata[1];
		console.log("seq="+seq);
		//아래는 잠시 ..나중에 다시 맞춰야함 
		if(seq=="email")
		{
			$("#listdiv").load("<?=$root?>/Skin/Signup/FindEmail.php");//비밀번호찾기 
		}
		else
		{			
			$("#listdiv").load("<?=$root?>/Skin/Signup/FindPwid.php");//비밀번호찾기 
		}
	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
