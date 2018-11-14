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
    ?>
</body>

</html>
