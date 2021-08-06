<?php  
	//메인 indexboardlist
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$btype=$_GET["btype"];
	$page=$_GET["page"];

	if($apiCode!="indexboardlist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="indexboardlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"search"=>$search,"returnData"=>$returnData);
	
		$jsql=" a ";
		$wsql=" where a.bb_use in ('M','Y') and a.bb_code='".$btype."' ";

		if($btype=="NOTICE") //3개만 보이기
		{
			$pg=maniapipaging("a.bb_seq","board",$jsql,$wsql);
		}
		else
		{
			$pg=apipaging("a.bb_seq","board",$jsql,$wsql);	
		}
		
		$sql=" select * from (";
		$sql.=" select row_number() over (order by a.bb_seq desc) num ";	
		$sql.=" ,a.bb_seq, a.bb_code, a.bb_title, a.bb_desc,BB_TOP,BB_LEFT,BB_WIDTH,BB_HEIGHT ";	
		$sql.=" ,bb_link,bb_linktype,bb_use,bb_popuplimit,bb_userid";
		$sql.=" ,to_char(bb_sdate,'yyyy-mm-dd hh24:mi:ss') as bb_sdate "; 
		$sql.=" ,to_char(bb_edate,'yyyy-mm-dd hh24:mi:ss') as bb_edate "; 
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
				"isql"=>$isql,


				"bbLink"=>$dt["BB_LINK"],
				"Linktype"=>$dt["BB_LINKTYPE"],
				"bbUse"=>$dt["BB_USE"],
				"bbPopuplimit"=>$dt["BB_POPUPLIMIT"],
				"bbIp"=>$dt["BB_USERID"],

					

					
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

	function maniapipaging($use,$tbl,$jsql="",$wsql="")
	{
		global $dbH;
		global $pagefile;
		global $disc;
		$page=$_GET["page"];
		$psize=$_GET["psize"];
		$block=$_GET["block"];
		if(!$page)$page=1;
		$pg["page"]=$page;
		if(!$psize)$psize=3;
		$pg["psize"] = $psize;	///페이지당 갯수
		if(!$block)$block=3;
		$pg["block"] = $block;	///화면당 페이지수
		$pg["snum"] = ($pg["page"]-1)*$pg["psize"];
		if(!$page)$page=1;
		///search

		$sql=" select count(distinct(".$use.")) TCNT from ".$dbH."_".$tbl." ".$jsql." ".$wsql;
		$dt=dbone($sql);

		$pg["psql"] = $sql;
		$pg["tcnt"] = $dt["TCNT"];
		$pg["tpage"] = ceil($dt["TCNT"] / $pg["psize"]);
		$pg["tlast"] = $pg["snum"]+$pg["psize"];
		return $pg;
	}
?>