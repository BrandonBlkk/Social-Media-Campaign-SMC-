<?php
session_start();
include("dbconnection.php");

if (isset($_GET["campaignID"])) {
    $campaignId = $_GET["campaignID"];

    $query = "SELECT * FROM campaigntb c, campaigntypetb ct, mediaapptb mp
        WHERE c.CampaignTypeID = ct.CampaignTypeID
        AND c.MediaAppID = mp.MediaAppID
        AND c.CampaignID = '$campaignId'";

    $result = mysqli_query($connect, $query);
    $array = mysqli_fetch_array($result);
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
    <div class="detail-form-container">
        <div class="detail-form">
            <div class="detail-close">
                <a href="Information.php"><i class="fa-solid fa-xmark"></i></a>
            </div>
            <div class="detail-img">
                <img src="<?php echo $array['CampaignImage1']; ?>" alt="Campaign Image">
            </div>
            <div class="detail-description">
                <h1><?php echo $array['CampaignName']; ?></h1>
                <div class="description-box">
                    <p><strong>Description: </strong><?php echo $array['CampaignDescription']; ?></p>
                    <p><strong>Aim: </strong><?php echo $array['CampaignAim']; ?></p>
                    <p><strong>Vision: </strong><?php echo $array['CampaignVision']; ?></p>
                </div>
                <div class="description-box">
                    <p><strong>Media App: </strong><?php echo $array['MediaAppName']; ?></p>
                </div>
                <div class="description-box2">
                    <div class="price-container">
                        <div class="price-box">
                            <h3>Price:</h3>
                            <div class="price">
                                <i class="fa-solid fa-dollar-sign" id="dollar"></i>
                                <p id="st-date"><?php echo $array['CampaignFees']; ?></p>
                            </div>
                        </div>
                        <div class="location-box">
                            <h3>Location:</h3>
                            <p id="st-date"><iframe src='<?php echo $array['CampaignLocation']; ?>'></iframe></p>
                        </div>
                    </div>
                    <div class="campaign-date-box">
                        <div class="start-box">
                            <i class="fa-regular fa-calendar"></i>
                            <p id="st-date"><?php echo $array['CampaignStartDate']; ?></p>
                        </div>
                        <div class="end-box">
                            <i class="fa-regular fa-calendar"></i>
                            <p id="ed-date"><?php echo $array['CampaignEndDate']; ?></p>
                        </div>
                        <p class="status-bg" id="ed-date"><?php echo $array['CampaignStatus']; ?></p>
                        <a href="Join.php?campaignID=<?php echo $array["CampaignID"] ?>">Join</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>