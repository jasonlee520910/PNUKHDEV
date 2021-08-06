<?php ///회원가입 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	if($apiCode!="mymedicalupdate"){$json["resultMessage"]="API코드오류2";$apiCode="mymedicalupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$seq=$_POST["seq"];  //멤버의 seq

		$sql=" update ".$dbH."_member set me_status='confirm' , me_confirmdate=sysdate where me_seq='".$seq."' ";  //한의원 소속으로 함
		dbcommit($sql);

		/*--------------------------------------------------------- 
		//member 상태값 정리(20200812) 
		apply - 회원가입만 한 상태
		emailauth - 이메일 인증을 한 상태
		approve - 이메일인증은 한 상태
		request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
		standby - 소속한의사가 한의원을 찾아 승인전 상태
		confirm - 정회원
		--------------------------------------------------------*/	

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";	
		$json["apiCode"]=$apiCode;		
	}
?>