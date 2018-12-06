<!doctype html> 
 
<html> 
 
<head> 
   <!--    
         Exercise 02_09_05 
         Author: Tabitha Siclovan 
         Date: December 05, 2018 
         
         ConferenceLogin.php 
    --> 
    <title>Conference Login</title> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="initial-scale=1.0"> 
    <script src="modernizr.custom.65897.js"></script> 
</head> 
 
<body> 
    <h1>Professional Conference</h1> 
    <h2>Conference Login</h2> 
    <?php 
    //Errors variable to control the flow 
    $errors = 0; 
    //Connect to database variable needed 
    $hostname = "localhost"; 
    $username = "adminer"; 
    $passwd = "after-water-49"; 
    $DBConnect = false; 
    $DBName = "conference2"; 
    $TableName = "profconf"; 
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
    //Query database (query a table)  
    if ($errors == 0) { 
        //Query string 
        //Filtered horizonatally 
        $SQLstring = "SELECT conferenceID, first, last FROM $TableName" . 
            " WHERE email='" . stripslashes($_POST['email']) . 
            "' AND password_md5='" . md5(stripslashes($_POST['password'])) . "'"; 
        $queryResult = mysqli_query($DBConnect, $SQLstring); 
        if (!$queryResult) { 
            ++$errors; 
            echo "<p>Query not executed, bad SQL syntax.</p>\n"; 
        } 
        if ($errors == 0) { 
            if (mysqli_num_rows($queryResult) == 0) { 
                ++$errors; 
                echo "<p>The email address/password combination entered is not valid.</p>\n"; 
            } 
            else { 
                //explode data into associative array 
                $row = mysqli_fetch_assoc($queryResult); 
                $conferenceID = $row['conferenceID']; 
                $registeredName = $row['first'] . " " . $row['last']; 
                mysqli_free_result($queryResult); 
                echo "<p>Welcome Back, $registeredName!</p>\n"; 
            } 
        } 
    } 
    //Close database connection 
    if ($DBConnect) { 
        echo "<p>Closing database connection.</p>\n"; 
        mysqli_close($DBConnect); 
    } 
    if ($errors == 0) { 
        //Hidden form field to pass data to next page in superglobal 
        echo "<form action='AvailableSeminars.php' " . "method='post'>\n"; 
        echo "<input type='hidden' name='conferenceID' value='$conferenceID'>\n"; 
        echo "<input type='submit' name='submit' value='View Available Seminars'>\n"; 
        echo "</form>\n"; 
    } 
    //If any errors in the script echoes this message 
    if ($errors > 0) { 
         echo "<p>Please use your browser's BACK button" .  
            " to return to the form and fix the errors" . 
            " indicated.</p>\n"; 
    } 
    ?> 
</body> 
 
</html> 