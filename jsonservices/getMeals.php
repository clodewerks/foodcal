<?php
include '../php/sql.php';

if (!isset($_REQUEST["active"])) $_REQUEST["active"] = '1';

$mealDates = mysqli_query($con,"select * from meals where Meal_Active = ".$_REQUEST["active"]) or die(mysqli_error());

while($row = mysqli_fetch_array($mealDates)){
	$mealId[] = '{id:"'.$row['Meal_id'].'", name:"'.$row['Meal_Name'].'"}';
}

echo "var meals=[";

for($x = 0; $x < count($mealId); $x++) {
    echo $mealId[$x];
   if($x < count($mealId)-1) echo ",";
}
echo "];";

?>