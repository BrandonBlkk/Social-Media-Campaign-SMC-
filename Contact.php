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
            echo "<script>window.location = 'Contact.php'</script>";
        } else {
            echo "<script>window.alert('Something went worng.')</script>";
            echo "<script>window.location = 'Contact.php'</script>";
        }
    }
}
if (isset($_POST["sent"])) {
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    $insert = "INSERT INTO contacttb(ContactEmail, MemberPhone, MemberMessage)
    VALUES('$email', '$phone', '$message')";

    $insertQuery = mysqli_query($connect, $insert);

    if ($insertQuery) {
        echo "<script>window.alert('Your message has been sent.')</script>";
        echo "<script>window.location = 'Contact.php'</script>";
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
                    //do something.
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

    <div class="contact-form-container">
        <div class="contact-img">
            <img src="MemberImage/Contact-Us-Vector-Illustration-Part-02-1.jpg" alt="Contact">
            <div class="contact-detail">
                <div>
                    <i class="fa-solid fa-location-dot"></i>
                    <p>(124)st, armhatay, Yangon, Myanmar</p>
                </div>
                <div>
                    <i class="fa-solid fa-phone"></i>
                    <p>09-772-217-900</p>
                </div>
                <div>
                    <i class="fa-solid fa-envelope"></i>
                    <p>SocialmediaCamp@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="contact-main-form">
            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
                <label for="phone">Phone No</label>
                <input type="tel" name="phone" id="phone" placeholder="09-000-000-000" required>
                <label for="message">Message</label>
                <textarea name="message" id="message" cols="30" rows="10" placeholder="Enter your message..." required></textarea>
                <div class="policy">
                    <input type="checkbox" name="checkbox" required>
                    <p>I agree to the <a href="PrivacyPolicy.php">Privacy Policy</a></p>
                </div>

                <div class="input">
                    <input type="submit" name="sent" value="Sent">
                    <div class="form-link">
                        <a href="#" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-github"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="faq">
        <h1>Frequently Asked Questions</h1>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>How can I protect my personal information on social media?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>You can protect your personal information by setting strict privacy settings, being cautious about what you share, and avoiding posting sensitive details like your address or phone number.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>What should I do if I receive a message from someone I don't know?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>If you receive a message from a stranger, it's best to ignore it and not respond. You can also block the user and report the message to the platform's administrators.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>Is it safe to meet someone in person that I met online?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>Meeting someone in person whom you met online can be risky. Always ensure you meet in a public place, inform a trusted adult about your plans, and consider bringing a friend along.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>How do I recognize and avoid online scams?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>Be wary of suspicious links or requests for personal information. If something seems too good to be true, it probably is. Trust your instincts and research the legitimacy of offers before engaging with them.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>What should I do if I encounter cyberbullying?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>Don't retaliate. Instead, block the bully, report the incident to the platform, and talk to a trusted adult or counselor about what happened. Remember, you're not alone, and there are resources available to help.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>How do I know if a website or app is safe to use?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>Look for secure connections (https://), read reviews from reputable sources, and check for a privacy policy and terms of service. Avoid downloading apps or visiting websites from untrusted sources.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>What should I do if someone is pressuring me to share inappropriate photos or information?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>Never give in to pressure. Trust your instincts and say no. If you feel uncomfortable or threatened, talk to a trusted adult immediately.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>How can I maintain a healthy balance between social media and real life?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>Set limits on your screen time, engage in offline activities, and prioritize face-to-face interactions with friends and family. Remember, it's important to find a balance that works for you.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>Can someone track my location through social media?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>Yes, some social media platforms have location tracking features. Be mindful of what information you share and consider disabling location services for apps that don't require it.</p>
            </div>
        </div>
        <div class="fqa-question-box">
            <button class="faq-question" id="question2"><b>What resources are available if I need help with online safety or mental health issues?</b><i class="fa-solid fa-plus"></i></button>
            <div class="faq-answer" id="answer2">
                <p>There are numerous resources available, including helplines, support groups, and online forums dedicated to online safety and mental health. Organizations such as SMC Ltd. may also offer guidance and support through their website and outreach programs. Don't hesitate to reach out for help if you need it.</p>
            </div>
        </div>
    </div>

    <script>
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach((question) => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const isOpen = answer.style.display === 'block';

                if (isOpen) {
                    answer.style.display = 'none';
                } else {
                    answer.style.display = 'block';
                }
            });
        });
    </script>

    <footer>
        <div class="footer">
            <div class="footer-logo">
                <h2>SMC</h2>
                <p>Social Media Campaigns</p>
                <span>You are here (Contact) </span>
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