<?php
$page = '6';
require 'navbar.php';
require '../MyDynamoDB.php';
use Aws\DynamoDb\Exception\DynamoDbException;

$db = new MyDynamoDB();
$tableName = 'GroupeFCountry';
$area1 = 400000;
$area2 = 500000;
$params = [
    'TableName' => $tableName,
    'ProjectionExpression' => 'nom, area',
    'FilterExpression' => 'area between :value_area1 and :value_area2',
    'ExpressionAttributeValues' => [
        ':value_area1' => ['N' => $area1],
        ':value_area2' => ['N' => $area2],
    ],
];

$result = $db->scan($params);

foreach ($result as $e) {
    echo "{$e['nom']['S']} - {$e['area']['N']}.<br>";
}






