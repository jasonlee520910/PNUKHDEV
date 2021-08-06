<?php  
	///처방관리 > 약속처방 리스트에서 매칭정보 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];
	$rc_code=$_GET["code"];
	$rc_title=$_GET["title"];

	if($apicode!="recipegoodscypkdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="recipegoodscypkdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{

		$sql2=" select rc_source, rc_sourcetit from ".$dbH."_recipemedical where rc_seq='".$rc_seq."' ";
		$dt=dbone($sql2);

		$sarr=explode(",",$dt["RC_SOURCE"]);
		$starr=explode(",",$dt["RC_SOURCETIT"]);
		$rc_source=$rc_sourcetit="";
		for($i=0;$i<count($sarr);$i++)
		{
			if($sarr[$i]==$rc_code)
			{
			}
			else
			{
				if($sarr[$i])
				{
					$rc_source.=",".$sarr[$i];
				}
				else
				{
					$rc_source.=",";
				}

				if($starr[$i])
				{
					$rc_sourcetit.=",".$starr[$i];
				}
				else
				{
					$rc_sourcetit.=",";
				}				
			}
		}
		$rc_source=str_replace(",,",",",$rc_source);
		$rc_sourcetit=str_replace(",,",",",$rc_sourcetit);



		$sql=" update ".$dbH."_recipemedical set rc_source='".$rc_source."', rc_sourcetit='".$rc_sourcetit."' where rc_seq='".$rc_seq."'";
		//dbcommit($sql);

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);


		$json["sarr"]=$sarr;
		$json["starr"]=$starr;

		$json["rc_source"]=$rc_source;
		$json["rc_sourcetit"]=$rc_sourcetit;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		
	}
?>