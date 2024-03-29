<?php
include("dbconnection.php");

$campaignId = $_GET["campaignID"];
$campaignDelete = "DELETE FROM campaigntb 
    WHERE CampaignID = '$campaignId'";

$campaignQuery = mysqli_query($connect, $campaignDelete);

if ($campaignQuery) {
    echo "<script>window.alert('Campaign data has been succesfully deleted.')</script>";
    echo "<script>window.location = 'AdminDashBoard.php'</script>";
} else {
    echo "<script>window.alert('Something went wrong.')</script>";
    echo "<script>window.location = 'AdminDashBoard.php'</script>";
}
