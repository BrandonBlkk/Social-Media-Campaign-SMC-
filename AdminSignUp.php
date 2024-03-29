<?php
include("dbconnection.php");
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
                            <label for="adminname">Admin Name </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" class="input" name="adminname" id="adminname" placeholder="Enter your name" required>
                        </div>
                        <div iv class="flex-column">
                            <label for="adminemail">Admin Email </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-at"></i>
                            <input type="email" class="input" name="adminemail" id="adminemail" placeholder="Enter your email" required>
                        </div>
                        <div iv class="flex-column">
                            <label for="adminpassword">Admin Password </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" class="input" name="adminpassword" id="adminpassword" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <div class="row2">
                        <div iv class="flex-column">
                            <label for="adminphone">Admin Phone </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-phone"></i>
                            <input type="tel" class="input" name="adminphone" id="adminphone" pattern="09-[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="09-963-000-000" required>
                        </div>
                        <div iv class="flex-column">
                            <label for="adminposition">Admin Position </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-solid fa-crosshairs"></i>
                            <input type="text" class="input" name="adminposition" id="adminposition" placeholder="Enter your position" required>
                        </div>
                        <div iv class="flex-column">
                            <label for="adminsignupdate">Admin SignUp Date </label>
                        </div>
                        <div class="inputForm">
                            <i class="fa-regular fa-calendar-days"></i>
                            <input type="date" class="input" name="adminsignupdate" id="adminsignupdate" value="<?php echo date("Y-m-d") ?>">
                        </div>
                    </div>
                </div>
                <input class="button-submit" type="submit" name="signup" value="Sign Up"></input>
                <p class="p">Have an account? <span class="span"><a href="AdminLogIn.php">Log In</a></span></p>
            </div>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST["signup"])) {

    // Retrieving user input from a form submitted via the POST method
    $userName = $_POST["username"];
    $adminName = $_POST["adminname"];
    $adminEmail = $_POST["adminemail"];
    $adminPassword = $_POST["adminpassword"];
    $adminPhone = $_POST["adminphone"];
    $adminPosition = $_POST["adminposition"];
    $adminSignUpDate = $_POST["adminsignupdate"];


    // Password Format
    $number = preg_match('@[0-9]@', $adminPassword);
    $upperLetter = preg_match('@[A-Z]@', $adminPassword);
    $lowerLetter = preg_match('@[a-z]@', $adminPassword);
    $specialChar = preg_match('@[^\w]@', $adminPassword);

    // Email Check
    $adminAccountCheck = "SELECT * FROM admintb 
        WHERE AdminEmail = '$adminEmail' 
        AND AdminPassword = '$adminPassword'";

    $adminQuery = mysqli_query($connect, $adminAccountCheck);
    $adminRow = mysqli_num_rows($adminQuery);

    // Check is there any same account in database
    if ($adminRow > 0) {
        echo "<script>window.alert('Administrator email already exists.')</script>";
        echo "<script>window.location = 'adminsignup.php'</script>";
    }
    // Check acccount password length
    elseif (strlen($adminPassword) <= 8 || !$number || !$upperLetter || !$lowerLetter || !$specialChar) {
        echo "<script>window.alert('Please ensure that your password is at least 8 characters long and includes a combination of numbers, uppercase and lowercase letters, as well as special characters.')</script>";
        echo "<script>window.location = 'adminsignup.php'</script>";
    } else {
        $adminInsertData = "INSERT INTO admintb(UserName, AdminName, AdminEmail, AdminPassword, AdminPhoneNo, AdminPosition,AdminSignUpDate, AdminStatus)
            VALUES('$userName', '$adminName', '$adminEmail', '$adminPassword', '$adminPhone', '$adminPosition', '$adminSignUpDate', 'Active')";

        $inserted = mysqli_query($connect, $adminInsertData);

        if ($inserted) {
            echo "<script>window.alert('Administrator account registration successful.')</script>";
            echo "<script>window.location = 'adminsignup.php'</script>";
        }
    }
}
?>