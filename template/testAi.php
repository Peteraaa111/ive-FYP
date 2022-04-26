<?php
session_start();
include_once("recommendationAi.php");

$result = personalized($_SESSION['user_id'], 10);

for ($i=0; $i<count($result); $i++) {
  echo $result[$i]['recommendedItemId'];
}