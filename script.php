<?php

include_once('_inc/function.php');
include('config.php');

/***
sample input URL:  http://localhost/greyhoundbet-staging/redirect/UK/HALL_GREEN/2016-05-23/18:03
sample return URL: http://mswmedia.net/greyhoundbet/card/B/1452422/2016-05-23
***/

$debug = false;

$default_url = $_GET['p'];
list($country, $race_track, $date, $time) = explode('/', $default_url); 


$time = $time.":00";
$race_track = str_replace('_', ' ', $race_track);

$card = "/card";
$host = $site_url . $folder . $card;
$return_url = "";


if ($debug) {
echo "country: ".$country."<br />";
echo "race track: ".$race_track."<br />";
echo "date: ".$date."<br />";
echo "time: ".$time."<br />";
}


$_q = "SELECT dcm.track, 
			   dcm.track_uid as tuid,
			   dcr.track_uid,
			   dcr.race_uid,
			   dcr.race_group,
			   dcr.race_time,
			   dcr.track_date


		FROM dog_cards_Meeting as dcm
		LEFT JOIN dog_cards_Race as dcr 
		ON dcm.track_uid = dcr.track_uid
		WHERE dcr.track_date = '$date'
		AND dcr.race_time = '$time'
		AND dcm.track = '$race_track' 
		GROUP BY track ";

if ($debug) {
echo "<br />";
echo $_q;
echo "<br />";
}

$connect = mysqli_connector();
$_result = $connect->query($_q);
if ($_result->num_rows == 0) {
	
	$return_url = "INVALID_INPUT_URL";
}
else {

	$_row = $_result->fetch_array(MYSQLI_ASSOC);
	$return_url = $host ."/". $_row['race_group'] ."/". $_row['race_uid'] ."/". $_row['track_date'];
}

echo $return_url; 