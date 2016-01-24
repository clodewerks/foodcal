<?php
include 'config.php';

date_default_timezone_set ( 'America/Los_Angeles' );
if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
if (!isset($_REQUEST["edit"])) $_REQUEST["edit"] = "false";
$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
$edit = $_REQUEST["edit"];

$firsties = mktime(0,0,0,$cMonth,1,$cYear);
$mLength = date("t",$firsties);
$thismonth = getdate ($firsties);
$startday = $thismonth['wday'];
$realStart = strtotime(date('Y-m-d',$firsties).'-'.$startday.' days');
$realMax = ($mLength + $startday + (7 - (($mLength + $startday) % 7)));
$realEnd = strtotime(date('Y-m-d',$realStart).'+'.($realMax).' days');

// Make a MySQL Connection
mysql_connect("localhost", $username, $password) or die(mysql_error());
mysql_select_db("clodewer_meals") or die(mysql_error());
$mealDates = mysql_query("SELECT * FROM calendar where meal_date between '".date('Y-m-d',$realStart)."' and '".date('Y-m-d',$realEnd)."'order by meal_date;") or die(mysql_error());
while($row = mysql_fetch_array($mealDates)){
$mealId[] = $row['Meal_id'];
}

$mealsArr = array();
$mealsPDD = array();
$mealInfo = mysql_query("SELECT * FROM meals order by Meal_Name") or die(mysql_error());
while($row = mysql_fetch_array($mealInfo)){
if($row['Meal_Active'] == 1) $mealsPDD[] = "<option value=\"".$row['Meal_id']."\">".$row['Meal_Name']."</option>";
$mealsArr[$row['Meal_id']] = $row['Meal_Name'];
$recipeArr[$row['Meal_id']] = $row['Meal_recipe'];
$ActiveArr[$row['Meal_id']] = $row['Meal_Active'];
}
$mealDD = implode("",$mealsPDD);


$monthNames = Array("January", "February", "March", "April", "May", "June", "July", 
"August", "September", "October", "November", "December");

 
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Food Calendar</title>
		<link rel='stylesheet' href='css/style.css' type='text/css' />
		<script src="http://code.jquery.com/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="js/calendar.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">
	<form name='calForm' id="calForm" action="calSubmit.php" method="post">
	<input type="hidden" name="month" value ="<? echo $cMonth ?>"/>
	<input type="hidden" name="year" value ="<? echo $cYear ?>"/>
	<div id="content">
<table border="0" cellpadding="2" cellspacing="2">
<tr>
<td colspan="7" bgcolor="#999999" style="color:#FFFFFF">
	<a id="prevButton" href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>">Previous</a>
	<strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong>
	<a id="nextButton" href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>">Next</a>
</td>
</tr>
<tr>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>Th</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
</tr>
<?php 
for ($i=0; $i< $realMax; $i++) {
    if(($i % 7) == 0 ) echo "<tr>";
     $currentDay = (strtotime(date('Y-m-d',$realStart).'+'.$i.' days'));
    	echo "<td class='calDate";
    	if(date('m',$currentDay) != $cMonth) echo " prev ";
    	echo "'><div class='dateNumber'>".date('j',$currentDay)."</div>";
    	echo "<span id='text".$i."'>".$mealsArr[$mealId[$i]]."</span>";
    if($edit == "true"){
    		 ?> <input type='hidden' id='day<? echo $i; ?>' name='day<? echo $i; ?>' value="<? echo date('Y-m-d',$currentDay)?>"/>
    		 <? echo "<input type='hidden' name='meal".($i)."' id='meal".($i)."' value='".$mealId[$i]."'/>";
    		  echo "<select id='mealdd".($i)."'value='".$mealId[$i]."'>".$mealDD."</select>";
    	}
    	echo "</td>";
    
    if(($i % 7) == 6 ) echo "</tr>";
}
?>
				</table>
				<div id="bottomNav">
				<a href="week.php">Week View</a> || 
				<? if($edit == "false") echo "<a href=\"".$_SERVER["PHP_SELF"]."?month=".$cMonth."&year=".$cYear."&edit=true\">Edit</a>"; 
				else echo "<a href=\"".$_SERVER["PHP_SELF"]."?month=".$cMonth."&year=".$cYear."\">Done</a>";
			?>
				</div>
			</div>
		</form>
	<? if($edit == "true"){?>
		<input type="hidden" name="month" value ="<? echo $cMonth ?>"/>
		<form name='newmeal'  id='newmeal' action='mealAdd.php' method='post'>
		<span>Meal Name: </span><input type='text' name='mealName' id='mealName'/><br/>
		<span>Meal Description: </span><textarea id='mealDesc' name="mealDesc"></textarea><br/>
		<input type='submit' value ='Add Meal'/>
		</form>
	<?}?>
	<?
		echo $mealID[2];
	?>
	</div>
	<div style="display:none">
	<? echo $realMax  ?>
	</div>
</body>
</html>