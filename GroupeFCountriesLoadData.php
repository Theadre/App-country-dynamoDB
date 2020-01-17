<?php

/**
 * Copyright 2010-2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * This file is licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License. A copy of
 * the License is located at
 *
 * http://aws.amazon.com/apache2.0/
 *
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 */

require 'vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    'endpoint'   => 'http://localhost:8000',
    'region'   => 'us-west-2',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'GroupeFCountry';

$countries = json_decode(file_get_contents('countries.json'), true);

foreach ($countries as $country) {

    $region = $country['region'];
    $nom = $country['name']['common'];
    $languages = $country['languages'];
    $area = $country['area'];

    $json = json_encode([
        'region' => $region,
        'nom' => $nom,
        'languages' => $languages,
        'area' => $area
    ]);

    $params = [
        'TableName' => $tableName,
        'Item' => $marshaler->marshalJson($json)
    ];

    try {
        $result = $dynamodb->putItem($params);
        echo "Added countries: " . $country['region'] . " " . $country['name']['common'] . "\n";
    } catch (DynamoDbException $e) {
        echo "Unable to add country:\n";
        echo $e->getMessage() . "\n";
        break;
    }

}



?>