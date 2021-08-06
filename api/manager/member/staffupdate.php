<?php  
	///사용자관리 > 스탭관리 > 등록 & 수정 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$st_userid=$_POST["stUserId"];

	if($apiCode!="staffupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="staffupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($st_userid==""){$json["resultMessage"]="API(stUserId) ERROR";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$st_seq=$_POST["seq"];
		$st_staffid=addslashes($_POST["stStaffId"]); //사원코드
		
		$st_name=$_POST["stName"];
		$st_auth=$_POST["stAuth"];
		$st_depart=$_POST["stDepart"];
		$st_zipcode=$_POST["stZipCode"];
		$st_address=$_POST["stAddress"]."||".$_POST["stAddress1"];//주소
		$st_phone=$_POST["stPhone0"]."-".$_POST["stPhone1"]."-".$_POST["stPhone2"]; //전화번호
		$st_mobile=$_POST["stMobile0"]."-".$_POST["stMobile1"]."-".$_POST["stMobile2"]; //휴대폰번호
		$st_email=$_POST["stEmail0"]."@".$_POST["stEmail1"]; //이메일
		$st_status=($_POST["stStatus"])?$_POST["stStatus"]:"standby";

		$st_passwd=$_POST["stPasswd"];
		$st_passwd2=$_POST["stPasswd2"];
		
		if($st_seq && $st_seq!="add")  ///비밀번호는 수정이 불가함. 등록만 가능 
		{
			$sql=" update ".$dbH."_staff set st_name='".$st_name."', st_auth='".$st_auth."', st_depart='".$st_depart."', st_zipcode='".$st_zipcode."' ";
			$sql.=", st_address='".$st_address."', st_phone='".$st_phone."', st_mobile='".$st_mobile."', st_email='".$st_email."'";
			$sql.=", st_status='".$st_status."', st_memo='".$st_memo."', st_modify=SYSDATE ";


/* 암호화 부분은 함수 주면 다시 수정하기
			if($st_passwd&&($st_passwd==$st_passwd2)){
				$sql.=", st_passwd = password('".$st_passwd."') ";
			}
*/
			$sql.=" where st_seq='".$st_seq."' ";
			dbcommit($sql);
			$json["sql"]=$sql.$st_passwd.$st_passwd2;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$sql=" select st_userid from ".$dbH."_staff where st_userid='".$st_userid."'";
			$dt=dbone($sql);
			if($dt["ST_USERID"])
			{
				$json["resultCode"]="204";
				$json["resultMessage"]="중복데이터";
			}
			else
			{
				$sql=" insert into ".$dbH."_staff (st_seq,st_userid ,st_name ,st_staffid ,st_passwd, st_auth ,st_depart ,st_zipcode";
				$sql.=" ,st_address ,st_phone ,st_mobile ,st_email, st_status, st_memo ,st_date) ";
				$sql.=" values ((SELECT NVL(MAX(st_seq),0)+1 FROM ".$dbH."_staff),'".$st_userid."','".$st_name."','".$st_staffid."',('".$st_passwd."')";
				$sql.=" ,'".$st_auth."','".$st_depart."','".$st_zipcode."','".$st_address."','".$st_phone."','".$st_mobile."','".$st_email."'";
				$sql.=" ,'".$st_status."','".$st_memo."',SYSDATE) ";

				dbcommit($sql);
				//$json["sql"]=$sql.$st_passwd.$st_passwd2;
				$json["sql"]=$sql;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
		}
	}


?>