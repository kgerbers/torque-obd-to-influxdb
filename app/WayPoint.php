<?php

class WayPoint
{
    public string $id;
    public string $session;
    public string $eml;
    public datetime $time;

    public int $v;
    public \Illuminate\Support\Collection $data;

    public function __construct(Request $data)
    {
        $time = now();

        $this->id = (string) $data->get('id');
        $this->session = (string) $data->get('session');
        $this->v = (int) $data->get('v');
        $this->eml = (string) $data->get('eml');
        if($data->has('time')) {
            $this->time = $time->setTimestamp(($data->get('time') / 1000));
        } else {
            $this->time = $time;
        }

        $this->data =  $data->getAll()->except(['id', 'session', 'eml', 'v', 'time']);
    }



    /**
    $export
     * @return void
     */
    public function write(\Exporters\InfluxDbExport $export)
    {

        $data = $export->format($this);

        $export->export($data);
    }
}