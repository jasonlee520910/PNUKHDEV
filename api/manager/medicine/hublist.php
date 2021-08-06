<?php  
	///약재관리 > 본초관리 > 본초관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="hublist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="hublist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"search"=>$search,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"]; //검색단어
		$searchpop=$_GET["searchPop"];

		//$jsql=" a left join ".$dbH."_file f on a.mh_code=f.af_fcode and f.af_code='medihub' and f.af_use='Y' ";
		$jsql=" a  ";
		$jsql.=" left join ".$dbH."_code c  on a.mh_poison=c.cd_code and c.cd_type='mhPoison' ";

		$wsql=" where a.mh_use <>'D' ";
		if($search){
			$wsql.=" and mh_title_".$language." like '%".$search."%'  ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.mh_title_".$language." like '%".$searchtxt."%' ";///본초명
			$wsql.=" or ";
			$wsql.=" a.mh_code like '%".$searchtxt."%' ";///본초코드
			$wsql.=" or ";
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
				$wsql.=" a.mh_title_".$language." like '%".$seardata."%' ";//본초명
				$wsql.=" or ";
				$wsql.=" a.mh_code like '%".$seardata."%' ";//본초코드
				$wsql.=" or ";
				///$wsql.=" a.mh_stitle_".$language." like '%".$seardata."%' ";//학명
				///$wsql.=" or ";
				///$wsql.=" a.mh_ctitle_".$language." like '%".$seardata."%' ";//과명 
				///$wsql.=" or ";
				$wsql.=" a.mh_dtitle_".$language." like '%".$seardata."%' ";//이명 
				$wsql.=" ) ";
			}
		}


		$pg=apipaging("a.mh_code","medihub",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.mh_seq) NUM ";
		$sql.=" ,(select * from (select af_url from ".$dbH."_file where a.mh_code=af_fcode and af_code='medihub' and af_use='Y' order by af_seq desc) where rownum <= 1)
				as AFURL ";
		$sql.=" ,a.mh_seq, a.mh_code ";
		$sql.=" ,a.mh_title_".$language." as mhTitle ,to_char(a.mh_stitle_".$language.") as MHSTITLE ,to_char(a.mh_dtitle_".$language.") as MHDTITLE ";
		$sql.=" ,to_char(a.mh_ctitle_".$language.") as mhCtitle, a.mh_poison as mhPoison ,to_char(a.mh_Efficacy_".$language.") as MHEFFICACY,a.mh_state as MHSTATE";
		$sql.=" ,a.mh_taste as mhTaste, a.mh_object as mhObject ";
		//$sql.=" ,f.af_url as afUrl";
		$sql.=" ,c.cd_code , c.cd_name_".$language." as poisontxt "; 			
		$sql.=" from ".$dbH."_medihub $jsql $wsql  ";
		$sql.=" group by a.mh_seq, a.mh_code,a.mh_title_".$language.",to_char(a.mh_stitle_".$language."),to_char(a.mh_dtitle_".$language.")";
		$sql.=" ,to_char(a.mh_ctitle_".$language."), a.mh_poison,to_char(a.mh_Efficacy_".$language."),a.mh_state ,a.mh_date";
		$sql.=" ,a.mh_taste, a.mh_object , c.cd_code , c.cd_name_".$language." "; 		
		$sql.=" order by a.mh_date desc  ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];   

		$res=dbqry($sql);
		$json["sql"]=$sql;

		$json["pg"]=$pg;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{	
			///성미귀경 한글 텍스트 가져오기 
			$tmh_state=substr(trim($dt["MHSTATE"]),1);
			$tmh_taste=substr(trim($dt["MHTASTE"]),1);
			$tmh_object=substr(trim($dt["MHOBJECT"]),1);

			$mhObjecttext=$mhTastetext=$mhStatetext="";

			if($tmh_state)
			{
				$mhStatetext = hancodetext($tmh_state,"mhState");
			}
			if($tmh_taste)
			{
				$mhTastetext = hancodetext($tmh_taste,"mhTaste");
			}
			if($tmh_object)
			{
				$mhObjecttext = hancodetext($tmh_object,"mhObject");
			}

			$afFile=getafFile($dt["AFURL"]);
			$afThumbUrl=getafThumbUrl($dt["AFURL"]);
			
			if($dt["MHEFFICACY"]){$mhefficacy=$dt["MHEFFICACY"];}else{$mhefficacy="-";}
			if($dt["MHSTITLE"]){$mhstitle=$dt["MHSTITLE"];}else{$mhstitle="-";}
			if($dt["MHDTITLE"]){$mhdtitle=$dt["MHDTITLE"];}else{$mhdtitle="-";}

			$addarray=array(
				"seq"=>$dt["MH_SEQ"], ///본초코드
				"mhCode"=>$dt["MH_CODE"], ///약제코드
				"mhTitle"=>$dt["MHTITLE"], ///본초명
				"mhStitle"=>$mhstitle, ///학명
				"mhDtitle"=>$mhdtitle, ///이명
				"mhCtitle"=>$mhctitle, ///과명
				"mhPoison"=>$dt["MH_POISON"], ///중독코드
				"mhPoisonText"=>$dt["POISONTXT"], ///중독 코드 text
				"mhEfficacy"=>$mhefficacy, ///효능효과
				"mhStatetext"=>$mhStatetext, ///성  
				"mhTastetext"=>$mhTastetext, ///미
				"mhObjecttext"=>$mhObjecttext, ///귀경
				"afUrl"=>$afUrl, 
				"afThumbUrl"=>$afThumbUrl, 
				"afFile"=>$afFile
			);
			array_push($json["list"], $addarray);

		}

		$json["searchtxt"] =$searchtxt;
		$json["sql"]=$sql;
		$json["sql1"]=$sql1;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	///han_code name 가져오기
	function hancodetext($medicode,$cdtype)
	{
		global $dbH;
		$sql="";
		$medititle="";
		if($medicode)
		{
			$dm_medi=explode(",",$medicode);
			$dm_medi_len=count($dm_medi);

			for($i=0;$i<$dm_medi_len;$i++)
			{			
				$sql=" select LISTAGG(cd_name_kor,',') as codename  from ".$dbH."_code where cd_type='".$cdtype."' and cd_code in ('".$dm_medi[$i]."') ";
				$res=dbqry($sql);
				while($hub=dbarr($res))
				{
					if($medititle!="")$medititle.=",";
					$medititle.=$hub["CODENAME"];
				}				
			}
		}
		return $medititle;
	}
?>