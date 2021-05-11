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
$itemID_get = $_GET['itemID'];
$departmentID = $_GET['departmentID'];
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
    $date_header =  $day . " " . $datetime->getmonthFromnum($mouth) . " " . $year . " " . '-' . " " . $day2 . " " . $datetime->getmonthFromnum($mouth2) . " " . $year2;
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
if ($departmentID == "") {
  $departmentName = "ทุกแผนก";
} else {
  $query = "SELECT
              department.departmentName
            FROM
              department
            WHERE
              department.departmentID = '$departmentID'
            AND department.siteID = '$siteID' ";

  $meQuery = mysqli_query($conn, $query);
  while ($Result = mysqli_fetch_assoc($meQuery)) {
    $departmentName = $Result["departmentName"];
  }
}



$objPHPExcel->setActiveSheetIndex(0)
  ->setCellValue('A7',  'ITEM NAME')
  ->setCellValue('B7',  'DEPARTMENT NAME');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'วันที่พิมพ์รายงาน' . $printdate);
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Report Pay Department' . '  ' . '(' . $departmentName . ')');
$objPHPExcel->getActiveSheet()->setCellValue('A6', $date_header);
$objPHPExcel->getActiveSheet()->mergeCells('A4:J4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:J5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:J6');
$objPHPExcel->getActiveSheet()->mergeCells('A7:A8');
$objPHPExcel->getActiveSheet()->mergeCells('B7:B8');
// -----------------------------------------------------------------------------------


$query = "SELECT
  site.siteName
  FROM
  site
  WHERE
  site.siteID = '$siteID'  ";

$meQuery = mysqli_query($conn, $query);
while ($Result = mysqli_fetch_assoc($meQuery)) {
  $objPHPExcel->getActiveSheet()->setCellValue('A5', $Result["siteName"]);
  $siteName = $Result["siteName"];
  $siteName = str_replace("/", " ", $siteName);
}

if ($itemID_get == '') {
  $search_item = " ";
} else {
  $search_item = "AND shelfcount_detail.itemID = '$itemID_get' ";
}

if ($departmentID == '') {
  $search_department = " ";
} else {
  $search_department = "AND shelfcount.departmentID = '$departmentID' ";
}

$query = "SELECT
            item.itemCode,
            item.itemName,
            item.itemID 
          FROM
          shelfcount
          INNER JOIN shelfcount_detail ON shelfcount.docNo = shelfcount_detail.docNo
          INNER JOIN item ON shelfcount_detail.itemID = item.itemID 
          WHERE  DATE(shelfcount.createAt)  IN ( ";
for ($day = 0; $day < $count; $day++) {

  $query .= " '$date[$day]' ,";
}
$query = rtrim($query, ' ,');
$query .= " )
          AND shelfcount.isStatus = 1
          AND shelfcount.isCancel = 0
          $search_item
          $search_department
          AND shelfcount.siteID = '$siteID' 
        GROUP BY item.itemID";

$meQuery = mysqli_query($conn, $query);
while ($Result = mysqli_fetch_assoc($meQuery)) {
  $itemName[] =  $Result["itemName"];
  $itemCode[] =  $Result["itemCode"];
  $itemID[] =  $Result["itemID"];
}


$countitem = sizeof($itemCode);
$start_row = 9;
$start_col = 2;

for ($j = 0; $j < $count; $j++) {
  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$start_col] . "8", 'ISSUE QTY');
  $date_header1 = $date_cell1[$start_col];
  $start_col++;
  $objPHPExcel->getActiveSheet()->setCellValue($date_header1 . "7", $DateShow[$j]);
  $date_header1 = '';
  $date_header2 = '';
  $date_header3 = '';
}

$objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$start_col] . "8", 'ISSUE QTY');
$date_header1 = $date_cell1[$start_col];
$start_col++;
$objPHPExcel->getActiveSheet()->setCellValue($date_header1 . "7", 'Total');
$start_col = 0;
$start_row = 9;
$objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$start_col] . $start_row, $siteName);


$start_col = 0;
$start_row = 9;
$start_merge = 9;
$start_col_dep = 1;

