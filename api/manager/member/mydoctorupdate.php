<?php  	
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	if($apiCode!="mydoctorupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="mydoctorupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$status=$_POST["status"];  //멤버의 상태
		$seq=$_POST["seq"];  //멤버의 seq

		/*--------------------------------------------------------- 
		//member 상태값 정리(20200812) 
		apply - 회원가입만 한 상태
		emailauth - 이메일 인증을 한 상태
		approve - 이메일인증은 한 상태
		request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
		standby - 소속한의사가 한의원을 찾아 승인전 상태
		confirm - 정회원
		--------------------------------------------------------*/	

		if($status=="apply") //이메일 인증하기
		{
			$sql2=" select me_grade,me_company from han_member where me_seq = '".$seq."' ";
			$dt=dbone($sql2);

			if($dt["ME_GRADE"]=='30')//me_grade이 30 이면 원장님이니까 바로 confirm으로 넘어간다.
			{		
				$sql=" update ".$dbH."_member set me_status='confirm', me_confirmdate=sysdate where me_seq='".$seq."' ";  //원장님은 바로 confirm			
			}
			else
			{

				if(isEmpty($dt["ME_COMPANY"]))
				{
				
					$sql=" update ".$dbH."_member set me_status='emailauth', me_modify=sysdate where me_seq='".$seq."' ";  //한의원 소속으로 함		
				}
				else
				{
					$sql3=" select count(*) tcnt from han_member where me_company = '".$dt["ME_COMPANY"]."' ";
					$dt3=dbone($sql3);

					if($dt3["TCNT"]>1)	//한의원에 처음 등록하는 member인지 확인하기 
					{		
						$sql=" update ".$dbH."_member set me_status='emailauth', me_modify=sysdate where me_seq='".$seq."' ";  //한의원 소속으로 함		
					}
					else
					{		
						$sql=" update ".$dbH."_member set me_status='confirm', me_confirmdate=sysdate where me_seq='".$seq."' ";  //원장님은 바로 confirm			
					}	
					
				}				
			}
		}
		else if($status=="emailauth") //면허증 확인하기
		{
			$sql=" update ".$dbH."_member set me_status='approve', me_modify=sysdate where me_seq='".$seq."' ";  //한의원 소속으로 함

		}
		else if($status=="request") //승인요청(요청취소)
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
		$json["sql3"]=$sql3;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>