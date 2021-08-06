<?php  
	///고객센터> FAQ  리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$btype=$_GET["btype"];
	$page=$_GET["page"];

	if($apiCode!="boardlist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="boardlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"search"=>$search,"returnData"=>$returnData);
	
		$jsql=" a ";
		$wsql=" where a.bb_use ='Y' and a.bb_code='".$btype."' ";

		$pg=apipaging("a.bb_seq","board",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select row_number() over (order by a.bb_seq desc) num ";	
		$sql.=" ,a.bb_seq, a.bb_code, a.bb_title, a.bb_desc,BB_TOP,BB_LEFT,BB_WIDTH,BB_HEIGHT ";	
		$sql.=" ,bb_link,bb_linktype,bb_use";
		$sql.=" ,to_char(bb_sdate,'yyyy-mm-dd') as bb_sdate "; 
		$sql.=" ,to_char(bb_edate,'yyyy-mm-dd') as bb_edate "; 
		$sql.=" ,to_char(a.bb_modify,'yyyy-mm-dd') as bb_modify ";
		$sql.=" from ".$dbH."_board $jsql $wsql  ";		
		$sql.=" order by a.bb_seq desc ";
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
			//팝업일경우 
			$imgPop="";
			if($dt["BB_CODE"]=="POPUP")
			{
				$isql=" select AF_URL from han_file where af_fcode='".$dt["BB_SEQ"]."' and af_code='popup' and af_use<>'D' ";
				$idt=dbone($isql);
				if($idt["AF_URL"])
				{
					$imgPop=getafFile($idt["AF_URL"]);		
				}
			}

			$addarray=array(
				"seq"=>$dt["BB_SEQ"], ///seq
				"bbTitle"=>$dt["BB_TITLE"], ///제목
				"BB_CODE"=>$dt["BB_CODE"], ///제목
				//"isql"=>$isql,


				"bbLink"=>$dt["BB_LINK"],
				"Linktype"=>$dt["BB_LINKTYPE"],
				"bbUse"=>$dt["BB_USE"],
				"bbSdate"=>$dt["BB_SDATE"],
				"bbEdate"=>$dt["BB_EDATE"],

				"bbTop"=>$dt["BB_TOP"], 
				"bbLeft"=>$dt["BB_LEFT"], 
				"bbWidth"=>$dt["BB_WIDTH"], 
				"bbHeight"=>$dt["BB_HEIGHT"], 
				"imgPop"=>$imgPop,

				"bbDesc"=>getClob($dt["BB_DESC"]), ///내용
				"bbModify"=>$dt["BB_MODIFY"] ///날짜
					);
			array_push($json["list"], $addarray);

		}

		

		$json["sql"]=$sql;
		$json["btype"]=$btype;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>