<?php
include '../php/sql.php';

if (!isset($_REQUEST["mealID"])) echo 'Error: Please have Meal ID';
else if (!isset($_REQUEST["mealName"]) && !isset($_REQUEST["mealActive"])) echo 'Error: Must Update something.';
else {

$setStatement = '';

if (isset($_REQUEST["mealName"]) && !isset($_REQUEST["mealActive"])) $setStatement = "Meal_Name = '".mysql_real_escape_string($con,$_REQUEST["mealName"])."'";

if (!isset($_REQUEST["mealName"]) && isset($_REQUEST["mealActive"])) $setStatement = "Meal_Active = '".$_REQUEST["mealActive"]."'";

if (isset($_REQUEST["mealName"]) && isset($_REQUEST["mealActive"])) $setStatement = "Meal_Name = '".mysql_real_escape_string($con,$_REQUEST["mealName"])."', Meal_Active = '".$_REQUEST["mealActive"]."'";



	$mealDates = mysqli_query($con,"update meals set ".$setStatement."where Meal_id =".$_REQUEST["mealID"]) or die(mysqli_error());

	echo 'Meal Updated!';

}
?>