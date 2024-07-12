<?php

namespace Log;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    protected $log;
    function __construct($name)
    {
        // create a log channel
        $this->log = new Logger($name);
        $this->log->pushHandler(new StreamHandler('/usr/share/nginx/html/storage/Logs/'.$name.'.log', Level::Debug));
    }

    public function log( $message, array $context = array(), $level = \Monolog\Level::Info)
    {
        // add records to the log
        $this->log->log($level, $message, $context);
    }

}