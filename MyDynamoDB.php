<?php
require 'vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;
use Aws\Sdk;

class MyDynamoDB
{
    // proprietes
	public Sdk $sdk;
	public $dynamodb;
    
    // constructeur
    public function __construct() {
        $this->sdk = new Aws\Sdk([
            'endpoint'   => 'http://localhost:8000',
            'region'   => 'us-west-2',
            'version'  => 'latest'
        ]);

        $this->dynamodb = $this->sdk->createDynamoDb();
    }

    // methode
    public function query($params = []): array {
        return $this->dynamodb->query($params)['Items'];
    }

    public function scan($params = []): array {
        return $this->dynamodb->scan($params)['Items'];
    }
}
