torque-obd-to-influxdb PHP 8 version
======================
Purpose
-------
The purpose of this service is to expose an API to use in the Torque Android app and put all metrics into InfluxDb.

Usage
-----
Run the service using docker-compose `docker-compose up -d` and you can access the api 
on `localhost:3000`.

This project assumes that influxDB is already running and accessible from where this container runs

Created to run behind a proxy server, but it could also be called directly using the port number and (external) ip

Copy `.env.example` to `.env` and change:

```
HOST="http://localhost:8086";
TOKEN='your token';
ORG='your org';
BUCKET='torque_data';
```