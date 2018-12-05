<?php
session_start();
echo "Session ID: " . session_id() . "<br>\n";
?>
<!doctype html>

<html>

<head>
    <!--   
         Exercise 02_09_05
         Author: Tabitha Siclovan
         Date: December 04, 2018
        
         Index2.php
    -->
    <title>Professional Conference</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>Professional Conference</h1>
    <h2>Register / Login</h2>
    <p>New professionals, please complete the top form to register as a user. 
    Returning users, please complete the second form to login.</p>
    
    <h3>New Conference Registration</h3>
    <form action="RegisterConference.php?PHPSESSID=<?php echo session_id(); ?>" method="post">
        <p>Enter Your Name: First
            <input type="text" name="first">
            Last 
            <input type="text" name="last">
        </p>
        <p>
            Enter Your Email Address:
            <input type="text" name="email">
        </p>
        <p>
            Enter a password for your account:
            <input type="password" name="password">
        </p>
         <p>
            Confirm Your Password:
            <input type="password" name="password2">
        </p>
        <p>
            <em>(Passwords are case sensitive and must be at least 7 characters long)</em>
        </p>
        <input type="reset" name="reset" value="Reset Registration Form">
            <input type="submit" name="register" value="Register">
    </form>
    
    <h3>Returning Conference Login</h3>
    <form action="ConferenceLogin.php?PHPSESSID=<?php echo session_id(); ?>" method="post">
        <p>
            Enter Your Email Address:
            <input type="text" name="email">
        </p>
        <p>
            Enter Your Password:
            <input type="password" name="password">
        </p>
        <p>
            <em>(Passwords are case sensitive and must be at least 7 characters long)</em>
        </p>
        <input type="reset" name="reset" value="Reset Login Form">
            <input type="submit" name="login" value="Log In">
    </form>
</body>

</html>
