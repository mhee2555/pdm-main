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
  }

}

function feedData($conn)
{

  $return = array();
  $selectSite = $_POST['selectSite'];
  $selectDepartment = $_POST['selectDepartment'];
  $txtSearch = $_POST['txtSearch'];

  $whereDepartment = "";
  if ($selectDepartment != "") {
    $whereDepartment = "AND users.departmentID = '$selectDepartment' ";
  }

  $query = "SELECT
              users.userID,
              users.perfix,
              users.firstName,
              users.lastName,
              users.userName,
              users.email,
              permission.permissionName,
              department.departmentName 
            FROM
              users
              INNER JOIN site ON users.siteID = site.siteID
              INNER JOIN department ON users.departmentID = department.departmentID
              INNER JOIN permission ON users.permissionID = permission.permissionID
            WHERE
              users.isCancel = 0 
              AND users.firstName LIKE '%$txtSearch%'
              AND `users`.siteID = '$selectSite'
              $whereDepartment ";
  $meQuery = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($meQuery)) {
    array_push($return, array(
      'real_name' => $row["perfix"] . ' ' . $row["firstName"] . ' ' . $row["lastName"],
      'userName' => $row["userName"],
      'userID' => $row["userID"],
      'email' => $row["email"],
      'permissionName' => $row["permissionName"],
      'departmentName' => $row["departmentName"],
    ));
  }

  unset($conn);
  echo json_encode($return);
  die;
}

function editData($conn)
{
 $txtcustomers_ID    = $_POST['txtcustomers_ID'];
  $txtcustomers_name    = $_POST['txtcustomers_name'];
  $StatusRadio     = $_POST['StatusRadio'];
  $ID_txt     = $_POST['ID_txt'];

  
 
    $query = "UPDATE customer 
                SET CustomerCode = '$txtcustomers_ID',
                    CustomerName = '$txtcustomers_name',
                    Status = '$StatusRadio'
              WHERE ID = '$ID_txt'";

    $return = "แก้ไขข้อมูล สำเร็จ";
  

  mysqli_query($conn, $query);
  echo $return;
  unset($conn);
  die;
}

function saveData($conn)
{

  $txtcustomers_ID    = $_POST['txtcustomers_ID'];
  $txtcustomers_name    = $_POST['txtcustomers_name'];
  $StatusRadio     = $_POST['StatusRadio'];

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
            customer.ID, 
            customer.CustomerCode, 
            customer.CustomerName, 
            customer.`Status`
          FROM
            customer
            WHERE (CustomerName LIKE '%$Search_txt%' OR CustomerCode LIKE '%$Search_txt%')
            AND customer.IsCancel = 0
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
            customer.ID, 
            customer.CustomerCode, 
            customer.CustomerName, 
            customer.`Status`
          FROM
            customer
            WHERE customer.ID = '$ID'
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

  $query = "UPDATE customer SET IsCancel = 1 WHERE ID = $ID_txt";
  mysqli_query($conn, $query);
  echo "delete success";
  unset($conn);
  die;
}
