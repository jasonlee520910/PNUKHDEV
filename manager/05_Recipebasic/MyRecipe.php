<?php 
//나의처방
$root = "..";
include_once ($root.'/cmmInc/subHead.php');
?>

<!--// page start -->
<div id="listdiv" data-value="/Skin/Recipebasic/MyRecipeList"></div>

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
			$("#listdiv").load("<?=$root?>/Skin/Recipebasic/MyRecipeList.php"); 
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Recipebasic/MyRecipeWrite.php?seq="+seq);
		}
	}
</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>

