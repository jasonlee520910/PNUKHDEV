<?php
	$root="../..";
	$folder="/medical"; ///TMPS
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR.";

	///GET, DELETE
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
		case "orderlist":///주문리스트 
			include_once $root.$folder."/order/orderlist.php";
			break;
		case "orderproclist":///진행중인 주문리스트 
			include_once $root.$folder."/order/orderproclist.php";
			break;			
		case "orderdesc":///주문상세  
			include_once $root.$folder."/order/orderdesc.php";
			break;
		case "chartdelete":///주문삭제   
			include_once $root.$folder."/order/chartdelete.php";
			break;
		case "ordercancel":///주문취소 
			include_once $root.$folder."/order/ordercancel.php";
			break;
		case "ordercartlist"://장바구니 
			include_once $root.$folder."/order/ordercartlist.php";
			break;
		case "orderdescnext":
			include_once $root.$folder."/order/orderdescnext.php";
			break;
		case "orderpaychk":  //결제취소시 카드결제인지 무통장인지 확인
			include_once $root.$folder."/order/orderpaychk.php";
			break;
		case "orderchk":  //결제가 된 카드인지 확인
			include_once $root.$folder."/order/orderchk.php";
			break;

			
		}
	}
	///POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
		case "chartupdate":///처방하기 
			include_once $root.$folder."/order/chartupdate.php";
			break;
		case "orderupdate":///결재하기 
			include_once $root.$folder."/order/orderupdate.php";
			break;
		case "orderpayment":///결재하기 
			include_once $root.$folder."/order/orderpayment.php";
			break;
		case "cartupdate":///장바구니 저장
			include_once $root.$folder."/order/cartupdate.php";
			break;
		case "payafterupdate":///결제하고 난 다음 update
			include_once $root.$folder."/order/payafterupdate.php";
			break;	

			
		}
	}

	if($_POST["data"])
	{
		$jdata=json_decode($_POST["data"],true);
		$jdir=$_POST["dir"];
		$apicode=$jdata["apiCode"];	
		$json["resultMessage"]="MEDICAL API(apiCode) 333 ERROR.".$jdata;

		switch($apicode)
		{
		case "orderregist"://MEDICAL 주문등록 
			include_once $root.$folder."/order/orderregist.php";
			break;
		}
	}


	include_once $root.$folder."/tail.php";
?>
