<?php
const secretKey ="ZGRqMnhpMzZnY2djMg==";
const url = "https://fyp-recommendationlyatq4w2foan6ws.azurewebsites.net/api/models/3d40bf02-d542-44dc-96e5-57f10008bf3a/recommend?";
const key = "X-API-Key:".secretKey;

function guesthouse_itemToItem($item_id, $count) {
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

function guesthouse_personalized($user_id, $count) {
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