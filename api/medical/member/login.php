<?php ///TMPS 로그인 login

	///로그인 IP 제어 (59.7.50.122는 디제이메디)
	///$accepip=array("59.7.50.122");

	$ip=$_SERVER["REMOTE_ADDR"];
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$me_loginId=$_POST["userID"];
	$me_passwd=$_POST["userPWD"];
	$severName=$_SERVER['SERVER_NAME'];
	
	if($apiCode!="login"){$json["resultMessage"]="API(apiCode2) ERROR2";$apiCode="login";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$NetLive=$_POST["NetLive"];
		$returnData=$_POST["returnData"];

		$sql=" select me_seq, me_company, me_use, me_grade, me_loginid, me_userid, me_name, me_auth, me_status  from ".$dbH."_member where me_loginid='".$me_loginId."' and me_passwd='".$me_passwd."' ";
		$dt=dbone($sql);

		$me_seq=$dt["ME_SEQ"];
		$me_company=$dt["ME_COMPANY"];
		$me_use=$dt["ME_USE"];
		$me_grade=$dt["ME_GRADE"];
		$me_loginid=$dt["ME_LOGINID"];
		$me_userid=$dt["ME_USERID"];
		$me_name=$dt["ME_NAME"];
		$me_auth=$dt["ME_AUTH"];
		$me_status=$dt["ME_STATUS"];

		/*--------------------------------------------------------- 
		//member 상태값 정리(20200812) 	
		apply - 회원가입만 한 상태
		emailauth-이메일인증은 한 상태 
		approve - 면허증을 올린 상태
		request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
		standby - 소속한의사가 한의원을 찾아 승인전 상태
		confirm - 정회원
		--------------------------------------------------------*/	

		if($me_seq)
		{

			if($me_status!='apply')  //승인 인증후 상태이면 (medical 로그인은 apply 만 아니면 로그인 가능함)
			{
				if($me_use=="Y") //살아있다면 
				{
					$mi_userid="";
					$mi_name="";
					$mi_grade="";
					$mi_status="";
					$mi_registno="";
					if($me_company) //소속된 한의원이 있으면 
					{
						$msql=" select mi_userid, mi_name, mi_grade, mi_status, mi_registno from ".$dbH."_medical where mi_userid='".$me_company."' ";
						$mdt=dbone($msql);
						$mi_userid=$mdt["MI_USERID"];
						$mi_name=$mdt["MI_NAME"];
						$mi_grade=$mdt["MI_GRADE"];
						$mi_status=$mdt["MI_STATUS"];
						$mi_registno=$mdt["MI_REGISTNO"];
					}

					$json = array(
							//한의사정보 
							"seq"=>$me_seq,
							"meGrade"=>$me_grade,
							"meLoginid"=>$me_loginid,
							"meUserId"=>$me_userid,
							"meName"=>$me_name,
							"meAuth"=>$me_auth,
							"meUse"=>$me_use, 
							"meStatus"=>$me_status, 
						

							//한의원정보
							"miUserid"=>$mi_userid, 
							"miRegistNo"=>$mi_registno, ///의료기관코드								
							"miName"=>$mi_name, ///한의원이름 
							"miGrade"=>$mi_grade,///한의원등급 
							"miStatus"=>$mi_status,

							"returnData"=>$returnData
					);


					if($me_status=='emailauth' || $me_status=='approve')
					{
						$lastUrl = str_replace("api","ehd",$severName);
						if($_SERVER['HTTPS'] != "on")
						{
							$json["locationURL"]="http://".$lastUrl."/Signup/document.php"; 
							
						}
						else					
						{
							$json["locationURL"]="https://".$lastUrl."/Signup/document.php"; 
							
						}

						$json["apiCode"]=$apiCode;
						$json["resultCode"]="201";
						$json["resultMessage"]="OK";

					}
					else
					{
						$lastUrl = str_replace("api","ehd",$severName);
						if($_SERVER['HTTPS'] != "on")
						{
							$json["locationURL"]="http://".$lastUrl; 
						}
						else					
						{
							$json["locationURL"]="https://".$lastUrl;
						}

						$json["apiCode"]=$apiCode;
						$json["resultCode"]="200";
						$json["resultMessage"]="OK";
					
					
					}
				}
				else
				{
					$json["apiCode"]=$apiCode;
					$json["resultCode"]="899";				
					$json["resultMessage"]="탈퇴한 회원입니다.";
				}	
			
			}
			else if($me_status=='apply')  //회원가입만 한 상태
			{
				$json["apiCode"]=$apiCode;
				$json["resultCode"]="900";				
				//$json["resultMessage"]="이메일 인증전입니다 인증후 사용하실수 있습니다.";
			}			
		}
		else
		{
			$json["apiCode"]=$apiCode;
			$json["resultCode"]="899";				
			$json["resultMessage"]="아이디와 비밀번호를 다시 확인해주세요.";
		}

		$json["sql"]=$sql;
		$json["msql"]=$msql;

	}

?>