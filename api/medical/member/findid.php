<?php ///내정보 수정시 비밀번호 확인
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$findname=$_POST["findname"];
	$stEmail0=$_POST["stEmail0"];
	$stEmail1=$_POST["stEmail1"];

	if($apiCode!="findid"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="findid";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if(!$findname){$json["resultMessage"]="API(findname) ERROR";}
	else if(!$stEmail0){$json["resultMessage"]="API(stEmail0) ERROR";}
	else if(!$stEmail1){$json["resultMessage"]="API(stEmail1) ERROR";}
	else
	{

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$me_name=$findname;
		$me_email=$stEmail0."@".$stEmail1;
		
		$wsql=" where me_name = '".$me_name."' and me_email='".$me_email."' ";
		$sql=" select me_loginid from ".$dbH."_member  $wsql ";
		
		$dt=dbone($sql);
		if($dt["ME_LOGINID"]){
			$json=array("apiCode"=>$apiCode,"resultCode"=>"200","resultMessage"=>"OK","loginID"=>$dt["ME_LOGINID"]);
		}else{
			$json=array("apiCode"=>$apiCode,"resultCode"=>"204","resultMessage"=>"아이디가 없습니다");
		}
		$json["sql"]=$sql;
	}
?>