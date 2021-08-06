<?php
	/// 환경설정 > 개인정보처리 > 상세 > 수정 
	$json["resultCode"]="204";
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$po_seq=$_POST["poSeq"];

	if($apicode!="policyupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="policyupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$po_group=$_POST["poGroup"];
		$po_type=$_POST["poType"];
		$po_contents=$_POST["poContents"];
		$po_use=!isEmpty($_POST["poUse"])?$_POST["poUse"]:"Y";
		$returnData=$_POST["returnData"];

		$po_link=!isEmpty($_POST["poBtnUrl"])?$_POST["poBtnUrl"]:"";

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

	
		$poSeq="";
		if(isEmpty($po_seq)==false)
		{
			$sql="select PO_SEQ from ".$dbH."_policy where PO_SEQ='".$po_seq."' ";
			$dt=dbone($sql);
			$poSeq=$dt["PO_SEQ"];
		}

		if(isEmpty($poSeq)==false)
		{
			if($po_type=="600")
			{
				$sql=" update ".$dbH."_policy set  PO_TYPE='".$po_type."', PO_CONTENTS=".insertClob($po_contents).", PO_LINK='".$po_link."', PO_USE='".$po_use."', PO_MODIFY=sysdate where PO_SEQ='".$po_seq."'";
			}
			else
			{
				$sql=" update ".$dbH."_policy set  PO_TYPE='".$po_type."', PO_CONTENTS=".insertClob($po_contents).", PO_USE='".$po_use."', PO_MODIFY=sysdate where PO_SEQ='".$po_seq."'";
			}
			dbcommit($sql);
			$json["stateName"]="수정";
		}
		else
		{
			if($po_type=="600")
			{
				$sql=" insert into ".$dbH."_policy (PO_SEQ, PO_GROUP, PO_SORT, PO_TYPE,  PO_CONTENTS, PO_LINK, PO_USE, PO_DATE) values ((SELECT NVL(MAX(PO_SEQ),0)+1 FROM ".$dbH."_policy),'".$po_group."',(SELECT NVL(MAX(PO_SORT),0)+1 FROM ".$dbH."_policy where to_char(PO_GROUP, 'yyyy-mm-dd')='".$po_group."'), '".$po_type."',".insertClob($po_contents).",'".$po_link."','Y', sysdate )";
			}
			else
			{
				$sql=" insert into ".$dbH."_policy (PO_SEQ, PO_GROUP, PO_SORT, PO_TYPE,  PO_CONTENTS, PO_USE, PO_DATE) values ((SELECT NVL(MAX(PO_SEQ),0)+1 FROM ".$dbH."_policy),'".$po_group."',(SELECT NVL(MAX(PO_SORT),0)+1 FROM ".$dbH."_policy where to_char(PO_GROUP, 'yyyy-mm-dd')='".$po_group."'), '".$po_type."',".insertClob($po_contents).",'Y', sysdate )";
			}
			dbcommit($sql);

			$json["stateName"]="추가";
		}

		$json["poGroup"]=$po_group;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>