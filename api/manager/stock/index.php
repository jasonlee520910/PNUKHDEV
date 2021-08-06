<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR.";
	
	//GET
	switch($_GET["apiCode"]){

		case "medistocklist"://약재재고목록
			include_once $root.$folder."/stock/medistocklist.php";
			break;
		case "instocklist"://약재입고
			include_once $root.$folder."/stock/instocklist.php";
			break;
		case "instockdesc"://약재입고 상세
			include_once $root.$folder."/stock/instockdesc.php";
			break;
		case "instockdelete"://약재입고 삭제 
			include_once $root.$folder."/stock/instockdelete.php";
			break;
		case "instocksearch":
			include_once $root.$folder."/stock/instocksearch.php";
			break;
		case "outstocklist"://약재출고
			include_once $root.$folder."/stock/outstocklist.php";
			break;
		case "outstockdesc"://약재출고 상세 
			include_once $root.$folder."/stock/outstockdesc.php";
			break;
		case "outstockdelete"://약재출고 삭제  
			include_once $root.$folder."/stock/outstockdelete.php";
			break;
		case "genstocklist"://자재입출고
			include_once $root.$folder."/stock/genstocklist.php";
			break;
		case "genstockdesc"://자재입출고 상세
			include_once $root.$folder."/stock/genstockdesc.php";
			break;
		case "genstockdelete":
			include_once $root.$folder."/stock/genstockdelete.php";
			break;
		case "medistockdesc":
			include_once $root.$folder."/stock/medistockdesc.php";
			break;
		case "stockroute":
			include_once $root.$folder."/stock/stockroute.php";
			break;
		case "stockroutelist":
			include_once $root.$folder."/stock/stockroutelist.php";
			break;
		case "checkoutstock":
			include_once $root.$folder."/stock/checkoutstock.php";
			break;
		case "medicineuselist":  //약재사용다운로드
			include_once $root.$folder."/stock/medicineuselist.php";
			break;					
	}

	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "instockupdate":
				include_once $root.$folder."/stock/instockupdate.php";
				break;
			case "outstockupdate":
				include_once $root.$folder."/stock/outstockupdate.php";
				break;
			case "genstockupdate": //자재입출고
				include_once $root.$folder."/stock/genstockupdate.php";
				break;
			case "instockcancelupdate":
				include_once $root.$folder."/stock/instockcancelupdate.php";
				break;
			case "outstockcancelupdate":
				include_once $root.$folder."/stock/outstockcancelupdate.php";
				break;
			case "medistatusupdate":
				include_once $root.$folder."/stock/medistatusupdate.php";
				break;
		}
	}

	include_once $root.$folder."/tail.php";
?>
