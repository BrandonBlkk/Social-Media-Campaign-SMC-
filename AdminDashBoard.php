<?php
session_start();
include("dbconnection.php");

if (!isset($_SESSION["AdminID"])) {
    echo "<script>window.alert('Login first! You cannot direct access the admin info.')</script>";
    echo "<script>window.location = 'AdminLogIn.php'</script>";
}
$AdminuserName = $_SESSION["AdminUserName"];
$adminPosition = $_SESSION["AdminPosition"];
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
        <div class="header-wrapper" id="admin-home">
            <div class="header-title">
                <h2>Dashboard</h2>
                <span>Hello, <?php echo $adminPosition ?> <?php echo $AdminuserName; ?></span>
            </div>
            <div class="user-info">
                <div class="search-bar">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </div>

        <div class="member-wrapper">
            <div class="member-container">
                <div class="member-title">
                    <h1>Total Member</h1>
                    <?php
                    $memberselect = "SELECT * FROM membertb";
                    $selectquery = mysqli_query($connect, $memberselect);
                    $count = mysqli_num_rows($selectquery);
                    echo "<p>$count</p>"
                    ?>
                </div>
                <div class="icon">
                    <span><i class="fa-solid fa-users"></i></span>
                </div>
            </div>
            <div class="member-container">
                <div class="member-title">
                    <h1>Total Campaign</h1>
                    <?php
                    $campaignselect = "SELECT * FROM campaigntb";
                    $selectquery = mysqli_query($connect, $campaignselect);
                    $count = mysqli_num_rows($selectquery);
                    echo "<p>$count</p>"
                    ?>
                </div>
                <div class="icon">
                    <span><i class="fa-solid fa-campground"></i></span>
                </div>
            </div>
            <div class="member-container">
                <div class="member-title">
                    <h1>Total Campaign Type</h1>
                    <?php
                    $campaigntypeselect = "SELECT * FROM campaigntypetb";
                    $selectquery = mysqli_query($connect, $campaigntypeselect);
                    $count = mysqli_num_rows($selectquery);
                    echo "<p>$count</p>"
                    ?>
                </div>
                <div class="icon">
                    <span><i class="fa-solid fa-campground"></i></span>
                </div>
            </div>
            <div class="member-container">
                <div class="member-title">
                    <h1>Total Media App</h1>
                    <?php
                    $mediaappselect = "SELECT * FROM mediaapptb";
                    $selectquery = mysqli_query($connect, $mediaappselect);
                    $count = mysqli_num_rows($selectquery);
                    echo "<p>$count</p>"
                    ?>
                </div>
                <div class="icon">
                    <span><i class="fa-solid fa-users"></i></span>
                </div>
            </div>
        </div>

        <div class="tabular-wrapper">
            <h3 class="main-title">
                Member data
            </h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>MemberID</th>
                            <th>UserName</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Phone</th>
                            <th>SignUp Date</th>
                            <th>SignUp Month</th>
                            <th>Profile</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $memberselect = "SELECT * FROM membertb";
                        $selectquery = mysqli_query($connect, $memberselect);
                        $count = mysqli_num_rows($selectquery);

                        for ($i = 0; $i < $count; $i++) {
                            $array = mysqli_fetch_array($selectquery);
                            $memberID = $array['MemberID'];
                            $userName = $array['UserName'];
                            $firstName = $array['FirstName'];
                            $surName = $array['SurName'];
                            $memberEmail = $array['MemberEmail'];
                            $memberPassword = $array['MemberPassword'];
                            $memberPhoneNo = $array['MemberPhoneNo'];
                            $signUpDate = $array['SignUpDate'];
                            $signUpMonth = $array['SignUpMonth'];
                            $memberProfile = $array['MemberProfile'];
                            $memberStatus = $array['MemberStatus'];

                            echo "<tr>";
                            echo "<td>$memberID</td>";
                            echo "<td>$userName</td>";
                            echo "<td>$firstName</td>";
                            echo "<td>$surName</td>";
                            echo "<td>$memberEmail</td>";
                            echo "<td>$memberPassword</td>";
                            echo "<td>$memberPhoneNo</td>";
                            echo "<td>$signUpDate</td>";
                            echo "<td>$signUpMonth</td>";
                            echo "<td><img src = '$memberProfile'></td>";
                            echo "<td>$memberStatus</td>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tabular-wrapper">
            <h3 class="main-title">
                Campaign data
            </h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>CampaignID</th>
                            <th>MediaAppID</th>
                            <th>CampaignTypeID</th>
                            <th>Campaign Name</th>
                            <th>Campaign Description</th>
                            <th>Campaign Image1</th>
                            <th>Campaign Image2</th>
                            <th>Campaign Image3</th>
                            <th>Campaign Image4</th>
                            <th>Campaign Fees</th>
                            <th>Campaign Location</th>
                            <th>Campaign Start Date</th>
                            <th>Campaign End Date</th>
                            <th>Campaign Aim</th>
                            <th>Campaign Vision</th>
                            <th>Campaign Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $campaignselect = "SELECT * FROM campaigntb cp, campaigntypetb cpt, mediaapptb mp
                            WHERE cp.CampaignTypeID = cpt.CampaignTypeID
                            AND cp.MediaAppID = mp.MediaAppID";
                        $selectquery = mysqli_query($connect, $campaignselect);
                        $count = mysqli_num_rows($selectquery);

                        for ($i = 0; $i < $count; $i++) {
                            $array = mysqli_fetch_array($selectquery);
                            $campaignID = $array['CampaignID'];
                            $mediaappID = $array['MediaAppID'];
                            $campaigntypeID = $array['CampaignTypeID'];
                            $campaignname = $array['CampaignName'];
                            $campaigndescription = $array['CampaignDescription'];
                            $campaignimage1 = $array['CampaignImage1'];
                            $campaignimage2 = $array['CampaignImage2'];
                            $campaignimage3 = $array['CampaignImage3'];
                            $campaignimage4 = $array['CampaignImage4'];
                            $campaignfees = $array['CampaignFees'];
                            $campaignlocation = $array['CampaignLocation'];
                            $campaignstartdate = $array['CampaignStartDate'];
                            $campaignenddate = $array['CampaignEndDate'];
                            $campaignaim = $array['CampaignAim'];
                            $campaignvision = $array['CampaignVision'];
                            $campaignstatus = $array['CampaignStatus'];

                            echo "<tr>";
                            echo "<td>$campaignID</td>";
                            echo "<td>$mediaappID</td>";
                            echo "<td>$campaigntypeID</td>";
                            echo "<td>$campaignname</td>";
                            echo "<td>$campaigndescription</td>";
                            echo "<td><img src = '$campaignimage1'></td>";
                            echo "<td><img src = '$campaignimage2'></td>";
                            echo "<td><img src = '$campaignimage3'></td>";
                            echo "<td><img src = '$campaignimage4'></td>";
                            echo "<td>$campaignfees</td>";
                            echo "<td>
                                    <iframe src='$campaignlocation' style='border:0;' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>
                                </td>";
                            echo "<td>$campaignstartdate</td>";
                            echo "<td>$campaignenddate</td>";
                            echo "<td>$campaignaim</td>";
                            echo "<td>$campaignvision</td>";
                            echo "<td>$campaignstatus</td>";

                            echo "<td> 
                                        <a href= 'CampaignEdit.php?campaignID=$campaignID'>Edit</a>
                                        <span>/</span>
                                        <a href= 'CampaignDelete.php?campaignID=$campaignID'>Delete</a>
                                    </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tabular-wrapper">
            <h3 class="main-title">
                CampaignType data
            </h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>CampaignTypeID</th>
                            <th>CampaignType Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $campaigntypeselect = "SELECT * FROM campaigntypetb";
                        $selectquery = mysqli_query($connect, $campaigntypeselect);
                        $count = mysqli_num_rows($selectquery);

                        for ($i = 0; $i < $count; $i++) {
                            $array = mysqli_fetch_array($selectquery);
                            $campaigntypeID = $array['CampaignTypeID'];
                            $campaigntypename = $array['CampaignTypeName'];

                            echo "<tr>";
                            echo "<td>$campaigntypeID</td>";
                            echo "<td>$campaigntypename</td>";

                            echo "<td> 
                                        <a href= 'CampaignTypeEdit.php?campaigntypeID=$campaigntypeID'>Edit</a>
                                        <span>/</span>
                                        <a href= 'CampaignTypeDelete.php?campaigntypeID=$campaigntypeID'>Delete</a>
                                    </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tabular-wrapper">
            <h3 class="main-title">
                SocialMedia App data
            </h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>MediaAppID</th>
                            <th>MediaApp Name</th>
                            <th>MediaApp Image</th>
                            <th>Rating</th>
                            <th>Platform</th>
                            <th>Developer</th>
                            <th>Technique</th>
                            <th>Technique Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $mediaappselect = "SELECT * FROM mediaapptb";
                        $selectquery = mysqli_query($connect, $mediaappselect);
                        $count = mysqli_num_rows($selectquery);

                        for ($i = 0; $i < $count; $i++) {
                            $array = mysqli_fetch_array($selectquery);
                            $mediaappID = $array['MediaAppID'];
                            $mediaappname = $array['MediaAppName'];
                            $mediaappimage = $array['MediaAppImage'];
                            $rating = $array['Rating'];
                            $platform = $array['Platform'];
                            $developer = $array['Developer'];
                            $technique = $array['Technique'];
                            $techniquestatus = $array['TechniqueStatus'];

                            echo "<tr>";
                            echo "<td>$mediaappID</td>";
                            echo "<td>$mediaappname</td>";
                            echo "<td><img src = '$mediaappimage'></td>";
                            echo "<td>$rating</td>";
                            echo "<td>$platform</td>";
                            echo "<td>$developer</td>";
                            echo "<td>$technique</td>";
                            echo "<td>$techniquestatus</td>";

                            echo "<td> 
                                        <a href= 'MediaAppEdit.php?mediaappID=$mediaappID'>Edit</a>
                                        <span>/</span>
                                        <a href= 'MediaAppDelete.php?mediaappID=$mediaappID'>Delete</a>
                                    </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>