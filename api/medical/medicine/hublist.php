<?php  
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="hublist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="hublist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$search=urldecode($_GET["searchTxt"]); ///검색단어
		$orderby=$_GET["orderby"]; ///orderby

		$jsql=" a ";

		$wsql=" where a.mh_use <>'D' ";

		if($search) 
		{
			$wsql.=" and a.mh_title_".$language." like '%".$search."%'  ";
		}

/*
		if($searchtxt)
		{
			///$carr=array("mhTitle","mhCode","mhStitle","mhCtitle","mhDtitle");
			///$tarr=array("본초명","본초코드","학명","과명","이명");
			$wsql.=" and ( ";
			$wsql.=" a.mh_title_".$language." like '%".$searchtxt."%' ";///본초명
			$wsql.=" or ";
			//$wsql.=" a.mh_code like '%".$searchtxt."%' ";///본초코드
			//$wsql.=" or ";
			$wsql.=" a.mh_stitle_".$language." like '%".$searchtxt."%' ";///학명
			$wsql.=" or ";
			$wsql.=" a.mh_ctitle_".$language." like '%".$searchtxt."%' ";///과명 
			$wsql.=" or ";
			$wsql.=" a.mh_dtitle_".$language." like '%".$searchtxt."%' ";///이명 
			$wsql.=" ) ";
		}

		if($searchpop){
			$arr=explode("|",$searchpop);
			foreach($arr as $val){
				$arr2=explode(",",$val);
				if($arr2[0]=="searchType")
				{
					$field=substr($arr2[1],0,2)."_".strtolower(substr($arr2[1],2,20));
				}
				if($arr2[0]=="searchTxt")
				{
					$seardata=$arr2[1];
				}
			}
			if($seardata)
			{
				$wsql.=" and ( ";
				$wsql.=" a.mh_title_".$language." like '%".$seardata."%' ";///본초명
				$wsql.=" or ";
				$wsql.=" a.mh_code like '%".$seardata."%' ";///본초코드
				$wsql.=" or ";
				///$wsql.=" a.mh_stitle_".$language." like '%".$seardata."%' ";///학명
				///$wsql.=" or ";
				///$wsql.=" a.mh_ctitle_".$language." like '%".$seardata."%' ";///과명 
				///$wsql.=" or ";
				$wsql.=" a.mh_dtitle_".$language." like '%".$seardata."%' ";///이명 
				$wsql.=" ) ";
			}
		}
		*/

		$pg=apipaging("a.mh_seq","hubdictionary",$jsql,$wsql);

		$orderbyno="";
		if(isEmpty($orderby))
		{
			$orderbyno="ASC";
		}
		else
		{		
			$orderbyno=$orderby;
		}

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.mh_seq ".$orderbyno.") NUM ";		
		$sql.=" ,a.mh_seq,a.mh_idx,a.mh_title_kor,a.mh_title_chn,a.mh_title_eng,a.mh_origin,a.mh_redefinition,a.mh_beginning,a.mh_stitle_kor,a.mh_dtitle_kor";
		//$sql.=" ,a.mh_ctitle_kor  "; 
		$sql.=" from ".$dbH."_hubdictionary $jsql $wsql  ";	
		$sql.=" order by a.mh_seq ".$orderbyno." ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"]; 

		//echo $sql;

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["pg"]=$pg;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["search"]=$search;
		$json["list"]=array();

		$no=1;
		while($dt=dbarr($res))
		{
			if($pg["snum"]==0)
			{
				$noindex=$no;
			}
			else
			{
				$noindex=(($page-1)*10)+$no;
			}
			$addarray=array(
				
				"no"=>$noindex, ///no
				"seq"=>$dt["MH_SEQ"], ///본초코드
				"mhTitle"=>$dt["MH_TITLE_KOR"]." / ".$dt["MH_TITLE_CHN"], ///본초명
				"mhOrigin"=>$dt["MH_ORIGIN"], ///본초명
				"mhRedefinition"=>getClob($dt["MH_REDEFINITION"]), ///설명

				"MH_STITLE_KOR"=>getClob($dt["MH_STITLE_KOR"]), ///학명
				//"mhCtitleKor"=>getClob($dt["MH_CTITLE_KOR"]), ///과명
				"mhDtitleKor"=>getClob($dt["MH_DTITLE_KOR"]) ///이명

				);
			
			array_push($json["list"], $addarray);
			$no++;

		}

		$json["search"]=$searchtxt;
		
		$json["sql1"]=$sql1;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>