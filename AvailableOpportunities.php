<!doctype html>

<html>

<head>
   <!--   
         Exercise 02_09_01
         Author: Tabitha Siclovan
         Date: November 15, 2018
        
         AvailableOpportunities.php
    -->
    <title>Available Opportunities</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>College Internship</h1>
    <h2>Available Opportunities</h2>
    <?php
    //Request used when various pages (get/post does not matter)
    if (isset($_REQUEST['internID'])) {
        $internID = $_REQUEST['internID'];
    }
    else {
       $internID = -1;
    }
    //debug
    echo "\$internID: $internID\n";
     //Errors variable to control the flow
    $errors = 0;
    //Connect to database variable needed
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "after-water-49";
    $DBConnect = false;
    $DBName = "internships2";
    //Opening database connection
    //Make it scallable, maintainability
    if ($errors == 0) {
        //Only do a connection if generated no errors in validation
        $DBConnect = mysqli_connect($hostname, $username, $passwd);
        if (!$DBConnect) {
            ++$errors;
            echo "<p>Unable to connect to the database server" .
                " error code: " . mysqli_connect_error() . "</p>\n";
        }
        //Select the database
        else {
            $result =  mysqli_select_db($DBConnect, $DBName);
            if (!$result) {
                //generates error if cannot select database
                ++$errors;
                echo "<p>Unable to select the database" .
                " \"$DBName\" error code: " . 
                mysqli_error($DBConnect) . "</p>\n";
            }
        }
    }
    $TableName = "interns";
    if ($errors == 0) {
        $SQLstring = "SELECT * FROM $TableName" . 
            " WHERE internID='$internID'";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (!$queryResult) {
            ++$errors;
            echo "<p>Unable to execute the query, error code: " . 
                mysqli_errno($DBConnect) . ": " . 
                mysqli_error($DBConnect) . "</p>\n";
        }
    }
    //Close database connection
    if ($DBConnect) {
        echo "<p>Closing database connection.</p>\n";
        mysqli_close($DBConnect);
    }
    ?>
</body>

</html>
