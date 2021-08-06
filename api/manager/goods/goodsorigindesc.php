<?php //원재료 왼쪽 리스트 api
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$gd_seq=$_GET["seq"];
	if($apiCode!="goodsorigindesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsorigindesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($gd_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$hCodeList = getNewCodeTitle("goodstype,mdWaterchk");
		//------------------------------------------------------------
		$goodstypeList = getCodeList($hCodeList, 'goodstype');//제품등록
		$UseList = getCodeList($hCodeList, 'mdWaterchk');  //YN 리스트

		if($gd_seq)
		{
			$sql=" select * from ".$dbH."_goods where gd_seq='".$gd_seq."'  and gd_use in ('Y','A') ";  //사용전과 사용중인것만 보임
			$dt=dbone($sql);

			$json=array(

				"seq"=>$dt["gd_seq"],
				"gdBomcode"=>$dt["gd_bomcode"],
				"gdUse"=>$dt["gd_use"],

				"gdLoss"=>$dt["gd_loss"],
				"gdStable"=>$dt["gd_stable"],
				"gdQty"=>$dt["gd_qty"],

				"gdType"=>$dt["gd_type"],
				"gdCode"=>$dt["gd_code"],
				"gdUnit"=>$dt["gd_unit"],
				"gdNameKor"=>$dt["gd_name_kor"],
				"gdSpec"=>$dt["gd_spec"],
				"gdDesc"=>$dt["gd_desc"]
				);

			$json["goodstypeList"] = $goodstypeList;
			$json["UseList"] = $UseList;


			$bomcode = substr($dt["gd_bomcode"], 1); //한자리만 자르기 
			$bomcodeList =getlist($bomcode);
			$json["bomcodeList"] = $bomcodeList;
		}
		else
		{
			$json["gd_use"] = $gd_use; 
			$json["goodstypeList"] = $goodstypeList; 
			$json["UseList"] = $UseList;

		}
		$json["gd_seq"]=$gd_seq;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
		$json["sql3"]=$sql3;

		$json["bomcode"]=$bomcode;
	
	}



	function getlist($val)   //ETGDSH|9,FTZE001|3,FTYX001|4,FTXX012|5
	{
				$Arry = explode(',', $val);			
			//	$bomcode = array();
				//$bomcapa = array();

				$bomdata=array();

				foreach($Arry as $value)
				{
					$items = explode('|', $value);

					//text구해오기
					$sql = " select gd_name_kor as title from han_goods where gd_code ='".$items[0]."' ";
					$dt2=dbone($sql);

					$bomarr=array("bomcode"=>$items[0],"bomcapa"=>$items[1],"bomtext"=>$dt2["title"]);
					array_push($bomdata,$bomarr);
				}

			return $bomdata;			
	}
?>