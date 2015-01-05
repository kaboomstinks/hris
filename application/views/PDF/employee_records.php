<?php
//require_once('tcpdf_include.php');
tcpdf();
$thisid = $_GET['id'];
$selectData = mysql_query("
  SELECT * 
  FROM tbl_person_info
  JOIN tbl_employee_info ON tbl_person_info.id = tbl_employee_info.emp_id
  JOIN tbl_employee_emergency_info ON tbl_employee_emergency_info.emp_id = tbl_employee_info.emp_id
  WHERE tbl_person_info.id = $thisid
");
$result = mysql_fetch_row($selectData);
$empstatus = "N/A";
/*if($result[13] == 0) { $empstatus = "Probationary"; }
	else if($result[13] == 1) { $empstatus = "Regular"; }
		else if($result[13] == 2) { $empstatus = "Casual/Others"; }*/

//$thisquery = mysql_fetch_assoc($selectData);
class MYPDF extends TCPDF {
  public function Header() {
    // Logo
    $image_file = K_PATH_IMAGES.'circus_logo.jpg';
    $this->Image($image_file, 89, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
  }
  public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-25);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Page number

    //$this->Cell(0, 0,'11F Tower 1, The Enterprise Center, 6766 Ayala Ave, Makati 1220 Philippines', 1, false, 'C', 0, '', 0, false, 'T', 'M');
    // $this->Cell(0, 10, 'Phone. +63-2-556-7777 Fax. +63-2-556-333', 1, false, 'C', 0, '', 0, false, 'T', 'M');
    //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    
  }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetAutoPageBreak(TRUE, 0);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(15, 42, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// --------------------------------------------------- EMPLOYEE DATA SHEET ---------------------------------------------------
$pdf->SetFont('helvetica','N', 15);
$pdf->AddPage();
$tbl = <<<EOD
<hr />
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf->Write(10, 'EMPLOYEE DATA SHEET', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica','N', 12);
$tbl = <<<EOD
<hr />
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf->Write(10, 'For Newly Hired Employees', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 10);
$tbl = <<<EOD
<table border="1" width="100%">
  <tr>
    <td align="center" width="30%">Title</td>
    <td align="center" width="40%">Contents</td>
    <td align="center" width="30%">Note</td>
  </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');


$html = '
<table border="0" width="100%" cellpadding="1">
	<tr>
		<td width="30%"></td>
		<td width="40%"></td>
		<td width="30%"></td>
	</tr>
	<tr>
		<td align="right">Employer : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[27].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Employer Name : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[3].', '.$result[1].' '.$result[2].' </td>
		<td></td>
	</tr>
	<tr>
		<td align="right" padding-top: 2px;>Employee No. : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;" > '.$result[26].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Employee Address : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[5].', '.$result[6].', '.$result[7].', '.$result[8].'</td>
		<td></td>
		</tr>
	<tr>
		<td align="right">Nickname : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[4].'</td>
		<td></td>
	</tr>
 	 <tr>
		<td align="right">Date of Birth : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[13].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Place of Birth : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[14].'</td>
    <td></td>
	</tr>
	<tr>
		<td align="right">Employee Status : </td>
    <td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[31].'</td>
    <td></td>
	</tr>
	<tr>
		<td align="right">Date of Hire : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[32].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Date of Regularization : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[33].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Tax Identification No. (TIN) : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[17].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Social Security System No(SSS) : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[18].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Philhealth No. (PHIC) : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[19].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Pag-ibig : </td>
		<td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[20].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center"></td>
	</tr>
  <tr>
    <td align="right">Department : </td>
    <td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[29].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Position : </td>
    <td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[30].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Gender : </td>
    <td style="border-bottom-width: 1px black;"> '.$result[15].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Civil Status : </td>
    <td style="font-size:15px; border-bottom-width: 1px black;"> '.$result[16].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');

$tbl = <<<EOD
<br /><br /><br />
<table border="0" align="center">
  <tr>
      <td align="right">Employee Signature : ____________________</td>
      <td align="center">Date : _____________________</td>
  </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<br /><br /><br /><br /><br /><br /><br />
<hr />
<table border="0" align="center">
  <tr>
      <td align="center">11F Tower 1, The Enterprise Center, 6766 Ayala Ave, Makati 1220 Philippines <br /> Phone. +63-2-556-7777 Fax. +63-2-556-333</td>
  </tr>
</table>
<hr />
<span align="center">www.circus.ac / info@circus.ac</span>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

/*// --------------------------------------------------- PRE-EMPLOYMENT REQUIREMENTS ---------------------------------------------------
$pdf->SetFont('helvetica','N', 15);
$pdf->AddPage();
$tbl = <<<EOD
<hr />
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf->Write(10, 'PRE-EMPLOYMENT REQUIREMENTS', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica','N', 12);
$tbl = <<<EOD
<hr />
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf->Write(10, 'For Newly Hired Employees', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 10);
$tbl = <<<EOD
<table border="1" width="100%">
  <tr>
    <td align="center">Title</td>
    <td align="center">Contents</td>
    <td align="center">Note</td>
  </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<table border="0">
  <tr>
    <td align="center">A)</td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Updated Resume : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Transcript of Records : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Diploma : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">BIR Form 2316 from previous employer (if applicable)  : </td>
    <td align="center"><br /><br />______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">2x2 and 1x1 Colored Picture (White background) : </td>
    <td align="center"><br /><br />______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center">B)</td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Tax Identification No. (TIN) : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Social Security System No. (SSS) : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Philhealth No. (PHIC) : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Home Development Mutual Fund No. (Pag-ibig) : </td>
    <td align="center"><br /><br />______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">NBI Clearance : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Police Clearance : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Birth Certificate : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Marriage Certificate (if applicable) : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Birth Certificate of Children <br />(if applicable) : </td>
    <td align="center"><br /><br />______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Community Tax Certificate (CTC) : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Residence Location Map : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Clearance from latest employer <br /> (if applicable) : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center">C)</td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">BIR Form 1902 : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">BIR Form 1905 : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">BIR Form 2305 : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="right">Emergency Contact Form : </td>
    <td align="center">______________________________</td>
    <td align="center"></td>
  </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<br /><br /><br />
<br /><br />
<table border="0" align="center">
  <tr>
      <td align="right">Employee Signature : ____________________</td>
      <td align="center">Date : _____________________</td>
  </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<br /><br /><br />
<br /><br />
<br />
<hr />
<table border="0" align="center">
  <tr>
      <td align="center">11F Tower 1, The Enterprise Center, 6766 Ayala Ave, Makati 1220 Philippines <br /> Phone. +63-2-556-7777 Fax. +63-2-556-333</td>
  </tr>
</table>
<hr />
<span align="center">www.circus.ac / info@circus.ac</span>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');*/
/*
// set border width
$pdf->SetLineWidth(.5);

// set color for cell border
$pdf->SetDrawColor(0,0,0);

// set filling color
$pdf->SetFillColor(255,255,255);
$pdf->SetXY(10, 80);
// set cell height ratio
$pdf->setCellHeightRatio(50);
$pdf->Ln(0);
$pdf->Cell(60, 0, 'asdsa', 'LR', 1, 'C', 1, '', 0, false, 'T', 'C');*/
// -------------------------------------------------------- EMERGENCY CONTACT FORM --------------------------------------------------------
$pdf->SetFont('helvetica','N', 15);
$pdf->AddPage();
$tbl = <<<EOD
<hr />
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf->Write(10, 'EMERGENCY CONTACT FORM', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica','N', 12);
$tbl = <<<EOD
<hr />
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf->Write(10, 'For HR/Admin Use', '', 0, 'C', true, 0, false, false, 0);

$tbl = <<<EOD
<hr />
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf->Write(5, 'Contents', '', 0, 'C', true, 0, false, false, 0);

// -----------------------------------------------------------------------------
//Name
$pdf->SetFont('helvetica', '', 10);
$html = '
<hr />
<br />
<table border="1" cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td>Employee Name: </td>
        <td align="center" style="border-bottom-width: 1px black; font-size:15px;">' .$result[1]. '</td>
        <td align="center" style="border-bottom-width: 1px black; font-size:15px;">' .$result[2]. '</td>
        <td align="center" style="border-bottom-width: 1px black; font-size:15px;">' .$result[3]. '</td>
    </tr>
    <tr>
        <td></td>
        <td align="center">First Name</td>
        <td align="center">Middle Name</td>
        <td align="center">Last Name</td>
    </tr>
</table>
<br />';

$pdf->writeHTML($html, true, false, false, false, '');

// -----------------------------------------------------------------------------
// Address
$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td>Address:</td>
    </tr>
    <tr>
        <td style="border-bottom-width: 1px black; font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $result[5], $result[6], $result[7]</td>
    </tr>
</table>
<br />
<hr />
<br />
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
// CONTACT
$tbl = <<<EOD
<table cellspacing="1" cellpadding="1" border="0">
    <tr>
        <td style="border-bottom-width: 1px black;">Home Phone : <span style="font-size:15px;">$result[11]</span></td>
        <td style="border-bottom-width: 1px black;">Mobile Phone : <span style="font-size:15px;">$result[12]</span></td>
    </tr>
    <tr>
        <td style="border-bottom-width: 1px black;">Social Security System No. : <span style="font-size:15px;">$result[18]</span></td>
        <td style="border-bottom-width: 1px black;">Date of Birth : <span style="font-size:15px;">$result[13]</span></td>
    </tr>
</table>
<br />
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
// EMERGENCY 1

$tbl = <<<EOD
<br /><br />
<br /><br />
<table cellspacing="1" cellpadding="1" border="0">
    <tr>
        <td>In case of emergency, notify:</td>
        <td align="center" style="border-bottom-width: 1px black; font-size:15px;">$result[40], $result[38] $result[39]</td>
        <td align="center" style="border-bottom-width: 1px black; font-size:15px;">$result[41]</td>
    </tr>
    <tr>
        <td></td>
        <td align="center" >Name</td>
        <td align="center" >Relationship</td>
    </tr>
</table>
<br />
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------
// EMERGENCY Contact 1
$tbl = <<<EOD
<table cellspacing="1" cellpadding="1" border="0">
    <tr>
        <td style="border-bottom-width: 1px black;">Home Phone : <span style="font-size:15px;">$result[42]</span></td>
        <td style="border-bottom-width: 1px black;">Mobile Phone : <span style="font-size:15px;">$result[43]</span></td>
    </tr>
</table>
<br />
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<br /><br /><br /><br />
<br /><br /><br />
<table border="0" align="center">
  <tr>
      <td align="right">Employee Signature : ____________________</td>
      <td align="center">Date : _____________________</td>
  </tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = <<<EOD
<br /><br /><br /><br /><br />
<br /><br /><br /><br />
<br /><br /><br /><br />
<hr />
<table border="0" align="center">
  <tr>
      <td align="center">11F Tower 1, The Enterprise Center, 6766 Ayala Ave, Makati 1220 Philippines <br /> Phone. +63-2-556-7777 Fax. +63-2-556-333</td>
  </tr>
</table>
<hr />
<span align="center">www.circus.ac / info@circus.ac</span>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('emplyee_record.pdf', 'I'); //employee record name

//============================================================+
// END OF FILE
//============================================================+
