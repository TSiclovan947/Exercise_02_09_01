<?php
session_start();
$body = "";
$errors = 0;
$conferenceID = 0;
//if (isset($_GET['internID'])) {
//    $internID = $_GET['internID'];
//}
if (!isset($_SESSION['conferenceID'])) {
   ++$errors;
    $body .= "<p>Log In Again." . 
        " Please return to the " . 
        " <a href='Index2.php'>" . 
        "Registration / Login Page</a></p>\n";
    $body .= "To see the Seminars Again retun to the " .
        " <a href='AvailableSeminars.php'>" . 
        "Available Seminars page.</a></p>\n";
}
if ($errors == 0) {
    if (isset($_GET['conferenceID'])) {
        $conferenceID = $_GET['conferenceID'];
    }
    else {
       ++$errors;
        $body .= "<p>You have not selected an opportunity." . 
            " Please return to the " . 
            " <a href='AvailableSeminars.php?" . "PHPSESSID=" . session_id() . "'>" . 
            "Seminars Page</a></p>\n";
    }   
}
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "after-water-49";
    $DBConnect = false;
    $DBName = "conference2";
    $TableName = "profconf";
    if ($errors == 0) {
        $DBConnect = mysqli_connect($hostname, $username,
        $passwd);
        if (!$DBConnect) {
            ++$errors;
            $body .= "<p>Unable to connect to the database server" .
                " error code: " . mysqli_connect_error() . 
                "</p>\n";
        }
        else {
            $result = mysqli_select_db($DBConnect, $DBName);
            if (!$result) {
            ++$errors;
            $body .= "<p>Unable to select the database" .
                " \"$DBName\" error code: " . 
                mysqli_error($DBConnect) . 
                "</p>\n";               
            }
        }
    }
$displayDate = date("l, F j, Y, g:i A");
$body .= "displayDate: $displayDate<br>";
$dbDate = date("Y-m-d H:i:s");
$body .= "\$dbDate: $dbDate<br>";

if ($DBConnect) {
        $body .= "<p>Closing database connection.</p>\n";
        mysqli_close($DBConnect);     
    }

//else {
//    $body .= "<p>Please " .
//        "<a href='Index2.php'>" . 
//        "Register or Log In" .
//        "</a> to use this page.</p>\n";
//}
if ($errors == 0) {
    $body .= "Setting cookie<br>";
    setcookie("LastRequestDate",
             urlencode($displayDate),
             time()+60*60*24*7);
}
?>
<!doctype html>
<html>

<head>
<!--   
         Exercise 02_09_05
         Author: Tabitha Siclovan
         Date: December 07, 2018
        
         SubmittedData.php
    -->
    <title>Submitted Data</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="inital-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body style="text-align:center;background-color:rgb(219, 224, 246)">
    <h1>Professional Conference</h1>
    <hr>
    <h2>Submitted Information</h2>
    <?php
    echo $body;
    echo "<p><strong><em>Company Name:</em></strong></p>";
   echo isset($_POST['text']);
   echo "<p><strong><em>Company Email:</em></strong></p>";
   echo isset($_POST['email']);
   echo "<p><strong><em>Company Number:</em></strong></p>\n";
   echo isset($_POST['phoneNumber']);
    echo "<p><strong><em>Your First Selected Seminar:</em></strong></p>";
   echo isset($_POST['option1']);
   echo "<p><strong><em>Your Second Selected Seminar:</em></strong></p>";
   echo isset($_POST['option2']);
   echo "<p><strong><em>Your Third Selected Seminar:</em></strong></p>\n";
   echo isset($_POST['option3']);
    echo "<hr>";
    echo "<h3>Thank You for signing up for the Conference. Remember the date: January 11, 2018!</h3>\n";
    echo "<h3>A reminder will be sent to your email to remind you of the important date.</h3>\n";
    echo "<h3>We cannot wait to see you there!</h3>\n";
    ?>
</body>

</html>