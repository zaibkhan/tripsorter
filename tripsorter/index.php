<?php
require_once __DIR__ . '/TripSorter.php';

$tripSorter = new TripSorter();
$myJourney  = $tripSorter->startMyTrip();
echo $myJourney;
?>