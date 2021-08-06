<?php  
	///사용자관리 > 한의원관리 > 상세보기 > 포장재관리에서 공통 포장재 가져오기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"]; //포장재 seq
	$miUserid=$_GET["miUserid"];

	if($apiCode!="commpackingupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="commpackingupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($miUserid==""){$json["resultMessage"]="API(miUserid) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		///중복확인
		$sql="select pb_member from ".$dbH."_packingbox where pb_seq = '".$seq."' ";
		$dt=dbone($sql);
		$pb_member=$dt["PB_MEMBER"];

		$newpbmember="";
		if($pb_member)
		{
			$arr=explode(",", $pb_member);
			$chk="Y";

			for($i=0;$i<count($arr);$i++)
			{
				if($i>0){$newpbmember.=",";}
				if($arr[$i]==$miUserid)
				{
					$newpbmember.=$arr[$i];
					$chk="N";
				}
				else
				{
					$newpbmember.=$arr[$i];
				}
			}

			if($chk=="Y")
			{
				$newpbmember.=",".$miUserid;
			}
		}
		else
		{
			$newpbmember.=$miUserid;
		}

		$sql2="update ".$dbH."_packingbox set pb_member='".$newpbmember."', pb_modify=SYSDATE  where pb_seq = '".$seq."' "; 
		dbqry($sql2);
	
		$json["sql2"]=$sql2;
		$json["sql"]=$sql;
		$json["newpbmember"]=$newpbmember;

		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>