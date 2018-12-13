<?php
    session_start();
    //$body =  "";
    $errors = 0;
    $email = "";
    if (empty($_POST['email'])) {
        ++$errors;
        //$body .= "<p>You need to enter an email address.</p>\n";
        echo "<p>You need to enter an email address!</p>\n"; 
    }
    else {
       $email = stripslashes($_POST['email']);
        if (preg_match("/^[\w-]+(\.[\w-])*@[\w-]+(\.[\w-]+)*(\.[A-Za-z]{2,})$/i", $email) == 0) {
            ++$errors;
//            $body .= "<p>You need to enter a vaild e-mail address.</p>\n";
//            $body .= "";
            //If email not in correct format 
            echo "<p>You need to enter a valid email address!</p>\n"; 
            //Returns empty because no errors is email correct 
            $email = ""; 
        }
    }
    if (empty($_POST['password'])) {
        ++$errors;
        echo "<p>You need to enter a password!<p>\n";
        //$body .= "<p>You need to enter a password.</p>\n";
    }
    else {
        $password = stripslashes($_POST['password']);
        
    }
    if (empty($_POST['password2'])) {
        ++$errors;
        //$body .= "<p>You need to enter a confirmation password.</p>\n";
          //If no password entered 
        echo "<p>You need to enter a confirmation password!<p>\n"; 
    }
    else {
        $password2 = stripslashes($_POST['password2']);
    }
    if (!empty($password) && !empty($password2)) {
        if (strlen($password) < 7) {
            ++$errors;
            //$body .= "<p>The password is too short.</p>\n";
            echo "<p>The password is too short!<p>\n"; 
            $password = "";
            $password2 = "";
        }
        if ($password <> $password2) {
            ++$errors;
            //$body .= "<p>The passwords do not match.</p>\n";
            echo "<p>The passwords do not match!<p>\n";
            $password = "";
            $password2 = "";
        }
    }

$hostname = "localhost"; 
    $username = "adminer"; 
    $passwd = "after-water-49"; 
    $DBConnect = false; 
    $DBName = "conference2"; 
    if ($errors == 0) { 
        //Only do a connection if generated no errors in validation 
        $DBConnect = mysqli_connect($hostname, $username, $passwd); 
        if (!$DBConnect) { 
            ++$errors; 
            echo "<p>Unable to connect to the database server" . 
                " error code: " . mysqli_connect_error() . "</p>\n"; 
        } 
        else { 
            $result =  mysqli_select_db($DBConnect, $DBName); 
            if (!$result) { 
                ++$errors; 
                echo "<p>Unable to select the database" . 
                " \"$DBName\" error code: " .  
                mysqli_error($DBConnect) . "</p>\n"; 
            } 
        } 
    } 
    $TableName = "profconf"; 
    //See if already have email in database 
    if ($errors == 0) { 
        $SQLstring = "SELECT count(*) FROM $TableName" .  
            " WHERE email='$email'"; 
        $queryResult = mysqli_query($DBConnect, $SQLstring); 
        if ($queryResult) { 
            $row = mysqli_fetch_row($queryResult); 
            //If primary key greater than 0 = good 
            if ($row[0] > 0) { 
                ++$errors; 
                echo "<p>The email address entered (" . 
                    htmlentities($email) . ") is already registered.</p>\n"; 
            } 
        } 
    } 
    if ($errors == 0) { 
        $first = stripslashes($_POST['first']); 
        $last = stripslashes($_POST['last']); 
        $SQLstring = "INSERT INTO $TableName" . 
            " (first, last, email, password_md5)" . 
            " VALUES('$first', '$last', '$email', '" . 
            md5($password) . "')"; 
        $queryResult = mysqli_query($DBConnect, $SQLstring); 
        if (!$queryResult) { 
             ++$errors; 
            echo "<p>Unable to save your registration" . 
            " information error code: " .  
            mysqli_error($DBConnect) . "</p>\n"; 
        } 
        else { 
            $conferenceID = mysqli_insert_id($DBConnect); 
        } 
    } 
    if ($errors == 0) { 
        $registeredName = $first . " " . $last; 
        echo "<p>Thank You, $registeredName. "; 
        echo "Your new Conference ID is <strong>" .  
            $conferenceID . "</strong>.</p>\n"; 
        echo "<p>Closing database connection.</p>\n"; 
        mysqli_close($DBConnect); 
    } 
    //Errors 
    if ($errors > 0) { 
        echo "<p>Please use your browser's BACK button" .  
            " to return to the form and fix the errors" . 
            " indicated.</p>\n"; 
    } 
