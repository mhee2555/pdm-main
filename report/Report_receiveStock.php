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
      $this->Cell(0, 10,"ใบรายการรับของประจำวัน", 0, 1, 'C');


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
    $this->SetY(-25);
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
$pdf->SetTitle('Report_receiveStock');
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
          receive_stock.docNo,
          CASE
              WHEN receive_stock.isStatus = 1 THEN 'Completed' ELSE 'OnProcess' 
          END   AS isStatusText ,
          site.siteName,
          DATE(receive_stock.createAt) AS createAt,
          receive_stock.remark  
        FROM
        receive_stock
          INNER JOIN site ON receive_stock.siteID = site.siteID
        WHERE receive_stock.docNo = '$docNo' ";
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
  $pdf->Cell(30, $height, "วันที่ :", 0, 0, 'R');
  $pdf->SetFont('thsarabunnew', '', 16);
  $pdf->Cell(65, $height, $createAt, 0, 1, 'L');

  $pdf->SetFont('thsarabunnew', 'b', 16);
  $pdf->Cell(30, $height, "หมายเหตุ :", 0, 0, 'R');
  $pdf->SetFont('thsarabunnew', '', 16);
  $pdf->Cell(65, $height, $row['remark'], 0, 0, 'L');
}
$pdf->Ln(15);

$html = '<table border="1" cellspacing="0" cellpadding="1">';
$html .= '<thead style="font-weight:bold;">';
$html .= '<tr>';
$html .= '<th colspan="1" align="center" style="width:10%"><b>No</b></th>';
$html .= '<th colspan="1" align="center" style="width:30%"><b>Item Name</b></th>';
$html .= '<th colspan="1" align="center" style="width:30%"><b>Qty</b></th>';
$html .= '<th colspan="1" align="center" style="width:30%"><b>Unit</b></th>';
$html .= '</tr>';
$html .= '</thead>';

$count = 1;
$query = "SELECT
            item.itemName,
            item.itemID,
            receive_stock_detail.qty,
            item_unit.unitName
          FROM
          receive_stock_detail
          INNER JOIN item ON receive_stock_detail.itemID = item.itemID
          INNER JOIN item_unit ON item_unit.unitID = item.unitID
          WHERE receive_stock_detail.docNo = '$docNo' 
          ORDER BY item.itemName ASC";
$meQuery = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($meQuery)) {
  
  $html .= '<tr>';
  $html .= '<td colspan="1" align="center" style="width:10%">' . $count . '</td>';
  $html .= '<td colspan="1" align="center" style="width:30%">' . $row['itemName'] . '</td>';
  $html .= '<td colspan="1" align="center" style="width:30%">' . $row['qty'] . '</td>';
  $html .= '<td colspan="1" align="center" style="width:30%">' . $row['unitName'] . '</td>';
  $html .= '</tr>';


  $count++;
}




$html .= '</table>';
$pdf->writeHTML($html, false, false, true, false, '');



//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_receiveStock' . $date . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
