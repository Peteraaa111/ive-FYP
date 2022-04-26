<?php

include_once "conn.php";
global $conn;

$driver_id = $_POST['driver_id'];
$sql = "SELECT *
        FROM `itinerary_booking` booking
        INNER JOIN `account` ac ON booking.`account_id` = ac.`account_id`
        WHERE `driver_id` = '$driver_id'
        AND booking.`status` = 1
        ORDER BY booking.`start_date`";

// AND start_date = DATE_FORMAT(NOW(), '%Y-%m-%d')

$rs = mysqli_query($conn, $sql);

$result = array();
while($rc= mysqli_fetch_assoc($rs)) {
  $record = array(
    'start_address' => $rc['start_address'],
    'end_address' => $rc['end_address'],
    'start_date' => $rc['start_date'],
    'start_time' => $rc['start_time'],
    'people_num' => $rc['people_num'],
    'booking_id' => $rc['booking_id'],
    'email' => $rc['email'],
    'account_id' => $rc['account_id'],
    'userName' => $rc['nickname'],
    'userPhone' => $rc['phone_number']
  );
  // $record = $rc;
  $result[] = $record;
}
echo json_encode($result);
?>


