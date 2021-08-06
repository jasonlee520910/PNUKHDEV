<?php
	$json["resultCode"]="204";
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$td_seq=$_GET["seq"];
	if($apicode!="textdbdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="textdbdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($td_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$sql=" update ".$dbH."_txtdata set td_use='D' where td_seq='".$td_seq."' ";
		dbcommit($sql);

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

			if($fdt["td_type"]=="0")//tbms - 나중에 이것은 9000번대로 바꿔야함..등록은 9000번대로 등록됨 
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




		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>