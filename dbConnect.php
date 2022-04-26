<?php

$hostname   = "localhost";
$username   = "root";
$pwd        = "";
$db         = "travelhk";

$conn = mysqli_connect($hostname, $username, $pwd, $db);
// if(!$conn){
//     die("Database Connection Failed" . mysqli_connect_error());
// }

if (mysqli_connect_errno()) {
  echo "<script> console.log(\"" . mysqli_connect_error() . "\"); </script>";
}

// Sets the default client character set to utf8 for display Chinese language
mysqli_set_charset($conn, "utf8");

// for map connection
class DbConnect
{
  private $host = 'localhost';
  private $dbName = 'travelhk';
  private $user = 'root';
  private $pass = '';

  public function connect()
  {
    try {
      $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      echo 'Database Error: ' . $e->getMessage();
    }
  }
}
