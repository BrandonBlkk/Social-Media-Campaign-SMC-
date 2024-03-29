<?xml version="1.0" encoding="UTF-8"?>

<rss version='2.0'>
<channel>
    <title>Social Media Campaign (SMC)</title>

<?php
    include("dbconnection.php");
    header('Content-Type: text/xml');

$feed = "SELECT * FROM rssfeed ORDER BY RssFeedID desc";
$feequery = mysqli_query($connect, $feed);

$numrow = mysqli_num_rows($feequery);

for ($i = 0; $i < $numrow; $i++) {
    $row = mysqli_fetch_array($feequery);

    echo "<item>";

    echo "<title>".$row['PageTitle']."</title>";
    echo "<pagedescription>".$row['PageDescription']."</pagedescription>";
    echo "<pageurl>".$row['PageUrl']."</pageurl>";

    echo "</item>";
}
?>
</channel>
</rss>


