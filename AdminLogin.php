<?php
session_start();
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
    <div class="login-form-wrapper">
        <form class="login-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <h1>SMC</h1>
            <div class="flex-column">
                <label for="adminemail">Email </label>
            </div>
            <div class="inputForm">
                <i class="fa-solid fa-at"></i>
                <input type="text" class="input" name="adminemail" id="adminemail" placeholder="Enter your Email" required>
            </div>
            <div class="flex-column">
                <label for="adminpassword">Password </label>
            </div>
            <div class="inputForm">
                <i class="fa-solid fa-lock"></i>
                <input type="password" class="input" name="adminpassword" id="adminpassword" placeholder="Enter your Password" required>
            </div>
            <input class="button-submit" type="submit" name="signin" value="Log In"></input>
            <p class="p">Don't have an account? <span class="span"><a href="AdminSignUp.php">Sign Up</a></span></p>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_POST["signin"])) {
    $adminEmail = $_POST["adminemail"];
    $adminPassword = $_POST["adminpassword"];

    $selectemailpassword = "SELECT * FROM admintb 
        WHERE AdminEmail = '$adminEmail' 
        AND AdminPassword = '$adminPassword'";

    $query = mysqli_query($connect, $selectemailpassword);
    $rowcount = mysqli_num_rows($query);
    // Check admin account match with signup account
    if ($rowcount > 0) {
        $array = mysqli_fetch_array($query);
        $adminId = $array["AdminID"];
        $userName = $array["UserName"];
        $adminName = $array["AdminName"];
        $adminEmail = $array["AdminEmail"];
        $adminPosition = $array["AdminPosition"];


        $_SESSION["AdminID"] = $adminId;
        $_SESSION["AdminUserName"] = $userName;
        $_SESSION["AdminName"] = $adminName;
        $_SESSION["AdminEmail"] = $adminEmail;
        $_SESSION["AdminPosition"] = $adminPosition;

        echo "<script>window.alert('Administrator login successful.')</script>";
        echo "<script>window.location = 'AdminDashBoard.php'</script>";
    } else {
        echo "<script>window.alert('Administrator login fail.')</script>";
        echo "<script>window.location = 'AdminLogin.php'</script>";
    }
}
?>