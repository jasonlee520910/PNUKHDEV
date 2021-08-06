<?php
	/// 오라클 DB 연결
	function dbconn($host, $user, $pass, $db)
	{
		$dns = "
			(DESCRIPTION =
				(ADDRESS_LIST =
					(ADDRESS = 
						(PROTOCOL = TCP)
						(HOST = ".$host.")
						(PORT = 1521)
					)
				)
				(CONNECT_DATA =
					(SERVICE_NAME = Orcl)
				)
			)
		";

		return oci_connect($user, $pass, $dns,'AL32UTF8');
	}

	/// select query 여러개 
	function dbqry($sql, $error=TRUE)
	{
		global $select_db;
		$result = oci_parse($select_db, $sql);
		oci_execute($result);
		return $result;
	}
	/// insert, update 일경우에는 이 함수를 써야함. 
	function dbcommit($sql)
	{
		global $select_db;
		$result = oci_parse($select_db, $sql);
		oci_execute($result, OCI_NO_AUTO_COMMIT);
		oci_commit($select_db);
	}
	/// 결과값에서 한행 연관배열(이름으로)로 얻는다.
	function dbarr($result){
		$row = oci_fetch_array($result, OCI_BOTH);
		return $row;
	}
	/// select query에서 뽑은 데이터의 총 갯수 
	function dbrows($sql)
	{
		global $select_db;
		$tsql=" select count(*) as total from (".$sql.")";
		$result = oci_parse($select_db, $tsql);
		oci_execute($result);
		$row = dbarr($result);
		return $row["TOTAL"];
		//return oci_num_rows($result);//이건 0만 나옴..
	}
	/// 메모리해제 
	function dbfree($result)
	{
		oci_free_statement($result);
	}

	/// select query 한개 
	function dbone($sql, $error=TRUE){
		global $select_db;
		$result = oci_parse($select_db, $sql);
		oci_execute($result);
		$row = dbarr($result);
		return $row;
	}



?>