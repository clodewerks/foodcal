<?php
include '../php/dates.php';
include '../php/sql.php';

if (!isset($_REQUEST["timeframe"])) $_REQUEST["timeframe"] = 'month';

if($_REQUEST["timeframe"] == 'month'){

$mealDates = mysql_query("select calendar.meal_date, meals.* from calendar left join meals on calendar.Meal_id = meals.Meal_id where meal_date between '".date('Y-m-d',$monthViewStart)."' and '".date('Y-m-d',$monthViewEND)."'order by meal_date;") or die(mysql_error());
	while($row = mysql_fetch_array($mealDates)){
		$mealId[] = '{day:"'.$row['meal_date'].'", id:"'.$row['Meal_id'].'", name:"'.$row['Meal_Name'].'"}';
	}

}
else{
	mysql_connect("localhost", $username, $password) or die(mysql_error());
mysql_select_db("clodewer_meals") or die(mysql_error());
$mealDates = mysql_query("select calendar.meal_date, meals.* from calendar left join meals on calendar.Meal_id = meals.Meal_id where meal_date between '".date('Y-m-d',$weekViewStart)."' and '".date('Y-m-d',$weekViewEnd)."'order by meal_date;") or die(mysql_error());
while($row = mysql_fetch_array($mealDates)){
$mealId[] = '{day:"'.$row['meal_date'].'", id:"'.$row['Meal_id'].'", name:"'.$row['Meal_Name'].'"}';
}

}
echo "var meals=[";

for($x = 0; $x < count($mealId); $x++) {
    echo $mealId[$x];
   if($x < count($mealId)-1) echo ",";
}
echo "];";

?>