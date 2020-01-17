<?php
$page = '2';
require 'navbar.php';
require '../MyDynamoDB.php';

$db = new MyDynamoDB();

$tableName = 'GroupeFCountry';
$region = 'Africa';
$params = [
    'TableName' => $tableName,
    'ProjectionExpression' => 'nom, area',
    'FilterExpression' => '#region = :region',
    'ExpressionAttributeNames'=> [ '#region' => 'region' ],
    'ExpressionAttributeValues' => [':region' => ['S' => $region]]
];

$result = $db->scan($params);

// php 7.4 
//usort($result, fn($a, $b) => $b['area']['N'] - $a['area']['N']);

// php 7.3
usort($result, function($a, $b) {
   return $b['area']['N'] - $a['area']['N'];
}); 

$result = array_slice($result, 9, 12); 

foreach ($result as $e) {
    echo "{$e['nom']['S']} - {$e['area']['N']}. <br>";
}
