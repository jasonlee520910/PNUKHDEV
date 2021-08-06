<?php
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="textdbupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="textdbupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$td_seq=$_POST["seq"];
		$td_code=$_POST["tdCode"];
		$td_name_kor=addslashes($_POST["tdNameKor"]);
		$td_name_chn=addslashes($_POST["tdNameChn"]);
		$td_name_eng=addslashes($_POST["tdNameEng"]);
		$txtType=$_POST["txtType"];
		$returnData=$_POST["returnData"];
		
		
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$json["td_seq"]=$td_seq;

		if($td_seq&&$td_seq!="add")
		{
			$sql=" update ".$dbH."_txtdata set td_name_kor='".$td_name_kor."',td_name_chn='".$td_name_chn."',td_name_eng='".$td_name_eng."',td_modify=sysdate where td_seq='".$td_seq."'";
			dbcommit($sql);
			$json["usql"]=$sql;
			$json["txtType"]=$txtType;
		}
		else
		{
			if($td_seq=="add")
			{
				//1000~ manager
				//5000~ care
				//7000~ medical 
				switch($txtType)
				{
				case "0"://tbms - 새로 등록한것들은 9000번대로 등록하게 하자 
					$sql=" select MAX(td_code) as code from han_txtdata where td_type='0' and substr(td_code,1, 1)='9' order by td_code desc ";
					$td_type="0";
					break;
				case "1": //manager,
					$sql=" select MAX(td_code) as code from han_txtdata where td_type='1' and substr(td_code,1, 1) in ('1','2','3','4') order by td_code desc ";
					$td_type="1";
					break;
				case "5": case "7"://care, medical 
					$sql=" select MAX(td_code) as code from han_txtdata where td_type='1' and substr(td_code,1, 1) = '".$txtType."' order by td_code desc ";
					$td_type="1";
					break;
				}
				
				$dt=dbone($sql);
				if($txtType=="0")
				{
					if(intVal($dt["CODE"]) < 9000)
					{
						$td_code=9000;
					}
					else
					{
						$td_code=intVal($dt["CODE"])+1;
					}
				}
				else
				{
					$td_code=intVal($dt["CODE"])+1;
				}

				$sql=" insert into ".$dbH."_txtdata (td_seq, td_code,td_type, td_name_kor,td_name_chn,td_name_eng,td_date) values ((SELECT NVL(MAX(td_seq),0)+1 FROM ".$dbH."_txtdata),'".$td_code."','".$td_type."', '".$td_name_kor."','".$td_name_chn."','".$td_name_eng."',sysdate) ";
				dbcommit($sql);
				$json["isql"]=$sql;
				$json["txtType"]=$txtType;
				
			}
		}

		//파일생성하자 
		$fsql=" select td_code, td_type, substr(td_code,1, 1) as tCode, td_name_kor, td_name_chn, td_name_eng  from ".$dbH."_txtdata where td_use='Y' order by td_code asc ";
		$fres=dbqry($fsql);

		$addkor0=array();
		$addchn0=array();
		$addeng0=array();

		$addkor1=array();
		$addchn1=array();
		$addeng1=array();

		$addkor5=array();
		$addchn5=array();
		$addeng5=array();


		$addkor7=array();
		$addchn7=array();
		$addeng7=array();

		while($fdt=dbarr($fres)) 
		{
			$kor = ($fdt["TD_NAME_KOR"]) ? $fdt["TD_NAME_KOR"] : "";
			$chn = ($fdt["TD_NAME_CHN"]) ? $fdt["TD_NAME_CHN"] : "";
			$eng = ($fdt["TD_NAME_ENG"]) ? $fdt["TD_NAME_ENG"] : "";

			if($fdt["TD_TYPE"]=="0")//tbms - 나중에 이것은 9000번대로 바꿔야함..등록은 9000번대로 등록됨 
			{
				$addkor0[$fdt["TD_CODE"]]=urlencode($kor);
				$addchn0[$fdt["TD_CODE"]]=urlencode($chn);
				$addeng0[$fdt["TD_CODE"]]=urlencode($eng);
			}
			else
			{
				if(intVal($fdt["TCODE"]) < 5)//manager
				{
					$addkor1[$fdt["TD_CODE"]]=urlencode($kor);
					$addchn1[$fdt["TD_CODE"]]=urlencode($chn);
					$addeng1[$fdt["TD_CODE"]]=urlencode($eng);
				}
				else if(intVal($fdt["TCODE"])==5)//care
				{
					$addkor5[$fdt["TD_CODE"]]=urlencode($kor);
					$addchn5[$fdt["TD_CODE"]]=urlencode($chn);
					$addeng5[$fdt["TD_CODE"]]=urlencode($eng);
				}
				else if(intVal($fdt["TCODE"])==7)//medical 
				{
					$addkor7[$fdt["TD_CODE"]]=urlencode($kor);
					$addchn7[$fdt["TD_CODE"]]=urlencode($chn);
					$addeng7[$fdt["TD_CODE"]]=urlencode($eng);
				}
			}

		}

		$json["data"]=array(
			"txtkor0"=>$addkor0,
			"txtchn0"=>$addchn0,
			"txteng0"=>$addeng0,

			"txtkor1"=>$addkor1,
			"txtchn1"=>$addchn1,
			"txteng1"=>$addeng1,

			"txtkor5"=>$addkor5,
			"txtchn5"=>$addchn5,
			"txteng5"=>$addeng5,

			"txtkor7"=>$addkor7,
			"txtchn7"=>$addchn7,
			"txteng7"=>$addeng7
			);

		//$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>