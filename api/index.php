<?php   echo "부산대 LIVE API"."<br>";
	error_reporting(E_ALL);

	ini_set("display_errors", 1);

	$mtimearr=microtime();
	var_dump($mtimearr);
	$mtime=explode(" ",$mtimearr);
	$startmicro=substr($mtime[0], 0, 8);
	

	$conn = oracle_open();
	if(!$conn) {echo "<script>alert('부산대 SERVER ERROR!!!-');</script>";exit;}

	
	$query="  select CD_SEQ,CD_TYPE,CD_TYPE_KOR,CD_TYPE_CHN,CD_CODE,CD_NAME_KOR,CD_NAME_CHN,CD_DESC_KOR,CD_DESC_CHN,CD_SORT,CD_VALUE_KOR,CD_VALUE_CHN,CD_MODIFY from han_code   where cd_use <> 'D' and cd_type = 'approvalUse'  order by cd_sort ";

	$stid = oci_parse($conn, $query);
	oci_execute($stid);

	while (($row = oci_fetch_array($stid, OCI_BOTH))) 
	{
		echo $row["CD_SEQ"]."(".$row["CD_TYPE"].")<br>";
	}

	$total=oci_num_rows($stid);
	oci_free_statement($stid);
	oci_close($conn);

	$etimearr=microtime();
	var_dump($etimearr);
	$etime=explode(" ",$etimearr);
	$endmicro=substr($etime[0], 0, 8);


	$leadmicro=$endmicro-$startmicro;


	echo "startmicro : ".$startmicro.", endmicro : ".$endmicro." = ".$leadmicro."<br>";
?>
<?php
//오라클 접속정보 초기화
function oracle_open() 
{        
	$user='djmedi';
	$passwd='c#1234';
	$dns = "
		(DESCRIPTION =
			(ADDRESS_LIST =
				(ADDRESS = 
					(PROTOCOL = TCP)
					(HOST = 27.96.135.37)
					(PORT = 1521)
				)
			)
			(CONNECT_DATA =
				(SERVICE_NAME = Orcl)
			)
		)
	";

	return oci_connect($user, $passwd, $dns,'AL32UTF8');
}
?>
