<?php 
$root = "..";
include_once ($root.'/cmmInc/subHead.php');
?>

<!--// page start -->
<div id="listdiv"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage(); 
		//repageload();
	}
	
	viewpage();  //첫페이지
/*
	function viewpage()
	{
		var page=1;
		var hdata=location.hash.replace("#","").split("|");
		if(hdata[1]!="" && hdata[1] != undefined)page=hdata[1];
		$("#listdiv").load("<?=$root?>/Skin/Goods/GoodsMedicine.php?page="+page);  //seq값이 없으면
	}

*/
	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Goods/GoodsMedicine.php");  //seq값이 없으면
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Goods/GoodsWrite.php?seq="+seq);  //seq값이 있으면
		}
		
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
