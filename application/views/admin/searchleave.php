<?php
$search = $_GET['search'];
$fieldname = $_GET['fieldname'];
$sort = $_GET['sort'];
$status = $_GET['status'];
if($fieldname == 'emp_code') {
$result = mysql_query("SELECT *, tbl_leaves.id as tl_id FROM tbl_leaves 
						INNER JOIN tbl_employee_info ON tbl_leaves.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						WHERE tbl_leaves.status = $status
						AND (tbl_employee_info.company LIKE '%$search%'
						OR tbl_employee_info.department LIKE '%$search%'
						OR tbl_employee_info.position LIKE '%$search%'
						OR tbl_leaves.emp_code LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_leaves.type LIKE '%$search%')
						ORDER BY tbl_employee_info.$fieldname $sort") or die(mysql_error());
}else {
$result = mysql_query("SELECT *, tbl_leaves.id as tl_id FROM tbl_leaves 
						INNER JOIN tbl_employee_info ON tbl_leaves.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						WHERE tbl_leaves.status = $status
						AND (tbl_employee_info.company LIKE '%$search%'
						OR tbl_employee_info.department LIKE '%$search%'
						OR tbl_employee_info.position LIKE '%$search%'
						OR tbl_leaves.emp_code LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_leaves.type LIKE '%$search%')
						ORDER BY $fieldname $sort") or die(mysql_error());
}
		Echo "<tbody>";
		while($row = mysql_fetch_array($result)) {
			Echo "<tr id=" .$row['tl_id']. ">";
				Echo "<td width='80px'>" .$row['company']. "</td>";
				Echo "<td width='80px'>" .$row['department']. "</td>";
				Echo "<td width='80px'>" .$row['position']. "</td>";
				Echo "<td width='80px'>" .$row['emp_code']. "</td>";
				Echo "<td width='80px'>" .$row['firstname']. " " .$row['middlename']. " " .$row['lastname']. "</td>";
				Echo "<td width='80px'>" .$row['type']. "</td>";
				Echo "<td width='80px'>" .$row['date_from']. "</td>";
				Echo "<td width='80px'>" .$row['date_to']. "</td>";
				Echo "<td width='80px'><a class='editlink btn btn-warning'><span class='glyphicon glyphicon-pencil'></span> Edit</a></td>";
				Echo "<td width='80px'><a class='deletelink btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Delete</a></td>";
			Echo "</tr>";
		}
		Echo "</tbody>";
?>