<?php

include_once "conn.php";
global $conn;

$sql = "SELECT * FROM account";

$rs = mysqli_query($conn, $sql);

$result = array();
while($rc= mysqli_fetch_assoc($rs)) {
  $record = array(
    'accID' => $rc['account_id'],
    'password' => $rc['password']
  );
  // $record = $rc;
  $result[] = $record;
}
echo json_encode($result);
?>

