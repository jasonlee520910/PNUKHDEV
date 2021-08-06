<?php  
	/// 제품재고관리 > 제품목록 > 제품목록리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$seq=$_GET["seq"];

	if($apiCode!="goodsdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{

function getbomCode($gdBom){
	$bomCodeArr = explode(',', $gdBom);
	$bomCode=$bomCapa=array();
	foreach($bomCodeArr as $val){
		$val2="";
		if($val){
			$val2 = explode('|', $val);
			$bomCapa[$val2[0]]=$val2[1];
			$addArray=array("code"=>$val2[0],"capa"=>$val2[1]);
			array_push($bomCode,$addArray);
		}
	}
	$addArray=array("bomCapa"=>$bomCapa);
	array_push($bomCapa,$addArray);
	$bomData=array("bomCode"=>$bomCode, "bomCapa"=>$bomCapa);
	return $bomData;
}
function bomCodeTxt($bomData){
	$gdBomcode="";
	foreach($bomData as $val){
		if($gdBomcode)$gdBomcode.=",";
		$gdBomcode.="'".$val["code"]."'";
	}
	return $gdBomcode;
}

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$jsql=" a ";
		$wsql=" where a.gd_seq='".$seq."' and a.gd_use <> 'D' ";
		$sql=" select a.gd_seq ,a.gd_type, a.gd_code, a.gd_name_".$language." as gd_name, a.gd_bomcode,a.gd_pillorder from ".$dbH."_goods $jsql $wsql ";

		$dt=dbone($sql);
		$gdSeq=$dt["GD_SEQ"];	
		$gdCode=$dt["GD_CODE"];	
		$gdName=$dt["GD_NAME"];
		$gdPillorder=getClob($dt["GD_PILLORDER"]);

		//bomData 추출
		$bomData=getbomCode($dt["GD_BOMCODE"]);
		$gdBomcode=bomCodeTxt($bomData["bomCode"]);
		//첫번째구성요소가 있을때
		if(count($bomData)>0 && $gdBomcode!=""){
			$goodsmedi=getGoodsMedicine($gdBomcode, $bomData);

			//$sql2=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode from ".$dbH."_goods a  inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType'  where gd_code in (".$gdBomcode.") and gd_type!='origin' and gd_use <> 'D'  order by field(gd_type, 'goods','pregoods','material','origin') ";

			$sql2=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode ";
			$sql2.=" from ".$dbH."_goods a ";
			$sql2.=" inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType' ";
			$sql2.=" where gd_code in (".$gdBomcode.") and gd_type!='origin' and gd_use <> 'D'  ";
			$sql2.=" order by decode(gd_type, 'goods',1,'pregoods',2,'material',3,'origin',4) ";


			$res2=dbqry($sql2);
			$bomArr=array();
			$bomArr = array_merge($bomArr, $goodsmedi);
			$bomcodelist=array();
			while($dt2=dbarr($res2)){
				$bomArr2=array();
				//두번째구성요소가 있을때
				if($dt2["GD_TYPE"]=="pregoods" || $dt2["GD_BOMCODE"]!=""){

					//bomData 추출
					$bomData2=getbomCode($dt2["GD_BOMCODE"]);
					$gdBomcode2=bomCodeTxt($bomData2["bomcode"]);
					//echo "1111>>>".$gdBomcode2;
					if(count($bomData2)>0 && $gdBomcode2!=""){
						
						$goodsmedi2=getGoodsMedicine($gdBomcode2, $bomData2);
						$bomArr2 = array_merge($bomArr2, $goodsmedi2);
						$gdBom2="'".str_replace(",","','",$dt2["GD_BOMCODE"])."'";
						//$sql3=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode from ".$dbH."_goods a  inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType'  where gd_code in (".$gdBomcode2.") and gd_type!='origin' and gd_use <> 'D' order by field(gd_type, 'goods','pregoods','material','origin') ";

						$sql3=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode ";
						$sql3.=" from ".$dbH."_goods a ";
						$sql3.=" inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType' ";
						$sql3.=" where gd_code in (".$gdBomcode.") and gd_type!='origin' and gd_use <> 'D'  ";
						$sql3.=" order by decode(gd_type, 'goods',1,'pregoods',2,'material',3,'origin',4) ";

						$res3=dbqry($sql3);
						while($dt3=dbarr($res3)){
							$bomArr3=array();
							//세번째구성요소가 있을때
							if($dt3["GD_TYPE"]=="pregoods" || $dt3["GD_BOMCODE"]!=""){
								//bomData 추출
								$bomData3=getbomCode($dt3["GD_BOMCODE"]);
								$gdBomcode3=bomCodeTxt($bomData3["bomCode"]);
								if(count($bomData3)>0 && $gdBomcode3!=""){
									$goodsmedi3=getGoodsMedicine($gdBomcode3, $bomData3);
									$bomArr3 = array_merge($bomArr3, $goodsmedi3);

									$gdBom3="'".str_replace(",","','",$dt3["GD_BOMCODE"])."'";
									//$sql4=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode from ".$dbH."_goods a  inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType'  where gd_code in (".$gdBomcode3.") and gd_type!='origin' and gd_use <> 'D' order by field(gd_type, 'goods','pregoods','material','origin') ";

									$sql4=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode ";
									$sql4.=" from ".$dbH."_goods a ";
									$sql4.=" inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType' ";
									$sql4.=" where gd_code in (".$gdBomcode.") and gd_type!='origin' and gd_use <> 'D'  ";
									$sql4.=" order by decode(gd_type, 'goods',1,'pregoods',2,'material',3,'origin',4) ";

									$res4=dbqry($sql4);
									while($dt4=dbarr($res4)){
										$bomArr4=array();
										//네번째구성요소가 있을때
										if($dt4["gd_type"]=="PREGOODS" || $dt4["GD_BOMCODE"]!=""){
											//bomData 추출
											$bomData4=getbomCode($dt4["GD_BOMCODE"]);
											$gdBomcode4=bomCodeTxt($bomData4["bomCode"]);
											if(count($bomData4)>0 && $gdBomcode4!=""){
												$goodsmedi4=getGoodsMedicine($gdBomcode4, $bomData4);
												$bomArr4 = array_merge($bomArr4, $goodsmedi4);

												$gdBom4="'".str_replace(",","','",$dt4["GD_BOMCODE"])."'";
												//$sql5=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode from ".$dbH."_goods a  inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType'  where gd_code in (".$gdBomcode4.") and gd_type!='origin' and gd_use <> 'D' order by field(gd_type, 'goods','pregoods','material','origin') ";

												$sql5=" select a.gd_seq, a.gd_type, b.cd_name_".$language." gdType, gd_code, gd_name_".$language." gd_name, gd_bomcode ";
												$sql5.=" from ".$dbH."_goods a ";
												$sql5.=" inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType' ";
												$sql5.=" where gd_code in (".$gdBomcode.") and gd_type!='origin' and gd_use <> 'D'  ";
												$sql5.=" order by decode(gd_type, 'goods',1,'pregoods',2,'material',3,'origin',4) ";


												$res5=dbqry($sql5);
												while($dt5=dbarr($res5)){
													$addarray=array(
														"gdSeq"=>$dt5["GD_SEQ"], 
														"gdTypeCode"=>$dt5["GD_TYPE"], 
														"gdType"=>$dt5["GDTYPE"], 
														"gdCode"=>$dt5["GD_CODE"], 
														"gdName"=>$dt5["GD_NAME"],
														"gdBom"=>$dt5["GD_BOMCODE"]
													);
													array_push($bomArr4, $addarray);
												}
											}
										}
										//네번째구성요소
										$addarray=array(
											"gdSeq"=>$dt4["GD_SEQ"], 
											"gdTypeCode"=>$dt4["GD_TYPE"], 
											"gdType"=>$dt4["GDTYPE"], 
											"gdCode"=>$dt4["GD_CODE"], 
											"gdName"=>$dt4["GD_NAME"],
											"gdRate"=>$bomData3["bomCapa"][$dt4["GD_CODE"]],
											"gdBom"=>$bomArr4
										);
										array_push($bomArr3, $addarray);
									}
								}
							}
							//세번째구성요소
							$addarray=array(
								"gdSeq"=>$dt3["GD_SEQ"], 
								"gdTypeCode"=>$dt3["GD_TYPE"], 
								"gdType"=>$dt3["GDTYPE"], 
								"gdCode"=>$dt3["GD_CODE"], 
								"gdName"=>$dt3["GD_NAME"],
								"gdRate"=>$bomData2["bomCapa"][$dt3["GD_CODE"]],
								"gdBom"=>$bomArr3
							);
							array_push($bomArr2, $addarray);
						}
					}
				}
				//두번째구성요소
				$addarray=array(
					"gdSeq"=>$dt2["GD_SEQ"], 
					"gdTypeCode"=>$dt2["GD_TYPE"], 
					"gdType"=>$dt2["GDTYPE"], 
					"gdCode"=>$dt2["GD_CODE"], 
					"gdName"=>$dt2["GD_NAME"],
					"gdRate"=>$bomData["bomCapa"][$dt2["GD_CODE"]],
					"gdBom"=>$bomArr2
				);
				array_push($bomArr, $addarray);
			}

		}
		//첫번째상위구성요소
		$json=array(
			"apiCode"=>$apiCode,
			"returnData"=>$returnData,
			"seq"=>$gdSeq, 
			"gdType"=>$gdType, 
			"gdCode"=>$gdCode, 
			"gdName"=>$gdName, 
			"gdBom"=>$bomArr,
			"gdPillorder"=>$gdPillorder
		);
		$json["bomData"]=$bomData;
		$json["gdBomcode"]=$gdBomcode;
		$json["gdBomcapa"]=$gdBomcapa;
		$json["첫번째goodsmedi"]=$goodsmedi;
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["sql3"]=$sql3;
		$json["sql4"]=$sql4;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}


?>

<?php
	function getGoodsMedicine($gdBomcode, $bomData)
	{
		global $dbH;
		global $bomData;
		global $language;
		$sql=" select ";
		$sql.=" a.mb_seq gd_seq, a.mb_code, b.mm_code gd_code, b.mm_title_".$language." gd_name, c.cd_name_".$language." gdType ";
		$sql.=" from ".$dbH."_medibox  ";
		$sql.=" a inner join ".$dbH."_medicine_djmedi b on a.mb_medicine=b.md_code  ";
		$sql.=" inner join han_code c on c.cd_code='origin' and c.cd_type='gdType' ";
		$sql.=" where b.mm_code in (".$gdBomcode.") and a.mb_table='99999' ";

		$res=dbqry($sql);

		$bomarr2=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"gdSeq"=>$dt["GD_SEQ"], 
				"gdTypeCode"=>"origin", 
				"gdType"=>$dt["GDTYPE"], 
				"gdCode"=>$dt["GD_CODE"], 
				"gdName"=>$dt["GD_NAME"],
				"gdRate"=>$bomData["bomCapa"][$dt["GD_CODE"]],
				"gdBom"=>""
			);
			array_push($bomarr2, $addarray);
		}
		
		return $bomarr2;
	}

?>