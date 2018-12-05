<html> 
 
<head> 
   <!--    
         Exercise 02_09_01 
         Author: Tabitha Siclovan 
         Date: December 04, 2018 
         
         AvailableSeminars.php 
    --> 
    <title>Available Seminars</title> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="initial-scale=1.0"> 
    <script src="modernizr.custom.65897.js"></script> 
</head> 
 
<body> 
    <h1>Professional Conference</h1> 
    <h2>Available Seminars</h2> 
    <?php 
    
        if (!$DBConnect) {
            //Failure (doesn't connect)
            echo "<p>Connection Failed.</p>\n";
        }
        else {
            //Embed sql command into a string
            $sql = "CREATE DATABASE $DBName";
            //set a command
            if (mysqli_query($DBConnect, $sql)) {
                //Success
                echo "<p>Successfully created the \"$DBName\" database.</p>\n";
            }
            else {
                //Failure
                echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
            }
            mysqli_close($DBConnect);
        }
    //Request used when various pages (get/post does not matter) 
    if (isset($_REQUEST['conferenceID'])) { 
        $conferenceID = $_REQUEST['conferenceID']; 
    } 
    else { 
       $conferenceID = -1; 
    } 
    //debug 
    echo "\$conferenceID: $conferenceID\n"; 
     //Errors variable to control the flow 
    $errors = 0; 
    //Connect to database variable needed 
    $hostname = "localhost"; 
    $username = "adminer"; 
    $passwd = "after-water-49"; 
    $DBConnect = false; 
    $DBName = "conferences2"; 
     $DBConnect = mysqli_connect($hostname, $username, $passwd);
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
    
    $TableName = "profconf"; 
    if ($errors == 0) { 
        $SQLstring = "SELECT * FROM $TableName" .  
            " WHERE conferenceID='$conferenceID'"; 
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