<?php
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED); 
	$localhost ='192.168.128.30';
	$username ='ccstimekeeper';
	$password ='qEJKaPpGh55d2ZYu';
	$databasename ='ccstimekeeper';
	ini_set('memory_limit', '-1');
	$connection = mysql_connect($localhost,$username,$password) or die(mysql_error());
	mysql_select_db($databasename,$connection);


	$defaultSql = "SELECT DISTINCT dwEnrollNo, glID ,
				  	dwMachineNo, dwEnrollNo, dwInOut,dwVerify, 
				  	dwYear ,dwMonth, dwDay,dwHour, dwMinute ,
				  	glTimeStamp ,glReadFlag ,glEntryDate   
				  FROM  generallogdata 
				  WHERE  glTimeStamp >= '2015-01-01 00:00:00'
				  GROUP BY dwEnrollNo, glTimeStamp
				  ORDER BY glTimeStamp ASC";
				
	$sql = mysql_query($defaultSql) or die(mysql_error());

	// available fields 
	/*
	glID,dwMachineNo,dwEnrollNo,dwInOut,dwVerify,dwYear,dwMonth,dwDay,dwHour,dwMinute,glTimeStamp,glReadFlag,glEntryDate
	*/
	$header = "No\tMchn\tEnNo\t\tName\t\tMode\tIOMd\tDateTime\t\r\n";
	$content ='';
	$file = 'document/biometrics_data.txt';
	$contentctr = 0;
	while ($r = mysql_fetch_object($sql))
	{
			
			$content .="$r->glID\t"; // No
			$content .="$r->dwMachineNo\t"; // Mchno
			$enrolno = substr('000000000000' . $r->dwEnrollNo, -8);
			$content .="$enrolno\t"; // Enno
			$content .="          \t"; // Name its empty
			$content .="$r->dwVerify\t"; // Mode
			$content .="$r->glReadFlag\t"; // IOMD
			$rawDate = strtotime( $r->glTimeStamp );
			$formatDate = date( 'Y/m/d  H:i', $rawDate );
			$content .="$formatDate"; // Date and time // 2013/09/20 
			$content .="\r\n";
			$contentctr++;

	}
	$record_data = $header.$content;
	file_put_contents($file, $record_data);
	if ($contentctr == 0)
	{
		echo json_encode(array('response'=>0,'filegen' =>''));
		die();
	}

	
	echo  json_encode(array('response' => 1, 'filegen'=>$file));
?>