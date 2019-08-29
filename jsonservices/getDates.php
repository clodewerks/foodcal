<?php
include '../php/dates.php';
include '../php/sql.php';

if (!isset($_REQUEST["timeframe"])) $_REQUEST["timeframe"] = 'month';

if($_REQUEST["timeframe"] == 'month'){

$mealDates = mysqli_query($con,"select calendar.meal_date, meals.* from calendar left join meals on calendar.Meal_id = meals.Meal_id where meal_date between '".date('Y-m-d',$monthViewStart)."' and '".date('Y-m-d',$monthViewEND)."'order by meal_date;") or die(mysqli_error());
	while($row = mysqli_fetch_array($mealDates)){
		$mealId[] = '{day:"'.$row['meal_date'].'", id:"'.$row['Meal_id'].'", name:"'.$row['Meal_Name'].'"}';
	}
}
else{
$mealDates = mysqli_query($con,"select calendar.meal_date, meals.* from calendar left join meals on calendar.Meal_id = meals.Meal_id where meal_date between '".date('Y-m-d',$weekViewStart)."' and '".date('Y-m-d',$weekViewEnd)."'order by meal_date;") or die(mysqli_error());
while($row = mysqli_fetch_array($mealDates)){
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