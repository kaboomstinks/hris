<?php
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED); 
	$localhost ='192.168.128.30';
	$username ='ccstimekeeper';
	$password ='qEJKaPpGh55d2ZYu';
	$databasename ='ccstimekeeper';
	ini_set('memory_limit', '-1');
	$connection = mysql_connect($localhost,$username,$password) or die(mysql_error());
	mysql_select_db($databasename,$connection);


	$shiftData = $_POST['shiftdata'];
	$startdate = date("2015-01-27 06:00:00");// 7:59AM testing today
	$enddate = date("2015-01-27 11:00:00");


	$defaultSql = "select  distinct dwEnrollNo, glID ,
				  	dwMachineNo, dwEnrollNo, dwInOut,dwVerify, 
				  	dwYear ,dwMonth, dwDay,dwHour, dwMinute ,
				  	glTimeStamp ,glReadFlag ,glEntryDate   
				  FROM  generallogdata 
				  	WHERE  glTimeStamp   BETWEEN '$startdate' AND '$enddate'   
				  GROUP  BY  dwEnrollNo ORDER BY glTimeStamp DESC";

			
	if ($shiftData == 2) // PM SHIFT
	{

		$date = "2015-01-27 14:00:00";
		$yesterday = date('Y-m-d H:i:s', strtotime($date . "-1 day"));

		$date1 = "2015-01-27 22:00:00";
		$yesterday1 = date('Y-m-d H:i:s', strtotime($date1 . "-1 day"));

	$startdate = $yesterday;
	$enddate = $yesterday1;
	 	$defaultSql = "select  distinct dwEnrollNo, glID ,
				  dwMachineNo, dwEnrollNo, dwInOut,dwVerify, 
				  dwYear ,dwMonth, dwDay,dwHour, dwMinute ,
				  glTimeStamp ,glReadFlag ,glEntryDate   
				  FROM  generallogdata 
				  WHERE  glTimeStamp   BETWEEN '$startdate' AND '$enddate'   
				  GROUP  BY  dwEnrollNo ORDER BY glTimeStamp DESC";
	}

	if($shiftData == 3) { //Mid Shift

		$startdate = date("2015-01-27 07:00:00"); // testing today
		$enddate = date("2015-01-27 12:00:00")	;

	 	$defaultSql = "select  distinct dwEnrollNo, glID ,
				  dwMachineNo, dwEnrollNo, dwInOut,dwVerify, 
				  dwYear ,dwMonth, dwDay,dwHour, dwMinute ,
				  glTimeStamp ,glReadFlag ,glEntryDate   
				  FROM  generallogdata 
				  WHERE  glTimeStamp   BETWEEN '$startdate' AND '$enddate'   
				  GROUP  BY  dwEnrollNo ORDER BY glTimeStamp DESC";

	}
	      // echo $defaultSql;

	$date = date("Y-m-d");
	
	$sql = mysql_query($defaultSql) or die(mysql_error());

	// available fields 
	/*
	glID,dwMachineNo,dwEnrollNo,dwInOut,dwVerify,dwYear,dwMonth,dwDay,dwHour,dwMinute,glTimeStamp,glReadFlag,glEntryDate
	*/
	$header = "No\tMchn\tEnNo\t\tName\t\tMode\tIOMd\tDateTime\t\r\n";
	$content ='';
	$file = 'document/bio_dumy.txt';
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

	
	echo  json_encode(array('response' => 1, 'filegen'=>$file,'shift'=>$shiftData))
?>