<?php
include("dbconnection.php");

$campaignTypeId = $_GET["campaigntypeID"];
$campaignTypeDelete = "DELETE FROM campaigntypetb 
    WHERE CampaignTypeID = '$campaignTypeId'";

$campaignTypeQuery = mysqli_query($connect, $campaignTypeDelete);

if ($campaignTypeQuery) {
    echo "<script>window.alert('CampaignType data has been succesfully deleted.')</script>";
    echo "<script>window.location = 'AdminDashBoard.php'</script>";
} else {
    echo "<script>window.alert('Something went wrong.')</script>";
    echo "<script>window.location = 'AdminDashBoard.php'</script>";
}
