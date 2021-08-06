<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>
<!--// page start -->
<div id="listdiv" data-value="/Skin/Order/Order"></div>

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
		var odStatus=hdata[3];
		var odGoods=hdata[4];
		
		//console.log("order odStatus   :"+odStatus);
		//console.log("order seq   :"+seq);
		var ck_stDepart=getCookie("ck_stDepart");
		var ck_stUserid=getCookie("ck_stUserid");
		//console.log("DOO :: ck_stDepart = " + ck_stDepart+", odStatus = " + odStatus+", ck_stUserid = " + ck_stUserid);
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Order/OrderList.php");  //seq값이 없으면
		}
		else if(seq=="add" || seq=="addg")
		{
			var type="";
			if(seq=="addg"){type="&type=G"}else{type=""}
			$("#listdiv").load("<?=$root?>/Skin/Order/OrderWrite.php?seq="+seq+type);  //seq값이 add
		}
		//else if(seq=="addg")
		//{
		//	$("#listdiv").load("<?=$root?>/Skin/Order/OrderGWrite.php?seq="+seq);  //seq값이 add
		//}
		else if(seq && odStatus=="order" || seq && odStatus=="making_cancel_smu" || /*seq && odStatus=="paid" ||*/ seq && odStatus=="making_cancel" || seq && odStatus=="delivery_cancel")  //주문상태가 주문/접수 이거나 취소일때
		{
			if(!isEmpty(odGoods)&&odGoods=="G"){type="&type=G"}else{type=""}
			$("#listdiv").load("<?=$root?>/Skin/Order/OrderWrite.php?seq="+seq+type);
		}
		else 
		{	
			if(!isEmpty(odGoods)&&odGoods=="G")
			{
				$("#listdiv").load("<?=$root?>/Skin/Order/OrderWrite.php?seq="+seq+"&type=G");  
			}
			else
			{
				if(ck_stDepart=="pharmacist" && odStatus=="paid" || ck_stUserid.indexOf("djmedi") != -1 && odStatus=="paid")//20191104 : 권한이 약사이면서 상태값이 paid일때만 수정할수 있게 바꾼다 
				{
					$("#listdiv").load("<?=$root?>/Skin/Order/OrderWrite.php?seq="+seq); 
				}
				else
				{
					$("#listdiv").load("<?=$root?>/Skin/Order/OrderDetail.php?seq="+seq); 
				}
			}
		}
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>


