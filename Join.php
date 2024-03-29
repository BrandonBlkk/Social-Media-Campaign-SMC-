<?php
session_start();
include("dbconnection.php");

if (!isset($_SESSION["MemberID"])) {
    echo "<script>window.alert('Please login to join our campaigns.')</script>";
    echo "<script>window.location = 'MemberLogin.php'</script>";
}

if (isset($_GET['campaignID'])) {
    $campaignID = $_GET['campaignID'];

    $query = "SELECT * FROM campaigntb
        WHERE CampaignID = $campaignID";

    $selectQuery = mysqli_query($connect, $query);
    $data = mysqli_fetch_array($selectQuery);

    $campaignid = $data['CampaignID'];
    $campaignname = $data['CampaignName'];
    $campaigndescription = $data['CampaignDescription'];
    $campaignstartdate = $data['CampaignStartDate'];
    $campaignenddate = $data['CampaignEndDate'];
    $campaignfees = $data['CampaignFees'];
    // Session passes from member login
    $sessionmemberemail = $_SESSION["MemberEmail"];
    $sessionmemberphone = $_SESSION["MemberPhoneNo"];
}

if (isset($_POST['save'])) {
    $joindate = $_POST['joindate'];
    $quantity = $_POST['joinqty'];
    $campaignfees = $_POST['campaignfees'];
    $total = $quantity * $campaignfees;
    $joinqty = $_POST['joinqty'];
    $description = $_POST['description'];
    $status = 'Pending';
    $memberemail = $_POST['memberemail'];
    $memberphone = $_POST['memberphone'];
    $payment = $_POST['payment'];
    $memberid = $_POST['memberid'];
    $campaignid = $_POST['campaignid'];
    // Session passes from member login
    $sessionmemberemail = $_SESSION["MemberEmail"];
    $sessionmemberphone = $_SESSION["MemberPhoneNo"];

    if ($memberemail === $sessionmemberemail && $memberphone === $sessionmemberphone) {

        $insert = "INSERT INTO jointb (JoinDate, JoinQty, TotalAmount, Description, JoinStatus, MemberEmail, MemberPhoneNo, PaymentType, MemberID, CampaignID)
    VALUES ('$joindate', '$joinqty', '$total', '$description', '$status', '$memberemail', '$memberphone', '$payment', '$memberid', '$campaignid')";

        $insertQuery = mysqli_query($connect, $insert);

        if ($insertQuery) {
            echo "<script>window.alert('Successfully. Your total amount is $total.')</script>";
            echo "<script>window.location = 'Information.php'</script>";
        } else {
            echo "<script>window.alert('Something went worng.')</script>";
            echo "<script>window.location = 'Join.php'</script>";
        }
    } else {
        // If $memberemail doesn't match $_SESSION["MemberEmail"], redirect back to the form page
        echo "<script>window.alert('Email does not match. Please confirm your email.')</script>";
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="MemberStyle.css">
</head>

<body id="join-body">
    <section class="join-form-section">
        <form class="join-form" id="join-form" action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <h1>Payment Form</h1>
            <div class="join-alert">
                <!-- <input type="submit" name="save" value="Proceed to payment &rarr;"> -->
                <?php

                if ($data["CampaignStatus"] === 'Upcoming') {
                    echo '<p>This campaign is not available right now!</p>';
                } elseif ($data["CampaignStatus"] === 'Unavaliable') {
                    echo '<p>This campaign is not available right now!</p>';
                } else {
                    echo '<input type="submit" name="save" value="Proceed to payment &rarr;" hidden>';
                }

                ?>
            </div>
            <div class="campaign-display">
                <h2>Checkout</h2>
                <input type="hidden" name="campaignid" value="<?php echo $campaignID ?>">
                <label for="campaignname">CampaignName</label>
                <input type="text" value="<?php echo $campaignname ?>" readonly>
                <label for="campaignfees">Fees Per Person</label>
                <input type="text" name="campaignfees" value="<?php echo $campaignfees ?>" readonly>
                <div class="campaign-display-box1">
                    <label for="startdate">Start Date</label>
                    <input type="text" value="<?php echo $campaignstartdate ?>" readonly>
                    <label id="enddate" for="enddate">End Date</label>
                    <input type="text" value="<?php echo $campaignenddate ?>" readonly>
                </div>
            </div>

            <div class="join-box1">
                <div class="data-container">
                    <h2>Member Information</h2>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $sessionmemberemail ?>" readonly>
                    <label for=" phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="<?php echo $sessionmemberphone ?>" readonly>
                    <label for="joindate">Join Date</label>
                    <input type="text" name="joindate" id="joindate" value="<?php echo date("Y-m-d") ?>" readonly>
                    <label for="joinqty">Join Quantity</label>
                    <input type="number" name="joinqty" id="joinqty" min=1 max=5 required>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="3" required></textarea>
                </div>
                <div class="member-info">
                    <h2>Confirm Information</h2>
                    <input type="hidden" name="memberid" id="memberid" value="<?php echo $_SESSION['MemberID'] ?>" required>
                    <label for="memberemail">Email</label>
                    <input type="email" name="memberemail" id="memberemail" placeholder="Confirm your email" required>
                    <label for="memberphone">Phone</label>
                    <input type="tel" name="memberphone" id="memberphone" placeholder="Confirm your phone" required>
                </div>
            </div>

            <div class="payment-container" id="pay-con">
                <h2>Add Payment Method</h2>
                <div class="payment-option-container">
                    <div class="payment-option">
                        <input type="radio" name="payment" id="payment" value="Paypal" checked onclick="showPaymentTable()">
                        <img src="MemberImage/paypal (1).png" alt="Palpay">
                    </div>
                    <div class="payment-option">
                        <input type="radio" name="payment" id="payment" value="Visa" onclick="showPaymentTable()">
                        <img src="MemberImage/visa.png" alt="Visa">
                    </div>
                    <div class="payment-option">
                        <input type="radio" name="payment" id="payment" value="Cash" onclick="hidePaymentTable()">
                        <img src="MemberImage/dollar.png" alt="Cash">
                    </div>
                </div>

                <table id="paymenttable">
                    <tr>
                        <td>
                            <div class="paymenttable-box">
                                <label for="cardno">Card No</label>
                                <input type="text" name="cardno" pattern="\d{4}\s\d{4}\s\d{4}\s\d{4}" id="cardno" placeholder="**** **** **** 1060">
                            </div>
                            <div class="paymenttable-box">
                                <label for="cvc">CVC</label>
                                <input type="text" name="cvc" pattern="[0-9]{4}" id="cvc" placeholder="****">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="join-save-btn">
                <?php

                if ($data["CampaignStatus"] === 'Upcoming') {
                    echo '<input type="submit" name="save" value="Proceed to payment &rarr;" hidden>';
                } elseif ($data["CampaignStatus"] === 'Unavaliable') {
                    echo '<input type="submit" name="save" value="Proceed to payment &rarr;" hidden>';
                } else {
                    echo '<input type="submit" name="save" value="Proceed to payment &rarr;">';
                }

                ?>
            </div>
        </form>
    </section>

    <script type="text/javascript">
        function showPaymentTable() {
            document.getElementById('paymenttable').style.visibility = 'visible';
            document.getElementById('pay-con').style.height = '17%';
            document.getElementById('pay-con').style.height = '12.35em';
        }

        function hidePaymentTable() {
            document.getElementById('paymenttable').style.visibility = 'hidden';
            document.getElementById('pay-con').style.height = '10%';
            document.getElementById('pay-con').style.height = '6em';
        }
    </script>
</body>

</html>