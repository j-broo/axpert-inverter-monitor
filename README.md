# axpert-inverter-monitor
Simple monitoring for Axpert/Voltronic type inverters via a connected Raspberry Pi. No MQTT needed.

![image](https://github.com/j-broo/axpert-inverter-monitor/assets/26300538/a2bb5aa5-2d30-4532-8fa6-dabb710a07e3)


Pre-requisites:
---------------

1. Download, build and install Manio's inverter poller: https://github.com/manio/skymax-demo
2. Test and make sure you can poll your inverter (poller returns results).
3. Recommended - install and run log2ram to save your SD card since polling writes to disk very frequently - https://github.com/azlux/log2ram
4. A web server with PHP installed, serving files from "/var/www/html". I recommend Lighttpd.

Installation:
-------------

1. Copy poll.sh and monitorconfig.json to same directory as inverter poller.
2. Copy InverterMonitor.php, InverterMonitor.png and loader.js to "/var/www/html" directory.
2. Run "chmod +x ./inverter_poller" to make executable.
3. Run "chmod +x ./poll.sh" to make executable.
4. Edit "/etc/log2ram.conf" and add the "/var/www/html/im" directory to cache it to RAM.
5. Execute by running "./poll.sh &". The ampersand lets the script run in the background. To terminate it, find the PID with "pidof -x poll.sh", then "kill x", where x is the PID returned.

Optional:
* Edit monitorconfig.json (applies only to web-monitor) - Set your inverter model and battery count here (battery count used in voltage calculation).
* Edit inverter.conf (you should not need to, interval here does not apply).

Usage:
------

Use with included PHP web-monitor. This is a webpage showing your inverter data that auto-resfreshes every 10 seconds.
Simply navigate to http://yourraspberrypi/InverterMonitor.php

Or

Use with IOT Dashboard: https://play.google.com/store/apps/details?id=com.cpk.iotdashboard

IOT Dashboard must fetch data from:
* http://yourraspberrypi/im/data.json - Inverter data
* http://yourraspberrypi/im/poll.json - Last poll time/date

It can also fetch graph data:
* http://yourraspberrypi/im/load_history.json - Load percentage history
* http://yourraspberrypi/im/temp_history.json - Temperature history
* http://yourraspberrypi/im/ac_in_history.json - Grid AC input voltage history
* http://yourraspberrypi/im/batt_history.json - Battery discharge amperage history

You can create your own graphs by editing poll.sh and grepping different values of interest.

NOTE: IOT Dashboard requires extensive configuration to parse the JSON data, so be prepared for trial and error.

Bonus points:
-------------
Install ZerotierOne on your Pi and mobile device to be able to monitor your inverter from anywhere, not just your local network.
You'll need to bridge your LAN/WLAN and Zerotier interface on the Pi. More info here: https://zerotier.atlassian.net/wiki/spaces/SD/pages/224395274/Route+between+ZeroTier+and+Physical+Networks

Credits:
--------
* Acknowledgements to the original inverter poller developer: https://github.com/manio
* Acknowledgements to the developer of IOT Dashboard: https://play.google.com/store/apps/developer?id=Ciprian+Savastre
