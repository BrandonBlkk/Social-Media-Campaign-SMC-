<?php
session_start();
include("dbconnection.php");

if (isset($_POST["signup"])) {
    $userName = $_POST["username"];
    $firstName = $_POST["firstname"];
    $surName = $_POST["surname"];
    $memberEmail = $_POST["memberemail"];
    $memberPassword = $_POST["memberpassword"];
    $memberPhone = $_POST["memberphone"];
    $memberSignUpDate = $_POST["membersignupdate"];
    $memberSignUpMonth = $_POST["membersignupmonth"];

    // Password Format

    $number = preg_match('@[0-9]@', $memberPassword);
    $upperLetter = preg_match('@[A-Z]@', $memberPassword);
    $lowerLetter = preg_match('@[a-z]@', $memberPassword);
    $specialChar = preg_match('@[^\w]@', $memberPassword);

    // Customer image upload 

    $memberProfile = $_FILES["memberprofile"]["name"];
    $copyFile = "MemberImage/";
    $fileName = $copyFile . uniqid() . "_" . $memberProfile;
    $copy = copy($_FILES["memberprofile"]["tmp_name"], $fileName);

    if (!$copy) {
        echo "<p>Cannot upload Profile Image.</p>";
        exit();
    }
    $checkUserName = "SELECT * FROM membertb
    WHERE UserName = '$userName'";

    $query = mysqli_query($connect, $checkUserName);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        echo "<script>window.alert('Username already exists.')</script>";
        echo "<script>window.location = 'MemberSignUp.php'</script>";
    } elseif (strlen($memberPassword) <= 8 || !$number || !$upperLetter || !$lowerLetter || !$specialChar) {
        echo "<script>window.alert('Password lenght must include 8 characters, number, upperletter, lowerletter and specialchar.')</script>";
        echo "<script>window.location = 'customersignup.php'</script>";
    } else {
        $insert = "INSERT INTO membertb(UserName, FirstName, SurName, MemberEmail,	MemberPassword,	MemberPhoneNo, SignUpDate, SignUpMonth, MemberProfile, MemberStatus)
            VALUES('$userName', '$firstName', '$surName', '$memberEmail', '$memberPassword', '$memberPhone', '$memberSignUpDate', '$memberSignUpMonth', '$fileName', 'Active')";

        $insertQuery = mysqli_query($connect, $insert);

        if ($insertQuery) {
            echo "<script>window.alert('Member account has been successfully registered.')</script>";
            echo "<script>window.location = 'MemberSignUp.php'</script>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="MemberStyle.css">
</head>

<body class="customer-body">
    <div class="signup-form-wrapper">
        <form class="signup-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
            <div class="main-row">
                <h1>SMC</h1>
                <div class="box">
                    <div class="row1">
                        <div class="flex-column">
                            <label for="username">Username </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" class="input" name="username" id="username" placeholder="Enter your Username" required>
                        </div>
                        <div class="flex-column">
                            <label for="firstname">First Name </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" class="input" name="firstname" id="firstname" placeholder="Enter your FirstName" required>
                        </div>
                        <div class="flex-column">
                            <label for="surname">SurName </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" class="input" name="surname" id="surname" placeholder="Enter your SurName" required>
                        </div>
                        <div class="flex-column">
                            <label for="memberemail">Email </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-at"></i>
                            <input type="email" class="input" name="memberemail" id="memberemail" placeholder="Enter your Email" required>
                        </div>
                        <div class="flex-column">
                            <label for="memberprofile">Profile </label>
                        </div>
                        <div class="inputForm">
                            <input type="file" name="memberprofile" id="memberprofile" required><br>
                        </div>
                    </div>
                    <div class="row2">
                        <div class="flex-column">
                            <label for="memberpassword">Password </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" class="input" name="memberpassword" id="memberpassword" placeholder="Enter your Password" required>
                        </div>
                        <div class="flex-column">
                            <label for="memberphone">Phone </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-phone"></i>
                            <input type="tel" class="input" name="memberphone" id="memberphone" pattern="09-[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="09-963-000-000" required>
                        </div>
                        <div class="flex-column">
                            <label for="membersignupdate">SignUp Date </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-regular fa-calendar-days"></i>
                            <input type="date" class="input" name="membersignupdate" id="membersignupdate" value="<?php echo date("Y-m-d") ?>" required>
                        </div>
                        <div class="flex-column">
                            <label for="membersignupmonth">SignUp Month </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-regular fa-calendar-days"></i>
                            <select name="membersignupmonth" id="membersignupmonth">
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="google-recaptcha">
                            <div class="g-recaptcha" data-sitekey="6LcE3G0pAAAAAE1GU9UXBq0POWnQ_1AMwyldy8lX">
                            </div>
                            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async defer></script>
                        </div>
                    </div>
                </div>
                <input class="button-submit" type="submit" name="signup" value="Sign Up"></input>
                <p class="p">Have an account? <span class="span"><a href="MemberLogIn.php">Log In</a></span></p>
        </form>
    </div>
</body>

</html>