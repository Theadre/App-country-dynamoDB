<?php
$page = '1';
require 'navbar.php';
require '../MyDynamoDB.php';

$db = new MyDynamoDB();
$tableName = 'GroupeFCountry';
$region = 'Europe';
$params = [
    'TableName' => $tableName,
    'ProjectionExpression' => 'nom',
    'KeyConditionExpression' => '#region = :region',
    'ExpressionAttributeNames'=> [ '#region' => 'region' ],
    'ExpressionAttributeValues' => [
        ':region' => ['S' => $region], 
    ],
];

$result = $db->query($params);

foreach ($result as $e) {
    echo $e['nom']['S'] . '<br>';
}
