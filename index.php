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

// for now log all urls for debug usage
$log = new Log\Log('requests');


$request = new Request();

$log->log("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", $request->getAll()->toArray(), Monolog\Level::Debug);

$waypoint = new WayPoint($request);

dd($request->getAll(),$waypoint);
# You can generate a Token from the "Tokens Tab" in the UI


echo "OK!";