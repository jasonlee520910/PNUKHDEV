<?php
	/// 환경설정 > 코드관리 > 리스트 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["code"];
	$type=$_GET["type"];

	if($apiCode!="selsuborder"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="selsuborder";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else if($type==""){$json["resultMessage"]="API(type) ERROR";}
	else{
		
		$json["seq"]=$seq=$_GET["seq"];
		$type=$_GET["type"];
		$json["code"]=$code;
		switch($code){
			case "packing":
				$sql=" select gd_bomcode from ".$dbH."_goods where gd_seq='".$seq."'";
				$dt=dbone($sql);
				$bomcode=explode(",",$dt["GD_BOMCODE"]);
				$gdcode="";
				foreach($bomcode as $val){
					if($gdcode)$gdcode.=",";
					$arr=explode("|",$val);
					if($arr[0]){
						$gdcode.="'".$arr[0]."'";
					}
				}
				$wsql=" where a.gd_type = 'material' and a.gd_code in (".$gdcode.") ";
				$sql=" select a.gd_code CDCODE, a.gd_name_".$language." CDNAME ";
				$sql.=" from ".$dbH."_goods a $jsql $wsql  ";
				break;
			case "concent":
				$jsql=" a ";
				$wsql=" where a.cd_type in ('pillRatio','pillTime') ";//비율시간
				$sql=" select a.cd_code CDCODE, a.cd_name_".$language." CDNAME ";
				$sql.=" from ".$dbH."_code $jsql $wsql  ";
				break;
			case "dry": case "ferment": case "warmup":
				$jsql=" a ";
				$wsql=" where a.cd_type in ('pillTemperature','pillTime') ";//온도시간
				$sql=" select a.cd_code CDCODE, a.cd_name_".$language." CDNAME ";
				$sql.=" from ".$dbH."_code $jsql $wsql  ";
				break;
			case "juice":
				$jsql=" a ";
				$wsql=" where a.cd_type in ('useY') ";//사용함
				$sql=" select a.cd_code CDCODE, a.cd_name_".$language." CDNAME ";
				$sql.=" from ".$dbH."_code $jsql $wsql  ";
				break;
			default:
				$jsql=" a ";
				$wsql=" where a.cd_type = '".$type."' ";
				$sql=" select a.cd_code CDCODE, a.cd_name_".$language." CDNAME ";
				$sql.=" from ".$dbH."_code $jsql $wsql  ";
		}
		$res=dbqry($sql);

		$json["sql"]=$sql;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$addarray=array(
				"cdCode"=>$dt["CDCODE"], /// 코드
				"cdCodeTxt"=>$dt["CDNAME"]///코드명
			);
			array_push($json["list"], $addarray);
		}

		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>