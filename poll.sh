#!/bin/bash

#create dir if not exist
mkdir -p /var/www/html/im

#copy extra config for php monitor
cp ./monitorconfig.json /var/www/html/im

#main loop
while :
do

#create main data json 
./inverter_poller -1 > /var/log/im_data.log
cp /var/log/im_data.log /var/www/html/im/data.json

#create timestamp json
echo -e {"\n\""Last_poll"\"":"\""`date -r /var/log/im_data.log "+%H:%M:%S %m-%d-%Y"`"\"\n"} > /var/log/im_poll.log
cp /var/log/im_poll.log /var/www/html/im/poll.json

#create temp history json
echo -e -n { >> /var/log/im_temp.log
cat /var/log/im_data.log | grep "Heatsink_temperature" >> /var/log/im_temp.log
echo -e "   \""Last_poll"\"":"\""`date -r /var/log/im_data.log "+%Y-%m-%dT%H:%M:%S.000"`"\""}, >> /var/log/im_temp.log
echo -e {"\""Temp_history"\"":"\n"[ > /var/log/temp_history.log
cat /var/log/im_temp.log | tail -n 10000 > /var/log/im_temp.tmp && cat /var/log/im_temp.tmp > /var/log/im_temp.log
cat /var/log/im_temp.log >> /var/log/temp_history.log
truncate -s -2 /var/log/temp_history.log
echo -e "\n"]"\n"} >> /var/log/temp_history.log
cp /var/log/temp_history.log /var/www/html/im/temp_history.json

#create load history json
echo -e -n { >> /var/log/im_load.log
cat /var/log/im_data.log | grep "Load_pct" >> /var/log/im_load.log
echo -e "   \""Last_poll"\"":"\""`date -r /var/log/im_data.log "+%Y-%m-%dT%H:%M:%S.000"`"\""}, >> /var/log/im_load.log
echo -e {"\""Load_history"\"":"\n"[ > /var/log/load_history.log
cat /var/log/im_load.log | tail -n 10000 > /var/log/im_load.tmp && cat /var/log/im_load.tmp > /var/log/im_load.log
cat /var/log/im_load.log >> /var/log/load_history.log
truncate -s -2 /var/log/load_history.log
echo -e "\n"]"\n"} >> /var/log/load_history.log
cp /var/log/load_history.log /var/www/html/im/load_history.json

#create batt discharge history json
echo -e -n { >> /var/log/im_batt.log
cat /var/log/im_data.log | grep "Battery_discharge_current" >> /var/log/im_batt.log
echo -e "   \""Last_poll"\"":"\""`date -r /var/log/im_data.log "+%Y-%m-%dT%H:%M:%S.000"`"\""}, >> /var/log/im_batt.log
echo -e {"\""Batt_history"\"":"\n"[ > /var/log/batt_history.log
cat /var/log/im_batt.log | tail -n 10000 > /var/log/im_batt.tmp && cat /var/log/im_batt.tmp > /var/log/im_batt.log
cat /var/log/im_batt.log >> /var/log/batt_history.log
truncate -s -2 /var/log/batt_history.log
echo -e "\n"]"\n"} >> /var/log/batt_history.log
cp /var/log/batt_history.log /var/www/html/im/batt_history.json

#create ac input history json
echo -e -n { >> /var/log/im_ac_in.log
cat /var/log/im_data.log | grep "AC_grid_voltage" >> /var/log/im_ac_in.log
echo -e "   \""Last_poll"\"":"\""`date -r /var/log/im_data.log "+%Y-%m-%dT%H:%M:%S.000"`"\""}, >> /var/log/im_ac_in.log
echo -e {"\""AC_in_history"\"":"\n"[ > /var/log/ac_in_history.log
cat /var/log/im_ac_in.log | tail -n 10000 > /var/log/im_ac_in.tmp && cat /var/log/im_ac_in.tmp > /var/log/im_ac_in.log
cat /var/log/im_ac_in.log >> /var/log/ac_in_history.log
truncate -s -2 /var/log/ac_in_history.log
echo -e "\n"]"\n"} >> /var/log/ac_in_history.log
cp /var/log/ac_in_history.log /var/www/html/im/ac_in_history.json

#extra delay if  less frequent polling is needed
#sleep 5
done
