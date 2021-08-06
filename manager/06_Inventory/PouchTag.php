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
	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		//console.log("seq   :"+seq);
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Inventory/PouchTag.php");  //seq값이 없으면
		}
		//else
		//{
			//$("#listdiv").load("<?=$root?>/Skin/Inventory/PouchTag.php?seq="+seq);  //seq값이 있으면
		//}
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
