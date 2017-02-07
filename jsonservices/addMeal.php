<?php
include '../php/sql.php';

if (!isset($_REQUEST["mealName"])) echo 'No name set!';
else {

	$mealDates = mysql_query("insert meals (Meal_name,Meal_Active) values ('".mysql_real_escape_string($_REQUEST["mealName"])."',1);") or die(mysql_error());

	echo 'Meal Added!';

}
?>