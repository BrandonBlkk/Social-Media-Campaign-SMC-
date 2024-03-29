<?php
include("dbconnection.php");

if ($_GET["campaignID"]) {
    $campaignId = $_GET["campaignID"];

    $query = "SELECT * FROM campaigntb 
        WHERE CampaignID = '$campaignId'";

    $resultQuery = mysqli_query($connect, $query);
    $array = mysqli_fetch_array($resultQuery);

    $campaignId = $array['CampaignID'];
    $mediaAppId = $array['MediaAppID'];
    $campaignTypeId = $array['CampaignTypeID'];
    $campaignName = $array['CampaignName'];
    $campaignDescription = $array['CampaignDescription'];
    $campaignFees = $array['CampaignFees'];
    $campaignLocation = $array['CampaignLocation'];
    $campaignStartDate = $array['CampaignStartDate'];
    $campaignEndDate = $array['CampaignEndDate'];
    $campaignAim = $array['CampaignAim'];
    $campaignVision = $array['CampaignVision'];
    $campaignStatus = $array['CampaignStatus'];
}

if (isset($_POST["update"])) {
    $campaignId = $_POST["campaignid"];
    $mediaAppId = $_POST["mediaappid"];
    $campaignTypeId = $_POST["campaigntypeid"];
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

    // Campaign image update 
    $campaignimgupdate1 = $_FILES["campaignimage1"]["name"];
    $copyFile = "AdminImage/";
    $updateimg1 = $copyFile . uniqid() . "_" . $campaignimgupdate1;
    $copy = copy($_FILES["campaignimage1"]["tmp_name"], $updateimg1);

    $campaignimgupdate2 = $_FILES["campaignimage2"]["name"];
    $copyFile = "AdminImage/";
    $updateimg2 = $copyFile . uniqid() . "_" . $campaignimgupdate2;
    $copy = copy($_FILES["campaignimage2"]["tmp_name"], $updateimg2);

    $campaignimgupdate3 = $_FILES["campaignimage3"]["name"];
    $copyFile = "AdminImage/";
    $updateimg3 = $copyFile . uniqid() . "_" . $campaignimgupdate3;
    $copy = copy($_FILES["campaignimage3"]["tmp_name"], $updateimg3);

    $campaignimgupdate4 = $_FILES["campaignimage4"]["name"];
    $copyFile = "AdminImage/";
    $updateimg4 = $copyFile . uniqid() . "_" . $campaignimgupdate4;
    $copy = copy($_FILES["campaignimage4"]["tmp_name"], $updateimg4);

    $update = "UPDATE campaigntb SET CampaignName = '$campaignName', CampaignDescription = '$campaignDescription', CampaignImage1 = '$updateimg1', CampaignImage2 = '$updateimg2', CampaignImage3 = '$updateimg3', CampaignImage4 = '$updateimg4', CampaignFees = '$campaignFees', CampaignLocation = '$campaignLocation', CampaignStartDate = '$campaignStartDate', CampaignEndDate = '$campaignEndDate', CampaignAim = '$campaignAim', CampaignVision = '$campaignVision', CampaignStatus = '$campaignStatus'  
    WHERE CampaignID = '$campaignId'";

    $updateQuery = mysqli_query($connect, $update);

    if ($updateQuery) {
        echo "<script>window.alert('Campaign is updated.')</script>";
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
                <form class="campaign-edit" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                    <h2>Edit Campaign</h2>
                    <label for="campaignid">CampaignID</label>
                    <input type="text" name="campaignid" id="campaignid" value="<?php echo $campaignId ?>" readonly>
                    <label for="mediaappid">MediaAppID</label>
                    <input type="text" name="mediaappid" id="mediaappid" value="<?php echo $mediaAppId ?>" readonly>
                    <label for="campaigntypeid">CampaignTypeID</label>
                    <input type="text" name="campaigntypeid" id="campaigntypeid" value="<?php echo $campaignTypeId ?>" readonly>
                    <label for="campaignname">Campaign Name</label>
                    <input type="text" name="campaignname" id="campaignname" value="<?php echo $campaignName ?>">
                    <label for="campaigndescription">Campaign Description</label>
                    <textarea name="campaigndescription" id="campaigndescription" cols="30" rows="3"><?php echo $campaignDescription ?></textarea>
                    <label for="campaignimage1">Campaign Image1</label>
                    <input type="file" name="campaignimage1" id="campaignimage1" required>
                    <label for="campaignimage2">Campaign Image2</label>
                    <input type="file" name="campaignimage2" id="campaignimage2" required>
                    <label for="campaignimage3">Campaign Image3</label>
                    <input type="file" name="campaignimage3" id="campaignimage3" required>
                    <label for="campaignimage4">Campaign Image4</label>
                    <input type="file" name="campaignimage4" id="campaignimage4" required>
                    <label for="campaignfees">Campaign Fees</label>
                    <input type="number" name="campaignfees" id="campaignfees" min="1" max="1000" value="<?php echo $campaignFees ?>">
                    <label for="campaignlocation">Campaign Location</label>
                    <input type="text" name="campaignlocation" id="campaignlocation" value="<?php echo $campaignLocation ?>">
                    <label for="campaignstartdate">Campaign Start Date</label>
                    <input type="date" class="input" name="campaignstartdate" id="campaignstartdate" value="<?php echo date("Y-m-d") ?>">
                    <label for="campaignenddate">Campaign End Date</label>
                    <input type="date" class="input" name="campaignenddate" id="campaignenddate" value="<?php echo date("Y-m-d") ?>">
                    <label for="campaignaim">Campaign Aim</label>
                    <textarea name="campaignaim" id="campaignaim" cols="30" rows="3"><?php echo $campaignAim ?></textarea>
                    <label for="campaignvision">Campaign Vison</label>
                    <textarea name="campaignvision" id="campaignvision" cols="30" rows="3"><?php echo $campaignVision ?></textarea>

                    <label for="mediaapp">Choose Media App</label>
                    <select name="mediaapp" id="mediaapp">
                        <option value="<?php echo $mediaAppId ?>"><?php echo $mediaAppId ?></option>
                        <?php
                        $select = "SELECT * FROM mediaapptb";
                        $query = mysqli_query($connect, $select);

                        $count = mysqli_num_rows($query);

                        for ($i = 0; $i < $count; $i++) {
                            $row = mysqli_fetch_array($query);
                            $MediaAppID = $row['MediaAppID'];
                            $MediaAppName = $row['MediaAppName'];

                            echo "<option value='$MediaAppID'>$MediaAppName</option>";
                        }
                        ?>
                    </select>

                    <label for="campaigntype">Choose CampaignType</label>
                    <select name="campaigntype" id="campaigntype">
                        <option value="<?php echo $campaignTypeId ?>"><?php echo $campaignTypeId ?></option>
                        <?php
                        $select = "SELECT * FROM campaigntypetb";
                        $query = mysqli_query($connect, $select);

                        $count = mysqli_num_rows($query);

                        for ($i = 0; $i < $count; $i++) {
                            $row = mysqli_fetch_array($query);
                            $CampaignTypeID = $row['CampaignTypeID'];
                            $CampaignTypeName = $row['CampaignTypeName'];

                            echo "<option value='$CampaignTypeID'>$CampaignTypeName</option>";
                        }
                        ?>
                    </select>

                    <label for="campaignstatus">Campaign Status</label>
                    <select name="campaignstatus" id="campaignstatus">
                        <option value="<?php echo $campaignStatus ?>"><?php echo $campaignStatus ?></option>
                        <option value="Avaliable">Avaliable</option>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Unavaliable">Unavaliable</option>
                    </select>
                    <input type="submit" class="form-btn" name="update" value="Update">
                </form>
            </section>
        </div>
    </div>
</body>

</html>