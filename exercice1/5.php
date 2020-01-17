<?php
$page = '5';
require 'navbar.php';
require '../MyDynamoDB.php';

$db = new MyDynamoDB();
$tableName = 'GroupeFCountry';
$letter = 'M';
$params = [
    'TableName' => $tableName,
    'ProjectionExpression' => 'nom',
    'FilterExpression' => 'begins_with( nom, :value_letter)',
    'ExpressionAttributeValues' => [':value_letter' => ['S' => $letter]],
];


$result = $db->scan($params);

foreach ($result as $e) {
    echo "{$e['nom']['S']} <br>";
}

