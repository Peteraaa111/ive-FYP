<?php
const secretKey ="ZGRqMnhpMzZnY2djMg==";
const url = "https://fyp-recommendationlyatq4w2foan6ws.azurewebsites.net/api/models/9192a2de-04bf-45c4-9e48-217169c84e5d/recommend?";
const key = "X-API-Key:".secretKey;

function itemToItem($item_id, $count) {
  $url = url . "itemId=" . $item_id . "&recommendationCount=" . $count;

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(key, "Content-Type:application/json", "Accept:application/json"));

  $output = curl_exec($ch);
  curl_close($ch);

  $output = json_decode($output, true);

  return $output;
}

function personalized($user_id, $count) {
  $url = url . "userId=" . $user_id . "&recommendationCount=" . $count;

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(key, "Content-Type:application/json", "Accept:application/json"));

  $output = curl_exec($ch);
  curl_close($ch);

  $output = json_decode($output, true);

  return $output;
}