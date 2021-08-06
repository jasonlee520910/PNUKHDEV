<?php  
	///처방하기> 처방추가 버튼 클릭시 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$medicalId=$_GET["medicalId"]; ///한의원
	$doctorId=$_GET["doctorId"]; ///한의사 
	$meGrade=$_GET["meGrade"]; ///한의사등급 (소속한의사인지)
	

	if($apiCode!="medicalsclist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="medicalsclist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$search=$_GET["searchTxt"]; ///검색단어

		$jsql.=" a left join ".$dbH."_order c on a.rc_code=c.od_scription ";
		$jsql.=" inner join ".$dbH."_medical m on c.od_userid=m.mi_userid ";
		$jsql.=" left join ".$dbH."_release d on c.od_code=d.re_odcode ";

		if($meGrade=="30")
		{
			$wsql=" where a.rc_use <>'D'  and m.mi_userid='".$medicalId."' "; ///해당 한의원의 이전처방만 보이게 작업함
		}
		else
		{
			$jsql.=" inner join ".$dbH."_member e on c.od_staff=e.me_userid ";
			$wsql=" where a.rc_use <>'D' and m.mi_userid='".$medicalId."' and e.me_userid='".$doctorId."' "; ///해당 한의원의 소속한의사 처방만 
		}

		if($search)
		{
			$wsql.=" and ( ";
			$wsql.=" d.re_name like '%".$search."%' ";///환자명
			$wsql.=" or ";
			$wsql.=" m.mi_name like '%".$search."%' ";///한의원
			$wsql.=" or ";
			$wsql.=" a.rc_title_".$language." like '%".$search."%' ";///처방명 
			$wsql.=" ) ";
		}

		$pg=apipaging("a.rc_code","recipeuser",$jsql,$wsql);

		$ssql=" a.rc_seq rcSeq, a.rc_code rcCode, a.rc_title_kor as RCTITLE,a.rc_medicine as RCMEDICINE ";
		$ssql.=" ,a.rc_sweet rcSweet ";	
		$ssql.=" ,to_char(a.rc_date,'yyyy-mm-dd') as RCDATE ";
		$ssql.=" ,m.mi_name miName, d.re_name as MEDINAME ";


		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_date) NUM ";
		$sql.=" ,$ssql ";					
		$sql.=" from ".$dbH."_recipeuser $jsql $wsql  ";		
		$sql.=" order by a.rc_date desc  ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];   

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["search"]=$search;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$odMedicine=getClob($dt["RCMEDICINE"]);
			$arr=explode("|",$odMedicine);///약재갯수(약미)

			$addarray=array(
				"seq"=>$dt["RCSEQ"],
				"rcCode"=>$dt["RCCODE"],
				"mediName"=>$dt["MEDINAME"],///환자명
				"rcTitle"=>$dt["RCTITLE"],///방제명 
				"odMedicineCnt"=>count($arr)-1,//약미 
				"odDate"=>$dt["RCDATE"]   ///처방일자
				);
			array_push($json["list"], $addarray);
		}
		
		$json["search"]=$search;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>