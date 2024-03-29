<?php
session_start();
include("dbconnection.php");

if (!isset($_SESSION["AdminID"])) {
    echo "<script>window.alert('Login first! You cannot directly access.')</script>";
    echo "<script>window.location = 'AdminLogIn.php'</script>";
}

if (isset($_POST["add"])) {
    $mediaAppName = $_POST["mediaappname"];
    $platform = $_POST["platform"];
    $developer = $_POST["developer"];
    $rating = $_POST["mediaapprating"];
    $technique = $_POST["mediatechnique"];
    $techniqueStatus = $_POST["mediaappstatus"];

    // image upload 

    $image = $_FILES['mediaappimage']['name'];
    $copyFile = "AdminImage/";
    $fileName = $copyFile . uniqid() . "_" . $image;
    $copy = copy($_FILES['mediaappimage']['tmp_name'], $fileName);

    if (!$copy) {
        echo "<p>Cannot upload Image.</p>";
        exit();
    }
    $mediaAppInsert = "INSERT INTO mediaapptb(MediaAppName, MediaAppImage, Rating, Platform, Developer, Technique, TechniqueStatus)
        VALUES('$mediaAppName', '$fileName', '$rating', '$platform', '$developer', '$technique', '$techniqueStatus')";
    $mediaAppInsertQuery = mysqli_query($connect, $mediaAppInsert);

    if ($mediaAppInsertQuery) {
        echo "<script>window.alert('MediaApp has been successfully added.')</script>";
        echo "<script>window.location = 'AddMediaApp.php'</script>";
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
            <li class="hover">
                <a href="AddCampaignType.php">
                    <i class="fa-solid fa-campground"></i>
                    <span>Add CampaignType</span>
                </a>
            </li>
            <li class="active">
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
                <form class="mediaapp-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                    <h2>Add Medai App</h2>
                    <label for="mediaappname">Media App Name</label>
                    <input type="text" name="mediaappname" id="mediaappname" placeholder="Enter Media App Name" required>
                    <label for="mediaappimage">Media App Image</label>
                    <input type="file" name="mediaappimage" id="mediaappimage" required>
                    <label for="platform">Platform</label>
                    <input type="text" name="platform" id="platform" placeholder="Enter Platform" required>
                    <label for="developer">Developer</label>
                    <input type="text" name="developer" id="developer" placeholder="Enter Developer Name" required>
                    <label for="mediaapprating">Rating</label>
                    <select name="mediaapprating" id="mediaapprating">
                        <option value="1">Bad</option>
                        <option value="2">Acceptable</option>
                        <option value="3">Good</option>
                        <option value="4">Very Good</option>
                        <option value="5">Excellent</option>
                    </select>
                    <label for="mediatechnique">Technique</label>
                    <textarea name="mediatechnique" id="mediatechnique" cols="30" rows="3" placeholder="Enter Text Here..."></textarea>
                    <label for="mediaappstatus">Status</label>
                    <select name="mediaappstatus" id="mediaappstatus">
                        <option value="1">Old</option>
                        <option value="2">Latest</option>
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
</body>

</html>