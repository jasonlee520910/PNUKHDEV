<?php  
	/// 자재코드관리 > 포장재관리 > 상세보기
	/// 사용자관리 > 한의원관리 상세보기 > 등록&수정	
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$pb_seq=$_GET["seq"];
	if($apiCode!="packingdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="packingdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($pb_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$hCodeList = getNewCodeTitle("pbType,miGrade,mrDesc");
		$pbTypeList = getCodeList($hCodeList, 'pbType');//포장재분류  
		$pbGradeList = getCodeList($hCodeList, 'miGrade'); //등급
		$mrDescList = getCodeList($hCodeList, 'mrDesc'); //마킹내용 

		if($pb_seq)
		{
			$jsql=" a left join ".$dbH."_medical b on a.pb_member=b.mi_userid ";
			$wsql=" where a.pb_seq = '".$pb_seq."' ";

			$sql=" select a.pb_grade,a.pb_seq,a.pb_codeonly,a.pb_code,a.pb_type,a.pb_title,a.pb_member ";
			$sql.=", a.pb_price,a.pb_pricea,a.pb_priceb,a.pb_pricec,a.pb_priced,a.pb_pricee,a.pb_capa,a.pb_volume,a.pb_maxcnt,a.pb_staff";
			$sql.=", a.pb_desc ";
			$sql.=", to_char(a.PB_DATE,'yyyy-mm-dd') as PB_DATE ";
			$sql.=", b.mi_userid, b.mi_name";
			$sql.=", (select cd_name_kor from han_code where cd_type='pbType' and cd_code = a.pb_type) as pbTypeName ";
			$sql.=" from ".$dbH."_packingbox $jsql $wsql ";		
			$dt=dbone($sql);

			$miUser=str_replace(",","','",$dt["PB_MEMBER"]);
			$subsql=" select mi_userid, mi_name from ".$dbH."_medical where mi_userid in ('".$miUser."')";
			$subres=dbqry($subsql);
			$mi_userid=$mi_name="";

			while($subdt=dbarr($subres))
			{
				if($mi_userid)$mi_userid.=",";
				$mi_userid.=$subdt["MI_USERID"];
				if($mi_name)$mi_name.=",";
				$mi_name.=$subdt["MI_NAME"];
			}

			$pb_member=explode(",",$dt["PB_MEMBER"]);
			$pbMember=$pbAll="";
			foreach($pb_member as $val)
			{
				if($pbMember!="")$pbMember.=",";
				if($pb_member[0]=="all")
				{
					$pbAll="all";
				}
				else
				{
					$pbAll="none";
				}
			}
			$json=array(
				"mrDescList"=>$mrDescList,///마킹리스트 
				"pbGradeList"=>$pbGradeList,  ///등급 A,B,C,D,E			
				"pbGrade"=>$dt["PB_GRADE"], ///포장재 등급
				"pb_member0"=>$pb_member[0], 
				"seq"=>$dt["PB_SEQ"], 
				"pbchk"=>$dt["PB_CODEONLY"],  ///코드만마킹
				"pbCode"=>$dt["PB_CODE"], 
				"pbType"=>$dt["PB_TYPE"], 
				"pbTypeName"=>$dt["PBTYPENAME"], 
				"pbTitle"=>$dt["PB_TITLE"], 
				"pbPrice"=>$dt["PB_PRICE"], 

				"pbPriceA"=>$dt["PB_PRICEA"], 
				"pbPriceB"=>$dt["PB_PRICEB"], 
				"pbPriceC"=>$dt["PB_PRICEC"], 
				"pbPriceD"=>$dt["PB_PRICED"], 
				"pbPriceE"=>$dt["PB_PRICEE"], 

				"pbCapa"=>$dt["PB_CAPA"], 

				"pbVolume"=>$dt["PB_VOLUME"], ///부피
				"pbMaxcnt"=>$dt["PB_MAXCNT"], ///최대팩수

				"pbAll"=>$pbAll, 
				"pbStaff"=>$dt["PB_STAFF"], 
				"pbDesc"=>getClob($dt["PB_DESC"]), 
				"pbDate"=>$dt["PB_DATE"], 
				"miUserid"=>$mi_userid,
				"miName"=>$mi_name ///한의원 이름 
				);

			//등록된 이미지들 
			$sql2=" select af_seq, af_name, af_url as afUrl from ".$dbH."_file where af_use='Y' and af_code='packingbox' and af_fcode='".$dt["PB_CODE"]."' order by af_no desc ";
			$res=dbqry($sql2);

			$json["afFiles"]=array();
			for($i=0;$dt=dbarr($res);$i++)
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(
					"afseq"=>$dt["AF_SEQ"], 
					"afCode"=>$dt["AF_CODE"], 
					"afThumbUrl"=>$afThumbUrl, 
					"afUrl"=>$afFile, 
					"afName"=>$dt["af_name"], 
					"afSize"=>$dt["af_size"]
				);
				array_push($json["afFiles"], $addarray);
			}
			//포장재분류 
			$json["pbTypeList"] = $pbTypeList;
		}
		else
		{
			$json["mrDescList"] = $mrDescList;  
			$json["pbGradeList"] = $pbGradeList;  //등급 A,B,C,D,E
			$json["pbTypeList"] = $pbTypeList;
		}
		$json["pb_seq"]=$pb_seq;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["subsql"]=$subsql;
		
$json["miUser"]=$miUser;
$json["PB_MEMBER123"]=$dt["PB_MEMBER"];
	}
?>