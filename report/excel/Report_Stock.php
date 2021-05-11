<?php
ini_set('memory_limit', ' -1 ');
include("PHPExcel-1.8/Classes/PHPExcel.php");
require('../../connect/connect.php');
require('../Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
session_start();

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

$query="SELECT 
          site.siteName 
        FROM 
          site 
        WHERE 
          siteID ='$siteID' ";
$meQuery = mysqli_query($conn, $query);
$Result = mysqli_fetch_assoc($meQuery);
$siteName = $Result['siteName'];

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'วันที่พิมพ์รายงาน' . $printdate);
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'รายงานสต๊อกคงคลัง');
$objPHPExcel->getActiveSheet()->setCellValue('A6', $siteName);
$objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:L6');
$objPHPExcel->getActiveSheet()->setCellValue('A7', 'ลำดับ');
$objPHPExcel->getActiveSheet()->setCellValue('B7', 'รายการ');
$objPHPExcel->getActiveSheet()->setCellValue('C7', 'จำนวนทั้งหมด');
$objPHPExcel->getActiveSheet()->setCellValue('D7', 'หน่วยนับ');

$r = 0;
$start_row = 8;


$count = 1;
$query = "SELECT
            item.itemName,
            SUM(item_par_stock.totalQty) AS totalQty,
            item_unit.unitName 
          FROM
            item_par_stock
            INNER JOIN item ON item_par_stock.itemID = item.itemID
            INNER JOIN item_unit ON item.unitID = item_unit.unitID
          WHERE 
            item_par_stock.siteID = '$siteID' 
          GROUP BY 
            item.itemName";

$meQuery = mysqli_query($conn, $query);
while ($Result = mysqli_fetch_assoc($meQuery)) {
  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $count);
  $r++;
  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["itemName"]);
  $r++;
  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["totalQty"]);
  $r++;
  $objPHPExcel->getActiveSheet()->setCellValue($date_cell1[$r] . $start_row, $Result["unitName"]);
  $r++;
  $start_row++;
  $r = 0;
  $count++;
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
$objPHPExcel->getActiveSheet()->getStyle("A7:D7")->applyFromArray($colorfill);
$objPHPExcel->getActiveSheet()->getStyle("A7:" . "M" . $start_row)->applyFromArray($fill);
$objPHPExcel->getActiveSheet()->getStyle("A7:D7")->applyFromArray($A7);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);




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
$file_name = "Report_Stock_xls_" . $date . "_" . $h . "_" . $i . "_" . $s . ")";
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
