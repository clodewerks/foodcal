<?
// Make a MySQL Connection
mysql_connect("localhost", "clodewer_clode", "kijker42") or die(mysql_error());
mysql_select_db("clodewer_meals") or die(mysql_error());

$mealsArr = array();
$mealsPDD = array();
$mealInfo = mysql_query("SELECT * FROM meals where Meal_Active = 1 order by Meal_Name") or die(mysql_error());
while($row = mysql_fetch_array($mealInfo)){
$mealsPDD[] = "<div>  <span class=\"".$row['Meal_id']."\">".$row['Meal_Name']."</span><span>".$row['Meal_Desc']."</span> <input type='checkbox' name='mealDel".$row['Meal_id']."' /><label for='mealDel".$row['Meal_id']."'>Hide Meal</label></div>";
$mealsArr[$row['Meal_id']] = $row['Meal_Name'];
$recipeArr[$row['Meal_id']] = $row['Meal_recipe'];
}
$mealDD = implode("",$mealsPDD);
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
			<h1>Edit Meals</h1>
			<? echo "<div id='mealdd".($i)."'>".$mealDD."</div>"; ?>
			<form name='newmeal'  id='newmeal' action='mealAdd.php' method='post'>
				<span>Meal Name: </span><input type='text' name='mealName' id='mealName'/><br/>
				<span>Meal Description: </span><textarea id='mealDesc' name="mealDesc"></textarea><br/>
				<input type='submit' value ='Add Meal'/>
			</form>
			
		</div>
	</body>
</html>