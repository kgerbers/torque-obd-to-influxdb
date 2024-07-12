<?php

namespace Exporters;

use Illuminate\Support\Collection;

class InfluxDbExport implements ExportInterface
{

    protected InfluxDB2\Client $client;

    public function __construct()
    {
        $host = getenv('HOST');
        $token = getenv('TOKEN');
        $org = getenv('ORG');
        $bucket = getenv('BUCKET');

# Next, we will instantiate the client and establish a connection
        $this->client = new InfluxDB2\Client([
            "url" => $host, // url and port of your instance
            "token" => $token,
            "bucket" => $bucket,
            "org" => $org,
            "precision" => InfluxDB2\Model\WritePrecision::NS,
        ]);
    }

    public function format(string $name, string $time, Collection $data, array $tags)
    {
        return [
            'name' => 'temp_c',
            'tags' => ['location' => 'CAR_NAME'],
            'fields' => ['INSERT ALL RECEIVED GET VALUES HERE, IF NOT META DATA'],
            'time' => microtime(true)
        ];
    }

    public function export(Collection $data)
    {
        $writeApi =  $this->client->createWriteApi();


// test data @todo: change to torque get input


        try {
            $writeApi->write($dataArray, InfluxDB2\Model\WritePrecision::S, $bucket, $org);
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}