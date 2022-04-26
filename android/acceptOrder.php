<?php

include_once "conn.php";
global $conn;

$driver_id = $_POST['driver_id'];
$booking_id =$_POST['booking_id'];
$sql = "UPDATE itinerary_booking 
        SET status =1, 
              driver_id = '$driver_id'
        WHERE booking_id = '$booking_id'";


$rs = mysqli_query($conn, $sql);

if($rs) {
  echo "success";
}else{
  echo "fail";
  echo mysqli_error($conn);
}





?>