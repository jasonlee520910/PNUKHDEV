<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$code=$_GET["code"];

	if($apiCode!="markingmain"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingmain";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$jsql=" a  inner join ".$dbH."_order b on a.mr_odcode=b.od_code ";
		$jsql.=" inner join ".$dbH."_release r on a.mr_odcode=r.re_odcode ";
		$jsql.=" inner join ".$dbH."_medical m on b.od_userid=m.mi_userid ";
		$jsql.=" left join ".$dbH."_packingbox c2 on b.od_packtype=c2.pb_code ";
		$jsql.=" left join ".$dbH."_order_client cy on b.od_keycode=cy.keycode ";

		$wsql=" where a.mr_barcode='".$code."' ";
		$sql=" select ";
		$sql.=" a.mr_desc,b.od_code, b.od_name,b.od_packcapa,b.od_packcnt,r.re_name, r.re_deliexception, r.re_delicomp, r.re_boxmedicnt, m.mi_name, r.RE_MOBILE ";
		$sql.=" , (select cd_value_kor from han_code where cd_code=a.mr_desc and cd_type='mrDesc' and cd_use = 'Y') as MARKINGTXT ";
		$sql.=", b.od_request as ODREQUEST ";
		$sql.=", c2.pb_code pouchcode, c2.pb_title packtype ";
		$sql.=" ,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=b.od_packtype and af_code='packingbox' and af_use='Y') as PACKIMG ";
		$sql.=", cy.packageInfo cypackageInfo, cy.orderCode cyodcode ";
		$sql.=" from ".$dbH."_marking $jsql where a.mr_barcode='".$code."'";

		$dt=dbone($sql);

		$markingtxt="";

		if($dt["CYODCODE"])
		{
			$cyodcode=($dt["CYODCODE"]+10000);
		}
		else
		{
			$cyodcode="";
		}

		$pmarkingtxt=getClob($dt["MARKINGTXT"]);
		if($pmarkingtxt)
		{
			$patientcode="12345678";
			$markingtxt=$pmarkingtxt;
			$markingtxt=str_replace("[od_code]",$dt["OD_CODE"],$markingtxt);//주문번호 
			$markingtxt=str_replace("[re_name]",$dt["OD_NAME"],$markingtxt);//환자명
			$markingtxt=str_replace("[mi_name]",$dt["MI_NAME"],$markingtxt);//한의원 
			$markingtxt=str_replace("[patientcode]",$patientcode,$markingtxt);///환자명코드 
		}
		else
		{
			$markingtxt="<p>No Marking</p>";
		}

		$afFile=getafFile($dt["PACKIMG"]);
		$afThumbUrl=getafFile($dt["PACKIMG"]);

		$re_boxmedicnt=($dt["RE_BOXMEDICNT"]) ? $dt["RE_BOXMEDICNT"] : "0";

		$RE_MOBILE=($dt["RE_MOBILE"])?$dt["RE_MOBILE"]:"5555";
		$mobile=($dt["RE_MOBILE"])?substr($dt["RE_MOBILE"], -4):"5555";

		$json=array(
				"sql"=>$sql,
				"mr_desc"=>$dt["MR_DESC"],
				"pouchcode"=>$dt["POUCHCODE"],
				"packtype"=>$dt["PACKTYPE"],
				"od_packcnt"=>$dt["OD_PACKCNT"],
				"od_packcapa"=>$dt["OD_PACKCAPA"],
				"od_request"=>getClob($dt["ODREQUEST"]),
				"re_deliexception"=>$dt["RE_DELIEXCEPTION"],//20191106 : 배송예외('O=oversea','T=tied', D=direct)
				"re_delicomp"=>$dt["RE_DELICOMP"],//20191106 : 배송예외('O=oversea','T=tied', D=direct)
				"re_boxmedicnt"=>$re_boxmedicnt,//20191106 : 배송예외('O=oversea','T=tied', D=direct)
				"mobile"=>$mobile,
				
				"cyodcode"=>$cyodcode,
				"markingtxt"=>$markingtxt,
				"afUrl"=>$afFile,
				"afThumbUrl"=>$afThumbUrl
				);

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>