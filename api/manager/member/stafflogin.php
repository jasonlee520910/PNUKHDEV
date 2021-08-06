<?php 
/*   안씀
//MANAGER 로그인 stafflogin

	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$st_userid=addslashes($_POST["stLoginId"]);
	$st_passwd=addslashes($_POST["stPasswd"]);

	if($apiCode!="stafflogin"){$json["resultMessage"]="API(apiCode) ERROR333";$apiCode="stafflogin";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$sql=" select * from ".$dbH."_staff where st_userid='".$st_userid."' and st_passwd=password('".$st_passwd."') ";
		$dt=dbone($sql);
		
		if($dt["st_seq"])
		{			
			$json = array(
						"apiCode"=>$apiCode, 
						"seq"=>$dt["st_seq"], 
						"stUserid"=>$dt["st_userid"], 
						"stName"=>$dt["st_name"], 
						"stStaffid"=>$dt["st_staffid"], 
						"stAuth"=>$dt["st_auth"], 
						"stDepart"=>$dt["st_depart"], 
						"stLogin"=>$dt["st_login"], 
						"stUse"=>$dt["st_use"],
						"returnData"=>$returnData
				);

			//=================================================================================
			$json["locationURL"] = "/";
			switch($dt["st_depart"])
			{
			case "manager":case "admin":
				$json["locationURL"]='http://manager.djmedi.net/index.php';
				break;
			case "making":case "decoction":case "marking":case "release":
				$json["locationURL"]='http://tbms.djmedi.net?depart='.$dt["st_depart"];
				break;
			case "sales":
				if($dt["st_auth"]=="sales")
				{
					$json["locationURL"]='/_adm/82_Estimate/Estimate.php';
				}
				else
				{
					$json["locationURL"]='/_adm/83_SetSale/SetPrice.php';
				}
				break;
			case "marketing":
				if($dt["st_auth"]=="tutadmin")
				{
					$json["locationURL"]='/_adm/61_Marketing/Tutorials.php';
				}
				else
				{
					$json["locationURL"]='/tutorial/';
				}
				break;
			}

			$txtdata = getTxtData("'checkdata','emailoklogin','accesserr','infono','confirmwait'");
			$json["txtdata"]=$txtdata;
			//checkdata : 올바른 정보를 입력하세요
			//emailoklogin : 이메일 인증 후 로그인 가능합니다.
			//accesserr : 접속오류
			//infono : 정보없음
			//confirmwait : 인증대기

			//=================================================================================

			$json["resultCode"]="200";
			$json["resultMessage"]="SUCCESS_OK";
		}
		else
		{
			$json["resultCode"]="204";
			$json["resultMessage"]="아이디와 비밀번호를 다시 확인해주세요.";
		}
		$json["sql"]=$sql;
	}
?>