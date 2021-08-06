<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["code"];
	if($apiCode!="goodsmain"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsmain";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

 		$jsql=" a inner join ".$dbH."_release b on a.gp_odcode=b.re_odcode  ";
		$jsql.=" inner join ".$dbH."_order c on a.gp_odcode=c.od_code ";
		$jsql.=" inner join ".$dbH."_goods g on g.gd_code=a.gp_goods ";
		$jsql.=" inner join ".$dbH."_medical m on b.re_userid=m.mi_userid ";
		$jsql.=" left join ".$dbH."_code c4 on b.re_delitype=c4.cd_code and cd_type='reDelitype' ";
		
		$wsql=" where a.gp_barcode='".$code."' ";

		$sql=" select ";
		$sql.=" a.GP_GOODSCNT, a.GP_SUBGOODS as GPSUBGOODS
		,b.RE_NAME, b.RE_DELITYPE,b.RE_DELIEXCEPTION, b.RE_DELICOMP, b.RE_ZIPCODE, b.RE_ADDRESS, b.RE_PHONE, b.RE_MOBILE, b.RE_BOXMEDICNT, 
		b.RE_SENDNAME, b.RE_SENDPHONE, b.RE_SENDMOBILE, b.RE_SENDZIPCODE, b.RE_SENDADDRESS, 
			c.od_request as ODREQUEST ,c.od_advice as ODADVICE, g.gd_name_kor as goodsName, c4.cd_name_kor as delitypeName, c.od_title,m.mi_name, m.mi_zipcode, m.mi_address, m.mi_phone ";
		$sql.=" from ".$dbH."_package $jsql $wsql ";

		$dt=dbone($sql);
		

		$json=array(
			"re_delitype"=>$dt["RE_DELITYPE"],
			"re_delitypename"=>$dt["DELITYPENAME"],	//배송방법 text		
			"re_deliexception"=>$dt["RE_DELIEXCEPTION"],	//배송예외 
			"re_delicomp"=>$dt["RE_DELICOMP"],	//배송예외 
			"re_boxmedicnt"=>$dt["RE_BOXMEDICNT"],	//배송예외 
			
		

			"re_name"=>$dt["RE_NAME"],
			"re_zipcode"=>$dt["RE_ZIPCODE"],
			"re_address"=>str_replace("||"," ",$dt["RE_ADDRESS"]),
			"re_phone"=>$dt["RE_PHONE"],
			"re_mobile"=>$dt["RE_MOBILE"],

			"re_sendname"=>$dt["RE_SENDNAME"],
			"re_sendzipcode"=>$dt["RE_SENDZIPCODE"],
			"re_sendaddress"=>str_replace("||"," ",$dt["RE_SENDADDRESS"]),
			"re_sendphone"=>$dt["RE_SENDPHONE"],
			"re_sendmobile"=>$dt["RE_SENDMOBILE"],


			"mi_name"=>$dt["MI_NAME"],
			"mi_zipcode"=>$dt["MI_ZIPCODE"],
			"mi_address"=>str_replace("||"," ",$dt["MI_ADDRESS"]),
			"mi_phone"=>$dt["MI_PHONE"],


			"od_title"=>$dt["OD_TITLE"],
			"od_request"=>getClob($dt["ODREQUEST"]),
			"od_advice"=>getClob($dt["ODADVICE"]),

			"goodsName"=>$dt["GOODSNAME"],
			"gp_goodscnt"=>$dt["GP_GOODSCNT"]
			);


		$arrg=explode(",", getClob($dt["GPSUBGOODS"]));
		$json["arrg"] = $arrg;
		for($i=1;$i<count($arrg);$i++)
		{
			$arrs=explode("|",$arrg[$i]);
			$gcode=$arrs[0];
			if($i>1)
			{
				$gpcode.=",";
			}
			$gpcode.="'".$gcode."'";
			$gcnt[$gcode]=$arrs[1];
		}


		$gsql=" select ";
		$gsql.=" c1.cd_name_kor as gdTypeName, a.gd_type, a.gd_code, a.gd_name_".$language." as gdname ";
		$gsql.=" ,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode=a.gd_code and af_code='goods' and af_use='Y') as goodsImg ";  
		$gsql.=" from han_goods ";
		$gsql.=" a left join han_code c1 on c1.cd_type='gdType' and c1.cd_code=a.gd_type ";
		$gsql.=" where gd_code in (".$gpcode.") ";
		$gres=dbqry($gsql);
		$json["gsql"] = $gsql;
		$json["goodslist"]=array();
		while($gdt=dbarr($gres))
		{
			$addarray=array(
				"gdTypeName"=>$gdt["GDTYPENAME"], //제품구분이름 
				"gd_type"=>$gdt["GD_TYPE"], //제품구분 
				"gd_code"=>$gdt["GD_CODE"],  //제품코드
				"gd_name"=>$gdt["GDNAME"],  //제품이름 
				"gd_thumb_image"=>getafThumbUrl($gdt["GOODSIMG"]),
				"gd_image"=>getafFile($gdt["GOODSIMG"]),  //제품이미지 
				"gd_cnt"=>$gcnt[$gdt["GD_CODE"]] //갯수
			);
			array_push($json["goodslist"], $addarray);			
		}

		
		
		$json["apiCode"] = $apiCode;
		$json["sql"] = $sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}

?>