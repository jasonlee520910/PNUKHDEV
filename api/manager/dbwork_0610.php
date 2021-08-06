<? 
	$root="..";
	$folder="/manager";
	include_once $root.$folder."/_common/db/db.inc.php";
	$json["resultCode"]="404";
	$json["resultMessage"]="Auth ERROR.";
	
	if($_SERVER["REMOTE_ADDR"]!="59.7.50.122"){$json["resultMessage"]="Auth";$apiCode="dbwork";}
	else
	{
		$sql=" select * from han_medicine order by md_seq ";
		$res=dbqry($sql);
		//while($dt=dbarr($res))
		for($i=1;$dt=dbarr($res);$i++)
		{
			//echo $dt["MD_CODE"]."<br>";
			//입고기록추가
			$wh_code="STO".date("YmdHis").$i;
			$wh_stock=$dt["MD_CODE"];
			$wh_category="basic";
			$wh_title=$dt["MD_NAME_KOR"];
			$wh_qty=30000;
			$wh_remain=30000;
			$wh_price=8;
			$wh_status='incoming';
			$wh_expired=date("Y-m-d",strtotime("6 month"));
			$wh_staff="djmediyou";
			$wh_memo="";
			$wh_etc="";
			$wh_etccode="";
			$wh_etcstaff="";
			$wh_etcphone="";
			$wh_etczipcode="";
			$wh_etcaddress="";
			$wh_date=date("Y-m-d H:i:s");
			$sql=" insert into ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ,wh_category ,wh_title ,wh_qty ,wh_remain ,wh_price ,wh_status ,wh_expired ,wh_staff, wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) values ((SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse),'incoming','".$wh_code."','".$wh_stock."','".$wh_category."','".$wh_title."','".$wh_qty."','".$wh_remain."','".$wh_price."','".$wh_status."','".$wh_expired."','".$wh_staff."','".$wh_memo."','".$wh_etc."','".$wh_etccode."','".$wh_etcstaff."','".$wh_etcphone."','".$wh_etczipcode."','".$wh_etcaddress."',sysdate,'Y',sysdate) ";
			//echo $sql."<br>";
			//dbqry($sql);
			//약재(창고)에 재고 추가 
			$sql=" update ".$dbH."_medicine set md_stock='Y', md_status='use', md_qty = ".$wh_qty." , md_indate=sysdate where md_code='".$wh_stock."' ";
			//echo $sql."<br>";
			//dbqry($sql);
			
			//테이블별 약재이동
			$tarr=array("00000","00001","00002","00003","00080");
			for($m=0;$m<count($tarr);$m++){
				$wh_table=$tarr[$m];
				$wh_qty_tbl=5000;
				//약재함이 있는지 여부 체크  
				$sql=" select mb_code,mb_capacity,mb_use  from ".$dbH."_medibox where mb_table = '".$wh_table."' and mb_medicine = '".$wh_stock."' ";
				$dt=dbone($sql);
				if($dt["MB_CODE"]){
					//출고기록추가
					$sql=" insert into ".$dbH."_warehouse (wh_seq,wh_type ,wh_code ,wh_stock ,wh_category ,wh_table, wh_title ,wh_qty ,wh_staff ,wh_status ,wh_expired ,wh_memo ,wh_etc ,wh_etccode, wh_etcstaff, wh_etcphone, wh_etczipcode, wh_etcaddress ,wh_date ,wh_use ,wh_indate) values ((SELECT NVL(MAX(wh_seq),0)+1 FROM ".$dbH."_warehouse),'outgoing','".$wh_code."','".$wh_stock."','".$wh_category."','".$wh_table."', '".$wh_title."','".$wh_qty_tbl."','".$wh_staff."','outgoing','".$wh_expired."','".$wh_memo."','".$wh_etc."','".$wh_etccode."','".$wh_etcstaff."','".$wh_etcphone."','".$wh_etczipcode."','".$wh_etcaddress."',sysdate,'Y',sysdate); ";
					//echo $sql."<br>";
					//dbqry($sql);
					//약재함재고추가 
					//$sql=" update ".$dbH."_medibox set mb_stock='".$wh_code."', mb_capacity = mb_capacity + ".$wh_qty.", mb_modify=sysdate where mb_table = '".$wh_table."' and mb_medicine = '".$wh_stock."'  ";
					$sql=" update ".$dbH."_medibox set mb_stock='".$wh_code."', mb_capacity = ".$wh_qty.", mb_modify=sysdate where mb_table = '".$wh_table."' and mb_medicine = '".$wh_stock."'  ";
					echo $sql."<br>";
					//dbqry($sql);
				}
			}

		}
	}
?>
