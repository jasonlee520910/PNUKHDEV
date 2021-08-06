<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>

<!--// page start -->
<div id="listdiv" data-value="/Skin/Inventory/PackagingCode"></div>

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
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Inventory/PackagingCode.php");  //seq값이 없으면
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Inventory/PackagingWrite.php?seq="+seq);  //seq값이 있으면
		}
	}

/*
	window.onhashchange = function(e) {	
		$("#listdiv").load("<?=$root?>/Skin/Inventory/PackagingCode.php");  //해시값이 바뀌면
	}

	//첫페이지
	$("#listdiv").load("<?=$root?>/Skin/Inventory/PackagingCode.php");

	//검색을 하면 1페이지로 간다
	function searchhash(search){
		location.hash="1|"+search;
	}
*/
</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
