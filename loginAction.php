<?php
//DB creds and connection to DB
require 'dbInclude.php';

//ensures access to page only through the loginAction button
if(isset($_POST['loginAction'])){
    //pulls the values from the form and stores them as variables
    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];

    //ensures there were values in the login form
    if(empty($mailuid) || empty($password)){
        header("Location: index.php?error=mailandpwdempty");
        exit();
    //if there were values to read in both username and password
    } else{
        //sql statement to check whether the username or email matches the value entered in the username field
        $sql = "SELECT * FROM news_users WHERE users_username = ? OR users_email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: index.php?error=sqlerror");
            exit();
        } else{
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt);
            //checks if the password matches the hashed value
            if($row = mysqli_fetch_assoc($results)){
                $pwdCheck = password_verify($password, $row['users_password']);
                if($pwdCheck == false){
                    header("Location: index.php?error=wrongpwd");
                    exit(); 
                } else if($pwdCheck == true){//if the password matches, start a session, and set some values
                    session_start();
                    $_SESSION['userID'] = $row['users_ID'];
                    $_SESSION['userUID'] = $row['users_username'];
                    $_SESSION['user_privledges'] = $row['users_admin'];

                    header("Location: index.php?login=success");
                    exit(); 
                } else{
                    header("Location: index.php?error=sqlerror");
                    exit(); 
                }
            } else{
                header("Location: index.php?error=wronguser");
                exit();
            }
        }
 
    }
} else{//send users back with a login success message
    header("Location: index.php");
    exit();
}