<?php
session_start();
require('tcpdf/tcpdf.php');
require('../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");


class MYPDF extends TCPDF
{
  protected $last_page_flag = false;

  public function Close()
  {
    $this->last_page_flag = true;
    parent::Close();
  }
  //Pag
  //Page header
  public function Header()
  {
    $datetime = new DatetimeTH();


    $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));

    if ($this->page == 1) {
      // Logo
      $image_file = "../assets/dist/img/logo_Nsupply.png";
      $this->Image($image_file, 10, 10, 33, 12, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // Set font
      $this->SetFont(' thsarabunnew', '', 12);
      // Title
      $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');

      $this->Ln(5);

      $this->SetFont('thsarabunnew', 'b', 18);
      $this->Cell(0, 10, "ใบรายการจ่ายของประจำวัน", 0, 1, 'C');
    } else {
      $this->SetFont(' thsarabunnew', '', 12);
      $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');
      $this->SetFont(' thsarabunnew', '', 12);
      $this->SetY(21);
    }
  }
  // Page footer
  public function Footer()
  {
    $this->SetY(-40);

    if ($this->last_page_flag) {

      $this->SetFont('  thsarabunnew', 'i', 13);
      $this->Cell(90, 10,   "ลงชื่อ" . "..................................................." . "เจ้าหน้าที่จัดของ", 0, 0, 'L');
      $this->Cell(50, 10,   "วันที่" . "........................................" . "เวลา" . ".............................", 0, 1, 'L');

      $this->SetFont('  thsarabunnew', 'i', 13);
      $this->Cell(90, 10,   "ลงชื่อ" . "..................................................." . "เจ้าหน้าที่ส่งของ", 0, 0, 'L');
      $this->Cell(50, 10,   "วันที่" . "........................................" . "เวลา" . ".............................", 0, 1, 'L');

      $this->SetFont('  thsarabunnew', 'i', 13);
      $this->Cell(90, 10,   "ลงชื่อ" . "..................................................." . "เจ้าหน้าที่รับของ", 0, 0, 'L');
      $this->Cell(50, 10,   "วันที่" . "........................................" . "เวลา" . ".............................", 0, 1, 'L');


    }
    // Arial italic 8
    $this->SetFont('thsarabunnew', 'i', 12);
    // Page number

    $this->Cell(190, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
  }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report_Shelfcount');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 35);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------
$height = 7;
$docNo = $_GET['docNo'];
$pdf->AddPage('P', 'A4');
$pdf->Ln(10);

$query = "SELECT
          shelfcount.docNo,
          CASE
              WHEN shelfcount.isStatus = 1 THEN 'Completed' ELSE 'OnProcess' 
          END   AS isStatusText ,
          site.siteName,
          department.departmentName,
          DATE(shelfcount.createAt) AS createAt
        FROM
          shelfcount
          INNER JOIN site ON shelfcount.siteID = site.siteID
          INNER JOIN department ON shelfcount.departmentID = department.departmentID 
        WHERE shelfcount.docNo = '$docNo' ";
$meQuery = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($meQuery)) {

  $createAt = explode('-', $row['createAt']);
  $createAt = $createAt[2] . "-" . $createAt[1] . "-" . $createAt[0];

  $pdf->SetFont('thsarabunnew', 'b', 16);
  $pdf->Cell(30, $height, "เลขที่เอกสาร :", 0, 0, 'R');
  $pdf->SetFont('thsarabunnew', '', 16);
  $pdf->Cell(65, $height, $row['docNo'], 0, 0, 'L');


  $pdf->SetFont('thsarabunnew', 'b', 16);
  $pdf->Cell(50, $height, "Status :", 0, 0, 'R');
  $pdf->SetFont('thsarabunnew', '', 16);
  $pdf->Cell(65, $height, $row['isStatusText'], 0, 1, 'L');

  $pdf->SetFont('thsarabunnew', 'b', 16);
  $pdf->Cell(30, $height, "โรงพยาบาล :", 0, 0, 'R');
  $pdf->SetFont('thsarabunnew', '', 16);
  $pdf->Cell(65, $height, $row['siteName'], 0, 1, 'L');

  $pdf->SetFont('thsarabunnew', 'b', 16);
  $pdf->Cell(30, $height, "แผนก :", 0, 0, 'R');
  $pdf->SetFont('thsarabunnew', '', 16);
  $pdf->Cell(65, $height, $row['departmentName'], 0, 1, 'L');

  $pdf->SetFont('thsarabunnew', 'b', 16);
  $pdf->Cell(30, $height, "วันที่ :", 0, 0, 'R');
  $pdf->SetFont('thsarabunnew', '', 16);
  $pdf->Cell(65, $height, $createAt, 0, 0, 'L');
}
$pdf->Ln(15);

$html = '<table border="1" cellspacing="0" cellpadding="1">';
$html .= '<thead style="font-weight:bold;">';
$html .= '<tr>';
$html .= '<th colspan="1" align="center" style="width:10%"><b>No</b></th>';
$html .= '<th colspan="1" align="center" style="width:30%"><b>Item Name</b></th>';
$html .= '<th colspan="1" align="center" style="width:30%"><b>Par Item Stock</b></th>';
$html .= '<th colspan="1" align="center" style="width:30%"><b>Issue</b></th>';
$html .= '</tr>';
$html .= '</thead>';

$count = 1;
$query = "SELECT
            item.itemName,
            item.itemID,
            shelfcount_detail.rowID,
            shelfcount_detail.parQty,
            shelfcount_detail.scQty,
            (	shelfcount_detail.parQty - shelfcount_detail.scQty) AS maxQty ,
            shelfcount_detail.issueQty 
          FROM
          shelfcount_detail
          INNER JOIN item ON shelfcount_detail.itemID = item.itemID
          WHERE shelfcount_detail.docNo = '$docNo' 
          ORDER BY item.itemName ASC ";
$meQuery = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($meQuery)) {

  $html .= '<tr>';
  $html .= '<td colspan="1" align="center" style="width:10%">' . $count . '</td>';
  $html .= '<td colspan="1" align="center" style="width:30%">' . $row['itemName'] . '</td>';
  $html .= '<td colspan="1" align="center" style="width:30%">' . $row['parQty'] . '</td>';
  $html .= '<td colspan="1" align="center" style="width:30%">' . number_format($row['issueQty'],0) . '</td>';
  $html .= '</tr>';


  $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, false, false, true, false, '');



//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Shelfcount' . $date . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
