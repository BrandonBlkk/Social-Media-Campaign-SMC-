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
            echo "<script>window.location = 'LegislationAndGuidance.php'</script>";
        } else {
            echo "<script>window.alert('Something went worng.')</script>";
            echo "<script>window.location = 'LegislationAndGuidance.php'</script>";
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
                    <li class="nav-links"><a href="LiveStreaming.php">Live Streaming</a>
                        <p class="line"></p>
                    </li>
                    <li class="nav-links"><a href="LegislationAndGuidance.php" class="active">Legislation/Guidance</a>
                        <p class="line line-active"></p>
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

    <section class="main-header">
        <div class="text">
            <h1>A Guide to Social Media and Privacy</h1>
            <h2>Everything you need to know, all in one place</h2>
        </div>
        <div class="main-header-img">
            <img src="MemberImage/LOM-general-service-pages-V4-UP_03.png" alt="Main Image">
        </div>
    </section>

    <div class="scroll-up">
        <a href="#"><i class="fa-solid fa-angle-up"></i></a>
    </div>

    <section class="main-content" id="guidance-main-content">
        <aside class="left-slide-container">
            <div class="table-content">
                <div class="form">
                    <h1>Content Outline Category:</h1>
                    <a href="#1">Protecting Personal Information</a>
                    <a href="#2">Cyberbullying Prevention Strategies</a>
                    <a href="#3">Age Restrictions</a>
                    <a href="#4">Content Regulation</a>
                    <a href="#5">Online Privacy and Security</a>
                    <a href="#6">Digital Citizenship</a>
                    <a href="#7">Parental Involvement and Supervision</a>
                    <a href="#8">Reporting Mechanisms</a>
                </div>
            </div>
        </aside>
        <div class="right-slide-container">
            <h3>Overall Explaination:</h3>
            <h1>Understanding Social Media Legislation and Guidance</h1>
            <div class="guidance-img">
                <img src="MemberImage/social-media-policy-for-employees-1200x630.png" alt="Live Streaming">
            </div>
            <p id="1">In today's digital age, social media has become an integral part of our lives, especially for teenagers. While these platforms offer numerous benefits, it's crucial to understand the legislation and guidance governing their usage to ensure safety and responsible behavior online.</p>

            <h3>Protecting Personal Information:</h3>
            <ul>
                <h1>Guarding Your Privacy</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Legislation such as the General Data Protection Regulation (GDPR) aims to safeguard individuals' personal data on social media platforms.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p id="2">It's essential for teenagers to be aware of their privacy settings and understand how their information is collected, stored, and shared by social media companies.</p>
                </div>
            </ul>

            <h3>Cyberbullying Prevention Strategies:</h3>
            <ul>
                <h1>Fostering Positive Online Interactions</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Laws like the Cyberbullying Prevention Act enforce consequences for online harassment and bullying behavior.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p id="3">Teenagers should know how to report instances of cyberbullying to the platform administrators and seek support from trusted adults or organizations like ours.</p>
                </div>
            </ul>

            <h3>Age Restrictions</h3>
            <ul>
                <h1>Limiting Youth Access</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Most social media platforms have age restrictions, typically requiring users to be at least 13 years old.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p id="4">Educating teenagers about the importance of adhering to these age limits helps them understand the risks associated with underage usage, such as exposure to inappropriate content or online predators.</p>
                </div>
            </ul>

            <h3>Content Regulation:</h3>
            <ul>
                <h1>Balancing Free Expression Safely</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Legislation like the Communications Decency Act and community guidelines set by social media platforms regulate the type of content users can post.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p id="5">Teenagers should familiarize themselves with these regulations to avoid sharing or accessing harmful or illegal content that could lead to legal consequences.</p>
                </div>
            </ul>

            <h3>Online Privacy and Security:</h3>
            <ul>
                <h1>Digital Fortification</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Guidance on creating strong passwords, avoiding phishing scams, and recognizing fake accounts helps teenagers protect themselves from identity theft and online fraud.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p id="6">Encouraging the use of privacy-enhancing tools and practicing digital hygiene habits can mitigate the risk of cyber threats and unauthorized access to personal information.</p>
                </div>
            </ul>

            <h3>Digital Citizenship:</h3>
            <ul>
                <h1>Online Etiquette and Responsibility</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Promoting digital citizenship empowers teenagers to navigate social media responsibly, treating others with respect and empathy.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p id="7">Providing resources on online etiquette, critical thinking, and media literacy equips teenagers with the skills to evaluate and respond to information encountered on social media platforms.</p>
                </div>
            </ul>

            <h3>Parental Involvement and Supervision:</h3>
            <ul>
                <h1>Guiding Parenthood</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Encouraging open communication between teenagers and their parents or guardians fosters a supportive environment for discussing social media usage.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p id="8">Educating parents about the risks and benefits of social media helps them guide their teenagers' online behavior and implement appropriate monitoring strategies.</p>
                </div>
            </ul>

            <h3>Reporting Mechanisms:</h3>
            <ul>
                <h1>Mechanisms of Reporting Excellence</h1>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Informing teenagers about reporting mechanisms for inappropriate content, cyberbullying, or suspicious activities empowers them to take action to protect themselves and others.</p>
                </div>
                <div class="icon">
                    <img src="MemberImage/arrow.png" alt="Image">
                    <p>Advocating for the improvement of reporting systems and swift response from social media platforms promotes a safer online environment for all users.</p>
                </div>
            </ul>
        </div>
    </section>

    <section class="main-content" id="social-main-content">
        <div class="right-slide-container" id="social-slide-container">
            <div class="social-img">
                <img src="MemberImage/Broadcast-Channels-on-FB-MSGR_Header.webp" alt="Facebook">
                <div class="social-img-text">
                    <h1>Facebook</h1>
                    <h1 id="blue">All You Need To Know About</h1>
                </div>
            </div>
            <h3>Legislation and Guidance for Facebook</h3>
            <h2>Introduction</h2>
            <p>Facebook, being a major social media platform, is subject to various legislation and guidance that govern its operations and user interactions. Here's a brief overview:</p>

            <h2 class="h2">Key Legislation</h2>
            <ul>
                <li><strong>General Data Protection Regulation (GDPR):</strong> Facebook must comply with GDPR, which governs the handling and processing of personal data of European Union residents.</li>
                <li><strong>Communications Decency Act:</strong> This US legislation provides certain protections to online platforms like Facebook from liability for user-generated content, but also outlines obligations regarding moderation of harmful content.</li>
                <li><strong>Children's Online Privacy Protection Act (COPPA):</strong> Facebook must comply with COPPA regulations to protect the privacy of children under 13 years old.</li>
            </ul>

            <h2 class="h2">Facebook Guidelines</h2>
            <ul>
                <li><strong>Community Standards:</strong> Facebook has established Community Standards that outline what is and isn't allowed on the platform, including hate speech, violence, nudity, and other types of content.</li>
                <li><strong>Advertising Policies:</strong> Facebook provides guidelines for advertisers to ensure their ads comply with legal requirements and community standards.</li>
                <li><strong>Privacy Settings:</strong> Facebook offers various privacy settings for users to control who can see their posts, personal information, and activity on the platform.</li>
            </ul>

            <div class="social-img">
                <img src="MemberImage/IG-Messaging-Stories-Bundle_Header.webp" alt="Instagram">
                <div class="social-img-text">
                    <h1>Instagram</h1>
                    <h1 id="rose">All You Need To Know About</h1>
                </div>
            </div>
            <h3>Legislation and Guidance on Instagram:</h3>
            <h2>Introduction</h2>
            <p>Instagram is a popular social media platform used by millions of people worldwide. However, users need to be aware of certain legislation and guidance to ensure they use the platform responsibly and lawfully.</p>

            <h2 class="h2">Key Legislation</h2>
            <p>While there isn't specific legislation targeting Instagram, users should be mindful of existing laws that apply to online behavior, such as</p>
            <ul>
                <li>The Children's Online Privacy Protection Act (COPPA)</li>
                <li>The General Data Protection Regulation (GDPR)</li>
                <li>The Federal Trade Commission Act (FTC Act)</li>
            </ul>

            <h2 class="h2">Instagram Guidelines</h2>
            <p>Instagram has its own set of community guidelines that users must adhere to. Some key points include:</p>
            <ul>
                <li>Respect other users</li>
                <li>Avoid posting explicit content</li>
                <li>Do not engage in bullying or harassment</li>
                <li>Respect intellectual property rights</li>
            </ul>

            <h2 class="h2">Privacy Settings</h2>
            <p>Instagram provides various privacy settings that users can adjust to control who can see their posts, send them messages, etc. Users should review and adjust these settings according to their preferences.</p>

            <div class="social-img">
                <img src="MemberImage/1651789513-twitter-spaces.jpg" alt="X(Twitter)">
                <div class="social-img-text">
                    <h1>X(Twitter)</h1>
                    <h1 id="blue">All You Need To Know About</h1>
                </div>
            </div>
            <h3>Legislation and Guidance for X(Twitter)</h3>
            <h2>Introduction</h2>
            <p>When using X(Twitter), it's important to adhere to relevant legislation, which may include:</p>

            <h2 class="h2">Key Legislation</h2>
            <ul>
                <li><strong>Privacy Laws:</strong> Ensure you comply with privacy laws when sharing personal information on X(Twitter).</li>
                <li><strong>Copyright Laws:</strong> Respect copyright laws when sharing content to avoid infringement issues.</li>
                <li><strong>Defamation Laws:</strong> Avoid defamatory statements or content that could harm someone's reputation.</li>
            </ul>

            <h2 class="h2">X(Twitter) Guidelines</h2>
            <p>Twitter provides guidelines to help users understand what is acceptable behavior on the platform. Some key points include:</p>
            <ul>
                <li><strong>X(Twitter) Rules:</strong> Familiarize yourself with X(Twitter)'s official rules to avoid violating them.</li>
                <li><strong>Community Standards:</strong> Respect X(Twitter)'s community standards by avoiding hate speech, harassment, and other harmful behavior.</li>
                <li><strong>Verified Accounts:</strong> Understand the criteria for obtaining a verified account on X(Twitter).</li>
            </ul>
    </section>

    <footer>
        <div class="footer">
            <div class="footer-logo">
                <h2>SMC</h2>
                <p>Social Media Campaigns</p>
                <span>You are here (Legislation/Guidance) </span>
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