<?php
$body = "";
$errors = 0;
$internID = 0;
if (isset($_GET['internID'])) {
    $internID = $_GET['internID'];
}
else {
   ++$errors;
    $body .= "<p>You have not logged in or registered." . 
        " Please return to the " . 
        " <a href='InternLogin.php'>" . 
        "Registration / Login Page</a></p>\n";
}
if ($errors == 0) {
    if (isset($_GET['opportunityID'])) {
        $opportunityID = $_GET['opportunityID'];
    }
    else {
       ++$errors;
        $body .= "<p>You have not selected an opportunity." . 
            " Please return to the " . 
            " <a href='AvailableOpportunities.php'>" . 
            "Opportunities Page</a></p>\n";
    }   
}
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "after-water-49";
    $DBConnect = false;
    $DBName = "internships2";
    $TableName = "interns";
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
$body .= "\displayDate: $displayDate<br>";
$dbDate = date("Y-m-d H:i:s");
$body .= "\$dbDate: $dbDate<br>";
if ($errors == 0) {
    $TableName = "assigned_opportunities";
    $SQLstring = "INSERT INTO $TableName" . 
        "(opportunityID, internID, dateSelected)" . 
        " VALUES($opportunityID, $internID, '$dbDate')";
    $queryResult = mysqli_query($DBConnect, $SQLstring);
    if (!$queryResult) {
        ++$errors;
        $body .= "<p>Unable to execute the query, " . 
            "error code: " . mysqli_errno($DBConnect) . ": " .
            mysqli_error($DBConnect) . "</p>\n";
    }
    else {
        $body .= "<p>Your results for opportunity #" . 
            " $opportunityID have been entered on" . 
            " $displayDate.</p>\n";
    }
}
if ($DBConnect) {
        $body .= "<p>Closing database connection.</p>\n";
        mysqli_close($DBConnect);     
    }
if ($internID > 0) {
    $body .= "<p>Return to the " .
        "<a href='AvailableOpportunities.php?" . 
        "internID=$internID'>Available Opportunities" .
        "</a> page.</p>\n";
}
else {
    $body .= "<p>Please " .
        "<a href='InternLogin.php'>" . 
        "Register or Log In" .
        "</a> to use this page.</p>\n";
}
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
         Exercise 02_09_01
         Author: Tabitha Siclovan
         Date: November 28, 2018
        
         RequestOpportunities.php
    -->
    <title>Request Opportunity</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="inital-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>College Internship</h1>
    <h2>Opportunity Requested</h2>
    <?php
    echo $body;
    ?>
</body>

</html>