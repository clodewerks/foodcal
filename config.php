<?php
//Database Credentials
$username = '_UserName_';
$password = '_Password_';

//Global Variables
date_default_timezone_set ( 'America/Los_Angeles' );

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
if (!isset($_REQUEST["day"])) $_REQUEST["day"] = date("j");
if (!isset($_REQUEST["edit"])) $_REQUEST["edit"] = "false";
$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
$cDay = $_REQUEST["day"];
$edit = $_REQUEST["edit"];

$firsties = mktime(0,0,0,$cMonth,$cDay,$cYear);
$mLength = date("t",$firsties);
$thismonth = getdate ($firsties);
$startday = $thismonth['wday'];
$realStart = strtotime(date('Y-m-d',$firsties).'-'.$startday.' days');
$realMax = ($mLength + $startday + (7 - (($mLength + $startday) % 7)));
$realEnd = strtotime(date('Y-m-d',$realStart).'+ 7 days');
$nextWeek = strtotime(date('Y-m-d',$realStart).'+ 1 week');
$prevWeek = strtotime(date('Y-m-d',$realStart).'- 1 week');
?>