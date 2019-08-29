<?php

include '../php/dates.php';
include '../php/sql.php';

if (!isset($_REQUEST["mealID"])) echo 'Error: Please have Meal ID';
if (!isset($_REQUEST["fullDate"])) echo 'Error: Please specify Date';

$query = 'update calendar set Meal_id ='.$_REQUEST["mealID"].' where meal_date =\''.$_REQUEST["fullDate"].'\';';

$mealDates = mysqli_query($con,$query) or die(mysqli_error());


echo 'Date Updated!';

?>