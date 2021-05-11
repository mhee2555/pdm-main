<?php
ini_set('memory_limit', ' -1 ');
include("PHPExcel-1.8/Classes/PHPExcel.php");
require('../../connect/connect.php');
require('../Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
session_start();

$forMat = $_GET['forMat'];
$forMatDay = $_GET['forMatDay'];
$sDate = $_GET['sDate'];
$eDate = $_GET['eDate'];
$month = $_GET['month'];
$year = $_GET['year'];
$type = $_GET['type'];
$siteID = $_GET['siteID'];

/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';

// Create new PHPExcel object
date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();
// Set properties
date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
  ->setLastModifiedBy("Maarten Balliauw")
  ->setTitle("Office 2007 XLSX Test Document")
  ->setSubject("Office 2007 XLSX Test Document")
  ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
  ->setKeywords("office 2007 openxml php")
  ->setCategory("Test result file");
// Page margins:
$objPHPExcel->getActiveSheet()
  ->getPageSetup()
  ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT);
$objPHPExcel->getActiveSheet()
  ->getPageSetup()
  ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()
  ->getPageMargins()->setTop(1);
$objPHPExcel->getActiveSheet()
  ->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()
  ->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()
  ->getPageMargins()->setBottom(1);
$objPHPExcel->getActiveSheet()
  ->getHeaderFooter()->setOddFooter('&R Page &P / &N');
$objPHPExcel->getActiveSheet()
  ->getHeaderFooter()->setEvenFooter('&R Page &P / &N');

$objPHPExcel->getActiveSheet()
  ->setShowGridlines(true);
// Setting rows/columns to repeat at the top/left of each page
$date_cell1 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$date_cell2 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$round_AZ1 = sizeof($date_cell1);
$round_AZ2 = sizeof($date_cell2);
for ($a = 0; $a < $round_AZ1; $a++) {
  for ($b = 0; $b < $round_AZ2; $b++) {
    array_push($date_cell1, $date_cell1[$a] . $date_cell2[$b]);
  }
}
// -----------------------------------------------------------------------------------
$datetime = new DatetimeTH();
$printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));


// หัวเอกสาร
if ($forMat == 'day') {
  if ($forMatDay == 1) {
    list($year, $mouth, $day) = explode("-", $sDate);
    $datetime = new DatetimeTH();
    $date_header =  $day . " " . $datetime->getmonthFromnum($mouth) . " " . $year;
  } else {
    list($year, $mouth, $day) = explode("-", $sDate);
    list($year2, $mouth2, $day2) = explode("-", $eDate);
    $datetime = new DatetimeTH();
    $date_header = $array['date'][$language] . $day . " " . $datetime->getmonthFromnum($mouth) . " " . $year . " " . '-' . " " .
      $day2 . " " . $datetime->getmonthFromnum($mouth2) . " " . $year2;
  }
} else {
  $date_header =  $datetime->getmonthFromnum($month);
}

if ($forMat == 'day') {
  if ($forMatDay == 1) {
    $count = 1;
    $date[] = $sDate;
    list($y, $m, $d) = explode('-', $sDate);
    $sDate = $d . '-' . $m . '-' . $y;
    $DateShow[] = $sDate;
  } else {
    $begin = new DateTime($sDate);
    $end = new DateTime($eDate);
    $end = $end->modify('1 day');

    $interval = new DateInterval('P1D');
    $period = new DatePeriod($begin, $interval, $end);
    foreach ($period as $key => $value) {
      $date[] = $value->format('Y-m-d');
    }
    $count = count($date);
    for ($i = 0; $i < $count; $i++) {
      $date1 = $date[$i];
      list($y, $m, $d) = explode('-', $date1);
      $date1 = $d . '-' . $m . '-' . $y;
      $DateShow[] = $date1;
    }
  }
} elseif ($forMat == 'month') {
  $day = 1;
  $y = $year;

  $count = cal_days_in_month(CAL_GREGORIAN, $month, $year);
  $datequery =  $year . '-' . $month . '-';
  $dateshow = '-' . $month . '-' . $y;
  for ($i = 0; $i < $count; $i++) {
    if ($day < 10) {
      $day = '0' . $day;
    }
    $date[] = $datequery . $day;
    $DateShow[] = $day . $dateshow;
    $day++;
  }
}



