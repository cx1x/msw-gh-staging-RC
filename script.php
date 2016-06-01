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

/***
match track name between SIS (LVS) and RACING POST (MSW)
***/
$lvs_track_name = array(
	'BELLE_VUE' 	=> 'BELLE_VUE',
	'CRAYFORD' 		=> 'CRAYFORD',
	'DONCASTER' 	=> 'DONCASTER',
	'HALL_GREEN'	=> 'HALL_GREEN',
	'HARLOW'		=> 'HARLOW',
	'HENLOW'		=> 'HENLOW',
	'HOVE'			=> 'HOVE',
	'KINSLEY'		=> 'KINSLEY',
	'MAIDENHALL'	=> 'MILDENHALL',
	'MONMORE'		=> 'MONMORE',
	'NEWCASTLE_DG'	=> 'NEWCASTLE',
	'NOTTS_(DOGS)'	=> 'NOTTINGHAM',
	'PELAW_GRANGE'	=> 'PELAW_GRANGE',
	'PERRY_BARR'	=> 'PERRY_BARR',
	'PETERBOROUGH'	=> 'PETERBOROUGH',
	'POOLE'			=> 'POOLE',
	'ROMFORD'		=> 'ROMFORD',
	'SHAWFIELD'		=> 'SHAWFIELD',
	'SHEFFIELD'		=> 'SHEFFIELD',
	'SITTINGBOURN'	=> 'SITTINGBOURNE',
	'SUNDERLAND'	=> 'SUNDERLAND',
	'SWINDON'		=> 'SWINDON',
	'TOWCESTER_DG'	=> 'TOWCESTER',
	'WIMBLEDON'		=> 'WIMBLEDON',
	'YARM\'TH_DOGS'	=> 'YARMOUTH',
	'YARMTH_DOGS'	=> 'YARMOUTH'
);


try {


	if (!array_key_exists($race_track, $lvs_track_name))
	{
		echo $race_track . " does not found. ";
		exit;
	}
	else
	{
		$race_track = $lvs_track_name[$race_track];

		$time = $time.":00";
		$race_track = str_replace('_', ' ', $race_track);

		$card = "/card";
		$host = $site_url . $card;
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
			
			$return_url = "Race ". $date ." (" . $time . ") under ". $race_track ." does not found";
			echo $return_url;
			exit;
		}
		else {

			$_row = $_result->fetch_array(MYSQLI_ASSOC);
			$return_url = $host ."/". $_row['race_group'] ."/". $_row['race_uid'] ."/". $_row['track_date'];
			//echo $return_url;
			header("location: ".$return_url);
		}

	}

}catch (customException $e) {


	//echo $e->errorMessage();
	
	$subject 	= "Subject: [NOTICE] PROD ERROR - TESTING";	
	$link 		= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$message 	= $e->errorMessage();
	$body		= $link ."<br /><br />". $message;
	$headers   	= array();
	$headers[] 	= "MIME-Version: 1.0 \r\n";
	$headers[] 	= "Content-type: text/plain; charset=utf-8\r\n";
	$headers[] 	= "From: MSW Debug Mailer \r\n";
	$headers[] 	= $subject ."\r\n";
	mail("christian.realubit@megasportsworld.com", $subject, $body, implode("\r\n", $headers));

}