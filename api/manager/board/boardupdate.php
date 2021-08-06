<?php  	
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apiCode!="boardupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="boardupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$seq=$_POST["seq"];	
		$bb_type=$_POST["bb_type"];	
		$bb_title=$_POST["bbTitle"];
		$bb_desc=$_POST["bbDesc"];

		$bb_answer=$_POST["bbAnswer"];  //답변	
		
		$bb_sdate=$_POST["sdate"];  //팝업 게시 시작날짜.
		$bb_edate=$_POST["edate"];  //팝업 게시 마지막날짜.
		$bb_link=$_POST["bbLink"];  //답변	
		$bb_linktype=$_POST["linktype"];  //답변	
		$bb_nychk=$_POST["NYchk"];  //사용여부
		$myip=$_POST["myip"];  //사용여부가 M일때만
		//$bbUse=$_POST["bbUse"];  //공개여부 

		$bb_popuplimit=$_POST["termchk"];  //노출기간 지정여부

		if($bb_popuplimit=="N")
		{
			$bb_sdate=$bb_edate="";
		}


		if($bb_nychk=="" || $bb_nychk==null){$bb_nychk="Y";}

		$bb_top=($_POST["bbTop"])?$_POST["bbTop"]:"0";
		$bb_left=($_POST["bbLeft"])?$_POST["bbLeft"]:"0";
		$bb_width=($_POST["bbWidth"])?$_POST["bbWidth"]:"0";
		$bb_height=($_POST["bbHeight"])?$_POST["bbHeight"]:"0";

		$bb_fileSeq=($_POST["bbFileSeq"])?$_POST["bbFileSeq"]:"";

		$bb_desc=insertClob($bb_desc);
		$bb_answer=insertClob($bb_answer);


		$json["bb_fileSeq"]=$bb_fileSeq;


		if($seq=="add")
		{
			$sql2=" insert into ".$dbH."_board (bb_seq,bb_code,bb_title,bb_desc,BB_TOP,BB_LEFT,BB_WIDTH,BB_HEIGHT, bb_indate,bb_link,bb_linktype,bb_use,bb_userid,bb_popuplimit,bb_sdate,bb_edate,bb_modify) ";
			$sql2.=" values ((SELECT NVL(MAX(bb_seq),0)+1 FROM ".$dbH."_board) ";
			$sql2.=",'".$bb_type."','".$bb_title."',".$bb_desc.",'".$bb_top."','".$bb_left."','".$bb_width."','".$bb_height."',SYSDATE,'".$bb_link."','".$bb_linktype."','".$bb_nychk."','".$myip."','".$bb_popuplimit."',to_date('".$bb_sdate."','YYYY-MM-DD hh24:mi:ss'),to_date('".$bb_edate."','YYYY-MM-DD hh24:mi:ss'), SYSDATE) ";

			//1대1만 bb_userid 를 입력하는데 이건 medical 에서만 insert함

			dbcommit($sql2);
			//echo $sql2;

			if($bb_fileSeq)
			{
				$fsql=" select MAX(bb_seq) as bbSeq from ".$dbH."_board ";
				$json["fsql"]=$fsql;
				$fdt=dbone($fsql);
				if($fdt["BBSEQ"])
				{
					$usql=" update ".$dbH."_file  set AF_FCODE='".$fdt["BBSEQ"]."' where AF_SEQ='".$bb_fileSeq."' ";
					dbcommit($usql);
					$json["usql"]=$usql;
				}
			}
		}
		else
		{
			if($bb_type=="QNA")
			{
				$sql=" update ".$dbH."_board set bb_title ='".$bb_title."',bb_desc =".$bb_desc.",bb_answer =".$bb_answer.", bb_modify=SYSDATE where bb_seq='".$seq."'";	
			
			}
			else
			{
				$sql=" update ".$dbH."_board set bb_title ='".$bb_title."',bb_desc =".$bb_desc.",bb_top =".$bb_top.",bb_left =".$bb_left." ";
				$sql.=" ,bb_width =".$bb_width.",bb_height =".$bb_height.", bb_modify=SYSDATE ";		
				$sql.=" ,BB_LINK ='".$bb_link."' ";
				$sql.=" ,bb_linktype ='".$bb_linktype."' ";
				$sql.=" ,bb_use ='".$bb_nychk."' ";
				$sql.=" ,bb_userid ='".$myip."' ";			
				$sql.=" ,bb_popuplimit ='".$bb_popuplimit."' ";
				$sql.=" ,bb_sdate =to_date('".$bb_sdate."','YYYY-MM-DD hh24:mi') ";
				$sql.=" ,bb_edate =to_date('".$bb_edate."','YYYY-MM-DD hh24:mi') ";
				$sql.=" where bb_seq='".$seq."' "; 
			}
				//echo $sql;
				dbcommit($sql);	

		}


		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}


?>