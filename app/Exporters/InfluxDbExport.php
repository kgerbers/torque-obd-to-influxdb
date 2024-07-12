<?php

namespace Exporters;

use Illuminate\Support\Collection;
use InfluxDB2;

class InfluxDbExport # implements Exporters\ExportInterface
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

    public function format(\WayPoint $wayPoint)
    {
        return [
            'name' => $wayPoint->id,
            'tags' => [
                'session' => $wayPoint->session,
                'version' => $wayPoint->v,
                'eml' => $wayPoint->eml,
            ],
            'fields' => $wayPoint->data->toArray(),
            'time' => $wayPoint->time->getTimestamp()
        ];
    }

    public function export(array $data)
    {
        $writeApi =  $this->client->createWriteApi();

        try {
            $writeApi->write($data, InfluxDB2\Model\WritePrecision::S, getenv('BUCKET'), getenv('ORG'));
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}