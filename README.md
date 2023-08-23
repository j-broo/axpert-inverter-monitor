# axpert-inverter-monitor
Simple monitoring for Axpert/Voltronic type inverters. No MQTT.

Pre-requisites:
---------------

1. Download, build and install Manio's inverter poller: https://github.com/manio/skymax-demo
2. Test and make sure you can poll your inverter (poller returns results).

Installation:
-------------

1. Copy poll.sh and monitorconfig.json to same directory as inverter poller.
2. Copy InverterMonitor.php, InverterMonitor.png and loader.js to "/var/www/html" directory.
2. Run "chmod +x ./inverter_poller" to make executable.
3. Run "chmod +x ./poll.sh" to make executable.
4. Execute by running "./poll.sh &".

Optional:
Edit monitorconfig.json (applies only to web-monitor)
Edit inverter.conf (should not need to, interval here does not apply)

Usage:
------

Use with included php web-monitor - http://yourraspberrypi/InverterMonitor.php

Or

Use with IOT Dashboard: https://play.google.com/store/apps/details?id=com.cpk.iotdashboard

IOT Dashboard must fetch data from:
* http://yourraspberrypi/im/data.json - Inverter data
* http://yourraspberrypi/im/poll.json - Last poll time/date
It can also fetch graph data:
* http://yourraspberrypi/im/load_history.json - Load percentage history 
* http://yourraspberrypi/im/temp_history.json - Temperature history
* http://yourraspberrypi/im/ac_in_history.json - Grid AC input voltage history
* http://yourraspberrypi/im/batt_history.json - Battery discharge amperage history.

You can create your own graphs by editing poll.sh and grepping different values of interest.

Credits to the original inverter poller developer: https://github.com/manio
