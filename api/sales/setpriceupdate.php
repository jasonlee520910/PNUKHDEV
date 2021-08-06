<?php
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	$spStaffid=$resjson["spStaffid"];
	if($apicode!="setpriceupdate"){$json["resultMessage"]="API코드오류";$apicode="setpriceupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($spStaffid==""){$json["resultMessage"]="userid 없음";}
	else{
		$jsonData=$resjson["jsonData"];;
		$returnData=$resjson["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		//현재 적용중인 가격 삭제
		$sql=" update ".$dbH."_salesprice set sp_use='D' where sp_staffid='".$spStaffid."'";
		dbqry($sql);

		//신규 가격 등록
		$sql=" insert into ".$dbH."_salesprice (sp_staffid, sp_data, sp_use, sp_date) values('".$spStaffid."', '".$jsonData."', 'Y', now())  ";
		dbqry($sql);

		//하위업체들 모두 업데이트
		//하위첫번째 업체
		$sql=" select st_staffid from ".$dbH."_staff where st_company='".$spStaffid."'";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$sql=" update ".$dbH."_salesprice set sp_use='U' where sp_use='Y' and sp_staffid='".$dt["st_staffid"]."'";
			dbqry($sql);
			//하위두번째 업체
			$sql=" select st_staffid from ".$dbH."_staff where st_company='".$dt["st_staffid"]."'";
			$res2=dbqry($sql);
			while($dt2=dbarr($res2)){
				$sql=" update ".$dbH."_salesprice set sp_use='U' where sp_use='Y' and sp_staffid='".$dt2["st_staffid"]."'";
				dbqry($sql);
				//하위세번째 업체
				$sql=" select st_staffid from ".$dbH."_staff where st_company='".$dt2["st_staffid"]."'";
				$res3=dbqry($sql);
				while($dt3=dbarr($res3)){
					$sql=" update ".$dbH."_salesprice set sp_use='U' where sp_use='Y' and sp_staffid='".$dt3["st_staffid"]."'";
					dbqry($sql);
					//하위네번째 업체
					$sql=" select st_staffid from ".$dbH."_staff where st_company='".$dt3["st_staffid"]."'";
					$res4=dbqry($sql);
					while($dt4=dbarr($res4)){
						$sql=" update ".$dbH."_salesprice set sp_use='U' where sp_use='Y' and sp_staffid='".$dt4["st_staffid"]."'";
						dbqry($sql);
						//하위다섯번째 업체
						$sql=" select st_staffid from ".$dbH."_staff where st_company='".$dt4["st_staffid"]."'";
						$res5=dbqry($sql);
						while($dt5=dbarr($res5)){
							$sql=" update ".$dbH."_salesprice set sp_use='U' where sp_use='Y' and sp_staffid='".$dt5["st_staffid"]."'";
							dbqry($sql);
						}
					}
				}
			}
		}

		$json["sql"]=$sqlall;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>