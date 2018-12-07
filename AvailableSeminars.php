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
    $DBName = "conference2"; 
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
        else {
            if (mysqli_num_rows($queryResult) == 0) {
                ++$errors;
                echo "<p>Invalid Conference ID!</p>\n";
            }
        }
    } 
    if ($errors == 0) {
        $row = mysqli_fetch_assoc($queryResult);
        $registeredName = $row['first'] . " " . $row['last'];
    }
    else {
        $registeredName = "";
    }
    echo "\$registeredName: $registeredName";
    $TableName = "assigned_seminars";
    if ($errors == 0) {
        $SQLstring = "SELECT count(seminarID)" .
            " FROM $TableName" . 
            " WHERE conferenceID='$conferenceID'" . 
            " AND dateApproved IS NOT NULL";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (mysqli_num_rows($queryResult) > 0) {
            $row = mysqli_fetch_row($queryResult);
            $approvedSeminars = $row[0];
            mysqli_free_result($queryResult);
        }
    }
    if ($errors == 0) {
        $selectedSeminars = array();
        $SQLstring = "SELECT seminarID FROM $TableName" . 
            " WHERE conferenceID='$conferenceID'";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (mysqli_num_rows($queryResult) > 0) {
            while (($row = mysqli_fetch_row($queryResult)) != false) {
                $selectedSeminars[] = $row[0];
            }
            mysqli_free_result($queryResult);
        }
        $assignedSeminars = array();
        $SQLstring = "SELECT seminarID FROM $TableName" . 
            " WHERE dateApproved IS NOT NULL";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (mysqli_num_rows($queryResult) > 0) {
            while (($row = mysqli_fetch_row($queryResult)) != false) {
                $assignedSeminars[] = $row[0];
            }
            mysqli_free_result($queryResult);
        }
    }
//    
//    $TableName = "seminars";
//    $seminars = array();
//    if ($errors == 0) {
//        $SQLstring = "SELECT seminarID, seminar, seminarDescription" . 
//            " FROM $TableName";
//        $queryResult = mysqli_query($DBConnect, $SQLstring);
//        if (mysqli_num_rows($queryResult) > 0) {
//            while (($row = mysqli_fetch_assoc($queryResult)) != 
//            false) {
//                $seminars[] = $row;
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
//    echo "<th style='background-color: cyan'>Seminar Name</th>\n";
//    echo "<th style='background-color: cyan'>Seminar Description</th>\n";
//    echo "<th style='background-color: cyan'>Status</th>\n";
//    echo "</tr>\n";
//    foreach ($seminars as $seminar) {
//        if (!in_array($seminar['seminarID'], $assignedSeminars)) {
//            echo "<tr>\n";
//            echo "<td>" . htmlentities($seminar['seminar']) . "</td>\n";
//            echo "<td>" . htmlentities($seminar['seminarDescription']) . "</td>\n";
//            echo "<td>";
//            if (in_array($seminar['seminarID'], 
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
    echo "<p><a href='Index2.php'>Log Out</a></p>\n";
    //Close database connection 
    if ($DBConnect) { 
        echo "<p>Closing database connection.</p>\n"; 
        mysqli_close($DBConnect); 
    } 
    ?> 
     <form action="SelectedSeminars.php?PHPSESSID=<?php echo session_id(); ?>" method="post">
       <h2>Choose Up To Three Seminars</h2>
       <p><strong><em>Create a Successful Business Description:</em></strong> Martha Keys, CEO of Keys Enterprises, shares her experience in creating a successful business.</p>
         <p><strong><em>The Age of Technology Description:</em></strong> Mac B. Stanton gives insight on today's new technology culture.</p>
         <p><strong><em>Be a Leader not a Follower Description:</em></strong> Make your own choices in life. Take initiative and be a leader. Develop leadership skills.</p>
         <p><strong><em>Experience the Different Food Cultures Description:</em></strong> Take a tour across the world through the art of food. Sample different foods and listen to culinary chefs from around the world. </p>
         <p><strong><em>Expand Your Business Description:</em></strong> George Hamilton shares how to take your business and expand it into a bigger and more successful business.</p>
         <p><strong><em>Know the Truth of Today Description:</em></strong> The government and large businesses often have secrets the people are not aware of. Learn the truth!</p>
         <p><strong><em>Become an Innovator Description:</em></strong> Create a product that will benefit all! Join us with Carl Senior and Jamie Stevonsan.</p>
        <p>
        First Seminar:
        <select name="option1">
         <option value="No Seminar Selected">No Seminar Selected</option>
          <option value="Create a Successful Business">Create a Successful Business</option>
          <option value="The Age of Technology">The Age of Technology</option>
          <option value="Be a Leader not a Follower">Be a Leader not a Follower</option>
          <option value="Experience the Different Food Cultures">Experience the Different Food Cultures</option>
          <option value="Expand Your Business">Expand Your Business</option>
          <option value="Know the Truth of Today">Know the Truth of Today</option>
          <option value="Become an Innovator">Become an Innovator</option>
        </select>
        </p>
        <p>
        Second Seminar:
        <select name="option2">
          <option value="No Seminar Selected">No Seminar Selected</option>
          <option value="Create a Successful Business">Create a Successful Business</option>
          <option value="The Age of Technology">The Age of Technology</option>
          <option value="Be a Leader not a Follower">Be a Leader not a Follower</option>
          <option value="Experience the Different Food Cultures">Experience the Different Food Cultures</option>
          <option value="Expand Your Business">Expand Your Business</option>
          <option value="Know the Truth of Today">Know the Truth of Today</option>
          <option value="Become an Innovator">Become an Innovator</option>
        </select>
        </p>
        <p>
        Third Seminar:
        <select name="option3">
          <option value="No Seminar Selected">No Seminar Selected</option>
          <option value="Create a Successful Business">Create a Successful Business</option>
          <option value="The Age of Technology">The Age of Technology</option>
          <option value="Be a Leader not a Follower">Be a Leader not a Follower</option>
          <option value="Experience the Different Food Cultures">Experience the Different Food Cultures</option>
          <option value="Expand Your Business">Expand Your Business</option>
          <option value="Know the Truth of Today">Know the Truth of Today</option>
          <option value="Become an Innovator">Become an Innovator</option>
        </select>
        </p>
        <input type="submit" name="submit" value="Submit Seminars">
    </form> 
</body> 
 
</html> 