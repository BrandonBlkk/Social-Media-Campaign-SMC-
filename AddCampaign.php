<?php
session_start();
include("dbconnection.php");

if (!isset($_SESSION["AdminID"])) {
    echo "<script>window.alert('Login first! You cannot directly access.')</script>";
    echo "<script>window.location = 'AdminLogIn.php'</script>";
}

if (isset($_POST["add"])) {
    $campaignName = $_POST["campaignname"];
    $campaignDescription = $_POST["campaigndescription"];
    $campaignFees = $_POST["campaignfees"];
    $campaignLocation = $_POST["campaignlocation"];
    $campaignStartDate = $_POST["campaignstartdate"];
    $campaignEndDate = $_POST["campaignenddate"];
    $campaignAim = $_POST["campaignaim"];
    $campaignVision = $_POST["campaignvision"];
    $mediaApp = $_POST["mediaapp"];
    $campaignType = $_POST["campaigntype"];
    $campaignStatus = $_POST["campaignstatus"];

    // image upload 

    $campaignImage1 = $_FILES['campaignimage1']['name'];
    $copyFile = "AdminImage/";
    $fileName1 = $copyFile . uniqid() . "_" . $campaignImage1;
    $copy = copy($_FILES['campaignimage1']['tmp_name'], $fileName1);

    if (!$copy) {
        echo "<p>Cannot upload Campaign Image1</p>";
        exit();
    }

    $campaignImage2 = $_FILES['campaignimage2']['name'];
    $copyFile = "AdminImage/";
    $fileName2 = $copyFile . uniqid() . "_" . $campaignImage2;
    $copy = copy($_FILES['campaignimage2']['tmp_name'], $fileName2);

    if (!$copy) {
        echo "<p>Cannot upload Campaign Image2</p>";
        exit();
    }

    $campaignImage3 = $_FILES['campaignimage3']['name'];
    $copyFile = "AdminImage/";
    $fileName3 = $copyFile . uniqid() . "_" . $campaignImage3;
    $copy = copy($_FILES['campaignimage3']['tmp_name'], $fileName3);

    if (!$copy) {
        echo "<p>Cannot upload Campaign Image3</p>";
        exit();
    }

    $campaignImage4 = $_FILES['campaignimage4']['name'];
    $copyFile = "AdminImage/";
    $fileName4 = $copyFile . uniqid() . "_" . $campaignImage4;
    $copy = copy($_FILES['campaignimage4']['tmp_name'], $fileName4);

    if (!$copy) {
        echo "<p>Cannot upload Campaign Image4</p>";
        exit();
    }

    $campaignSelect = "SELECT * FROM campaigntypetb WHERE CampaignTypeName = '$campaignType'";
    $campaignQuery = mysqli_query($connect, $campaignSelect);
    $campaignRow = mysqli_num_rows($campaignQuery);

    if ($campaignRow > 0) {
        echo "<script>window.alert('Campaign already exists.')</script>";
        echo "<script>window.location = 'AddCampaign.php'</script>";
    } else {
        $campaignInsert = "INSERT INTO campaigntb(MediaAppID, CampaignTypeID, CampaignName, CampaignDescription, CampaignImage1, CampaignImage2, CampaignImage3, CampaignImage4, CampaignFees, CampaignLocation, CampaignStartDate,  CampaignEndDate, CampaignAim, CampaignVision, CampaignStatus)
            VALUES('$mediaApp', '$campaignType', '$campaignName', '$campaignDescription', '$fileName1', '$fileName2', '$fileName3', '$fileName4', '$campaignFees', '$campaignLocation', '$campaignStartDate', '$campaignEndDate', '$campaignAim', '$campaignVision', '$campaignStatus')";
        $campaignInsertQuery = mysqli_query($connect, $campaignInsert);

        if ($campaignInsertQuery) {
            echo "<script>window.alert('Campaign has been successfully added.')</script>";
            echo "<script>window.location = 'AddCampaign.php'</script>";
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
            <li class="active">
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
            <section class="campaign-section">
                <form class="campaign-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                    <h2>Add Campaign</h2>
                    <label for="campaignname">Campaign Name</label>
                    <input type="text" name="campaignname" id="campaignname" placeholder="Enter Campaign Name" required>
                    <label for="campaigndescription">Campaign Description</label>
                    <textarea name="campaigndescription" id="campaigndescription" cols="30" rows="3" placeholder="Enter Campaign Description" required></textarea>
                    <label for="campaignimage1">Campaign Image1</label>
                    <input type="file" name="campaignimage1" id="campaignimage1" required>
                    <label for="campaignimage2">Campaign Image2</label>
                    <input type="file" name="campaignimage2" id="campaignimage2" required>
                    <label for="campaignimage3">Campaign Image3</label>
                    <input type="file" name="campaignimage3" id="campaignimage3" required>
                    <label for="campaignimage4">Campaign Image4</label>
                    <input type="file" name="campaignimage4" id="campaignimage4" required>
                    <label for="campaignfees">Campaign Fees</label>
                    <input type="number" name="campaignfees" id="campaignfees" min="1" max="1000" placeholder="Enter Campaign Fees" required>
                    <label for="campaignlocation">Campaign Location</label>
                    <input type="text" name="campaignlocation" id="campaignlocation" placeholder="Enter Campaign Location" required>
                    <label for="campaignstartdate">Campaign Start Date</label>
                    <input type="date" class="input" name="campaignstartdate" id="campaignstartdate" value="<?php echo date("Y-m-d") ?>">
                    <label for="campaignenddate">Campaign End Date</label>
                    <input type="date" class="input" name="campaignenddate" id="campaignenddate" value="<?php echo date("Y-m-d") ?>">
                    <label for="campaignaim">Campaign Aim</label>
                    <textarea name="campaignaim" id="campaignaim" cols="30" rows="3" placeholder="Enter Campaign Aim" required></textarea>
                    <label for="campaignvision">Campaign Vison</label>
                    <textarea name="campaignvision" id="campaignvision" cols="30" rows="3" placeholder="Enter Campaign Vision" required></textarea>

                    <label for="mediaapp">Choose Media App</label>
                    <select name="mediaapp" id="mediaapp">
                        <?php
                        $select = "SELECT * FROM mediaapptb";
                        $query = mysqli_query($connect, $select);

                        $count = mysqli_num_rows($query);

                        for ($i = 0; $i < $count; $i++) {
                            $row = mysqli_fetch_array($query);
                            $MediaAppID = $row['MediaAppID'];
                            $MediaAppName = $row['MediaAppName'];

                            echo "<option value= '$MediaAppID'>$MediaAppName</option>";
                        }
                        ?>
                    </select>

                    <label for="campaigntype">Choose CampaignType</label>
                    <select name="campaigntype" id="campaigntype">
                        <?php
                        $select = "SELECT * FROM campaigntypetb";
                        $query = mysqli_query($connect, $select);

                        $count = mysqli_num_rows($query);

                        for ($i = 0; $i < $count; $i++) {
                            $row = mysqli_fetch_array($query);
                            $CampaignTypeID = $row['CampaignTypeID'];
                            $CampaignTypeName = $row['CampaignTypeName'];

                            echo "<option value= '$CampaignTypeID'>$CampaignTypeName</option>";
                        }
                        ?>
                    </select>

                    <label for="campaignstatus">Campaign Status</label>
                    <select name="campaignstatus" id="campaignstatus">
                        <option value="Avaliable">Avaliable</option>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Unavaliable">Unavaliable</option>
                    </select>
                    <div class="form-button">
                        <input type="submit" class="form-btn" name="add" value="Add">
                    </div>
                </form>
            </section>
        </div>
    </div>
</body>

</html>