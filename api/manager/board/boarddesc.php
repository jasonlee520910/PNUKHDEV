<?php 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	

	if($apiCode!="boarddesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="boarddesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$hCodeList = getNewCodeTitle("bbtype,linktype,popupopen,bbUse");
		$bbtypeList = getCodeList($hCodeList, 'bbtype');
		$linktypeList = getCodeList($hCodeList, 'linktype');
		$popupopenList = getCodeList($hCodeList, 'popupopen');
		$bbUseList = getCodeList($hCodeList, 'bbUse');

		if($seq)
		{
			$sql=" select ";
			$sql.=" bb_seq,bb_code,bb_userid,bb_title,bb_desc,bb_type,bb_indate,bb_answer,BB_TOP,BB_LEFT,BB_WIDTH,BB_HEIGHT";
			$sql.=" ,bb_link,bb_linktype,bb_use,bb_popuplimit";
			$sql.=" ,to_char(bb_sdate,'yyyy-mm-dd hh24:mi:ss') as bb_sdate "; 
			$sql.=" ,to_char(bb_edate,'yyyy-mm-dd hh24:mi:ss') as bb_edate "; 
			$sql.=" from ".$dbH."_board  where bb_seq='".$seq."'";
			$dt=dbone($sql);
	//echo $sql;

			$bb_sdate=explode(" ",$dt["BB_SDATE"]);
			$bb_sdate2=explode("-",$bb_sdate[0]);
			$bb_sdate3=explode(":",$bb_sdate[1]);

			$bb_edate=explode(" ",$dt["BB_EDATE"]);
			$bb_edate2=explode("-",$bb_edate[0]);
			$bb_edate3=explode(":",$bb_edate[1]);

			$json=array(
				"seq"=>$dt["BB_SEQ"], 
				"bbCode"=>$dt["BB_CODE"], 
				"bbTitle"=>$dt["BB_TITLE"], 
				"bbDesc"=>getClob($dt["BB_DESC"]), 
				"bbAnswer"=>getClob($dt["BB_ANSWER"]), 
				"bbType"=>$dt["BB_TYPE"], 
				"bbIndate"=>$dt["BB_INDATE"], 
				"bbModify"=>$dt["BB_MODIFY"],

				"bbLink"=>$dt["BB_LINK"],
				"Linktype"=>$dt["BB_LINKTYPE"],
				"bbUse"=>$dt["BB_USE"],
				"bb_popuplimit"=>$dt["BB_POPUPLIMIT"],

				"bb_userid"=>$dt["BB_USERID"],
					
				"bbSdate"=>$dt["BB_SDATE"],  //2020-07-06 15:39:50
				"bbEdate"=>$dt["BB_EDATE"],  //2020-07-22 16:09:00

				"bbSdate0"=>$bb_sdate2[0], //년
				"bbSdate1"=>$bb_sdate2[1], //월
				"bbSdate2"=>$bb_sdate2[2],  //일

				"bbSdate3"=>$bb_sdate3[0],  //분
				"bbSdate4"=>$bb_sdate3[1],	//초				

				"bbEdate0"=>$bb_edate2[0], 
				"bbEdate1"=>$bb_edate2[1],
				"bbEdate2"=>$bb_edate2[2],	

				"bbEdate3"=>$bb_edate3[0],
				"bbEdate4"=>$bb_edate3[1],

				"bbTop"=>$dt["BB_TOP"], 
				"bbLeft"=>$dt["BB_LEFT"], 
				"bbWidth"=>$dt["BB_WIDTH"], 
				"bbHeight"=>$dt["BB_HEIGHT"], 
					
				"popupopenList"=>$popupopenList, //이 팝업 사용여부
				"bbUseList"=>$bbUseList,
				
				"linktypeList"=>$linktypeList,  //게시판 링크 유형
				"bbtypeList"=>$bbtypeList //게시판 문의유형	
				);


				$isql=" select AF_SEQ, AF_URL from han_file where af_fcode='".$dt["BB_SEQ"]."' and af_code='popup' and af_use<>'D' ";
				$idt=dbone($isql);
				$imgPop="";
				if($idt["AF_URL"])
				{
					$imgPop=getafFile($idt["AF_URL"]);
				}

				$json["imgPop"]=$imgPop;
				$json["afSeq"]=$idt["AF_SEQ"];
		}
		else
		{
				$json=array(
				"popupopenList"=>$popupopenList, //이 팝업 사용여부		
				"bbUseList"=>$bbUseList,
				"linktypeList"=>$linktypeList,  //게시판 링크 유형
				"bbtypeList"=>$bbtypeList //게시판 문의유형			
				);	
		}
	
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>