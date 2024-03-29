<?php
include("dbconnection.php");

if ($_GET["mediaappID"]) {
    $mediaAppId = $_GET["mediaappID"];

    $query = "SELECT * FROM mediaapptb 
        WHERE MediaAppID = '$mediaAppId'";

    $resultQuery = mysqli_query($connect, $query);
    $array = mysqli_fetch_array($resultQuery);

    $mediaAppId = $array['MediaAppID'];
    $mediaAppName = $array['MediaAppName'];
    $mediaAppImage = $array['MediaAppImage'];
    $rating = $array['Rating'];
    $platform = $array['Platform'];
    $developer = $array['Developer'];
    $technique = $array['Technique'];
    $techniqueStatus = $array['TechniqueStatus'];
}

if (isset($_POST["update"])) {
    $mediaAppId = $_POST['mediaappid'];
    $mediaAppName = $_POST['mediaappname'];
    $rating = $_POST['mediaapprating'];
    $platform = $_POST['platform'];
    $developer = $_POST['developer'];
    $technique = $_POST['technique'];
    $techniqueStatus = $_POST['techniquestatus'];

    // Media image update 
    $mediaimgupdate = $_FILES["mediaappimage"]["name"];
    $copyFile = "AdminImage/";
    $updateimg = $copyFile . uniqid() . "_" . $mediaimgupdate;
    $copy = copy($_FILES["mediaappimage"]["tmp_name"], $updateimg);

    $update = "UPDATE mediaapptb SET MediaAppName = '$mediaAppName', MediaAppImage = '$updateimg', Rating = '$rating', Platform = '$platform', Developer = '$developer', Technique = '$technique', TechniqueStatus = '$techniqueStatus' 
    WHERE MediaAppID = '$mediaAppId'";

    $updateQuery = mysqli_query($connect, $update);

    if ($updateQuery) {
        echo "<script>window.alert('MediaApp is updated.')</script>";
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
            <section class="mediaapp-section">
                <form class="mediaapp-edit" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                    <h2>Edit MediaApp</h2>
                    <label for="mediaappid">MediaAppID</label>
                    <input type="text" name="mediaappid" value="<?php echo $mediaAppId; ?>" readonly>
                    <label for="mediaappame">MediaApp Name</label>
                    <input type="text" name="mediaappname" id="mediaappname" value="<?php echo $mediaAppName; ?>">
                    <label for="mediaappimage">MediaApp Image</label>
                    <input type="file" name="mediaappimage" id="mediaappimage" value="<?php echo $mediaAppImage; ?>" required>
                    <label for="platform">Platform</label>
                    <input type="text" name="platform" id="platform" value="<?php echo $platform; ?>">
                    <label for="developer">Developer</label>
                    <input type="text" name="developer" id="developer" value="<?php echo $developer; ?>">
                    <label for="mediaapprating">Rating</label>
                    <select name="mediaapprating" id="mediaapprating">
                        <option value="<?php echo $rating ?>"><?php echo $rating ?></option>
                        <option value="1">Acceptable</option>
                        <option value="2">Good</option>
                        <option value="3">Very Good</option>
                        <option value="4">Excellent</option>
                    </select>
                    <label for="technique">Technique</label>
                    <textarea name="technique" id="technique" cols="30" rows="3"><?php echo $technique; ?></textarea>
                    <label for="mediaappstatus">Status</label>
                    <select name="techniquestatus" id="techniquestatus">
                        <option value="<?php echo $techniqueStatus ?>"><?php echo $techniqueStatus ?></option>
                        <option value="1">Old</option>
                        <option value="2">Latest</option>
                    </select>
                    <input type="submit" name="update" value="Update">
                </form>
            </section>
        </div>
    </div>
</body>

</html>