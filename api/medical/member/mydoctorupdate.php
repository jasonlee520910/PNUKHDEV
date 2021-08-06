<?php ///회원가입 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$me_company=$_POST["meCompany"]; ///mi_userid &  me_company

	if($apiCode!="mydoctorupdate"){$json["resultMessage"]="API코드오류2";$apiCode="mydoctorupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$status=$_POST["status"];  //멤버의 상태
		$seq=$_POST["seq"];  //멤버의 seq

		$me_userId=$_POST["meUserId"];  //멤버의 

		if(isEmpty($me_userId)==false)  //한의사가 한의원을 검색해서 등록하고자 함
		{
			$sql2=" update ".$dbH."_member set me_company='".$me_company."' , me_status='standby' where me_userid='".$me_userId."' ";  //한의원 소속으로 함
			dbcommit($sql2);

		}

		/*--------------------------------------------------------- 
		//member 상태값 정리(20200812) 
		apply - 회원가입만 한 상태
		emailauth - 이메일 인증을 한 상태
		approve - 이메일인증은 한 상태
		request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
		standby - 소속한의사가 한의원을 찾아 승인전 상태
		confirm - 정회원
		--------------------------------------------------------*/	


		if($status=="request") //승인요청(요청취소)
		{
			$sql=" update ".$dbH."_member set me_status='approve', me_modify=sysdate where me_seq='".$seq."' ";  //한의원 소속으로 함

		}
		else if($status=="standby")
		{

			$sql=" update ".$dbH."_member set me_status='confirm', me_confirmdate=sysdate where me_seq='".$seq."' ";  //한의원 소속으로 함

		}
		else if($status=="confirm")  //해당 한의사를 삭제
		{
			$sql=" update ".$dbH."_member set me_company='' ,me_status='approve' ,me_modify=sysdate where me_seq='".$seq."' ";  //한의원 소속을 없애버림
		}

		//echo $sql;
		dbcommit($sql);

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>