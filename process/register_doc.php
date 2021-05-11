<?php
session_start();
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
  if ($_POST['FUNC_NAME'] == 'show_data') {
    show_data($conn);
  } else if ($_POST['FUNC_NAME'] == 'feedDepartmentSelection') {
    feedDepartmentSelection($conn);
  } else if ($_POST['FUNC_NAME'] == 'feedPermissionSelection') {
    feedPermissionSelection($conn);
  } else if ($_POST['FUNC_NAME'] == 'show_Detail') {
    show_Detail($conn);
  } else if ($_POST['FUNC_NAME'] == 'editData') {
    editData($conn);
  } else if ($_POST['FUNC_NAME'] == 'saveData') {
    saveData($conn);
  } else if ($_POST['FUNC_NAME'] == 'deleteData') {
    deleteData($conn);
  } else if ($_POST['FUNC_NAME'] == 'Get_customers') {
    Get_customers($conn);
  }
  
}

function Get_customers($conn){
      $Sql = "SELECT
                customer.ID,
                customer.CustomerName 
              FROM
                customer
                WHERE customer.IsCancel = 0
           ";

    $meQuery = mysqli_query($conn, $Sql);
    while ($row = mysqli_fetch_assoc($meQuery)) {
    $return[] = $row;
    }


    echo json_encode($return);
    mysqli_close($conn);
    die;
}



function editData($conn)
{
  $select_cus    = $_POST['select_cus'];
  $txt_contact_name    = $_POST['txt_contact_name'];
  $txt_deb_name     = $_POST['txt_deb_name'];
  $txt_email     = $_POST['txt_email'];
  $txt_phonenumber     = $_POST['txt_phonenumber'];
  $ID_txt     = $_POST['ID_txt'];

  
 
    $query = "UPDATE cuscontact 
                SET ContactName = '$txt_contact_name',
                    Department = '$txt_deb_name',
                    email = '$txt_email',
                    Tel = '$txt_phonenumber',
                    CustomerID = '$select_cus'
              WHERE ID = '$ID_txt'";

    $return = "แก้ไขข้อมูล สำเร็จ";
  

  mysqli_query($conn, $query);
  echo $return;
  unset($conn);
  die;
}

function saveData($conn)
{

  $txt_DocNo    = $_POST['txt_DocNo'];
  $txt_Doc_name    = $_POST['txt_Doc_name'];
  $txt_Doc_numbar     = $_POST['txt_Doc_numbar'];
  $txt_date_doc     = $_POST['txt_date_doc'];
  $txt_expira_date     = $_POST['txt_expira_date'];
  $txt_detail     = $_POST['txt_detail'];
  $StatusRadio     = $_POST['StatusRadio'];

  $date = explode("-", $date);

  $newdate = $date[0].'-'.$date[1].'-'.$date[2];

            $Sql2 = "SELECT
                      customer.CustomerCode
                    FROM
                      customer
                      WHERE  customer.CustomerCode = '$txtcustomers_ID'
                    ";

          $result = mysqli_query($conn, $Sql2);
          $num_rows = mysqli_num_rows($result);
          if($num_rows>0){
          $return = "0";
          }else{


            $query = "INSERT INTO customer 
            SET CustomerCode = '$txtcustomers_ID',
                CustomerName = '$txtcustomers_name',
                Status = '$StatusRadio'
            ";

            $return = "เพิ่มข้อมูล สำเร็จ";
            mysqli_query($conn, $query);
          }
            
    
 
  echo $return;
  unset($conn);
  die;
}

function show_data($conn)
{
  $Search_txt = $_POST["Search_txt"];


  $Sql = "SELECT
              cuscontact.ContactName,
              cuscontact.Department,
              cuscontact.email,
              cuscontact.Tel,
              cuscontact.ID, 
              customer.CustomerName
            FROM
              cuscontact
              INNER JOIN customer ON cuscontact.CustomerID = customer.ID 
            WHERE (cuscontact.ContactName LIKE '%$Search_txt%' OR customer.CustomerName LIKE '%$Search_txt%'	)
            AND cuscontact.IsCancel=0
          ";

  $meQuery = mysqli_query($conn, $Sql);
  while ($row = mysqli_fetch_assoc($meQuery)) {
    $return[] = $row;
  }

  
  echo json_encode($return);
  mysqli_close($conn);
  die;
}


function show_Detail($conn)
{
  $ID = $_POST["ID"];


  $Sql = "SELECT
              cuscontact.ContactName,
              cuscontact.Department,
              cuscontact.email,
              cuscontact.Tel,
              cuscontact.ID, 
              cuscontact.CustomerID
          FROM
          cuscontact
            WHERE cuscontact.ID = '$ID'
          ";
          
  $meQuery = mysqli_query($conn, $Sql);
  while ($row = mysqli_fetch_assoc($meQuery)) {
    $return[] = $row;
  }

  
  echo json_encode($return);
  mysqli_close($conn);
  die;
}


function deleteData($conn)
{
  $ID_txt = $_POST['ID_txt'];

  $query = "UPDATE cuscontact SET IsCancel = 1 WHERE ID = $ID_txt";
  mysqli_query($conn, $query);
  echo "delete success";
  unset($conn);
  die;
}
