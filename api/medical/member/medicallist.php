<?php

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	
	
	if($apiCode!="medicallist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicallist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searchtxt=$_GET["medicalsearchTxt"];	

		$jsql=" a ";
		$jsql.=" inner join ".$dbH."_member b on a.mi_userid = b.me_company and me_grade='30' ";  //원장님만

		$wsql=" where  a.mi_use='Y' and b.me_use='Y' and a.mi_status='confirm' ";  //서류확인이 된 한의원만 나온다.

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.mi_name like '%".$searchtxt."%' ";///본초명
			//$wsql.=" or ";
			//$wsql.=" a.mh_dtitle_".$language." like '%".$searchtxt."%' ";///이명 
			$wsql.=" ) ";
		}

		$pg=apipaging("a.mi_seq","medical",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (order by a.mi_name ) NUM ";
		$sql.=" ,a.mi_name,a.mi_businessno, a.mi_address ,a.mi_userid,b.me_name,b.me_company";
		$sql.=" from ".$dbH."_medical $jsql $wsql  ";
		$sql.=" order by a.mi_name ";
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


			/*--------------------------------------------------------- 
			//member 상태값 정리(20200812) 	
			apply - 회원가입만 한 상태
			emailauth-이메일인증은 한 상태 
			approve - 면허증을 올린 상태
			request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
			standby - 소속한의사가 한의원을 찾아 승인전 상태
			confirm - 정회원(우리병원 소속 한의사)
			--------------------------------------------------------*/	

			$addarray=array(
				"standbyBtn"=>"<button type='button' class='btn bg-blue color-white radius' style='font-size:12px;padding:3px 5px;height:20px;width:150px;background:#04B486;' onclick='gostandby(\"".$dt["MI_USERID"]."\");'>해당 한의원에 등록</button>",
				"miName"=>$dt["MI_NAME"], ///seq
				"miBusinessno"=>$dt["MI_BUSINESSNO"], 
				"miAddress"=>$dt["MI_ADDRESS"], 
				"meName"=>$dt["ME_NAME"]

				
			);
			array_push($json["list"], $addarray);
		}

		$json["sql"] = $sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>