if ($type == 'receive') {

  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->setCellValue('E1', 'วันที่พิมพ์รายงาน' . $printdate);
  $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Monitoring Receive');
  $objPHPExcel->getActiveSheet()->setCellValue('A6', $date_header);
  $objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
  $objPHPExcel->getActiveSheet()->mergeCells('A6:L6');
  $objPHPExcel->getActiveSheet()->setCellValue('A7', 'CREATE_DATE');
  $objPHPExcel->getActiveSheet()->setCellValue('B7', 'CONFIRM_DATE');
  $objPHPExcel->getActiveSheet()->setCellValue('C7', 'DOCUMENT_NO');
  $objPHPExcel->getActiveSheet()->setCellValue('D7', 'ITEM_CODE');
  $objPHPExcel->getActiveSheet()->setCellValue('E7', 'ITEM_NAME');
  $objPHPExcel->getActiveSheet()->setCellValue('F7', 'Receive_QTY');
  $objPHPExcel->getActiveSheet()->setCellValue('G7', 'REMARK');

  $r = 0;
  $start_row = 8;



  $query = "SELECT
              receive_stock.createAt,
              receive_stock.updateAt,
              receive_stock.docNo,
              receive_stock.remark,
              item.itemCode,
              item.itemName,
              receive_stock_detail.qty 
            FROM
              receive_stock
              INNER JOIN receive_stock_detail ON receive_stock.docNo = receive_stock_detail.docNo
              INNER JOIN item ON receive_stock_detail.itemID = item.itemID 
  WHERE  DATE(receive_stock.createAt)  IN ( ";
  for ($day = 0; $day < $count; $day++) {

    $query .= " '$date[$day]' ,";
  }
  $query = rtrim($query, ' ,');
  $query .= " )AND receive_stock.isStatus = 1
  AND receive_stock.isCancel = 0
  AND receive_stock.siteID = '$siteID'
  ORDER BY receive_stock_detail.docNo ";

  $meQuery = mysqli_query($conn, $query);
  while ($Result = mysqli_fetch_assoc($meQuery)) {
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["createAt"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["updateAt"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["docNo"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["itemCode"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["itemName"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["qty"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["remark"]);
    $r++;
    $start_row++;
    $r = 0;
  }





  $A5 = array(
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),

    'font'  => array(
      'bold'  => true,
      'size'  => 20,
      'name'  => 'THSarabun'
    )
  );

  $A7 = array(
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),

    'font'  => array(
      'bold'  => true,
      'size'  => 10,
      'name'  => 'THSarabun'
    )
  );

  $fill = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'font'  => array(
      'size'  => 8,
      'name'  => 'THSarabun'
    )
  );


  $styleArray = array(

    'borders' => array(

      'allborders' => array(

        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );
  $colorfill = array(
    'fill' => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'FF6600')
    )
  );


  $objPHPExcel->getActiveSheet()->getStyle("A5:A6")->applyFromArray($A5);
  $objPHPExcel->getActiveSheet()->getStyle("A7:G7")->applyFromArray($colorfill);
  $objPHPExcel->getActiveSheet()->getStyle("A7:" . "M" . $start_row)->applyFromArray($fill);
  $objPHPExcel->getActiveSheet()->getStyle("A7:G7")->applyFromArray($A7);
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);




  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('Nhealth_linen');
  $objDrawing->setDescription('Nhealth_linen');
  $objDrawing->setPath('Nhealth_linen 4.0.png');
  $objDrawing->setCoordinates('A1');
  //setOffsetX works properly
  $objDrawing->setOffsetX(0);
  $objDrawing->setOffsetY(0);
  //set width, height
  $objDrawing->setWidthAndHeight(150, 75);
  $objDrawing->setResizeProportional(true);
  $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

  // Rename worksheet
  $objPHPExcel->getActiveSheet()->setTitle("Monitoring");
  $objPHPExcel->createSheet();




  //ตั้งชื่อไฟล์
  $time  = date("H:i:s");
  $date  = date("Y-m-d");
  list($h, $i, $s) = explode(":", $time);
  $file_name = "Report_Monitoring_xls_" . $date . "_" . $h . "_" . $i . "_" . $s . ")";
  //
  $objPHPExcel->removeSheetByIndex(
    $objPHPExcel->getIndex(
      $objPHPExcel->getSheetByName('Worksheet')
    )
  );
  // Save Excel 2007 file
  #echo date('H:i:s') . " Write to Excel2007 format\n";
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  ob_end_clean();
  // We'll be outputting an excel file
  header('Content-type: application/vnd.ms-excel');
  // It will be called file.xls
  header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx"');
  $objWriter->save('php://output');
  exit();
} else {

  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->setCellValue('E1', 'วันที่พิมพ์รายงาน' . $printdate);
  $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Monitoring Pay Department');
  $objPHPExcel->getActiveSheet()->setCellValue('A6', $date_header);
  $objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
  $objPHPExcel->getActiveSheet()->mergeCells('A6:L6');
  
  $objPHPExcel->getActiveSheet()->setCellValue('A7', 'DEPARTMENT_CODE');
  $objPHPExcel->getActiveSheet()->setCellValue('B7', 'CUSTOMER');
  $objPHPExcel->getActiveSheet()->setCellValue('C7', 'CREATE_DATE');
  $objPHPExcel->getActiveSheet()->setCellValue('D7', 'CONFIRM_DATE');
  $objPHPExcel->getActiveSheet()->setCellValue('E7', 'DOCUMENT_NO');
  $objPHPExcel->getActiveSheet()->setCellValue('F7', 'ITEM_CODE');
  $objPHPExcel->getActiveSheet()->setCellValue('G7', 'ITEM_NAME');
  $objPHPExcel->getActiveSheet()->setCellValue('H7', 'PAR');
  $objPHPExcel->getActiveSheet()->setCellValue('I7', 'SHELF COUNT');
  $objPHPExcel->getActiveSheet()->setCellValue('J7', 'MAX');
  $objPHPExcel->getActiveSheet()->setCellValue('K7', 'ISSUE_QTY');
  $objPHPExcel->getActiveSheet()->setCellValue('L7', 'STATUS');
  $objPHPExcel->getActiveSheet()->setCellValue('M7', 'REMARK');
  
  $r = 0;
  $start_row = 8;



  $query = "SELECT
              department.departmentCode,
              department.departmentName,
              shelfcount.createAt,
              shelfcount.updateAt,
              shelfcount.docNo,
              item.itemCode,
              item.itemName,
              shelfcount_detail.parQty,
              shelfcount_detail.issueQty,
              shelfcount_detail.scQty,
              shelfcount_detail.maxQty,
              shelfcount_detail.remark,
              shelfcount.isStatus 
            FROM
              shelfcount
              INNER JOIN shelfcount_detail ON shelfcount.docNo = shelfcount_detail.docNo
              INNER JOIN item ON shelfcount_detail.itemID = item.itemID
              INNER JOIN department ON shelfcount.departmentID = department.departmentID 
  WHERE  DATE(shelfcount.createAt)  IN ( ";
  for ($day = 0; $day < $count; $day++) {

    $query .= " '$date[$day]' ,";
  }
  $query = rtrim($query, ' ,');
  $query .= " )
  AND ( shelfcount.isStatus = 1 OR shelfcount.isStatus = 0 )
  AND shelfcount.isMobile = 1
  AND shelfcount.isCancel = 0
  AND shelfcount.siteID = '$siteID'
  ORDER BY shelfcount_detail.docNo ";
  $meQuery = mysqli_query($conn, $query);
  while ($Result = mysqli_fetch_assoc($meQuery)) {
    if($Result["isStatus"] ==0){
      $Result["updateAt"] = "";
    }

    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["departmentCode"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["departmentName"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["createAt"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["updateAt"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["docNo"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["itemCode"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["itemName"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["parQty"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["scQty"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["maxQty"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["issueQty"]);
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["isStatus"]=='1'?'Completed':'On Process');
    $r++;
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["remark"]);
    $r++;

    $start_row++;
    $r = 0;
  }





  $A5 = array(
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),

    'font'  => array(
      'bold'  => true,
      'size'  => 20,
      'name'  => 'THSarabun'
    )
  );

  $A7 = array(
    'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),

    'font'  => array(
      'bold'  => true,
      'size'  => 10,
      'name'  => 'THSarabun'
    )
  );

  $fill = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'font'  => array(
      'size'  => 8,
      'name'  => 'THSarabun'
    )
  );


  $styleArray = array(

    'borders' => array(

      'allborders' => array(

        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );
  $colorfill = array(
    'fill' => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'FF6600')
    )
  );


  $objPHPExcel->getActiveSheet()->getStyle("A5:A6")->applyFromArray($A5);
  $objPHPExcel->getActiveSheet()->getStyle("A7:M7")->applyFromArray($colorfill);
  $objPHPExcel->getActiveSheet()->getStyle("A7:" . "M" . $start_row)->applyFromArray($fill);
  $objPHPExcel->getActiveSheet()->getStyle("A7:M7")->applyFromArray($A7);
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);




  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('Nhealth_linen');
  $objDrawing->setDescription('Nhealth_linen');
  $objDrawing->setPath('Nhealth_linen 4.0.png');
  $objDrawing->setCoordinates('A1');
  //setOffsetX works properly
  $objDrawing->setOffsetX(0);
  $objDrawing->setOffsetY(0);
  //set width, height
  $objDrawing->setWidthAndHeight(150, 75);
  $objDrawing->setResizeProportional(true);
  $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

  // Rename worksheet
  $objPHPExcel->getActiveSheet()->setTitle("Monitoring");
  $objPHPExcel->createSheet();




  //ตั้งชื่อไฟล์
  $time  = date("H:i:s");
  $date  = date("Y-m-d");
  list($h, $i, $s) = explode(":", $time);
  $file_name = "Report_Monitoring_xls_" . $date . "_" . $h . "_" . $i . "_" . $s . ")";
  //
  $objPHPExcel->removeSheetByIndex(
    $objPHPExcel->getIndex(
      $objPHPExcel->getSheetByName('Worksheet')
    )
  );
  // Save Excel 2007 file
  #echo date('H:i:s') . " Write to Excel2007 format\n";
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  ob_end_clean();
  // We'll be outputting an excel file
  header('Content-type: application/vnd.ms-excel');
  // It will be called file.xls
  header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx"');
  $objWriter->save('php://output');
  exit();
}
