<?php
//require_once('tcpdf_include.php');
tcpdf();
$thisid = $_GET['id'];
$selectData = mysql_query("
  SELECT * 
  FROM tbl_person_info
  JOIN tbl_employee_info ON tbl_person_info.id = tbl_employee_info.emp_id
  JOIN tbl_employee_emergency_info ON tbl_employee_emergency_info.emp_id = tbl_employee_info.emp_id
  JOIN tbl_departments ON tbl_employee_info.department  = tbl_departments.id
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
    $this->Image($image_file, 89, 2, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
  }
  public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-10);
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
$pdf->SetMargins(15, 35, 15);
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

$html = <<<EOF

EOF;

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
<style>
.datafile {
	font-size:15px; border-bottom-width: 1px black;
}
</style>

<table border="0" width="100%">
	<tr>
		<td width="30%" align="right">Employer : </td>
		<td width="40%" class="datafile">  '.$result[27].'</td>
		<td width="30%"></td>
	</tr>
	<tr>
		<td align="right">Employer Name : </td>
    <td class="datafile">  ';
    if(!empty($result[3])) { $html .= $result[3]. ', '; }
      if(!empty($result[1])) { $html .= $result[1]. ' '; }
        if(!empty($result[2])) { $html .= $result[2]; }
    $html .= '</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Employee No. : </td>
		<td class="datafile">  '.$result[26].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Employee Address : </td>
		<td class="datafile">  ';
    if(!empty($result[5])) { $html .= $result[5]. ', '; }
      if(!empty($result[6])) { $html .= $result[6]. ', '; }
        if(!empty($result[7])) { $html .= $result[7]. ', '; }
          if(!empty($result[8])) { $html .= $result[8]; }
    $html .= '</td>
		<td></td>
		</tr>
	<tr>
		<td align="right">Nickname : </td>
		<td class="datafile">  '.$result[4].'</td>
		<td></td>
	</tr>
 	 <tr>
		<td align="right">Date of Birth : </td>
		<td class="datafile">  '.$result[13].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Place of Birth : </td>
		<td class="datafile">  '.$result[14].'</td>
    <td></td>
	</tr>
	<tr>
		<td align="right">Employee Status : </td>
    <td class="datafile">  '.$result[31].'</td>
    <td></td>
	</tr>
	<tr>
		<td align="right">Date of Hire : </td>
		<td class="datafile">  '.$result[32].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Date of Regularization : </td>
		<td class="datafile">  '.$result[33].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Tax Identification No. (TIN) : </td>
		<td class="datafile">  '.$result[17].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Social Security System No.(SSS) : </td>
		<td class="datafile">  '.$result[18].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Philhealth No. (PHIC) : </td>
		<td class="datafile">  '.$result[19].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">Pag-ibig : </td>
		<td class="datafile">  '.$result[20].'</td>
		<td></td>
	</tr>
	<tr>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center"></td>
	</tr>
  <tr>
    <td align="right">Department : </td>
    <td class="datafile">  '.$result[48].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Position : </td>
    <td class="datafile">  '.$result[30].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Gender : </td>
    <td class="datafile">  '.$result[15].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Civil Status : </td>
    <td class="datafile">  '.$result[16].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
  <tr>
    <td colspan="2">IN CASE OF EMERGENCY, NOTIFY:</td>
    <td></td>
  </tr><br />
  <tr>
    <td align="right">Name : </td>
    <td class="datafile">  ';
    if(!empty($result[41])) { $html .= $result[41]. ', '; }
      if(!empty($result[40])) { $html .= $result[40]. ' '; }
        if(!empty($result[42])) { $html .= $result[42]; }
    $html .= '</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Relationship : </td>
    <td class="datafile">  '.$result[43].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Home Phone : </td>
    <td class="datafile">  '.$result[44].'</td>
    <td></td>
  </tr>
  <tr>
    <td align="right">Mobile Phone : </td>
    <td class="datafile">  '.$result[45].'</td>
    <td></td>
  </tr>
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');

$tbl = <<<EOD
<br /><br /><br /><br /><br />
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
$pdf->Output($result[26]. '_record.pdf', 'I'); //employee record name

//============================================================+
// END OF FILE
//============================================================+
