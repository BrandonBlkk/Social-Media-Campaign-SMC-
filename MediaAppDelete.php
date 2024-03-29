<?php
include("dbconnection.php");

$mediaAppId = $_GET["mediaappID"];
$mediaAppDelete = "DELETE FROM mediaapptb 
    WHERE MediaAppID = '$mediaAppId'";

$mediaAppQuery = mysqli_query($connect, $mediaAppDelete);

if ($mediaAppQuery) {
    echo "<script>window.alert('Media App data has been succesfully deleted.')</script>";
    echo "<script>window.location = 'AdminDashBoard.php'</script>";
} else {
    echo "<script>window.alert('Something went wrong.')</script>";
    echo "<script>window.location = 'AdminDashBoard.php'</script>";
}
