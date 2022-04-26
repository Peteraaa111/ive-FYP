<?php

include_once "conn.php";
global $conn;

$booking_id =$_POST['booking_id'];
$sql = "UPDATE itinerary_booking 
        SET status =2
        WHERE booking_id = '$booking_id'";


$rs = mysqli_query($conn, $sql);

if($rs) {
  echo "success";
}else{
  echo "fail";
  echo mysqli_error($conn);
}



?>