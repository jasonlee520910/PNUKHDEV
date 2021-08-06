<?php  
	///고객센터> 공지사항  리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="noticelist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="noticelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"search"=>$search,"returnData"=>$returnData);
	
		$jsql=" a ";
		$wsql=" where a.bb_use <>'D' and a.bb_code='NOTICE' ";

		$pg=apipaging("a.bb_seq","_board",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select row_number() over (order by a.bb_seq) num ";	
		$sql.=" ,a.bb_seq, a.bb_title, a.bb_desc ";		
		$sql.=" ,to_char(a.bb_modify,'yyyy-mm-dd') as bb_modify ";
		$sql.=" from ".$dbH."_board $jsql $wsql  ";		
		$sql.=" order by a.bb_seq  ";
		$sql.=" ) where num>".$pg["snum"]." and num<=".$pg["tlast"]; 

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["search"]=$search;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"seq"=>$dt["BB_SEQ"], ///seq
				"bbTitle"=>$dt["BB_TITLE"], ///제목
				"bbDesc"=>getClob($dt["BB_DESC"]), ///내용
				"bbModify"=>$dt["BB_MODIFY"] ///날짜
					);
			array_push($json["list"], $addarray);

		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>