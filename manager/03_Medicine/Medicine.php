<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>

<!--// page start -->
<div id="listdiv"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
		viewpage();  //첫페이지

	function viewpage()
	{
		//$("#listdiv").fadeOut(300);
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Medicine/MedicineList.php");  //seq값이 없으면
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Medicine/MedicineWrite.php?seq="+seq);  //seq값이 있으면
		}
		//setTimeout("$('#listdiv').fadeIn(300)",300);
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
