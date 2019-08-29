<?php
include '../php/sql.php';

if (!isset($_REQUEST["mealName"])) echo 'No name set!';
else {

	$mealDates = mysqli_query($con,"insert meals (Meal_name,Meal_Active) values ('".mysql_real_escape_string($con,$_REQUEST["mealName"])."',1);") or die(mysqli_error());

	echo 'Meal Added!';

}
?>