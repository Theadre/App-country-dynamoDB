<?php
$page = '4';
require 'navbar.php';
require '../MyDynamoDB.php';
use Aws\DynamoDb\Exception\DynamoDbException;

$db = new MyDynamoDB();
$tableName = 'GroupeFCountry';
$langue = 'Dutch';
$params = [
    'TableName' => $tableName,
    'ProjectionExpression' => 'nom',
    'FilterExpression' => 'languages.nld = :value_langue',
    'ExpressionAttributeValues' => [':value_langue' => ['S' => $langue]],
];


$result = $db->scan($params);

foreach ($result as $e) {
    echo "{$e['nom']['S']} <br>";
}






