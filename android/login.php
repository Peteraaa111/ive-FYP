<?php

include_once "conn.php";
global $conn;

$email = $_POST['email'];
$psw = $_POST['password'];

$sql = "SELECT * FROM `account` WHERE `email` = '$email' AND `password` = '$psw'";

$rs = mysqli_query($conn, $sql);

if(mysqli_num_rows($rs) > 0) {
  $rc = mysqli_fetch_assoc($rs);

  echo json_encode(array(
    'accID'=>$rc['account_id'],
    'password' => $rc['password'],
    'email'=>$rc['email'],
    'nick'=>$rc['nickname'],
    'phone'=>$rc['phone_number'], 
    'type' => $rc['type_id']
  ));
} else {
  echo "fail";
}


?>