<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>

<!--// page start -->
<div id="listdiv" data-value="/Skin/Board/Policy"></div>

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
		console.log("hdata = "+hdata+", seq="+seq+", hdata[0]="+hdata[0]);
		if(isEmpty(seq))
		{
			$("#listdiv").load("<?=$root?>/Skin/Board/Policy.php");  //seq값이 없으면
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Board/PolicyWrite.php?seq="+seq);  //seq값이 있으면
		}
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
