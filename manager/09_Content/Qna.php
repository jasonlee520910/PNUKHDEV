<?php 
$root = "..";
include_once ($root.'/cmmInc/subHead.php');
?>

<!--// page start -->
<div id="listdiv"></div>
<input type="hidden" name="bb_type" class="reqdata" value="QNA">
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
		console.log("seq   :"+seq);
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Board/Board.php?bb_type=QNA");  //seq값이 없으면
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Board/BoardWrite.php?seq="+seq+"&bb_type=QNA");  //seq값이 있으면
		}
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
