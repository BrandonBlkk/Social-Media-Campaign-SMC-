<?php
session_start();
include("dbconnection.php");

if (isset($_POST["login"])) {
    $memberEmail = $_POST["memberemail"];
    $memberPassword = $_POST["memberpassword"];

    $selectEmailPassword = "SELECT * FROM membertb 
        WHERE MemberEmail = '$memberEmail' 
        AND MemberPassword = '$memberPassword'";

    $query = mysqli_query($connect, $selectEmailPassword);
    $rowCount = mysqli_num_rows($query);

    // Check customer account match with signup account
    if ($rowCount > 0) {
        $array = mysqli_fetch_array($query);
        $memberId = $array["MemberID"];
        $memberUserName = $array["UserName"];
        $memberEmail = $array["MemberEmail"];
        $memberPassword = $array["MemberPassword"];
        $memberPhone = $array["MemberPhoneNo"];
        $memberProfile = $array["MemberProfile"];

        $_SESSION["MemberID"] = $memberId;
        $_SESSION["MemberUserName"] = $memberUserName;
        $_SESSION["MemberEmail"] = $memberEmail;
        $_SESSION["MemberPassword"] = $memberPassword;
        $_SESSION["MemberPhoneNo"] = $memberPhone;
        $_SESSION["MemberProfile"] = $memberProfile;

        setcookie('user', $memberUserName, time() + 10, "/");

        unset($_SESSION["logincount"]); // reset login attempts
        echo "<script>window.alert('Customer login successful.')</script>";
        echo "<script>window.location = 'MemberHome.php'</script>";
    } else {
        // Restrict member login attempts (max 3 times)
        if (isset($_SESSION["logincount"])) {
            $counterror = $_SESSION["logincount"];

            if ($counterror == 1) {
                echo "<script>window.alert('Member login fail. Attempt Two!')</script>";
                $_SESSION["logincount"] = 2;
            } elseif ($counterror == 2) {
                unset($_SESSION["logincount"]); // reset login attempts
                echo "<script>window.alert('Member login fail. Attempt Three!')</script>";
                echo "<script>window.location = 'WaitingRoom.php'</script>";
            }
        } else {
            echo "<script>window.alert('Member login fail.')</script>";
            $_SESSION["logincount"] = 1;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="MemberStyle.css">
</head>

<body class="customer-body">
    <div class="login-form-wrapper">
        <form class="login-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <h1>SMC</h1>
            <div class="flex-column">
                <label for="memberemail">Email </label>
            </div>
            <div class="inputForm">
                <i class="fa-solid fa-at"></i>
                <input type="email" class="input" name="memberemail" id="memberemail" placeholder="Enter your Email" required>
            </div>
            <div class="flex-column">
                <label for="memberpassword">Password </label>
            </div>
            <div class="inputForm">
                <i class="fa-solid fa-lock"></i>
                <input type="password" class="input" name="memberpassword" id="memberpassword" placeholder="Enter your Password" required>
            </div>
            <input class="button-submit" type="submit" name="login" value="Log In"></input>
            <p class="p">Don't have an account? <span class="span"><a href="MemberSignUp.php">Sign Up</a></span></p>
        </form>
    </div>
</body>

</html>