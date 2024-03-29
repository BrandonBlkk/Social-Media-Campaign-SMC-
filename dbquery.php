<?php
include("dbconnection.php");

// $admin = "CREATE TABLE admintb
// (
//     AdminID int not null primary key auto_increment,
//     UserName varchar(30),
//     AdminName varchar(30),
//     AdminEmail varchar(30),
//     AdminPassword varchar(30),
//     AdminPhoneNo varchar(30),
//     AdminPosition varchar(30),
//     AdminSignUpDate varchar(30),
//     AdminStatus varchar(30)
// )";

// try {
//     $query = mysqli_query($connect, $admin);
//     echo "Data Successfully saved";
// }
// catch(mysqli_sql_exception) {
//     echo "Data has been saved";
// }

// $campaigntype = "CREATE TABLE campaigntypetb
// (
//     CampaignTypeID int NOT NULL Primary Key Auto_Increment,
//     CampaignTypeName varchar(30)
// )";

// try {
//     $query = mysqli_query($connect, $campaigntype);
//     echo "Data Successfully saved";
// } catch (mysqli_sql_exception) {
//     echo "Data has been saved";
// }

// $mediaapp = "CREATE TABLE mediaapptb
// (
//     MediaAppID int NOT NULL Primary Key Auto_Increment,
//     MediaAppName varchar(30),
//     MediaAppImage varchar(255),
//     Rating int,
//     Platform varchar(30),
//     Developer varchar(30),
//     Technique text,
//     TechniqueStatus varchar(30)
// )";

// try {
//     $query = mysqli_query($connect, $mediaapp);
//     echo "Data Successfully saved";
// }
// catch(mysqli_sql_exception) {
//     echo "Data has been saved";
// }

// $campaign = "CREATE TABLE campaigntb
// (
//     CampaignID int NOT NULL Primary Key Auto_Increment,
//     MediaAppID int,
//     CampaignTypeID int,
//     CampaignName varchar(30),
//     CampaignDescription varchar(255),
//     CampaignImage1 varchar(255),
//     CampaignImage2 varchar(255),
//     CampaignImage3 varchar(255),
//     CampaignImage4 varchar(255),
//     CampaignFees int,
//     CampaignLocation text,
//     CampaignStartDate varchar(30),
//     CampaignEndDate varchar(30),
//     CampaignAim text,
//     CampaignVision text,
//     CampaignStatus varchar(30),
//     FOREIGN KEY (MediaAppID) REFERENCES mediaapptb (MediaAppID),
//     FOREIGN KEY (CampaignTypeID) REFERENCES campaigntypetb (CampaignTypeID)
// )";

// try {
//     $query = mysqli_query($connect, $campaign);
//     echo "Data Successfully saved";
// } catch (mysqli_sql_exception) {
//     echo "Data has been saved";
// }

// $parentcomment = "CREATE TABLE parentcommenttb
//     (
//         CommentID int NOT NULL Primary Key Auto_Increment,
//         MemberID int,
//         Comment text,
//         CommentDate varchar(30),
//         UserName varchar(30), 
//         MemberEmail varchar(30),
//         MemberProfile varchar(255),
//         FOREIGN KEY (MemberID) REFERENCES membertb (MemberID)
//     )";

// try {
//     $query = mysqli_query($connect, $parentcomment);
//     echo "Data Successfully saved";
// } catch (mysqli_sql_exception) {
//     echo "Data has been saved";
// }

// $member = "CREATE TABLE membertb
// (
//     MemberID int not null primary key auto_increment,
//     UserName varchar(30),
//     FirstName varchar(30),
//     SurName varchar(30),
//     MemberEmail varchar(30),
//     MemberPassword varchar(30),
//     MemberPhoneNo varchar(30),
//     SignUpDate varchar(30),
//     SignUpMonth varchar(30),
//     MemberProfile varchar(255),
//     MemberStatus varchar(30)
// )";

// try {
//     $query = mysqli_query($connect, $member);
//     echo "Data Successfully saved";
// } catch (mysqli_sql_exception) {
//     echo "Data has been saved";
// }

// $join = "CREATE TABLE jointb
// (
//     JoinID int not null primary key auto_increment,
//     JoinDate varchar(30),
//     JoinQty int,
//     TotalAmount int,
//     Description varchar(30),
//     JoinStatus varchar(30),
//     MemberEmail varchar(30),
//     MemberPhoneNo varchar(30),
//     PaymentType varchar(30),
//     MemberID int,
//     CampaignID int,
//     FOREIGN KEY (MemberID) REFERENCES membertb (MemberID),
//     FOREIGN KEY (CampaignID) REFERENCES campaigntb (CampaignID)
// )";

// try {
//     $query = mysqli_query($connect, $join);
//     echo "Data Successfully saved";
// } catch (mysqli_sql_exception) {
//     echo "Data has been saved";
// }

// $contact = "CREATE TABLE contacttb
// (
//     ContactID int NOT NULL Primary Key Auto_Increment,
//     ContactEmail varchar(30), 
//     MemberPhone varchar(30),
//     MemberMessage varchar(255)
// )";

// try {
//     $query = mysqli_query($connect, $contact);
//     echo "Data Successfully saved";
// } catch (mysqli_sql_exception) {
//     echo "Data has been saved";
// }
