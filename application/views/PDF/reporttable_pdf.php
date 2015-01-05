<?php
tcpdf();

class MYPDF extends TCPDF {
  public function Header() {
    // Logo
    $image_file = K_PATH_IMAGES.'all_logos.jpg';
  //  fn_print_die($image_file);
    $this->Image($image_file, 69, 10, 120, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
  }
  public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-10);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
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

// page orientation
$pdf->setPageOrientation('L');

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------Attendance report table ---------------------------------------------------
$datenow = date('F d, Y');

$pdf->SetFont('helvetica','B', 14);
$pdf->AddPage();
$pdf->Write(10, 'DAILY ATTENDANCE REPORT', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica','N', 12);
$pdf->Write(10, 'Summary', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica','N', 12);
$pdf->Write(10, $datenow, '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 10);

$html = <<<EOF

EOF;


$html .= $report_table;

$pdf->writeHTML($html, true, false, true, false, '');

// ----------------------------------------------------------------------------------------------------------------------------------//

//Close and output PDF document
$pdf->Output('report.pdf', 'I'); //employee record name

//============================================================+
// END OF FILE
//============================================================+
