<?php  
	/// 자재코드관리 > 조제태그관리 >  등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$pt_seq=$_POST["seq"];
	$pt_group=$_POST["ptGroup"];
	if($apicode!="pouchtagupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="pouchtagupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($pt_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($pt_group==""){$json["resultMessage"]="API(ptGroup) ERROR";}
	else
	{
		$pt_code=$_POST["ptCode"];

		if($pt_code=="add")
		{
			$sql2="select * from  ( select substr(pt_code, 4,10) as PTCODE from ".$dbH."_pouchtag order by pt_code desc) where rownum <= 1 ";


			$dt=dbone($sql2);
			if($dt["PTCODE"])
			{
				$ptcode=sprintf("%010d",intval($dt["PTCODE"]) + 1);
			}
			else
			{
				$ptcode="0000000001";
			}
			$pt_code="MDT".$ptcode;
		}
		$pt_name1=$_POST["ptName1"];
		$pt_name2=$_POST["ptName2"];
		$pt_name3=$_POST["ptName3"];

		if($pt_seq&&$pt_seq!="add")
		{
			$sql=" update ".$dbH."_pouchtag set ";
			$sql.=" pt_group='".$pt_group."',pt_name1='".$pt_name1."',pt_name2='".$pt_name2."',pt_name3='".$pt_name3."',pt_date=SYSDATE";
			$sql.=" where pt_seq='".$pt_seq."'";
		}
		else
		{
			$sql=" insert into ".$dbH."_pouchtag (pt_seq,pt_code,pt_group,pt_name1,pt_name2,pt_name3,pt_date) values ((SELECT NVL(MAX(pt_seq),0)+1 FROM ".$dbH."_pouchtag),'".$pt_code."','".$pt_group."','".$pt_name1."','".$pt_name2."','".$pt_name3."',SYSDATE) ";
		}
		dbcommit($sql);

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		
	}
?>