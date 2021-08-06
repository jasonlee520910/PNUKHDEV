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
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/CS/InquiryList.php",function(){
				getlist();
			});//1:1문의리스트 
		}
		/*
		else if(seq=="add")
		{
			
			$("#listdiv").load("<?=$root?>/Skin/CS/InquiryWrite.php");//탕전처방 
		}
		/*
		else if(seq)
		{
			
			$("#listdiv").load("<?=$root?>/Skin/CS/InquiryWrite.php?"+"&seq="+seq);//탕전처방 
		}
		*/
	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
