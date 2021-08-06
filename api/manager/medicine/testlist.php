<?php 
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="testlist"){$json["resultMessage"]="API코드오류2";$apiCode="testlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{	
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		//약재넣을때 쿼리문 
		$sql=" select * from han_goods where gd_type='pregoods' and gd_pregoodstype='mixedmilling' ";  
		
		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["list"]=array();
		
		while($dt=dbarr($res))
		{ 		
			$new=explode(",",$dt["gd_bomcode"]);
			$cnt=count($new);

			//ETGDHH,A023G072KR100J,FTCB006,FTCB008,FTTA003
			$zzz="";
			for($i=0;$i<$cnt;$i++)
			{		
				$zzz.= ",".$new[$i]."|0";
			}
				
				$addarray=array(
				
					"new0"=>(",".$new[0]."|0"),
					"new1"=>(",".$new[1]."|0"),
					"new2"=>(",".$new[2]."|0"),

					"new"=>($new),
					"count"=>($count),
					"gd_bomcode"=>($dt["gd_bomcode"]),
					"gd_seq"=>($dt["gd_seq"]),
					"zzz"=>$zzz
						
						);
					array_push($json["list"], $addarray);
				
		}
	
//////////////////////////////////////////////////////////////////////////////////////////////	

	
			$sql1="";	
			for($i=0; $i<50; $i++) //count 4000	//테스트할때만 
			{	
				$b0 = $json["list"][$i]["zzz"];
				$b1 = $json["list"][$i]["gd_seq"];
				//$b2 = $json["list"][$i]["rcMedicine1"];
				

				//약재 넣을때 쿼리 
				$sql1="  update han_goods set  gd_bomcode='".$b0."'  where gd_seq='".$b1."' ";


				
				//이거확인하고 update 하기
				//dbqry($sql1);		//주석풀면 바로 입력됨!!!		
				echo $sql1;
				//dbqry($sql2);		//주석풀면 바로 입력됨!!!		
				//echo $sql2;
			}


		$json["sql3"]=$sql3;				
		$json["sql2"]=$sql2;
		$json["sql1"]=$sql1;		
		$json["apiCode"]=$apiCode;		
		$json["resultCode"]="200";		
		$json["resultMessage"]="OK";		
	}	
	

	function getmedititle($medicode)
	{


			for($i=0;$i<1;$i++)
			{
				$sql=" select md_code from han_medicine_djmedi where ( mm_title_kor like '%".$medicode."%' ) ";				
				$res=dbqry($sql);
				while($hub=dbarr($res))
				{
					
					$medititle.=$hub["md_code"];
				}				
			}
	}
		return $medititle;

	function getMedicine_test($val, $type='desc')
	{
		$chk_mmcode="";
		global $language;

		if($type == 'list')
		{
			if($val == '' || $val == false || $val == null)
			{
				$rcMedicineTxt = "-";
			}
			else
			{
				$rcMedicine = str_replace("'", "", $val);//빈공간있으면 일단은 삭제
				$rcMedicineArry = explode(',', $rcMedicine);			
				$where_rcMedicine_arry = array();

				foreach($rcMedicineArry as $value)
				{
					$items = $rcMedicineArry;
					
					array_push($where_rcMedicine_arry, "'".$items[0]."'");
				}
			}

				for($i=0;$i<count($rcMedicineArry);$i++)
				{		
					$sql3=" select mm_use from han_medicine_djmedi where mm_code = '".$rcMedicineArry[$i]."' ";	
					$dt3=dbone($sql3);

					if($dt3["mm_use"])
					{
						$chk_mmcode.=",Y";
					}
					else
					{
						$chk_mmcode.=",N";
					}	
				}
			return $chk_mmcode;
		}	
	}



	function getMediname($val, $type='desc')
	{
		global $language;

		if($type == 'list')
		{
			if($val == '' || $val == false || $val == null)
			{
				$rcMedicineTxt = "-";
			}
			else
			{
				$rcMedicineArry = explode('|', $val);			
				$where_rcMedicine_arry = array();

				foreach($rcMedicineArry as $value)
				{
					$items = explode(',', $value);
					array_push($where_rcMedicine_arry, "'".$items[0]."'");
				}
				$where_rcMedicine = implode(",", $where_rcMedicine_arry);
				$sql_rcMedicine = " select group_concat(md_title_".$language.") as title from han_medicine where md_code in (".$where_rcMedicine.")";
				$dt_rcMedicine=dbone($sql_rcMedicine);
				$rcMedicineTxt = $dt_rcMedicine["title"];
			}

			return $where_rcMedicine;
		}

		

	}

//$rcMedicine1, $nycode1  배열로 넘어옴

function getlast($num1,$num2){

	$new1 =explode(",",$num1);
	$new2 =explode("|",$num2);

 //echo count($new1);

}
?>