//    $hostname = "localhost";
//    $username = "adminer";
//    $passwd = "after-water-49";
//    $DBConnect = false;
//    $DBName = "conferences2";
//    if ($errors == 0) {
//        $DBConnect = mysqli_connect($hostname, $username,
//        $passwd);
//        if (!$DBConnect) {
//            ++$errors;
//            $body .= "<p>Unable to connect to the database server" .
//                " error code: " . mysqli_connect_error() . 
//                "</p>\n";
//        }
//        else {
//            $result = mysqli_select_db($DBConnect, $DBName);
//            if (!$result) {
//            ++$errors;
//            $body .= "<p>Unable to select the database" .
//                " \"$DBName\" error code: " . 
//                mysqli_error($DBConnect) . 
//                "</p>\n";               
//            }
//        }
//    }
//    $TableName = "profconf";
//    if ($errors == 0) {
//        $SQLstring = "SELECT count(*) FROM $TableName" . 
//            " WHERE email='$email'";
//        $queryResult = mysqli_query($DBConnect, $SQLstring);
//        if ($queryResult) {
//            $row = mysqli_fetch_row($queryResult);
//            if ($row[0] > 0) {
//                ++$errors;
//                $body .= "<p>The email address entered (" .
//                    htmlentities($email) . ") is already registered
//                    </p>\n";     
//            }
//        }
//    }
//    if ($errors == 0) {
//        $first = stripslashes($_POST['first']);
//        $last = stripslashes($_POST['last']);
//        $SQLstring = "INSERT INTO $TableName" . 
//            " (first, last, email, password_md5)" .
//            " VALUES('$first', '$last', '$email', '" .
//            md5($password) . "')";
//        $queryResult = mysqli_query($DBConnect, $SQLstring);
//        if (!$queryResult) {
//            ++$errors;
//            $body .= "<p>Unable to save your registration" .
//                " information error code: " . 
//                mysqli_error($DBConnect) . "</p>\n";  
//        }
//        else {
//            $conferenceID = mysqli_insert_id($DBConnect);
//            //$_SESSION['conferenceID'] = mysqli_insert_id($DBConnect);
//        }
//    }
//    if ($errors == 0) {
//        $registeredName = $first . " " . $last;
//        $body .= "<p>Thank you, $registeredName. ";
//        $body .= "Your new Conference ID is <strong>" .
//            $_SESSION['conferenceID'] . "</strong>.</p>\n";
//    }
//    if ($DBConnect) {
//        setcookie("conferenceID", $_SESSION['conferenceID']);
//        $body .= "<p>Closing database connection.</p>\n";
//        mysqli_close($DBConnect);     
//    }
//    if ($errors == 0) {
//        $body .= "<form action='AvailableSeminars.php'" . 
//        " method='post'>\n";
//        $body .= "<input type='hidden' name='conferenceID' 
//        value='$conferenceID'>\n";
//        $body .= "<input type='submit' name='submit' 
//        value='View Available Seminars'>\n";
//        $body .= "</form>\n";
////        $body .= "<p><a href='AvailableSeminars.php?" .
////            "PHPSESSID=" . session_id() . "'>" . 
////            "View Available Seminars</a></p>\n"; 
//    }
//    if ($errors > 0) {
//        $body .= "<p>Please use your browser's BACK button" . 
//            " to return to the form and fix the errors" .
//            " indicated.</p>\n";
//    }
?>
<!doctype html>
<html>

<head>
<!--   
         Exercise 02_09_05
         Author: Tabitha Siclovan
         Date: December 04, 2018
        
         RegisterConference.php
    -->
    <title>Register Conference</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="inital-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body style="text-align:center;background-color:rgb(219, 224, 246)">
    <h1>Professional Conference</h1>
    <hr>
    <h2>Conference Registration</h2>
    <?php
    //echo $body;
    ?>
      <form action="AvailableSeminars.php?PHPSESSID=<?php echo session_id(); ?>" method="post">
       <h2>Fill in Your Company Information</h2>
        <p>
            Company Name:
            <input type="text" name="text">
        </p>
        <p>
            Company Email:
            <input type="text" name="email">
        </p>
        <p>
            Company Phone Number:
            <input type="tel" name="phoneNumber">
        </p>
        <input type="reset" name="reset" value="Reset Login Form">
            <input type="submit" name="login" value="Log In">
    </form> 
</body>

</html>