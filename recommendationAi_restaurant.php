<?php
const restaurant_secretKey ="ZGRqMnhpMzZnY2djMg==";
const restaurant_url = "https://fyp-recommendationlyatq4w2foan6ws.azurewebsites.net/api/models/3369206a-8f3f-4095-be3d-998846e0b6a2/recommend?";
const restaurant_key = "X-API-Key:".restaurant_secretKey;

function restaurant_itemToItem($item_id, $count) {
  $restaurant_url = restaurant_url . "itemId=" . $item_id . "&recommendationCount=" . $count;

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $restaurant_url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(restaurant_key, "Content-Type:application/json", "Accept:application/json"));

  $output = curl_exec($ch);
  curl_close($ch);

  $output = json_decode($output, true);

  return $output;
}

function restaurant_personalized($user_id, $count) {
  $restaurant_url = restaurant_url . "userId=" . $user_id . "&recommendationCount=" . $count;

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $restaurant_url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(restaurant_key, "Content-Type:application/json", "Accept:application/json"));

  $output = curl_exec($ch);
  curl_close($ch);

  $output = json_decode($output, true);

  return $output;
}