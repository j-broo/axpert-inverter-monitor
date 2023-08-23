# axpert-inverter-monitor
Simple monitoring for Axpert/Voltronic type inverters via a connected Raspberry Pi. No MQTT needed.

![image](https://github.com/j-broo/axpert-inverter-monitor/assets/26300538/75549074-452f-4539-850e-3f14c8a32e86)


Pre-requisites:
---------------

1. Download, build and install Manio's inverter poller: https://github.com/manio/skymax-demo
2. Test and make sure you can poll your inverter (poller returns results).
3. Recommended - install and run log2ram to save your SD card since polling writes to disk very frequently - https://github.com/azlux/log2ram
4. For PHP monitor, a web server with PHP installed, serving files from "/var/www/html". I recommend Lighttpd.

Installation:
-------------

1. Copy poll.sh and monitorconfig.json to same directory as inverter poller.
2. Copy InverterMonitor.php, InverterMonitor.png and loader.js to "/var/www/html" directory.
2. Run "chmod +x ./inverter_poller" to make executable.
3. Run "chmod +x ./poll.sh" to make executable.
4. Edit "/etc/log2ram.conf" and add the "/var/www/html/im" directory to cache it to RAM.
5. Execute by running "./poll.sh &".

Optional:
* Edit monitorconfig.json (applies only to web-monitor) - Set your inverter model and battery count here (battery count used in voltage calculation).
* Edit inverter.conf (you should not need to, interval here does not apply).

Usage:
------

Use with included PHP web-monitor. This is a webpage showing your inverter data that auto-resfreshes every 5 seconds.
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
* http://yourraspberrypi/im/batt_history.json - Battery discharge amperage history.

You can create your own graphs by editing poll.sh and grepping different values of interest.

Bonus points:
-------------
Install ZerotierOne on your Pi and mobile device to be able to monitor your inverter from anywhere, not just your local network.
You'll need to bridge your LAN/WLAN and Zerotier on the Pi. More info here: https://zerotier.atlassian.net/wiki/spaces/SD/pages/224395274/Route+between+ZeroTier+and+Physical+Networks

Credits and ackowledgments to the original inverter poller developer: https://github.com/manio
