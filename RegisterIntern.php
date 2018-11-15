<!doctype html>

<html>

<head>
   <!--   
         Exercise 02_09_01
         Author: Tabitha Siclovan
         Date: November 13, 2018
        
         RegisterIntern.php
    -->
    <title>Internship Registration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>College Internship</h1>
    <h2>Intern Registration</h2>
    <?php
    //Variable to count the errors
    $errors = 0;
    //Email Variable starts out empty
    $email = "";
    //If the email field is empty
    if (empty($_POST['email'])) {
        ++$errors;
        //Give error with following echo
        echo "<p>You need to enter an email address!</p>\n";
    }
    else {
        $email = stripslashes($_POST['email']);
        //Use regex to validate email address
        if (preg_match("/^[\w-]+(\.[\w-])*@[\w-]+(\.[\w-]+)*(\.[A-Za-z]{2,})$/i", $email) == 0) {
            //Increment errors
            ++$errors;
            //If email not in correct format
            echo "<p>You need to enter a valid email address!</p>\n";
            //Returns empty because no errors is email correct
            $email = "";
        }
    }
    //Failure: does not have a password
    if (empty($_POST['password'])) {
        //Increment errors
        ++$errors;
        //If no password entered
        echo "<p>You need to enter a password!<p>\n";
    }
    //If email not empty
    else {
        $password = stripslashes($_POST['password']);
    }
     //Failure: does not have a password
    if (empty($_POST['password2'])) {
        //Increment errors
        ++$errors;
        //If no password entered
        echo "<p>You need to enter a confirmation password!<p>\n";
    }
    //If email not empty
    else {
        $password2 = stripslashes($_POST['password2']);
    }
    
    if (!empty($password) && !empty($password2)) {
        if (strlen($password) < 6) {
            //Increment errors
            ++$errors;
            //If no password entered
            echo "<p>The password is too short!<p>\n";
            $password = "";
            $password2 = "";
        }
         if ($password <> $password2) {
            //Increment errors
            ++$errors;
            //If no password entered
            echo "<p>The passwords do not match!<p>\n";
            $password = "";
            $password2 = "";
        }
    }
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "after-water-49";
    $DBConnect = false;
    $DBName = "internships2";
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
    $TableName = "interns";
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
            $internID = mysqli_insert_id($DBConnect);
        }
    }
    if ($errors == 0) {
        $internName = $first . " " . $last;
        echo "<p>Thank You, $internName. ";
        echo "Your new Intern ID is <strong>" . 
            $internID . "</strong>.</p>\n";
        echo "<p>Closing database connection.</p>\n";
        mysqli_close($DBConnect);
    }
    //Errors
    if ($errors > 0) {
        echo "<p>Please use your browser's BACK button" . 
            " to return to the form and fix the errors" .
            " indicated.</p>\n";
    }
    ?>
</body>

</html>
