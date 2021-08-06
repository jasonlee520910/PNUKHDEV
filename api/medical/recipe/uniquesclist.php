<?php  
	///추천처방
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="uniquesclist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="uniquesclist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$search=urldecode($_GET["searchTxt"]); ///검색단어
		$orderby=$_GET["orderby"]; ///orderby

		$jsql=" a left join ".$dbH."_recipebook b on a.rc_source=b.rb_code ";
		//$wsql=" where a.rc_use = 'Y' and a.rc_userid = '2172498925' ";   ///2172498925 -> han_recipemember 의 rc_userid 값
		$wsql=" where a.rc_use = 'Y' ";   

		if($search)  ///검색단어
		{
			$wsql.=" and a.rc_title_".$language." like '%".$search."%'  "; //처방명
		}

		$pg=apipaging("a.rc_code","recipemember",$jsql,$wsql);
/*
		$sql=" select ";
		$sql.=" distinct(a.rc_seq) rcSeq, a.rc_chub, a.rc_code rcCode, a.rc_source rcSource, a.rc_sourcetit rcSourcetit ";
		$sql.=" ,a.rc_title_kor rcTitle,  a.rc_detail_kor rcDetail ";
		$sql.=" ,a.rc_medicine rcMedicine, a.rc_tingue_kor rcTingue, a.rc_status rcStatus ";
		$sql.=" ,a.rc_date rcDate ";
		$sql.=" ,a.rc_maincure_kor rcMaincure, a.rc_efficacy_kor rcEfficacy";
		$sql.=" ,b.rb_seq, b.rb_title_kor rbSourcetxt, b.rb_index_kor rbIndex ";
		$sql.=" from ".$dbH."_recipemember $jsql $wsql ";
		$sql.=" order by a.rc_date desc ";
		$sql.=" limit ".$pg["snum"].", ".$pg["psize"];  
*/
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
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_title_kor ".$orderbyno.") NUM ";
		$sql.=" ,a.rc_seq as RCSEQ, a.rc_chub, a.rc_code as RCCODE, a.rc_source as RCSOURCE, a.rc_sourcetit as RCSOURCETIT ";
		$sql.=" ,a.rc_title_kor RCTITLE,a.rc_title_chn RCTITLECHN,  a.rc_detail_kor RCDETAIL ";
		$sql.=" ,a.rc_medicine RCMEDICINE, a.rc_tingue_kor RCTINGUE, a.rc_status RCSTATUS ";
		$sql.=" ,a.rc_date rcDate ";
		$sql.=" ,a.rc_maincure_kor RCMAINCURE, a.rc_efficacy_kor RCEFFICACY";
		$sql.=" ,b.rb_seq, b.rb_title_kor RBSOURCETXT, b.rb_index_kor RBINDEX ";
		$sql.=" from ".$dbH."_recipemember  $jsql $wsql  ";
		$sql.=" ORDER BY a.rc_title_kor ".$orderbyno." ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
///echo $sql;

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["pg"]=$pg;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		$no=1;
		while($dt=dbarr($res))
		{
			///------------------------------------------------------------
			/// DOO :: 약재정보 이름으로 보여지기 위한 쿼리 추가 
			///------------------------------------------------------------

			$rcMedicine111 = getClob($dt["RCMEDICINE"]); //한자리만 자르기 //HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcMedicine222 = substr(($rcMedicine111), 1); //한자리만 자르기 //HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcMedicine = str_replace(" ", "", $rcMedicine222);//빈공간있으면 일단은 삭제
			$rcMedicine = str_replace("↵", "", $rcMedicine222);//빈공간있으면 일단은 삭제
			$rcMedicineTxt = getMedicine($rcMedicine, 'list');
			//$djmedicode = getMedicine_test($rcMedicine, 'list');
			//------------------------------------------------------------


			//$rcMedicine = substr(getClob($dt["RCMEDICINE"]), 1); ///한자리만 자르기 
			//$rcMedicineTxt = getMedicine($rcMedicine, 'list');
			///------------------------------------------------------------
			$arr=explode("|",$rcMedicine);///약재갯수(약미)
			if($dt["RB_SEQ"])
			{
				
				$sourceTxt=$dt["RBSOURCETXT"];
				$sourceIndex=$dt["RBINDEX"];
			}
			else
			{
				$sourceTxt=$dt["RCSOURCETIT"];
				$sourceIndex=$dt["RCSOURCE"];
			}

			if($pg["snum"]==0)
			{
				$noindex=$no;
			}
			else
			{
				$noindex=(($page-1)*10)+$no;
			}
			$addarray = array(
					"no"=>$noindex, ///no
					"seq"=>$dt["RCSEQ"], 
					"chartno"=>$dt["RCCODE"], 
					"patient"=>$dt["RCSOURCE"], 
					"rcTitle"=>$dt["RCTITLE"], 
					//"rcTitle"=>$dt["RCTITLE"]."/".$dt["RCTITLECHN"], 
					//"rcTitlechn"=>$dt["RCTITLECHN"], 

				

					"sourceTxt"=>$sourceTxt, 
					"sourceIndex"=>$sourceIndex, 
					"rcMedicine111"=>$rcMedicine111,
					"rcMedicine222"=>$rcMedicine222,
						
					"rcMedicine222"=>$rcMedicine222,

					"chub"=>"1", 

					//"rcMedicineTxt"=>$rcMedicineTxt, 

					"rcMedicine"=>$rcMedicine, 
						


					"RCDETAIL"=>getClob($dt["RCDETAIL"]),
					"RCEFFICACY"=>getClob($dt["RCEFFICACY"]), 
					"lastdate"=>$dt["RC_CHUB"] ///첩수

				/*
					"seq"=>$dt["RCSEQ"], 
					"rcCode"=>$dt["RCCODE"], 
					"rcSource"=>$dt["RCSOURCE"], 
					"rcTitle"=>$dt["RCTITLE"], 
					"rcDetail"=>getClob($dt["RCDETAIL"]), ///복용법/효과
					"rc_chub"=>$dt["RC_CHUB"], ///첩수

					"rcEfficacy"=>getClob($dt["RCEFFICACY"]), ///효능/주치 
					"rcMaincure"=>getClob($dt["RCMAINCURE"]), ///주치 
					
					"rcMedicine"=>$rcMedicine, 
					"rcMedicineTxt"=>$rcMedicineTxt,
					"rcMedicineCnt"=>count($arr),  
					"rcTingue"=>$dt["RCTINGUE"], 
					"rcStatus"=>$dt["RCSTATUS"], 
					"rbSourcetxt"=>$sourceTxt 
					///"rbIndex"=>$sourceIndex 
				*/
	
					);
					$no++;
			array_push($json["list"], $addarray);
		}
		$json["search"]=$search;
		$json["orderby"]=$orderby;
		
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>