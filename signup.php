<?php session_start()?>

<!DOCTYPE html>
<html>
<body>

<?php
//DB creds and connection to DB
require 'dbInclude.php';
//Header code
include 'headerInclude.php';
?>

<div class="sign__up">
    <h1> Sign Up!</h1>
    <form action="signupAction.php" method="post">
        <input type="text" name="uid" placeholder="Enter your Username"><br>
        <input type="text" name="email" placeholder="Enter your Email"><br>
        <input type="text" name="fnid" placeholder="Enter your First Name"><br>
        <input type="text" name="lnid" placeholder="Enter your Last Name"><br>
        <input type="password" name="pwd" placeholder="Enter your Password"><br>
        <input type="password" name="pwd-check" placeholder="Re-enter your Password"><br>
        <button type="submit" name="signupBtn">Sign Up</button>
    </form>
</div>

</body>
</html>