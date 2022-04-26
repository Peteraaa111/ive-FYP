<?php
$secretKey="djd6eHFjdDV6cGFraw==";
$url = "https://recommendao4bnzpfw2axcws.azurewebsites.net/api/models/6e293585-9096-4c97-92f0-840a2f030cd2/recommend?itemId=DQF-00248";
$key = "X-API-Key:$secretKey";

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, 'https://recommendao4bnzpfw2axcws.azurewebsites.net/api/models/6e293585-9096-4c97-92f0-840a2f030cd2/recommend?itemId=DQF-00248');

curl_setopt($ch, CURLOPT_HTTPHEADER, array($key, "Content-Type:application/json", "Accept:application/json")) ;

$json_str=curl_exec($ch);
curl_close($ch);

$obj = json_decode($json_str, true);


echo "<h1>Recommendation AI</h1><table border='1'><tr>
<th>Item</th>
<th>recommendedItemId</th>
<th>score</th>
</tr>";
for ($row = 0; $row < sizeof($obj); $row ++) {
   echo "<tr>";
    echo "<td>".($row+1) ."</td>";
    echo "<td>".$obj[$row]['recommendedItemId'] ."</td>";
    echo "<td>".$obj[$row]['score'] ."</td>";
   echo "</tr>";
}
echo "</table>";
?>