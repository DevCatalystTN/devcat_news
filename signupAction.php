<?php
//ensures that you can only get to this file through the signupBtn button
if(isset($_POST['signupBtn'])){
    //DB Creds
    $servername = "localhost:3306";
    $username = "theco_mpinkley";
    $password = "devcat123";
    $dbname = "theco_mpinkley";

    //creates connection to DB
    $conn = new mysqli($servername, $username, $password, $dbname);// Check connection
    if ($conn->connect_error) {
        die("Connection failed: {$conn->connect_error}");
    }

    //pulls the values from the form on signup.php and stores them in variables
    $user = $_POST['uid'];
    $email = $_POST['email'];
    $user_password = $_POST['pwd'];
    $pass_check = $_POST['pwd-check'];
    $fname = $_POST['fnid'];
    $lname = $_POST['lnid'];


    //checks to makesure all the values are filled and not a hacker's attempt to destroy the database
    if(empty($user) || empty($email) || empty($user_password) || empty($pass_check || empty($fname) || empty($lname))){
        header("Location: signup.php?error=fieldsempty&uid={$user}&email={$email}&fnid={$fname}&lnid={$lname}");
        exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $user)){
        header("Location: signup.php?error=invalidemailandusername&fnid={$fname}&lnid={$lname}");
        exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: signup.php?error=invalidemail&uid={$user}&fnid={$fname}&lnid={$lname}");
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $user)){
        header("Location: signup.php?error=invalidusername&email={$email}&fnid={$fname}&lnid={$lname}");
        exit();
    }
    elseif($user_password !== $pass_check){
        header("Location: signup.php?error=invalidpasscheck&uid={$user}&mail={$email}&fnid={$fname}&lnid={$lname}");
        exit();
    }
    //the actual creation of the user
    else{
        //sql statement to check for pre-existing usernames with the same value
        $sql = "SELECT users_username FROM news_users WHERE users_username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: signup.php?error=sqlerror");
            exit(); 
        }
        //proceeds if no such user existed
        else{
            //ensures that the value used by the user is read as a string value in case they used sql keywords
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultcheck = mysqli_stmt_num_rows($stmt);
            //if a user existed, return to page with errors
            if($resultcheck > 0){
                header("Location: signup.php?error=usernametaken&email={$email}");
                exit();
            }
            //if no user existed, insert into the database
            else{
                //override $sql with new query
                $sql = "INSERT INTO news_users(users_username, users_password, users_email, user_FName, user_LName) 
                VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                //if the sql doesn't run, return to the previous page with an error
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: signup.php?error=sqlerror");
                    exit();
                }
                //hash the password for security, and bind parameters to strings for DB entry
                else{
                    $hashed = password_hash($user_password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sssss", $user, $hashed, $email, $fname, $lname);
                    mysqli_stmt_execute($stmt);
                    header("Location: index.php?signup=success");
                    exit();
                }
            }
        }
    }
    //close the sql server 
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
//return to last page with success message
else{
    header("Location: signup.php");
    exit();
}