<?php 
	///약재관리 > 약재 삭제
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mm_seq=$_GET["seq"];

	if($apiCode!="medicinesmudelete"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinesmudelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mm_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_medicine_".$refer." set mm_use='D' where mm_seq='".$mm_seq."'"; // update han_medicine_djmedi set mm_use='D' where mm_seq='253'
		dbcommit($sql);

		$returnData=urldecode($_GET["returnData"]);
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

/*
		$mediboxchk=true;

		$arr=array("00080","00001","00002","00003","00000","99999");  //약재함들
		for($i=0;$i<=count($arr);$i++)
		{

			//약재함에 재고가 있는지 먼저 체크
			$sql=" select a.md_code,b.mb_table ,b.mb_capacity from han_medicine_djmedi a inner join han_medibox b on a.md_code=b.mb_medicine where a.mm_seq='".$mm_seq."' and mb_table='".$arr[$i]."' "; 
			$dt=dbone($sql);

			if($dt["MB_CAPACITY"]!=0)
			{
				$mediboxchk=false;
				$json["resultCode"]="209";
				$json["resultMessage"]="1941";//재고가 있어서 삭제할수없습니다. 			
			}
			else if($mediboxchk==true)
			{
			
				$sql=" update ".$dbH."_medicine_".$refer." set mm_use='D' where mm_seq='".$mm_seq."'"; 
				//dbcommit($sql);
				$returnData=$_GET["returnData"];
				$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			
			}
		}

*/


?>