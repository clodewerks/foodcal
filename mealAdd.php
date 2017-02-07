<? 
//echo $_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day1'] 
if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
// Make a MySQL Connection
	$con = mysqli_connect("localhost", "clodewer_clode", "kijker42", "clodewer_meals");
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }
	  
		$sql ="INSERT INTO meals (Meal_Name, Meal_desc,Meal_Active) VALUES ('".$_REQUEST['mealName']."', '".$_REQUEST['mealDesc']."',1);";	

if (!mysqli_query($con,$sql))
	  {
	  die('Error: ' . mysqli_error($con));
	  }
	
	mysqli_close($con);
	header('Location: calendar.php?month='.$_REQUEST['month']);
?>
<html>
<head>
<?
echo "<META http-equiv='refresh' content='5;calendar.php?month=".$_REQUEST['month']."'/>";
?>
</head>
<body>
echo $sql;
</body>
</html>