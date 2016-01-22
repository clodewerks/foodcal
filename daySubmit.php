<? 
//echo $_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day1'] 
// Make a MySQL Connection
	$con = mysqli_connect("localhost", "_USERNAME_", "_PASSWORD_", "clodewer_meals");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}  
  		$sql="Update calendar SET Meal_id = '".$_REQUEST['meal']."' WHERE meal_date='".$_REQUEST['day']."';";  
  		
	if (!mysqli_query($con,$sql))
	  {
	  die('Error: ' . mysqli_error($con));
	  }
	mysqli_close($con);
	//if (intval($_REQUEST['monthLength']) > 10) { header('Location: calendar.php?month='.$_REQUEST['month']);}
	echo $sql
	//else {header('Location: week.php?month='.$_REQUEST['month'].'&day='.$_REQUEST['cDay']);}
	
	
?>