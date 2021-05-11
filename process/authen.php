<?php
session_start();
require '../connect/connect.php';

if (!empty($_POST['FUNC_NAME'])) {
    if ($_POST['FUNC_NAME'] == 'login') {
        login($conn);
    } else if ($_POST['FUNC_NAME'] == 'logout') {
        logout($conn);
    }
}

function login($conn)
{
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];
        // $password = md5($_POST['password']);
        $password = $_POST['password'];

        $query = "SELECT
                        `user`.ID,
                        `user`.Username,
                        `user`.`User`,
                        `user`.UserTypeID 
                    FROM
                        `user` 
                    WHERE
                        `user` .Username = '$username' 
                        AND `user` .`Password` = '$password' ";
        
        $meQuery = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($meQuery)) {
            $userID = $row['ID'];
            $Username = $row['Username'];
            $permissionID = $row['UserTypeID'];
            $firstName = $row['User'];
            $return = "success";
        }

        if (!empty($userID) || $userID == "") {
            $_SESSION["userData"]['userID'] = $userID;
            $_SESSION["userData"]['Username'] = $Username;
            $_SESSION["userData"]['real_name'] = $firstName;
        } else {
            $return = "falied";
        }
    } else {
        $return = "falied";
    }
    unset($conn);
    echo $return;
    die;
}

function logout($conn)
{
    unset($_SESSION['userData']);
}
