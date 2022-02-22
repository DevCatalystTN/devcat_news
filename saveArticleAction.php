<?php
//DB creds and connection to DB
require 'dbInclude.php';

//pulls the values used in the signup form from the signup page
$user = $_GET['uid'];
$article = $_GET['aid'];

//the actual creation of the row

        $sql = "INSERT INTO news_saved( user_ID, article_ID) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){//if the sql doesn't run, return to the previous page with an error
            header("Location: article.php?error=sqlerror{$_GET['aid']}");
            exit();
        }
        else{//hash the password for security, and bind parameters to strings for DB entry
            mysqli_stmt_bind_param($stmt, "ii", $user, $article);
            mysqli_stmt_execute($stmt);
            header("Location: article.php?save=success&aid={$_GET['aid']}");
            exit();
        }

//close the sql server 
mysqli_stmt_close($stmt);
mysqli_close($conn);

