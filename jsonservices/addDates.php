<?php
include '../php/dates.php';
include '../php/sql.php';

$query =  'insert ignore into calendar (`meal_date`, `Meal`, `Meal_id`) VALUES ';
while ($monthViewStart <= $monthViewEND) {
    $query = $query.' (\''.date('Y-m-d',$monthViewStart).'\',\'\',\'12\')';
    if($monthViewStart < $monthViewEND) $query = $query.',';
    else $query = $query.'';
    $monthViewStart = strtotime(date('Y-m-d',$monthViewStart).'+ 1 day');
}
$mealDates = mysql_query($query) or die(mysql_error());

echo 'Dates Added!';

?>