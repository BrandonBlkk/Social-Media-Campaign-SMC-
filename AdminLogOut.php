<?php
session_start();
include("dbconnection.php");
session_destroy();

echo "<script>window.alert('Signout Successful.')</script>";
echo "<script>window.location = 'AdminLogIn.php'</script>";
