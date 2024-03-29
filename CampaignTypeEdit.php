<?php
include("dbconnection.php");

if ($_GET["campaigntypeID"]) {
    $campaignTypeId = $_GET["campaigntypeID"];

    $query = "SELECT * FROM campaigntypetb 
        WHERE CampaignTypeID = '$campaignTypeId'";

    $resultQuery = mysqli_query($connect, $query);
    $array = mysqli_fetch_array($resultQuery);

    $campaignTypeId = $array['CampaignTypeID'];
    $campaignTypeName = $array['CampaignTypeName'];
}

if (isset($_POST["update"])) {
    $campaignTypeId = $_POST["campaigntypeid"];
    $campaignTypeName = $_POST["campaigntypename"];

    $update = "UPDATE campaigntypetb SET CampaignTypeName = '$campaignTypeName'
    WHERE CampaignTypeID = '$campaignTypeId'";

    $updateQuery = mysqli_query($connect, $update);

    if ($updateQuery) {
        echo "<script>window.alert('CampaignType is updated.')</script>";
        echo "<script>window.location = 'AdminDashBoard.php'</script>";
    } else {
        echo "<script>window.alert('Something went worng.')</script>";
        echo "<script>window.location = 'AdminDashBoard.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Campaigns (SMC)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="AdminStyle.css">
</head>

<body>
    <nav>
        <label for="hamburger"><i class="fa-solid fa-bars"></i></label>
        <input type="checkbox" id="hamburger">
        <ul id="hamitems">
            <li class="logo">
                <h1>SMC</h1>
                <p>Social Media Campaigns</p>
            </li>
            <li class="active">
                <a href="Admindashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="hover">
                <a href="AddCampaign.php">
                    <i class="fa-solid fa-campground"></i>
                    <span>Add Campaign</span>
                </a>
            </li>
            <li class="hover">
                <a href="AddCampaignType.php">
                    <i class="fa-solid fa-campground"></i>
                    <span>Add CampaignType</span>
                </a>
            </li>
            <li class="hover">
                <a href="AddMediaApp.php">
                    <i class="fa-solid fa-users"></i>
                    <span>Add SocialMedia</span>
                </a>
            </li>
            <li class="hover">
                <a href="AdminLogOut.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </a>
            </li>
        </ul>
        <div class="main-footer">
            <footer>
                <p class="copyright">&copy; 2024 Social Media Campaigns Ltd. All rights reserved.</p>
            </footer>
        </div>
    </nav>
    <div class="main-content">
        <div class="header-wrapper">
            <section class="campaigntype-section">
                <form class="campaigntype-edit" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                    <h2>Edit CampaignType</h2>
                    <label for="campaigntypeid">CampaignTypeID</label>
                    <input type="text" name="campaigntypeid" value="<?php echo $campaignTypeId; ?>" readonly>
                    <label for="campaigntypename">CampaignType Name</label>
                    <input type="text" name="campaigntypename" value="<?php echo $campaignTypeName; ?>">
                    <input type="submit" name="update" value="Update">
                </form>
            </section>
        </div>
    </div>
</body>

</html>