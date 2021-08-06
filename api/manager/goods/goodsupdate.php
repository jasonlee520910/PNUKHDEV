<?php  
	/// 제품재고관리 > 제품목록 > 등록 & 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$gd_seq=$_POST["seq"];

	if($apicode!="goodsupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodsupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($gd_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$rcCode=$_POST["rcCode"];

		$gd_type=$_POST["gdType"];
		$gd_code=trim($_POST["gdCode"]);
		$gd_unit=$_POST["gdUnit"];
		$gd_name_kor=$_POST["gdNameKor"];
		//$gd_spec=$_POST["gdSpec"];
		$gd_desc=$_POST["gdDesc"];
		
		$gd_stable=$_POST["gdStable"]; //적정수량
		$gd_loss=$_POST["gdLoss"]; //로스율
		if($gd_loss=="")$gd_loss=0;
		$gd_losscapa=$_POST["gdLossCapa"]; //로스량
		if($gd_losscapa=="")$gd_losscapa=0;
		$gd_capa=$_POST["gdCapa"]; //제품용량
		if($gd_capa=="")$gd_capa=0;
		$gd_category=$_POST["gdCategory"]; //반제품의 상세분류
		$radiouse=$_POST["radiouse"]; //사용여부
		$gd_use=$_POST["gdUse"]; //사용여부

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$sql=" select gd_code,gd_bomcode from han_goods where gd_code = '".$gd_code."'";
		$dt=dbone($sql);

		if($dt["GD_CODE"] && $gd_seq=="")
		{
			$json["resultCode"]="204";
			$json["resultMessage"]="중복코드";
		}
		else
		{
			//제환순서
			$json["pillorder"]=$_POST["pillorder"];
			//$gd_pillorder=json_encode($_POST["pillorder"]);
			$gd_pillorder=$_POST["pillorder"];
			//약재가 아닐때는 
			if($gd_type!="origin")
			{
				if($gd_type=="material")
				{
					$gd_pillorder="";
				}
				if($gd_seq && $gd_seq!="add")
				{
					if($gd_type=="pregoods")//반제품은 gd_category 입력
					{

						$sql2=" update ".$dbH."_goods set ";
						$sql2.="gd_loss='".$gd_loss."',gd_losscapa='".$gd_losscapa."',gd_capa='".$gd_capa."',gd_type='".$gd_type."',gd_code='".$gd_code."',gd_category='".$gd_category."',gd_stable='".$gd_stable."',gd_unit='".$gd_unit."',gd_name_kor='".$gd_name_kor."',gd_desc='".$gd_desc."',gd_use='".$gd_use."',gd_modify=SYSDATE, gd_pillorder='".$gd_pillorder."'";
						$sql2.=" where gd_seq='".$gd_seq."'";
						dbcommit($sql2);

						//반제품의 경우 han_recipemedical 에도 update하기
						$sql3=" update ".$dbH."_recipemedical set ";
						$sql3.=" rc_title_kor='".$gd_name_kor."',rc_medicine='".$dt["GD_BOMCODE"]."',rc_modify=SYSDATE ";
						$sql3.=" where rc_code='".$rcCode."' ";
						dbcommit($sql3);
					}
					else
					{
						$sql2=" update ".$dbH."_goods set ";
						$sql2.="gd_loss='".$gd_loss."',gd_losscapa='".$gd_losscapa."',gd_capa='".$gd_capa."',gd_code='".$gd_code."',gd_type='".$gd_type."',gd_stable='".$gd_stable."',gd_unit='".$gd_unit."',gd_name_kor='".$gd_name_kor."',gd_desc='".$gd_desc."',gd_use='".$gd_use."',gd_modify=SYSDATE, gd_pillorder='".$gd_pillorder."'";
						$sql2.=" where gd_seq='".$gd_seq."'";
						dbcommit($sql2);
					}
				}
				else
				{
					if($gd_type=="pregoods")//반제품은 gd_category 입력
					{
						$sql2=" insert into ".$dbH."_goods (gd_seq,gd_recipe, gd_loss, gd_losscapa, gd_capa, gd_category, gd_stable, gd_type,gd_code,gd_unit,gd_name_kor,gd_desc,gd_use,gd_date,gd_pillorder) values ((SELECT NVL(MAX(gd_seq),0)+1 FROM ".$dbH."_goods),'".$rcCode."','".$gd_loss."','".$gd_losscapa."','".$gd_capa."','".$gd_category."','".$gd_stable."','".$gd_type."','".$gd_code."','".$gd_unit."','".$gd_name_kor."','".$gd_desc."','".$gd_use."',SYSDATE,'".$gd_pillorder."') ";
						dbcommit($sql2);

						//반제품의 경우 han_recipemedical 에도 insert 하기
						$sql3=" insert into ".$dbH."_recipemedical (rc_seq,rc_code,rc_medical,rc_title_kor,rc_medicine,rc_status,rc_date) ";
						$sql3.=" values ((SELECT NVL(MAX(rc_seq),0)+1 FROM ".$dbH."_recipemedical),'".$rcCode."','pill','".$gd_name_kor."','".$rc_medicine."','F',SYSDATE) "; 
						dbcommit($sql3);

					}
					else
					{

						$sql=" insert into ".$dbH."_goods (gd_seq,gd_loss, gd_losscapa, gd_capa,gd_stable,gd_type,gd_code,gd_unit,gd_name_kor,gd_desc,gd_use,gd_date,gd_pillorder) values ((SELECT NVL(MAX(gd_seq),0)+1 FROM ".$dbH."_goods),'".$gd_loss."','".$gd_losscapa."','".$gd_capa."','".$gd_stable."','".$gd_type."','".$gd_code."','".$gd_unit."','".$gd_name_kor."','".$gd_desc."','".$gd_use."',SYSDATE, '".$gd_pillorder."') ";  
						dbcommit($sql);
					}
				}
			}

			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
			$json["sql"]=$sql;	
			$json["sql2"]=$sql2;	
			$json["sql3"]=$sql3;
			$json["sql4"]=$sql4;	
		}
	}
?>