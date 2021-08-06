<?php  
	///공지사항 리스트
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apicode!="boardlist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="boardlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$bb_type=$_GET["bb_type"];
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$search=urldecode(trim($_GET["searchTxt"])); //검색단어	

		$jsql=" a  ";
		$wsql="  where a.bb_use <>'D' and a.bb_code='".$bb_type."' ";

		if($search)  ///검색단어
		{
			$wsql.=" and bb_title like '%".$search."%'  ";
		}

		$pg=apipaging("a.bb_seq","_board",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select row_number() over (order by a.bb_seq desc) num ";	
		$sql.=" ,a.bb_seq, a.BB_CODE, a.bb_title, a.bb_desc, a.BB_ANSWER  ";		
		$sql.=" ,to_char(a.bb_indate,'yyyy-mm-dd') as BBINDATE ";
		$sql.=" from ".$dbH."_board $jsql $wsql  ";		
		$sql.=" order by a.bb_seq desc  ";
		$sql.=" ) where num>".$pg["snum"]." and num<=".$pg["tlast"]; 

		$res=dbqry($sql);

		$json["sql"]=$sql;

		$json["wsql"]=$wsql;

		$json["tsql"]=$pg["tsql"];
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$bbAnswer=getClob($dt["BB_ANSWER"]);
			$answer="무";
			if(isEmpty($bbAnswer)==false)
			{
				$answer="유";
			}

			$addarray=array(

				"seq"=>$dt["BB_SEQ"], 
				"bbCode"=>$dt["BB_CODE"], 
				"bbTitle"=>$dt["BB_TITLE"], 
				"bbDesc"=>getClob($dt["BB_DESC"]),
				"bbAnswer"=>getClob($dt["BB_ANSWER"]),
				"chkAnswer"=>$answer,
				"bbIndate"=>$dt["BBINDATE"]

				);
			array_push($json["list"], $addarray);
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>