<?php  	//한의원리스트에서 버튼 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	if($apiCode!="medicaldoctorupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="medicaldoctorupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$status=$_POST["status"];  //한의원의 상태
		$seq=$_POST["seq"];  //한의원의 seq

		if($status=="apply") //승인하기
		{
			$sql=" update ".$dbH."_medical set mi_status='confirm', mi_confirmdate=sysdate where mi_seq='".$seq."' ";  

		}
		else if($status=="confirm") //차단하기
		{
			$sql=" update ".$dbH."_medical set mi_status='reject', mi_modify=sysdate where mi_seq='".$seq."' ";  

		}

		//--------------------------------------------------------------------
		$me_company=$_POST["me_company"];  //한의원의 seq
		$meSeq=$_POST["meSeq"];  //한의사 seq

		//한의사 리스트에서 한의원 등록하기
		if($me_company && $meSeq)
		{
			$sql=" update ".$dbH."_member set me_status='confirm',me_company='".$me_company."', me_confirmdate=sysdate where me_seq='".$meSeq."' ";  
		}

		//echo $sql;
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>