<?php
include 'config.php';

mysql_connect("localhost", $username, $password) or die(mysql_error());
mysql_select_db("clodewer_meals") or die(mysql_error());


?>