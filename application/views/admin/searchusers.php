<?php
$search = $_GET['search'];
$fieldname = $_GET['fieldname'];
$sort = $_GET['sort'];



/*
$this->db->select('*, tbl_logins.id as tl_id');
$this->db->from('tbl_logins');
$this->db->join('tbl_employee_info', 'tbl_logins.emp_id = tbl_employee_info.emp_id', 'inner');
$this->db->join('tbl_person_info', 'tbl_person_info.id = tbl_employee_info.emp_id', 'inner');

$this->db->like('tbl_employee_info.company', $search);
$this->db->or_like('tbl_logins.username', $search);
$this->db->or_like('tbl_person_info.lastname', $search);
$this->db->or_like('tbl_person_info.firstname', $search);
$this->db->or_like('tbl_person_info.middlename', $search);

$this->db->order_by($fieldname, $sort); 


$query = $this->db->get();*/





$result = mysql_query("SELECT *, tbl_logins.id as tl_id FROM tbl_logins 
						INNER JOIN tbl_employee_info ON tbl_logins.emp_id = tbl_employee_info.emp_id
						INNER JOIN tbl_person_info ON tbl_person_info.id = tbl_employee_info.emp_id
						WHERE tbl_employee_info.company LIKE '%$search%'
						OR tbl_logins.username LIKE '%$search%'	
						OR tbl_person_info.lastname LIKE '%$search%'
						OR tbl_person_info.firstname LIKE '%$search%'
						OR tbl_person_info.middlename LIKE '%$search%'
						ORDER BY $fieldname $sort") or die(mysql_error());
						
		echo "<tbody>";
		
		while($row = mysql_fetch_array($result)) {
			Echo "<tr id=" .$row['tl_id']. ">";
				Echo "<td>" .$row['company']. "</td>";
				Echo "<td>" .$row['username']. "</td>";
				Echo "<td>" .$row['lastname']. "</td>";
				Echo "<td>" .$row['firstname']. "</td>";
				Echo "<td>" .$row['middlename']. "</td>";
				Echo "<td align='center' colspan='2'><a class='printpdf btn btn-default'><span class='glyphicon glyphicon-eye-open'></span> PDF</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='edituser btn btn-warning' target='_blank' href=../employee/employee_edit?username=" .$row['username']. "><span class='glyphicon glyphicon-pencil'></span> Edit</a></td>";
			Echo "</tr>";
		}
		
		echo "</tbody>";
		
		

?>

		