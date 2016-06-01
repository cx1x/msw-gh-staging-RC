<?php

/*
READ ME:

> use '/' for mswdogs.ph domain
> use '/<folder-name>' if code is inside a folder like /greyhoundbet on mswmedia.net domain
 
 */

$folder = '/greyhoundbet-staging';
$site_url = 'https://mswmedia.net' . $folder;


if (strpos($folder, 'staging') === false) {
    error_reporting(0); // production turn-off error
}
else
{
	error_reporting(1); // show error
}