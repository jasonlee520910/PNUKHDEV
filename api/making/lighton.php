<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$ma_table=$_GET["maTable"];
	$selectbox=$_GET["selectbox"];
	$refer="djmedi";

	if($apicode!="lighton"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="lighton";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($ma_table==""){$json["resultMessage"]="API(TableNo) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$sql=" select mg_statustext from ".$dbH."_makinglog where mg_command='004' and mg_status='end' and mg_tableno='".$ma_table."' and mg_use='Y' ";
		$dt=dbone($sql);
		$arr=explode("u0005",getClob($dt["MG_STATUSTEXT"]));
		$i=0;
		$medibox="";
		$json["arr"]=$arr;
		foreach($arr as $val){
			if($i>0){
				$tbl=explode(",",$val);
				if($medibox!="")$medibox.=",";
				//$boxno[trim($tbl[3])]="".trim($tbl[1])."";
				$boxno[trim($tbl[1])]="".trim($tbl[3])."";
				$medibox.="'".trim($tbl[3])."'";
			}
			$i++;
		}

		$json["medibox"]=$medibox;

		if($medibox)
		{
			$sql=" select md_code, mm_title_".$language." mm_title, mb_code from han_medicine_".$refer." a ";
			$sql.="	inner join han_medibox b on a.md_code=b.mb_medicine where mb_code in (".$medibox.") ";
			$json["tableInfosql"]=$sql;

			$res=dbqry($sql);
			while($dt=dbarr($res)){
				$tableno=array_search($dt["MB_CODE"], $boxno);
				//$tableno=$boxno[trim($dt["mb_code"])];
				$json["tableInfo"][trim($dt["MB_CODE"])]=array("no"=>$tableno,"code"=>$dt["MD_CODE"],"name"=>$dt["MM_TITLE"]);
			}
		}

		//20190415:조제대약재함에 처방한 약재가 없는지 체크하여 있으면 약재이름을 보내준다. 
		if($selectbox)
		{
			$tmpSelectBox=str_replace(",","','",$selectbox);
			$sql=" select a.md_code, a.mm_title_".$language." mm_title, b.mb_code from han_medicine_".$refer." a ";
			$sql.="	inner join han_medibox b on a.md_code=b.mb_medicine where b.mb_code in ('".$tmpSelectBox."') ";
			$json["selectboxsql"]=$sql;
			$res=dbqry($sql);


			while($dt=dbarr($res)){
				$json["selectInfo"][trim($dt["MB_CODE"])]=array("code"=>$dt["MD_CODE"],"name"=>$dt["MM_TITLE"]);
			}

			$skey = array_keys($json["selectInfo"]);
			$tkey = array_keys($json["tableInfo"]);
			$rkey = array_diff($skey, $tkey);

			$json["skey"]=$skey;
			$json["tkey"]=$tkey;


			$noneMediBoxName="";
			foreach($json["selectInfo"] as $key=>$value)
			{
				foreach($rkey as $rvalue)
				{
					if($key == $rvalue)
					{
						$noneMediBoxName.=",".$value["name"];
					}
				}
			}

			$json["noneMediBoxName"]=($noneMediBoxName) ? substr($noneMediBoxName, 1) : "";
		}

		$json["boxno"]=$boxno;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>