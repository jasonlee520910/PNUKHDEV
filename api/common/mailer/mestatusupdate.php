<?php  
	///이메일 인증확인하면 update
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	$key=$_POST["postdata"];

	if($apiCode!="mestatusupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="mestatusupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($dm_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{

		include_once $root.$folder."/mailer/oracleDB.php";


		$sql2=" select me_grade,me_company from han_member where me_loginid = '".$key."' ";
		$dt=dbone($sql2);

		if($dt["ME_GRADE"]=='30')//me_grade이 30 이면 원장님이니까 바로 confirm으로 넘어간다.
		{
			$sql=" update han_member set me_status='confirm', me_confirmdate=sysdate ";	
			$sql.=" where me_loginid='".$key."' ";
		}
		else
		{
				if($dt["ME_COMPANY"]=="" || $dt["ME_COMPANY"]==null )
				{	
					$sql=" update ".$dbH."_member set me_status='emailauth', me_modify=sysdate where me_loginid='".$key."' ";  //한의원 소속으로 함		
				}
				else
				{			
					$sql3=" select count(*)tcnt from han_member where me_company = '".$dt["ME_COMPANY"]."' ";
					$dt3=dbone($sql3);

					if($dt3["TCNT"]>1)	//한의원에 처음 등록하는 member인지 확인하기 
					{		


						$sql=" update han_member set me_status='emailauth',me_modify=sysdate ";	
						$sql.=" where me_loginid='".$key."'";	
					}
					else
					{
						$sql=" update han_member set me_status='confirm', me_confirmdate=sysdate ";	
						$sql.=" where me_loginid='".$key."' ";
					}			
				}
		}

		dbcommit($sql);	

		/*--------------------------------------------------------- 
		//member 상태값 정리(20200812) 	
		apply - 회원가입만 한 상태
		emailauth-이메일인증은 한 상태 
		approve - 면허증을 올린 상태
		request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
		standby - 소속한의사가 한의원을 찾아 승인전 상태
		confirm - 정회원
		--------------------------------------------------------*/	

		$json["mestatusupdate_sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultMessage"]="OK";
		$json["resultCode"]="200";
		$json["key"]=$key;

	}
?>

