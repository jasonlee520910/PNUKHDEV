<?php
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicine=$_GET["medicine"];
	if($apicode!="caremedicine"){$json["resultMessage"]="API코드오류";$apicode="caremedicine";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($medicine==""){$json["resultMessage"]="medicine 없음";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$sweet=$_GET["sweet"];
		$rc_medicine=$medicine;
		$rc_sweet=$sweet;

		if($rc_medicine){
			$arr=explode("|",$rc_medicine);
			$medicode="";$medicapa=0;
			for($i=1;$i<count($arr);$i++){
				$arr2=explode(",",$arr[$i]);
				if($i>1)$medicode.=",";
				$medicode.="'".$arr2[0]."'";
				$medicapa+=$arr2[1];
			}
			if($medicode){
				$sql=" select a.md_code, a.md_title_".$language." md_title, b.mh_efficacy_".$language." mh_efficacy from ".$dbH."_medicine a inner join ".$dbH."_medihub b on a.md_code=b.mh_code where a.md_code in (".$medicode.")  order by field(a.md_code,".$medicode.")";
				$res=dbqry($sql);
				$medi=array();
				while($dt2=dbarr($res)){
					$addarray=array($dt2["md_code"]=>$dt2["md_code"]);
					$mdtitle[$dt2["md_code"]]=$dt2["md_title"];
					$mhefficacy[$dt2["md_code"]]=$dt2["mh_efficacy"];
				}
			}
			$poison=$dismatch=0;
			$json["medicine"]=array();
			for($i=1;$i<count($arr);$i++){
				if($arr[$i]!=""){
					$arr2=explode(",",$arr[$i]);
					if($mdpoison[$arr2[0]]=="Y")$poison++;
					if($mddismatch[$arr2[0]]=="Y")$dismatch++;
					$medicine=array("rcMedicode"=>$arr2[0], "rcMedititle"=>$mdtitle[$arr2[0]], "rcEfficacy"=>$mhefficacy[$arr2[0]]);
					array_push($json["medicine"], $medicine);
				}
			}
		}

		$json["rcSweet"]=$rc_sweet;
		$arr=array("","9980,0,inlast","9985,0,inlast","9986,0,inlast");
		if($rc_sweet){
			$arr=explode("|",$rc_sweet);
		}
		$medicode="";
		for($i=1;$i<count($arr);$i++){
			$arr2=explode(",",$arr[$i]);
			if($i>1)$medicode.=",";
			$medicode.="'".$arr2[0]."'";
		}
		if($medicode){
			$sql=" select * from ".$dbH."_medicine where md_code in (".$medicode.")  order by field(md_code,".$medicode.")";
			$res=dbqry($sql);
			$medi=array();
			while($dt2=dbarr($res)){
				$addarray=array($dt2["md_code"]=>$dt2["md_title_".$language]);
				$mdtitle[$dt2["md_code"]]=$dt2["md_title_".$language];
			}
		}
		//저장된 후하재료

		$json["sweet"]=array();
		for($i=1;$i<count($arr);$i++){
			$arr2=explode(",",$arr[$i]);
			if($arr2[1]>0){
				$medicine=array("rcMedicode"=>$arr2[0], "rcMedititle"=>$mdtitle[$arr2[0]]);
				array_push($json["sweet"], $medicine);
			}
		}

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
