<?php
session_start();
include("dbconnection.php");

if (isset($_COOKIE["user"])) {
    $memberUserName = $_SESSION["MemberUserName"];
    echo "<script>window.alert('Welcome Customer $memberUserName!')</script>";
} else {
    //pass
}
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
            echo "<script>window.location = 'MemberHome.php'</script>";
        } else {
            echo "<script>window.alert('Something went worng.')</script>";
            echo "<script>window.location = 'MemberHome.php'</script>";
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
                    <li class="nav-links"><a href="MemberHome.php" class="active">Home</a>
                        <p class="line line-active"></p>
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
                    // pass
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

    <section class="home-header-container">
        <div class="home-header-title">
            <h1>Stay Safe Online with SMC</h1>
            <p>Your Trusted Resource for Teenagers</p>
        </div>
        <div class="home-header-img">
            <img src="MemberImage/social-media-article-version-2-main.png" alt="Main Image">
        </div>
    </section>

    <section class="home-main-content">
        <div class="right-slide-container" id="home">
            <h1>The top 5 social media apps and platforms for 2024</h1>
            <p>This list is ranked by the latest data on monthly active users (MAUs)*. While it's useful to see the sheer volume of users each site has, it doesn't necessarily mean the one with the biggest user base is the best for your brand. If your target audience is not active there, the platform isn't worth the time and effort it will take to manage it.</p>
            <p id="1">Start your social media marketing strategy by pinpointing where your ideal customers are active, to get the best return on investment (ROI) for your business.</p>

            <h1>1. Facebook — 3.05 billion MAUs</h1>
            <div class="home-main-img">
                <img src="MemberImage/Top-Social-Media-Sites--17-.png" alt="Social Media">
            </div>

            <p>Facebook is the largest social networking site, with over 3 billion people using it monthly, according to Statista. This means roughly 37 percent of the world’s population are Facebook users. Facebook's direct messaging spin-off app, Facebook Messenger, boasts 931 million monthly active users.</p>
            <p>More than 200 million businesses (mostly small businesses) use Facebook tools, and more than seven million advertisers actively promote their business on Facebook, which makes it a pretty safe bet if you want to have a presence on social media.</p>
            <p>It’s easy to get started on Facebook because almost all content formats work great on Facebook — text, images, video content, and Stories. But the Facebook algorithm prioritizes content that sparks conversations and meaningful interactions between people, especially those from family and friends.</p>
            <p id="2">To learn more about how Facebook works, check out <a href="https://www.facebook.com/help/1081628722047954" target="_blank">Facebook</a> on Facebook — and measuring your results.</p>

            <h1>2. WhatsApp — 2.78 billion MAUs</h1>
            <div class="home-main-img">
                <img src="MemberImage/Top-Social-Media-Sites--15-.png" alt="Social Media">
            </div>

            <p>WhatsApp is a messaging app used by people in over 180 countries, boasting an estimated 2.78 active users, according to Statista.</p>
            <p>Initially, people originally used WhatsApp to send text messages to their family and friends, but the launch of WhatsApp Business in 2018 has seen the messaging platform become a popular choice for brands. WhatsApp Business reported having over 200 million monthly active users in June 2023.</p>
            <p>WhatsApp’s business platform allows businesses to provide customer support and share updates with customers about their purchases. For small businesses, there’s the WhatsApp Business app, while enterprise businesses can use the WhatsApp Business API.</p>
            <p id="3">As the most widely used messaging platform, WhatsApp can be a great customer service channel for your business. Check out these <a href="https://business.whatsapp.com/learn-more" target="_blank">WhatsApp</a> Business user success stories.</p>

            <h1>3. YouTube — 2.49 billion MAUs</h1>
            <div class="home-main-img">
                <img src="MemberImage/Top-Social-Media-Sites--16-.png" alt="Social Media">
            </div>

            <p>YouTube is a video-sharing platform where users watch a billion hours of videos daily. Besides being the second largest social media app, YouTube is often called the second largest search engine after Google, its parent company.</p>
            <p>So, if you use video to promote your business, then you definitely need to add YouTube to your marketing strategy. To get started, here’s how to create a YouTube channel for your brand.</p>
            <p id="4">To help your videos get discovered by more people, we recommend reading up on <a href="https://blog.hubspot.com/marketing/youtube-seo" target="_blank">Youtube SEO</a> or considering advertising on YouTube to increase your reach.</p>

            <h1>4. Instagram — 2.04 billion MAUs</h1>
            <div class="home-main-img">
                <img src="MemberImage/Top-Social-Media-Sites--19-.png" alt="Social Media">
            </div>

            <p>As a visual social networking platform, Instagram is the place for showcasing your products or services with photos or videos. On the app, you can share a wide range of content, such as photos, videos, Stories, Reels, and live videos.</p>
            <p id="5">As a brand, you can create an Instagram business profile, which provides rich analytics of your profile and posts and the ability to schedule Instagram posts using third-party tools. It’s also a great place to get user-generated content from your audience because users frequently share content and tag brands.</p>
            <p>To help you use Instagram like a pro, check out <a href="https://help.instagram.com/521372114683554" target="_blank">Instagram</a>.</p>

            <h1>5. TikTok — 1.22 billion MAUs</h1>
            <div class="home-main-img">
                <img src="MemberImage/Top-Social-Media-Sites--7-.png" alt="Social Media">
            </div>

            <p>TikTok (known as Douyin in China) is a short-form video-sharing app. Despite only launching in 2017, it’s one of the fastest-growing apps in the world and recently overtook Google as the most visited internet site.​</p>
            <p>TikTok allows users to create and share videos between 15 seconds and 10 minutes long, and the app has a vast catalog of sound effects, music snippets, and filters to enhance the videos and make them more appealing.</p>
            <p>You can find videos relating to almost all interests, ranging from lip-syncs, dancing, and challenges to DIY tricks and make-up tutorials. About 47.4 percent of TikTok users in the U.S. are aged 10-29. So if your target demographic is young, then <a href="https://www.tiktok.com/about?lang=en" target="_blank">TikTok</a> is a great social media platform for your business to be on.</p>
        </div>
        <aside class="left-slide-container">
            <div class="table-content">
                <div class="form">
                    <div class="table-title">
                        <img src="MemberImage/architecture-and-city.png" alt="Icon">
                        <h1>On this page</h1>
                    </div>
                    <a href="#1">1. Facebook — 3.05 billion MAUs</a>
                    <a href="#2">2. WhatsApp — 2.78 billion MAUs</a>
                    <a href="#3">3. YouTube — 2.49 billion MAUs</a>
                    <a href="#4">4. Instagram — 2.04 billion MAUs</a>
                    <a href="#5">5. TikTok — 1.22 billion MAUs</a>
                </div>
            </div>
        </aside>
    </section>

    <section class="home-section-container">
        <div class="home-section-img">
            <img src="MemberImage/bigstock-User-Social-Networking-And-Cha-234637759.jpg" alt="Main Image">
        </div>
    </section>

    <section class="benifit-risk">
        <div class="fb-main-container">
            <div class="br-container-box">
                <div class="fb-title">
                    <h1 class="fb">Facebook</h1>
                </div>
                <div class="benifit-container">
                    <h1>Pros</h1>
                    <ul>
                        <li><strong>Useful for Education –</strong> Facebook is an excellent tool for education. Professors can share lectures and other course materials with the class, and students can even interact with each other to have debates about the course material. Teachers are able to connect with their students, and parents are able to get updates on a student’s progress at school. The site also has a forum that teachers can use when they need help with questions from their students.</li>
                        <li><strong>Stay connected –</strong> As much as we like to think that the Internet is a great place for connecting with other people, Facebook has made it even easier. You can message your friends and family, or you can keep up with what they’re doing on Facebook. You can also create groups where you share information and updates about a certain topic.</li>
                        <li><strong>Helps find people with similar interests and preferences –</strong> Facebook provides us with new opportunities to meet people who share similar interests or goals. We can find others who have gone through the same struggles, and support each other as we work on overcoming them together.</li>
                        <li><strong>Useful for marketing –</strong> Facebook has been an effective marketing tool for a few reasons. First, it’s the most popular social media platform with over 1.86 billion monthly active users as of June 2017. Second, many people use Facebook’s ad targeting to reach potential customers in specific demographics and geographic areas at a low cost. Third, Facebook pages are highly customizable and easy to create which allows businesses to easily promote their products and services.</li>
                    </ul>
                </div>
                <div class="risk-container">
                    <h1>Cons</h1>
                    <ul>
                        <li><strong>Privacy concerns –</strong> Facebook has a history of violating user privacy. For example, in 2012, the company proposed an app that would have let marketers track users’ web browsing activity outside of Facebook. This would have allowed them to better target advertisements on Facebook. Two years ago, the company admitted that it had been secretly saving phone numbers and text messages from Android devices for years. More recently, Facebook shut down nearly 200 apps due to privacy concerns.</li>
                        <li><strong>Can cause addiction –</strong> Facebook can be distracting, rather than being helpful. Instead of checking your Facebook feed and addressing the tasks that need to be done, it can take over your life. It has been proven that Facebook can also have a negative impact on someone’s lifestyle habits. The addiction to Facebook is so severe that some people find themselves logging in as soon as their phone wakes up in the morning, checking for notifications before anything else.</li>
                        <li><strong>Can disrupt sleep –</strong> It is well known that Facebook can be addicting. It also disrupts sleep patterns. One study found that the blue light from smartphones, laptops and other devices that emit this type of light can suppress the production of melatonin. This means people are not getting enough sleep or the deep, beneficial sleep that they need to function well and stay healthy.</li>
                        <li><strong>Risk of cyber bullying –</strong> One of the most dangerous things that can happen on Facebook is cyber bullying, which is when someone uses the internet to threaten or bully another person. This abuse can be done by known followers, anonymously or under a fake profile and it often starts by pestering the victim with mentally disturbing messages, posts, or images.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="fb-main-container">
            <div class="br-container-box">
                <div class="fb-title">
                    <h1 class="wsu">WhatsApp</h1>
                </div>
                <div class="benifit-container">
                    <h1>Pros</h1>
                    <ul>
                        <li><strong>Acts as an Information Sharing Platform –</strong> WhatsApp is the most efficient platform for communicating with individuals and groups. You can share files, images, documents, and other resources with a single click. WhatsApp has proven to be the primary information-sharing medium in various institutions like universities and schools. During the pandemic, when everything shut down, WhatsApp was a bridge between office work and school work.</li>
                        <li><strong>Provides Safety and Security –</strong> Personal data and information are securely stored with the end-to-end encryption feature of WhatsApp, and users can report and block unknown users. Moreover, to protect data, WhatsApp enables you to take end-to-end encrypted backups. These features of WhatsApp restrict the exploitation of personal information, giving users a friendly and safe experience.</li>
                        <li><strong>Provides a Global Connection –</strong> WhatsApp enables friends and family to communicate even if they live on different continents and countries. Even if you live far from each other, you can celebrate festivals by making video calls, sending photos, and watching videos. Today, WhatsApp has become the new vogue.</li>
                        <li><strong>User Friendly –</strong> WhatsApp’s user-friendliness is another fantastic feature, which accounts for its popularity among youngsters and senior citizens. The app does not require any technical knowledge. Hence, WhatsApp is the only program where you can locate several family groups; thus, it has increased global connectivity.</li>
                    </ul>
                </div>
                <div class="risk-container">
                    <h1>Cons</h1>
                    <ul>
                        <li><strong>A Platform for Spreading False Information –</strong> WhatsApp has become a platform for spreading misleading content. Some people use the application to advance their political viewpoints, and WhatsApp is also used to promote hate speech against specific people and organizations. During the Covid-19 outbreak, people received several false medical recommendations on WhatsApp.</li>
                        <li><strong>Affects Mental Health –</strong> Youngsters remain isolated from their physical environment and get lost in virtual reality due to the excessive use of WhatsApp. They prefer to be on their phones instead of interacting with people in person. It severely affects their mental health as they compete in a self-created world. It lowers their self-worth and creates self-doubt.</li>
                        <li><strong>Unnecessary Interruptions –</strong> Nobody can indeed overlook WhatsApp text notifications. From checking one message to viewing people’s statuses, you’ll also start looking through the profile pictures of your contacts. After doing that, you frequently open your connections’ contact information and review it. Therefore, we can conclude that WhatsApp is a persistent cause of disturbances in our day-to-day lives.</li>
                        <li><strong>Usage of Storage –</strong> The images, videos, and audio you receive or forward to people can be deleted, but backups of them are saved in the media folder of WhatsApp. As a result, the space to store WhatsApp on your phone keeps rising. Moreover, it is tough to free space even after deleting the images and videos.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="fb-main-container">
            <div class="br-container-box">
                <div class="fb-title">
                    <h1 class="yt">YouTube</h1>
                </div>
                <div class="benifit-container">
                    <h1>Pros</h1>
                    <ul>
                        <li><strong>It’s free to use –</strong> You can watch and upload videos on YouTube. However, to get the free services, now, you have to manage several advertisements, most of which can skip, but some of which need to play partially or wholly. YouTube Premium is a paid service that allows users to go ad-free.</li>
                        <li><strong>Wide selection of content –</strong> There is a wide variety of content available on YouTube, including music videos, educational videos, movie trailers, and more, as we have mentioned above. The range is such that people have made entire careers by being YouTube content creators in several niches. For instance, for individuals seeking valuable insights on personal development and life guidance, the platform offers easy access to the best life coaches on YouTube.</li>
                        <li><strong>Accessibility –</strong> You can access YouTube from any device with an internet connection, including your computer, smartphone, and tablet. It brings knowledge of the world, such as Ted Talks, to your room. You can even rent movies on YouTube.</li>
                        <li><strong>Sharing –</strong> You can easily share videos from YouTube on social media and other websites. Additionally, while downloading videos from YouTube to your device is difficult, you can view downloaded videos offline on the YouTube platform and share their links with your friends and family. Moreover, you can also use a video downloader to save YouTube videos on your device for offline viewing.</li>
                    </ul>
                </div>
                <div class="risk-container">
                    <h1>Cons</h1>
                    <ul>
                        <li><strong>Misinformation –</strong> Some videos on YouTube contain misinformation or false information. Fact-checking information you find online, including those on YouTube, is essential. Taking the lead from personal vlogs can be exceptionally dangerous as that information can be precise to the people involved and might not be the best for you as an individual.</li>
                        <li><strong>Inappropriate content –</strong> While YouTube has strict policies to remove inappropriate content, some videos may not be suitable for all audiences. YouTube has a feature that helps keep children away from adult content.</li>
                        <li><strong>Privacy –</strong> YouTube collects data from its users and may share it with third parties. It is a concern for users who value their privacy. Ads are also a concern of privacy issues, as some adverts that YouTube gets are from websites that have used cookies to remind users to return to their products.</li>
                        <li><strong>Social sustainability –</strong> YouTube has faced criticism for its impact on its users’ mental health and well-being, particularly young people. While this remains a problem, YouTube has implemented policies and tools to address these issues from now on.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="fb-main-container">
            <div class="br-container-box">
                <div class="fb-title">
                    <h1 class="ig">Instagram</h1>
                </div>
                <div class="benifit-container">
                    <h1>Pros</h1>
                    <ul>
                        <li><strong>Sharing –</strong> Every content on Instagram, whether made directly from the Instagram app or created by the user and afterward published to Instagram, can be freely shared by the user. Also, every user can share any content file on other social networking sites such as Facebook, Twitter, and others.</li>
                        <li><strong>Instagram for Business –</strong> Market potential has grown due to the high number of people selling their services and goods on Instagram profiles. Businesses now have additional market potential due to their capacity to promote their products and investigate consumer demand.</li>
                        <li><strong>Builds Contacts –</strong> It is a social networking platform that you may use to follow celebrities and stay in touch with your friends. Anyone who misses their friends can hunt them up on Instagram, and business owners can create profiles and ask for followers. In this approach, business executives and ordinary people can improve their interactions.</li>
                        <li><strong>First Choice for Travelers –</strong> Instagram, like Bloggers, has become a hotspot for travelers. It features a geotagging option that works flawlessly! You may quickly put the location of your photo when you share it anywhere you go. There is also a slew of additional public accounts where people share their trip stories and images.</li>
                    </ul>
                </div>
                <div class="risk-container">
                    <h1>Cons</h1>
                    <ul>
                        <li><strong>Addictive –</strong> Instagram has become an addiction for consumers, and even now, young people frequently use it for entertainment. It’s an addiction to use with caution because it can cause many issues.</li>
                        <li><strong>Not compatible with all operating systems –</strong> Insta is only available and useable on iOS, Windows Mobile, and Android-powered mobile devices. Other mobile operating systems, such as LINUX and Blackberry, are not supported.</li>
                        <li><strong>False Ads –</strong> Someone occasionally publishes inaccurate advertisements to defraud many people. As a result of multiple fraudulent promotions, people no longer trust Instagram. Other businesses must suffer as a result.</li>
                        <li><strong>Image Stealing –</strong> Despite Instagram’s various security measures, it is a digital platform, and there is always the possibility that any professional and quality content added to Instagram may be “stolen” by another person without the consent of the user who has uploaded the content.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="fb-main-container">
            <div class="br-container-box">
                <div class="fb-title">
                    <h1 class="tk">Tiktok</h1>
                </div>
                <div class="benifit-container">
                    <h1>Pros</h1>
                    <ul>
                        <li><strong>People can teach and learn new skills -</strong> If it’s learning how to draw, how to ride a skateboard without falling down, or how to paint a tiger, Tik Tok can help users learn from creators. The Tik Tok messaging system can also help users ask questions about how to do what they’re teaching. It can also help people interact and bond about things they like about the experience or video.</li>
                        <li><strong>Increase awareness for new brands -</strong> Tik Tok will often show many ads a lot of the time. These ads can show people about new products that are released in the app which actually promotes new and helpful items. There is also now a Tik Tok store which shows places where you can buy items, as well as an online version of the store.</li>
                        <li>Entertained with content -</strong> In Tik Tok you can find anything you can think of in a video. You can like and share videos that you find interesting or funny to friends and family. You can also like and favorite the videos to show support to your favorite creators. You can also show support to small creators that just started to help their community grow. Leaving a like or a nice comment could brighten up the day of a small creator or a friend who’s posting on Tik Tok, and though there can be and are many negative comments on the platform, Tik Tok is also a place to spread positivity.</li>
                        <li><strong>Worldwide audience -</strong> When searching for videos, you might find an idea that you like. This might encourage you to start your journey into creating videos and content on Tik Tok. When you upload the videos you can gather a lot of likes, favorites and positive comments. This way, you can upload things to the world, simply with a phone or tablet, and in five seconds upload it for the world to see.</li>
                    </ul>
                </div>
                <div class="risk-container">
                    <h1>Cons</h1>
                    <ul>
                        <li><strong>It can be addictive -</strong> Teens already spend a lot of time on their devices every day, which have been proven to impact their brains. According to realresearcher.com, about 68 percent of teens spend more time on social media than on any other activity, and about 39 percent of teens own over five social media accounts. If teens are already addicted to technology, then with Tik Tok, they end up using more screen time. </li>
                        <li><strong>Damage teenage minds -</strong> The content on the internet can be harmful to the minds of teenagers. 4.67 billion people use social media daily, and about 1 billion active users monthly on Tik Tok. This means that anyone has the freedom to post anything they want. Therefore, the content on the internet may not always be appropriate to the brains of other users.</li>
                        <li><strong>Can be dangerous -</strong> In many cases, TikTok can be helpful and fun. However, it can also be very dangerous. TikTok can be an opportunity for people to stalk users in their daily life, which can be dangerous considering the amount of information that people share about their lives on the internet. TikTok can also have safety risks like saved user data, and scams. </li>
                        <li><strong>Prone to cyberbullying -</strong> Posting on TikTok provides the risk of anybody seeing it, and broadcasting their opinions — including negative commentary — which can then lead to cyberbullying. Cyberbullying has caused insecurities, low self esteem and even more serious mental health issues — especially for teenagers.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="home-main-content">
        <div class="right-slide-container" id="staysafe">
            <h2>Staying Safe Online</h2>
            <ul>
                <li><strong>Protect Your Personal Information –</strong> Be cautious about sharing personal information online, such as your full name, address, phone number, school name, or financial details.</li>
                <li>Avoid posting sensitive information on social media or public forums where it can be accessed by strangers.</li>
                <li>Use privacy settings on social media platforms to control who can view your profile and posts.</li>
            </ul>

            <ul>
                <li><strong>Think Before You Click –</strong> Be wary of clicking on links or downloading attachments from unfamiliar sources, as they could contain malware or phishing attempts.</li>
                <li>Verify the legitimacy of websites before entering any personal information or making online purchases.</li>
                <li>If something seems too good to be true (like offers for free products or easy money), it's likely a scam.</li>
            </ul>

            <ul>
                <li><strong>Practice Safe Social Media Habits –</strong> Only accept friend requests or follow requests from people you know and trust in real life.</li>
                <li>Think twice before sharing photos or videos online, considering how they could be perceived by others and whether they could potentially harm your reputation.</li>
                <li>Report and block users who engage in cyberbullying, harassment, or inappropriate behavior.</li>
            </ul>

            <ul>
                <li><strong>Create Strong Passwords –</strong> Use unique, complex passwords for each of your online accounts to minimize the risk of hacking.</li>
                <li>Incorporate a mix of uppercase and lowercase letters, numbers, and symbols in your passwords.</li>
                <li>Consider using a password manager to securely store and manage your passwords.</li>
            </ul>

            <ul>
                <li><strong>Be Mindful of Online Relationships –</strong> Exercise caution when interacting with strangers online, especially in chat rooms, online gaming platforms, or dating apps.</li>
                <li>Avoid sharing personal information or meeting up with someone you've only met online without first consulting a trusted adult.</li>
                <li>If you ever feel uncomfortable or pressured in an online interaction, trust your instincts and seek help from a parent, guardian, or trusted adult.</li>
            </ul>

            <ul>
                <li><strong>Educate Yourself About Online Safety –</strong> Stay informed about the latest online threats and safety tips by following reputable sources such as cybersecurity blogs, news websites, or educational resources.</li>
                <li>Talk to your parents, teachers, or school counselors about online safety and seek their guidance if you encounter any issues or concerns.</li>
            </ul>
        </div>
    </section>

    <section class="monthly-newsletter-container">
        <div class="monthly-newsletter">
            <div class="monthly-newsletter-title">
                <h1>Monthly Newsletter</h1>
                <p>Stay informed and empowered with our exclusive monthly newsletter for essential social media safety tips.</p>
            </div>
            <div class="monthly-newsletter-btn">
                <a href="MemberSignUp.php">Register Now</a>
            </div>
        </div>
    </section>

    <section class="feacture-container">
        <div class="feacture">
            <div class="feactures-box">
                <h1>Create an account</h1>
                <p>Sign up now for exclusive access to safety tips and our monthly newsletter updates!</p>
            </div>
            <div class="feactures-box">
                <h1>Share your thoughts</h1>
                <p>Connect, learn, and stay safe online with our community-focused resources and expert advice.</p>
            </div>
            <div class="feactures-box">
                <h1>Join our campaigns</h1>
                <p>Empowering teens with essential social media safety tips. Join our campaign for a safer online experience!</p>
            </div>
        </div>
    </section>

    <section class="member-list-container">
        <div class="member-list-title">
            <h1>Welcome</h1>
            <p>Welcome to a safer online space! Join us in empowering teens for secure social media experiences.</p>
        </div>
        <div class="member-list-box-container">
            <?php
            $campaignSelect = "SELECT * FROM campaigntb";
            $selectQuery = mysqli_query($connect, $campaignSelect);
            $campaigncount = mysqli_num_rows($selectQuery);

            // Select members who signed up in a specific month.
            $memberSelect = "SELECT * FROM membertb
            WHERE SignUpMonth = 'March'";
            $selectQuery = mysqli_query($connect, $memberSelect);
            $membercount = mysqli_num_rows($selectQuery);

            ?>
            <div class="member-list-box">
                <h1><?php echo $campaigncount ?></h1>
                <p>Campaign</p>
            </div>
            <div class="member-list-box">
                <h1><?php echo $membercount ?></h1>
                <p>Member</p>
            </div>
            <div class="member-list-box">
                <h1>5</h1>
                <p>Award</p>
            </div>
        </div>
    </section>

    <section class="monthly-member-container">
        <div class="monthly-member">
            <table>
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>UserName</th>
                        <th>Member Email</th>
                        <th>SignUp Month</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Select members who signed up in a specific month.
                    $memberSelect = "SELECT * FROM membertb
                    WHERE SignUpMonth = 'March'";
                    $selectQuery = mysqli_query($connect, $memberSelect);
                    $membercount = mysqli_num_rows($selectQuery);

                    for ($i = 0; $i < $membercount; $i++) {
                        $array = mysqli_fetch_array($selectQuery);
                        $memberUsername = $array['UserName'];
                        $memberEmail = $array['MemberEmail'];
                        $signUpMonth = $array['SignUpMonth'];
                        $memberProfile = $array['MemberProfile'];

                        echo "<tr>";
                        echo "<td class='member-img'><img src = '$memberProfile'></td>";
                        echo "<td>$memberUsername</td>";
                        echo "<td>$memberEmail</td>";
                        echo "<td>$signUpMonth</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="gallery">
        <div class="gallery-title">
            <h1>Gallery</h1>
        </div>
        <div class="gallery-wrapper">
            <div class="gallery-box">
                <img src="MemberImage/colorful-icons-collection_79603-1270.avif" alt="Gallery Image">
            </div>
            <div class="gallery-box">
                <img src="MemberImage/colorful-icons-set-design_79603-1268.avif" alt="Gallery Image">
            </div>
            <div class="gallery-box">
                <img src="MemberImage/colorful-icons-set-style_79603-1269.avif" alt="Gallery Image">
            </div>
            <div class="gallery-box">
                <img src="MemberImage/ecd662c702bdf61baa72d9dd9b3bf253.jpg" alt="Gallery Image">
            </div>
            <div class="gallery-box">
                <img src="MemberImage/3d-vector-minimal-social-media-with-video-photo-gallery-mobile-hand-holding-interface-optimization-banner-website-mockup-mobile-concept-image-3d-display-with-device-smartp.avif" alt="Gallery Image">
            </div>
            <div class="gallery-box">
                <img src="MemberImage/3d-illustration-people-working-marketing_23-2150417378.avif" alt="Gallery Image">
            </div>
        </div>
    </section>

    <footer>
        <div class="footer">
            <div class="footer-logo">
                <h2>SMC</h2>
                <p>Social Media Campaigns</p>
                <span>You are here (Home) </span>
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