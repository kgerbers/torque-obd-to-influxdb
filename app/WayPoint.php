<?php

class WayPoint
{
    protected string $id;
    protected string $session;
    protected string $eml;
    protected datetime $time;

    protected int $v;
    protected \Illuminate\Support\Collection $data;

    public function __construct(Request $data)
    {
        $this->id = (string) $data->get('id');
        $this->session = (string) $data->get('session');
        $this->v = (int) $data->get('v');
        $this->eml = (string) $data->get('eml');
        if($data->has('time')) {
            $this->time = (new DateTime())->setTimestamp($data->get('time'));
        } else {
            $this->time = new DateTime('now');
        }

        $this->data =  $data->getAll()->except(['id', 'session', 'eml', 'v', 'time']);
    }



    /**
     * @param \Exporters\ExportInterface $export
     * @return void
     */
    public function write(\Exporters\ExportInterface $export)
    {
        dd($export);
    }
}