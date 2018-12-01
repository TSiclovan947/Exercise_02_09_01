<?php
session_start();
?>
<!doctype html>
<html>

<head>
<!--   
         Exercise 02_09_01
         Author: Tabitha Siclovan
         Date: November 13, 2018
        
         VerifyLogin.php
    -->
    <title>Verify Intern Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="inital-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>College Internship</h1>
    <h2>Verify Intern Login</h2>
    <?php
    $errors = 0;
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
            echo "<p>Unable to connect to the database server" .
                " error code: " . mysqli_connect_error() . 
                "</p>\n";
        }
        else {
            $result = mysqli_select_db($DBConnect, $DBName);
            if (!$result) {
            ++$errors;
            echo "<p>Unable to select the database" .
                " \"$DBName\" error code: " . 
                mysqli_error($DBConnect) . 
                "</p>\n";               
            }
        }
    }
    if ($errors == 0) {
        $SQLstring = "SELECT internID, first, last FROM $TableName" . 
            " WHERE email='" . stripslashes($_POST['email']) . 
            "' AND password_md5='" . md5(stripslashes($_POST['password'])) . "'";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (!$queryResult) {
            ++$errors;
            echo "<p>Query not executed, bad SQL syntax.
            </p>\n";
        }
        if ($errors == 0) {
            if (mysqli_num_rows($queryResult) == 0) {
                ++$errors;
                echo "<p>The email address/password 
                combination entered is not valid.</p>\n";
            }
            else {
                $row = mysqli_fetch_assoc($queryResult);
//                $internID = $row['internID'];
                $_SESSION['internID'] = $row['internID'];
                $internName = $row['first'] . " " . 
                $row['last'];
                mysqli_free_result($queryResult);
                echo "<p>Welcome back, $internName!</p>\n";
            }
        }
    }
    if ($DBConnect) {
        echo "<p>Closing database connection.</p>\n";
        mysqli_close($DBConnect);     
    }
    if ($errors == 0) {
//        echo "<form action='AvailableOpportunities.php'" . 
//        " method='post'>\n";
//        echo "<input type='hidden' name='internID' 
//        value='$internID'>\n";
//        echo "<input type='submit' name='submit' 
//        value='View Available Opportunities'>\n";
//        echo "</form>\n";
//        echo "<p><a href='AvailableOpportunities.php?" . 
//            "internID=$internID'>Available Opportunities" . 
//            "</a></p>\n";
        echo "<p><a href='AvailableOpportunities.php?" . "PHPSESSID=" 
            . session_id() . "'>Available Opportunities" . "</a></p>\n";
    }
    if ($errors > 0) {
        echo "<p>Please use your browser's BACK button" . 
            " to return to the form and fix the errors" .
            " indicated.</p>\n";
    }
    ?>
</body>

</html>