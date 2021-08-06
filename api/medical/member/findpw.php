<?php ///내정보 수정시 비밀번호 확인
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$findid=$_POST["findid"];
	$findname=$_POST["findname"];
	$stEmail0=$_POST["stEmail0"];
	$stEmail1=$_POST["stEmail1"];

	if($apiCode!="findpw"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="findpw";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if(!$findid){$json["resultMessage"]="API(findid) ERROR";}
	else if(!$findname){$json["resultMessage"]="API(findname) ERROR";}
	else if(!$stEmail0){$json["resultMessage"]="API(stEmail0) ERROR";}
	else if(!$stEmail1){$json["resultMessage"]="API(stEmail1) ERROR";}
	else
	{

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$me_loginid=$findid;
		$me_name=$findname;
		$me_email=$stEmail0."@".$stEmail1;
		
		$wsql=" where me_loginid = '".$me_loginid."' and me_name = '".$me_name."' and me_email='".$me_email."' ";
		$sql=" select me_email from ".$dbH."_member  $wsql ";
		
		$dt=dbone($sql);
		if($dt["ME_EMAIL"]){
			//메일발송
			//me_email
			//
			$json=array("apiCode"=>$apiCode,"resultCode"=>"200","resultMessage"=>"OK","memberEmail"=>$dt["ME_EMAIL"]);
		}else{
			$json=array("apiCode"=>$apiCode,"resultCode"=>"204","resultMessage"=>"아이디가 없습니다");
		}
		$json["sql"]=$sql;
	}
?>