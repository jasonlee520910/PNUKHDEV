<?php  
	///사용자관리 > 스탭관리 > 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$st_seq=$_GET["seq"];

	if($apiCode!="staffdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="staffdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($st_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$hCodeList = getNewCodeTitle("meStatus,stAuth,stDepart");

		$meStatusList = getCodeList($hCodeList, 'meStatus');
		$stAuthList = getCodeList($hCodeList, 'stAuth');
		$stDepartList = getCodeList($hCodeList, 'stDepart');
		
		if($st_seq)
		{
			$returnData=$_GET["returnData"];
			$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

			$jsql="";
			$wsql=" where st_seq = '".$st_seq."' ";
			$sql=" select * from ".$dbH."_staff a $jsql $wsql ";
			$dt=dbone($sql);

			$addr=explode("||",$dt["ST_ADDRESS"]);
			$phone=explode("-",$dt["ST_PHONE"]); ///전화번호
			$mobile=explode("-",$dt["ST_MOBILE"]); ///휴대폰번호
			$email=explode("@",$dt["ST_EMAIL"]); ///이메일

			$st_staffid=$dt["ST_STAFFID"];

			$json=array(

				"seq"=>$dt["ST_SEQ"], 
				"stStaffId"=>$dt["ST_STAFFID"], 
				"stUserId"=>$dt["ST_USERID"], 
				"stName"=>$dt["ST_NAME"], 
				"stAuth"=>$dt["ST_AUTH"], 
				"stDepart"=>$dt["ST_DEPART"], 
				"stZipCode"=>$dt["ST_ZIPCODE"], 
				"stAddress"=>$addr[0], ///주소
				"stAddress1"=>$addr[1],///상세주소
				
				"stPhone0"=>$phone[0], 
				"stPhone1"=>$phone[1],
				"stPhone2"=>$phone[2],

				"stMobile0"=>$mobile[0], 
				"stMobile1"=>$mobile[1], 
				"stMobile2"=>$mobile[2], 

				"stEmail0"=>$email[0], 
				"stEmail1"=>$email[1], 

				"stStatus"=>$dt["ST_STATUS"], 
				"stDate"=>$dt["ST_DATE"],
				"stMemo"=>$dt["ST_MEMO"],

				"meStatusList"=>$meStatusList, ///회원상태 리스트
				"stDepartList"=>$stDepartList, ///소속 리스트
				"stAuthList"=>$stAuthList ///회원그룹 리스트
				);

			$json["files"]=array();

			///staff
			$sql=" select * from  ( select af_seq,af_code, af_name, af_size ,af_fcode, af_url as afUrl ";
			$sql.= " from ".$dbH."_file where af_use='Y' and af_code='staff' and af_fcode='staff' and af_userid='".$st_staffid."' ";
			$sql.=" order by af_no desc) where rownum <= 1 ";
			$dt=dbone($sql);

			$json["staffsql"]=$sql;

			if($dt["AF_FCODE"])
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(
						"afseq"=>$dt["AF_SEQ"], 
						"afCode"=>$dt["AF_CODE"], 					
						"afUrl"=>$afFile,
						"afThumbUrl"=>$afThumbUrl, 
						"afFcode"=>$dt["AF_FCODE"],
						"afName"=>$dt["AF_NAME"], 
						"afSize"=>$dt["AF_SIZE"]
				);
				$json["files"]["staff"]=$addarray;
			}
			else
			{
				$json["files"]["staff"]=null;
			}

			///signature
			$sql=" select * from  ( select af_seq,af_code, af_name, af_size ,af_fcode, af_url as afUrl ";
			$sql.= " from ".$dbH."_file where af_use='Y' and af_code='staff' and af_fcode='signature' and af_userid='".$st_staffid."' ";
			$sql.=" order by af_no desc) where rownum <= 1 ";

			$json["signaturesql"]=$sql;
			
			$dt=dbone($sql);
			if($dt["AF_FCODE"])
			{
				$afFile=getafFile($dt["AFURL"]);
				$afThumbUrl=getafThumbUrl($dt["AFURL"]);

				$addarray=array(

						"afseq"=>$dt["AF_SEQ"], 
						"afCode"=>$dt["AF_CODE"], 					
						"afUrl"=>$afFile,
						"afThumbUrl"=>$afThumbUrl, 
						"afFcode"=>$dt["AF_FCODE"],
						"afName"=>$dt["AF_NAME"], 
						"afSize"=>$dt["AF_SIZE"]
				);
				$json["files"]["signature"]=$addarray;
			}
			else
			{
				$json["files"]["signature"]=null;
			}

		}
		else
		{			
			$rand_num = sprintf('%06d',rand(000000000000,999999999999));   ///1029 난수로 staffid 생성
			$json = array(		
				
				"stStaffId"=>"MEM".$rand_num,
				"meStatusList"=>$meStatusList, ///회원상태 리스트
				"stDepartList"=>$stDepartList, ///소속 리스트
				"stAuthList"=>$stAuthList ///회원그룹 리스트
			);		
		}

		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>