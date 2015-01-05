<?php
$search = $_GET['search'];
$fieldname = $_GET['fieldname'];
$sort = $_GET['sort'];
if($fieldname == "emp_code") {
$result = mysql_query("SELECT *, tbl_request.id as rid FROM tbl_request 
						INNER JOIN tbl_employee_info ON tbl_request.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						WHERE tbl_employee_info.company LIKE '%$search%'
						OR tbl_employee_info.department LIKE '%$search%'
						OR tbl_employee_info.position LIKE '%$search%'
						OR tbl_request.emp_code LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_request.purpose LIKE '%$search%'
						ORDER BY tbl_request.$fieldname $sort") or die(mysql_error());
}else {
$result = mysql_query("SELECT *, tbl_request.id as rid FROM tbl_request 
						INNER JOIN tbl_employee_info ON tbl_request.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						WHERE tbl_employee_info.company LIKE '%$search%'
						OR tbl_employee_info.department LIKE '%$search%'
						OR tbl_employee_info.position LIKE '%$search%'
						OR tbl_request.emp_code LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_request.purpose LIKE '%$search%'
						ORDER BY $fieldname $sort") or die(mysql_error());
}
		while($row = mysql_fetch_array($result)) {
			Echo "<tr id=" .$row['rid']. ">";
				Echo "<td width='88.89px'>" .$row['company']. "</td>";
				Echo "<td width='88.89px'>" .$row['department']. "</td>";
				Echo "<td width='88.89px'>" .$row['position']. "</td>";
				Echo "<td width='88.89px'>" .$row['emp_code']. "</td>";
				Echo "<td width='88.89px'>" .$row['firstname']. " " .$row['middlename']. " " .$row['lastname']. "</td>";
				Echo "<td width='88.89px'>" .$row['purpose']. "</td>";
				$date = date_create();
					date_timestamp_set($date, $row['date_filed']);
				Echo "<td width='88.89px'>" .date_format($date, 'Y-m-d H:i:s'). "</td>";
				Echo "<td width='88.89px'><a class='editlink btn btn-warning'><span class='glyphicon glyphicon-pencil'></span> Edit</a></td>";
				Echo "<td width='88.89px'><a class='deletelink btn btn-primary'><span class='glyphicon glyphicon-trash'></span> Delete</a></td>";
			Echo "</tr>";
		}
?>