<?php  
	//처방하기>>나의처방에서 나의처방삭제 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apiCode!="myrecipedelete"){$json["resultMessage"]="API코드오류";$apiCode="myrecipedelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$doctorId=$_POST["doctorId"]; ///한의사
		$medicalId=$_POST["medicalId"]; ///한의원
		$seqdata=$_POST["seqdata"]; ///등록할 처방seq 

		$seqarr=explode(",",$seqdata);

		$sql1="";
		for($i=1;$i<count($seqarr);$i++)
		{
			//RC20200617 105428 00001
			$sql=" update ".$dbH."_RECIPEMEDICAL set RC_USE='D', RC_MODIFY=sysdate  where RC_SEQ='".$seqarr[$i]."' ";

			dbcommit($sql);

			$sql1.=$sql;
		}

		$json["_POST"]=$_POST;
		$json["sql1"]=$sql1;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>