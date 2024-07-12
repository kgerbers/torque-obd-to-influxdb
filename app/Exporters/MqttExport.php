<?php

namespace Exporters;

use Illuminate\Support\Collection;

class MqttExport implements ExportInterface
{

    protected \PhpMqtt\Client\MqttClient $client;

    public function __construct()
    {
        $host = getenv('HOST');
        $token = getenv('TOKEN');
        $org = getenv('ORG');
        $bucket = getenv('BUCKET');

        $server   = getenv('MQTT_HOST');
        $port     = getenv('MQTT_PORT');
        $clientId = getenv('MQTT_CLIENT_ID');
        $user = getenv('MQTT_USER');
        $pass = getenv('MQTT_PASSWORD');

        $this->client = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        $this->client ->connect();

    }

    public function format(string $name, string $time, Collection $data, array $tags = ['location' => 'SUZUKI SWIFT'])
    {
        return [
            'name' => $name,
            'tags' => $tags,
            'fields' => $data->toArray(),
            'time' => $time
        ];
    }

    public function export(array $data)
    {
        $data = $this->format('torque', (new \DateTime())->getTimestamp(), $data, []);

        $baseTopic = getenv('MQTT_BASE_TOPIC');
        foreach($data as $sensor => $value) {
            $this->client ->publish($baseTopic.'/'.$data['name'].'/'.$sensor, $value, 0);
        }

        $this->client ->disconnect();
    }
}