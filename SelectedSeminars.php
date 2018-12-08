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
         Date: December 06, 2018
        
         SelectedSeminars.php
    -->
    <title>Professional Conference</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <h1>Professional Conference</h1>
    <h2>Selected Seminars</h2>
   <?php
   echo "<p><em>Your First Selected Seminar:</em></p>";
   echo $_POST['option1'];
   echo "<p><em>Your Second Selected Seminar:</em></p>";
   echo $_POST['option2'];
   echo "<p><em>Your Third Selected Seminar:</em></p>\n";
   echo $_POST['option3'];
   echo "<p><strong>Use the back arrow to make any changes.</strong></p>";
   echo "<p>Click <a href='SubmittedData.php'>Here</a> to review information.</p>";
   echo "<p><a href='Index2.php'>Log Out</a></p>\n";
   ?>
</body>

</html>
