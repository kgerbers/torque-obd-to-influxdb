<?php
// Example get query:
// ?eml=keesgerbers@gmail.com&session=fdsa4fsdafdsa&id=dsafa3afdsfsdfdsfs&v=2

# First, let's make use of Composer so that we can access the Library
require __DIR__ . '/vendor/autoload.php';
// fix autoloading too, but for now:
require __DIR__ . '/app/functions.php';
require __DIR__ . '/app/Request.php';
require __DIR__ . '/app/WayPoint.php';
require __DIR__ . '/app/Log/Log.php';
require __DIR__ . '/app/Exporters/InfluxDbExport.php';

// for now log all urls for debug usage
$log = new Log\Log('requests');


$request = new Request();

$log->log("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", $request->getAll()->toArray(), Monolog\Level::Debug);

// first only log, then enable and continue building
$waypoint = new WayPoint($request);
$exporter = new \Exporters\InfluxDbExport();

$waypoint->write($exporter);
dd($waypoint, $request, $exporter);

// required response by Torque application
echo "OK!";