<?php
date_default_timezone_set ( 'America/Los_Angeles' );

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
if (!isset($_REQUEST["day"])) $_REQUEST["day"] = date("j");

//Week View Variables
$weekViewFirst = mktime(0,0,0,$_REQUEST["month"],$_REQUEST["day"],$_REQUEST["year"]);
$wLength = date("t",$weekViewFirst);
$thisWeek = getdate ($weekViewFirst);
$weekStartDay = $thisWeek['wday'];
$weekViewStart = strtotime(date('Y-m-d',$weekViewFirst).'-'.$weekStartDay.' days');
$weekViewEnd = strtotime(date('Y-m-d',$weekViewStart).'+ 6 days');


//Month View Variables
$monthViewFirst = mktime(0,0,0,$_REQUEST["month"],1,$_REQUEST["year"]);
$mLength = date("t",$monthViewFirst);
$thismonth = getdate ($monthViewFirst);
$monthStartDay = $thismonth['wday'];
$monthViewStart = strtotime(date('Y-m-d',$monthViewFirst).'-'.$monthStartDay.' days');
$monthViewMax = ($mLength + $monthStartDay + (7 - (($mLength + $monthStartDay) % 7))-1);
$monthViewEND = strtotime(date('Y-m-d',$monthViewStart).'+'.($monthViewMax).' days');

$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

$prev_year = $_REQUEST["year"];
$next_year = $_REQUEST["year"];
$prev_month = $_REQUEST["month"]-1;
$next_month = $_REQUEST["month"]+1;
$nextWeek = strtotime(date('Y-m-d',$weekViewStart).'+ 1 week');
$prevWeek = strtotime(date('Y-m-d',$weekViewStart).'- 1 week');
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $_REQUEST["year"] - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $_REQUEST["year"] + 1;
}

?>