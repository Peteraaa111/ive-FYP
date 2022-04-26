<?php

class initialMap
{
  private $id;
  private $name;
  private $address;
  private $type;
  private $lat;
  private $lng;
  private $conn;
  private $restaurant_table = "colleges";  // need to change
  private $attraction_table = "markers";  // need to change
  private $guesthouse_table = "colleges";  // need to change

  function setId($id)
  {
    $this->id = $id;
  }
  function getId()
  {
    return $this->id;
  }
  function setName($name)
  {
    $this->name = $name;
  }
  function getName()
  {
    return $this->name;
  }
  function setAddress($address)
  {
    $this->address = $address;
  }
  function getAddress()
  {
    return $this->address;
  }
  function setType($type)
  {
    $this->type = $type;
  }
  function getType()
  {
    return $this->type;
  }
  function setLat($lat)
  {
    $this->lat = $lat;
  }
  function getLat()
  {
    return $this->lat;
  }
  function setLng($lng)
  {
    $this->lng = $lng;
  }
  function getLng()
  {
    return $this->lng;
  }

  public function __construct()
  {
    require_once('dbConnect.php');
    $conn = new DbConnect;
    $this->conn = $conn->connect();
  }

  // get restaurant details
  public function getAllRestaurants()
  {
    $sql = "SELECT * FROM $this->restaurant_table";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // get attraction details
  public function getAllAttractions()
  {
    $sql = "SELECT * FROM $this->attraction_table";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // get guesthouse details
  public function getAllGuesthouses()
  {
    $sql = "SELECT * FROM $this->guesthouse_table";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
