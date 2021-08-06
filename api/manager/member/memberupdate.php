<?php  
	///사용자관리 > 한의원관리 > 소속 한의사 등록&수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$mi_userid=$_POST["userid"];///company
	if($apiCode!="memberupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="memberupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mi_userid==""){$json["resultMessage"]="API(userid) ERROR";}
	else
	{
		$me_seq=$_POST["meSeq"];
		if($me_seq=="add")$me_seq="";
		$me_grade=$_POST["meGrade"]; ///회원구분
		$me_loginid=addslashes($_POST["meLoginid"]); ///아이디
		$me_passwd=addslashes($_POST["mePasswd"]); ///비밀번호
		$me_name=$_POST["meName"]; ///이름 
		$me_auth=$_POST["meAuth"]; ///의사PK 

		if($me_seq)
		{
			if($me_passwd)
			{
				///update 시에는 비밀번호가 변경이 되도록 수정함(0314)
				$sql=" update ".$dbH."_member set me_grade='".$me_grade."', me_loginid='".$me_loginid."',me_passwd='".$me_passwd."',me_name='".$me_name."', me_auth='".$me_auth."',  me_modify=SYSDATE where me_seq='".$me_seq."' ";

				dbcommit($sql);				
			}
			else
			{
				$sql=" update ".$dbH."_member set me_grade='".$me_grade."', 
				me_loginid='".$me_loginid."',me_name='".$me_name."', me_auth='".$me_auth."',  me_modify=SYSDATE where me_seq='".$me_seq."' ";

				dbcommit($sql);
			}				
		}
		else
		{
			$sql=" select me_seq from ".$dbH."_member where me_company='".$mi_userid."' ";
			$dt=dbone($sql);

			///해당 한의원에 member가 없으면 처음 입력하는 member의 me_grade 를 30(원장)으로 입력되게함 
			if(!$dt["ME_SEQ"]){$me_grade='30';} 
		
			$me_userid=randno(10);
			$sql2=" insert into ".$dbH."_member (me_seq,me_company,me_userid,me_passwd,me_loginid,me_name,me_grade,me_auth,me_status ,me_date)";
			$sql2.="values ((SELECT NVL(MAX(me_seq),0)+1 FROM ".$dbH."_member),'".$mi_userid."', '".$me_userid."','".$me_passwd."', '".$me_loginid."','".$me_name."','".$me_grade."','".$me_auth."','confirm', SYSDATE) ";

			dbcommit($sql2);
		}

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"seq"=>$me_seq,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["sql1"]=$sql1;
		$json["sql2"]=$sql2;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>