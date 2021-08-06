<?php ///회원가입 서류 확인
	///GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$meCompany=$_GET["meCompany"];
	$afFcode=$_GET["afFcode"];	

	if($apiCode!="joindesc"){$json["resultMessage"]="API코드오류";$apiCode="joindesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	///else if($seq==""){$json["resultMessage"]="seq 없음";}
	else
	{	
		if($meCompany)
		{
			$returnData=$_GET["returnData"];
			$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
			
			$wsql=" where mi_userid = '".$meCompany."' ";
			$sql1=" select * from ".$dbH."_medical a  $wsql ";
			$dt=dbone($sql1);
//아래오유
			$json=array(

				"meCompany"=>$meCompany,
				"seq"=>$dt["MI_SEQ"] 

				);

			///등록된 이미지들 
			///$sql=" select af_seq, af_name, af_url as afUrl from ".$dbH."_file where af_use='Y' and af_code='member' and af_fcode='".$afFcode."' order by af_no desc limit 1 ";///업로드 마지막 한장만 보임
			$sql=" select af_seq, af_name, af_code, af_fcode, af_size, af_url as AFURL from ".$dbH."_file where af_use='Y' and af_code='member' and af_userid='".$meCompany."' order by af_no desc  ";
			$res=dbqry($sql);

			$json["afFiles"]=array();
			for($i=0;$dt=dbarr($res);$i++)
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(	
					"afseq"=>$dt["AF_SEQ"], 
					"afCode"=>$dt["AF_CODE"], 					
					"afUrl"=>$afFile,
					"afThumbUrl"=>$afThumbUrl, 
					"afFcode"=>$dt["AF_FCODE"], 					
					"afName"=>$dt["AF_NAME"], 
					"afSize"=>$dt["AF_SIZE"]
				);
				array_push($json["afFiles"], $addarray);
			}
		}

		$json["sql1"]=$sql1;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>