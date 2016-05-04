<?php

date_default_timezone_set("Europe/London");
include_once('_inc/function.php');
include_once('config.php');

$_dateParam = date("Y-m-d");

$_dateLabel = date("M j");

$_current_time = date("H:i:s");

$_next_race = json_decode(get_next_race($_dateParam, $_current_time));

header('Location: '. $folder. '/card/'.$_next_race->race_group.'/'.$_next_race->race_uid.'/'.$_dateParam);

exit();


