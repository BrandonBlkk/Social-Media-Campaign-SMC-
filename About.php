<?php
session_start();
include("dbconnection.php");

// Update member profile
if (isset($_POST["save"])) {
    $memberusername = $_POST["username"];
    $memberfirstname = $_POST["firstname"];
    $membersurname = $_POST["surname"];
    $memberphoneno = $_POST["phoneno"];
    // Session passes from member login
    $memberEmail = $_SESSION["MemberEmail"];

    $query = "SELECT * FROM membertb 
        WHERE MemberEmail = '$memberEmail'";

    $selectQuery = mysqli_query($connect, $query);
    $count = mysqli_num_rows($selectQuery);

    for ($i = 0; $i < $count; $i++) {
        $array = mysqli_fetch_array($selectQuery);
        $memberid = $array['MemberID'];

        // Customer image update 
        $memberUpdateProfile = $_FILES["memberprofile"]["name"];
        $copyFile = "MemberImage/";
        $updateProfile = $copyFile . uniqid() . "_" . $memberUpdateProfile;
        $copy = copy($_FILES["memberprofile"]["tmp_name"], $updateProfile);

        $update = "UPDATE membertb SET UserName = '$memberusername', FirstName = '$memberfirstname', SurName = '$membersurname', MemberPhoneNo = '$memberphoneno', MemberProfile = '$updateProfile'
        WHERE MemberID = '$memberid'";

        $updatequery = mysqli_query($connect, $update);

        if ($updatequery) {
            echo "<script>window.alert('Profile is updated.')</script>";
            echo "<script>window.location = 'About.php'</script>";
        } else {
            echo "<script>window.alert('Something went worng.')</script>";
            echo "<script>window.location = 'About.php'</script>";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="MemberStyle.css">
</head>

<body>
    <header>
        <nav>
            <div class="nav-title">
                <h1>SMC</h1>
                <p>Social Media Campaigns</p>
            </div>
            <div class="nav">
                <input type="checkbox" id="ham">
                <label for="ham"><i class="fa-solid fa-bars"></i></label>
                <div class="overlay2"></div>

                <ul id="hamitems">
                    <div class="nav-close-container">
                        <input type="checkbox" id="ham">
                        <label for="ham"><i class="fa-solid fa-xmark"></i></label>
                    </div>
                    <li class="nav-links"><a href="MemberHome.php">Home</a>
                        <p class="line"></p>
                    </li>
                    <li class="nav-links"><a href="Information.php">Information</a>
                        <p class="line"></p>
                    </li>
                    <li class="nav-links"><a href="SocialApps.php">Social Apps</a>
                        <p class="line"></p>
                    </li>
                    <li class="nav-links"><a href="ParentalSupport.php">Parental Support</a>
                        <p class="line"></p>
                    </li>
                    <li class="nav-links"><a href="LiveStreaming.php">Live Streaming</a>
                        <p class="line"></p>
                    </li>
                    <li class="nav-links"><a href="LegislationAndGuidance.php">Legislation/Guidance</a>
                        <p class="line"></p>
                    </li>
                    <li class="nav-links">
                        <a href="#">Company<i class="fa fa-chevron-right" id="arrow"></i></a>
                        <p class="line"></p>
                        <ul class="dropdown">
                            <li class="dropdown-links"><a href="About.php">About Us</a></li>
                            <li class="dropdown-links"><a href="Contact.php">Contact Us</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="button">
                <a href="#search" id="search-btn"><i class="fa-solid fa-magnifying-glass"></i></a>

                <!-- Condition to display login member profile -->
                <?php

                if (!isset($_SESSION["MemberUserName"])) {
                    echo
                    "<div class='member-profile default'>
                        <img src='MemberImage/blank-avatar-photo-place-holder-600nw-1095249842.webp' alt='Profile Image'>
                    </div>";
                } else {
                    // Session passes from member login
                    $memberEmail = $_SESSION["MemberEmail"];
                    $memberUserName = $_SESSION["MemberUserName"];

                    $memberSelect = "SELECT * FROM membertb
                        WHERE MemberEmail = '$memberEmail'";

                    $selectQuery = mysqli_query($connect, $memberSelect);
                    $count = mysqli_num_rows($selectQuery);

                    for ($i = 0; $i < $count; $i++) {
                        $array = mysqli_fetch_array($selectQuery);
                        $memberusername = $array['UserName'];
                        $memberfirstname = $array['FirstName'];
                        $membersurname = $array['SurName'];
                        $memberphoneno = $array['MemberPhoneNo'];
                        $memberprofile = $array['MemberProfile'];
                        // $memberEmail = $_SESSION["MemberEmail"];
                        // $memberUserName = $_SESSION["MemberUserName"];

                        echo
                        "<a href='#popup'>
                        <div class='member-profile'>
                            <img src='$memberprofile'>
                        </div>
                    </a>";
                    }
                }
                ?>
                <?php
                if (!isset($_SESSION["MemberEmail"])) {
                    echo '<div class="signin-button">
                    <div class="signin-btn">
                        <a href="MemberSignUp.php">
                            SignUp
                        </a>
                    </div>
                </div>';
                } else {
                    //pass
                }
                ?>
            </div>
            <div class='profile-feacture' id='popup'>
                <a class="profile-feacture-close" href="#"><i class="fa-solid fa-xmark"></i></a>
                <div class="feacuture-box-container">
                    <div class="feacture-box user-profile-box">
                        <div class="user-profile">
                            <img src="<?php echo $memberprofile ?>" alt="Member Profile">
                        </div>
                        <div class="feacture-box-user-info">
                            <p><strong><?php echo $memberusername ?></strong></p>
                            <p class="email"><?php echo $memberEmail ?></p>
                        </div>
                    </div>
                    <div class="feacture-box">
                        <i class="fa-regular fa-user"></i>
                        <a href='#profile-edit'>Profile Edit</a>
                    </div>
                    <div class='feacture-box'>
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <a href='MemberSignUp.php'>Sign Up</a>
                    </div>
                    <div class='feacture-box'>
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <a href='MemberSignOut.php'>Sign Out</a>
                    </div>
                </div>
            </div>

            <div class="input-box" id="search">
                <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
                <input type="search" name="membersearch" placeholder="Enter anything here...">
            </div>
            <div class="profile-edit-container" id="profile-edit">
                <div class="profile-edit-title">
                    <h1>Edit Profile</h1>
                </div>
                <div class="profile-edit-img">
                    <img src="<?php echo $memberprofile ?>" alt="Profile Image">
                </div>
                <div class="overlay"></div>
                <div class="overlay1"></div>
                <div class="profile-close">
                    <a href="#"><i class="fa-solid fa-xmark"></i></a>
                </div>
                <div class="profile-info">
                    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                        <div class="flex-column">
                            <label for="username">Username </label>
                        </div>
                        <div class="pf-input">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" class="input" name="username" id="username" value="<?php echo $memberusername ?>">
                        </div>
                        <div class="flex-column">
                            <label for="firstname">First Name </label>
                        </div>
                        <div class="pf-input">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" class="input" name="firstname" id="firstname" value="<?php echo $memberfirstname ?>">
                        </div>
                        <div class="flex-column">
                            <label for="surname">SurName </label>
                        </div>
                        <div class="pf-input">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" class="input" name="surname" id="surname" value="<?php echo $membersurname ?>">
                        </div>
                        <div class="flex-column">
                            <label for="phoneno">Phone No</label>
                        </div>
                        <div class="pf-input">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" class="input" name="phoneno" id="phoneno" value="<?php echo $memberphoneno ?>">
                        </div>
                        <div class="flex-column">
                            <label for="memberprofile">Profile </label>
                        </div>
                        <div class="pf-input">
                            <i class="fa-solid fa-user"></i>
                            <input type="file" class="input" name="memberprofile" id="memberprofile" required>
                        </div>
                        <input type="submit" name="save" value="Save">
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <section class="about-container">
        <div class="header-box">
            <div class="header-title">
                <h1>Who are we?</h1>
                <p>We are Social Media Campaigns Ltd. (SMC), dedicated to empowering teenagers with knowledge and resources to navigate social media safely. Join us to access informative content and sign up for our monthly newsletter!</p>
            </div>
            <div class="about-img">
                <img src="MemberImage/teamwork-vector-free-flat-illustration.jpg" alt="About Image">
            </div>
            <p id="p">Our aim to provie accessible affordable services to everybody who needs it.</p>
        </div>
        <div class="we-do-box">
            <div class="header-title">
                <h1>What we do?</h1>
                <p>At Social Media Campaigns Ltd., we empower teenagers to navigate social media safely through informative resources and engaging content, fostering a secure online environment while offering a monthly newsletter subscription.</p>
            </div>
        </div>
        <div class="team-box about-color">
            <div class="header-title">
                <h1>Our Team</h1>
                <p>Our dedicated team at Social Media Campaigns Ltd. is committed to empowering teenagers with the knowledge and resources they need to navigate social media safely and confidently.</p>
            </div>
            <div class="team-img">
                <img src="MemberImage/illustration-concept-with-business-people_23-2148452992.avif" alt="About Image">
            </div>
        </div>
    </section>

    <footer>
        <div class="footer">
            <div class="footer-logo">
                <h2>SMC</h2>
                <p>Social Media Campaigns</p>
                <span>You are here (About) </span>
            </div>
            <div class="footer-link">
                <a href="#">COMMUNITY FORM</a>
                <a href="LiveStreaming.php">SAFETY TIPS</a>
                <a href="#">REPORT ABUSE</a>
            </div>
            <div class="footer-link">
                <a href="#">SERVICES</a>
                <a href="ParentalSupport.php">PARENTAL GUIDANCE</a>
                <a href="RssFeed.php">Rss Feeds</a>
            </div>
            <div class="footer-link">
                <a href="#">SUPPORT</a>
                <a href="PrivacyPolicy.php">PRIVACY POLICY</a>
                <a href="#">FAQS</a>
            </div>
            <div class="footer-link">
                <a href="About.php">ABOUT</a>
                <a href="Contact.php">CONTACT</a>
                <a href="#">RESOURCES</a>
            </div>
            <div id="google_translate_element"></div>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElement"></script>

            <script type="text/javascript">
                function googleTranslateElement() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en'
                    }, 'google_translate_element');
                }
            </script>
        </div>
        <p class="links">
            <a href="#" target="_blank" title="Go to Facebook"><img src="MemberImage/facebook (1).png" alt="Facebook"></a>
            <a href="#" target="_blank" title="Go to Instagram"><img src="MemberImage/instagram.png" alt="Instragram"></a>
            <a href="#" target="_blank" title="Go to X"><img src="MemberImage/twitter.png" alt="X"></a>
            <a href="#" target="_blank" title="Go to Linkedin"><img src="MemberImage/linkedin.png" alt="Linkedin"></a>
            <a href="#" target="_blank" title="Go to Youtube"><img src="MemberImage/youtube.png" alt="Youtube"></a>
        </p>
        <p class="copyright">&copy; 2024 Social Media Campaigns Ltd. All rights reserved.</p>
    </footer>

    <script>
        // Javascript for change header bg color when scroll down 
        document.addEventListener('DOMContentLoaded', function() {
            const changebackColor = document.querySelector('header nav');

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 100) {
                    changebackColor.style.backgroundColor = '#d9e7f1';
                } else {
                    changebackColor.style.backgroundColor = 'white';
                }
            });
        });
        // Javascript for change search-btn color when scroll down 
        document.addEventListener('DOMContentLoaded', function() {
            const changeColor = document.querySelector('#search-btn');

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 100) {
                    changeColor.style.backgroundColor = 'white';
                } else {
                    changeColor.style.backgroundColor = ' rgb(227, 227, 227)';
                }
            });
        });
    </script>
</body>

</html>