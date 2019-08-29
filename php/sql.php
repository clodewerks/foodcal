<?php
include 'config.php';

$con = mysqli_connect("localhost", $username, $password) or die(mysqli_error());
mysqli_select_db($con,"clodewer_meals") or die(mysqli_error());


?>