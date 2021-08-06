<?php  
	///사용자관리 > 한의원관리 > 상세보기 > 포장재관리에서 공통 포장재 가져오기 (팝업)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$psize=$_GET["psize"];
	$block=$_GET["block"];
	$miUserid=$_GET["miUserid"];

	if($apiCode!="commpacking"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="commpacking";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$searchtxt=$_GET["searchTxt"];
		$searchpop=$_GET["searchPop"];

		$json["searchtxt"]=$_GET["searchTxt"];
		$json["searchpop"]=$_GET["searchPop"];

		$wsql=" where a.pb_use='Y' and pb_member like '%1000000000%' ";

		if($searchpop)
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0] == 'searpoptxt')///관리자에서 한의원 검색시 
				{
					$wsql.=" and (";
					$wsql.=" a.pb_code like '%".$arr2[1]."%' ";
					$wsql.=" or ";
					$wsql.=" a.pb_title like '%".$arr2[1]."%' ";
					$wsql.=") ";
				}
			}
		}

		///공통인것만 가져오기 
		$jsql=" a left join ".$dbH."_medical b on a.pb_member=b.mi_userid ";
		$jsql.=" left join ".$dbH."_file f on a.pb_code=f.af_fcode and f.af_code='packingbox' and f.af_use='Y' ";
		
		$pg=apipaging("pb_code","packingbox",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.pb_code) NUM ";
		$sql.=" ,a.pb_seq,a.pb_code, a.pb_type, a.pb_title, a.pb_member";
		$sql.=" ,to_char(a.pb_date,'yyyy-mm-dd') as PBDATE";
		///$sql.=" ,b.mi_name ";
		$sql.=" ,f.af_seq,f.af_url";
		$sql.=" ,(select cd_name_kor from han_code where cd_type='pbType' and cd_code = a.pb_type) as PBTYPENAME ";
		
		$sql.=" from ".$dbH."_packingbox $jsql $wsql ";
		$sql.=" group by a.pb_seq,a.pb_code, a.pb_type, a.pb_title, a.pb_member ,to_char(a.pb_date,'yyyy-mm-dd'),f.af_seq,f.af_url ";
		
		$sql.=" ORDER BY a.pb_code  ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"]; 

		$res=dbqry($sql);
		$json["sql"]=$sql.$searchstatus;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
	
		$json["list"] = array();

		while($dt=dbarr($res))
		{
			$afFile=getafFile($dt["AF_URL"]);
			$afThumbUrl=getafThumbUrl($dt["AF_URL"]);

			$addarray=array(
				"seq"=>$dt["PB_SEQ"], 
				"pbCode"=>$dt["PB_CODE"], 
				"pbType"=>$dt["PB_TYPE"], 
				"pbTypeName"=>$dt["PBTYPENAME"], 
				"pbTitle"=>$dt["PB_TITLE"], 
				"pbMember"=>$dt["PB_MEMBER"], 
				"pbDate"=>$dt["PBDATE"],
				"afSeq"=>$dt["AF_SEQ"],
				"afThumbUrl"=>$afThumbUrl,
				"afFile"=>$afFile
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>