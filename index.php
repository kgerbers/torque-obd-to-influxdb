<?php

# First, let's make use of Composer so that we can access the Library
require __DIR__ . '/vendor/autoload.php';

# You can generate a Token from the "Tokens Tab" in the UI
$host = getenv('HOST');
$token = getenv('TOKEN');
$org = getenv('ORG');
$bucket = getenv('BUCKET');

# Next, we will instantiate the client and establish a connection
$client = new InfluxDB2\Client([
    "url" => $host, // url and port of your instance
    "token" => $token,
    "bucket" => $bucket,
    "org" => $org,
    "precision" => InfluxDB2\Model\WritePrecision::NS,
]);

$writeApi = $client->createWriteApi();


// test data @todo: change to torque get input
$dataArray = [
    'name' => 'temp_c',
    'tags' => ['location' => 'CAR_NAME'],
    'fields' => ['INSERT ALL RECEIVED GET VALUES HERE, IF NOT META DATA'],
    'time' => microtime(true)
];

try {
    $writeApi->write($dataArray, InfluxDB2\Model\WritePrecision::S, $bucket, $org);
} catch (Exception $e) {
    var_dump($e);
}
echo "OK!";