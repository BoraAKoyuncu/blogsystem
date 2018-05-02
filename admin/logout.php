<?php
session_start();
include('../includes/db_connection.php');


session_destroy();
//include("login.php");
header("Location:login.php");
exit();
?>