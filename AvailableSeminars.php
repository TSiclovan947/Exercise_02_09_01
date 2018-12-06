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
//    
//    //Request used when various pages (get/post does not matter) 
//    if (isset($_REQUEST['conferenceID'])) { 
//        $conferenceID = $_REQUEST['conferenceID']; 
//    } 
//    else { 
//       $conferenceID = -1; 
//    } 
//    //debug 
//    echo "\$conferenceID: $conferenceID\n"; 
//     //Errors variable to control the flow 
//    $errors = 0; 
//    //Connect to database variable needed 
//    $hostname = "localhost"; 
//    $username = "adminer"; 
//    $passwd = "after-water-49"; 
//    $DBConnect = false; 
//    $DBName = "conference2"; 
//     $DBConnect = mysqli_connect($hostname, $username, $passwd);
//    //Opening database connection 
//    //Make it scallable, maintainability 
//    if ($errors == 0) { 
//        //Only do a connection if generated no errors in validation 
//        $DBConnect = mysqli_connect($hostname, $username, $passwd); 
//        if (!$DBConnect) { 
//            ++$errors; 
//            echo "<p>Unable to connect to the database server" . 
//                " error code: " . mysqli_connect_error() . "</p>\n"; 
//        } 
//        //Select the database 
//        else { 
//            $result =  mysqli_select_db($DBConnect, $DBName); 
//            if (!$result) { 
//                //generates error if cannot select database 
//                ++$errors; 
//                echo "<p>Unable to select the database" . 
//                " \"$DBName\" error code: " .  
//                mysqli_error($DBConnect) . "</p>\n"; 
//            } 
//        } 
//    } 
//    
//    $TableName = "profconf"; 
//    if ($errors == 0) { 
//        $SQLstring = "SELECT * FROM $TableName" .  
//            " WHERE conferenceID='$conferenceID'"; 
//        $queryResult = mysqli_query($DBConnect, $SQLstring); 
//        if (!$queryResult) { 
//            ++$errors; 
//            echo "<p>Unable to execute the query, error code: " .  
//                mysqli_errno($DBConnect) . ": " .  
//                mysqli_error($DBConnect) . "</p>\n"; 
//        }
//        else {
//            if (mysqli_num_rows($queryResult) == 0) {
//                ++$errors;
//                echo "<p>Invalid Conference ID!</p>\n";
//            }
//        }
//    } 
//    if ($errors == 0) {
//        $row = mysqli_fetch_assoc($queryResult);
//        $registeredName = $row['first'] . " " . $row['last'];
//    }
//    else {
//        $registeredName = "";
//    }
//    echo "\$registeredName: $registeredName";
//    $TableName = "assigned_seminars";
//    if ($errors == 0) {
//        $SQLstring = "SELECT count(seminarID)" .
//            " FROM $TableName" . 
//            " WHERE conferenceID='$conferenceID'" . 
//            " AND dateApproved IS NOT NULL";
//        $queryResult = mysqli_query($DBConnect, $SQLstring);
//        if (mysqli_num_rows($queryResult) > 0) {
//            $row = mysqli_fetch_row($queryResult);
//            $approvedSeminars = $row[0];
//            mysqli_free_result($queryResult);
//        }
//    }
//    if ($errors == 0) {
//        $selectedSeminars = array();
//        $SQLstring = "SELECT seminarID FROM $TableName" . 
//            " WHERE conferenceID='$conferenceID'";
//        $queryResult = mysqli_query($DBConnect, $SQLstring);
//        if (mysqli_num_rows($queryResult) > 0) {
//            while (($row = mysqli_fetch_row($queryResult)) != false) {
//                $selectedSeminars[] = $row[0];
//            }
//            mysqli_free_result($queryResult);
//        }
//        $assignedSeminars = array();
//        $SQLstring = "SELECT seminarID FROM $TableName" . 
//            " WHERE dateApproved IS NOT NULL";
//        $queryResult = mysqli_query($DBConnect, $SQLstring);
//        if (mysqli_num_rows($queryResult) > 0) {
//            while (($row = mysqli_fetch_row($queryResult)) != false) {
//                $assignedSeminars[] = $row[0];
//            }
//            mysqli_free_result($queryResult);
//        }
//    }
//    
//    $TableName = "seminars";
//    $seminars = array();
//    if ($errors == 0) {
//        $SQLstring = "SELECT seminarID, company, city," . 
//            " startDate, endDate, position, description" . 
//            " FROM $TableName";
//        $queryResult = mysqli_query($DBConnect, $SQLstring);
//        if (mysqli_num_rows($queryResult) > 0) {
//            while (($row = mysqli_fetch_assoc($queryResult)) != 
//            false) {
//                $opportunities[] = $row;
//            }
//            mysqli_free_result($queryResult);
//        }
//    }
//    if ($DBConnect) {
//        echo "<p>Closing database connection.</p>\n";
//        mysqli_close($DBConnect);     
//    }
//    echo "<table border='1' width='100%'>\n";
//    echo "<tr>\n";
//    echo "<th style='background-color: cyan'>Company</th>\n";
//    echo "<th style='background-color: cyan'>City</th>\n";
//    echo "<th style='background-color: cyan'>Start Date</th>\n";
//    echo "<th style='background-color: cyan'>End Date</th>\n";
//    echo "<th style='background-color: cyan'>Position</th>\n";
//    echo "<th style='background-color: cyan'>Description</th>\n";
//    echo "<th style='background-color: cyan'>Status</th>\n";
//    echo "</tr>\n";
//    foreach ($opportunities as $opportunity) {
//        if (!in_array($opportunity['opportunityID'], $assignedSeminars)) {
//            echo "<tr>\n";
//            echo "<td>" . htmlentities($opportunity['company']) . "</td>\n";
//            echo "<td>" . htmlentities($opportunity['city']) . "</td>\n";
//            echo "<td>" . htmlentities($opportunity['startDate']) . "</td>\n";
//            echo "<td>" . htmlentities($opportunity['endDate']) . "</td>\n";
//            echo "<td>" . htmlentities($opportunity['position']) . "</td>\n";
//            echo "<td>" . htmlentities($opportunity['description']) . "</td>\n";
//            echo "<td>";
//            if (in_array($opportunity['opportunityID'], 
//            $selectedSeminars)) {
//                echo "Selected";
//            }
//            else if ($approvedSeminars) {
//                echo "Open";
//            }
//            else {
//                echo "<a href ='RequestOpportunity.php?" . 
//                    "internID=$internID&" . 
//                    "opportunityID=" . 
//                    $opportunity['opportunityID'] . 
//                    "'>Available</a>";
//            }
//            echo "</td>";
//            echo "</tr>\n";
//        }
//    }
//    echo "</table>\n";
//    echo "<p><a href='InternLogin.php'>Log Out</a></p>\n";
//    //Close database connection 
//    if ($DBConnect) { 
//        echo "<p>Closing database connection.</p>\n"; 
//        mysqli_close($DBConnect); 
//    } 
    ?> 
</body> 
 
</html> 