foreach ($itemCode as $keyItem => $valueItem) {
  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$start_col] . $start_row, $itemName[$keyItem]);

  $Select_Dep = "SELECT
                  department.departmentName,
                  department.departmentID
                FROM
                  shelfcount
                  INNER JOIN shelfcount_detail ON shelfcount.docNo = shelfcount_detail.docNo
                  INNER JOIN department ON shelfcount.departmentID = department.departmentID
                WHERE  shelfcount.isStatus = 1
                AND shelfcount.isCancel = 0 
                $search_item
                $search_department 
                GROUP BY department.departmentID ";

  $meQuery_dep = mysqli_query($conn, $Select_Dep);
  while ($Result_dep = mysqli_fetch_assoc($meQuery_dep)) {
    $departmentID_Show = $Result_dep["departmentID"];
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$start_col_dep] . $start_row, $Result_dep["departmentName"]);
    $cnt = 0;


    $r = 2;

    for ($dayx = 0; $dayx < $count; $dayx++) {
      $ISSUE_loop[$dayx] = 0;
      $Date_chk[$dayx] = 0;
    }

    $data = "SELECT 
              COALESCE(SUM(shelfcount_detail.issueQty),'0') as  ISSUE,
              DATE(shelfcount.createAt) AS Date_chk
             FROM
             shelfcount_detail
              INNER JOIN shelfcount ON shelfcount_detail.docNo = shelfcount.docNo 
  WHERE  DATE(shelfcount.createAt) IN (";
    for ($day = 0; $day < $count; $day++) {
      $data .= " '$date[$day]' ,";
    }
    $data = rtrim($data, ' ,');
    $data .= " )
            AND shelfcount.isStatus = 1
            AND shelfcount.isCancel = 0 
            AND shelfcount.siteID = '$siteID'
            AND shelfcount.departmentID = '$departmentID_Show'
            AND shelfcount_detail.itemID = '$itemID[$keyItem]' 
            GROUP BY DATE(shelfcount.createAt) ";

    $meQuery = mysqli_query($conn, $data);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $ISSUE_loop[$cnt] =  $Result["ISSUE"];
      $Date_chk[$cnt] =  $Result["Date_chk"];
      $cnt++;
    }

    $ISSUE_SUM   = 0;
    $x = 0;

    //  Loop นำค่าใส่ช่อง
    foreach ($date as $key => $val) {
      if ($Date_chk[$x]  == $val) {
        $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $ISSUE_loop[$x]);
        $r++;
        $ISSUE_SUM += $ISSUE_loop[$x];
        $x++;
      } else {
        $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, 0);
        $r++;
      }
    }

    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $ISSUE_SUM);
    $ISSUE_SUM = 0;
    $r = 2;
    $start_row++;
  }
  
  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$start_col_dep] . $start_row, 'Total');

  foreach ($date as $key => $value) {
    $ISSUE_total_loop[$key] = 0;
    $Date_total_chk[$key] = 0;
  }

  $cnt = 0;


  $data_total = "SELECT 
            COALESCE(SUM(shelfcount_detail.issueQty),'0') as  ISSUE,
            DATE(shelfcount.createAt) AS Date_chk
          FROM
          shelfcount_detail
          INNER JOIN shelfcount ON shelfcount_detail.docNo = shelfcount.docNo 
          WHERE  DATE(shelfcount.createAt) IN (";
  for ($day = 0; $day < $count; $day++) {

    $data_total .= " '$date[$day]' ,";
  }
  $data_total = rtrim($data_total, ' ,');
  $data_total .= " )
          AND shelfcount.isStatus = 1
          AND shelfcount.isCancel = 0 
          AND shelfcount.siteID = '$siteID'
          AND shelfcount_detail.itemID = '$itemID[$keyItem]'  
          $search_item
          $search_department
          GROUP BY DATE(shelfcount.createAt) ";

  $meQuery_dep_total = mysqli_query($conn, $data_total);
  while ($Result = mysqli_fetch_assoc($meQuery_dep_total)) {
    $ISSUE_total_loop[$cnt] =  $Result["ISSUE"];
    $Date_total_chk[$cnt] =  $Result["Date_chk"];
    $cnt++;
  }

  $ISSUE_SUM_total   = 0;
  $x = 0;
  $r = 2;
  //  Loop นำค่าใส่ช่อง
  foreach ($date as $key => $val) {
    if ($Date_total_chk[$x]  == $val) {
      $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $ISSUE_total_loop[$x]);
      $r++;
      $ISSUE_SUM_total += $ISSUE_total_loop[$x];
      $x++;
    } else {
      $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, 0);
      $r++;
    }
  }

  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $ISSUE_SUM_total);
  $ISSUE_SUM_total = 0;




  // ===========================================================================================
  $styleNormal2 = array(
    'alignment' => array(
      'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
    )
  );
  $objPHPExcel->getActiveSheet()->getStyle("A" . $start_merge . ":" .  "A" . $start_row)->applyFromArray($styleNormal2);
  $objPHPExcel->getActiveSheet()->mergeCells("A" . $start_merge . ":" .  "A" . $start_row);
  $start_rowx = $start_row - 1;
  foreach (range($start_merge, $start_rowx) as $column) {
    $objPHPExcel->getActiveSheet()->getRowDimension($column)->setOutlineLevel(1);
    $objPHPExcel->getActiveSheet()->getRowDimension($column)->setVisible(false);
    $objPHPExcel->getActiveSheet()->getRowDimension($column)->setCollapsed(true);
  }
  $start_row++;
  $start_merge =  $start_row;
}


$objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$start_col_dep] . $start_row, 'Total');

for ($dayx = 0; $dayx < $count; $dayx++) {
  $ISSUE_total_sum_loop[$dayx] = 0;
  $Date_total_sum_chk[$dayx] = 0;
}
$cnt = 0;

$data_total = "SELECT 
          COALESCE(SUM(shelfcount_detail.issueQty),'0') as  ISSUE,
          DATE(shelfcount.createAt) AS Date_chk
        FROM
        shelfcount_detail
        INNER JOIN shelfcount ON shelfcount_detail.docNo = shelfcount.docNo 
        WHERE  DATE(shelfcount.createAt) IN (";
for ($day = 0; $day < $count; $day++) {

  $data_total .= " '$date[$day]' ,";
}
$data_total = rtrim($data_total, ' ,');
$data_total .= " )
        AND shelfcount.isStatus = 1
        AND shelfcount.isCancel = 0 
        AND shelfcount.siteID = '$siteID'
        $search_item
        $search_department
        GROUP BY DATE(shelfcount.createAt) ";

$meQuery_dep_total = mysqli_query($conn, $data_total);
while ($Result = mysqli_fetch_assoc($meQuery_dep_total)) {
  $ISSUE_total_sum_loop[$cnt] =  $Result["ISSUE"];
  $Date_total_sum_chk[$cnt] =  $Result["Date_chk"];
  $cnt++;
}


$ISSUE_SUM_total   = 0;
$x = 0;
$r = 2;
//  Loop นำค่าใส่ช่อง
foreach ($date as $key => $val) {
  if ($Date_total_sum_chk[$x]  == $val) {
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $ISSUE_total_sum_loop[$x]);
    $r++;
    $ISSUE_SUM_total += $ISSUE_total_sum_loop[$x];
    $x++;
  } else {
    $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, 0);
    $r++;
  }
}

$objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $ISSUE_SUM_total);
$ISSUE_SUM_total = 0;

// ===========================================================================================





$styleArray = array(

  'borders' => array(

    'allborders' => array(

      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$CENTER = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  ),
  'font'  => array(
    'size'  => 8,
    'name'  => 'THSarabun'
  )
);
$HEAD = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  ),
  'font'  => array(
    'size'  => 16,
    'name'  => 'THSarabun'
  )
);
$colorfill = array(
  'fill' => array(
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
    'color' => array('rgb' => 'B9E3E6')
  )
);

$r1 = $r;
$objPHPExcel->getActiveSheet()->getStyle("A7:" . $date_cell1[$r] . $start_row)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle("A7:" . $date_cell1[$r] . "8")->applyFromArray($colorfill);
$objPHPExcel->getActiveSheet()->getStyle("A" . $start_row . ":" . $date_cell1[$r] . $start_row)->applyFromArray($colorfill);
$objPHPExcel->getActiveSheet()->getStyle($date_cell1[$r1] . "9:" . $date_cell1[$r] . $start_row)->applyFromArray($colorfill);
$objPHPExcel->getActiveSheet()->getStyle("A5:" . $date_cell1[$r] . "8")->applyFromArray($CENTER);
$objPHPExcel->getActiveSheet()->getStyle($date_cell1[2] . $start_row . ":" . $date_cell1[$r] . $start_row);
$objPHPExcel->getActiveSheet()->getStyle("A4:A6")->applyFromArray($HEAD);
// $objPHPExcel->getActiveSheet()->getStyle("C9:" . $date_cell1[$r] . $start_row)->getNumberFormat()->setFormatCode('#,##0');


$cols = array('A', 'B');
$width = array(40, 40);
for ($j = 0; $j < count($cols); $j++) {
  $objPHPExcel->getActiveSheet()->getColumnDimension($cols[$j])->setWidth($width[$j]);
}


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

$start_row = $start_row - 1;

// foreach (range('9', $start_row) as $column) {
//   $objPHPExcel->getActiveSheet()->getRowDimension($column)->setOutlineLevel(1);
//   $objPHPExcel->getActiveSheet()->getRowDimension($column)->setVisible(false);
//   $objPHPExcel->getActiveSheet()->getRowDimension($column)->setCollapsed(true);
// }

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("pay");
$objPHPExcel->createSheet();




//ตั้งชื่อไฟล์
$time  = date("H:i:s");
$date  = date("Y-m-d");
list($h, $i, $s) = explode(":", $time);
$file_name = "Report_Receive_xls_" . $date . "_" . $h . "_" . $i . "_" . $s . ")";
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
