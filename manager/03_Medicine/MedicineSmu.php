<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>

<!--// page start -->
<div id="listdiv"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		//viewpage(); 
		console.log("window.onhashchange ");
		repageload();

	}
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Medicine/MedicineSmu.php");  
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Medicine/MedicineSmu.php?seq="+seq);  
		}
	}
/*
	window.onhashchange = function(e) {		
		$("#listdiv").load("<?=$root?>/Skin/Medicine/MedicineSmu.php");  //해시값이 바뀌면
	}

	//첫페이지
	$("#listdiv").load("<?=$root?>/Skin/Medicine/MedicineSmu.php");

	//검색을 하면 1페이지로 간다
	function searchhash(search){
		location.hash="1|"+search;
	}
*/
</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
