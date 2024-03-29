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
            echo "<script>window.location = 'LiveStreaming.php'</script>";
        } else {
            echo "<script>window.alert('Something went worng.')</script>";
            echo "<script>window.location = 'LiveStreaming.php'</script>";
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
    <link href="https://fonts.googleapis.com/css2?family=Protest+Riot&display=swap" rel="stylesheet">
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
                    <li class="nav-links"><a href="LiveStreaming.php" class="active">Live Streaming</a>
                        <p class="line line-active"></p>
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
                        $memberEmail = $_SESSION["MemberEmail"];
                        $memberUserName = $_SESSION["MemberUserName"];

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

    <div class="scroll-up">
        <a href="#"><i class="fa-solid fa-angle-up"></i></a>
    </div>

    <section class="main-content">
        <aside class="left-slide-container">
            <div class="table-content">
                <div class="form">
                    <h1>Content Outline Category:</h1>
                    <a href="#1">Staying Safe While Sharing Your World Online</a>
                    <a href="#2">What is Livestreaming?</a>
                    <a href="#3">Pros</a>
                    <a href="#4">Cons</a>
                    <a href="#5">Tips for Livestreaming Safely</a>
                    <a href="#6">Discover the Best Locations</a>
                </div>
            </div>
        </aside>
        <div class="right-slide-container">
            <div class="main-img live-main-img">
                <img id="1" src="MemberImage/live_streaming-1024x536.jpg" alt="Live Streaming">
            </div>
            <h3>Safe Livestreaming:</h3>
            <h1>Staying Safe While Sharing Your World Online</h1>
            <p id="2">In today's digital age, livestreaming has become an increasingly popular way for individuals to connect, share, and express themselves online. From gaming sessions to personal vlogs, livestreaming offers a dynamic platform for interaction and creativity. However, it's important for teenagers to understand the potential risks involved and how to navigate them safely.</p>

            <h3>Understanding Livestreaming:</h3>
            <h1>What is Livestreaming?</h1>
            <ul>
                <li>Livestreaming refers to broadcasting live video content over the internet in real-time.</li>
                <li>It allows users to broadcast themselves live to an audience, who can watch and engage with the content in real-time.</li>
                <li id="3">Platforms like Twitch, YouTube, and Instagram Live have made livestreaming accessible to millions of users worldwide.</li>
            </ul>

            <h3>Benifits Associated with Livestreaming:</h3>
            <h1 id="pros">Pros</h1>
            <ul>
                <li><b>Instant Interaction: </b>Livestreaming enables direct interaction between content creators and their audience in real-time. Viewers can ask questions, leave comments, and participate in discussions, fostering a sense of community and connection.</li>
                <li><b>Creativity and Expression: </b>Livestreaming provides a platform for individuals to showcase their talents, share their experiences, and express themselves creatively. Whether it's through music, gaming, or storytelling, livestreaming allows for diverse forms of content creation.</li>
                <li><b>Educational Opportunities: </b>Livestreaming isn't just about entertainment; it can also be educational. From tutorial videos to live workshops, livestreams offer valuable learning experiences on a wide range of topics.</li>
                <li><b>Know Your Rights:</b> Familiarize yourself with the terms of service for the platform you're using and understand your rights as a content creator. Report any violations or abuse of these terms to the platform administrators.</li>
            </ul>

            <div class="pros-cons-img">
                <div class="pros-cons-img-row">
                    <img src="MemberImage/0_HRSXg6KaCmM9tto8.jpg" alt="Image">
                    <img src="MemberImage/online-3412473_1920.webp" alt="Image">
                    <img src="MemberImage/TalkPal-illustrations-of-languiage-learning-45.webp" alt="Image">
                    <img id="4" src="MemberImage/Human_rights_1024x512.jpg" alt="Image">
                </div>
            </div>

            <h3>Risks Associated with Livestreaming:</h3>
            <h1 id="cons">Cons</h1>
            <ul>
                <li><b>Privacy Concerns: </b>Livestreaming involves broadcasting content to a potentially large and unknown audience. This raises concerns about privacy, as personal information and locations may inadvertently be revealed during broadcasts.</li>
                <li><b>Online Predators: </b>Livestreaming platforms can attract unwanted attention from online predators who may attempt to exploit or manipulate young users. It's important for teenagers to be cautious when interacting with strangers online and to avoid sharing personal information.</li>
                <li><b>Cyberbullying: </b>Livestreaming opens users up to the risk of cyberbullying and harassment from viewers. Negative comments and trolling behavior can have a detrimental impact on mental health and wellbeing.</li>
            </ul>

            <div class="pros-cons-img">
                <div class="pros-cons-img-row">
                    <img src="MemberImage/How-to-Protect-Your-Privacy-on-Social-Media.png" alt="Image">
                    <img src="MemberImage/StaySafeFromPredators_IntroImage.png" alt="Image">
                    <img id="5" src="MemberImage/cyber-bullying.jpeg" alt="Image">
                </div>
            </div>

            <h1>What are the Tips for Livestreaming Safely?</h1>
            <p>Each of these issues contributes to lack of efficiency and potential loss of income if customers must wait for a data outage to be corrected. Additionally, when it comes to data storage, small businesses find themselves faced with other storage-related needs such as:</p>
            <ul>
                <li><b>Protect Your Privacy: </b>Be mindful of what you share during livestreams. Avoid disclosing personal information such as your full name, address, or phone number. Use privacy settings to control who can view your streams.</p>
                </li>
                <li><b>Set Boundaries: </b>Establish clear boundaries for yourself regarding the type of content you're comfortable sharing online. Don't feel pressured to broadcast anything that makes you feel uncomfortable or vulnerable.</li>
                <li><b>Monitor Comments and Interactions: </b>Keep an eye on the comments and interactions during your livestreams. Block or report any users who engage in inappropriate behavior or harassment.</p>
                </li>
                <li><b>Stay Vigilant: </b>Be wary of strangers who try to engage with you during livestreams. If something feels off or suspicious, trust your instincts and end the broadcast if necessary.</p>
                </li>
                <li><b>Seek Support: </b>Don't hesitate to reach out for support if you encounter any negative experiences or challenges while livestreaming. Talk to a trusted adult, friend, or counselor for guidance and assistance.</p>
                </li>
            </ul>

            <div class="pros-cons-img">
                <div class="pros-cons-img-row">
                    <img src="MemberImage/mobile_security_endpoint_protection_thinkstock_669282050-100750728-large.webp" alt="Image">
                    <img src="MemberImage/setting-boundaries3.png" alt="Image">
                    <img src="MemberImage/social media monitoring.png" alt="Image">
                    <img src="MemberImage/ofca_500x300b.png" alt="Image">
                    <img src="MemberImage/seek-help.jpg" id="6" alt="Image">
                </div>
            </div>

            <h1>Discover the Best Locations for Seamless Live Streaming</h1>
            <p>In the modern era, live streaming has become an essential component of our internet experience. Whether you're a content creator, a business professional, or just someone who enjoys sharing moments with friends and family, selecting the proper live streaming venue is essential. Here, we investigate the top real-world locations suitable for flawless live streaming.</p>
            <ul>
                <li><b id="main">Urban Hotspots:</b>Explore bustling cityscapes with reliable Wi-Fi connections and vibrant backgrounds that add energy to your streams.</li>
                <li><b id="main">Scenic Nature Retreats:</b>Escape to serene natural settings, from lush forests to tranquil beaches, offering breathtaking backdrops for captivating live streams.</li>
                <li><b id="main">Cozy Cafés and Coffee Shops:</b>Discover quaint cafes with cozy atmospheres and reliable internet connections, perfect for intimate live streams and virtual hangouts.</li>
                <li><b id="main">Professional Studios:</b>For high-quality broadcasts, consider renting professional studio space equipped with top-tier equipment and technical support.</li>
                <li><b id="main">Cultural Landmarks:</b>Showcase your streams against iconic landmarks and historical sites, adding depth and context to your content.</li>
            </ul>
        </div>
    </section>

    <section class="youtube" id="youtube">
        <div class="youtube-main-content">
            <iframe src="https://www.youtube.com//embed/HC-tgFdIcB0"></iframe>
        </div>
    </section>

    <footer>
        <div class="footer">
            <div class="footer-logo">
                <h2>SMC</h2>
                <p>Social Media Campaigns</p>
                <span>You are here (Live Streaming) </span>
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
        // Javascript for display scroll-up when scroll down 
        document.addEventListener('DOMContentLoaded', function() {
            const scrollUpButton = document.querySelector('.scroll-up');

            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 100) {
                    scrollUpButton.style.display = 'flex';
                    scrollUpButton.style.transition = 'opacity 0.3s ease-in-out';
                    scrollUpButton.style.opacity = '1';
                } else {
                    scrollUpButton.style.opacity = '0';
                }
            });
        });
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