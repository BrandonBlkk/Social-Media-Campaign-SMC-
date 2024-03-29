<?php
session_start();
include("dbconnection.php");

// Adding member comment into database 
if (isset($_POST["submit"])) {
    $memberEmail = $_POST["memberemail"];
    $memberSuggestion = $_POST["membersuggestion"];
    $suggestionDate = $_POST["suggestiondate"];
    // Session passes from member login
    $memberid = $_SESSION["MemberID"];
    $memberEmail = $_SESSION["MemberEmail"];
    $memberUserName = $_SESSION["MemberUserName"];
    $memberProfile = $_SESSION["MemberProfile"];

    $insert = "INSERT INTO parentcommenttb(MemberID, Comment, CommentDate, UserName, MemberEmail, MemberProfile)
        VALUES('$memberid', '$memberSuggestion', '$suggestionDate', '$memberUserName', '$memberEmail', '$memberProfile')";

    $insertQuery = mysqli_query($connect, $insert);

    if ($insertQuery) {
        echo "<script>window.alert('Your comment has been added.')</script>";
        echo "<script>window.location = 'ParentalSupport.php'</script>";
    }
}

// Update member profile
if (isset($_POST["save"])) {
    $memberusername = $_POST["username"];
    $memberfirstname = $_POST["firstname"];
    $membersurname = $_POST["surname"];
    $memberphoneno = $_POST["phoneno"];
    // Session passes from member login
    $memberid = $_SESSION["MemberID"];
    $memberEmail = $_SESSION["MemberEmail"];
    $memberUserName = $_SESSION["MemberUserName"];
    $memberProfile = $_SESSION["MemberProfile"];

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
            echo "<script>window.location = 'ParentalSupport.php'</script>";
        } else {
            echo "<script>window.alert('Something went worng.')</script>";
            echo "<script>window.location = 'ParentalSupport.php'</script>";
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
                    <li class="nav-links"><a href="ParentalSupport.php" class="active">Parental Support</a>
                        <p class="line line-active"></p>
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
                    $memberid = $_SESSION["MemberID"];
                    $memberEmail = $_SESSION["MemberEmail"];
                    $memberUserName = $_SESSION["MemberUserName"];
                    $memberProfile = $_SESSION["MemberProfile"];

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

                        echo "<a href='#popup'>
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

    <section class="main-content" id="1">
        <aside class="left-slide-container">
            <div class="table-content">
                <div class="form">
                    <h1>Content Outline Category:</h1>
                    <a href="#1">Supporting Healthy Teen Use of Social Media</a>
                    <a href="#2">Top Tips for Parents</a>
                    <a href="#3">Important Information</a>
                </div>
            </div>
        </aside>
        <div class="right-slide-container">
            <h3 id="parent-h3">How Parents Can Help: </h3>
            <h1>Supporting Healthy Teen Use of Social Media</h1>
            <div class="main-img" id="parent-main-img">
                <img src="MemberImage/16-reasons-why-social-media-is-important-to-your-company-616d3200e6dc6-sej.webp" alt="Live Streaming">
            </div>
            <p id="2">In today's digital age, social media plays a significant role in the lives of teenagers. While it offers opportunities for connection and self-expression, it also presents various challenges and risks. As a parent, navigating your teenager's social media usage can be daunting. However, with the right guidance and support, you can help ensure that your teen stays safe and responsible online.</p>

            <h3>Top Tips for Parents:</h3>
            <ol>
                <li><b>Open Communication:</b></li>
                <p class="ol-p">Establishing open and honest communication with your teenager is crucial. Encourage them to share their online experiences, concerns, and questions with you without fear of judgment. By fostering a trusting relationship, you can better understand their digital world and provide appropriate guidance.</p>
                <li><b>Set Clear Boundaries:</b></li>
                <p class="ol-p">Set explicit rules and limitations for the use of social media. Talk about appropriate platforms, reasonable time restrictions, and the significance of privacy settings. Early establishment of these boundaries lowers the likelihood of overuse or exposure to dangerous information while also assisting your adolescent in developing safe internet habits.</p>
                <li><b>Educate About Online Safety:</b></li>
                <p class="ol-p">Teach your adolescent the value of maintaining personal information security, identifying and avoiding online hazards including frauds and cyberbullying, and exercising caution when communicating with strangers on the internet. Give them the tools they need to navigate the digital world with knowledge and faith in their gut feelings.</p>
                <li><b>Lead by Example:</b></li>
                <p class="ol-p">Your involvement as a parent sets an example for your adolescent. Set an example of ethical social media use by being a good digital citizen. Respect other people while interacting online, avoid disclosing private information to the public, and have constructive and encouraging conversations. Your teen's conduct is influenced by your actions, which have a greater impact than words.</p>
                <li><b>Monitor Without Intruding:</b></li>
                <p class="ol-p">As vital as it is to keep tabs on your adolescent's internet activity, you also need to respect their privacy. Strike a balance between allowing kids some liberty and keeping an eye on their internet activity. Be inconspicuous when utilizing monitoring and parental control software, and prioritize safety over spying. Continue having frank discussions as you jointly address any worries or warning signs.</p>
                <li><b>Encourage Offline Activities:</b></li>
                <p id="3" class="ol-p">Motivate your adolescent to engage in hobbies and offline pursuits that enhance their mental, emotional, and physical health. Incorporate in-person conversations, outdoor pursuits, sports, the arts, and other hobbies to counterbalance their screen usage. Maintain a healthy lifestyle by placing a high value on interactions and experiences in the actual world.</p>
            </ol>

            <h3>Important Information:</h3>
            <ul>
                <li>Cyberbullying Awareness</li>
                <li>Privacy Settings</li>
                <li>Reporting Tools</li>
                <li>Digital Footprint</li>
                <li>Seek Support</li>
            </ul>
            <h3>Cyberbullying Awareness:</h3>
            <p>Train your kid and yourself about the dangers of cyberbullying and how common it is. Promote candid conversations about experiences with bullying while offering assistance and direction on how to react correctly.</p>
            <h3>Privacy Settings:</h3>
            <p>Assist your adolescent in utilizing social media privacy settings to manage who may view their posts, images, and private data. Stress the value of protecting one's privacy and staying away from online encounters with strangers.</p>
            <h3>Reporting Tools:</h3>
            <p>Learn how to use the reporting and blocking tools on social networking sites with your adolescent. Urge them to notify the platform administrators of any instances of bullying, harassment, or offensive content.</p>
            <h3>Digital Footprint:</h3>
            <p>Talk to your adolescent about the idea of a digital footprint and the long-term effects of their internet behavior. Remind them that the things they publish on social media can have a long-term effect on their reputation, their ability to get into college, and their chances of finding work in the future.</p>
            <h3>Seek Support:</h3>
            <p>Talk to your adolescent about the idea of a digital footprint and the long-term effects of their internet behavior. Remind them that the things they publish on social media can have a long-term effect on their reputation, their ability to get into college, and their chances of finding work in the future.</p>
        </div>
    </section>

    <section class="reminder-container">
        <h1>Succinct Reminders</h1>
        <div class="reminder-box">
            <div class="reminder">
                <div class="img">
                    <img src="MemberImage/help (1).png" alt="image">
                </div>
                <div class="text">
                    <p>Help</p>
                </div>
                <div class="info">
                    <p>Support Teenagers to get Healthy Social Life</p>
                </div>
            </div>
            <div class="reminder">
                <div class="img">
                    <img src="MemberImage/top-tips (1).png" alt="image">
                </div>
                <div class="text">
                    <p>Top Tips</p>
                </div>
                <div class="info">
                    <p>Top Tips for Parental Guidance on Social Media Safety</p>
                </div>
            </div>
            <div class="reminder">
                <div class="img">
                    <img src="MemberImage/info.png" alt="image">
                </div>
                <div class="text">
                    <p>Important Info</p>
                </div>
                <div class="info">
                    <p>Learn about reporting tools to address cyberbullying together.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials">
        <div class="testimonial-heading">
            <span>Comments</span>
            <h1>Parents' Suggestions</h1>
        </div>
        <div class="testimonial-box-container">
            <div class="testimonial-box">
                <div class="box-top">
                    <div class="profile">
                        <div class="profile-img">
                            <img src="MemberImage/user.webp" alt="image">
                        </div>
                        <div class="name-user">
                            <strong>George</strong>
                            <span>George0527@gmail.com</span>
                            <span class="date">2/1/2024</span>
                        </div>
                    </div>
                </div>
                <div class="comment-container">
                    <div class="client-comment">
                        <p>I find that having regular 'tech-free' family nights really helps balance out our screen time. It's a great way to reconnect and focus on each other without the distractions of social media.</p>
                    </div>
                    <div class="react">
                        <i class="fa-regular fa-heart"><span id="like-count">1</span></i>
                        <i class="fa-regular fa-comment"></i>
                        <i class="fa-regular fa-share-from-square"></i>
                    </div>
                </div>
            </div>

            <div class="testimonial-box">
                <div class="box-top">
                    <div class="profile">
                        <div class="profile-img">
                            <img src="MemberImage/ano1.png" alt="Profile Image">
                        </div>
                        <div class="name-user">
                            <strong>Elijah</strong>
                            <span>Elijah@gmail.com</span>
                            <span class="date">2/2/2024</span>
                        </div>
                    </div>
                </div>
                <div class="comment-container">
                    <div class="client-comment">
                        <p>Setting up weekly check-ins where we discuss any concerns or issues my teen may have encountered online has really helped keep communication open.</p>
                    </div>
                    <div class="react">
                        <i class="fa-regular fa-heart"><span id="like-count">3</span></i>
                        <i class="fa-regular fa-comment"></i>
                        <i class="fa-regular fa-share-from-square"></i>
                    </div>
                </div>
            </div>

            <div class="testimonial-box">
                <div class="box-top">
                    <div class="profile">
                        <div class="profile-img">
                            <img src="MemberImage/ano4.png" alt="Profile Image">
                        </div>
                        <div class="name-user">
                            <strong>Araminta</strong>
                            <span>aramintacute@gmail.com</span>
                            <span class="date">2/17/2024</span>
                        </div>
                    </div>
                </div>
                <div class="comment-container">
                    <div class="client-comment">
                        <p>We've made it a habit to review privacy settings together every few months. It helps my teen understand the importance of protecting their information and gives us peace of mind knowing they're being proactive about their online safety.</p>
                    </div>
                    <div class="react">
                        <i class="fa-regular fa-heart"><span id="like-count">2</span></i>
                        <i class="fa-regular fa-comment"></i>
                        <i class="fa-regular fa-share-from-square"></i>
                    </div>
                </div>
            </div>

            <div class="testimonial-box">
                <div class="box-top">
                    <div class="profile">
                        <div class="profile-img">
                            <img src="MemberImage/ano3.png" alt="Profile Image">
                        </div>
                        <div class="name-user">
                            <strong>William</strong>
                            <span>Williamstar@gmail.com</span>
                            <span class="date">2/19/2024</span>
                        </div>
                    </div>
                </div>
                <div class="comment-container">
                    <div class="client-comment">
                        <p>Setting boundaries on screen time has been crucial for us. We have designated 'no-phone zones' in the house, like during meals and before bedtime, to encourage offline interactions and better sleep habits.</p>
                    </div>
                    <div class="react">
                        <i class="fa-regular fa-heart"><span id="like-count">0</span></i>
                        <i class="fa-regular fa-comment"></i>
                        <i class="fa-regular fa-share-from-square"></i>
                    </div>
                </div>
            </div>

            <?php
            if (!isset($_SESSION["MemberID"])) {
                $parentCommentSelect = "SELECT * FROM parentcommenttb";
                $selectQuery = mysqli_query($connect, $parentCommentSelect);
                $count = mysqli_num_rows($selectQuery);

                for ($i = 0; $i < $count; $i++) {
                    $array = mysqli_fetch_array($selectQuery);
                    $memberemail = $array['MemberEmail'];
                    $commentdate = $array['CommentDate'];
                    $comment = $array['Comment'];
                    $memberusername = $array['UserName'];
                    $memberprofile = $array['MemberProfile'];

                    echo "<div class='testimonial-box'>
                        <div class='box-top'>
                            <div class='profile'>
                                <div class='profile-img'>
                                    <img src='$memberprofile'>
                                </div>
                                <div class='name-user'>
                                    <strong>$memberusername</strong>
                                    <span>$memberemail</span>
                                    <span class='date'>$commentdate</span>
                                </div>
                            </div>
                        </div>
                        <div class='comment-container'>
                            <div class='client-comment'>
                                <p>$comment</p>
                            </div>
                            <div class='react'>
                                <i class='fa-regular fa-heart'><span id='like-count'>0</span></i>
                                <i class='fa-regular fa-comment'></i>
                                <i class='fa-regular fa-share-from-square'></i>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                // Session passes from member login
                $memberid = $_SESSION["MemberID"];
                $memberEmail = $_SESSION["MemberEmail"];
                $memberUserName = $_SESSION["MemberUserName"];
                $memberProfile = $_SESSION["MemberProfile"];

                $parentCommentSelect = "SELECT * FROM parentcommenttb";
                $selectQuery = mysqli_query($connect, $parentCommentSelect);
                $count = mysqli_num_rows($selectQuery);

                for ($i = 0; $i < $count; $i++) {
                    $array = mysqli_fetch_array($selectQuery);
                    $memberemail = $array['MemberEmail'];
                    $commentdate = $array['CommentDate'];
                    $comment = $array['Comment'];
                    $memberusername = $array['UserName'];
                    $memberprofile = $array['MemberProfile'];

                    echo "<div class='testimonial-box'>
                        <div class='box-top'>
                            <div class='profile'>
                                <div class='profile-img'>
                                    <img src='$memberprofile'>
                                </div>
                                <div class='name-user'>
                                    <strong>$memberusername</strong>
                                    <span>$memberemail</span>
                                    <span class='date'>$commentdate</span>
                                </div>
                            </div>
                        </div>
                        <div class='comment-container'>
                            <div class='client-comment'>
                                <p>$comment</p>
                            </div>
                            <div class='react'>
                                <i class='fa-regular fa-heart'><span id='like-count'>0</span></i>
                                <i class='fa-regular fa-comment'></i>
                                <i class='fa-regular fa-share-from-square'></i>
                            </div>
                        </div>
                    </div>";
                }
            }
            ?>

        </div>
    </section>

    <?php
    if (!isset($_SESSION["MemberID"])) {
    ?>
        <section class="suggestion-form">
            <div class="suggestion-img">
                <img src="MemberImage/employee-suggestion_program.webp" alt="Image">
            </div>
            <div class="suggestion-form-container">
                <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                    <label for="memberemail">Email</label>
                    <input type="email" name="memberemail" id="memberemail" placeholder="example@gmail.com" readonly>
                    <label for="membersuggestion">Your Suggestion</label>
                    <textarea name="membersuggestion" id="membersuggestion" placeholder="Enter your suggestion here..." required></textarea>
                    <input type="date" name="suggestiondate" id="suggestiondate" value="<?php echo date("Y-m-d") ?>">
                    <?php
                    if (!isset($_SESSION["MemberID"])) {
                        echo '<p>Please login to comment.</p>';
                    } else {
                        echo '<input type="submit" name="submit" id="submit" value="Submit">';
                    }
                    ?>
                </form>
            </div>
        </section>
    <?php
    } else {
    ?>
        <section class="suggestion-form">
            <div class="suggestion-img">
                <img src="MemberImage/employee-suggestion_program.webp" alt="Image">
            </div>
            <div class="suggestion-form-container">
                <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                    <label for="memberemail">Email</label>
                    <input type="email" name="memberemail" id="memberemail" value="<?php echo $memberEmail ?>" readonly>
                    <label for="membersuggestion">Your Suggestion</label>
                    <textarea name="membersuggestion" id="membersuggestion" placeholder="Enter your suggestion here..." required></textarea>
                    <input type="date" name="suggestiondate" id="suggestiondate" value="<?php echo date("Y-m-d") ?>">
                    <?php
                    if (!isset($_SESSION["MemberID"])) {
                        echo '<p>Please login to comment.</p>';
                    } else {
                        echo '<input type="submit" name="submit" id="submit" value="Submit">';
                    }
                    ?>
                </form>
            </div>
        </section>
    <?php
    }
    ?>

    <footer>
        <div class="footer">
            <div class="footer-logo">
                <h2>SMC</h2>
                <p>Social Media Campaigns</p>
                <span>You are here (Parental Support) </span>
            </div>
            <div class="footer-link">
                <a href="#">COMMUNITY FORM</a>
                <a href="LiveStreaming.php">SAFETY TIPS</a>
                <a href="#">REPORT ABUSE</a>
            </div>
            <div class="footer-link">
                <a href="#">SERVICES</a>
                <a href="ParentalSupport.php">PARENTAL GUIDANCE</a>
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