<?php
session_start();
include("dbconnection.php");

if (!isset($_SESSION["AdminID"])) {
    echo "<script>window.alert('Login first! You cannot directly access.')</script>";
    echo "<script>window.location = 'AdminLogIn.php'</script>";
}

if (isset($_POST["add"])) {
    $campaignTypeName = $_POST["campaigntypename"];

    $campaignTypeSelect = "SELECT * FROM campaigntypetb WHERE CampaignTypeName = '$campaignType'";
    $campaignTypequery = mysqli_query($connect, $campaignTypeSelect);
    $campaignTypeRow = mysqli_num_rows($campaignTypequery);

    if ($campaignTypeRow > 0) {
        echo "<script>window.alert('CampaignType already exists.')</script>";
        echo "<script>window.location = 'AddCampaignType.php'</script>";
    } else {
        $campaignTypeInsert = "INSERT INTO campaigntypetb(CampaignTypeName)
            VALUES('$campaignTypeName')";
        $campaignTypeInsertQuery = mysqli_query($connect, $campaignTypeInsert);

        if ($campaignTypeInsertQuery) {
            echo "<script>window.alert('CampaignType has been successfully added.')</script>";
            echo "<script>window.location = 'AddCampaignType.php'</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Campaigns (SMC)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
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
            <li class="hover">
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
            <li class="active">
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
                <form class="campaigntype-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                    <h2>Add CampaignType</h2>
                    <label for="campaigntypename">CampaignType Name</label>
                    <input type="text" name="campaigntypename" id="campaigntypename" placeholder="Enter CampaignType Name" required>
                    <div class="form-button">
                        <input type="submit" class="form-btn" name="add" value="Add">
                    </div>
                </form>
            </section>
        </div>
    </div>
</body>

</html>