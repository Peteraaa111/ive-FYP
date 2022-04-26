<?php
include_once "conn.php";
global $conn;

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "select * from account where email='$email' and password='" . $password . "'";

$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
    $jsonresult[] = $row;
}
print(json_encode($jsonresult));
?>
