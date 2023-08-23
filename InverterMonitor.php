<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=2.0">
  <title>Inverter Monitor</title>
  <link rel="icon" type="image/png" href="InverterMonitor.png">
  <meta http-equiv="refresh" content="10">
  <style>
  table, th, td
    {
      border: 0px white;
      padding: 0px;
      border-collapse: collapse;
      vertical-align: middle;
      margin-left: auto;
      margin-right: auto;
      font-size: small;
      font-family: Arial, Helvetica, sans-serif;
    }

  body
    {
    color: gray;
    background-color: black;
    }
  </style>
</head>

<body>
  <?php
  $json_config = json_decode(file_get_contents('./im/monitorconfig.json'),true);
  $model = $json_config['Model'];
  $batt_count = $json_config['Battery_count'];

  //shell_exec('env -i /etc/InverterMonitor/inverter_poller -1 > /var/www/html/data.json &');
  $last_poll = date("d M Y H:i:s", filemtime('./im/data.json'));
  $json_data = json_decode(file_get_contents('./im/data.json'),true);
  $inv_mode = $json_data['Inverter_mode'];
  $ac_grid_v = $json_data['AC_grid_voltage'];
  $ac_grid_freq = $json_data['AC_grid_frequency'];
  $ac_out_v = $json_data['AC_out_voltage'];
  $ac_out_freq = $json_data['AC_out_frequency'];
  $pv_in_v = $json_data['PV_in_voltage'];
  $pv_in_c = $json_data['PV_in_current'];
  $pv_in_w = $json_data['PV_in_watts'];
  $pv_in_wh = $json_data['PV_in_watthour'];
  $scc_v = $json_data['SCC_voltage'];
  $load_pct = $json_data['Load_pct'];
  $load_w = $json_data['Load_watt'];
  $load_wh = $json_data['Load_watthour'];
  $load_va = $json_data['Load_va'];
  $bus_v = $json_data['Bus_voltage'];
  $heatsink_temp = $json_data['Heatsink_temperature'];
  $batt_capacity = $json_data['Battery_capacity'];
  $batt_v = $json_data['Battery_voltage'];
  $batt_charge_current = $json_data['Battery_charge_current'];
  $batt_discharge_current = $json_data['Battery_discharge_current'];
  $load_status_on = $json_data['Load_status_on'];
  $scc_charge_on = $json_data['SCC_charge_on'];
  $ac_charge_on = $json_data['AC_charge_on'];
  $batt_recharge_v = $json_data['Battery_recharge_voltage'];
  $batt_under_v = $json_data['Battery_under_voltage'];
  $batt_bulk_v = $json_data['Battery_bulk_voltage'];
  $batt_float_v = $json_data['Battery_float_voltage'];
  $max_grid_charge_current = $json_data['Max_grid_charge_current'];
  $max_charge_current = $json_data['Max_charge_current'];
  $out_source_priority = $json_data['Out_source_priority'];
  $charger_source_priority = $json_data['Charger_source_priority'];
  $batt_redischarge_v = $json_data['Battery_redischarge_voltage'];
  $warnings = $json_data['Warnings'];
  ?>
  
    <table>
      <tr>
        <td colspan="4" style="text-align:center; color:limegreen"><b><?php echo "Last poll: ", date("d M Y H:i:s");?></b></td>
      </tr>
      <tr>
        <td>
          <div id="battcap_div"></div>
        </td>
        <td>
          <div id="battv_div"></div>
        </td>
        <td>
          <div id="load_div"></div>
        </td>
        <td>
          <div id="temp_div"></div>
        </td>
      </tr>
        <tr>
        <td>
          <div id="gridv_div"></div>
        </td>
        <td>
          <div id="gridfreq_div"></div>
        </td>
        <td>
          <div id="inverterv_div"></div>
        </td>
        <td>
          <div id="inverterfreq_div"></div>
        </td>
      </tr>
    </table>
  </div>

  <div id="data_table">
    <table>
    <tr>
      <td colspan="2" style="text-align:center; color:limegreen"><b>Inverter Info</b></td>
    </tr>
    <tr>
      <td>Model:</td>
      <td style="text-align:center"><?php echo $model;?></td>
    </tr>
    <tr>
      <td>Inverter mode:</td>
      <td style="text-align:center"><?php switch ($inv_mode)
      {
       case "1": echo "Power on"; break;
       case "2": echo "Standby"; break;
       case "3": echo "Line"; break;
       case "4": echo "Battery"; break;
       case "5": echo "Fault"; break;
       case "6": echo "Power saving"; break;
       case "0": echo "Unknown"; break;
      }?></td>
    </tr>
    <tr>
      <td>Battery count:</td>
      <td style="text-align:center"><?php echo $batt_count;?></td>
    </tr>

    <!--
    <tr>
      <td colspan="2" style="text-align:center; color:limegreen"><b>AC Info</b></td>
    </tr>
    <tr>
      <td>Grid voltage:</td>
      <td style="text-align:center"><?php echo "$ac_grid_v V";?></td>
    </tr>
    <tr>
      <td>Grid frequency:</td>
      <td style="text-align:center"><?php echo "$ac_grid_freq Hz" ;?></td>
    </tr>
    <tr>
      <td>Inverter voltage:</td>
      <td style="text-align:center"><?php echo "$ac_out_v V";?></td>
    </tr>
    <tr>
      <td>Inverter frequency:</td>
      <td style="text-align:center"><?php echo "$ac_out_freq Hz";?></td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align:center; color:limegreen"><b>Solar Info</b></td>
    </tr>
    <tr>
      <td>PV input voltage:</td>
      <td style="text-align:center"><?php echo "$pv_in_v V";?></td>
    </tr>
    <tr>
      <td>PV input current:</td>
      <td style="text-align:center"><?php echo "$pv_in_c A";?></td>
    </tr>
    <tr>
      <td>PV input watt:</td>
      <td style="text-align:center"><?php echo "$pv_in_w W";?></td>
    </tr>
    <tr>
      <td>PV input watthour:</td>
      <td style="text-align:center"><?php echo "$pv_in_wh Wh";?></td>
    </tr>
    <tr>
    -->
    <tr>
      <td colspan="2" style="text-align:center; color:limegreen"><b>Battery Info</b></td>
    </tr>
    <tr>
      <td>Battery charge current:</td>
      <td style="text-align:center"><?php echo "$batt_charge_current A";?></td>
    </tr>
    <tr>
      <td>Battery discharge current:</td>
      <td style="text-align:center"><?php echo "$batt_discharge_current A";?></td>
    </tr>
    <tr>
      <td>Load status on:</td>
      <td style="text-align:center"><?php echo "$load_status_on";?></td>
    </tr>
    <tr>
      <td>SCC charge on:</td>
      <td style="text-align:center"><?php echo "$scc_charge_on";?></td>
    </tr>
    <tr>
      <td>AC charge on:</td>
      <td style="text-align:center"><?php echo "$ac_charge_on";?></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align:center; color:limegreen"><b>Other Settings</b></td>
    </tr>
    <tr>
      <td>Battery recharge voltage:</td>
      <td style="text-align:center"><?php echo "$batt_recharge_v V";?></td>
    </tr>
    <tr>
      <td>Battery low voltage:</td>
      <td style="text-align:center"><?php echo "$batt_under_v V";?></td>
    </tr>
    <tr>
      <td>Battery bulk charge voltage:</td>
      <td style="text-align:center"><?php echo "$batt_bulk_v V";?></td>
    </tr>
    <tr>
      <td>Battery float charge voltage:</td>
      <td style="text-align:center"><?php echo "$batt_float_v V";?></td>
    </tr>
    <tr>
      <td>Battery re-discharge voltage:</td>
      <td style="text-align:center"><?php echo "$batt_redischarge_v V";?></td>
    </tr>
    <tr>
      <td>Max grid charge current:</td>
      <td style="text-align:center"><?php echo "$max_grid_charge_current A";?></td>
    </tr>
    <tr>
      <td>Max total charge current:</td>
      <td style="text-align:center"><?php echo "$max_charge_current A";?></td>
    </tr>
    <tr>
      <td>Output source priority:</td>
      <td style="text-align:center"><?php echo "$out_source_priority";?></td>
    </tr>
    <tr>
      <td>Charge source priority:</td>
      <td style="text-align:center"><?php echo "$charger_source_priority";?></td>
    </tr>
  </table>
  </div>
