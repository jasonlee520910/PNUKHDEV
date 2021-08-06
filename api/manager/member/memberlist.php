<?php  
	///주문리스트 > 한의원등록버튼 클릭시 pk가 없으면 한의원&한의사 리스트보여주자 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="memberlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="memberlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchpop=$_GET["searchPop"];

		$wsql=" where a.me_grade in ('22','30') and a.me_use <> 'D' and b.mi_use <> 'D' ";

		if($searchpop)
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0] == 'searpoptxt')//관리자에서 한의원 검색시 
				{
					$wsql.=" and (";
					$wsql.=" b.mi_name like '%".$arr2[1]."%' ";//한의원 이름
					$wsql.=" or ";
					$wsql.=" a.me_name like '%".$arr2[1]."%' and a.me_grade in ('30','22') "; //한의사&원장 
					$wsql.=") ";
				}
			}
		}

		
		$jsql=" a inner join ".$dbH."_medical b on b.mi_userid=a.me_company ";

		$ssql=" a.me_auth, a.me_idpk, a.me_userid, a.me_name, b.mi_userid, b.mi_name ";

		$pg=apipaging("a.me_seq","member",$jsql,$wsql);

		//$sql=" select $ssql from ".$dbH."_member $jsql $wsql order by a.me_seq desc limit ".$pg["snum"].", ".$pg["psize"];
		$sql="select * from ( ";
		$sql.=" select  ";
		$sql.=" ROW_NUMBER() OVER (ORDER BY a.me_seq desc) NUM,  ";
		$sql.=" $ssql ";
		$sql.=" from ".$dbH."_member ";
		$sql.=" $jsql ";
		$sql.=" $wsql ";		
		$sql.=" order by a.me_seq desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"me_auth"=>$dt["ME_AUTH"], //한의사PK 
				"me_userid"=>$dt["ME_USERID"], //한의사code
				"me_idpk"=>$dt["ME_IDPK"],//CY 한의사 pk 
				"me_name"=>$dt["ME_NAME"],//한의사이름
				"mi_userid"=>$dt["MI_USERID"], //한의원code
				"mi_name"=>$dt["MI_NAME"]//한의원명
				);
			array_push($json["list"], $addarray);
		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"] = $sql;
	}
?>