<?php
$page = '3';
require 'navbar.php';
require '../MyDynamoDB.php';


$db = new MyDynamoDB();
$tableName = 'GroupeFCountry';
$nom = 'Morocco';
$params = [
    'TableName' => $tableName,
    'FilterExpression' => 'nom = :value_nom',
    'ExpressionAttributeValues' => [':value_nom' => ['S' => $nom]],
];


$result = $db->scan($params);

foreach ($result as $e) {
    echo "Région : {$e['region']['S']} <br>";
    echo "Nom : {$e['nom']['S']} <br>";
    echo "Langues : <br>";
    foreach (array_values(array_values($e['languages'])[0]) as $languages) {
        echo "- {$languages['S']} <br>";
    }
    echo "Zone : {$e['area']['N']}";
}