<!-- Commands, etc
  <div id="commands">
  <table>
    <tr>
      <td colspan="2" style="text-align:center; color:limegreen"><b>Commands</b></td>
    </tr>
    <tr>
        <td><input id="1" name="ebz" type="button" value="Enable buzzer" tabindex="1" style="width: 100%"></td>
        <td><input id="2" name="dbz" type="button" value="Disable buzzer" tabindex="2" style="width: 100%"></td>
    </tr>
    <tr>
        <td><input id="3" name="ebl" type="button" value="Enable backlight" tabindex="3" style="width: 100%"></td>
        <td><input id="4" name="dbl" type="button" value="Disable backlight" tabindex="4" style="width: 100%"></td>
    </tr>
  </table>
  </div>
-->
<!-- Mini Monitor
<div style="color:grey; font-family:monospace; font-size:large; text-align:center">
<pre>

AC Grid Voltage:       <meter id="ac_grid_v" value=<?php echo $ac_grid_v;?> min="200" max="260"></meter>
AC Grid Frequency:     <meter id="ac_grid_freq" value=<?php echo $ac_grid_freq;?> min="40" max="60"></meter>
AC Inverter Voltage:   <meter id="ac_out_v" value=<?php echo $ac_out_v?> min="200" max="260"></meter>
AC Inverter Frequency: <meter id="ac_out_freq" value=<?php echo $ac_out_freq?> min="40" max="60"></meter>
</pre>
</div>
-->
  <script type="text/javascript" src="loader.js"></script>
  <script type="text/javascript">

      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var battcap_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Batt %',<?php echo $batt_capacity;?>]
        ]);

        var battv_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Batt V',<?php echo $batt_v / $batt_count;?>]
        ]);

        var load_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Load %',<?php echo $load_pct;?>]
        ]);

        var temp_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Temp',<?php echo $heatsink_temp;?>]
        ]);

        var gridv_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Grid V',<?php echo $ac_grid_v;?>]
        ]);

        var gridfreq_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Grid Hz',<?php echo $ac_grid_freq;?>]
        ]);

        var inverterv_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Inv. V',<?php echo $ac_out_v;?>]
        ]);

        var inverterfreq_data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Inv. Hz',<?php echo $ac_out_freq;?>]
        ]);

        var battcap_options = {
          width: 300, height: 90,
          redFrom: 0, redTo: 20,
          yellowFrom: 20, yellowTo: 60,
          greenFrom: 0, greenTo: 100,
          majorTicks: ['0','20','40','60','80','100'],
          minorTicks: 10,
          min: 0,
          max: 100
        };

        var battv_options = {
          width: 300, height: 90,
          redFrom: 10, redTo: 12,
          yellowFrom: 12, yellowTo: 13,
          greenFrom: 13, greenTo: 14,
          majorTicks: ['10','11','12','13','14'],
          minorTicks: 10,
          min: 10,
          max: 14
        };

        var load_options = {
          width: 300, height: 90,
          redFrom: 80, redTo: 100,
          yellowFrom: 60, yellowTo: 80,
          greenFrom: 0, greenTo: 60,
          majorTicks: ['0','20','40','60','80','100'],
          minorTicks: 10,
          min: 0,
          max: 100
        };

        var temp_options = {
          width: 300, height: 90,
          redFrom: 60, redTo: 80,
          yellowFrom: 40, yellowTo: 60,
          greenFrom: 0, greenTo: 40,
          majorTicks: ['0','10','20','30','40','50','60','70','80'],
          minorTicks: 10,
          min: 0,
          max: 80
        };

        var gridv_options = {
          width: 300, height: 90,
          greenFrom: 225, greenTo: 235,
          majorTicks: ['200','210','220','230','240','250','260'],
          minorTicks: 10,
          min: 200,
          max: 260
        };

        var gridfreq_options = {
          width: 300, height: 90,
          greenFrom: 48, greenTo: 52,
          majorTicks: ['40','50','60'],
          minorTicks: 10,
          min: 40,
          max: 60
        };

        var inverterv_options = {
          width: 300, height: 90,
          greenFrom: 225, greenTo: 235,
          majorTicks: ['200','210','220','230','240','250','260'],
          minorTicks: 10,
          min: 200,
          max: 260
        };

        var inverterfreq_options = {
          width: 300, height: 90,
          greenFrom: 48, greenTo: 52,
          majorTicks: ['40','50','60'],
          minorTicks: 10,
          min: 40,
          max: 60
        };

        var battcap_chart = new google.visualization.Gauge(document.getElementById('battcap_div'));
        var battv_chart = new google.visualization.Gauge(document.getElementById('battv_div'));
        var load_chart = new google.visualization.Gauge(document.getElementById('load_div'));
        var temp_chart = new google.visualization.Gauge(document.getElementById('temp_div'));
        var gridv_chart = new google.visualization.Gauge(document.getElementById('gridv_div'));
        var gridfreq_chart = new google.visualization.Gauge(document.getElementById('gridfreq_div'));
        var inverterv_chart = new google.visualization.Gauge(document.getElementById('inverterv_div'));
        var inverterfreq_chart = new google.visualization.Gauge(document.getElementById('inverterfreq_div'));

        battcap_chart.draw(battcap_data, battcap_options);
        battv_chart.draw(battv_data, battv_options);
        load_chart.draw(load_data, load_options);
        temp_chart.draw(temp_data, temp_options);
        gridv_chart.draw(gridv_data, gridv_options);
        gridfreq_chart.draw(gridfreq_data, gridfreq_options);
        inverterv_chart.draw(inverterv_data, inverterv_options);
        inverterfreq_chart.draw(inverterfreq_data, inverterfreq_options);
      }

  </script>

</body>
</html>
