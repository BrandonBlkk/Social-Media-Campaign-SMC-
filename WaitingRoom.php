<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Campaigns (SMC)</title>
    <link rel="stylesheet" href="MemberStyle.css">
</head>

<body>
    <section class="waiting-section">
        <div class="waiting-title">
            <h1>Hang Tight</h1>
            <h2>Your're now in a virtual queue</h2>
            <p>You are now placed in a virtual queue and will be redirected to our site shortly.</p>
        </div>
        <div class="waiting-img">
            <img src="MemberImage/travelers-with-suitcases-semi-flat-color-character-editable-full-body-people-sitting-on-wooden-bench-and-waiting-on-white-simple-cartoon-spot-illustration-for-web-graphic-d.jpg" alt="Waiting Image">
        </div>
        <p id="time"><span>Your estimated waiting time is: </span><span id="countdown">10:00</span> minutes</p>
        <p id="alert">DO NOT EXIT PAGE</p>
        <div class="condown-container">
            <div id="countdown-line">
                <p class="countdown-line"></p>
            </div>
        </div>

        <script type="text/javascript">
            var totalSeconds = 600; // 10 minutes = 600 seconds

            function updateCountdown() {
                var minutes = Math.floor(totalSeconds / 60);
                var seconds = totalSeconds % 60;

                // Format minutes and seconds with leading zeros if needed
                var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
                var formattedSeconds = seconds < 10 ? "0" + seconds : seconds;

                document.getElementById("countdown").textContent = formattedMinutes + ":" + formattedSeconds;
                totalSeconds--;

                if (totalSeconds < 0) {
                    window.location.href = "MemberLogin.php";
                }
            }

            setInterval(updateCountdown, 1000);
        </script>
    </section>
</body>

</html>